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
            'pic_url' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $project = new Project;
        $project->title = $request->title;
        // $project->pic_url = $request->pic_url;
        $project->description = $request->description;
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
                    ->select('projects.id', 'projects.title', 'projects.description', 'profiles.fullnames', 'users.email', 'profiles.phone', 'projects.isActive', 'projects.created_at')
                    ->where('projects.isActive', '!=', 0)
                    ->where('projects.isActive', '!=', 3)
                    ->get();

        return view('projects', [
            'projects' => $projects
        ]);
    }

    public function approve($id){
        $project = Project::find($id);
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
        $project = Project::find($id);
        return view('project', [
            'project' => $project
        ]);
    }
}
