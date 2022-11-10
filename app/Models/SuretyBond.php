<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InsuranceRate;
use App\Models\AgentRate;
use App\Models\Status;
use App\Models\Scoring;
use App\Models\ScoringDetail;
use DB;

class SuretyBond extends Model
{
    use HasFactory;

    public $fillable = [
        'receipt_number',
        'bond_number',
        'polish_number',
        'project_name',
        'start_date',
        'end_date',
        'day_count',
        'due_day_tolerance',
        'document_number',
        'document_title',
        'document_expired_at',
        'contract_value',
        'insurance_value',
        'service_charge',
        'admin_charge',
        'total_charge',
        'profit',
        'insurance_polish_cost',
        'insurance_stamp_cost',
        'insurance_total_net',
        'office_polish_cost',
        'office_stamp_cost',
        'office_total_net',
        'principal_id',
        'agent_id',
        'obligee_id',
        'insurance_id',
        'insurance_type_id',
        'revision_from_id',
        'score'
    ];
    public function principal(){
        return $this->belongsTo(Principal::class);
    }
    public function agent(){
        return $this->belongsTo(Agent::class);
    }
    public function obligee(){
        return $this->belongsTo(Obligee::class);
    }
    public function insurance(){
        return $this->belongsTo(Insurance::class);
    }
    public function insurance_type(){
        return $this->belongsTo(InsuranceType::class);
    }
    public function revision_from(){
        return $this->belongsTo(SuretyBond::class,'revision_from_id');
    }
    public function statuses(){
        return $this->hasMany(SuretyBondStatus::class);
    }
    public function scorings(){
        return $this->hasMany(SuretyBondScore::class);
    }
    public function last_status(){
        return $this->hasOne(SuretyBondStatus::class)->ofMany('id', 'max');
    }
    public function process_status(){
        return $this->hasOne(SuretyBondStatus::class)->ofMany(['id' => 'max'], function($query){$query->where('type','process'); });
    }
    public function finance_status(){
        return $this->hasOne(SuretyBondStatus::class)->ofMany(['id' => 'max'], function($query){$query->where('type','finance'); });
    }
    public function insurance_status(){
        return $this->hasOne(SuretyBondStatus::class)->ofMany(['id' => 'max'], function($query){$query->where('type','insurance'); });
    }
    private static function fetch(object $args): object{
        $insuranceRate = InsuranceRate::where([['insurance_id',$args->insuranceId],['insurance_type_id',$args->insuranceTypeId]])->firstOrFail();
        $agentRate = AgentRate::where([['insurance_id',$args->insuranceId],['insurance_type_id',$args->insuranceTypeId],['agent_id',$args->agentId],['bank_id',null]])->firstOrFail();
        $scoring = array_map(function($key,$value){
            return [
                'scoring_id' => $key,
                'scoring_detail_id' => $value,
                'category' => Scoring::findOrFail($key)->category,
                'value' => ScoringDetail::findOrFail($value)->value
            ];
        },array_keys($args->scoring),array_values($args->scoring));
        $totalScore = array_sum(array_column($scoring, 'value'));
        $insuranceTotalNet = ((int)$args->insuranceValue * $insuranceRate->rate_value / (((int)$args->dayCount > 90) ? 90 : 1)) + $insuranceRate->polish_cost + $insuranceRate->stamp_cost;
        $officeTotalNet = ((int)$args->insuranceValue * $agentRate->rate_value / (((int)$args->dayCount > 90) ? 90 : 1)) + $agentRate->polish_cost + $agentRate->stamp_cost;
        return (object)[
            'suretyBond' => [
                'receipt_number' => $args->receiptNumber,
                'bond_number' => $args->bondNumber,
                'polish_number' => $args->polishNumber,
                'project_name' => $args->projectName,
                'start_date' => $args->startDate,
                'end_date' => $args->endDate,
                'day_count' => $args->dayCount,
                'due_day_tolerance' => $args->dueDayTolerance,
                'document_number' => $args->documentTitle,
                'document_title' => $args->documentNumber,
                'document_expired_at' => $args->documentExpiredAt,
                'contract_value' => $args->contractValue,
                'insurance_value' => $args->insuranceValue,
                'service_charge' => $args->serviceCharge,
                'admin_charge' => $args->adminCharge,
                'total_charge' => $args->serviceCharge + $args->adminCharge,
                'profit' => $officeTotalNet - $insuranceTotalNet,
                'insurance_polish_cost' => $insuranceRate->polish_cost,
                'insurance_stamp_cost' => $insuranceRate->stamp_cost,
                'insurance_total_net' => $insuranceTotalNet,
                'office_polish_cost' => $agentRate->polish_cost,
                'office_stamp_cost' => $agentRate->stamp_cost,
                'office_total_net' => $officeTotalNet,
                'principal_id' => $args->principalId,
                'agent_id' => $args->agentId,
                'obligee_id' => $args->obligeeId,
                'insurance_id' => $args->insuranceId,
                'insurance_type_id' => $args->insuranceTypeId,
                'score' => $totalScore
            ],
            'scoring' => $scoring
        ];
    }
    private static function fetchStatus(object $args): array{
        $params = [];
        $type = $args->type;
        $status = $args->status;
        if($type == 'process'){
            if($status == 'input'){
                $params = [
                    ['type' => $type,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id],
                    ['type' => 'finance','status_id' => Status::where([['type','finance'],['name','belum lunas']])->firstOrFail()->id],
                    ['type' => 'insurance','status_id' => Status::where([['type','insurance'],['name','belum terbit']])->firstOrFail()->id]
                ];
            }else if($status == 'terbit'){
                $params = [
                    ['type' => $type,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id],
                    ['type' => 'insurance','status_id' => Status::where([['type','insurance'],['name',$status]])->firstOrFail()->id]
                ];
            }else{
                $params = [
                    ['type' => $type,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id]
                ];
            }
        }else if($type == 'insurance' || $type == 'finance'){
            $params = [
                ['type' => $type,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id]
            ];
        }
        return $params;
    }
    public static function buat(array $params): self{
        $request = self::fetch((object)$params);
        $suretyBond = self::create($request->suretyBond);
        $suretyBond->ubahStatus(['type' => 'process','status' => 'input']);
        $suretyBond->scorings()->createMany($request->scoring);
        return $suretyBond;
    }
    public function ubah(array $params): bool{
        $request = self::fetch((object)$params);
        foreach ($request->scoring as $score) {
            $this->scorings()->where('scoring_id',$score['scoring_id'])->update($score);
        }
        return $this->update($request->suretyBond);
    }
    public function ubahStatus(array $params){
        return $this->statuses()->createMany(self::fetchStatus((object)$params));
    }
    public function hapus(){
        $this->statuses()->delete();
        $this->scorings()->delete();
        return $this->delete();
    }

    private static function fetchReport(object $args): object{
        $columns = [
            'startDate' => 'sb.created_at',
            'endDate' => 'sb.created_at',
            1 => 'sb.receipt_number',
            2 => 'sb.bond_number',
            3 => 'sb.polish_number',
            4 => 'sb.insurance_value',
        ];
        $params = [];
        if(isset($args->params)){
            foreach ($args->params as $key => $param) {
                if(!in_array($key,['startDate','endDate'])){
                    if(isset($columns[$param['name']])){
                        $params[] = (object)[
                            'column' => $columns[$param['name']],
                            'operator' => $param['operator'],
                            'value' => $param['value']
                        ];
                    }
                }else{
                    $operator = '';
                    if($key == 'startDate'){
                        $operator = '>=';
                    }else if($key == 'endDate'){
                        $operator = '<=';
                    }
                    $params[] = (object)[
                        'column' => $columns[$key],
                        'operator' => $operator,
                        'value' => $param
                    ];
                }
            }
        }
        return (object)$params;
    }

    public static function report(array $params){
        $params = self::fetchReport((object)$params);
        $query = DB::table('surety_bonds as sb')->select('sb.id','sb.created_at as date','sb.receipt_number','sb.bond_number','sb.polish_number','sb.total_charge as nominal')
        ->join('principals as p','p.id','sb.principal_id')
        ->join('agents as a','a.id','sb.agent_id')
        ->join('obligees as o','o.id','sb.obligee_id')
        ->join('insurances as i','i.id','sb.insurance_id')
        ->join('insurance_types as it','it.id','sb.insurance_type_id');
        // dd($params);
        foreach ($params as $param) {
            if(in_array($param->column,['sb.created_at'])){
                // dd($param);
                // $query->when(isset($params->column),function($sub) use ($param){
                    $query->whereDate($param->column,$param->operator,$param->value);
                // });
            }else{
                $query->where($param->column,$param->operator,$param->value);

            }
        }
        // ->when(isset($params->receipt_number),function($query) use ($params){
        //     $query->where('sb.receipt_number',$params->receipt_number->operator,$params->receipt_number->value);
        // })
        // ->when(isset($params->bond_number),function($query) use ($params){
        //     $query->where('sb.bond_number',$params->bond_number->operator,$params->bond_number->value);
        // })
        // ->when(isset($params->polish_number),function($query) use ($params){
        //     $query->where('sb.polish_number',$params->polish_number->operator,$params->polish_number->value);
        // })
        // ->when(isset($params->project_name),function($query) use ($params){
        //     $query->where('sb.project_name',$params->project_name->operator,$params->project_name->value);
        // })
        // ->when(isset($params->start_date),function($query) use ($params){
        //     $query->whereDate('sb.start_date',$params->start_date->operator,$params->start_date->value);
        // })
        // ->when(isset($params->end_date),function($query) use ($params){
        //     $query->whereDate('sb.end_date',$params->end_date->operator,$params->end_date->value);
        // })
        // ->when(isset($params->day_count),function($query) use ($params){
        //     $query->where('sb.day_count',$params->day_count->operator,$params->day_count->value);
        // })
        // ->when(isset($params->due_day_tolerance),function($query) use ($params){
        //     $query->where('sb.due_day_tolerance',$params->due_day_tolerance->operator,$params->due_day_tolerance->value);
        // })
        // ->when(isset($params->document_number),function($query) use ($params){
        //     $query->where('sb.document_number',$params->document_number->operator,$params->document_number->value);
        // })
        // ->when(isset($params->document_title),function($query) use ($params){
        //     $query->where('sb.document_title',$params->document_title->operator,$params->document_title->value);
        // })
        // ->when(isset($params->document_expired_at),function($query) use ($params){
        //     $query->whereDate('sb.document_expired_at',$params->document_expired_at->operator,$params->document_expired_at->value);
        // })
        // ->when(isset($params->contract_value),function($query) use ($params){
        //     $query->where('sb.contract_value',$params->contract_value->operator,$params->contract_value->value);
        // })
        // ->when(isset($params->insurance_value),function($query) use ($params){
        //     $query->where('sb.insurance_value',$params->insurance_value->operator,$params->insurance_value->value);
        // })
        // ->when(isset($params->service_charge),function($query) use ($params){
        //     $query->where('sb.service_charge',$params->service_charge->operator,$params->service_charge->value);
        // })
        // ->when(isset($params->admin_charge),function($query) use ($params){
        //     $query->where('sb.admin_charge',$params->admin_charge->operator,$params->admin_charge->value);
        // })
        // ->when(isset($params->total_charge),function($query) use ($params){
        //     $query->where('sb.total_charge',$params->total_charge->operator,$params->total_charge->value);
        // })
        // ->when(isset($params->profit),function($query) use ($params){
        //     $query->where('sb.profit',$params->profit->operator,$params->profit->value);
        // })
        // ->when(isset($params->insurance_polish_cost),function($query) use ($params){
        //     $query->where('sb.insurance_polish_cost',$params->insurance_polish_cost->operator,$params->insurance_polish_cost->value);
        // })
        // ->when(isset($params->insurance_stamp_cost),function($query) use ($params){
        //     $query->where('sb.insurance_stamp_cost',$params->insurance_stamp_cost->operator,$params->insurance_stamp_cost->value);
        // })
        // ->when(isset($params->insurance_total_net),function($query) use ($params){
        //     $query->where('sb.insurance_total_net',$params->insurance_total_net->operator,$params->insurance_total_net->value);
        // })
        // ->when(isset($params->office_polish_cost),function($query) use ($params){
        //     $query->where('sb.office_polish_cost',$params->office_polish_cost->operator,$params->office_polish_cost->value);
        // })
        // ->when(isset($params->office_total_net),function($query) use ($params){
        //     $query->where('sb.office_total_net',$params->office_total_net->operator,$params->office_total_net->value);
        // })
        // ->when(isset($params->score),function($query) use ($params){
        //     $query->where('sb.score',$params->score->operator,$params->score->value);
        // })
        // ->when(isset($params->agent),function($query) use ($params){
        //     $query->where('a.name',$params->agent->operator,$params->agent->value);
        // })
        // ->when(isset($params->agent),function($query) use ($params){
        //     $query->where('a.name',$params->agent->operator,$params->agent->value);
        // })
        // ->when(isset($params->obligee),function($query) use ($params){
        //     $query->where('a.name',$params->obligee->operator,$params->obligee->value);
        // })
        // ->when(isset($params->insurance),function($query) use ($params){
        //     $query->where('a.name',$params->insurance->operator,$params->insurance->value);
        // })
        // ->when(isset($params->insurance_type),function($query) use ($params){
        //     $query->where('a.name',$params->insurance_type->operator,$params->insurance_type->value);
        // });
        // ->when(isset($params->period) && isset($params->period->start),function($query) use ($params){
        //     $query->whereDate('created_at',$params->period->operator,$params->period->start);
        // })
        // ->when(isset($params->period) && isset($params->period->end),function($query) use ($params){
        //     $query->whereDate('created_at',$params->period->operator,$params->period->end);
        // });
        return $query;
    }
}
