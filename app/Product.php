<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name', 'desc', 'category_id', 'price', 'stock', 'thumbnail'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function details()
    {
        return $this->hasMany('App\Detail');
    }
}
