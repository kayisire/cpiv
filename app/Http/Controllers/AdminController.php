<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Profile;
use App\Charts\Analytics;

class AdminController extends Controller {
    public function welcome() {
        return view('welcome');
    }

    public function index() {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        if(!$profile){
            return redirect('profile');
        }

        $analytics = new Analytics;
        $analytics->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $analytics->dataset('User Acquisition', 'line', [1, 2, 3, 4, 1, 2, 3, 4, 1, 2, 3, 4, 1, 2, 3, 4]);

        $analytics2 = new Analytics;
        $analytics2->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $analytics2->dataset('Project Creation', 'bar', [1, 2, 3, 4, 1, 2, 3, 4, 1, 2, 3, 4, 1, 2, 3, 4]);

        return view('home', [
            'investors' => 80,
            'owners' => 134,
            'projects' => 50,
            'analytics' => $analytics,
            'analytics2' => $analytics2
        ]);
    }
}
