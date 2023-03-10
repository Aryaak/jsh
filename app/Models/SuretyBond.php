<?php

namespace App\Models;

use DB;
use Exception;
use App\Models\Status;
use App\Helpers\Sirius;
use App\Models\Scoring;
use App\Models\Payment;
use App\Helpers\Jamsyar;
use App\Models\AgentRate;
use Illuminate\Support\Str;
use App\Models\InsuranceRate;
use App\Models\ScoringDetail;
use App\Models\SuretyBondStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'score',
        'request_number'
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
        'insurance_value_converted',
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
    public function branch(){
        return $this->belongsTo(Branch::class);
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
    public static function requestReceiptNumber(array $params): array{
        $nextNumber = (self::where('branch_id',$params['branchId'])->max('receipt_number') ?? 0) + 1;
        return [
            'receiptNumber' => Sirius::fetchReceiptNumber($nextNumber)
        ];
    }
    private static function fetch(object $args): object{
        $insuranceRate = InsuranceRate::where([['insurance_id',$args->insuranceId],['insurance_type_id',$args->insuranceTypeId]])->firstOrFail();
        $agentRate = AgentRate::where([['insurance_id',$args->insuranceId],['insurance_type_id',$args->insuranceTypeId],['agent_id',$args->agentId],['bank_id',null]])->firstOrFail();
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
        $insuranceNet = Sirius::calculateNetValue($args->insuranceValue,$insuranceRate->rate_value,$args->dayCount);
        $officeNet = Sirius::calculateNetValue($args->insuranceValue,$agentRate->rate_value,$args->dayCount);

        $insuranceNet = $insuranceNet >= $insuranceRate->min_value ? $insuranceNet : $insuranceRate->min_value;
        $officeNet = $officeNet >= $agentRate->min_value ? $officeNet : $agentRate->min_value;

        $insuranceNetTotal = $insuranceNet + $insuranceRate->polish_cost + $insuranceRate->stamp_cost;
        $officeNetTotal = $officeNet + $agentRate->polish_cost + $agentRate->stamp_cost;

        $serviceCharge = $args->serviceCharge ?? 0;
        $adminCharge = $args->adminCharge ?? 0;
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
                'service_charge' => $serviceCharge,
                'admin_charge' => $adminCharge,
                'total_charge' => $serviceCharge + $adminCharge,
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
    private function fetchStatus(object $args): array{
        $params = [];
        $type = $args->type;
        $status = $args->status;
        if($type == 'process'){
            if($status == 'input'){
                $params = [
                    ['type' => $type,'surety_bond_id' => $this->id,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id,'name' => $status],
                    ['type' => 'finance','surety_bond_id' => $this->id,'status_id' => Status::where([['type','finance'],['name','belum lunas']])->firstOrFail()->id,'name' => 'belum lunas'],
                    ['type' => 'insurance','surety_bond_id' => $this->id,'status_id' => Status::where([['type','insurance'],['name','belum terbit']])->firstOrFail()->id,'name' => 'belum terbit']
                ];
            }else if($status == 'terbit'){
                $params = [
                    ['type' => $type,'surety_bond_id' => $this->id,'status_id' => Status::where([['type',$type],['name','analisa asuransi']])->firstOrFail()->id,'name' => 'analisa asuransi'],
                    ['type' => $type,'surety_bond_id' => $this->id,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id,'name' => $status],
                    ['type' => 'insurance','surety_bond_id' => $this->id,'status_id' => Status::where([['type','insurance'],['name',$status]])->firstOrFail()->id,'name' => $status]
                ];
            }else{
                $params = [
                    ['type' => $type,'surety_bond_id' => $this->id,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id,'name' => $status]
                ];
            }
        }else if($type == 'insurance' || $type == 'finance'){
            $params = [
                ['type' => $type,'surety_bond_id' => $this->id,'status_id' => Status::where([['type',$type],['name',$status]])->firstOrFail()->id,'name' => $status]
            ];
        }
        return $params;
    }
    public static function buat(array $params): self{
        $request = self::fetch((object)$params);
        $suretyBond = self::create($request->suretyBond);
        $suretyBond->ubahStatus(['type' => 'process','status' => 'input']);
        if(isset($request->scoring)) $suretyBond->scorings()->createMany($request->scoring);
        return $suretyBond;
    }
    public static function buatDraft(array $params): self{
        $request = (object)$params;
        $suretyBond = self::create($request->suretyBond);
        $suretyBond->ubahStatus(['type' => 'process','status' => 'input']);
        return $suretyBond;
    }
    public function ubah(array $params): bool{
        $request = self::fetch((object)$params);
        if(isset($request->scoring)) {
            foreach ($request->scoring as $score) {
                $this->scorings()->where('scoring_id',$score['scoring_id'])->update($score);
            }
        }
        return $this->update($request->suretyBond);
    }
    public function ubahStatus(array $params): bool{
        $request = $this->fetchStatus((object)$params);
        foreach ($request as $param) {
            unset($param['name']);
            SuretyBondStatus::updateOrCreate([
                'surety_bond_id' => $param['surety_bond_id'],
                'status_id' => $param['status_id'],
            ],$param);
        }
        if(!collect($request)->where('name','lunas')->isEmpty()){
            $this->bayar();
        }
        if(!collect($request)->where('type','insurance')->where('name','<>','terbit')->isEmpty()){
            $suretyBondId = $this->id;
            $payment = Payment::whereHas('details',function($query) use ($suretyBondId){
                $query->where('surety_bond_id',$suretyBondId);
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
            throw new Exception("Data ini tidak dapat dihapus karena sedang digunakan di data lain!", 422);
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
            'suretyBondId' => $this->id,
        ]);
    }

    public static function sectors(){
        //disesuaikan dengan dokumentasi jamshar v1.1.0, 12-20-2022 by Imoh
        return [
            258 => 'Konstruksi',
            563 => 'Non Konstruksi'
        ];
    }

    public static function basts(){
        //disesuaikan dengan dokumentasi jamshar v1.1.0, 12-20-2022 by Imoh
        return [
            1 => 'Ada',
            2 => 'Tidak Ada',
        ];
    }

    public static function jamsyarInsuranceType(int $returnType = 0){
        //disesuaikan dengan dokumentasi jamshar v1.1.0, 12-20-2022 by Imoh
        if($returnType === 0){
            return [
                7 => 'Jaminan Pelaksanaan',
                8 => 'Jaminan Pemeliharaan',
                5 => 'Jaminan Penawaran',
                6 => 'Jaminan Uang Muka'
            ];
        }else if($returnType == 1){
            return [
                'Jaminan Pelaksanaan' => 7,
                'Jaminan Pemeliharaan' => 8,
                'Jaminan Penawaran' => 5,
                'Jaminan Uang Muka' => 6,
            ];
        }
    }

    public function fetchSync(): array{
        $principal = (object)[
            'kodeUnik' => $this->principal->jamsyar_code ?? throw new Exception("Principal ini belum terdaftar di Jamsyar", 422),
            'noSurat' => $this->principal->certificate->number ?? throw new Exception("Principal ini belum memiliki akta pendirian", 422),
            'tglSurat' => date('Ymd',strtotime($this->principal->certificate->expired_at)) ?? throw new Exception("Principal ini belum memiliki akta pendirian", 422),
            'kategori' => 'Belum diterapkan',

        ];
        $kodeUnikObligee = $this->obligee->jamsyar_code ?? throw new Exception("Obligee ini belum terdaftar di Jamsyar", 422);
        return [
            "jenis_penjaminan" => ($attemp = self::jamsyarInsuranceType(1)[$this->insurance_type->name] ?? null) ? $attemp : throw new Exception("Jenis Jaminan ini tidak dikenali Jamsyar", 422),
            "jenis_persyaratan" => 0,
            "skema_penalty" => 0,
            "sektor" => 258,
            "principal" => $principal->kodeUnik,
            "kategori_principal" => $principal->kategori,
            "obligee" => $kodeUnikObligee,
            "no_surat" => $principal->noSurat,
            "tanggal_surat" => $principal->tglSurat,
            "no_kontrak" => $this->document_number ? $this->document_number : throw new Exception("Dokumen pendukung diperlukan untuk sinkron ke Jamsyar", 422),
            "tanggal_kontrak" => $this->document_expired_at ? date('Ymd',strtotime($this->document_expired_at)) : throw new Exception("Dokumen pendukung diperlukan untuk sinkron ke Jamsyar", 422),
            "bast" => 2,
            "propinsi" => $this->principal->city->province_id,
            "kota" => $this->principal->city->id,
            "nama_proyek" => $this->project_name,
            "nilai_proyek" => $this->contract_value,
            "nilai_bond" => $this->insurance_value,
            "tanggal_awal" => date('Ymd',strtotime($this->start_date)),
            "tanggal_akhir" => date('Ymd',strtotime($this->end_date)),
            "penambahan_jangka_waktu" => $this->due_day_tolerance,
            "biaya_administrasi" => $this->admin_charge,
            "biaya_materai" => $this->insurance_stamp_cost,
            "subagen" => 34,
        ];
    }

    public function sync(){
        $url = config('app.env') == 'local' ? 'http://devmicroservice.jamkrindosyariah.co.id/Api/permohonan_sbd' : 'http://192.168.190.168:8002/Api/permohonan_sbd';
        $params = $this->fetchSync();
        $response = Http::asJson()->acceptJson()->withToken(Jamsyar::login())
        ->post($url, $this->fetchSync());
        // dd($response);
        if($response->successful()){
            // $data = $response->json()['data'];
            dd($response->json());
            // return $this->update([
            //     'request_number' => $data['no_permohonan'],
            // ]);
        }else{
            throw new Exception($response->json()['keterangan'], $response->json()['status']);
        }
    }
    private static function fetchQuery(object $args): object{
        $columns = [
            'startDate' => 'sb.created_at',
            'endDate' => 'sb.created_at',
            'receipt_number' => 'sb.receipt_number',
            'bond_number' => 'sb.bond_number',
            'polish_number' => 'sb.polish_number',
            'principal_name' => 'p.name',
            'insurance_value' => 'sb.insurance_value',
            'insurance_name' => 'i.name',
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
            return self::kueri($params)->select('sb.id','sb.created_at as date','sb.receipt_number','sb.bond_number','sb.polish_number','sb.total_charge as nominal','i.name as insurance_name');
        }else if($type == 'expense'){
            return self::kueri($params)->select('sb.id','sb.created_at as date','sb.receipt_number','sb.bond_number','sb.polish_number','sb.insurance_net_total as nominal','i.name as insurance_name');
        }else if($type == 'production'){
            return self::kueri($params)->select(
                'sb.receipt_number','sb.bond_number','p.name as principal_name','sb.insurance_value','sb.start_date','sb.end_date','sb.day_count','sb.due_day_tolerance','it.code',
                'sb.insurance_net', 'sb.insurance_polish_cost', 'sb.insurance_stamp_cost', DB::raw("(sb.insurance_net + sb.insurance_polish_cost + sb.insurance_stamp_cost) as insurance_nett_total"),
                'sb.office_net', 'sb.admin_charge', DB::raw("(sb.office_net + sb.admin_charge) as office_total"),
                DB::raw("((sb.office_net + sb.admin_charge) - (sb.insurance_net + sb.insurance_polish_cost + sb.insurance_stamp_cost)) as profit"),
                'a.name as agent_name',
                DB::raw("(
                    SELECT sts.name FROM statuses AS sts INNER JOIN surety_bond_statuses AS sbs ON sts.id = sbs.status_id WHERE sbs.type = 'insurance' AND sbs.surety_bond_id = sb.id ORDER BY sbs.id DESC limit 1
                ) as status"),
                'i.name as insurance_name'
            );
        }else if($type == 'finance'){
            return self::kueri($params)->join('payment_details as pmd','sb.id','pmd.surety_bond_id')->join('payments as pm','pm.id','pmd.payment_id')->select(
                'pm.paid_at','sb.receipt_number','sb.bond_number','p.name as principal_name','sb.insurance_value','sb.start_date','sb.end_date','sb.day_count','sb.due_day_tolerance','it.code',
                'sb.insurance_net', 'sb.insurance_polish_cost', 'sb.insurance_stamp_cost', DB::raw("(sb.insurance_net + sb.insurance_polish_cost + sb.insurance_stamp_cost) as insurance_nett_total"),
                'sb.office_net', 'sb.admin_charge', DB::raw("(sb.office_net + sb.admin_charge) as office_total"),
                DB::raw("((sb.office_net + sb.admin_charge) - (sb.insurance_net + sb.insurance_polish_cost + sb.insurance_stamp_cost)) as profit"),
                'a.name as agent_name',
                DB::raw("(
                    SELECT sts.name FROM statuses AS sts INNER JOIN surety_bond_statuses AS sbs ON sts.id = sbs.status_id WHERE sbs.type = 'insurance' AND sbs.surety_bond_id = sb.id ORDER BY sbs.id DESC limit 1
                ) as status"),
                'i.name as insurance_name'
            );
        }else if($type == 'remain'){
            return self::kueri($params)->select(
                'sb.receipt_number','sb.bond_number','p.name as principal_name','sb.insurance_value','sb.start_date','sb.end_date',
                'sb.day_count','sb.due_day_tolerance','it.code','sb.office_net','sb.admin_charge', DB::raw('(sb.office_net + sb.admin_charge) as office_total'),'sb.service_charge', DB::raw('(sb.service_charge + sb.admin_charge) as receipt_total'), DB::raw('((sb.service_charge + sb.admin_charge) - (sb.office_net + sb.admin_charge)) as total_charge'),'a.name as agent_name',
                DB::raw("(
                    SELECT sts.name FROM statuses AS sts INNER JOIN surety_bond_statuses AS sbs ON sts.id = sbs.status_id WHERE sbs.type = 'insurance' AND sbs.surety_bond_id = sb.id ORDER BY sbs.id DESC limit 1
                ) as status"),
                DB::raw("(
                    SELECT IFNULL(pm.id,0) AS payment
                    from payments as pm inner join payment_details as pmd on pm.id=pmd.payment_id
                    where pmd.surety_bond_id = sb.id AND pm.agent_id = sb.agent_id ORDER BY pm.id DESC LIMIT 1
                ) as payment"),
                'i.name as insurance_name'
            );
        }else if($type == 'profit'){
            return self::kueri($params)->select('sb.receipt_number','sb.total_charge as debit','sb.insurance_net_total as credit','i.name as insurance_name');
        }
    }
    public static function chart(string $type,array $params){
        $data = [];
        if($type == 'income'){
            $data = self::kueri($params)->selectRaw("date(sb.created_at) as date, sum(sb.total_charge) as nominal")->groupBy(DB::raw("date(sb.created_at)"))->pluck('nominal','date')->toArray();
        }else if($type == 'expense'){
            $data = self::kueri($params)->selectRaw("date(sb.created_at) as date, sum(sb.insurance_net_total) as nominal")->groupBy(DB::raw("date(sb.created_at)"))->pluck('nominal','date')->toArray();
        }else if($type == 'production'){
            $data = self::kueri($params)->selectRaw("date(sb.created_at) as date, sum(sb.office_net_total) as nominal")->groupBy(DB::raw("date(sb.created_at)"))->pluck('nominal','date')->toArray();
        }else if($type == 'finance'){
            $data = self::kueri($params)->join('payment_details as pmd','sb.id','pmd.surety_bond_id')->join('payments as pm','pm.id','pmd.payment_id')->selectRaw("date(sb.created_at) as date, sum(sb.office_net_total) as nominal")->groupBy(DB::raw("date(sb.created_at)"))->pluck('nominal','date')->toArray();
        }
        return [
            'labels' => array_map(function($val){ return Sirius::toShortDate($val); },array_keys($data)),
            'datasets' => array_values($data),
        ];
    }
    public static function summary(string $type, array $params)
    {
        if ($type == 'finance') {
            $data = self::kueri($params)->join('payment_details as pmd','sb.id','pmd.surety_bond_id')->join('payments as pm','pm.id','pmd.payment_id')->select(
                DB::raw("SUM(sb.insurance_net + sb.insurance_polish_cost + sb.insurance_stamp_cost) as insurance_nett_total"),
                DB::raw("SUM(sb.office_net + sb.admin_charge) as office_total"),
                DB::raw("SUM((sb.office_net + sb.admin_charge) - (sb.insurance_net + sb.insurance_polish_cost + sb.insurance_stamp_cost)) as profit"),
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
            'analisa asuransi' => 'warning',
            'terbit' => 'success',
            'batal' => 'danger',
            null => ''
        };
    }
    public static function mappingProcessStatusIcons($status)
    {
        return match ($status) {
            'input' => 'bx bxs-edit-alt',
            'analisa asuransi' => 'bx bx-search-alt',
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
            'piutang', 'belum lunas' => 'danger',
            'lunas' => 'success',
            null => ''
        };
    }
    public static function mappingFinanceStatusIcons($status)
    {
        return match ($status) {
            'piutang', 'belum lunas' => 'bx bx-x',
            'lunas' => 'bx bx-check',
            null => ''
        };
    }

}
