<?php

namespace App\Services\Payment;

interface PaymentServiceInterface
{
    public function processPayment(array $paymentDetails): bool;
}
