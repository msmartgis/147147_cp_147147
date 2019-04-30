<?php

namespace App\Http\Controllers;

use App\DossierAdjiducataire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
class DossierAdjiducataireController extends Controller
{
    public function addPiece(Request $request)
    {
        $path_file = "";


        // Handle File Upload
        if ($request->hasFile('piece_upload')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('piece_upload')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('piece_upload')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image

                $path_file ="public/uploaded_files/appel_offres/".$request->appelOffre_id;


                $path = $request->file('piece_upload')->storeAs($path_file, $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $piece = new DossierAdjiducataire();
        $piece->document = $request->piece_type;
        $piece->file_name = $fileNameToStore;
        if(isset($request->appelOffre_id))
        {
            $piece->appel_offre_id = $request->appelOffre_id;
        }


        $piece->save();
        return response()->json(array('piece' => $piece,'type_piece'=>'dossier_adjiducataire'));


    }

    public function deletePiece(Request $req)
    {
        $file_name = $req->file_name;
        $directory = $req->directory;
        $id =  $req->piece_id;

        $local_path = 'public/uploaded_files/appel_offres/';
        //unlink($local_path.$id.'/'.$file_name);
        //File::disk('local')->delete($local_path.$id.'/'.$file_name);
        Storage::disk('local')->delete($local_path.$id.'/'.$file_name);

        $piece = DossierAdjiducataire::find($id)->delete();
        //redirecting with success message
        return response()->json();
    }
}
