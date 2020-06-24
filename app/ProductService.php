<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductService extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
