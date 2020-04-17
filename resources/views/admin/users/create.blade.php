@extends('admin.sidebar')


@section('main')
<h2 class="mb-4">New User</h2>

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                New User Form
            </div>

            <div class="card-body">
                <form action="/users" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="text-dark">Full Name <sup>*</sup></label>
                        <input type="text" id="name" name="name" autocomplete="off"
                            class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" required>

                        @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="email" class="text-dark">Email address <sup>*</sup></label>
                        <input type="text" id="email" name="email" autocomplete="off"
                            class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" required>

                        @error('email')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="text-dark">Password <sup>*</sup></label>
                        <input type="password" id="password" name="password" autocomplete="off"
                            class="form-control @error('password') is-invalid @enderror" required>

                        @error('password')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="text-dark">Confirm Password <sup>*</sup></label>
                        <input type="password" id="password-confirm" name="password_confirmation" autocomplete="off"
                            class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="" class="text-dark">Role</label>
                        @foreach ($roles as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role_id"
                                id="roleRadio-{{$loop->iteration}}" value="{{$role->id}}">
                            <label class="form-check-label" for="roleRadio-{{$loop->iteration}}">
                                {{$role->name}}
                            </label>
                        </div>
                        @endforeach


                    </div>
                    @error('role_id')
                    <div class="invalid-feedback d-block">
                        {{$message}}
                    </div>
                    @enderror


                    <a href="/products" class="btn btn-outline-primary float-right">Cancel</a>
                    <button class="btn btn-primary float-right mr-2" type="submit">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection