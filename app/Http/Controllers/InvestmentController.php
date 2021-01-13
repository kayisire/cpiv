<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use Auth;
use Redirect;
use Validator;

use App\Models\Investment;
use App\Models\User;
use App\Models\UserByType;
use App\Models\Profile;
use App\Models\Project;

class InvestmentController extends Controller {
    public function all() {
        $projects = DB::table('projects')
                    ->join('profiles', 'projects.user_id', 'profiles.user_id')
                    ->join('users', 'profiles.user_id', 'users.id')
                    ->select('projects.*', 'profiles.fullnames', 'users.email', 'profiles.phone')
                    ->where('projects.isActive', 1)
                    ->get();

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
        return view('investProjects', [
            'loggedIn' => $loggedIn,
            'projects' => $projects
        ]);
    }

    public function new($id) {
        $project = DB::table('projects')
                    ->join('profiles', 'projects.user_id', 'profiles.user_id')
                    ->join('users', 'profiles.user_id', 'users.id')
                    ->select('projects.*', 'profiles.fullnames', 'users.email', 'profiles.phone')
                    ->where('projects.id', $id)
                    ->first();

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
        return view('investProject', [
            'loggedIn' => $loggedIn,
            'project' => $project
        ]);
    }

    public function makeNew(REQUEST $request) {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'notes' => 'required',
            'paymentDate' => 'required|date',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $investment = new Investment;
        $investment->amount = $request->amount;
        $investment->paymentDate = $request->paymentDate;
        $investment->notes = cloudinary()->uploadFile($request->file('notes')->getRealPath())->getSecurePath();
        $investment->project_id = $request->project;
        $investment->user_id = Auth::user()->id;
        $investment->isActive = 0;
        $investment->save();

        return redirect('/investments/my')->with('success','Investment Pledged Successfully');
    }

    public function my() {
        $investments = DB::table('investments')
                    ->join('projects', 'projects.id', 'investments.project_id')
                    ->select('investments.amount as invested', 'investments.paymentDate', 'investments.notes', 'investments.project_id', 'investments.user_id', 'investments.isActive as status', 'investments.created_at as investedOn', 'projects.*')
                    ->where('projects.user_id', Auth::user()->id)
                    ->get();

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
        return view('myInvestments', [
            'loggedIn' => $loggedIn,
            'investments' => $investments
        ]);
    }

    public function pending() {
        $investments = DB::table('investments')
                    ->join('projects', 'projects.id', 'investments.project_id')
                    ->join('users', 'users.id', 'investments.user_id')
                    ->join('profiles', 'profiles.user_id', 'users.id')
                    ->select('projects.*', 'investments.amount as invested', 'investments.paymentDate', 'investments.notes', 'investments.project_id', 'investments.user_id', 'investments.isActive as status', 'investments.created_at as investedOn', 'users.email', 'users.id', 'profiles.fullnames', 'profiles.phone')
                    ->where('investments.isActive', 0)
                    ->get();

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
        return view('approveInvestment', [
            'loggedIn' => $loggedIn,
            'investments' => $investments
        ]);
    }

    public function allMade() {
        $investments = DB::table('investments')
                    ->join('projects', 'projects.id', 'investments.project_id')
                    ->join('users', 'users.id', 'investments.user_id')
                    ->join('profiles', 'profiles.user_id', 'users.id')
                    ->select('projects.*', 'investments.amount as invested', 'investments.paymentDate', 'investments.notes', 'investments.project_id', 'investments.user_id', 'investments.isActive as status', 'investments.created_at as investedOn', 'users.email', 'users.id', 'profiles.fullnames', 'profiles.phone')
                    ->where('investments.isActive', '!=', 0)
                    ->where('investments.isActive', '!=', 3)
                    ->get();

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
        return view('approveInvestment', [
            'loggedIn' => $loggedIn,
            'investments' => $investments
        ]);
    }

    public function view($id) {
        $investment = DB::table('investments')
                    ->join('projects', 'projects.id', 'investments.project_id')
                    ->join('users', 'users.id', 'projects.user_id')
                    ->join('profiles', 'profiles.user_id', 'users.id')
                    ->select('projects.*', 'investments.amount as invested', 'investments.paymentDate', 'investments.notes', 'investments.project_id', 'investments.user_id', 'investments.isActive as status', 'investments.created_at as investedOn', 'users.email', 'users.id', 'profiles.fullnames', 'profiles.phone')
                    ->where('investments.id', $id)
                    ->first();

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
        return view('investmentDetails', [
            'loggedIn' => $loggedIn,
            'investment' => $investment
        ]);
    }

    public function approve($id) {
        $project = Investment::find($id);
        $project->isActive = 1;
        $project->save();

        return redirect('/investments/pending')->with('success','Investment Approved Successfully');
    }

    public function suspend($id) {
        $project = Investment::find($id);
        $project->isActive = 2;
        $project->save();

        return redirect('/investments/pending')->with('success','Investment Suspended Successfully');
    }

    public function delete($id) {
        $project = Investment::find($id);
        $project->isActive = 3;
        $project->save();

        return redirect('/investments/my')->with('success','Investment Deleted Successfully');
    }
}
