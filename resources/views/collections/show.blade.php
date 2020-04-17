@extends('layouts.app')

@section('content')

<h1 class="display-3 mb-4 pb-2 text-center ">{{$category->name}} String Bag</h1>


<div class="row w-100 m-0">
    @foreach ($category->products as $product)
    <div class="col-sm-4 p-0">
        <a href="/" class="text-dark">
            <div class="card border-dark m-1" style="border-radius: 0">
                <img src="/storage/{{$product->thumbnail}}" class="card-img-top border-bottom border-dark"
                    style="border-radius: 0">
                <div class="card-body text-center">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text"> <sup>&#82;&#112;</sup> {{$product->price}}</p>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

@endsection