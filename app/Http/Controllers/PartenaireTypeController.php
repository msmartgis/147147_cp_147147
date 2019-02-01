<?php

namespace App\Http\Controllers;

use App\PartenaireType;
use App\Demande;
use Illuminate\Http\Request;


class PartenaireTypeController extends Controller
{

    public function addPartenaire(Request $req)
    {
        //$part = new PartenaireType;
        $part = PartenaireType::find($req->partnenaire_type_id);
        $pourcentage = $req->montant / $req->montant_global;
        $part->demandes()->attach($req->demande_id, ['montant' => $req->montant, 'pourcentage' => $pourcentage]);
        return response()->json(array('part' => $part, 'montant' => $req->montant, 'pourcentage' => $pourcentage, 'demande' => $req->demande_id));

    }
    public function deletePartenaire(Request $req)
    {
        $demande = Demande::find($req->demande_id);
        $demande->partenaires()->detach($req->partenaire_id);
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
     * @param  \App\PartenaireType  $partenaireType
     * @return \Illuminate\Http\Response
     */
    public function show(PartenaireType $partenaireType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PartenaireType  $partenaireType
     * @return \Illuminate\Http\Response
     */
    public function edit(PartenaireType $partenaireType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PartenaireType  $partenaireType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartenaireType $partenaireType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PartenaireType  $partenaireType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartenaireType $partenaireType)
    {
        //
    }
}
