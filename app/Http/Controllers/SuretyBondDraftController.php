<?php

namespace App\Http\Controllers;

use App\Models\SuretyBondDraft;
use Illuminate\Http\Request;
use App\Models\Scoring;
use App\Helpers\Sirius;
use App\Models\Branch;
use DB;
use Exception;
use App\Http\Requests\SuretyBondRequest;

class SuretyBondDraftController extends Controller
{
    public function index()
    {

    }

    public function indexClient()
    {
        $scorings = Scoring::whereNotNull('category')->with('details')->get();
        return view('surety-bonds-client',compact('scorings'));
    }

    public function storeClient(SuretyBondRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->validated();
            SuretyBondDraft::buat($params);
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

    public function store(Branch $branch, SuretyBondRequest $request)
    {

    }

    public function show(SuretyBondDraft $suretyBondDraft)
    {
    }

    public function edit(SuretyBondDraft $suretyBondDraft)
    {
    }

    public function update(Request $request, SuretyBondDraft $suretyBondDraft)
    {
    }

    public function destroy(SuretyBondDraft $suretyBondDraft)
    {
    }
}
