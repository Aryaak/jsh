<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionalController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Branch::where('is_regional',true);
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-regional')
            ->toJson();
        }
        return view('regionals');
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

    public function show(Branch $regional)
    {
        $regional->regional;
        return response()->json($this->showResponse($regional->toArray()));
    }

    public function update(Request $request, $regional)
    {
        try {
            DB::beginTransaction();
            $regional->ubah($request->all());
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

    public function destroy(Branch $regional)
    {
        try {
            DB::beginTransaction();
            $regional->hapus();
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
