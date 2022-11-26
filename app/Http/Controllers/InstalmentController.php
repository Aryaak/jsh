<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Branch;
use App\Helpers\Sirius;
use App\Models\Payable;
use App\Models\Instalment;
use Illuminate\Http\Request;

class InstalmentController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Instalment::query();
            // dd($data->get());
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('paid_at', fn($payment) => Sirius::toLongDate($payment->paid_at))
            ->editColumn('nominal', fn($payment) => Sirius::toRupiah($payment->nominal, 2))
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('payment.branch-to-regional');
    }

    public function create()
    {
    }

    public function store(Branch $regional, ?Branch $branch,Request $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->all();
            $params['branchId'] = $branch->id;
            Instalment::buat($params);
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

    public function show(Instalment $instalment)
    {
    }

    public function edit(Instalment $instalment)
    {
    }

    public function update(Request $request, Instalment $instalment)
    {
    }

    public function destroy(Branch $regional, ?Branch $branch, Instalment $instalment)
    {
        try {
            DB::beginTransaction();
            $instalment->hapus();
            DB::commit();
            $http_code = 200;
            $response = $this->destroyResponse();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function calculate(Branch $regional, ?Branch $branch,Request $request){
        $params = $request->all();
        $params['branchId'] = $branch->id;
        $payable_total = Payable::calculate(($params));
        return response()->json($this->showResponse([
            'payable_total' => $payable_total,
            'payable_total_converted' => Sirius::toRupiah($payable_total, 2)
        ]));
    }
    public function payable(Branch $regional, ?Branch $branch,Request $request){
        $params = $request->all();
        $params['branchId'] = $branch->id;
        return response()->json($this->showResponse(Payable::index($params)));
    }
}
