<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'departure_date',
        'return_date',
        'price_quad',
        'price_triple',
        'price_double',
        'quota',
        'available_seats',
        'airline',
        'hotel_makkah',
        'hotel_madinah',
        'status'
    ];
}
