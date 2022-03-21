<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function index(UploadRequest $request)
    {
        $token = $request->session()->get('token');
        $word = Str::slug($request->get("word"), '_');

        if ($request->hasFile('audio_data')) {
            $request->audio_data->storeAs('recordings/'.date('Y-m-d', time()), date('Ymd-His', time())."-".$token."-".$word.".wav");
        }
    }
}
