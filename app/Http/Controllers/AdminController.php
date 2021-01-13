<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use Auth;
use Redirect;
use Validator;

use App\Models\User;
use App\Models\Profile;
use App\Charts\Analytics;

class AdminController extends Controller {
    public function welcome() {
        return view('welcome');
    }

    public function locked() {
        $loggedIn = DB::table('users')
                        ->join('user_by_types', 'user_by_types.user_id', 'users.id')
                        ->select('users.id', 'user_by_types.user_type_id')
                        ->get();
        $loggedIn->administrator = false;
        $loggedIn->project = false;
        $loggedIn->investor = false;
        $loggedIn->RHA = false;
        $loggedIn->RDB = false;
        return view('locked', [
            'loggedIn' => $loggedIn,
        ]);
    }

    public function index() {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        if(!$profile){
            return redirect('/projects');
        }

        $check = DB::table('users')
                        ->join('profile', 'profile.user_id', 'users.id')
                        ->select('users.id', 'profile.isActive')
                        ->first();
        if(!$check->isActive) {
            return redirect('/locked');
        }

        $analytics = new Analytics;
        $analytics->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $analytics->dataset('User Acquisition', 'line', [1, 2, 3, 4, 1, 2, 3, 4, 1, 2, 3, 4, 1, 2, 3, 4]);

        $analytics2 = new Analytics;
        $analytics2->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $analytics2->dataset('Project Creation', 'bar', [1, 2, 3, 4, 1, 2, 3, 4, 1, 2, 3, 4, 1, 2, 3, 4]);

        $loggedIn = DB::table('users')
                        ->join('user_by_types', 'user_by_types.user_id', 'users.id')
                        ->select('users.id', 'user_by_types.user_type_id')
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

        if($loggedIn->administrator) {
            return view('home', [
                'loggedIn' => $loggedIn,
                'investors' => 80,
                'owners' => 134,
                'projects' => 50,
                'analytics' => $analytics,
                'analytics2' => $analytics2
            ]);
        } else if($loggedIn->project) {
            return redirect('/projects');
        } else if($loggedIn->investor) {
            return redirect('/investments');
        } else if($loggedIn->RHA) {
            return redirect('/projects/pending');
        } else if($loggedIn->RDB) {
            return redirect('/investments/pending');
        }
    }
}
