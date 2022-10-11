<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignController
{
    public function __invoke(Request $request, $page)
    {
        return view("designs.$page");
    }
}
