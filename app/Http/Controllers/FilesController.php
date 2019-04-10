<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function fileDownload(Request $request)
    {
        $file_name = $request->file_name;
        $directory = $request->directory;
        $id =  $request->id;

        $local_path = 'local/uploaded_files/'.$directory.'/';
        return Storage::disk('local')->download($local_path.$id.'/'.$file_name);
    }
}
