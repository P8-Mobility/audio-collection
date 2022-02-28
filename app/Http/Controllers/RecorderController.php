<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RecorderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->missing('token'))
            $request->session()->put('token', Str::random(10));

        return view('recording');
    }
}
