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
                    @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <img src="{{ $project->pic_url }}" alt="" width="500" class="mb-3">
                    <hr>
                    <h3 class="h3 font-weight-bold">{{ $project->title }}</h3>
                    <p>
                        <span class="font-weight-bold">Amount: </span><br>
                        <span class="h4 font-weight-bold">{{ number_format($project->amount) }} Rwf</span>
                    </p>
                    <p>
                        <span class="font-weight-bold">Description: </span><br>
                        <span class="h5">{{ $project->description }}</span>
                    </p>
                    <p>
                        <span class="font-weight-bold">Additional Document: </span><br>
                        <a href="{{ $project->files }}" class="btn btn-md btn-outline-primary">Download Files Here</a>
                    </p>
                    @if ($project->signedDocument)
                    <p>
                        <span class="font-weight-bold">Signed Document: </span><br>
                        <a href="{{ $project->signedDocument }}" class="btn btn-md btn-outline-primary">Download Files Here</a>
                    </p>
                    @endif
                    <p>
                        <span class="font-weight-bold">Owner: </span><br>
                        <span>{{ $project->fullnames }}</span><br>
                        <small>{{ $project->email }}</small><br>
                        <small class="text-muted">{{ $project->phone }}</small>
                    </p>
                    <p>
                        <span class="font-weight-bold">Uploaded: </span> {{ \Carbon\Carbon::parse($project->created_at)->diffForHumans() }}
                    </p>
                    @if ($project->approvedLocation)
                    <h6 class="h6 font-weight-bold">Selected Location:</h6>
                    <table class="table table-hover">
                        <thead>
                            <th>UPI Code #</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>{{ $project->approvedLocation }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                    @elseif($project->isActive == 1)
                    <h6 class="h6 font-weight-bold">Proposed Locations: <span class="badge badge-pill badge-warning">New</span></h6>
                    <table class="table table-hover">
                        <thead>
                            <th>UPI Code #</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>{{ $project->location1 }}</b></td>
                                <td>
                                    <a href="/projects/{{ $project->id }}/approve/1/location" class="btn btn-sm btn-outline-success float-right"><i class="fa fa-check"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><b>{{ $project->location2 }}</b></td>
                                <td>
                                    <a href="/projects/{{ $project->id }}/approve/2/location" class="btn btn-sm btn-outline-success float-right"><i class="fa fa-check"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><b>{{ $project->location3 }}</b></td>
                                <td>
                                    <a href="/projects/{{ $project->id }}/approve/3/location" class="btn btn-sm btn-outline-success float-right"><i class="fa fa-check"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                    @if(count($investments))
                    <hr>
                    <h3 class="h6 font-weight-bold">Investors Section:</h3>
                    <table class="table table-hover">
                        <thead>
                            <th>Investor Info</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($investments as $investment)
                            @if($investment->isActive != 99)
                            <tr>
                                <td>
                                    <span>{{ $investment->fullnames }}</span><br>
                                    <small>{{ $investment->email }}</small><br>
                                    <small class="text-muted">{{ $investment->phone }}</small>
                                </td>
                                <td>
                                    <b>{{ number_format($investment->amount) }} Rwf</b>
                                </td>
                                <td>{{ $investment->paymentDate }}</td>
                                @if($investment->isActive == 0)
                                <td>
                                    <a href="/investments/{{ $investment->id }}/approve" class="btn btn-sm btn-outline-success float-right mx-1">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    <a href="/investments/{{ $investment->id }}/suspend" class="btn btn-sm btn-outline-danger float-right mx-1">
                                        <i class="fa fa-times"></i>
                                    </a>
                                    <a href="/investments/{{ $investment->id }}/view" class="btn btn-sm btn-outline-primary float-right my-1">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                                @else
                                <td>
                                    @if($investment->isActive == 1)
                                        <span class="badge badge-pill badge-warning">Pending Review</span>
                                    @elseif($investment->isActive == 3)
                                        <span class="badge badge-pill badge-success">Approved by RDB</span>
                                    @else
                                        <span class="badge badge-pill badge-danger">Suspended</span>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
