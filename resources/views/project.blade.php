@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <a href="/projects">
                        <i class="fa fa-chevron-left mr-2"></i>
                        All Projects
                    </a>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['projects/*/view']) ? 'active' : null }}" href="/accounts">
                                <i class="fa fa-briefcase mr-2"></i>
                                View Project Details
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">Project Title: <b>{{ \Illuminate\Support\Str::limit($project->title, $limit = 15, $end = '...') }}</b></span>
                    <span class="float-right">
                        @if($project->isActive == 1)
                            <span class="badge badge-pill badge-success">Approved</span>
                        @elseif($project->isActive == 0)
                            <span class="badge badge-pill badge-warning">Pending Review</span>
                        @else
                            <span class="badge badge-pill badge-danger">Suspended</span>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <img src="{{ asset('/img/placeholder.png') }}" class="mb-3">
                    <hr>
                    <h3 class="h3 font-weight-bold">{{ $project->title }}</h3>
                    <p><span class="font-weight-bold">Description: </span><br>{{ $project->description }}</p>
                    <p><span class="font-weight-bold">Owner: </span> You</p>
                    <p><span class="font-weight-bold">Uploaded: </span> {{ $project->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
