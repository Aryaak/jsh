<?php

namespace App\Http\Controllers;

use DB;
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
    public function index(Request $request)
    {
        if($request->ajax()){
            if (request()->routeIs('regional.*')) $action = 'datatables.actions-show';
            elseif (request()->routeIs('branch.*')) $action = 'datatables.actions-products';

            $data = GuaranteeBank::with('insurance_status','insurance_status.status')->select('guarantee_banks.*')->orderBy('created_at','desc');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('insurance_value', fn($sb) => Sirius::toRupiah($sb->insurance_value))
            ->editColumn('start_date', fn($sb) => Sirius::toLongDate($sb->start_date))
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
        $bankGaransi->bank;
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
    public function printScore(Branch $regional, Branch $branch, GuaranteeBank $bankGaransi){
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        return view('product.pdf.score',compact('scorings'));
    }
}
