<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function sheet()
    {
        return $this->belongsTo(Sheet::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

}
