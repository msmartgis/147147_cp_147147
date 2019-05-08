<?php

namespace App\Http\Controllers;

use App\Piste;
use Illuminate\Http\Request;
use App\Http\Resources\PisteRes as PisteResource;

class PisteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //get pistes
        $pistes = Piste::with('demande','convention','geometries')
            ->where('id','=',63)
            ->orWhere('id','=',66)
            ->orWhere('id','=',70)
            ->get();
        return PisteResource::collection($pistes);
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
     * @param  \App\Piste  $piste
     * @return \Illuminate\Http\Response
     */
    public function show(Piste $piste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Piste  $piste
     * @return \Illuminate\Http\Response
     */
    public function edit(Piste $piste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Piste  $piste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Piste $piste)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Piste  $piste
     * @return \Illuminate\Http\Response
     */
    public function destroy(Piste $piste)
    {
        //
    }
}
