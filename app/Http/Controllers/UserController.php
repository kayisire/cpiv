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

class UserController extends Controller {
    public function index(){
        $users = DB::table('users')
                    ->join('profiles', 'users.id', 'profiles.user_id')
                    ->select('users.id', 'profiles.fullnames', 'users.email', 'profiles.phone', 'profiles.isActive')
                    ->get();

        return view("accounts", [
            'users' => $users
        ]);
    }

    public function activateAccount($id){
        $type = Profile::where('user_id', $id)->first();
        $type->isActive = 1;
        $type->save();

        return Redirect::back()->with('success','User Activated Successfully');
    }

    public function disableAccount($id){
        $type = Profile::where('user_id', $id)->first();
        $type->isActive = 0;
        $type->save();

        return Redirect::back()->with('success','User Disabled Successfully');
    }
}
