@extends('admin.sidebar')

@section('main')

<h2 class="mb-4">New Role</h2>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                New Role Form
            </div>

            <div class="card-body">
                <form action="/roles" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="text-dark">Role Name<sup>*</sup></label>
                        <input type="text" id="name" name="name" autocomplete="off"
                            class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" required>
                        @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <a href="/roles" class="btn btn-outline-primary float-right">Cancel</a>
                    <button class="btn btn-primary float-right mr-2" type="submit">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection