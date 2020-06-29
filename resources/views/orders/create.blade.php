@extends('layouts.app')

@section('content')
<div class="row w-100 p-3">

    <div class="col-md-12">
        <h5>Summary</h5>
        <hr>
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
                @foreach ($items as $item)
                <tr>
                    <td>
                        <img src="/storage/{{$item->attributes->thumbnail}}" alt="..." class="img-thumbnail"
                            style="max-height:75px">
                    </td>
                    <td>
                        <p>{{$item->name}}</p>
                    </td>
                    <td>
                        <p>{{$item->quantity}}</p>
                    </td>
                    <td>
                        <p>{{number_format($item->quantity * $item->price, 2, ',', '.')}}</p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <div class="d-flex card-body pb-0">
            <h6>Sub Total:</h6>
            <h6 class="ml-auto">Rp. {{number_format(\Cart::getTotal(), 2, ',', '.')}}
        </div>
        <div class="d-flex card-body pb-0">
            <h6>Shipping Cost:</h6>
            <h6 class="ml-auto">Rp. {{number_format(last($transaction['item_details'])['price'], 2, ',', '.')}}
        </div>
        <div class="card-body d-flex">

            <h5>Gross Amount:</h5>
            <h5 class="ml-auto">Rp. {{number_format($transaction['transaction_details']['gross_amount'], 2, ',', '.')}}
            </h5>
        </div>
        <hr>
        <button id="pay-button" class="btn btn-outline-primary btn-block">Pay</button>
    </div>
</div>
<pre><div id="result-json">JSON result will appear here after payment:<br></div></pre>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-uBXgZoNJZvZjGqNK"
    type="text/javascript"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
                    // SnapToken acquired from previous step
                    snap.pay('<?php echo $snapToken?>', {
                        // Optional
                        onSuccess: function(result){
                            /* You may add your own js here, this is just example */ 
                            document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                            
                            window.location = '/orders'
                        },
                        // Optional
                        onPending: function(result){
                            /* You may add your own js here, this is just example */ 
                            document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                            window.location = '/orders'
                        },
                        // Optional
                        onError: function(result){
                            /* You may add your own js here, this is just example */ 
                            document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                            window.location = '/orders'
                        }
                    });
                };
</script>
@endsection