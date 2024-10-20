<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Place Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="products" class="block text-gray-700">Products</label>
                            <div id="products">
                                <div class="flex items-center mb-2 product-row">
                                    <select name="products[0][product_id]"
                                        class="mr-2 w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">Select a product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-stock="{{ $product->quantity }}">
                                                {{ $product->name }} (Stock: {{ $product->quantity }})</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="products[0][quantity]" min="1"
                                        class="ml-2 w-20 border-gray-300 rounded-md shadow-sm" placeholder="Quantity">
                                    <button type="button" class="ml-2 text-green-500 add-product">+</button>
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Place
                            Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let productIndex = 1;

            document.querySelector('.add-product').addEventListener('click', function() {
                const productRow = document.querySelector('.product-row').cloneNode(true);
                productRow.querySelector('select').name = `products[${productIndex}][product_id]`;
                productRow.querySelector('input[type="number"]').name =
                    `products[${productIndex}][quantity]`;
                productRow.querySelector('input[type="number"]').value = '';
                productRow.querySelector('.add-product').addEventListener('click', function() {
                    productIndex++;
                    const newProductRow = productRow.cloneNode(true);
                    newProductRow.querySelector('select').name =
                        `products[${productIndex}][product_id]`;
                    newProductRow.querySelector('input[type="number"]').name =
                        `products[${productIndex}][quantity]`;
                    newProductRow.querySelector('input[type="number"]').value = '';
                    document.getElementById('products').appendChild(newProductRow);
                });
                document.getElementById('products').appendChild(productRow);
                productIndex++;
            });
        });
    </script>
</x-dashboard-layout>
