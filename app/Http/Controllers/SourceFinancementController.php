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
        $src = new SourceFinancement();
        $src->source = $request->source;
        $src->reference = $request->reference;
        $src->montant_credit = $request->montant_credit;

        $src->save();


        if($src)
        {
            return redirect('/parametres')->with('success', 'Source de fincancement ajoutée avec succès');
        }
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


    public function update_src(Request $request)
    {
        $src_to_update = SourceFinancement::find($request->id);
        $src_to_update->source = $request->source;
        $src_to_update->reference = $request->reference;
        $src_to_update->montant_credit = $request->montant_credit;

        $src_to_update->save();
        return redirect("/parametres")->with('success', 'Modification a été éffectuer avec succès');
    }


    public function deleteSrcSetting(Request $req)
    {
        $src = SourceFinancement::find($req->id);
        $src->delete();
        return response()->json();
    }
}
