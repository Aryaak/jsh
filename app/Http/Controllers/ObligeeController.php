<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObligeeRequest;
use DB;
use Exception;
use App\Models\Obligee;
use Illuminate\Http\Request;

class ObligeeController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Obligee::with('city')->orderBy('created_at','desc');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-sync-show-delete')
            ->toJson();
        }
        $types = Obligee::types();
        return view('master.obligees',compact('types'));
    }

    public function create()
    {
    }

    public function store(ObligeeRequest $request)
    {
        try {
            DB::beginTransaction();
            $agent = Obligee::buat($request->validated());
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

    public function show(Obligee $obligee)
    {
        if(isset($obligee->city->province)) $obligee->city->province;
        return response()->json($this->showResponse($obligee->toArray()));
    }

    public function edit(Obligee $obligee)
    {
    }

    public function update(Request $request, Obligee $obligee)
    {
        try {
            DB::beginTransaction();
            $obligee->ubah($request->all());
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

    public function destroy(Obligee $obligee)
    {
        try {
            DB::beginTransaction();
            $obligee->hapus();
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
    public function sync(Obligee $obligee)
    {
        try {
            DB::beginTransaction();
            $obligee->sync();
            $http_code = 200;
            $response = $this->response("Sinkron obligee berhasil!");
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function jamsyar()
    {
        try {
            DB::beginTransaction();
            Obligee::jamsyar();
            $http_code = 200;
            $response = $this->response("Sinkron dengan Jamsyar berhasil!");
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }
}
