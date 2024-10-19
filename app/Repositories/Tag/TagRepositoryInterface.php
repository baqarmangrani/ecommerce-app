<?php

namespace App\Repositories\Tag;

use App\Models\Tag;

interface TagRepositoryInterface
{
    public function all();
    public function find($id): ?Tag;
    public function create(array $data): Tag;
    public function update(Tag $tag, array $data): Tag;
    public function delete(Tag $tag): bool;
}