<?php

namespace App\Http\Middleware;

use App\Repositories\Discount\DiscountRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyDiscounts
{
    protected $discountRepository;

    public function __construct(DiscountRepositoryInterface $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $discountCode = $request->input('discount_code');
        if ($discountCode) {
            $discount = $this->discountRepository->findByDiscountCode($discountCode);
            if ($discount) {
                $orderTotal = $request->input('order_total');

                if ($discount->type === 'fixed') {
                    $orderTotal -= $discount->amount;
                } elseif ($discount->type === 'percentage') {
                    $orderTotal -= ($orderTotal * ($discount->amount / 100));
                }

                $request->merge(['order_total' => max($orderTotal, 0)]);
            }
        }

        // Continue with the request
        return $next($request);
    }
}
