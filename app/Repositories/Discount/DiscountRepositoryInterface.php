<?php

namespace App\Repositories\Discount;

use App\Models\Order;

interface DiscountRepositoryInterface
{
    public function findByDiscountCode(string $code);
}