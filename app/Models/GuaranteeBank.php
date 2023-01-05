<?php

namespace App\Models;

use DB;
use Exception;
use App\Models\Status;
use App\Helpers\Sirius;
use App\Models\Scoring;
use App\Models\Payment;
use App\Models\BankRate;
use App\Models\AgentRate;
use App\Models\GuaranteeBankStatus;
use Illuminate\Support\Str;
use App\Models\ScoringDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'insurance_rate',
        'insurance_net',
        'insurance_net_total',
        'office_polish_cost',
        'office_stamp_cost',
        'office_rate',
        'office_net',
        'office_net_total',
        'branch_id',
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

    protected $appends = [
        'service_charge_converted',
        'admin_charge_converted',
        'total_charge_converted',
        'contract_value_converted',
        'insurance_value_converted',
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
        if($this->service_charge != null){
            return Attribute::make(get: fn () => Sirius::toRupiah($this->service_charge));
        }else{
            return Attribute::make(get: fn () => Sirius::toRupiah(0));
        }
    }
    public function adminChargeConverted(): Attribute
    {
        if($this->admin_charge != null){
            return Attribute::make(get: fn () => Sirius::toRupiah($this->admin_charge));
        }else{
            return Attribute::make(get: fn () => Sirius::toRupiah(0));
        }
    }
    public function totalChargeConverted(): Attribute
    {
        if($this->total_charge != null){
            return Attribute::make(get: fn () => Sirius::toRupiah($this->total_charge));
        }else{
            return Attribute::make(get: fn () => Sirius::toRupiah(0));
        }
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
        $scoring = [];
        if(isset($args->scoring)){
            $scoring = array_map(function($key,$value){
                return [
                    'scoring_id' => $key,
                    'scoring_detail_id' => $value,
                    'category' => Scoring::findOrFail($key)->category,
                    'value' => ScoringDetail::findOrFail($value)->value
                ];
            },array_keys($args->scoring),array_values($args->scoring));
        }
        $totalScore = array_sum(array_column($scoring, 'value'));
        $bankNet = Sirius::calculateNetValue($args->insuranceValue,$bankRate->rate_value,$args->dayCount);
        $officeNet = Sirius::calculateNetValue($args->insuranceValue,$agentRate->rate_value,$args->dayCount);

        $bankNet = $bankNet >= $bankRate->min_value ? $bankNet : $bankRate->min_value;
        $officeNet = $officeNet >= $agentRate->min_value ? $officeNet : $agentRate->min_value;

        $bankNetTotal = $bankNet + $bankRate->polish_cost + $bankRate->stamp_cost;
        $officeNetTotal = $officeNet + $agentRate->polish_cost + $agentRate->stamp_cost;
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
                'profit' => $officeNetTotal - $bankNetTotal,
                'insurance_polish_cost' => $bankRate->polish_cost,
                'insurance_stamp_cost' =>  $bankRate->stamp_cost,
                'insurance_rate' => $bankRate->rate_value,
                'insurance_net' => $bankNet,
                'insurance_net_total' => $bankNetTotal,
                'office_polish_cost' => $agentRate->polish_cost,
                'office_stamp_cost' => $agentRate->stamp_cost,
                'office_rate' => $agentRate->rate_value,
                'office_net' => $officeNet,
                'office_net_total' => $officeNetTotal,
                'principal_id' => $args->principalId,
                'bank_id' => $args->bankId,
                'branch_id' => $args->branchId,
                'agent_id' => $args->agentId,
                'obligee_id' => $args->obligeeId,
                'insurance_id' => $args->insuranceId,
                'insurance_type_id' => $args->insuranceTypeId,
                'score' => $totalScore
            ],
            'scoring' => $scoring
        ];
    }
    private function fetchStatus(object $args): array{
        $params = [];
        $type = $args->type;
        $status = $args->status;
        if($type == 'process'){
            if($status == 'input'){
                $params = [
                    ['type' => $type,'guarantee_bank_id' => $this->id,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id,'name' => $status],
                    ['type' => 'finance','guarantee_bank_id' => $this->id,'status_id' => Status::where([['type','finance'],['name','belum lunas']])->firstOrFail()->id,'name' => 'belum lunas'],
                    ['type' => 'insurance','guarantee_bank_id' => $this->id,'status_id' => Status::where([['type','insurance'],['name','belum terbit']])->firstOrFail()->id,'name' => 'belum terbit']
                ];
            }else if($status == 'terbit'){
                $params = [
                    ['type' => $type,'guarantee_bank_id' => $this->id,'status_id' => Status::where([['type',$type],['name','analisa asuransi']])->firstOrFail()->id,'name' => 'analisa asuransi'],
                    ['type' => $type,'guarantee_bank_id' => $this->id,'status_id' => Status::where([['type',$type],['name','analisa bank']])->firstOrFail()->id,'name' => 'analisa bank'],
                    ['type' => $type,'guarantee_bank_id' => $this->id,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id,'name' => $status],
                    ['type' => 'insurance','guarantee_bank_id' => $this->id,'status_id' => Status::where([['type','insurance'],['name',$status]])->firstOrFail()->id,'name' => $status]
                ];
            }else if($status == 'analisa bank'){
                $params = [
                    ['type' => $type,'guarantee_bank_id' => $this->id,'status_id' => Status::where([['type',$type],['name','analisa asuransi']])->firstOrFail()->id,'name' => 'analisa asuransi'],
                    ['type' => $type,'guarantee_bank_id' => $this->id,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id,'name' => $status]
                ];
            }
            else{
                $params = [
                    ['type' => $type,'guarantee_bank_id' => $this->id,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id,'name' => $status]
                ];
            }
        }else if($type == 'insurance' || $type == 'finance'){
            $params = [
                ['type' => $type,'guarantee_bank_id' => $this->id,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id,'name' => $status]
            ];
        }
        return $params;
    }
    public static function buat(array $params): self{
        $request = self::fetch((object)$params);
        $guaranteeBank = self::create($request->guaranteeBank);
        $guaranteeBank->ubahStatus(['type' => 'process','status' => 'input']);
        if(isset($request->scoring)) $guaranteeBank->scorings()->createMany($request->scoring);
        return $guaranteeBank;
    }
    public static function buatDraft(array $params): self{
        $request = (object)$params;
        $guaranteeBank = self::create($request->guaranteeBank);
        $guaranteeBank->ubahStatus(['type' => 'process','status' => 'input']);
        return $guaranteeBank;
    }
    public function ubah(array $params): bool{
        $request = self::fetch((object)$params);
        if(isset($request->scoring)){
            foreach ($request->scoring as $score) {
                $this->scorings()->where('scoring_id',$score['scoring_id'])->update($score);
            }
        }
        return $this->update($request->guaranteeBank);
    }
    public function ubahStatus(array $params){
        $request = $this->fetchStatus((object)$params);
        foreach ($request as $param) {
            unset($param['name']);
            GuaranteeBankStatus::updateOrCreate([
                'guarantee_bank_id' => $param['guarantee_bank_id'],
                'status_id' => $param['status_id'],
            ],$param);
        }
        if(!collect($request)->where('name','lunas')->isEmpty()){
            $this->bayar();
        }
        if(!collect($request)->where('type','insurance')->where('name','<>','terbit')->isEmpty()){
            $guaranteeBankId = $this->id;
            $payment = Payment::whereHas('details',function($query) use ($guaranteeBankId){
                $query->where('guarantee_bank_id',$guaranteeBankId);
            })->first();
            if(!empty($payment)){
                $payment->hapus();
                $this->bayar();
            }
        }
        return true;
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
    private function bayar(){
        Payment::buat([
            'type' => 'principal_to_branch',
            'year' => date('Y'),
            'month' => date('m'),
            'datetime' => now(),
            'branchId' => $this->branch_id,
            'principalId' => $this->principal_id,
            'guaranteeBankId' => $this->id,
        ]);
    }

    private static function fetchQuery(object $args): object{
        $columns = [
            'startDate' => 'gb.created_at',
            'endDate' => 'gb.created_at',
            'receipt_number' => 'gb.receipt_number',
            'bond_number' => 'gb.bond_number',
            'polish_number' => 'sb.polish_number',
            'principal_name' => 'p.name',
            'insurance_value' => 'gb.insurance_value',
        ];
        $params = [];
        if(isset($args->request_for)) unset($args->request_for);
        foreach ($args as $key => $param) {
            if(!in_array($key,['startDate','endDate'])){
                if(isset($param['name'])){
                    if(isset($columns[$param['name']])){
                        $params[] = (object)[
                            'column' => $columns[$param['name']],
                            'operator' => $param['operator'],
                            'value' => $param['operator'] == 'like' ? ("%" . ($param['value'] ?? '') . "%") : $param['value'],
                        ];
                    }
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
                    'value' => $param ?? ''
                ];
            }
        }
        return (object)$params;
    }
    private static function kueri(array $params){
        $params = self::fetchQuery((object)$params);
        $query = DB::table('guarantee_banks as gb')
        ->join('principals as p','p.id','gb.principal_id')
        ->join('agents as a','a.id','gb.agent_id')
        ->join('obligees as o','o.id','gb.obligee_id')
        ->join('insurances as i','i.id','gb.insurance_id')
        ->join('insurance_types as it','it.id','gb.insurance_type_id');
        foreach ($params as $param) {
            if(in_array($param->column,['gb.created_at'])){
                $query->whereDate($param->column,$param->operator,$param->value);
            }else{
                $query->where($param->column,$param->operator,$param->value);
            }
        }
        return $query;
    }
    public static function table(string $type,array $params){
        if($type == 'income'){
            return self::kueri($params)->select('gb.id','gb.created_at as date','gb.receipt_number','gb.bond_number','gb.polish_number','gb.total_charge as nominal');
        }else if($type == 'expense'){
            return self::kueri($params)->select('gb.id','gb.created_at as date','gb.receipt_number','gb.bond_number','gb.polish_number','gb.insurance_net_total as nominal');
        }else if($type == 'production'){
            return self::kueri($params)->select(
                'gb.receipt_number','gb.bond_number','p.name as principal_name','gb.insurance_value','gb.start_date','gb.end_date','gb.day_count','gb.due_day_tolerance','it.code',
                'gb.insurance_net', 'gb.insurance_polish_cost', 'gb.insurance_stamp_cost', DB::raw("(gb.insurance_net + gb.insurance_polish_cost + gb.insurance_stamp_cost) as insurance_nett_total"),
                'gb.office_net', 'gb.admin_charge', DB::raw("(gb.office_net + gb.admin_charge) as office_total"),
                DB::raw("((gb.office_net + gb.admin_charge) - (gb.insurance_net + gb.insurance_polish_cost + gb.insurance_stamp_cost)) as profit"),
                'a.name as agent_name',
                DB::raw("(
                    SELECT sts.name FROM statuses AS sts INNER JOIN guarantee_bank_statuses AS gbs ON sts.id = gbs.status_id WHERE gbs.type = 'insurance' AND gbs.guarantee_bank_id = gb.id ORDER BY gbs.id DESC limit 1
                ) as status")
            );
        }else if($type == 'finance'){
            return self::kueri($params)->join('payment_details as pmd','gb.id','pmd.guarantee_bank_id')->join('payments as pm','pm.id','pmd.payment_id')->select(
                'pm.paid_at','gb.receipt_number','gb.bond_number','p.name as principal_name','gb.insurance_value','gb.start_date','gb.end_date','gb.day_count','gb.due_day_tolerance','it.code',
                'gb.insurance_net', 'gb.insurance_polish_cost', 'gb.insurance_stamp_cost', DB::raw("(gb.insurance_net + gb.insurance_polish_cost + gb.insurance_stamp_cost) as insurance_nett_total"),
                'gb.office_net', 'gb.admin_charge', DB::raw("(gb.office_net + gb.admin_charge) as office_total"),
                DB::raw("((gb.office_net + gb.admin_charge) - (gb.insurance_net + gb.insurance_polish_cost + gb.insurance_stamp_cost)) as profit"),
                'a.name as agent_name',
                DB::raw("(
                    SELECT sts.name FROM statuses AS sts INNER JOIN guarantee_bank_statuses AS gbs ON sts.id = gbs.status_id WHERE gbs.type = 'insurance' AND gbs.guarantee_bank_id = gb.id ORDER BY gbs.id DESC limit 1
                ) as status"),
            );
        }else if($type == 'remain'){
            return self::kueri($params)->select(
                'gb.receipt_number','gb.bond_number','p.name as principal_name','gb.insurance_value','gb.start_date','gb.end_date',
                'gb.day_count','gb.due_day_tolerance','it.code','gb.office_net','gb.admin_charge', DB::raw('(gb.office_net + gb.admin_charge) as office_total'),'gb.service_charge', DB::raw('(gb.service_charge + gb.admin_charge) as receipt_total'), DB::raw('((gb.service_charge + gb.admin_charge) - (gb.office_net + gb.admin_charge)) as total_charge'),'a.name as agent_name',
                DB::raw("(
                    SELECT sts.name FROM statuses AS sts INNER JOIN guarantee_bank_statuses AS gbs ON sts.id = gbs.status_id WHERE gbs.type = 'insurance' AND gbs.guarantee_bank_id = gb.id ORDER BY gbs.id DESC limit 1
                ) as status"),
                DB::raw("(
                    SELECT IFNULL(pm.id,0) AS payment
                    from payments as pm inner join payment_details as pmd on pm.id=pmd.payment_id
                    where pmd.guarantee_bank_id = gb.id AND pm.agent_id = gb.agent_id ORDER BY pm.id DESC LIMIT 1
                ) as payment")
            );
        }else if($type == 'profit'){
            return self::kueri($params)->select('gb.receipt_number','gb.total_charge as debit','gb.insurance_net_total as credit');
        }
    }
    public static function chart(string $type,array $params){
        $data = [];
        if($type == 'income'){
            $data = self::kueri($params)->selectRaw("date(gb.created_at) as date, sum(gb.total_charge) as nominal")->groupBy(DB::raw("date(gb.created_at)"))->pluck('nominal','date')->toArray();
        }else if($type == 'expense'){
            $data = self::kueri($params)->selectRaw("date(gb.created_at) as date, sum(gb.insurance_net_total) as nominal")->groupBy(DB::raw("date(gb.created_at)"))->pluck('nominal','date')->toArray();
        }else if($type == 'production'){
            $data = self::kueri($params)->selectRaw("date(gb.created_at) as date, sum(gb.office_net_total) as nominal")->groupBy(DB::raw("date(gb.created_at)"))->pluck('nominal','date')->toArray();
        }else if($type == 'finance'){
            $data = self::kueri($params)->join('payment_details as pmd','gb.id','pmd.surety_bond_id')->join('payments as pm','pm.id','pmd.payment_id')->selectRaw("date(gb.created_at) as date, sum(gb.office_net_total) as nominal")->groupBy(DB::raw("date(gb.created_at)"))->pluck('nominal','date')->toArray();
        }
        return [
            'labels' => array_map(function($val){ return Sirius::toShortDate($val); },array_keys($data)),
            'datasets' => array_values($data),
        ];
    }
    public static function summary(string $type, array $params)
    {
        if ($type == 'finance') {
            $data = self::kueri($params)->join('payment_details as pmd','gb.id','pmd.surety_bond_id')->join('payments as pm','pm.id','pmd.payment_id')->select(
                DB::raw("SUM(gb.insurance_net + gb.insurance_polish_cost + gb.insurance_stamp_cost) as insurance_nett_total"),
                DB::raw("SUM(gb.office_net + gb.admin_charge) as office_total"),
                DB::raw("SUM((gb.office_net + gb.admin_charge) - (gb.insurance_net + gb.insurance_polish_cost + gb.insurance_stamp_cost)) as profit"),
            )->first();

            return [
                'income' => Sirius::toRupiah($data->office_total ?? 0),
                'expense' => Sirius::toRupiah($data->insurance_nett_total ?? 0),
                'profit' => Sirius::toRupiah($data->profit ?? 0)
            ];
        }
    }
    // Status
    public static function mappingProcessStatusNames($status)
    {
        return Str::title($status);
    }
    public static function mappingProcessStatusColors($status)
    {
        return match ($status) {
            'input' => 'primary',
            'analisa asuransi', 'analisa bank' => 'warning',
            'terbit' => 'success',
            'batal' => 'danger',
            null => ''
        };
    }
    public static function mappingProcessStatusIcons($status)
    {
        return match ($status) {
            'input' => 'bx bxs-edit-alt',
            'analisa asuransi', 'analisa bank' => 'bx bx-search-alt',
            'terbit' => 'bx bx-check',
            'batal' => 'bx bx-x',
            null => ''
        };
    }
    public static function mappingInsuranceStatusNames($status)
    {
        return Str::title($status);
    }
    public static function mappingInsuranceStatusColors($status)
    {
        return match ($status) {
            'belum terbit' => 'primary',
            'terbit' => 'success',
            'batal', 'salah cetak' => 'danger',
            'revisi' => 'info',
            null => ''
        };
    }
    public static function mappingInsuranceStatusIcons($status)
    {
        return match ($status) {
            'belum terbit' => 'bx bx-dots-horizontal-rounded',
            'terbit' => 'bx bx-check',
            'batal', 'salah cetak' => 'bx bx-x',
            'revisi' => 'bx bx-undo',
            null => ''
        };
    }
    public static function mappingFinanceStatusNames($status)
    {
        return Str::title($status);
    }
    public static function mappingFinanceStatusColors($status)
    {
        return match ($status) {
            'belum lunas' => 'danger',
            'lunas' => 'success',
            null => ''
        };
    }
    public static function mappingFinanceStatusIcons($status)
    {
        return match ($status) {
            'belum lunas' => 'bx bx-x',
            'lunas' => 'bx bx-check',
            null => ''
        };
    }
}
