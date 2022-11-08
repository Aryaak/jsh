<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function indexPrincipalToBranch(Request $request)
    {
        return view('payment.principal-to-branch');
    }
    public function indexRegionalToInsurance(Request $request)
    {
        return view('payment.regional-to-insurance');
    }

    public function calculate(Request $request){
        try {
            $response = $this->response('OK',true,['total' => Payment::fetch((object)$request->all())->payment['total_bill']]);
            $http_code = 200;
        } catch (Exception $e) {
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }
        return response()->json($response,$http_code);
    }
    public function tables(Request $request){
        $type = $request->type;
        $data = null;
        if($type == 'principal_to_branch'){
            $data = Payment::with('principal','branch')->whereType($type);
        }else if($type == 'branch_to_regional'){
            // $data = Payment::with('principal','branch')->whereType($type);
        }else if($type == 'regional_to_insurance'){
            $data = Payment::with('insurance','regional')->whereType($type);
        }else if($type == 'branch_to_agent'){
            // $data = Payment::with('principal','branch')->whereType($type);
        }
        return datatables()->of($data)
        ->addIndexColumn()
        ->editColumn('action', 'datatables.actions-show-delete')
        ->toJson();
    }


    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $agent = Payment::buat($request->all());
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

    public function show(Payment $payment)
    {
        $type = $payment->type;
        if($type == 'principal_to_branch'){
            $payment->principal;
            $payment->branch;
        }else if($type == 'branch_to_regional'){

        }else if($type == 'regional_to_insurance'){
            $payment->regional;
            $payment->insurance;
        }else if($type == 'branch_to_agent'){

        }

        return response()->json($this->showResponse($payment->toArray()));
    }

    public function edit(Payment $payment)
    {
    }

    public function update(Request $request, Payment $payment)
    {
    }

    public function destroy(Payment $payment)
    {
        try {
            DB::beginTransaction();
            $payment->hapus();
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
