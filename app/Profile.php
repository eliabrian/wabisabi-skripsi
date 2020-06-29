<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function profileImage()
    {
        $imageProfile = ($this->image) ? $this->image : 'uploads/default.png';
        return $imageProfile;
    }
}
