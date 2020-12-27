<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserType;

class AdminController extends Controller
{
    public function index(){
        return view('admin.create_users');
    }

    public function store(){
        $typ= new UserType();
        $typ->name = request('name');
        $typ->description = request('desc');
        $typ->save();
        return view('admin.create_users');
           //return redirect('/') -> with('mssg','Thank you for buying');
       }
}
