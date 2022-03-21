<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class RESTController extends Controller
{
    public function download(Request $request)
    {
        $from = $request->input("from", null);
        $word = $request->input("word", null);
        $exclude = filter_var($request->input("exclude", 'false'), FILTER_VALIDATE_BOOLEAN);;
        $from_date = null;

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
                        if(!is_null($word)){
                            if(Str::endsWith($file, $word.".wav")){
                                if($exclude)
                                    continue;
                            }else{
                                if(!$exclude)
                                    continue;
                            }
                        }
                        
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
