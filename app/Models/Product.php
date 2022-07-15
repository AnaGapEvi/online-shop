<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class);
    }
    public function orders(){
        return $this->belongsToMany(Order::class);
    }

    public function reviews(){
        return $this->hasMany(Reviews::class);
    }
   public function users(){
        return $this->belongsToMany( \App\Models\User::class, 'bags', 'product_id', 'user_id' );
    }
}
