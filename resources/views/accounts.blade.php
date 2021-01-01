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
                <div class="card-header">All Users</div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <table class="table table-hover table-responsive">
                        <thead>
                            <th>#</th>
                            <th>Fullnames</th>
                            <th>Contacts</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->fullnames }}</td>
                                <td>
                                    <span>{{ $user->email }}</span>
                                    <small class="text-muted">{{ $user->phone }}</small>
                                </td>
                                <td>
                                    @if($user->isActive)
                                    <a href="/accounts/{{ $user->id }}/disable" class="btn btn-sm btn-outline-danger float-right my-1">
                                        <i class="fa fa-trash"></i>
                                        <span class="d-none d-sm-inline ml-2">Disable Account</span>
                                    </a>
                                    @else
                                    <a href="/accounts/{{ $user->id }}/activate" class="btn btn-sm btn-outline-success float-right my-1">
                                        <i class="fa fa-check"></i>
                                        <span class="d-none d-sm-inline ml-2">Enable Account</span>
                                    </a>
                                    @endif
                                    <a href="/accounts/{{ $user->id }}/assign" class="btn btn-sm btn-outline-primary float-right my-1">
                                        <i class="fa fa-user-tag"></i>
                                        <span class="d-none d-sm-inline ml-2">Assign Type</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
