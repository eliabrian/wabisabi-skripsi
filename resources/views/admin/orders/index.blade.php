@extends('admin.sidebar')

@section('main')

<h2 class="mb-4 text-gray-900">Orders</h2>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Order (Total)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($orders)}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            Orders Table
        </h6>
    </div>

    @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('status')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>User Email</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td><a href="/admin/orders/{{$order->order_code}}">{{$order->order_code}}</a></td>
                        <td>{{$order->user->email}}</td>
                        <td>{{$order->created_at}}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection