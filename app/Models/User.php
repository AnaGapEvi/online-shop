<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'birthday',
        'gender',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany( \App\Models\Product::class, 'bags', 'user_id', 'product_id' )->withPivot(['quantity', 'id']);
    }

    public function wishlist(): HasMany
    {
        return $this->hasMany(WishList::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany( \App\Models\User::class, 'reviews', 'product_id','user_id')->withPivot(['first_name']);
    }
}
