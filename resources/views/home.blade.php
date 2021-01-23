@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body bg-success">
                            <div class="float-left">
                                <h6 class="text-uppercase">Owners</h6><br>
                                <h1 class="display-4">{{ $owners }}</h1>
                            </div>
                            <div class="float-right">
                                <i class="fa fa-users fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body bg-danger">
                            <div class="float-left">
                                <h6 class="text-uppercase">Investors</h6><br>
                                <h1 class="display-4">{{ $investors }}</h1>
                            </div>
                            <div class="float-right">
                                <i class="fa fa-user fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body bg-primary">
                            <div class="float-left">
                                <h6 class="text-uppercase">Projects</h6><br>
                                <h1 class="display-4">{{ $projects }}</h1>
                            </div>
                            <div class="float-right">
                                <i class="fa fa-briefcase fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card mb-3">
                <div class="card-header">Analytics</div>
                <div class="card-body">
                    <h3 class="h3 border-bottom pb-3">Investments</h3>
                    {!! $analytics->container() !!}
                    {!! $analytics->script() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
