<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Discount\DiscountRepository;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Repositories\InventoryLog\InventoryLogRepository;
use App\Repositories\InventoryLog\InventoryLogRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderItem\OrderItemRepository;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Tag\TagRepository;
use App\Repositories\Tag\TagRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Payment\PaymentServiceInterface;
use App\Services\Payment\PayPalPaymentService;
use App\Services\Payment\StripePaymentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemRepository::class);
        $this->app->bind(DiscountRepositoryInterface::class, DiscountRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(InventoryLogRepositoryInterface::class, InventoryLogRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);

        $this->app->bind(PaymentServiceInterface::class, function ($app) {
            $paymentMethod = request()->input('payment_method');
            if ($paymentMethod === 'paypal') {
                return new PayPalPaymentService();
            }
            return new StripePaymentService();
        });
    }

    public function boot(): void
    {
        //
    }
}
