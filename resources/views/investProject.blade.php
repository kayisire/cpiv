@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <a href="/investments">
                        <i class="fa fa-chevron-left mr-2"></i>
                        All Projects
                    </a>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is(['investments/*/new']) ? 'active' : null }}" href="#">
                                <i class="fa fa-eye mr-2"></i>
                                View Project
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
                        <span class="font-weight-bold">Owner: </span><br>
                        <span>{{ $project->fullnames }}</span><br>
                        <small>{{ $project->email }}</small><br>
                        <small class="text-muted">{{ $project->phone }}</small>
                    </p>
                    <p>
                        <span class="font-weight-bold">Uploaded: </span> {{ \Carbon\Carbon::parse($project->created_at)->diffForHumans() }}
                    </p>
                    <hr>
                    <h3 class="border-bottom pb-3">Make Investment</h3>
                    <form method="POST" action="{{ route('invest') }}" class="pt-3" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="amount" class="col-md-3 col-form-label text-md-right">Amount <br><small class="text-muted">(in RWF)</small></label>
                            <div class="col-md-9">
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required>
                                <input type="hidden" name="project" value="{{ $project->id }}">
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="notes" class="col-md-3 col-form-label text-md-right">Investment Document <br><small class="text-muted">(in PDF)</small></label>
                            <div class="col-md-9">
                                <input id="notes" type="file" accept="application/pdf" class="form-control @error('notes') is-invalid @enderror" name="notes" value="{{ old('notes') }}" required>
                                @error('notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="paymentDate" class="col-md-3 col-form-label text-md-right">Payment Date</label>
                            <div class="col-md-9">
                                <input id="paymentDate" type="date" class="form-control @error('paymentDate') is-invalid @enderror" name="paymentDate" value="{{ old('paymentDate') }}" required>
                                @error('paymentDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    Pledge Investment
                                </button>
                            </div>
                        </div>
                    </form>
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
                                <td>{{ \Carbon\Carbon::parse($investment->paymentDate)->diffForHumans() }}</td>
                                <td>
                                    @if($investment->isActive == 0)
                                        <span class="badge badge-pill badge-warning">Pending Owner Review</span>
                                    @elseif($investment->isActive == 1)
                                        <span class="badge badge-pill badge-warning">Pending RDB Review</span>
                                    @elseif($investment->isActive == 2)
                                        <span class="badge badge-pill badge-danger">Suspended</span>
                                    @elseif($investment->isActive == 3)
                                        <span class="badge badge-pill badge-success">Approved</span>
                                    @endif
                                </td>
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
