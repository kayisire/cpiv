@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <a href="/investments/my">
                        <i class="fa fa-chevron-left mr-2"></i>
                        My Investments
                    </a>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['investments/*/view']) ? 'active' : null }}" href="#">
                                <i class="fa fa-eye mr-2"></i>
                                View Details
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">Project Title: <b>{{ \Illuminate\Support\Str::limit($investment->title, $limit = 15, $end = '...') }}</b></span>
                    <span class="float-right">
                        @if($investment->status == 0)
                            <span class="badge badge-pill badge-warning">Pending Owner Review</span>
                        @elseif($investment->status == 1)
                            <span class="badge badge-pill badge-warning">Pending RDB Review</span>
                        @elseif($investment->status == 2)
                            <span class="badge badge-pill badge-danger">Suspended</span>
                        @elseif($investment->status == 3)
                            <span class="badge badge-pill badge-success">Approved</span>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <img src="{{ $investment->pic_url }}" alt="" width="500" class="mb-3">
                    <hr>
                    <h3 class="h3 font-weight-bold">{{ $investment->title }}</h3>
                    <p>
                        <span class="font-weight-bold">Amount: </span><br>
                        <span class="h4 font-weight-bold">{{ number_format($investment->amount) }} Rwf</span>
                    </p>
                    <p>
                        <span class="font-weight-bold">Description: </span><br>
                        <span class="h5">{{ $investment->description }}</span>
                    </p>
                    @if($investment->status == 1)
                    <p>
                        <span class="font-weight-bold">Additional Document: </span><br>
                        <a href="{{ $investment->files }}" class="btn btn-md btn-outline-primary">Download Files Here</a>
                    </p>
                    @if ($investment->signedDocument)
                    <p>
                        <span class="font-weight-bold">Signed Document: </span><br>
                        <a href="{{ $investment->signedDocument }}" class="btn btn-md btn-outline-primary">Download Files Here</a>
                    </p>
                    @endif
                    @endif
                    <p>
                        <span class="font-weight-bold">Owner: </span><br>
                        <span>{{ $investment->fullnames }}</span><br>
                        <small>{{ $investment->email }}</small><br>
                        <small class="text-muted">{{ $investment->phone }}</small>
                    </p>
                    <p>
                        <span class="font-weight-bold">Uploaded: </span> {{ \Carbon\Carbon::parse($investment->created_at)->diffForHumans() }}
                    </p>
                    @if($investment->status == 1)
                    @if ($investment->approvedLocation)
                    <h6 class="h6 font-weight-bold">Selected Location:</h6>
                    <table class="table table-hover">
                        <thead>
                            <th>UPI Code #</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>{{ $investment->approvedLocation }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                    @endif
                    <hr>
                    <h3 class="h3 border-bottom pb-3">Investment Section</h3>
                    <p class="pt-3">
                        <span class="font-weight-bold">Invested: </span> {{ \Carbon\Carbon::parse($investment->investedOn)->diffForHumans() }}
                    </p>
                    <p>
                        <span class="font-weight-bold">Invested Amount: </span><br>
                        <span class="h4 font-weight-bold">{{ number_format($investment->invested) }} Rwf</span>
                    </p>
                    <p>
                        <span class="font-weight-bold">Investment Document: </span><br>
                        <a href="{{ $investment->notes }}" class="btn btn-md btn-outline-primary">Download Files Here</a>
                    </p>
                    <p>
                        <span class="font-weight-bold">Pledged Payment Date: </span> {{ $investment->paymentDate }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
