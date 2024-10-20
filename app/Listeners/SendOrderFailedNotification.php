<?php

namespace App\Listeners;

use App\Events\OrderFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderFailedMail;

class SendOrderFailedNotification implements ShouldQueue
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
    public function handle(OrderFailed $event)
    {
        Mail::to($event->order->user->email)->send(new OrderFailedMail($event->order, $event->exception));
    }
}
