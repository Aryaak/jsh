<?php

namespace App\Http\Controllers;

use App\Helpers\Sirius;
use DB;
use Exception;
use App\Models\Expense;
use App\Models\Branch;
use App\Http\Requests\ExpensesRequest;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Expense::all();
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('transaction_date', fn($d) => Sirius::toLongDate($d->transaction_date))
            ->editColumn('nominal', fn($d) => Sirius::toRupiah($d->nominal))
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('expenses');
    }

    public function create()
    {
    }

    public function store(Branch $regional, ExpensesRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->validated();
            $params['nominal'] = str_replace('.','',$params['nominal']);
            $params['regional_id'] = $regional->id;
            Expense::buat($params);
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

    public function show(Branch $regional, Expense $pengeluaran)
    {
        $pengeluaran->transaction_date_converted = Sirius::toLongDate($pengeluaran->transaction_date);
        $pengeluaran->nominal_converted = Sirius::toRupiah($pengeluaran->nominal);
        return response()->json($this->showResponse($pengeluaran->toArray()));
    }

    public function edit(Expense $expense)
    {
    }

    public function update(Request $request, Expense $pengeluaran)
    {
        try {
            DB::beginTransaction();
            $pengeluaran->ubah($request->all());
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

    public function destroy(Branch $regional, Expense $pengeluaran)
    {
        try {
            DB::beginTransaction();
            $pengeluaran->hapus();
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
