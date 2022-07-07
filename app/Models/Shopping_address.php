<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping_address extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'city',
        'country',
        'zip',
        'user_id',
        'telephone'
    ];
}
