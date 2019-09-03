<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UsersController extends Controller
{
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
        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(60);
        $user->organisation_id = $request->organisation_id;
        $user->save();
        if($user)
        {
            return redirect('/parametres')->with('success', 'Utilisateur ajouté avec succès');
        }
    }


    public function update_user(Request $request)
    {
        $user_to_update = User::find($request->id);
        $user_to_update->username = $request->username;
        $user_to_update->password = $request->password;
        $user_to_update->first_name = $request->first_name;
        $user_to_update->last_name = $request->last_name;
        $user_to_update->organisation_id = $request->organisation_id;
        $user_to_update->save();
        return redirect("/parametres")->with('success', 'Modification a été éffectuer avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function deleteUser(Request $req)
    {
        $user = User::find($req->id);
        $user->delete();
        return response()->json();
    }



}
