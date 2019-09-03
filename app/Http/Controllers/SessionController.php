<?php

namespace App\Http\Controllers;

use App\Session;
use Illuminate\Http\Request;
use Response;
class SessionController extends Controller
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
        $session = new Session();
        $session->mois = $request->mois;
        $session->type = $request->type;

        $date_to_time = strtotime(str_replace("/",'-',$request->date));
        $date_formatted = date('Y-m-d',$date_to_time);
        $session->date =  $date_formatted;

        $session->save();


        if($session)
        {
            return redirect('/parametres')->with('success', 'Session  ajoutée avec succès');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Session $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Session $session)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        //
    }



    public function update_session(Request $request)
    {
        $session_to_update = Session::find($request->id);
        $session_to_update->mois = $request->mois;
        $session_to_update->date = $request->date;
        $session_to_update->type = $request->type;

        $session_to_update->save();
        return redirect("/parametres")->with('success', 'Modification a été éffectuer avec succès');
    }


    public function deleteSession(Request $req)
    {
        $session = Session::find($req->id);
        $session->delete();
        return response()->json();
    }
}
