@php
    $status = $model->insurance_status->status->name ?? $model->status;
@endphp
<x-badge rounded face="label-{{ \App\Models\SuretyBond::mappingInsuranceStatusColors($status) }}" icon="{{ \App\Models\SuretyBond::mappingInsuranceStatusIcons($status) }}">{{ \App\Models\SuretyBond::mappingInsuranceStatusNames($status) }}</x-badge>
