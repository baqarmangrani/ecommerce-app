<?php

namespace Tests\Unit;

use App\Services\Payment\PayPalPaymentService;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PayPalPaymentServiceTest extends TestCase
{
    /** @test */
    public function it_processes_payment_successfully()
    {
        $paymentService = new PayPalPaymentService();
        $paymentDetails = [
            'card_number' => '4242424242424242',
            'expiry_date' => '12/23',
            'cvv' => '123',
        ];

        $result = $paymentService->processPayment($paymentDetails);

        $this->assertTrue($result);
    }

    /** @test */
    public function it_fails_to_process_payment_with_missing_details()
    {
        $paymentService = new PayPalPaymentService();
        $paymentDetails = [
            'card_number' => '4242424242424242',
            'expiry_date' => '12/23',
            // 'cvv' is missing
        ];

        $result = $paymentService->processPayment($paymentDetails);

        $this->assertFalse($result);
    }

    /** @test */
    public function it_logs_error_on_exception()
    {
        Log::shouldReceive('error')->once();

        $paymentService = new PayPalPaymentService();
        $paymentDetails = [
            'card_number' => 'invalid_card_number',
            'expiry_date' => '12/23',
            'cvv' => '123',
        ];

        $result = $paymentService->processPayment($paymentDetails);

        $this->assertFalse($result);
    }
}