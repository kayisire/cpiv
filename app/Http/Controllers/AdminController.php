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
use Carbon\Carbon;
use Illuminate\Support\Arr;

class AdminController extends Controller {
    public function welcome() {
        return redirect('/login');
    }

    public function locked() {
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
        return view('locked', [
            'loggedIn' => $loggedIn,
        ]);
    }

    public function index() {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        if(!$profile){
            return redirect('/profile');
        }

        $check = DB::table('users')
                        ->join('profiles', 'profiles.user_id', 'users.id')
                        ->select('users.id', 'profiles.isActive')
                        ->first();
        if(!$check->isActive) {
            return redirect('/locked');
        }

        $ownners= DB::table('user_by_types')
                         ->where('user_type_id',2)
                         ->count();
        
        $innvestors= DB::table('user_by_types')
                         ->where('user_type_id',3)
                         ->count();
        
        $projjects= DB::table('projects')
                         ->count();

        $invv = DB::table('projects')
                    ->join('investments', 'projects.id', 'investments.project_id')
                    ->select('projects.id', 'projects.title', 'projects.amount', 'projects.isActive as projectStatus', DB::raw('sum(investments.amount) as investment'), 'investments.isActive', 'investments.project_id')
                    ->where('projects.isActive', 1)
                    ->where('investments.isActive', 3)
                    ->groupBy('investments.project_id')
                    ->get();
        
        $titles = array();
        $amount = array();
        $investments = array();
        for($a = 0; $a < count($invv); $a++){
            array_push($titles, $invv[$a]->title);
            array_push($amount, $invv[$a]->amount);
            array_push($investments, $invv[$a]->investment);
        }
        
        $analytics = new Analytics;
        $analytics->labels($titles);
        $analytics->dataset('Amount', 'bar', $amount);
        $analytics->dataset('Investment', 'bar', $investments);

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

        if($loggedIn->administrator) {
            return view('home', [
                'loggedIn' => $loggedIn,
                'investors' => $innvestors,
                'owners' => $ownners,
                'projects' => $projjects,
                'analytics' => $analytics
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
