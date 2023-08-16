<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'no_purchase',
        'customer',
        'type',
        'order_title',
        'status',
        'category',
        'total_price',
        'deadline',
    ];
}
