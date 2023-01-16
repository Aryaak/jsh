<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Exception;
use App\Models\Branch;
use App\Helpers\Sirius;
use App\Models\Scoring;
use App\Models\SuretyBond;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\SuretyBondRequest;
use App\Models\SuretyBondDraft;

class SuretyBondController extends Controller
{
    public function index(Request $request,?Branch $regional = null, ?Branch $branch = null)
    {
        if($request->ajax()){
            if (request()->routeIs('regional.*')) $action = 'datatables.actions-show';
            elseif (request()->routeIs('branch.*')) $action = 'datatables.actions-products';

            $data = SuretyBond::with('insurance_status','insurance_status.status','principal')->select('surety_bonds.*')
            ->whereIn('branch_id',($branch ? [$branch->id] : Branch::where('regional_id',$regional->id)->pluck('id')->toArray()));
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('insurance_value', fn($sb) => Sirius::toRupiah($sb->insurance_value))
            ->editColumn('created_date', fn($sb) => Sirius::toLongDate($sb->created_date))
            ->editColumn('insurance_status.status.name', 'datatables.status-surety-bond')
            ->editColumn('action', $action)
            ->rawColumns(['insurance_status.status.name', 'action'])
            ->toJson();
        }
        $count_draft = count(SuretyBondDraft::where('approved_status','Belum Disetujui')->get());
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        $statuses = (object)[
            'process' => [
                'input',
                'analisa asuransi',
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
        return view('product.surety-bonds',compact('scorings','statuses','count_draft'));
    }

    public function create()
    {
    }

    public function store(Branch $regional, Branch $branch, SuretyBondRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->validated();
            $params['branchId'] = $branch->id;
            SuretyBond::buat($params);
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

    public function showRegional(Branch $regional, SuretyBond $suretyBond)
    {
        return $this->show($regional, null, $suretyBond);
    }

    public function show(Branch $regional, ?Branch $branch, SuretyBond $suretyBond)
    {
        $suretyBond->principal;
        $suretyBond->obligee;
        $suretyBond->agent;
        $suretyBond->insurance;
        $suretyBond->insurance_type;
        $suretyBond->statuses;
        $suretyBond->scorings;
        $suretyBond->process_status->status;
        $suretyBond->insurance_status->status;
        $suretyBond->finance_status->status;

        $statusStyles = [];
        foreach ($suretyBond->statuses as $statuses) {
            $statuses->status;
            $statusStyles[$statuses->status->type][$statuses->status->name] = [
                'name' => SuretyBond::{"mapping". Str::title($statuses->status->type) ."StatusNames"}($statuses->status->name),
                'color' => SuretyBond::{"mapping". Str::title($statuses->status->type) ."StatusColors"}($statuses->status->name),
                'icon' => SuretyBond::{"mapping". Str::title($statuses->status->type) ."StatusIcons"}($statuses->status->name),
            ];
        }

        return response()->json($this->showResponse(array_merge($suretyBond->toArray(), [
            'status_style' => $statusStyles
        ])));
    }

    public function edit(SurestyBond $suretyBond)
    {
    }

    public function update(Branch $regional, Branch $branch, SuretyBond $suretyBond, SuretyBondRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->validated();
            $params['branchId'] = $branch->id;
            $suretyBond->ubah($params);
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

    public function destroy(Branch $regional, Branch $branch, SuretyBond $suretyBond)
    {
        try {
            DB::beginTransaction();
            $suretyBond->hapus();
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
    public function changeStatus(Branch $regional, Branch $branch, SuretyBond $suretyBond,Request $request){
        try {
            DB::beginTransaction();
            $suretyBond->ubahStatus($request->all());
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

    public function printScoreRegional(Branch $regional, SuretyBond $suretyBond)
    {
        return $this->printScore($regional, null, $suretyBond);
    }

    public function printScore(Branch $regional, ?Branch $branch, SuretyBond $suretyBond){
        $product = $suretyBond;
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

    public function print(Branch $regional, Branch $branch, SuretyBond $suretyBond){
        $suretyBond->principal;
        $suretyBond->obligee;
        $suretyBond->agent;
        $suretyBond->insurance;
        $suretyBond->insurance_type;
        $suretyBond->statuses;
        $suretyBond->scorings;
        $suretyBond->statuses;
        $suretyBond->process_status->status;
        $suretyBond->insurance_status->status;
        $suretyBond->finance_status->status;

        $suretyBond->contract_value_converted = Sirius::toRupiah($suretyBond->contract_value);
        $suretyBond->contract_value_in_text = strtoupper(Sirius::toRupiahInText($suretyBond->contract_value));
        $suretyBond->insurance_value_converted = Sirius::toRupiah($suretyBond->insurance_value);
        $suretyBond->insurance_value_in_text = strtoupper(Sirius::toRupiahInText($suretyBond->insurance_value));
        $suretyBond->service_charge_converted = Sirius::toRupiah($suretyBond->service_charge ?? 0);
        $suretyBond->service_charge_in_text = strtoupper(Sirius::toRupiahInText($suretyBond->service_charge ?? 0));
        $suretyBond->admin_charge_converted = Sirius::toRupiah($suretyBond->admin_charge ?? 0);
        $suretyBond->admin_charge_in_text = strtoupper(Sirius::toRupiahInText($suretyBond->admin_charge ?? 0));
        $suretyBond->total_charge_converted = Sirius::toRupiah($suretyBond->total_charge ?? 0);
        $suretyBond->total_charge_in_text = strtoupper(Sirius::toRupiahInText($suretyBond->total_charge ?? 0));
        $suretyBond->start_date_dmy = date('d/m/Y', strtotime($suretyBond->start_date));
        $suretyBond->end_date_dmy = date('d/m/Y', strtotime($suretyBond->end_date));
        $suretyBond->document_expired_at_dmy = date('d/m/Y', strtotime($suretyBond->document_expired_at));
        $suretyBond->today = date('d/m/Y');

        $now = 'surety';
        return view('product.print',compact('now','suretyBond'));
    }
    public function requestReceiptNumber(Branch $regional, Branch $branch){
        try {
            $response = $this->showResponse(SuretyBond::requestReceiptNumber(['branchId' => $branch->id]));
            $http_code = 200;
        } catch (Exception $e) {
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }
}
