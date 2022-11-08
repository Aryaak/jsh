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
        if($request->ajax()){
            try {
                $response = $this->response('OK',true,['total' => Payment::fetch((object)$request->all())->payment['total_bill']]);
                $http_code = 200;
            } catch (Exception $e) {
                $http_code = $this->httpErrorCode($e->getCode());
                $response = $this->errorResponse($e->getMessage());
            }
            return response()->json($response,$http_code);
        }
        return view('payment.principal-to-branch');
    }

    public function tables(){
        $data = Payment::with('principal','branch');
        return datatables()->of($data)
        ->addIndexColumn()
        ->editColumn('action', 'datatables.actions-delete')
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
        $payment->principal;
        $payment->branch;
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
