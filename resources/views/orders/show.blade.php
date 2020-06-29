@extends('layouts.app')

@section('content')
{{-- {{$order->products}} --}}


<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            Order Details
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">

                                <span class="text-muted">Order Number :</span> #{{$order->order_code}}
                            </h5>
                            <hr>
                            <div class="d-flex">
                                <p class="text-muted">Full Name :</p>
                                <p class="ml-auto">{{$order->user->name}}</p>
                            </div>
                            <div class="d-flex">
                                <p class="text-muted">Email :</p>
                                <p class="ml-auto">{{$order->user->email}}</p>
                            </div>
                            <div class="d-flex">
                                <p class="text-muted">Date of Submission :</p>
                                <p class="ml-auto">{{date('d M Y', strtotime($order->created_at))}}</p>
                            </div>
                            <div class="d-flex">
                                <p class="text-muted">Payment Status :</p>
                                <p class="ml-auto">
                                    {{-- {{dd($status)}} --}}
                                    @if ($status->transaction_status == 'settlement')
                                    <span class="badge badge-pill badge-success">Success</span>
                                    @elseif ($status->transaction_status == 'pending')
                                    <span class="badge badge-pill badge-warning">Pending</span>
                                    @elseif ($status->transaction_status == 'cancel')
                                    <span class="badge badge-pill badge-danger">Canceled</span>
                                    @elseif ($status->transaction_status == 'expire')
                                    <span class="badge badge-pill badge-danger">Expired</span>
                                    @endif
                                </p>
                            </div>
                            <div class="d-flex">
                                <p class="text-muted">Payment Method : </p>
                                <p class="ml-auto mb-0">
                                    @if ($status->payment_type == 'bank_transfer')

                                    @if ($status->va_numbers[0]->bank == 'bca')
                                    BCA Virtual Account
                                    @elseif ($status->va_numbers[0]->bank == 'bni')
                                    BNI
                                    @endif

                                    @elseif ($status->payment_type == 'echannel')
                                    <span class="text-dark">Mandiri Virtual Account</span>
                                    @endif
                                </p>
                            </div>
                            @if ($status->payment_type == 'bank_transfer')
                            <div class="d-flex">
                                <p class="text-muted">Virtual Number : </p>
                                <p class="ml-auto mb-0">
                                    {{$status->va_numbers[0]->va_number}}
                                </p>
                            </div>
                            @elseif ($status->payment_type == 'echannel')
                            <div class="d-flex">
                                <p class="text-muted">Merchant Code : </p>
                                <p class="ml-auto mb-0">
                                    {{$status->biller_code}}
                                </p>
                            </div>
                            <div class="d-flex">
                                <p class="text-muted">Virtual Number : </p>
                                <p class="ml-auto mb-0">
                                    {{$status->bill_key}}
                                </p>
                            </div>
                            @endif
                        </div>
                        @if ($status->status_code == 201)
                        <div class="card-footer">
                            <button type="button" class="btn btn-outline-dark btn-block" data-toggle="modal"
                                data-target="#cancelModal">
                                Cancel Order
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-12 my-3">
                    <div class="card  shadow-sm">
                        <div class="card-header">
                            Shipment Details
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <span class="text-muted">Shipment Number :</span>
                                @if ($order->shipment->shipment_number == NULL)
                                TBA
                                @else
                                {{$order->shipment->shipment_number}}
                                @endif
                            </h5>
                            <hr>

                            @isset($order->shipment->shipment_number)
                            <div class="d-flex">
                                <p class="text-muted">Shipment Status :</p>
                                <p class="ml-auto">
                                    @if ($cek->error == true)
                                    <span class="badge badge-pill badge-danger">{{ucfirst($cek->message)}}</span>
                                    @else
                                    <span class="badge badge-pill badge-success">{{ucfirst($cek->info->status)}}</span>
                                    @endif
                                </p>
                            </div>
                            @endisset

                            <div class="d-flex">
                                <p class="text-muted">Full Name :</p>
                                <p class="ml-auto">{{$order->shipment->first_name}} {{$order->shipment->last_name}}</p>
                            </div>
                            <div class="d-flex">
                                <p class="text-muted">Address :</p>
                                <p class="ml-auto">{{$order->shipment->address}} </p>
                            </div>
                            <div class="d-flex">
                                <p class="text-muted">City :</p>
                                <p class="ml-auto">{{$order->shipment->city->city_name}}</p>
                            </div>
                            <div class="d-flex">
                                <p class="text-muted">Province :</p>
                                <p class="ml-auto">{{$order->shipment->city->province}}</p>
                            </div>
                            <div class="d-flex">
                                <p class="text-muted">Postal Code :</p>
                                <p class="ml-auto">{{$order->shipment->city->postal_code}}</p>
                            </div>
                            <div class="d-flex">
                                <p class="text-muted">Phone :</p>
                                <p class="ml-auto">+62 {{$order->shipment->phone}}</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header">
                    Order Items
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
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
                        </tbody>
                    </table>
                    <hr>
                    <div class="d-flex">
                        <p class="text-muted">Shipment Cost
                            @if ($order->shipment->courier_id == 'jne')
                            (JNE)
                            @elseif ($order->shipment->courier_id == 'pos')
                            (POS)
                            @elseif ($order->shipment->courier_id == 'tiki')
                            (TIKI)
                            @endif
                            :</p>
                        <p class="ml-auto">Rp {{number_format($cost['value'], 2, ',', '.')}}</p>
                    </div>
                    <div class="d-flex">
                        <p class="text-muted">Total :</p>
                        <p class="ml-auto">Rp {{number_format($status->gross_amount, 2, ',', '.')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to cancel this order?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Select "Yes" below if you want to cancel this order.
            </div>
            <div class="modal-footer">
                <form action="/order/{{$order->order_code}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button tyle="submit" class="btn btn-light">Yes please.</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep my order.</button>
            </div>
        </div>
    </div>
</div>



@endsection