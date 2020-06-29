<?php

namespace App\Http\Controllers;

use App\Shipment;
use App\City;
use App\User;
use App\Order;
use App\Province;
use App\Courier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Kavist\RajaOngkir\Facades\RajaOngkir;

class ShipmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        
        $id = Auth::id();
        \Cart::session($id);
        $items = \Cart::getContent();
        if (count($items) <= 0) {
            return redirect('carts')->with('status','You should add atleast 1 item');
        }

        $cities = City::orderBy('city_id', 'asc')->get();
        $couriers = Courier::all();

        return view('shipments.index', compact('items', 'cities', 'couriers',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::id();
        \Cart::session($id);
        $items = \Cart::getContent();
        
        \Midtrans\Config::$serverKey = 'SB-Mid-server-LtqgZHhxsY2gQR5xaIo-uKf0';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = \Midtrans\Config::$is3ds = true;
        
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'city_id' => 'required|numeric|exists:cities,id',
            'address' => 'required|string|max:500',
            'phone' => 'required|numeric',
            'courier_id' => 'required|exists:couriers,code',
        ];

        $request->validate($rules);
        $city = City::where('city_id', $request->city_id)->first();
        //Create Shipment
        $shipment = Shipment::create(array_merge($request->all(), ['province_id' => $city->province_id]));

        //Get and Create Shipment Cost
        $getCost = RajaOngkir::biaya([
            'origin'        => 22,     // ID kota/kabupaten asal
            'destination'   => $request->city_id,      // ID kota/kabupaten tujuan
            'weight'        => 700,    // berat barang dalam gram
            'courier'       => $request->courier_id    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();

        if($getCost[0]['code'] == 'jne'){
            $cost = $getCost[0]['costs'][1]['cost'][0]['value'];
        }else{
            $cost = $getCost[0]['costs'][0]['cost'][0]['value'];
        }
        
        $shipment_cost = [
            'id' => $getCost[0]['code'],
            'price' => $cost,
            'quantity' => 1,
            'name' => $getCost[0]['name'],
        ];

        //Create Order Details
        $order_details = [
            'order_code' => rand(),
            'user_id' => $id,
            'shipment_id' => $shipment->id,
        ];

        $gross_amount = (int)\Cart::getTotal() + (int)$shipment_cost['price'];

        $transaction_details = array(
            'order_id' => $order_details['order_code'],
            'gross_amount' => $gross_amount, // no decimal allowed for creditcard
        );

        $order = Order::create($order_details);

        $items = \Cart::getContent();
        foreach($items as $item){
            $product[] = array(
                'id' => $item->id,
                'price' => (int)$item->price,
                'quantity' => (int)$item->quantity,
                'name' => $item->name
            );
        }
        
        $order = Order::find($order->id);
        foreach ($items as $item) {
            $order->products()->attach($item->id, ['quantity' => $item->quantity, 'total' => $item->quantity * $item->price]);
        }

        $billing_address = $shipping_address = array(
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'address'       => $request->address,
            'city'          => $city->city_name,
            'postal_code'   => $city->postal_code,
            'phone'         => $request->phone,
            'country_code'  => 'IDN'
        );
        $user = User::find($id); 

        $customer_details = array(
            'first_name'    => $user->name,
            'email'         => $user->email,
            'phone'         => "+62" . (string)$request->phone,
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );


        $transaction = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => array_merge($product, array($shipment_cost)),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($transaction);

        //    return view('orders.show', compact('snapToken', 'transaction'));
        return redirect('/orders/create')
        ->with('transaction', $transaction)
        ->with('snapToken', $snapToken);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function show(Shipment $shipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipment $shipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipment $shipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipment $shipment)
    {
        //
    }
}
