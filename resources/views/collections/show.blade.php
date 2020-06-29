@extends('layouts.app')

@section('content')

<h1 class="display-3 mb-4 pb-2 text-center ">{{$category->name}} String Bag</h1>


<div class="row w-100 m-p">
    @foreach ($category->products as $product)
    <div class="col-sm-4 p-0">
        <a href="/product/{{$product->id}}" class="text-dark text-decoration-none">
            <div class="card border-dark m-1" style="border-radius: 0">
                <img src="/storage/{{$product->thumbnail}}" class="card-img-top border-bottom border-dark"
                    style="border-radius: 0" height="360px">
                <div class="card-body text-center">
                    <h5 class="card-title">
                        @if ($product->stock == 0)
                        <del>{{$product->name}}</del> <small class="text-danger">Out of stock!</small>
                        @else
                        {{$product->name}}
                        @endif

                    </h5>
                    <p class="card-text"> &#82;&#112; {{number_format($product->price, 2, ',', '.')}}</p>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

@endsection