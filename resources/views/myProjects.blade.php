@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Manage Projects</div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['projects']) ? 'active' : null }}" href="/projects">
                                <i class="fa fa-briefcase mr-2"></i>
                                View All My Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['projects/new']) ? 'active' : null }}" href="/projects/new">
                                <i class="fa fa-plus-circle mr-2"></i>
                                Add New Project
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Projects</div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <table class="table table-hover">
                        <thead>
                            <th></th>
                            <th>Project Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @if (count($projects))
                            @foreach ($projects as $project)
                            <tr>
                                <td>
                                    <a href="/projects/{{ $project->id }}/view">
                                        <img src="{{ $project->pic_url }}" alt="" width="75">
                                    </a>
                                </td>
                                <td>
                                    <a href="/projects/{{ $project->id }}/view" class="text-decoration-none">
                                        {{ $project->title }}
                                    </a>
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($project->description, $limit = 150, $end = '...') }}</td>
                                <td>
                                    @if($project->isActive == 1)
                                        <span class="badge badge-pill badge-success">Approved</span>
                                    @elseif($project->isActive == 0)
                                        <span class="badge badge-pill badge-warning">Pending Review</span>
                                    @else
                                        <span class="badge badge-pill badge-danger">Suspended</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="/projects/{{ $project->id }}/delete" class="btn btn-sm btn-outline-danger float-right my-1">
                                        <i class="fa fa-times"></i>
                                        <span class="d-none d-sm-inline ml-2">Delete Project</span>
                                    </a><br>
                                    <a href="/projects/{{ $project->id }}/view" class="btn btn-sm btn-outline-primary float-right my-1">
                                        <i class="fa fa-eye"></i>
                                        <span class="d-none d-sm-inline ml-2">View Project</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="font-weight-bolder text-center">
                                    No Record Available
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
