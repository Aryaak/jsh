<?php

namespace App\Http\Controllers;

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
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('expenses');
    }

    public function create()
    {
    }

    public function store(ExpensesRequest $request)
    {
        try {
            DB::beginTransaction();
            Expense::buat($request->validated());
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

    public function show(Branch $regional, Branch $cabang, Expense $expense)
    {
        return response()->json($this->showResponse($expense->toArray()));
    }

    public function edit(Expense $expense)
    {
    }

    public function update(Request $request, Expense $expense)
    {
        try {
            DB::beginTransaction();
            $expense->ubah($request->all());
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

    public function destroy(Expense $expense)
    {
        try {
            DB::beginTransaction();
            $expense->hapus();
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
