<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'DSLR',
            'description' => 'Kamera Digital Single-Lens Reflex'
        ]);
        
        Category::create([
            'name' => 'Mirrorless',
            'description' => 'Kamera tanpa cermin mekanis, lebih ringan'
        ]);
        
        Category::create([
            'name' => 'Action Camera',
            'description' => 'Kamera tahan banting untuk olahraga dan aksi'
        ]);
    }
}
