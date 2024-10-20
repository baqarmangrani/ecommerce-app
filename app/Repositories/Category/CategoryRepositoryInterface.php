<?php

namespace App\Repositories\Category;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function all($paginate = null);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}