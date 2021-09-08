<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    /**
     * Assign a user to a group
     *
     * @param  int  $user_id
     * @param  int  $group_id
     * @return \Illuminate\Http\Response
     */
    public function update($user_id, $group_id)
    {
	    $group = \App\Models\Group::find($group_id);
	    if (empty($group)) {
		    return response()->json(['status'=>'ko','message'=>'Group doesn´t exists'],200);    
	    } else {
		    $user = $group->users()->find($user_id);
		    if (empty($user)) {
			    $myuser = \App\Models\User::find($user_id);
			    if($group->users()->save($myuser))
				    return response()->json(['status'=>'ok','message'=>'User added to the group'],200);
			    else
				    return response()->json(['status'=>'ko','message'=>'Error while adding user to the group'],200);
		    } else
			    return response()->json(['status'=>'ko','message'=>'User already exists in the group'],200);
	    }
    }

    /**
     * Remove a user from a group
     *
     * @param  int  $user_id
     * @param  int  $group_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $group_id)
    {
	    $group = \App\Models\Group::find($group_id);
	    if (empty($group)) {
		    return response()->json(['status'=>'ko','message'=>'Group doesn´t exists'],200);    
	    } else {
		    $user = $group->users()->find($user_id);
		    if (empty($user))
			    return response()->json(['status'=>'ko','message'=>'User doesn´t exists in the group'],200);
		    else {
			    $myuser = \App\Models\User::find($user_id);
			    if($group->users()->detach($myuser))
				    return response()->json(['status'=>'ok','message'=>'User removed from the group'],200);
			    else
				    return response()->json(['status'=>'ko','message'=>'Error while removing user from the group'],200);
		    }
	    }
    }
}
