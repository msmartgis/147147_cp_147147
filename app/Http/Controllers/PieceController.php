<?php

namespace App\Http\Controllers;

use App\Piece;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use response;

use Image;

class PieceController extends Controller
{
    public function addPiece(Request $request)
    {
        $path_file = "";
        // $this->validate($request, [
        //     'piece_upload' => 'required|max:1999'
        // ]);

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

    public function deletePiece(Request $req)
    {
        $file_name = $req->file_name;
        $directory = $req->directory;
        $id =  $req->file_id;
        $object_id = $req->object_id;

        Storage::disk('uploads')->delete($directory.'/'.$object_id.'/'.$file_name);
        $piece = Piece::find($id)->delete();
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
     * @param  \App\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function show(Piece $piece)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function edit(Piece $piece)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Piece $piece)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function destroy(Piece $piece)
    {
        Piece::find($piece)->delete();
         //redirecting with success message
        return "OK";
    }
}
