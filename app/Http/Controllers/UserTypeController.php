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
        return view('newType');
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
        return view('types', [
            'types' => $types
        ]);
    }
}
