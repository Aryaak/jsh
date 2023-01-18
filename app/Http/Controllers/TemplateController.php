<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplateRequest;
use DB;
use Exception;
use App\Models\Template;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Template::orderBy('created_at','desc')->get();
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('master.templates');
    }

    public function store(TemplateRequest $request)
    {
        try {
            DB::beginTransaction();
            Template::buatTemplate($request->all(), null);
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

    public function show(Template $template)
    {
        return response()->json($this->showResponse($template->toArray()));
    }

    public function update(TemplateRequest $request, Template $template)
    {
        try {
            DB::beginTransaction();
            $template->ubah($request->all());
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

    public function destroy(Template $template)
    {
        try {
            DB::beginTransaction();
            $template->hapus();
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
