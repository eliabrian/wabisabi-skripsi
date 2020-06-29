@extends('admin.sidebar')


@section('main')

{{-- {{dd($status)}} --}}
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Order ID</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$order->order_code}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Amount</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                            {{number_format($status->gross_amount, 2, ',', '.')}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Payment Method</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            @if ($status->payment_type == 'bank_transfer')
                            @if ($status->va_numbers[0]->bank == 'bca')
                            BCA VA
                            @elseif ($status->va_numbers[0]->bank == 'bni')
                            BNI VA
                            @endif
                            @elseif ($status->payment_type == 'echannel')
                            Mandiri Bill
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Transaction Status</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            @if ($status->transaction_status == 'settlement')
                            <span class="badge badge-pill badge-success">Success</span>
                            @elseif ($status->transaction_status == 'pending')
                            <span class="badge badge-pill badge-warning">Pending</span>
                            @elseif ($status->transaction_status == 'cancel')
                            <span class="badge badge-pill badge-danger">Canceled</span>
                            @elseif ($status->transaction_status == 'expire')
                            <span class="badge badge-pill badge-danger">Expired</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Order Id</td>
                                <td>{{$order->order_code}}</td>
                            </tr>
                            <tr>
                                <td>Payment Type</td>
                                <td>
                                    @if ($status->payment_type == 'bank_transfer')

                                    @if ($status->va_numbers[0]->bank == 'bca')
                                    BCA Virtual Account
                                    @elseif ($status->va_numbers[0]->bank == 'bni')
                                    BNI Virtual Account
                                    @endif
                                    @elseif ($status->payment_type == 'echannel')
                                    Mandiri Bill
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Amount</td>
                                <td>Rp {{number_format($status->gross_amount, 2, ',', '.')}}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>{{$status->transaction_time}}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @if ($status->transaction_status == 'settlement')
                                    Success
                                    @elseif ($status->transaction_status == 'pending')
                                    Pending
                                    @elseif ($status->transaction_status == 'cancel')
                                    Canceled
                                    @elseif ($status->transaction_status == 'expire')
                                    Expired
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Payment Details</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Virtual Account</td>
                                <td>
                                    @if ($status->payment_type == 'bank_transfer')
                                    {{$status->va_numbers[0]->va_number}}
                                    @elseif ($status->payment_type == 'echannel')
                                    {{$status->biller_code}} + {{$status->bill_key}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Acquiring Bank</td>
                                <td>
                                    @if ($status->payment_type == 'bank_transfer')

                                    @if ($status->va_numbers[0]->bank == 'bca')
                                    BCA Virtual Account
                                    @elseif ($status->va_numbers[0]->bank == 'bni')
                                    BNI Virtual Account
                                    @endif
                                    @elseif ($status->payment_type == 'echannel')
                                    Mandiri Bill
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Customer Details</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{$order->user->name}}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>
                                    +62{{$order->shipment->phone}}
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{$order->user->email}}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>
                                    {{$order->shipment->address}}, {{$order->shipment->city->city_name}},
                                    {{$order->shipment->city->province}}, {{$order->shipment->city->postal_code}}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Shipping Details</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            @if ($status->transaction_status == 'settlement')
                            <tr>
                                <td class="text-dark">Shipment Vendor</td>
                                <td>
                                    @if ($order->shipment->courier_id == 'jne')
                                    JNE
                                    @elseif ($order->shipment->courier_id == 'pos')
                                    POS
                                    @elseif ($order->shipment->courier_id == 'tiki')
                                    TIKI
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark">Tracking Number</td>
                                <td>
                                    @if ($order->shipment->shipment_number == NULL)
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addTracking">Add here</button>
                                    @else
                                    {{$order->shipment->shipment_number}}

                                    <a type="button" data-toggle="modal" data-target="#addTracking" class="ml-1"><i
                                            class="fas fa-pen"></i></a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                @isset($order->shipment->shipment_number)
                                <td class="text-dark">Shipment Status :</td>
                                <td>
                                    @if ($cek->error == true)
                                    <span class="badge badge-pill badge-danger">{{ucfirst($cek->message)}}</span>
                                    @else
                                    <span class="badge badge-pill badge-success">{{ucfirst($cek->info->status)}}</span>
                                    @endif
                                </td>
                                @endisset
                            </tr>
                            @endif
                            <tr>
                                <td class="text-dark">Name</td>
                                <td>{{$order->shipment->first_name}} {{$order->shipment->last_name}}</td>
                            </tr>
                            <tr>
                                <td class="text-dark">Phone</td>
                                <td>
                                    +62{{$order->shipment->phone}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark">Address</td>
                                <td>
                                    {{$order->shipment->address}}, {{$order->shipment->city->city_name}},
                                    {{$order->shipment->city->province}}, {{$order->shipment->city->postal_code}}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Item Details</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Subtotal</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $item)
                            <tr>
                                <td>
                                    <img src="/storage/{{$item->thumbnail}}" alt="..." class="img-thumbnail"
                                        style="max-height:75px">
                                </td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->pivot->quantity}}</td>
                                <td>Rp {{number_format($item->pivot->total, 2, ',', '.')}}</td>

                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="text-dark">Shipment</td>
                                <td>
                                    @if ($order->shipment->courier_id == 'jne')
                                    (JNE)
                                    @elseif ($order->shipment->courier_id == 'pos')
                                    (POS)
                                    @elseif ($order->shipment->courier_id == 'tiki')
                                    (TIKI)
                                    @endif
                                </td>
                                <td>Rp {{number_format($cost['value'], 2, ',', '.')}}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-dark"><strong>Total</strong></td>
                                <td class="text-dark">
                                    <strong>
                                        Rp
                                        {{number_format($status->gross_amount, 2, ',', '.')}}
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addTracking" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trackingModal">Tracking Number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/admin/shipment/{{$order->shipment->id}}" method="POST">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tracking Number:</label>
                        <input type="text" class="form-control" id="shipment_number" name="shipment_number"
                            value="{{$order->shipment->shipment_number}}">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection