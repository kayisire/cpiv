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

class UserTypeController extends Controller {
    public function newType(){
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
        return view('newType', [
            'loggedIn' => $loggedIn,
        ]);
    }

    public function addType(REQUEST $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $type = new UserType;
        $type->name = $request->name;
        $type->description = $request->description;
        $type->isActive = 1;
        $type->save();

        return redirect('/accounts/types')->with('success','User Type Added Successfully');
    }

    public function activateType($id){
        $type = UserType::find($id);
        $type->isActive = 1;
        $type->save();

        return Redirect::back()->with('success','User Type Activated Successfully');
    }

    public function disableType($id){
        $type = UserType::find($id);
        $type->isActive = 0;
        $type->save();

        return Redirect::back()->with('success','User Type Disabled Successfully');
    }

    public function types(){
        $types = UserType::get();

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
        return view('types', [
            'loggedIn' => $loggedIn,
            'types' => $types
        ]);
    }
}
