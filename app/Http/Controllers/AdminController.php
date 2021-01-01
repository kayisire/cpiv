<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Profile;

class AdminController extends Controller {
    public function welcome() {
        return view('welcome');
    }

    public function index() {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        if(!$profile){
            return redirect('profile');
        }
        return view('home');
    }
}
