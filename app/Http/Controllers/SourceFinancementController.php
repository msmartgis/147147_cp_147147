<?php

namespace App\Http\Controllers;

use App\Demande;
use App\SourceFinancement;
use Illuminate\Http\Request;

class SourceFinancementController extends Controller
{

    public function addSourceFinancement(Request $req)
    {
        $src = SourceFinancement::find($req->source_financement_id);

        if(isset($req->demande_id))
        {
            $src->demandes()->attach($req->demande_id, ['montant' => str_replace(',','',$req->montant) ]);
            return response()->json(array('src' => $src, 'montant' => str_replace(',','',$req->montant) , 'demande' => $req->demande_id));
        }

    }


    public function deleteSourceFinancement(Request $req)
    {
        $demande = Demande::find($req->demande_id);
        $demande->sourceFinancement()->detach($req->src_id);
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
     * @param  \App\SourceFinancement  $sourceFinancement
     * @return \Illuminate\Http\Response
     */
    public function show(SourceFinancement $sourceFinancement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SourceFinancement  $sourceFinancement
     * @return \Illuminate\Http\Response
     */
    public function edit(SourceFinancement $sourceFinancement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SourceFinancement  $sourceFinancement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SourceFinancement $sourceFinancement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SourceFinancement  $sourceFinancement
     * @return \Illuminate\Http\Response
     */
    public function destroy(SourceFinancement $sourceFinancement)
    {
        //
    }
}
