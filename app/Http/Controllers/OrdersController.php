<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use GTrack\GTrack;

class OrdersController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('cart');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();
        \Cart::session(Auth::id())->clear();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if($request->session()->has('transaction')){
            $id = Auth::id();
            \Cart::session($id);
            $items = \Cart::getContent();
            $request->session()->reflash();
            $transaction = $request->session()->get('transaction');

            $snapToken = $request->session()->get('snapToken');
            return view('orders.create', compact('snapToken', 'transaction', 'items'));
        }else{
            return redirect('/shipments/create');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        $this->authorize('view', $order);
        \Midtrans\Config::$serverKey = 'SB-Mid-server-LtqgZHhxsY2gQR5xaIo-uKf0';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = \Midtrans\Config::$is3ds = true;

        $status = \Midtrans\Transaction::status($order->order_code);

        $getCost = RajaOngkir::biaya([
            'origin'        => 22,     // ID kota/kabupaten asal
            'destination'   => $order->shipment->city_id,      // ID kota/kabupaten tujuan
            'weight'        => 700,    // berat barang dalam gram
            'courier'       => $order->shipment->courier_id    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();  

        if($getCost[0]['code'] == 'jne'){
            $cost = $getCost[0]['costs'][1]['cost'][0];
        }else{
            $cost = $getCost[0]['costs'][0]['cost'][0];
        }

        $cek = '';

        if ($order->shipment->shipment_number != NULL) {
            if($getCost[0]['code'] == 'jne'){
                $cek = GTrack::jne($order->shipment->shipment_number);
            }else if($getCost[0]['code'] == 'tiki'){
                $cek = GTrack::tiki($order->shipment->shipment_number);
            }else if($getCost[0]['code'] == 'pos'){
                $cek = GTrack::pos($order->shipment->shipment_number);
            }
        }
        return view('orders.show', compact('order', 'status', 'cost', 'cek'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this->authorize('view', $order);
        \Midtrans\Config::$serverKey = 'SB-Mid-server-qNXIjCOZ5NKdQYyIKmvvm_js';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = \Midtrans\Config::$is3ds = true;
        $cancel = \Midtrans\Transaction::cancel($order->order_code);
        return view('order/'.$order->order_code)->with('status', 'Order canceled.');
    }
}
