<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \App\Models\User::all();

	return response()->json(['status'=>'ok','data'=>$user],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $user = \App\Models\User::where('name', $request->get('name'))->count();
	    if ($user > 0) {
		    return response()->json(['status'=>'ko','message'=>'This user name already exists.'],200);    
	    } else {
		    $user = new \App\Models\User;
		    $user->name = $request->get('name');
		    $user->save();
		    return response()->json(['status'=>'ok','message'=>'User created succesfully','user_id'=>$user->id],200);
	    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    $user = \App\Models\User::find($id);
	    
	    if (empty($user))
		    return response()->json(['status'=>'ko','message'=>'User doesn´t exists'],200);
	    else {
		    $tot = $user->groups()->count();
		    if ($tot > 0)
			    return response()->json(['status'=>'ko','message'=>'Can´t delete this user. It has several groups'],200);
		    else {
			    $user->delete();
			    return response()->json(['status'=>'ok','message'=>'User deleted'],200);
		    }
	    }
    }
}
