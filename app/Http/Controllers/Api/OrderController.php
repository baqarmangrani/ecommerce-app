<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessOrder;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Payment\PaymentServiceInterface;
use Auth;
use Illuminate\Http\Request;

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
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'card_number' => ['required', 'string', 'regex:/^\d{16}$/'],
            'expiry_date' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
            'cvv' => ['required', 'string', 'regex:/^\d{3,4}$/'],
        ]);

        $totalPrice = 0;
        $orderItems = [];

        foreach ($request->products as $productData) {
            $product = $this->productRepository->find($productData['product_id']);

            if ($product->quantity < $productData['quantity']) {
                return response()->json(['error' => 'The selected quantity exceeds available stock for product ID ' . $productData['product_id']], 400);
            }

            $productPrice = $product->price;

            if ($request->has('discount')) {
                $discount = $request->discount;
                if ($discount->type == 'percentage') {
                    $productPrice -= ($productPrice * ($discount->value / 100));
                } else {
                    $productPrice -= $discount->value;
                }
            }

            $totalPrice += $productPrice * $productData['quantity'];

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $productData['quantity'],
                'price' => $productPrice,
            ];
        }

        $paymentDetails = [
            'card_number' => $request->card_number,
            'expiry_date' => $request->expiry_date,
            'cvv' => $request->cvv,
        ];

        if (!$this->paymentService->processPayment($paymentDetails)) {
            return response()->json(['error' => 'Payment processing failed. Please check your card details and try again.'], 400);
        }

        $orderData = [
            'user_id' => Auth::id(),
            'order_number' => $this->generateOrderNumber(),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'paid',
            'payment_method' => $request->payment_method,
        ];

        $order = $this->orderRepository->create($orderData);
        ProcessOrder::dispatch($order, $orderItems);

        return response()->json(['success' => 'Order placed successfully. Your order number is ' . $order->order_number], 201);
    }

    private function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid());
    }
}
