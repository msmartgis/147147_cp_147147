<?php

namespace App\Http\Controllers;

use App\DCE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DCEController extends Controller
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

        $piece = new DCE();
        $piece->document = $request->piece_type;
        $piece->file_name = $fileNameToStore;
        if(isset($request->appelOffre_id))
        {
            $piece->appel_offre_id = $request->appelOffre_id;
        }
        $piece->save();
        return response()->json(array('piece' => $piece,'type_piece'=>'dce'));

    }

    public function deletePiece(Request $req)
    {
        $file_name = $req->file_name;
        $directory = $req->directory;
        $id =  $req->piece_id;
        $local_path = 'public/uploaded_files/appel_offres/';
       // unlink(storage_path($local_path.$req->ao.'/'.$file_name));
        Storage::disk('uploads')->delete('appel_offres/'.$req->ao.'/'.$file_name);
        $piece = DCE::find($id)->delete();
        //redirecting with success message
        return response()->json();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DCE  $dCE
     * @return \Illuminate\Http\Response
     */
    public function show(DCE $dCE)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DCE  $dCE
     * @return \Illuminate\Http\Response
     */
    public function edit(DCE $dCE)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DCE  $dCE
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DCE $dCE)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DCE  $dCE
     * @return \Illuminate\Http\Response
     */
    public function destroy(DCE $dCE)
    {
        //
    }
}
