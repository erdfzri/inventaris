<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $elektronik = Category::where('name', 'Elektronik')->first();
        $dapur = Category::where('name', 'Alat Dapur')->first();

        if ($elektronik) {
            Item::create(['category_id' => $elektronik->id, 'name' => 'Komputer', 'total_stock' => 130, 'repair_stock' => 3]);
            Item::create(['category_id' => $elektronik->id, 'name' => 'Leptop', 'total_stock' => 210, 'repair_stock' => 0]);
        }

        if ($dapur) {
            Item::create(['category_id' => $dapur->id, 'name' => 'Piring', 'total_stock' => 100, 'repair_stock' => 0]);
            Item::create(['category_id' => $dapur->id, 'name' => 'Gelas', 'total_stock' => 89, 'repair_stock' => 0]);
        }
    }
}
