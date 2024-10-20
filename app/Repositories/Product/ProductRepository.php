<?php

namespace App\Repositories\Product;

use App\Models\InventoryLog;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
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
        $product = Product::find($id);
        if ($product) {
            $product->increment('quantity', $quantity);

            InventoryLog::create([
                'product_id' => $id,
                'quantity_change' => $quantity,
                'type' => 'addition',
                'comments' => "Restocked $quantity units.",
            ]);

            return $product;
        }
        return null;
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

    public function all($paginate = null, Request $request = null)
    {
        $query = Product::query();

        // Filtering
        if ($request && $request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Searching
        if ($request && $request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Pagination
        if ($paginate) {
            return $query->paginate($paginate);
        }

        return $query->get();
    }
}