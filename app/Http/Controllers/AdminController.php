<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserType;

class AdminController extends Controller {
    public function index() {
        return view('home');
    }
}
