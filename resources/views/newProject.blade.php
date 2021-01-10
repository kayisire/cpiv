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
                <div class="card-header">Add New Project</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('projects') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="title" class="col-md-3 col-form-label text-md-right">Title</label>
                            <div class="col-md-9">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
                            <div class="col-md-9">
                                <textarea id="description" cols="30" rows="5" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-3 col-form-label text-md-right">Amount <br><small class="text-muted">(in RWF)</small></label>
                            <div class="col-md-9">
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required>
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="completionDate" class="col-md-3 col-form-label text-md-right">Completion Date</label>
                            <div class="col-md-9">
                                <input id="completionDate" type="date" class="form-control @error('completionDate') is-invalid @enderror" name="completionDate" value="{{ old('completionDate') }}" required>
                                @error('completionDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pic_url" class="col-md-3 col-form-label text-md-right">Picture <br><small class="text-muted">(in JPG, PNG)</small></label>
                            <div class="col-md-9">
                                <input id="pic_url" type="file" accept="image/*" class="form-control @error('pic_url') is-invalid @enderror" name="pic_url" value="{{ old('pic_url') }}" required>
                                @error('pic_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="files" class="col-md-3 col-form-label text-md-right">Additional Document <br><small class="text-muted">(in PDF)</small></label>
                            <div class="col-md-9">
                                <input id="files" type="file" accept="application/pdf" class="form-control @error('files') is-invalid @enderror" name="files" value="{{ old('files') }}" required>
                                @error('files')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    Add New Project
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
