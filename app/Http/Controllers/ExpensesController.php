<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Http\Requests\ExpensesRequest;
use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Expenses::all();
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
            Expenses::buat($request->validated());
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

    public function show(Expenses $expenses)
    {
        dd($expenses);
        return response()->json($this->showResponse($expenses->toArray()));
    }

    public function edit(Expenses $expenses)
    {
    }

    public function update(Request $request, Expenses $expenses)
    {
        try {
            DB::beginTransaction();
            $expenses->ubah($request->all());
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

    public function destroy(Expenses $expenses)
    {
        try {
            DB::beginTransaction();
            $expenses->hapus();
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
