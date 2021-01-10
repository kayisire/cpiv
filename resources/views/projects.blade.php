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
                            <a class="nav-link {{ Request::is(['projects/pending']) ? 'active' : null }}" href="/projects/pending">
                                <i class="fa fa-spinner mr-2"></i>
                                Pending Approval Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['projects/all']) ? 'active' : null }}" href="/projects/all">
                                <i class="fa fa-briefcase mr-2"></i>
                                All Projects
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
                            <th>Owner</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @if (count($projects))
                            @foreach ($projects as $project)
                            <tr>
                                <td>
                                    <a href="/projects/{{ $project->id }}/view">
                                        <img src="{{ asset('/img/placeholder.png') }}" alt="" width="75">
                                    </a>
                                </td>
                                <td>
                                    <a href="/projects/{{ $project->id }}/view" class="text-decoration-none">
                                        <span>{{ $project->title }}</span><br>
                                    </a>
                                    <small class="text-muted font-italic">Uploaded: <span class="font-weight-bolder">{{ \Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</span></small>
                                </td>
                                <td>
                                    <span>{{ $project->fullnames }}</span><br>
                                    <small>{{ $project->email }}</small><br>
                                    <small class="text-muted">{{ $project->phone }}</small>
                                </td>
                                @if(REQUEST::is('projects/pending'))
                                <td>
                                    <a href="/projects/{{ $project->id }}/approve" class="btn btn-sm btn-outline-success float-right my-1">
                                        <i class="fa fa-check"></i>
                                        <span class="d-none d-sm-inline ml-2">Approve Project</span>
                                    </a><br>
                                    <a href="/projects/{{ $project->id }}/suspend" class="btn btn-sm btn-outline-danger float-right my-1">
                                        <i class="fa fa-times"></i>
                                        <span class="d-none d-sm-inline ml-2">Suspend Project</span>
                                    </a><br>
                                    <a href="/projects/{{ $project->id }}/view" class="btn btn-sm btn-outline-primary float-right my-1">
                                        <i class="fa fa-eye"></i>
                                        <span class="d-none d-sm-inline ml-2">View Project</span>
                                    </a>
                                </td>
                                @else
                                <td>
                                    @if($project->isActive == 1)
                                        <span class="badge badge-pill badge-success">Approved</span>
                                    @elseif($project->isActive == 0)
                                        <span class="badge badge-pill badge-warning">Pending Review</span>
                                    @else
                                        <span class="badge badge-pill badge-danger">Suspended</span>
                                    @endif
                                </td>
                                @endif
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
