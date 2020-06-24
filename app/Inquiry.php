<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $guarded = [];

    protected  $casts = [
      'images' => 'array'
    ];

    public function pinquiries()
    {
        return $this->hasMany(Pinquiry::class);
    }
}
