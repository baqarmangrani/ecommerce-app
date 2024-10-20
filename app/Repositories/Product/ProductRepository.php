<?php

namespace App\Repositories\Product;

use App\Models\InventoryLog;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all($paginate = null)
    {
        if ($paginate) {
            return Product::paginate($paginate);
        }
        return Product::all();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = Product::find($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $product;
    }

    public function getLowStockProducts($limit)
    {
        return Product::where('quantity', '<', $limit)->get();
    }

    public function restock($id, $quantity)
    {
        $product = Product::findOrFail($id);
        $product->increment('quantity', $quantity);

        InventoryLog::create([
            'product_id' => $product->id,
            'quantity_change' => $quantity, // Positive value for restock
            'type' => 'restock',
            'comments' => 'Restocked ' . $quantity . ' units.',
        ]);

        return $product;
    }

    public function reduceStock($id, $quantity)
    {
        $product = Product::findOrFail($id);

        if ($product->quantity < $quantity) {
            throw new \Exception('Insufficient stock available.');
        }

        $product->decrement('quantity', $quantity);

        InventoryLog::create([
            'product_id' => $id,
            'quantity_change' => -$quantity,
            'type' => 'subtraction', // Use a valid value
            'comments' => "Sold $quantity units.",
        ]);

        return $product;
    }
}