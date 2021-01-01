@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Profile</div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('profile') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="fullnames" class="col-md-3 col-form-label text-md-right">Fullnames</label>
                            <div class="col-md-9">
                                <input id="fullnames" type="text" class="form-control @error('fullnames') is-invalid @enderror" name="fullnames" value="{{ $fullnames }}" required autocomplete="fullnames" autofocus>
                                @error('fullnames')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nid" class="col-md-3 col-form-label text-md-right">National ID</label>
                            <div class="col-md-9">
                                <input id="nid" type="number" class="form-control @error('nid') is-invalid @enderror" name="nid" value="{{ $nid }}" required>
                                @error('nid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tin" class="col-md-3 col-form-label text-md-right">TIN</label>
                            <div class="col-md-9">
                                <input id="tin" type="number" class="form-control @error('tin') is-invalid @enderror" name="tin" value="{{ $tin }}" required>
                                @error('tin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-3 col-form-label text-md-right">Phone Number</label>
                            <div class="col-md-9">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $phone }}" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-3 col-form-label text-md-right">Gender</label>
                            <div class="col-md-9">
                                <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender" required>
                                    @if($gender)
                                    <option value="{{ $gender }}">{{ ucfirst($gender) }}</option>
                                    @else
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="notMentioned">Not mention</option>
                                    @endif
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-3 col-form-label text-md-right">Address</label>
                            <div class="col-md-9">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $address }}" required>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-md-3 col-form-label text-md-right">User Type</label>
                            <div class="col-md-9">
                                <input id="type" type="text" class="form-control" value="{{ $type }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    Save Changes
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
