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
                    <h3 class="text-lg font-semibold mb-4">Order #{{ $order->id }}</h3>
                    <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Total:</strong> {{ $order->total }}</p>
                    <p><strong>Status:</strong> {{ $order->status }}</p>
                    <a href="{{ route('orders.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-4 inline-block">Back
                        to Orders</a>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
