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
                                        class="mr-2 w-full border-gray-300 rounded-md shadow-sm product-select"
                                        required>
                                        <option value="">Select a product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                data-stock="{{ $product->quantity }}">{{ $product->name }} (Stock:
                                                {{ $product->quantity }}, Price: ${{ $product->price }})</option>
                                        @endforeach
                                    </select>
                                    <select name="products[0][quantity]"
                                        class="ml-2 w-20 border-gray-300 rounded-md shadow-sm quantity-select" disabled
                                        required>
                                        <option value="">Quantity</option>
                                    </select>
                                    <span class="ml-2 product-price">$0.00</span>
                                    <button type="button" class="ml-2 text-green-500 add-product">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="payment_method" class="block text-gray-700">Payment Method</label>
                            <select name="payment_method" id="payment_method"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="payment_status" class="block text-gray-700">Payment Status</label>
                            <select name="payment_status" id="payment_status"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="card_number" class="block text-gray-700">Card Number</label>
                            <input type="text" name="card_number" id="card_number"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="expiry_date" class="block text-gray-700">Expiry Date</label>
                            <input type="text" name="expiry_date" id="expiry_date"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="cvv" class="block text-gray-700">CVV</label>
                            <input type="text" name="cvv" id="cvv"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="total_price" class="block text-gray-700">Total Price</label>
                            <span id="total_price" class="block text-gray-900">$0.00</span>
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

            function updateTotalPrice() {
                let totalPrice = 0;
                document.querySelectorAll('.product-row').forEach(function(row) {
                    const price = parseFloat(row.querySelector('.product-select').selectedOptions[0]
                        .getAttribute('data-price') || 0);
                    const quantity = parseInt(row.querySelector('.quantity-select').value || 0);
                    totalPrice += price * quantity;
                });
                document.getElementById('total_price').textContent = `$${totalPrice.toFixed(2)}`;
            }

            function populateQuantityOptions(selectElement, maxQuantity) {
                selectElement.innerHTML = '<option value="">Quantity</option>';
                for (let i = 1; i <= maxQuantity; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = i;
                    selectElement.appendChild(option);
                }
            }

            document.querySelector('.add-product').addEventListener('click', function() {
                const productRow = document.querySelector('.product-row').cloneNode(true);
                productRow.querySelector('select[name^="products"]').name =
                    `products[${productIndex}][product_id]`;
                productRow.querySelector('.quantity-select').name = `products[${productIndex}][quantity]`;
                productRow.querySelector('.quantity-select').disabled = true;
                productRow.querySelector('.product-price').textContent = '$0.00';
                productRow.querySelector('.add-product').addEventListener('click', function() {
                    productIndex++;
                    const newProductRow = productRow.cloneNode(true);
                    newProductRow.querySelector('select[name^="products"]').name =
                        `products[${productIndex}][product_id]`;
                    newProductRow.querySelector('.quantity-select').name =
                        `products[${productIndex}][quantity]`;
                    newProductRow.querySelector('.quantity-select').disabled = true;
                    newProductRow.querySelector('.product-price').textContent = '$0.00';
                    document.getElementById('products').appendChild(newProductRow);
                });
                document.getElementById('products').appendChild(productRow);
                productIndex++;
            });

            document.getElementById('products').addEventListener('change', function(event) {
                if (event.target.classList.contains('product-select')) {
                    const row = event.target.closest('.product-row');
                    const price = parseFloat(event.target.selectedOptions[0].getAttribute('data-price') ||
                        0);
                    const stock = parseInt(event.target.selectedOptions[0].getAttribute('data-stock') || 0);
                    const quantitySelect = row.querySelector('.quantity-select');
                    populateQuantityOptions(quantitySelect, stock);
                    quantitySelect.disabled = false;
                    row.querySelector('.product-price').textContent =
                        `$${(price * (quantitySelect.value || 0)).toFixed(2)}`;
                    updateTotalPrice();
                } else if (event.target.classList.contains('quantity-select')) {
                    const row = event.target.closest('.product-row');
                    const price = parseFloat(row.querySelector('.product-select').selectedOptions[0]
                        .getAttribute('data-price') || 0);
                    const quantity = parseInt(event.target.value || 0);
                    row.querySelector('.product-price').textContent = `$${(price * quantity).toFixed(2)}`;
                    updateTotalPrice();
                }
            });
        });
    </script>
</x-dashboard-layout>
