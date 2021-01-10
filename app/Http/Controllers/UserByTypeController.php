<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use Auth;
use Redirect;
use Validator;

use App\Models\User;
use App\Models\UserByType;
use App\Models\UserType;
use App\Models\Profile;

class UserByTypeController extends Controller {
    public function assignAccount($id){
        $user = DB::table('users')
                    ->join('profiles', 'users.id', 'profiles.user_id')
                    ->select('users.id', 'profiles.fullnames', 'users.email', 'profiles.phone', 'profiles.isActive')
                    ->where('users.id', $id)
                    ->first();

        $userTypesAssigned = DB::table('user_types')
                                ->join('user_by_types', 'user_types.id', 'user_by_types.user_type_id')
                                ->join('users', 'user_by_types.user_id', 'users.id')
                                ->select('user_by_types.id', 'user_types.name')
                                ->where('user_id', $user->id)->get();

        $userTypes = UserType::get();

        return view('assign', [
            'user' => $user,
            'types' => $userTypes,
            'userTypesAssigned' => $userTypesAssigned
        ]);
    }

    public function makeAssignAccount(REQUEST $request){
        $assignment = new UserByType();
        $assignment->user_id = $request->user_id;
        $assignment->user_type_id = $request->user_type_id;
        $assignment->save();

        return Redirect::back()->with('success','User Type Assigned Successfully');
    }

    public function removeAssignAccount($userId, $typeId){
        $assignment = UserByType::find($typeId);
        $assignment->delete();

        return Redirect::back()->with('success','User Type Removed Successfully');
    }
}
