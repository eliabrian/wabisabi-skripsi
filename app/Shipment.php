<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = ['first_name', 'last_name', 'city_id', 'address', 'phone', 'courier_id', 'province_id'];

    public function order()
    {
        return $this->hasOne('App\Order');
    }

    public function city()
    {
        return $this->belongsTo('App\City','city_id', 'city_id');
    }
}
