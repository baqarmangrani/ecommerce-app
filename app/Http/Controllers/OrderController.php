<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Jobs\ProcessOrder;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Payment\PaymentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $userRepository;
    protected $productRepository;
    protected $paymentService;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        UserRepositoryInterface $userRepository,
        ProductRepositoryInterface $productRepository,
        PaymentServiceInterface $paymentService
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->paymentService = $paymentService;

    }

    public function index()
    {
        $orders = $this->orderRepository->all(10); // Paginate with 10 items per page
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = $this->productRepository->all()->filter(function ($product) {
            return $product->quantity > 0;
        });
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'card_number' => ['required', 'string', 'regex:/^\d{16}$/'],
            'expiry_date' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
            'cvv' => ['required', 'string', 'regex:/^\d{3,4}$/'],
        ]);

        $totalPrice = 0;
        $orderItems = [];

        foreach ($request->products as $productData) {
            $product = $this->productRepository->find($productData['product_id']);

            if ($product->quantity < $productData['quantity']) {
                return back()->withErrors(['quantity' => 'The selected quantity exceeds available stock for product ID ' . $productData['product_id']]);
            }

            $productPrice = $product->price;

            if ($request->has('discount')) {
                $discount = $request->discount;
                dd($discount);
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
            return back()->withErrors(['payment' => 'Payment processing failed. Please check your card details and try again.']);
        }

        $orderData = [
            'user_id' => Auth::id(),
            'order_number' => $this->generateOrderNumber(),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => $request->payment_status,
            'payment_method' => $request->payment_method,
        ];

        $order = $this->orderRepository->create($orderData);

        ProcessOrder::dispatch($order, $orderItems);

        return redirect()->route('orders.index')->with('success', 'Order placed successfully. Please check your email for confirmation. Your order number is ' . $order->order_number);
    }

    private function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    public function show($id)
    {
        $order = $this->orderRepository->find($id);
        return view('orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = $this->orderRepository->find($id);
        $users = $this->userRepository->all();
        return view('orders.edit', compact('order', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
        ]);

        $this->orderRepository->update($id, $request->all());

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy($id)
    {
        $this->orderRepository->delete($id);

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
