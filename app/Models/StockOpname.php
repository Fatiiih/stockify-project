<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\User;

class StockOpname extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'system_stock',
        'physical_stock',
        'difference',
        'note',
        'opname_date',
    ];

    protected $casts = [
        'opname_date' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}