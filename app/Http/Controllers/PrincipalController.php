<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Principal;
use App\Models\Scoring;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Principal::with('city');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        $scorings = Scoring::whereNull('category')->get();
        return view('master.principal',compact('scorings'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            Principal::buat($request->all());
            DB::commit();
            $http_code = 200;
            $response = $this->storeResponse();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function show(Principal $principal)
    {
        $principal->city->province;
        return response()->json($this->showResponse($principal->toArray()));
    }

    public function edit(Principal $principal)
    {
    }

    public function update(Request $request, Principal $principal)
    {
        try {
            DB::beginTransaction();
            $principal->ubah($request->all());
            DB::commit();
            $http_code = 200;
            $response = $this->updateResponse();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }

    public function destroy(Principal $principal)
    {
        try {
            DB::beginTransaction();
            $principal->hapus();
            DB::commit();
            $http_code = 200;
            $response = $this->destroyResponse();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }
}
