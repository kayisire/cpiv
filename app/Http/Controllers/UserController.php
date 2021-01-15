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

        $loggedIn = DB::table('users')
                        ->join('user_by_types', 'user_by_types.user_id', 'users.id')
                        ->select('users.id', 'user_by_types.user_type_id')
                        ->where('users.id', Auth::user()->id)
                        ->get();
        $loggedIn->administrator = false;
        $loggedIn->project = false;
        $loggedIn->investor = false;
        $loggedIn->RHA = false;
        $loggedIn->RDB = false;
        foreach ($loggedIn as $key => $value) {
            if($value->user_type_id == "1") {
                $loggedIn->administrator = true;
            }
            if($value->user_type_id == "2") {
                $loggedIn->project = true;
            }
            if($value->user_type_id == "3") {
                $loggedIn->investor = true;
            }
            if($value->user_type_id == "4") {
                $loggedIn->RHA = true;
            }
            if($value->user_type_id == "5") {
                $loggedIn->RDB = true;
            }
        }
        return view("accounts", [
            'loggedIn' => $loggedIn,
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
