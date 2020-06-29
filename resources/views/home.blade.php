@extends('layouts.app')

@section('content')

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <h1 class="font-weight-light">Wabisabi String Bag Store</h1>
                <p class="lead">Take the bag and go where ever you want</p>
            </div>
        </div>
    </div>
</header>


<!-- Header -->
<header class="text-center py-5">
    <div class="container">
        <h1 class="font-weight-light mb-5">Our Latest Collections</h1>
        <div class="row">
            <!-- Team Member 1 -->
            @foreach ($new_categories as $cat)

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow">
                    <img src="storage/{{ $cat->products->first()['thumbnail'] }}" class="card-img-top" alt="..."
                        height="215px">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-2">{{ $cat->name }} String Bags</h5>
                        <a href="{{ url('collection/' . $cat->name) }}" class="btn btn-outline-secondary btn">Discover
                            Now</a>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- /.row -->

        </div>
</header>

<!-- Page Content -->


@endsection