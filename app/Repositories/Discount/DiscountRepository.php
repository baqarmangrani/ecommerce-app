<?php

namespace App\Repositories\Discount;


use App\Models\Discount;

class DiscountRepository implements DiscountRepositoryInterface
{
    public function findByDiscountCode(string $code)
    {
        return Discount::where('code', $code)->first();
    }
}
