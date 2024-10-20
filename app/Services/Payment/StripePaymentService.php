<?php

namespace App\Services\Payment;

use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\Log;

class StripePaymentService implements PaymentServiceInterface
{
    public function __construct()
    {

    }

    public function processPayment(array $paymentDetails): bool
    {
        try {
            if (
                isset($paymentDetails['card_number'])
                &&
                isset($paymentDetails['expiry_date'])
                &&
                isset($paymentDetails['cvv'])
            ) {
                return true;
            }
        } catch (\Exception $e) {
            Log::error('Stripe payment processing error: ' . $e->getMessage());
        }
        return false;
    }
}
