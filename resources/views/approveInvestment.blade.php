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
                            <a class="nav-link {{ Request::is(['investments/pending']) ? 'active' : null }}" href="/investments/pending">
                                <i class="fa fa-spinner mr-2"></i>
                                Pending Approval Investments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['investments/all']) ? 'active' : null }}" href="/investments/all">
                                <i class="fa fa-briefcase mr-2"></i>
                                All Investments
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Investments</div>
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
                            <th>Investor</th>
                            <th>Amount</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @if (count($investments))
                            @foreach ($investments as $investment)
                            @if($investment->isActive != 99)
                            <tr>
                            <td>
                                <a href="/projects/{{ $investment->id }}/view">
                                    <img src="{{ $investment->pic_url }}" alt="" width="75">
                                </a>
                            </td>
                            <td>
                                <a href="/projects/{{ $investment->id }}/view" class="text-decoration-none">
                                    <span>{{ $investment->title }}</span><br>
                                </a>
                                <small class="text-muted font-italic">Uploaded: <span class="font-weight-bolder">{{ \Carbon\Carbon::parse($investment->created_at)->diffForHumans() }}</span></small>
                            </td>
                            <td>
                                <span>{{ $investment->fullnames }}</span><br>
                                <small>{{ $investment->email }}</small><br>
                                <small class="text-muted">{{ $investment->phone }}</small>
                            </td>
                            <td>{{ number_format($investment->invested) }} Rwf</td>
                            @if(REQUEST::is('investments/pending'))
                            <td>
                                <a href="/investments/{{ $investment->investment_id }}/approved" class="btn btn-sm btn-outline-success float-right my-1">
                                    <i class="fa fa-check"></i>
                                    <span class="d-none d-sm-inline ml-2">Approve</span>
                                </a><br>
                                <a href="/investments/{{ $investment->investment_id }}/suspend" class="btn btn-sm btn-outline-danger float-right my-1">
                                    <i class="fa fa-times"></i>
                                    <span class="d-none d-sm-inline ml-2">Suspend</span>
                                </a><br>
                                <a href="/investments/{{ $investment->investment_id }}/view" class="btn btn-sm btn-outline-primary float-right my-1">
                                    <i class="fa fa-eye"></i>
                                    <span class="d-none d-sm-inline ml-2">View Details</span>
                                </a>
                            </td>
                            @else
                            <td>
                                @if($investment->status == 3)
                                    <span class="badge badge-pill badge-success">Approved</span>
                                @elseif($investment->status == 2)
                                    <span class="badge badge-pill badge-danger">Suspended</span>
                                @endif
                            </td>
                            @endif
                            </tr>
                            @endif
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
