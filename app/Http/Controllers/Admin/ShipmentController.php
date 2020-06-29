<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shipment;
use App\Product;

class ShipmentController extends Controller
{
    public function update(Request $request, Shipment $shipment)
    {
        $shipment->shipment_number = $request->shipment_number;
        if (isset($shipment->shipment_number)) {
            $order = $shipment->order;
            $items = collect($order->products)->map(function ($item)
            {
                return Product::where('id', $item->id)
                ->update(['stock' => $item->stock - $item->pivot->quantity]);
            });
        }
        if($shipment->save()){
            return back();
        }
    }
}
