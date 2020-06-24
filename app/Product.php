<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'allfiles' => 'array'
    ];

    public function scopeSearch($query , $keywords)
    {
    //    $keywords = explode(' ',$keywords);
       // foreach ($keywords as $keyword) {
            $query
                ->whereHas('category' , function ($query) use ($keywords){
                    $query->where('name' , 'LIKE' , '%' . $keywords . '%' );
                })
                ->orWhere('name' , 'LIKE' , '%' . $keywords . '%');

      //  }

        return $query;

    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsTo(Order::class);
    }

    public function pservices()
    {
        return $this->belongsToMany(Pservice::class);
    }
}
