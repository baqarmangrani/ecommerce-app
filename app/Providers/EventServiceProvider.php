<?php

namespace App\Providers;

use App\Listeners\SendLowInventoryNotification;
use Illuminate\Support\ServiceProvider;
use App\Events\OrderPlaced;
use App\Listeners\SendOrderNotification;
use App\Events\OrderFailed;
use App\Listeners\SendOrderFailedNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderPlaced::class => [
            SendOrderNotification::class,
        ],
        OrderFailed::class => [
            SendOrderFailedNotification::class,
        ],
        LowInventory::class => [
            SendLowInventoryNotification::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
