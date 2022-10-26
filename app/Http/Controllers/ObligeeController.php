<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Obligee;
use Illuminate\Http\Request;

class ObligeeController extends Controller
{
    public function index()
    {
        return view('master.obligees');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Obligee $obligee)
    {
    }

    public function edit(Obligee $obligee)
    {
    }

    public function update(Request $request, Obligee $obligee)
    {
    }

    public function destroy(Obligee $obligee)
    {
    }
}
