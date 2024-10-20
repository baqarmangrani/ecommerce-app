<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessOrder;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Payment\PaymentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $productRepository;
    protected $paymentService;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository,
        PaymentServiceInterface $paymentService
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->paymentService = $paymentService;
    }

    public function store(Request $request)
    {
        $this->validateOrder($request);

        $orderItems = [];
        $totalPrice = $this->calculateOrderDetails($request, $orderItems);

        $paymentDetails = $this->preparePaymentDetails($request);

        if (!$this->processPayment($paymentDetails)) {
            return response()->json(['error' => 'Payment processing failed. Please check your card details and try again.'], 400);
        }

        $orderData = $this->prepareOrderData($totalPrice, $request);

        $order = $this->orderRepository->create($orderData);
        ProcessOrder::dispatch($order, $orderItems);

        return response()->json(['success' => 'Order placed successfully. Your order number is ' . $order->order_number], 201);
    }

    private function validateOrder(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'card_number' => ['required', 'string', 'regex:/^\d{16}$/'],
            'expiry_date' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
            'cvv' => ['required', 'string', 'regex:/^\d{3,4}$/'],
        ]);
    }

    private function calculateOrderDetails(Request $request, array &$orderItems): float
    {
        $totalPrice = 0;

        foreach ($request->products as $productData) {
            $product = $this->productRepository->find($productData['product_id']);
            $this->checkProductAvailability($product, $productData['quantity']);

            $productPrice = $product->price;
            $productPrice = $this->applyDiscount($productPrice, $request->discount ?? null);

            $totalPrice += $productPrice * $productData['quantity'];
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $productData['quantity'],
                'price' => $productPrice,
            ];
        }

        return $totalPrice;
    }

    private function preparePaymentDetails(Request $request): array
    {
        return [
            'card_number' => $request->card_number,
            'expiry_date' => $request->expiry_date,
            'cvv' => $request->cvv,
        ];
    }

    private function processPayment(array $paymentDetails): bool
    {
        return $this->paymentService->processPayment($paymentDetails);
    }

    private function prepareOrderData(float $totalPrice, Request $request): array
    {
        return [
            'user_id' => Auth::id(),
            'order_number' => $this->generateOrderNumber(),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'paid',
            'payment_method' => $request->payment_method,
        ];
    }

    private function applyDiscount(float $productPrice, $discount): float
    {
        if ($discount) {
            if ($discount['type'] === 'percentage') {
                return $productPrice - ($productPrice * ($discount['value'] / 100));
            } else {
                return $productPrice - $discount['value'];
            }
        }
        return $productPrice;
    }

    private function checkProductAvailability($product, int $quantity): void
    {
        if ($product->quantity < $quantity) {
            abort(400, 'The selected quantity exceeds available stock for product ID ' . $product->id);
        }
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    private function validateUpdate(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);
    }
}