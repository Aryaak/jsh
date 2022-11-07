<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BankRate;
use App\Models\ScoringDetail;
use App\Models\AgentRate;
use App\Models\Scoring;
use App\Models\Status;

class GuaranteeBank extends Model
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
        'bank_id',
        'principal_id',
        'agent_id',
        'obligee_id',
        'insurance_id',
        'insurance_type_id',
        'revision_from_id',
        'score',
        'revision_from_id'
    ];
    public function bank(){
        return $this->belongsTo(Bank::class);
    }
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
        return $this->belongsTo(GuaranteeBank::class,'revision_from_id');
    }
    public function statuses(){
        return $this->hasMany(GuaranteeBankStatus::class);
    }
    public function scorings(){
        return $this->hasMany(GuaranteeBankScore::class);
    }
    public function last_status(){
        return $this->hasOne(GuaranteeBankStatus::class)->ofMany('id', 'max');
    }
    public function process_status(){
        return $this->hasOne(GuaranteeBankStatus::class)->ofMany(['id' => 'max'], function($query){$query->where('type','process'); });
    }
    public function finance_status(){
        return $this->hasOne(GuaranteeBankStatus::class)->ofMany(['id' => 'max'], function($query){$query->where('type','finance'); });
    }
    public function insurance_status(){
        return $this->hasOne(GuaranteeBankStatus::class)->ofMany(['id' => 'max'], function($query){$query->where('type','insurance'); });
    }
    private static function fetch(object $args): object{
        $bankRate = BankRate::where([['bank_id',$args->bankId],['insurance_type_id',$args->insuranceTypeId],['insurance_id',$args->insuranceId]])->firstOrFail();
        $agentRate = AgentRate::where([['insurance_id',$args->insuranceId],['insurance_type_id',$args->insuranceTypeId],['agent_id',$args->agentId],['bank_id',$args->bankId]])->firstOrFail();
        $scoring = array_map(function($key,$value){
            return [
                'scoring_id' => $key,
                'scoring_detail_id' => $value,
                'category' => Scoring::findOrFail($key)->category,
                'value' => ScoringDetail::findOrFail($value)->value
            ];
        },array_keys($args->scoring),array_values($args->scoring));
        $totalScore = array_sum(array_column($scoring, 'value'));
        $insuranceTotalNet = ((int)$args->insuranceValue * $bankRate->rate_value / (((int)$args->dayCount > 90) ? 90 : 1)) + $bankRate->polish_cost + $bankRate->stamp_cost;
        $officeTotalNet = ((int)$args->insuranceValue * $agentRate->rate_value / (((int)$args->dayCount > 90) ? 90 : 1)) + $agentRate->polish_cost + $agentRate->stamp_cost;
        return (object)[
            'guaranteeBank' => [
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
                'insurance_polish_cost' => $bankRate->polish_cost,
                'insurance_stamp_cost' => $bankRate->stamp_cost,
                'insurance_total_net' => $insuranceTotalNet,
                'office_polish_cost' => $agentRate->polish_cost,
                'office_stamp_cost' => $agentRate->stamp_cost,
                'office_total_net' => $officeTotalNet,
                'principal_id' => $args->principalId,
                'bank_id' => $args->bankId,
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
        $guaranteeBank = self::create($request->guaranteeBank);
        $guaranteeBank->ubahStatus(['type' => 'process','status' => 'input']);
        $guaranteeBank->scorings()->createMany($request->scoring);
        return $guaranteeBank;
    }
    public function ubah(array $params): bool{
        $request = self::fetch((object)$params);
        foreach ($request->scoring as $score) {
            $this->scorings()->where('scoring_id',$score['scoring_id'])->update($score);
        }
        return $this->update($request->guaranteeBank);
    }
    public function ubahStatus(array $params){
        return $this->statuses()->createMany(self::fetchStatus((object)$params));
    }
    public function hapus(){
        $this->statuses()->delete();
        $this->scorings()->delete();
        return $this->delete();
    }
}
