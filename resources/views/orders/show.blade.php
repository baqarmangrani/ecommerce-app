<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Order Information</h3>
                    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                    <p><strong>Customer:</strong> {{ $order->user->name }}</p>
                    <p><strong>Total Price:</strong> {{ $order->total_price }}</p>
                    <p><strong>Status:</strong> {{ $order->status }}</p>
                    <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
                    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Discount:</strong> {{ $order->discount->discount_code ?? 'No Discount' }}</p>

                    <h3 class="text-lg font-semibold mt-6 mb-4">Order Items</h3>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Product</th>
                                <th class="py-2 px-4 border-b">Quantity</th>
                                <th class="py-2 px-4 border-b">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $item->product->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $item->quantity }}</td>
                                    <td class="py-2 px-4 border-b">{{ $item->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <a href="{{ route('orders.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-4 inline-block">Back
                        to Orders</a>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
