<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use Auth;
use Redirect;
use Validator;

use App\Models\User;
use App\Models\UserByType;
use App\Models\Profile;
use App\Models\Project;

class ProjectController extends Controller {
    public function index(){
        $projects = Project::where('user_id', Auth::user()->id)
                        ->where('isActive', '!=', 3)
                        ->get();

        return view('myProjects', [
            'projects' => $projects
        ]);
    }

    public function new(){
        return view('newProject');
    }

    public function store(REQUEST $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'completionDate' => 'required|date',
            'pic_url' => 'required',
            'files' => 'required',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $project = new Project;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->amount = $request->amount;
        $project->completionDate = $request->completionDate;
        $project->pic_url = cloudinary()->upload($request->file('pic_url')->getRealPath())->getSecurePath();
        $project->files = cloudinary()->uploadFile($request->file('files')->getRealPath())->getSecurePath();
        $project->user_id = Auth::user()->id;
        $project->isActive = 0;
        $project->save();

        return redirect('/projects')->with('success','Project Added Successfully');
    }

    public function pending(){
        $projects = DB::table('projects')
                    ->join('profiles', 'projects.user_id', 'profiles.user_id')
                    ->join('users', 'profiles.user_id', 'users.id')
                    ->select('projects.id', 'projects.title', 'projects.description', 'profiles.fullnames', 'users.email', 'profiles.phone', 'projects.isActive', 'projects.created_at')
                    ->where('projects.isActive', 0)
                    ->get();

        return view('projects', [
            'projects' => $projects
        ]);
    }

    public function all(){
        $projects = DB::table('projects')
                    ->join('profiles', 'projects.user_id', 'profiles.user_id')
                    ->join('users', 'profiles.user_id', 'users.id')
                    ->select('projects.id', 'projects.title', 'projects.pic_url', 'projects.description', 'profiles.fullnames', 'users.email', 'profiles.phone', 'projects.isActive', 'projects.created_at')
                    ->where('projects.isActive', '!=', 0)
                    ->where('projects.isActive', '!=', 3)
                    ->get();

        return view('projects', [
            'projects' => $projects
        ]);
    }

    public function approve($id){
        $project = DB::table('projects')
                    ->join('profiles', 'projects.user_id', 'profiles.user_id')
                    ->join('users', 'profiles.user_id', 'users.id')
                    ->select('projects.*', 'profiles.fullnames', 'users.email', 'profiles.phone')
                    ->where('projects.id', $id)
                    ->first();

        return view('approveProject', [
            'project' => $project
        ]);
    }

    public function makeApprovement(REQUEST $request){
        $validator = Validator::make($request->all(), [
            'location1' => 'required',
            'location2' => 'required',
            'location3' => 'required',
            'signedDocument' => 'required',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $project = Project::find($request->project_id);
        $project->location1 = $request->location1;
        $project->location2 = $request->location2;
        $project->location3 = $request->location3;
        $project->signedDocument = cloudinary()->uploadFile($request->file('signedDocument')->getRealPath())->getSecurePath();
        $project->isActive = 1;
        $project->save();

        return redirect('/projects/pending')->with('success','Project Approved Successfully');
    }

    public function suspend($id){
        $project = Project::find($id);
        $project->isActive = 2;
        $project->save();

        return redirect('/projects/pending')->with('success','Project Suspended Successfully');
    }

    public function delete($id){
        $project = Project::find($id);
        $project->isActive = 3;
        $project->save();

        return redirect('/projects')->with('success','Project Deleted Successfully');
    }

    public function view($id){
        $project = DB::table('projects')
                    ->join('profiles', 'projects.user_id', 'profiles.user_id')
                    ->join('users', 'profiles.user_id', 'users.id')
                    ->select('projects.*', 'profiles.fullnames', 'users.email', 'profiles.phone')
                    ->where('projects.id', $id)
                    ->first();

        return view('project', [
            'project' => $project
        ]);
    }

    public function approveLocation($id, $location){
        $results = Project::find($id);
        $newLocation = null;

        switch ($location) {
            case '1':
                $newLocation = $results->location1;
                break;

            case '2':
                $newLocation = $results->location2;
                break;

            case '3':
                $newLocation = $results->location3;
                break;

            default:
                return redirect('/projects'.'/'.$id.'/view')->with('error','Something went wrong!');
                break;
        }

        $project = Project::find($id);
        $project->approvedLocation = $newLocation;
        $project->save();

        return redirect('/projects'.'/'.$id.'/view')->with('success','Location Updated Successfully');
    }
}
