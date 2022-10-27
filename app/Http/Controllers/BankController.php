<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Http\Requests\BankRequest;
use App\Models\Bank;
use App\Models\Template;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Bank::with('templates');
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('master.banks');
    }

    public function create()
    {
    }

    public function store(BankRequest $request)
    {
        try {
            DB::beginTransaction();
            $bank = Bank::buat($request->validated());
            Template::buat($request->validated(), $bank->id);
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

    public function show(Bank $bank)
    {
        $bank->templates;
        return response()->json($this->showResponse($bank->toArray()));
    }

    public function edit(Bank $bank)
    {
    }

    public function update(Request $request, Bank $bank)
    {
        try {
            DB::beginTransaction();
            $bank->ubah($request->all());
            $templates = $bank->templates;
            for($i = 0; $i < count($templates); $i++){
                $templates[$i]->ubah($request->all(),$i,$bank->id);
            }
            Template::buat($request->all(),$bank->id);
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

    public function destroy(Bank $bank)
    {
        try {
            DB::beginTransaction();
            $bank->hapus();
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
