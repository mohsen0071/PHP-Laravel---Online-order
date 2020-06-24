<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pinquiry extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(User::class);
    }
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
    public function messinqus()
    {
        return $this->hasMany(Messinqu::class);
    }
}
