<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messinqu extends Model
{
    protected  $guarded = [];

    protected  $casts = [
        'images' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pinquiry()
    {
        return $this->belongsTo(Pinquiry::class);
    }

}
