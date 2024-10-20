<?php

namespace App\Http;

use App\Http\Middleware\ApplyDiscounts;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        // Other middleware...
        'apply.discounts' => ApplyDiscounts::class,
    ];
}