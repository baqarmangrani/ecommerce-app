<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" name="name" id="name"
                                class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $product->name }}"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700">Description</label>
                            <textarea name="description" id="description" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ $product->description }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700">Price</label>
                            <input type="number" name="price" id="price"
                                class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $product->price }}"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="category_id" class="block text-gray-700">Category</label>
                            <select name="category_id" id="category_id"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
