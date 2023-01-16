<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Exception;
use App\Models\Branch;
use App\Helpers\Sirius;
use App\Models\Scoring;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\GuaranteeBank;
use App\Http\Requests\GuaranteeBankRequest;
use App\Models\GuaranteeBankDraft;

class GuaranteeBankController extends Controller
{
    public function index(Request $request,?Branch $regional = null, ?Branch $branch = null)
    {
        if($request->ajax()){
            if (request()->routeIs('regional.*')) $action = 'datatables.actions-show';
            elseif (request()->routeIs('branch.*')) $action = 'datatables.actions-products';

            $data = GuaranteeBank::with('insurance_status','insurance_status.status','principal')->select('guarantee_banks.*')
            ->whereIn('branch_id',($branch ? [$branch->id] : Branch::where('regional_id',$regional->id)->pluck('id')->toArray()));
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('insurance_value', fn($bg) => Sirius::toRupiah($bg->insurance_value))
            ->editColumn('created_date', fn($bg) => Sirius::toLongDate($bg->created_date))
            ->editColumn('insurance_status.status.name', 'datatables.status-guarantee-bank')
            ->editColumn('action', $action)
            ->rawColumns(['insurance_status.status.name', 'action'])
            ->toJson();
        }
        $count_draft = count(GuaranteeBankDraft::where('approved_status','Belum Disetujui')->get());
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        $statuses = (object)[
            'process' => [
                'input',
                'analisa asuransi',
                'analisa bank',
                'terbit',
                'batal',
            ],
            'insurance' => [
                'belum terbit',
                'terbit',
                'batal',
                'revisi',
                'salah cetak',
            ],
            'finance' => [
                'lunas',
                'belum lunas',
            ]
        ];
        return view('product.guarantee-banks',compact('scorings','statuses','count_draft'));
    }

    public function create()
    {
    }

    public function store(Branch $regional, Branch $branch, GuaranteeBankRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->validated();
            $params['branchId'] = $branch->id;
            GuaranteeBank::buat($params);
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

    public function showRegional(Branch $regional, GuaranteeBank $bankGaransi)
    {
        return $this->show($regional, null, $bankGaransi);
    }

    public function show(Branch $regional, ?Branch $branch, GuaranteeBank $bankGaransi)
    {
        $bankGaransi->principal;
        $bankGaransi->obligee;
        $bankGaransi->agent;
        $bankGaransi->bank->templates;
        $bankGaransi->insurance;
        $bankGaransi->insurance_type;
        $bankGaransi->statuses;
        $bankGaransi->scorings;
        $bankGaransi->statuses;
        $bankGaransi->process_status->status;
        $bankGaransi->insurance_status->status;
        $bankGaransi->finance_status->status;
        $statusStyles = [];

        foreach ($bankGaransi->statuses as $statuses) {
            $statuses->status;
            $statusStyles[$statuses->status->type][$statuses->status->name] = [
                'name' => GuaranteeBank::{"mapping". Str::title($statuses->status->type) ."StatusNames"}($statuses->status->name),
                'color' => GuaranteeBank::{"mapping". Str::title($statuses->status->type) ."StatusColors"}($statuses->status->name),
                'icon' => GuaranteeBank::{"mapping". Str::title($statuses->status->type) ."StatusIcons"}($statuses->status->name),
            ];
        }

        return response()->json($this->showResponse(array_merge($bankGaransi->toArray(), [
            'status_style' => $statusStyles
        ])));
    }

    public function edit(GuaranteeBank $bankGaransi)
    {
    }

    public function update(Branch $regional, Branch $branch, GuaranteeBank $bankGaransi, GuaranteeBankRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->validated();
            $params['branchId'] = $branch->id;
            $bankGaransi->ubah($params);
            $http_code = 200;
            $response = $this->updateResponse();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function destroy(Branch $regional, Branch $branch, GuaranteeBank $bankGaransi)
    {
        try {
            DB::beginTransaction();
            $bankGaransi->hapus();
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

    public function changeStatus(Branch $regional, Branch $branch, GuaranteeBank $bankGaransi,Request $request){
        try {
            DB::beginTransaction();
            $bankGaransi->ubahStatus($request->all());
            $http_code = 200;
            $response = $this->updateResponse('Ubah status berhasil!');
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function printScoreRegional(Branch $regional, GuaranteeBank $bankGaransi)
    {
        return $this->printScore($regional, null, $bankGaransi);
    }

    public function printScore(Branch $regional, ?Branch $branch, GuaranteeBank $bankGaransi){
        $product = $bankGaransi;
        $selected = $product->scorings->pluck('scoring_detail_id')->toArray();
        $subTotals = [];
        foreach ($product->scorings->groupBy('category') as $scoring) {
            $subTotals[$scoring->first()->category] = $scoring->sum('value');
        }
        $pdf = Pdf::loadView('product.pdf.scoring', [
            'selected' => $selected,
            'subTotals' => $subTotals,
            'product' => $product
        ])->setPaper('a4', 'landscape');
        return $pdf->download('scoring.pdf');
    }

    public function print(Branch $regional, Branch $branch, GuaranteeBank $bankGaransi){
        $bankGaransi->principal;
        $bankGaransi->obligee;
        $bankGaransi->agent;
        $bankGaransi->bank->templates;
        $bankGaransi->insurance;
        $bankGaransi->insurance_type;
        $bankGaransi->statuses;
        $bankGaransi->scorings;
        $bankGaransi->statuses;
        $bankGaransi->process_status->status;
        $bankGaransi->insurance_status->status;
        $bankGaransi->finance_status->status;

        $bankGaransi->contract_value_converted = Sirius::toRupiah($bankGaransi->contract_value);
        $bankGaransi->contract_value_in_text = strtoupper(Sirius::toRupiahInText($bankGaransi->contract_value));
        $bankGaransi->insurance_value_converted = Sirius::toRupiah($bankGaransi->insurance_value);
        $bankGaransi->insurance_value_in_text = strtoupper(Sirius::toRupiahInText($bankGaransi->insurance_value));
        $bankGaransi->service_charge_converted = Sirius::toRupiah($bankGaransi->service_charge);
        $bankGaransi->service_charge_in_text = strtoupper(Sirius::toRupiahInText($bankGaransi->service_charge));
        $bankGaransi->admin_charge_converted = Sirius::toRupiah($bankGaransi->admin_charge);
        $bankGaransi->admin_charge_in_text = strtoupper(Sirius::toRupiahInText($bankGaransi->admin_charge));
        $bankGaransi->total_charge_converted = Sirius::toRupiah($bankGaransi->total_charge);
        $bankGaransi->total_charge_in_text = strtoupper(Sirius::toRupiahInText($bankGaransi->total_charge));
        $bankGaransi->start_date_dmy = date('d/m/Y', strtotime($bankGaransi->start_date));
        $bankGaransi->end_date_dmy = date('d/m/Y', strtotime($bankGaransi->end_date));
        $bankGaransi->document_expired_at_dmy = date('d/m/Y', strtotime($bankGaransi->document_expired_at));
        $bankGaransi->today = date('d/m/Y');

        $id = $bankGaransi->bank->id;
        $now = 'bank';
        return view('product.print',compact('id','now','bankGaransi'));
    }
    public function requestReceiptNumber(Branch $regional, Branch $branch){
        try {
            $response = $this->showResponse(GuaranteeBank::requestReceiptNumber(['branchId' => $branch->id]));
            $http_code = 200;
        } catch (Exception $e) {
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }
}
