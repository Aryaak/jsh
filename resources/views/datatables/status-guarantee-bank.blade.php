@php
    $status = $model->insurance_status?->status->name ?? $model->status;
@endphp
<x-badge rounded face="label-{{ \App\Models\GuaranteeBank::mappingInsuranceStatusColors($status) }}" icon="{{ \App\Models\GuaranteeBank::mappingInsuranceStatusIcons($status) }}">{{ \App\Models\GuaranteeBank::mappingInsuranceStatusNames($status) }}</x-badge>
