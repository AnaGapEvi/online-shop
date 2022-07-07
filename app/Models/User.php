<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'birthday',
        'gender',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
//    public function bag(){
//        return $this->belongsToMany(Bag::class);
//    }

    public function products(){
        return $this->belongsToMany( \App\Models\Product::class, 'bags', 'user_id', 'product_id' )->withPivot(['quantity', 'id']);
    }

    public function wishlist(){
        return $this->hasMany(WishList::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function reviews(){
        return $this->hasMany(Reviews::class);
    }

}
