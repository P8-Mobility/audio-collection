<?php

namespace App\Http\Controllers;

use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Log;

class PredictController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->missing('token'))
            $request->session()->put('token', Str::random(10));

        $agent = new Agent();
        $browser = $agent->browser();

        if(in_array($browser, ['Chrome', 'Edge', 'Safari'])){
            $models = $this->getModels();
            return view('predict', ['models' => $models]);
        }

        return view('browser-support');
    }

    public function predict(Request $request)
    {
        if($request->hasFile("mediafile")){
            $name = time().$request->file('mediafile')->getFilename();
            $extension = $request->mediafile->extension();

            if(!in_array($extension, ['wav', 'mp4']))
                abort(500, "File type not allowed...");

            $path = $request->mediafile->storeAs('predictions', $name.".".$extension);
            $the_file = new CURLFile(Storage::path($path));

            $headers = array(
                'Content-type: multipart/form-data'
            );

            $data = array(
                "file" => $the_file,
                "model" => $request->input("model", "")
            );

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://92.205.62.104:8080/predict",
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

            Storage::delete($path);

            return $response;
        }

        return "No file...";
    }

    private function getModels()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "http://92.205.62.104:8080/models");
        $result = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($result);

        if($obj->status == "OK")
            return $obj->result;

        return [];
    }
}
