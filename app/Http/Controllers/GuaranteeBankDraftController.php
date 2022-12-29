<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Helpers\Sirius;
use App\Http\Requests\GuaranteeBankDraftRequest;
use App\Http\Requests\GuaranteeBankRequest;
use App\Models\Branch;
use App\Models\GuaranteeBank;
use App\Models\GuaranteeBankDraft;
use App\Models\Scoring;
use App\Models\GuaranteeBankDrafts;
use Illuminate\Http\Request;

class GuaranteeBankDraftController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            if (request()->routeIs('regional.*')) $action = 'datatables.actions-show';
            elseif (request()->routeIs('branch.*')) $action = 'datatables.actions-show-delete';

            $data = GuaranteeBankDraft::with('principal')->orderBy('created_at','desc')->get();
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('insurance_value', fn($sb) => Sirius::toRupiah($sb->insurance_value))
            ->editColumn('start_date', fn($sb) => Sirius::toLongDate($sb->start_date))
            ->editColumn('action', $action)
            ->toJson();
        }
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        return view('product.guarantee-banks-draft',compact('scorings'));
    }

    public function indexClient()
    {
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        return view('guarantee-banks-client',compact('scorings'));
    }

    public function storeClient(GuaranteeBankDraftRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->validated();
            GuaranteeBankDraft::buat($params);
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

    public function store(Request $request)
    {
    }

    public function show(Branch $regional, ?Branch $branch, GuaranteeBankDraft $bank_garansi_draft)
    {
        $bank_garansi_draft->branch->regional;
        $bank_garansi_draft->principal;
        $bank_garansi_draft->obligee;
        $bank_garansi_draft->agent;
        $bank_garansi_draft->bank;
        $bank_garansi_draft->insurance;
        $bank_garansi_draft->insurance_type;
        $bank_garansi_draft->scorings;
        return response()->json($this->showResponse($bank_garansi_draft->toArray()));
    }

    public function approve(Branch $regional, ?Branch $branch, GuaranteeBankDraft $bank_garansi_draft)
    {
        // $scoring = [];
        // foreach($bank_garansi_draft->scorings as $value){
        //     array_push($scoring, [
        //         'scoring_id' => $value->scoring_id,
        //         'scoring_detail_id' => $value->scoring_detail_id,
        //         'category' => $value->category,
        //         'value' => $value->value,
        //     ]);
        // }
        $data = [
            'guaranteeBank' => [
                'receipt_number' => $bank_garansi_draft->receipt_number,
                'bond_number' => $bank_garansi_draft->bond_number,
                'polish_number' => $bank_garansi_draft->polish_number,
                'project_name' => $bank_garansi_draft->project_name,
                'start_date' => $bank_garansi_draft->start_date,
                'end_date' => $bank_garansi_draft->end_date,
                'day_count' => $bank_garansi_draft->day_count,
                'due_day_tolerance' => $bank_garansi_draft->due_day_tolerance,
                'document_number' => $bank_garansi_draft->document_number,
                'document_title' => $bank_garansi_draft->document_title,
                'document_expired_at' => $bank_garansi_draft->document_expired_at,
                'contract_value' => $bank_garansi_draft->contract_value,
                'insurance_value' => $bank_garansi_draft->insurance_value,
                // 'service_charge' => $bank_garansi_draft->service_charge,
                // 'admin_charge' => $bank_garansi_draft->admin_charge,
                // 'total_charge' => $bank_garansi_draft->total_charge,
                'profit' => $bank_garansi_draft->profit,
                'insurance_polish_cost' => $bank_garansi_draft->insurance_polish_cost,
                'insurance_stamp_cost' =>  $bank_garansi_draft->insurance_stamp_cost,
                'insurance_rate' => $bank_garansi_draft->insurance_rate,
                'insurance_net' => $bank_garansi_draft->insurance_net,
                'insurance_net_total' => $bank_garansi_draft->insurance_net_total,
                'office_polish_cost' => $bank_garansi_draft->office_polish_cost,
                'office_stamp_cost' => $bank_garansi_draft->office_stamp_cost,
                'office_rate' => $bank_garansi_draft->office_rate,
                'office_net' => $bank_garansi_draft->office_net,
                'office_net_total' => $bank_garansi_draft->office_net_total,
                'bank_id' => $bank_garansi_draft->bank_id,
                'branch_id' => $bank_garansi_draft->branch_id,
                'principal_id' => $bank_garansi_draft->principal_id,
                'agent_id' => $bank_garansi_draft->agent_id,
                'obligee_id' => $bank_garansi_draft->obligee_id,
                'insurance_id' => $bank_garansi_draft->insurance_id,
                'insurance_type_id' => $bank_garansi_draft->insurance_type_id,
                // 'score' => $bank_garansi_draft->score
            ],
            // 'scoring' => $scoring
        ];

        try {
            DB::beginTransaction();
            $params = $data;
            GuaranteeBank::buatDraft($params);
            $bank_garansi_draft->hapus();
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

    public function decline(Branch $regional, ?Branch $branch, GuaranteeBankDraft $bank_garansi_draft)
    {
        // $scoring = [];
        // foreach($bank_garansi_draft->scorings as $value){
        //     array_push($scoring, [
        //         'scoring_id' => $value->scoring_id,
        //         'scoring_detail_id' => $value->scoring_detail_id,
        //         'category' => $value->category,
        //         'value' => $value->value,
        //     ]);
        // }
        $data = [
            'guaranteeBank' => [
                'receipt_number' => $bank_garansi_draft->receipt_number,
                'bond_number' => $bank_garansi_draft->bond_number,
                'polish_number' => $bank_garansi_draft->polish_number,
                'project_name' => $bank_garansi_draft->project_name,
                'start_date' => $bank_garansi_draft->start_date,
                'end_date' => $bank_garansi_draft->end_date,
                'day_count' => $bank_garansi_draft->day_count,
                'due_day_tolerance' => $bank_garansi_draft->due_day_tolerance,
                'document_number' => $bank_garansi_draft->document_number,
                'document_title' => $bank_garansi_draft->document_title,
                'document_expired_at' => $bank_garansi_draft->document_expired_at,
                'contract_value' => $bank_garansi_draft->contract_value,
                'insurance_value' => $bank_garansi_draft->insurance_value,
                // 'service_charge' => $bank_garansi_draft->service_charge,
                // 'admin_charge' => $bank_garansi_draft->admin_charge,
                // 'total_charge' => $bank_garansi_draft->total_charge,
                'profit' => $bank_garansi_draft->profit,
                'insurance_polish_cost' => $bank_garansi_draft->insurance_polish_cost,
                'insurance_stamp_cost' =>  $bank_garansi_draft->insurance_stamp_cost,
                'insurance_rate' => $bank_garansi_draft->insurance_rate,
                'insurance_net' => $bank_garansi_draft->insurance_net,
                'insurance_net_total' => $bank_garansi_draft->insurance_net_total,
                'office_polish_cost' => $bank_garansi_draft->office_polish_cost,
                'office_stamp_cost' => $bank_garansi_draft->office_stamp_cost,
                'office_rate' => $bank_garansi_draft->office_rate,
                'office_net' => $bank_garansi_draft->office_net,
                'office_net_total' => $bank_garansi_draft->office_net_total,
                'branch_id' => $bank_garansi_draft->branch_id,
                'principal_id' => $bank_garansi_draft->principal_id,
                'agent_id' => $bank_garansi_draft->agent_id,
                'obligee_id' => $bank_garansi_draft->obligee_id,
                'insurance_id' => $bank_garansi_draft->insurance_id,
                'insurance_type_id' => $bank_garansi_draft->insurance_type_id,
                // 'score' => $bank_garansi_draft->score,
                'approved_status' => 'Ditolak',
                'bank_id' => $bank_garansi_draft->bank_id,
            ],
            // 'scoring' => $scoring
        ];

        try {
            DB::beginTransaction();
            $params = $data;
            $bank_garansi_draft->ubah($params);
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

    public function update(Request $request, GuaranteeBankDraft $guaranteeBankDrafts)
    {
    }

    public function destroy(Branch $regional, Branch $branch, GuaranteeBankDraft $bank_garansi_draft)
    {
        try {
            DB::beginTransaction();
            $bank_garansi_draft->hapus();
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
