<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Scoring;
use App\Models\Principal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PrincipalRequest;

class PrincipalController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Principal::with('city')->select('principals.*')->orderBy('created_at','desc');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('score', 'datatables.score-principal')
            ->editColumn('action', 'datatables.actions-sync-show-delete')
            ->rawColumns(['score', 'action'])
            ->toJson();
        }
        $scorings = Scoring::whereNull('category')->get();
        return view('master.principal',compact('scorings'));
    }

    public function create()
    {
    }

    public function store(PrincipalRequest $request)
    {
        try {
            DB::beginTransaction();
            Principal::buat($request->all());
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

    public function show(Principal $principal)
    {
        if(isset($principal->city->province)) $principal->city->province;
        $principal->scorings;
        $principal->certificates;
        $principal->score = Str::replace('.', ',', $principal->score);
        return response()->json($this->showResponse($principal->toArray()));
    }

    public function edit(Principal $principal)
    {
    }

    public function update(PrincipalRequest $request, Principal $principal)
    {
        try {
            DB::beginTransaction();
            $principal->ubah($request->all());
            $http_code = 200;
            $response = $this->updateResponse();
            DB::commit();
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
    public function sync(Principal $principal)
    {
        try {
            DB::beginTransaction();
            $principal->sync();
            $http_code = 200;
            $response = $this->response("Sinkron principal berhasil!");
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $http_code = $this->httpErrorCode($e->getCode());
            $response = $this->errorResponse($e->getMessage());
        }

        return response()->json($response, $http_code);
    }
}
