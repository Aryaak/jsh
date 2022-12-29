<?php

namespace App\Http\Controllers;

use App\Models\SuretyBondDraft;
use Illuminate\Http\Request;
use App\Models\Scoring;
use App\Helpers\Sirius;
use App\Http\Requests\SuretyBondDraftRequest;
use App\Models\Branch;
use DB;
use Exception;
use App\Http\Requests\SuretyBondRequest;
use App\Models\SuretyBond;

class SuretyBondDraftController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            if (request()->routeIs('regional.*')) $action = 'datatables.actions-show';
            elseif (request()->routeIs('branch.*')) $action = 'datatables.actions-show-delete';

            $data = SuretyBondDraft::with('principal')->orderBy('created_at','desc')->get();
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('insurance_value', fn($sb) => Sirius::toRupiah($sb->insurance_value))
            ->editColumn('start_date', fn($sb) => Sirius::toLongDate($sb->start_date))
            ->editColumn('action', $action)
            ->toJson();
        }
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        $statuses = (object)[
            'process' => [
                'input' => 'Input',
                'analisa asuransi' => 'Analisa Asuransi',
                'terbit' => 'Terbit'
            ],
            'insurance' => [
                'belum terbit' => 'Belum Terbit',
                'terbit' => 'Terbit',
                'batal' => 'Batal',
                'revisi' => 'Revisi',
                'salah cetak' => 'Salah Cetak',
            ],
            'finance' => [
                'lunas' => 'Lunas',
                'belum lunas' => 'Belum Lunas'
            ]
        ];
        return view('product.surety-bonds-draft',compact('scorings','statuses'));
    }

    public function indexClient()
    {
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        return view('surety-bonds-client',compact('scorings'));
    }

    public function storeClient(SuretyBondDraftRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->validated();
            SuretyBondDraft::buat($params);
            $http_code = 200;
            $response = $this->storeResponse();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function store(Branch $branch, SuretyBondRequest $request)
    {

    }

    public function show(Branch $regional, ?Branch $branch, SuretyBondDraft $surety_bond_draft)
    {
        $surety_bond_draft->branch->regional;
        $surety_bond_draft->principal;
        $surety_bond_draft->obligee;
        $surety_bond_draft->agent;
        $surety_bond_draft->insurance;
        $surety_bond_draft->insurance_type;
        $surety_bond_draft->scorings;
        return response()->json($this->showResponse($surety_bond_draft->toArray()));
    }

    public function approve(Branch $regional, ?Branch $branch, SuretyBondDraft $surety_bond_draft)
    {
        // $scoring = [];
        // foreach($surety_bond_draft->scorings as $value){
        //     array_push($scoring, [
        //         'scoring_id' => $value->scoring_id,
        //         'scoring_detail_id' => $value->scoring_detail_id,
        //         'category' => $value->category,
        //         'value' => $value->value,
        //     ]);
        // }
        $data = [
            'suretyBond' => [
                'receipt_number' => $surety_bond_draft->receipt_number,
                'bond_number' => $surety_bond_draft->bond_number,
                'polish_number' => $surety_bond_draft->polish_number,
                'project_name' => $surety_bond_draft->project_name,
                'start_date' => $surety_bond_draft->start_date,
                'end_date' => $surety_bond_draft->end_date,
                'day_count' => $surety_bond_draft->day_count,
                'due_day_tolerance' => $surety_bond_draft->due_day_tolerance,
                'document_number' => $surety_bond_draft->document_number,
                'document_title' => $surety_bond_draft->document_title,
                'document_expired_at' => $surety_bond_draft->document_expired_at,
                'contract_value' => $surety_bond_draft->contract_value,
                'insurance_value' => $surety_bond_draft->insurance_value,
                // 'service_charge' => $surety_bond_draft->service_charge,
                // 'admin_charge' => $surety_bond_draft->admin_charge,
                // 'total_charge' => $surety_bond_draft->total_charge,
                'profit' => $surety_bond_draft->profit,
                'insurance_polish_cost' => $surety_bond_draft->insurance_polish_cost,
                'insurance_stamp_cost' =>  $surety_bond_draft->insurance_stamp_cost,
                'insurance_rate' => $surety_bond_draft->insurance_rate,
                'insurance_net' => $surety_bond_draft->insurance_net,
                'insurance_net_total' => $surety_bond_draft->insurance_net_total,
                'office_polish_cost' => $surety_bond_draft->office_polish_cost,
                'office_stamp_cost' => $surety_bond_draft->office_stamp_cost,
                'office_rate' => $surety_bond_draft->office_rate,
                'office_net' => $surety_bond_draft->office_net,
                'office_net_total' => $surety_bond_draft->office_net_total,
                'branch_id' => $surety_bond_draft->branch_id,
                'principal_id' => $surety_bond_draft->principal_id,
                'agent_id' => $surety_bond_draft->agent_id,
                'obligee_id' => $surety_bond_draft->obligee_id,
                'insurance_id' => $surety_bond_draft->insurance_id,
                'insurance_type_id' => $surety_bond_draft->insurance_type_id,
                // 'score' => $surety_bond_draft->score
            ],
            // 'scoring' => $scoring
        ];

        try {
            DB::beginTransaction();
            $params = $data;
            SuretyBond::buatDraft($params);
            $surety_bond_draft->hapus();
            $http_code = 200;
            $response = $this->storeResponse();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function decline(Branch $regional, ?Branch $branch, SuretyBondDraft $surety_bond_draft)
    {
        // $scoring = [];
        // foreach($surety_bond_draft->scorings as $value){
        //     array_push($scoring, [
        //         'scoring_id' => $value->scoring_id,
        //         'scoring_detail_id' => $value->scoring_detail_id,
        //         'category' => $value->category,
        //         'value' => $value->value,
        //     ]);
        // }
        $data = [
            'suretyBond' => [
                'receipt_number' => $surety_bond_draft->receipt_number,
                'bond_number' => $surety_bond_draft->bond_number,
                'polish_number' => $surety_bond_draft->polish_number,
                'project_name' => $surety_bond_draft->project_name,
                'start_date' => $surety_bond_draft->start_date,
                'end_date' => $surety_bond_draft->end_date,
                'day_count' => $surety_bond_draft->day_count,
                'due_day_tolerance' => $surety_bond_draft->due_day_tolerance,
                'document_number' => $surety_bond_draft->document_number,
                'document_title' => $surety_bond_draft->document_title,
                'document_expired_at' => $surety_bond_draft->document_expired_at,
                'contract_value' => $surety_bond_draft->contract_value,
                'insurance_value' => $surety_bond_draft->insurance_value,
                // 'service_charge' => $surety_bond_draft->service_charge,
                // 'admin_charge' => $surety_bond_draft->admin_charge,
                // 'total_charge' => $surety_bond_draft->total_charge,
                'profit' => $surety_bond_draft->profit,
                'insurance_polish_cost' => $surety_bond_draft->insurance_polish_cost,
                'insurance_stamp_cost' =>  $surety_bond_draft->insurance_stamp_cost,
                'insurance_rate' => $surety_bond_draft->insurance_rate,
                'insurance_net' => $surety_bond_draft->insurance_net,
                'insurance_net_total' => $surety_bond_draft->insurance_net_total,
                'office_polish_cost' => $surety_bond_draft->office_polish_cost,
                'office_stamp_cost' => $surety_bond_draft->office_stamp_cost,
                'office_rate' => $surety_bond_draft->office_rate,
                'office_net' => $surety_bond_draft->office_net,
                'office_net_total' => $surety_bond_draft->office_net_total,
                'branch_id' => $surety_bond_draft->branch_id,
                'principal_id' => $surety_bond_draft->principal_id,
                'agent_id' => $surety_bond_draft->agent_id,
                'obligee_id' => $surety_bond_draft->obligee_id,
                'insurance_id' => $surety_bond_draft->insurance_id,
                'insurance_type_id' => $surety_bond_draft->insurance_type_id,
                // 'score' => $surety_bond_draft->score,
                'approved_status' => 'Ditolak',
            ],
            // 'scoring' => $scoring
        ];

        try {
            DB::beginTransaction();
            $params = $data;
            $surety_bond_draft->ubah($params);
            $http_code = 200;
            $response = $this->storeResponse();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function edit(SuretyBondDraft $suretyBondDraft)
    {
    }

    public function update(Request $request, SuretyBondDraft $suretyBondDraft)
    {
    }

    public function destroy(Branch $regional, Branch $branch, SuretyBondDraft $surety_bond_draft)
    {
        try {
            DB::beginTransaction();
            $surety_bond_draft->hapus();
            $http_code = 200;
            $response = $this->destroyResponse();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }
}
