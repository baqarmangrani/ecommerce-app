<?php

namespace App\Repositories\Product;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function restock($id, $quantity);
    public function reduceStock($id, $quantity);
    public function getLowStockProducts($limit);
}