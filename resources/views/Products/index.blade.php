<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
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

                    <div class="flex justify-between mb-4">
                        <a href="{{ route('products.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create
                            Product</a>
                        <button id="restock-button"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Restock
                            Product</button>
                    </div>

                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Description</th>
                                <th class="py-2 px-4 border-b">Price</th>
                                <th class="py-2 px-4 border-b">Current Stock</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $product->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ Str::limit($product->description, 50, '...') }}
                                    <td class="py-2">${{ number_format($product->price, 2) }}</td>
                                    <td class="py-2 px-4 border-b">{{ $product->quantity }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">View</a>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
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
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Restock Modal -->
    <div id="restock-modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Restock Product
                            </h3>
                            <div class="mt-2">
                                <form id="restock-form" action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label for="product_id" class="block text-gray-700">Product</label>
                                        <select id="product_id" name="product_id"
                                            class="w-full border-gray-300 rounded-md shadow-sm" required>
                                            <option value="">Select a product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    data-quantity="{{ $product->quantity }}">{{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="current_quantity" class="block text-gray-700">Current
                                            Quantity</label>
                                        <input type="number" id="current_quantity" name="current_quantity"
                                            class="w-full border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div class="mb-4">
                                        <label for="quantity" class="block text-gray-700">Restock Quantity</label>
                                        <input type="number" id="quantity" name="quantity" min="1"
                                            class="w-full border-gray-300 rounded-md shadow-sm" required>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="button" id="cancel-button"
                                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancel</button>
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Restock</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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

            const restockButton = document.getElementById('restock-button');
            const restockModal = document.getElementById('restock-modal');
            const cancelButton = document.getElementById('cancel-button');
            const restockForm = document.getElementById('restock-form');
            const productSelect = document.getElementById('product_id');
            const currentQuantityInput = document.getElementById('current_quantity');

            restockButton.addEventListener('click', function() {
                restockModal.classList.remove('hidden');
            });

            cancelButton.addEventListener('click', function() {
                restockModal.classList.add('hidden');
            });

            productSelect.addEventListener('change', function() {
                const selectedOption = productSelect.selectedOptions[0];
                const currentQuantity = selectedOption.getAttribute('data-quantity');
                currentQuantityInput.value = currentQuantity;
            });

            restockForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const productId = productSelect.value;
                if (productId) {
                    restockForm.action = `/products/restock/${productId}`;
                    restockForm.submit();
                }
            });
        });
    </script>
</x-dashboard-layout>
