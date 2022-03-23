<?php

namespace App\Http\Controllers;

use CURLFile;
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

    public function predict(Request $request)
    {
        if($request->hasFile("wav_file")){
            $wav_file = new CURLFile($request->wav_file->path(),'audio/wav');

            $headers = array(
                'Content-type: multipart/form-data'
            );

            $data = array(
                "file" => $wav_file
            );

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://100.75.4.76:8080/predict",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data
            ));

            // Set Header
            if (!empty($headers)) {
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            }

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        }
    }
}
