@extends('layouts.app')

@section('content')
<h1 class="px-3 mb-5 text-center">Your Order(s)</h1>
<div class="px-3">
    <h4>Your Order(s)</h4>
    <hr>
    @foreach ($orders as $order)
    <div class="list-group my-2">
        <a href="/order/{{$order->order_code}}" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">#{{$order->order_code}}</h5>
                <small>{{date('d M Y', strtotime($order->created_at))}}</small>
            </div>
        </a>
    </div>
    @endforeach
</div>


@endsection