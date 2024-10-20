<?php

namespace App\Repositories\Tag;

interface TagRepositoryInterface
{
    public function all($paginate = null);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}