<?php

namespace App\Models;

use App\Enums\UnitEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'stock_quantity',
        'stock_alert_sent',
        'initial_stock_quantity',
        'unit'
    ];

    protected $casts = [
        'unit' => UnitEnum::class,
        'stock_quantity' => 'decimal:3',
        'stock_alert_sent' => 'boolean',
    ];

}
