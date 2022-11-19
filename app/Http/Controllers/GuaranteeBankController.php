<?php

namespace App\Http\Controllers;

use App\Helpers\Sirius;
use App\Models\Branch;
use DB;
use Exception;
use App\Models\Scoring;
use App\Models\GuaranteeBank;
use Illuminate\Http\Request;
use App\Http\Requests\GuaranteeBankRequest;

class GuaranteeBankController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            if (request()->routeIs('regional.*')) $action = 'datatables.actions-show';
            elseif (request()->routeIs('branch.*')) $action = 'datatables.actions-show-delete';

            $data = GuaranteeBank::with('insurance_status','insurance_status.status')->select('guarantee_banks.*')->orderBy('created_at','desc');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('insurance_value', fn($sb) => Sirius::toRupiah($sb->insurance_value))
            ->editColumn('start_date', fn($sb) => Sirius::toLongDate($sb->start_date))
            ->editColumn('action', $action)
            ->toJson();
        }
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        return view('product.guarantee-banks',compact('scorings'));
    }

    public function create()
    {
    }

    public function store(Branch $regional, Branch $branch, Request $request)
    {
        try {
            DB::beginTransaction();
            GuaranteeBank::buat($request->validated());
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
        foreach ($bankGaransi->statuses as $statuses) {
            $statuses->status;
        }
        return response()->json($this->showResponse($bankGaransi->toArray()));
    }

    public function edit(GuaranteeBank $bankGaransi)
    {
    }

    public function update(Branch $regional, Branch $branch, GuaranteeBank $bankGaransi, Request $request)
    {
        try {
            DB::beginTransaction();
            $bankGaransi->ubah($request->validated());
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
}
