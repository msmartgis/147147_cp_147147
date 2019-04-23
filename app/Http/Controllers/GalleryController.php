<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{

    public function addImage(Request $request)
    {

        $path_file = "";
        $this->validate($request, [
            'piece_upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

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
            if(isset($request->demande_id))
            {
                $path_file ="public/uploaded_files/demandes/".$request->demande_id;
                $path_file_t ="public/uploaded_files/demandes/thumbnail/".$request->demande_id;
            }

            if(isset($request->convention_id))
            {
                $path_file ="public/uploaded_files/conventions/".$request->convention_id;
            }

            $path = $request->file('piece_upload')->storeAs($path_file, $fileNameToStore);


        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $piece = new Piece;
        $piece->type = $request->piece_type;
        $piece->nom = $request->piece_nom;
        $piece->path = $fileNameToStore;
        if(isset($request->demande_id))
        {
            $piece->demande_id = $request->demande_id;
        }

        if(isset($request->convention_id))
        {
            $piece->convention_id = $request->convention_id;
        }

        $piece->save();
        return response()->json($piece);

    }

    // delete
    public function deleteImage(Request $request)
    {
        $path = $request->path;
        $convention_id = $request->id_convention;
        unlink(storage_path("app/public/uploaded_files/galleries/projets_partenaire/thumbnail/".$convention_id.'/'.$path));
        unlink(storage_path("app/public/uploaded_files/galleries/projets_partenaire/".$convention_id.'/'.$path));
        $gallery_img = Gallery::where('filename','=',$request->path)->delete();

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
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //
    }
}
