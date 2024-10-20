<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="order_number" class="block text-gray-700">Order Number</label>
                            <input type="text" name="order_number" id="order_number"
                                class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $order->order_number }}"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="user_id" class="block text-gray-700">Customer</label>
                            <select name="user_id" id="user_id" class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $order->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="total_price" class="block text-gray-700">Total Price</label>
                            <input type="number" name="total_price" id="total_price"
                                class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $order->total_price }}"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-gray-700">Status</label>
                            <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="payment_status" class="block text-gray-700">Payment Status</label>
                            <select name="payment_status" id="payment_status"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>
                                    Unpaid</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="payment_method" class="block text-gray-700">Payment Method</label>
                            <select name="payment_method" id="payment_method"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="credit_card"
                                    {{ $order->payment_method == 'credit_card' ? 'selected' : '' }}>Credit Card
                                </option>
                                <option value="paypal" {{ $order->payment_method == 'paypal' ? 'selected' : '' }}>
                                    PayPal</option>
                                <option value="bank_transfer"
                                    {{ $order->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                </option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="discount_id" class="block text-gray-700">Discount</label>
                            <select name="discount_id" id="discount_id"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">No Discount</option>
                                @foreach ($discounts as $discount)
                                    <option value="{{ $discount->id }}"
                                        {{ $order->discount_id == $discount->id ? 'selected' : '' }}>
                                        {{ $discount->discount_code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                    </form>

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
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
