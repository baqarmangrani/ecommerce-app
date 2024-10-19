<?php

namespace App\Repositories\InventoryLog;

use App\Models\InventoryLog;

class InventoryLogRepository implements InventoryLogRepositoryInterface
{
    public function all()
    {
        return InventoryLog::all();
    }

    public function find($id)
    {
        return InventoryLog::find($id);
    }

    public function create(array $data)
    {
        return InventoryLog::create($data);
    }

    public function update($id, array $data)
    {
        $inventoryLog = InventoryLog::find($id);
        if ($inventoryLog) {
            $inventoryLog->update($data);
            return $inventoryLog;
        }
        return null;
    }

    public function delete($id)
    {
        $inventoryLog = InventoryLog::find($id);
        if ($inventoryLog) {
            return $inventoryLog->delete();
        }
        return false;
    }
}