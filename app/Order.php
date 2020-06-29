<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = ['order_code', 'user_id', 'shipment_id'];

    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity', 'total');
    }

    public function shipment()
    {
        return $this->belongsTo('App\Shipment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
