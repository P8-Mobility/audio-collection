<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->session()->get('token');

        if ($request->hasFile('audio_data')) {
            $request->audio_data->storeAs('recordings', date('Ymd-His', time())."-".$token.".wav");
        }
    }
}
