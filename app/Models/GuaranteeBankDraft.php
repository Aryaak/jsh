<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\BankRate;
use App\Models\ScoringDetail;
use App\Models\AgentRate;
use App\Models\Scoring;
use App\Models\Status;
use App\Helpers\Sirius;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;

class GuaranteeBankDraft extends Model
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
        'revision_from_id',
        'approved_status'
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
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
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
        return $this->belongsTo(GuaranteeBankDraft::class,'revision_from_id');
    }
    public function scorings(){
        return $this->hasMany(GuaranteeBankDraftScore::class);
    }

    private static function fetch(object $args): object{
        $bankRate = BankRate::where([['bank_id',$args->bankId],['insurance_type_id',$args->insuranceTypeId],['insurance_id',$args->insuranceId]])->firstOrFail();
        $agentRate = AgentRate::where([['insurance_id',$args->insuranceId],['insurance_type_id',$args->insuranceTypeId],['agent_id',$args->agentId],['bank_id',$args->bankId]])->firstOrFail();

        $bankNet = ((int)$args->insuranceValue * $bankRate->rate_value / (((int)$args->dayCount > 90) ? 90 : 1));
        $officeNet = ((int)$args->insuranceValue * $agentRate->rate_value / (((int)$args->dayCount > 90) ? 90 : 1));

        $bankNet = $bankNet >= $bankRate->min_value ? $bankNet : $bankRate->min_value;
        $officeNet = $officeNet >= $agentRate->min_value ? $officeNet : $agentRate->min_value;

        $bankNetTotal = $bankNet + $bankRate->polish_cost + $bankRate->stamp_cost;
        $officeNetTotal = $officeNet + $agentRate->polish_cost + $agentRate->stamp_cost;
        return (object)[
            'guaranteeBank' => [
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
                'branch_id' => $args->branchId,
                'principal_id' => $args->principalId,
                'bank_id' => $args->bankId,
                'agent_id' => $args->agentId,
                'obligee_id' => $args->obligeeId,
                'insurance_id' => $args->insuranceId,
                'insurance_type_id' => $args->insuranceTypeId,
                'approved_status' => 'Belum Disetujui'
            ],
        ];
    }

    public static function buat(array $params): self{
        $request = self::fetch((object)$params);
        $guaranteeBank = self::create($request->guaranteeBank);
        return $guaranteeBank;
    }

    public function ubah(array $params): bool{
        $request = (object)$params;
        return $this->update($request->guaranteeBank);
    }

    public function hapus(){
        try{
            $this->scorings()->delete();
            return $this->delete();
        } catch (Exception $ex) {
            throw new Exception("Data ini tidak dapat dihapus karena sedang digunakan di data lain!", 422);
        }
    }
}
