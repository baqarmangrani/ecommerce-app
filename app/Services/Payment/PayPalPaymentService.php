<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Log;

class PayPalPaymentService implements PaymentServiceInterface
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
                if ($paymentDetails['card_number'] === 'invalid_card_number') {
                    throw new \Exception('Invalid card number');
                }
                return true;
            } else {
                throw new \Exception('Missing payment details');
            }
        } catch (\Exception $e) {
            Log::error('Stripe payment processing error: ' . $e->getMessage());
            return false;
        }
    }
}