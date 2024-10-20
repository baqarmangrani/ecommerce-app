<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div id="success-message" class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4">Order List</h3>
                    <a href="{{ route('orders.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Create
                        Order</a>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Order Number</th>
                                <th class="py-2 px-4 border-b">Customer</th>
                                <th class="py-2 px-4 border-b">Total Price</th>
                                <th class="py-2 px-4 border-b">Status</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $order->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->order_number }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->total_price }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->status }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('orders.show', $order->id) }}"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">View</a>
                                        <a href="{{ route('orders.edit', $order->id) }}"
                                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000); // Hide after 3 seconds
            }
        });
    </script>
</x-dashboard-layout>
