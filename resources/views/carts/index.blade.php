@extends('layouts.app')

@section('content')
@if(session('status'))
<div class="alert alert-primary alert-dismissible fade show" role="alert">
    <strong>{{session('status')}}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<h3 class="px-3 mb-3">Shopping Cart</h3>

<div class="row w-100 m-0">
    <div class="col-md-8">

        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @if (\Cart::getTotal() != 0)
                @foreach ($items as $item)
                <tr>
                    <td>
                        <img src="/storage/{{$item->attributes->thumbnail}}" alt="..." class="img-thumbnail"
                            style="max-height:75px">
                    </td>
                    <td>{{$item->name}}</td>
                    <td>
                        @if($item->quantity > 1)
                        <a href="/carts/{{$item->id}}/decrement" class="btn btn-sm btn-outline-dark mr-2">
                            <i class="fas fa-minus"></i>
                        </a>
                        @endif

                        {{$item->quantity}}

                        <a href="/carts/{{$item->id}}/increment" class="btn btn-sm btn-outline-dark ml-2">
                            <i class="fas fa-plus"></i>
                        </a>
                    </td>
                    <td>Rp {{number_format($item->price * $item->quantity, 2, ',', '.')}}</td>
                    <td>
                        <form action="/carts/{{$item->id}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5" class="text-center">There is no item in your cart.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="col-md-4 align-items-center">

        <div class="card">
            <h3 class="card-header">
                Your Order
            </h3>
            <div class="card-body d-flex">
                <h5>Total:</h5>
                <h5 class="ml-auto">Rp. {{number_format(\Cart::getTotal(), 2, ',', '.')}}</h5>
            </div>
        </div>

        @if (\Cart::getTotal() != 0)
        <a href="/shipments/create" class="btn btn-outline-dark mt-3 w-100">Checkout</a>
        @endif

    </div>
</div>


@endsection