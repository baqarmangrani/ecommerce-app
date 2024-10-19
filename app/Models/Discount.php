<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_code',
        'amount',
        'type',
    ];

    public function applyTo(float $total): float
    {
        if ($this->type === 'flat') {
            return max($total - $this->amount, 0);
        } elseif ($this->type === 'percentage') {
            return max($total - ($total * ($this->amount / 100)), 0);
        }

        return $total;
    }
}
