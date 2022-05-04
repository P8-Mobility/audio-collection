<?php

namespace App\Http\Controllers;

use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class RESTController extends Controller
{
    public function download(Request $request)
    {
        $from = $request->input("from", null);
        $word = $request->input("word", array());
        $from_date = null;

        if(!is_array($word))
            $word = explode(",", $word);

        if(!is_null($from))
            $from_date = intval(date('Ymd', strtotime($from)));

        $zip = new ZipArchive();
        $fileCount = 0;
        $filename = "download.zip";
        File::delete(public_path($filename));

        $directories = Storage::directories("recordings");

        if ($zip->open(public_path($filename), ZipArchive::CREATE) === TRUE) {
            foreach ($directories AS $directory){
                $dirname = basename($directory);
                $dir_date = intval(date('Ymd', strtotime($dirname)));

                if(is_null($from) || $dir_date >= $from_date){
                    $files = Storage::files($directory);

                    foreach ($files AS $file){
                        $baseFileName = basename($file);
                        Log::debug($baseFileName);
                        Log::debug(json_encode($word));

                        if(count($word) > 0){
                            $fileWord = substr(explode("-", $baseFileName)[3], 0, -4);

                            if(!in_array($fileWord, $word))
                                continue;
                        }

                        $zip->addFile(Storage::path($file), $baseFileName);
                    }
                }
            }

            $fileCount = $zip->count();
            $zip->close();

            if($fileCount > 0)
                return response()->download(public_path($filename));

            abort(204, "Nothing to download!");
        }
    }

    public function predict(Request $request)
    {
        if($request->hasFile("mediafile")){
            $name = time().$request->file('mediafile')->getFilename();
            $extension = $request->mediafile->extension();

            if(!in_array($extension, ['wav', 'mp4']))
                return response()->json(["status" => "FAILED", "message" => "File type not allowed... (Got: ".$extension.")"]);

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

    public function words(Request $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://92.205.62.104:8080/words",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
