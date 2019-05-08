<?php

namespace App\Http\Controllers;

use App\Geometry;
use App\Http\Resources\GeometryResource;
use Illuminate\Http\Request;

class GeometryController extends Controller
{
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
     * @param  \App\Geometry  $geometry
     * @return \Illuminate\Http\Response
     */
    public function show(Geometry $geometry)
    {
        GeometryResource::withoutWrapping();
        return new GeometryResource($geometry);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Geometry  $geometry
     * @return \Illuminate\Http\Response
     */
    public function edit(Geometry $geometry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Geometry  $geometry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Geometry $geometry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Geometry  $geometry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Geometry $geometry)
    {
        //
    }
}
