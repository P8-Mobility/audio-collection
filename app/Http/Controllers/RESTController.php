<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class RESTController extends Controller
{
    public function download(Request $request)
    {
        $from = $request->get("from", null);

        $zip = new ZipArchive();
        $fileCount = 0;
        $filename = "download.zip";
        $directories = Storage::directories("recordings");

        if ($zip->open(public_path($filename), ZipArchive::CREATE) === TRUE) {
            foreach ($directories AS $directory){
                $dirname = basename($directory);

                if(is_null($from) || $dirname >= $from){
                    $files = Storage::files($directory);

                    foreach ($files AS $file){
                        $zip->addFile(Storage::path($file), basename($file));
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
}
