<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Branch;
use App\Http\Requests\BranchRequest;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Branch::with('regional')->where('is_regional',false);
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('master.branches');
    }

    public function create()
    {
    }

    public function store(BranchRequest $request)
    {
        try {
            DB::beginTransaction();
            Branch::buat($request->validated());
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

    public function show(Branch $branch)
    {
        $branch->regional;
        return response()->json($this->showResponse($branch->toArray()));
    }

    public function edit(Branch $branch)
    {
    }

    public function update(Request $request, Branch $branch)
    {
        try {
            DB::beginTransaction();
            $branch->ubah($request->all());
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

    public function destroy(Branch $branch)
    {
        try {
            DB::beginTransaction();
            $branch->hapus();
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
