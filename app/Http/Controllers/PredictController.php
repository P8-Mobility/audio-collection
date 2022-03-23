<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class PredictController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->missing('token'))
            $request->session()->put('token', Str::random(10));

        $agent = new Agent();
        $browser = $agent->browser();

        if(in_array($browser, ['Chrome', 'Edge', 'Safari']))
            return view('predict');

        return view('browser-support');
    }
}
