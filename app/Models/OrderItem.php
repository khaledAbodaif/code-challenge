<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['total_price', 'quantity', 'unit_price', 'order_id', 'product_id'];

    protected $casts = [
        "unit_price" => "float",
        "total_price" => "float",
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
