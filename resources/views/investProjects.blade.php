@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Investments</div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['investments']) ? 'active' : null }}" href="/investments">
                                <i class="fa fa-briefcase mr-2"></i>
                                All Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['investments/my']) ? 'active' : null }}" href="/investments/my">
                                <i class="fa fa-money-bill-wave mr-2"></i>
                                My Investments
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
                            <th>Amount</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @if (count($projects))
                            @foreach ($projects as $project)
                            <tr>
                                <td>
                                    <a href="/investments/{{ $project->id }}/new">
                                        <img src="{{ $project->pic_url }}" alt="" width="75">
                                    </a>
                                </td>
                                <td>
                                    <a href="/investments/{{ $project->id }}/new" class="text-decoration-none">
                                        <span>{{ $project->title }}</span><br>
                                    </a>
                                    <small class="text-muted font-italic">Uploaded: <span class="font-weight-bolder">{{ \Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</span></small>
                                </td>
                                <td>
                                    <span>{{ $project->fullnames }}</span><br>
                                    <small>{{ $project->email }}</small><br>
                                    <small class="text-muted">{{ $project->phone }}</small>
                                </td>
                                <td>
                                    <span>{{ number_format($project->amount) }} Rwf</span><br>
                                </td>
                                <td>
                                    <a href="/investments/{{ $project->id }}/new" class="btn btn-sm btn-outline-primary float-right my-1">
                                        <i class="fa fa-eye"></i>
                                        <span class="d-none d-sm-inline ml-2">View Project</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="font-weight-bolder text-center">
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
