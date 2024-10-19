@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Product Details</h1>
        <div class="card">
            <div class="card-header">
                {{ $product->name }}
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> {{ $product->description }}</p>
                <p><strong>Price:</strong> {{ $product->price }}</p>
                <p><strong>Category:</strong> {{ $product->category->name }}</p>
            </div>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back to Products</a>
    </div>
@endsection
