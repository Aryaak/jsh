<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploaderRequest;
use Illuminate\Http\Request;

class UploaderController extends Controller
{
    public function tinyMCE(UploaderRequest $request)
    {
        $path = public_path('images/content/');
        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');
        $name = time().'.'.$file->getClientOriginalExtension();
        $file->move($path, $name);

        return response()->json([
            'location' => asset('images/content').'/'.$name,
        ]);
    }
}
