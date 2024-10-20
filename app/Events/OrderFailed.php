<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $exception;

    public function __construct(Order $order, \Exception $exception)
    {
        $this->order = $order;
        $this->exception = $exception;
    }
}