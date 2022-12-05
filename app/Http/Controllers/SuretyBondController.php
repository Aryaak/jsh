<?php

namespace App\Http\Controllers;

use App\Helpers\Sirius;
use App\Models\Branch;
use DB;
use Exception;
use App\Models\SuretyBond;
use App\Models\Scoring;
use Illuminate\Http\Request;
use App\Http\Requests\SuretyBondRequest;
use App\Models\SuretyBondDraft;

class SuretyBondController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            if (request()->routeIs('regional.*')) $action = 'datatables.actions-show';
            elseif (request()->routeIs('branch.*')) $action = 'datatables.actions-show-delete';

            $data = SuretyBond::with('insurance_status','insurance_status.status')->select('surety_bonds.*')->orderBy('created_at','desc');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('insurance_value', fn($sb) => Sirius::toRupiah($sb->insurance_value))
            ->editColumn('start_date', fn($sb) => Sirius::toLongDate($sb->start_date))
            ->editColumn('action', $action)
            ->toJson();
        }
        $count_draft = count(SuretyBondDraft::where('approved_status','Belum Disetujui')->get());
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
        foreach ($suretyBond->statuses as $statuses) {
            $statuses->status;
        }
        return response()->json($this->showResponse($suretyBond->toArray()));
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
            $response = $this->updateResponse();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }
}
