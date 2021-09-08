<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = \App\Models\Group::all();

	return response()->json(['status'=>'ok','data'=>$groups],200);
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $group = \App\Models\Group::where('name', $request->get('name'))->count();
	    if ($group > 0) {
		    return response()->json(['status'=>'ko','message'=>'This group name already exists.'],200);    
	    } else {
		    $group = new \App\Models\Group;
		    $group->name = $request->get('name');
		    $group->save();
		    return response()->json(['status'=>'ok','message'=>'Group created succesfully','group_id'=>$group->id],200);
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
	    $group = \App\Models\Group::find($id);
	    
	    if (empty($group))
		    return response()->json(['status'=>'ko','message'=>'Group doesn´t exists'],200);
	    else {
		    $tot = $group->users()->count();
		    if ($tot > 0)
			    return response()->json(['status'=>'ko','message'=>'Can´t delete this group. It has several users'],200);
		    else {
			    $group->delete();
			    return response()->json(['status'=>'ok','message'=>'Group deleted'],200);
		    }
	    }
    }
}
