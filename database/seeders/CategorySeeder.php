<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(['name' => 'Elektronik'], ['division_pj' => 'tefa']);
        Category::updateOrCreate(['name' => 'Alat Dapur'], ['division_pj' => 'Sarpras']);
    }
}
