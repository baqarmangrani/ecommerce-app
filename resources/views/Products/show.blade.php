<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ $product->name }}</h3>
                    <p><strong>Description:</strong> {{ $product->description }}</p>
                    <p><strong>Price:</strong> {{ $product->price }}</p>
                    <p><strong>Category:</strong> {{ $product->category->name }}</p>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-4">Back to Products</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
