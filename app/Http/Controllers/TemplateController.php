<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Template::all();
            return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', 'datatables.actions-show-delete')
            ->toJson();
        }
        return view('master.templates');
    }

    public function store(Request $request)
    {
    }

    public function show(Template $template)
    {
        return response()->json($this->showResponse($template->toArray()));
    }

    public function update(Request $request, Template $template)
    {
    }

    public function destroy(Template $template)
    {
    }
}
