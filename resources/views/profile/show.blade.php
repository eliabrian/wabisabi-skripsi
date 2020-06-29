@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Profile</h5>
            <a href="#" class="btn btn-sm btn-primary">Update Profile</a>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <img src="/storage/{{ $user->profile->profileImage() }}" alt="" class="img-thumbnail" width="300px"
                        height="300px">
                </div>
                <div class="col-md-8">
                    <dl class="row">
                        <dt class="col-sm-3">Full Name</dt>
                        <dd class="col-sm-9">{{ $user->name }}</dd>
                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">{{ $user->email }}</dd>
                        <dt class="col-sm-3">Gender</dt>
                        <dd class="col-sm-9">@empty($user->profile->gender) - @endempty</dd>
                        <dt class="col-sm-3">Phone</dt>
                        <dd class="col-sm-9">@empty($user->profile->phone) - @endempty</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection