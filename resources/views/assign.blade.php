@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <a href="/accounts">
                        <i class="fa fa-chevron-left mr-2"></i>
                        All Users
                    </a>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['accounts/*/assign']) ? 'active' : null }}" href="#">
                                <i class="fa fa-user-tag mr-2"></i>
                                Assign Type
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Assign Type</div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('assignType') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="fullnames" class="col-md-3 col-form-label text-md-right">Fullnames</label>
                            <div class="col-md-9">
                                <input id="fullnames" type="text" class="form-control" value="{{ $user->fullnames }}" disabled>
                                <input type="hidden" value="{{ $user->id }}" name="user_id">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">Email</label>
                            <div class="col-md-9">
                                <input id="email" type="text" class="form-control" value="{{ $user->email }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_type" class="col-md-3 col-form-label text-md-right">User Type</label>
                            <div class="col-md-9">
                                <select name="user_type_id" id="user_type" class="form-control @error('user_type') is-invalid @enderror" required>
                                <option value="">Select User Type</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                                </select>
                                @error('user_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    Assign Type
                                </button>
                            </div>
                        </div>
                        @if (count($userTypesAssigned))
                        <hr>
                        <h6 class="h6 font-weight-bold">User Types Assigned:</h6>
                        <table class="table table-hover">
                            <thead>
                                <th>Name</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($userTypesAssigned as $item)
                                <tr>
                                    <td><b>{{ $item->name }}</b></td>
                                    <td>
                                        <a href="/accounts/{{ $user->id }}/assign/{{ $item->id }}/remove" class="btn btn-sm btn-outline-danger float-right"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
