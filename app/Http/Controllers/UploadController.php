<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index(UploadRequest $request)
    {
        $token = $request->session()->get('token');
        $word = $request->get("word");

        if ($request->hasFile('audio_data')) {
            $request->audio_data->storeAs('recordings', date('Ymd-His', time())."-".$token."-".$word.".wav");
        }
    }
}
