<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\Supplier;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'category_id',
        'supplier_id',
        'buy_price',
        'sell_price',
        'stock',
        'min_stock',
        'unit',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function stockTransactions()
{
    return $this->hasMany(StockTransaction::class);
}
public function stockOpnames()
{
    return $this->hasMany(StockOpname::class);
}
public function attributes()
{
    return $this->hasMany(ProductAttribute::class);
}
}