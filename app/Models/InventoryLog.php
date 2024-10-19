<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $fillable = ['product_id', 'quantity_change', 'type', 'comments'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}