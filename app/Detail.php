<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'product_id', 'path'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
