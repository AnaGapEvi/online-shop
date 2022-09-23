<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
      'name',
      'description',
      'image',
      'price',
      'category_id',
      'quantity',
      'created_at'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Reviews::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany( \App\Models\User::class, 'bags', 'product_id', 'user_id' );
    }
}
