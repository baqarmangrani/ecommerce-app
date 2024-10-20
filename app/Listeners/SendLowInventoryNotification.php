<?php

namespace App\Listeners;

use App\Events\LowInventory;
use App\Mail\LowInventoryMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendLowInventoryNotification
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LowInventory $event)
    {
        Mail::to($event->product->orders->email)->send(new LowInventoryMail($event->product));
    }
}
