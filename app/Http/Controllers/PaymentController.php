<?php

namespace App\Http\Controllers;

use App\Helpers\Sirius;
use App\Models\Branch;
use DB;
use Exception;
use App\Models\Payment;
use App\Models\Payable;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function indexPrincipalToBranch(Request $request){
        return view('payment.principal-to-branch');
    }
    public function indexRegionalToInsurance(Request $request){
        return view('payment.regional-to-insurance');
    }
    public function indexBranchToAgent(Request $request){
        return view('payment.branch-to-agent');
    }
    public function indexBranchToRegional(Request $request){
        $payables = Payable::where('is_paid_off',false)->whereHas('payment',function($query){
            $query->where('branch_id',session()->get('branch')?->id);
        })->with('payment')->get();
        $payableTotal = Sirius::toRupiah($payables->sum('unpaid_total'),2);
        return view('payment.branch-to-regional',compact('payables','payableTotal'));
    }

    public function calculate(Request $request){
        try {
            $payment = Payment::fetch((object)$request->all());
            $totalBill = $payment->payment['total_bill'] ?? 0;
            $payable = Payment::calculatePayable(['branchId' => $request->branchId]) ?? 0;
            $totalPayment = $totalBill + $payable;
            $response = $this->response('OK',true,[
                'total_bill' => $totalBill,
                'total_bill_converted' => Sirius::toRupiah($totalBill, 2),
                'payable' => $payable,
                'payable_converted' => Sirius::toRupiah($payable, 2),
                'total_payment' => $totalPayment,
                'total_payment_converted' => Sirius::toRupiah($totalPayment, 2),
            ]);
            $http_code = 200;
        } catch (Exception $e) {
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }
        return response()->json($response,$http_code);
    }
    public function calculateToRegional(Branch $regional, Branch $branch,Request $request){
        $request->merge(['branchId' => $branch->id,'regionalId' => $regional->id]);
        return $this->calculate($request);
    }
    public function tables(Request $request){
        $type = $request->type;
        $data = null;
        if($type == 'principal_to_branch'){
            $data = Payment::with('principal','branch')->select('payments.*')->where('branch_id', session()->get('branch')?->id)->whereType($type)->orderBy('created_at','desc');
        }else if($type == 'branch_to_regional'){
            $data = Payment::with('principal','branch')->where('branch_id', session()->get('branch')?->id)->whereType($type);
        }else if($type == 'regional_to_insurance'){
            $data = Payment::with('insurance','regional')->select('payments.*')->where('regional_id', session()->get('regional')?->id)->whereType($type)->orderBy('created_at','desc');
        }else if($type == 'branch_to_agent'){
            $data = Payment::with('branch','agent')->select('payments.*')->where('branch_id', session()->get('branch')?->id)->whereType($type)->orderBy('created_at','desc');
        }
        return datatables()->of($data)
        ->addIndexColumn()
        ->editColumn('paid_at', fn($payment) => Sirius::toLongDate($payment->paid_at))
        ->editColumn('total_bill', fn($payment) => Sirius::toRupiah($payment->total_bill, 2))
        ->editColumn('paid_bill', fn($payment) => Sirius::toRupiah($payment->paid_bill, 2))
        ->editColumn('unpaid_bill', fn($payment) => Sirius::toRupiah($payment->unpaid_bill, 2))
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
            Payment::buat($request->all());
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
    public function storeToRegional(Branch $regional, Branch $branch, Request $request)
    {
        $request->merge(['branchId' => $branch->id,'regionalId' => $regional->id]);
        return $this->store($request);
    }

    public function show(Payment $payment)
    {
        $type = $payment->type;
        if($type == 'principal_to_branch'){
            $payment->principal;
            $payment->branch;
        }else if($type == 'branch_to_regional'){
            $payment->branch;
            $payment->regional;
        }else if($type == 'regional_to_insurance'){
            $payment->regional;
            $payment->insurance;
        }else if($type == 'branch_to_agent'){
            $payment->branch;
            $payment->agent;
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
