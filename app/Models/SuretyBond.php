<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InsuranceRate;
use App\Models\AgentRate;
use App\Models\Status;
use App\Models\Scoring;
use App\Models\ScoringDetail;
use App\Helpers\Sirius;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'insurance_rate',
        'insurance_net',
        'insurance_net_total',
        'office_polish_cost',
        'office_stamp_cost',
        'office_rate',
        'office_net',
        'office_net_total',
        'branch_id',
        'principal_id',
        'agent_id',
        'obligee_id',
        'insurance_id',
        'insurance_type_id',
        'revision_from_id',
        'score'
    ];

    protected $appends = [
        'service_charge_converted',
        'admin_charge_converted',
        'total_charge_converted',
        'contract_value_converted',
        'start_date_converted',
        'end_date_converted',
        'document_expired_at_converted',
        'insurance_stamp_cost_converted',
        'insurance_polish_cost_converted',
        'insurance_net_converted',
        'insurance_net_total_converted',
        'office_stamp_cost_converted',
        'office_polish_cost_converted',
        'office_net_converted',
        'office_net_total_converted',
        'profit_converted',
    ];

    // Accessors
    public function serviceChargeConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->service_charge));
    }
    public function adminChargeConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->admin_charge));
    }
    public function totalChargeConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->total_charge));
    }
    public function contractValueConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->contract_value));
    }
    public function insurancePolishCostConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->insurance_polish_cost));
    }
    public function insuranceStampCostConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->insurance_stamp_cost));
    }
    public function insuranceValueConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->insurance_value));
    }
    public function insuranceNetConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->insurance_net));
    }
    public function insuranceNetTotalConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->insurance_net_total));
    }
    public function officePolishCostConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->office_polish_cost));
    }
    public function officeStampCostConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->office_stamp_cost));
    }
    public function officeNetConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->office_net));
    }
    public function officeNetTotalConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->office_net_total));
    }
    public function profitConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toRupiah($this->profit));
    }
    public function startDateConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toLongDate($this->start_date));
    }
    public function endDateConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toLongDate($this->end_date));
    }
    public function documentExpiredAtConverted(): Attribute
    {
        return Attribute::make(get: fn () => Sirius::toLongDate($this->document_expired_at));
    }

    // Relations
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
        $insuranceNet = ((int)$args->insuranceValue * $insuranceRate->rate_value / (((int)$args->dayCount > 90) ? 90 : 1));
        $officeNet = ((int)$args->insuranceValue * $agentRate->rate_value / (((int)$args->dayCount > 90) ? 90 : 1));

        $insuranceNet = $insuranceNet >= $insuranceRate->min_value ? $insuranceNet : $insuranceRate->min_value;
        $officeNet = $officeNet >= $agentRate->min_value ? $officeNet : $agentRate->min_value;

        $insuranceNetTotal = $insuranceNet + $insuranceRate->polish_cost + $insuranceRate->rate_value;
        $officeNetTotal = $officeNet + $agentRate->polish_cost + $agentRate->stamp_cost;
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
                'profit' => $officeNetTotal - $insuranceNetTotal,
                'insurance_polish_cost' => $insuranceRate->polish_cost,
                'insurance_stamp_cost' =>  $insuranceRate->stamp_cost,
                'insurance_rate' => $insuranceRate->rate_value,
                'insurance_net' => $insuranceNet,
                'insurance_net_total' => $insuranceNetTotal,
                'office_polish_cost' => $agentRate->polish_cost,
                'office_stamp_cost' => $agentRate->stamp_cost,
                'office_rate' => $agentRate->rate_value,
                'office_net' => $officeNet,
                'office_net_total' => $officeNetTotal,
                'branch_id' => $args->branchId,
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
        try{
            $this->statuses()->delete();
            $this->scorings()->delete();
            return $this->delete();
        } catch (Exception $ex) {
            throw new Exception("Data ini tidak dapat dihapus karena sedang digunakan data lain", 422);
        }
    }

    private static function fetchQuery(object $args): object{
        $columns = [
            'startDate' => 'sb.created_at',
            'endDate' => 'sb.created_at',
            1 => 'sb.receipt_number',
            2 => 'sb.bond_number',
            3 => 'sb.polish_number',
            4 => 'sb.insurance_value',
        ];
        $params = [];
        if(isset($args->request_for)) unset($args->request_for);
        foreach ($args as $key => $param) {
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
        return (object)$params;
    }

    private static function kueri(array $params){
        $params = self::fetchQuery((object)$params);
        $query = DB::table('surety_bonds as sb')
        ->join('principals as p','p.id','sb.principal_id')
        ->join('agents as a','a.id','sb.agent_id')
        ->join('obligees as o','o.id','sb.obligee_id')
        ->join('insurances as i','i.id','sb.insurance_id')
        ->join('insurance_types as it','it.id','sb.insurance_type_id');
        foreach ($params as $param) {
            if(in_array($param->column,['sb.created_at'])){
                $query->whereDate($param->column,$param->operator,$param->value);
            }else{
                $query->where($param->column,$param->operator,$param->value);
            }
        }
        return $query;
    }
    public static function table(string $type,array $params){
        if($type == 'income'){
            return self::kueri($params)->select('sb.id','sb.created_at as date','sb.receipt_number','sb.bond_number','sb.polish_number','sb.total_charge as nominal');
        }else if($type == 'expense'){
            return self::kueri($params)->select('sb.id','sb.created_at as date','sb.receipt_number','sb.bond_number','sb.polish_number','sb.insurance_total_net as nominal');
        }else if($type == 'product'){
            return self::kueri($params)->select('sb.id','sb.created_at as date','sb.receipt_number','sb.bond_number','sb.polish_number','sb.office_total_net as nominal');
        }else if($type == 'finance'){
            return self::kueri($params)->select('sb.id','sb.created_at as date','sb.receipt_number','sb.bond_number','sb.polish_number','sb.office_total_net as nominal');
        }
    }
    public static function chart(string $type,array $params){
        $data = [];
        if($type == 'income'){
            $data = self::kueri($params)->selectRaw("date(sb.created_at) as date, sum(sb.total_charge) as nominal")->groupBy(DB::raw("date(sb.created_at)"))->pluck('nominal','date')->toArray();
        }else if($type == 'expense'){
            $data = self::kueri($params)->selectRaw("date(sb.created_at) as date, sum(sb.insurance_total_net) as nominal")->groupBy(DB::raw("date(sb.created_at)"))->pluck('nominal','date')->toArray();
        }else if($type == 'product'){
            $data = self::kueri($params)->selectRaw("date(sb.created_at) as date, sum(sb.office_total_net) as nominal")->groupBy(DB::raw("date(sb.created_at)"))->pluck('nominal','date')->toArray();
        }else if($type == 'finance'){
            $data = self::kueri($params)->selectRaw("date(sb.created_at) as date, sum(sb.office_total_net) as nominal")->groupBy(DB::raw("date(sb.created_at)"))->pluck('nominal','date')->toArray();
        }
        return [
            'labels' => array_map(function($val){ return Sirius::toShortDate($val); },array_keys($data)),
            'datasets' => array_values($data),
        ];
    }
}
