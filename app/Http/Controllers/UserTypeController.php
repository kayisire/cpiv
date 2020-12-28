<?php

namespace App\Http\Controllers;
use App\Models\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller {
    public function index(){
        $userTypes = UserType::all();

        return view('admin.types', [
            'userTypes' => $userTypes
        ]);
    }

    public function store(){
        $userType = new UserType();
        $userType->name = request('name');
        $userType->description = request('desc');
        $userType->save();
        
        return redirect('/admin/types') -> with('msg','User Type Created Successfully!');
    }

 
}
