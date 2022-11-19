<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\BranchRequest;
use Barryvdh\Debugbar\Facades\Debugbar;

class BranchController extends Controller
{
    public function index(Branch $regional, Request $request)
    {
        if($request->ajax()){
            $data = Branch::with('regional')->select('branches.*')->where('is_regional', false)->where('regional_id', $regional->id)->orderBy('created_at','desc');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-branch')
            ->toJson();
        }
        return view('branches');
    }

    public function store(Branch $regional, BranchRequest $request)
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

    public function show(Branch $regional, Branch $cabang)
    {
        $cabang->regional;
        return response()->json($this->showResponse($cabang->toArray()));
    }

    public function update(Branch $regional, Branch $cabang, Request $request)
    {
        try {
            DB::beginTransaction();
            $cabang->ubah($request->all());
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

    public function destroy(Branch $regional, Branch $cabang)
    {
        try {
            DB::beginTransaction();
            $cabang->hapus();
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
