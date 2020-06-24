<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function scopeSearch($query , $keywords)
    {


        $keywords = explode(' ',$keywords);
        foreach ($keywords as $keyword) {

                $query

                ->whereHas('province' , function ($query) use ($keyword){
                    $query->where('name' , 'LIKE' , '%' . $keyword . '%' );
                })
                ->orWhereHas('city', function ( $query ) use ($keyword){
                    $query->where('name' , 'LIKE' , '%' . $keyword . '%' );
                })
                ->orWhere('name' , 'LIKE' , '%' . $keyword . '%')
                ->orWhere('mobile' , 'LIKE' , '%' . $keyword . '%')
                ->orWhere('tel' , 'LIKE' , '%' . $keyword . '%')
                ->orWhere('company' , 'LIKE' , '%' . $keyword . '%');

        }

        return $query;

//        $query
//            ->where('mobile' , 'LIKE' , '%' . $keywords . '%')
//            ->orWhere('company' , 'LIKE' , '%' . $keywords . '%')
//            ->orWhere('name' , 'LIKE' , '%' . $keywords . '%')
//            ->where('level','user');
//
//        return $query;
    }

    public function notifs()
    {
        return $this->hasMany(Notif::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }


    public function hasRole($role)
    {
        if(is_string($role)) {
            return $this->roles->contains('name' , $role);
        }

        return !! $role->intersect($this->roles)->count();
    }

    public function isAdmin()
    {
        return $this->level == 'admin' ? true : false;
    }

    public function isActive()
    {
        return $this->status == 1 ? true : false;
    }

    public function sheets()
    {
        return $this->hasMany(Sheet::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function pinquiries()
    {
        return $this->hasMany(Pinquiry::class);
    }
    public function messinqus()
    {
        return $this->hasMany(Messinqu::class);
    }

    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }

    public function userlogs()
    {
        return $this->hasMany(Userlog::class);
    }

}
