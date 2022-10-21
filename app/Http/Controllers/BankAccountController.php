<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Http\Requests\BankAccountRequest;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store(BankAccountRequest $request)
    {
        try {
            DB::beginTransaction();
            BankAccount::buat($request->validated());
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

    public function show(BankAccount $bankAccount)
    {
    }

    public function edit(BankAccount $bankAccount)
    {
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
    }

    public function destroy(BankAccount $bankAccount)
    {
    }
}
