<?php

use App\Services\Payment\PaymentServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can process a payment', function () {
    $paymentService = app(PaymentServiceInterface::class);
    $paymentDetails = [
        'card_number' => '1234567812345678',
        'expiry_date' => '12/23',
        'cvv' => '123',
    ];

    $result = $paymentService->processPayment($paymentDetails);

    expect($result)->toBeTrue();
});