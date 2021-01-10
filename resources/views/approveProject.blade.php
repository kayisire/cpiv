@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <a href="/projects/pending">
                        <i class="fa fa-chevron-left mr-2"></i>
                        Pending Approval Projects
                    </a>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['projects/*/approve']) ? 'active' : null }}" href="#">
                                <i class="fa fa-user-tag mr-2"></i>
                                Approve Project
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
                    <p>
                        <span class="font-weight-bold">Owner: </span><br>
                        <span>
                            <span class="h5">{{ $project->fullnames }}</span><br>
                            <span class="h6 text-muted">{{ $project->email }}</span><br>
                            <small class="text-muted">{{ $project->phone }}</small>
                        </span>
                    </p>
                    <p>
                        <span class="font-weight-bold">Uploaded: </span> {{ \Carbon\Carbon::parse($project->created_at)->diffForHumans() }}
                    </p>
                    <hr>
                    <h4 class="h4">Authenticated Area</h4>
                    <p class="pb-3"><span class="font-weight-bolder">Note:</span> For approval of the project, you have to upload the signed document and propose three options for location of the investment.</p>
                    <form action="{{ route('approveProject') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="signedDocument" class="col-md-3 col-form-label text-md-right">Signed Document <br><small class="text-muted">(in PDF)</small></label>
                            <div class="col-md-9">
                                <input id="signedDocument" type="file" accept="application/pdf" class="form-control @error('signedDocument') is-invalid @enderror" name="signedDocument" value="{{ old('signedDocument') }}" required>
                                <input type="hidden" value="{{ $project->id }}" name="project_id">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="location1" class="col-md-3 col-form-label text-md-right">Location 1 <br><small class="text-muted">(UPI #)</small></label>
                            <div class="col-md-9">
                                <input id="location1" type="text" class="form-control @error('location1') is-invalid @enderror" name="location1" value="{{ old('location1') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="location2" class="col-md-3 col-form-label text-md-right">Location 2 <br><small class="text-muted">(UPI #)</small></label>
                            <div class="col-md-9">
                                <input id="location2" type="text" class="form-control @error('location2') is-invalid @enderror" name="location2" value="{{ old('location2') }}" required>
                                <input type="hidden" value="{{ $project->id }}" name="project_id">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="location3" class="col-md-3 col-form-label text-md-right">Location 3 <br><small class="text-muted">(UPI #)</small></label>
                            <div class="col-md-9">
                                <input id="location3" type="text" class="form-control @error('location3') is-invalid @enderror" name="location3" value="{{ old('location3') }}" required>
                                <input type="hidden" value="{{ $project->id }}" name="project_id">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    Approve Project
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
