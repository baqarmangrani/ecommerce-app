<?php

namespace Database\Seeders;

use App\Models\InventoryLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventoryLogSeeder extends Seeder
{
    public function run()
    {
        InventoryLog::factory()->count(100)->create();
    }
}
