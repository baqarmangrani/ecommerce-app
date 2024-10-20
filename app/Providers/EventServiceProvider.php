<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\OrderPlaced;
use App\Listeners\SendOrderNotification;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        OrderPlaced::class => [
            SendOrderNotification::class,
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
