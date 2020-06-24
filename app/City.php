<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'province_id',
        'name'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

}
