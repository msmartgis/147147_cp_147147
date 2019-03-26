<?php

namespace App\Http\Controllers;

use App\PointDesservi;
use App\PointDesserviCategorie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PointDesserviController extends Controller
{

    public function loadPoint(Request $request)
    {


        $categories = PointDesserviCategorie::all()->toArray();
        $type_point = $request->type;
        $points = PointDesserviCategorie::find($type_point)->point_desservis->toArray();
        return array('categories' => $categories, 'points' => $points);
        //return \response()->json(['categories' => $categories, 'points' => $points]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PointDesservi  $pointDesservi
     * @return \Illuminate\Http\Response
     */
    public function show(PointDesservi $pointDesservi)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PointDesservi  $pointDesservi
     * @return \Illuminate\Http\Response
     */
    public function edit(PointDesservi $pointDesservi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PointDesservi  $pointDesservi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PointDesservi $pointDesservi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PointDesservi  $pointDesservi
     * @return \Illuminate\Http\Response
     */
    public function destroy(PointDesservi $pointDesservi)
    {
        //
    }
}
