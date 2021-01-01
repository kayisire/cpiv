@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Manage Accounts</div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['accounts']) ? 'active' : null }}" href="/accounts">
                                <i class="fa fa-users mr-2"></i>
                                All Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['accounts/types/new']) ? 'active' : null }}" href="/accounts/types/new">
                                <i class="fa fa-plus-circle mr-2"></i>
                                Add New User Type
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['accounts/types']) ? 'active' : null }}" href="/accounts/types">
                                <i class="fa fa-home mr-2"></i>
                                View All User Type
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New User Type</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('types') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">Name</label>
                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
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
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    Add New Type
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
