<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use Auth;
use Redirect;
use Validator;

use App\Models\User;
use App\Models\Profile;

class ProfileController extends Controller {
    public function index(){
        $profile = Profile::where('users_id', Auth::user()->id)->first();
        if(!$profile){
            return view('profile', [
                "fullnames" => "",
                "nid" => "",
                "tin" => "",
                "phone" => "",
                "gender" => "",
                "address" => "",
            ]);
        }

        return view('profile', [
            "fullnames" => $profile->fullnames,
            "nid" => $profile->nid,
            "tin" => $profile->tin,
            "phone" => $profile->phone,
            "gender" => $profile->gender,
            "address" => $profile->address
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'fullnames' => 'required',
            'nid' => 'required',
            'tin' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required'
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $profile = Profile::where('users_id', Auth::user()->id)->first();
        if(!$profile){
            $profile = new Profile;
            $profile->fullnames = $request->fullnames;
            $profile->nid = $request->nid;
            $profile->tin = $request->tin;
            $profile->phone = $request->phone;
            $profile->gender = $request->gender;
            $profile->address = $request->address;
            $profile->status = 1;
            $profile->users_id = Auth::user()->id;
            $profile->isActive = 1;
            $profile->save();
        } else {
            $profile->fullnames = $request->fullnames;
            $profile->nid = $request->nid;
            $profile->tin = $request->tin;
            $profile->phone = $request->phone;
            $profile->gender = $request->gender;
            $profile->address = $request->address;
            $profile->status = 1;
            $profile->users_id = Auth::user()->id;
            $profile->isActive = 1;
            $profile->save();
        }

        return Redirect::back()->with('success','Changes Saved Successfully');
    }
}
