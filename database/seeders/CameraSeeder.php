<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Camera;
use App\Models\Category;

class CameraSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori ada
        $katDSLR = Category::where('name', 'DSLR')->first();
        $katMirrorless = Category::where('name', 'Mirrorless')->first();
        $katAction = Category::where('name', 'Action Camera')->first();

        if($katDSLR) {
            Camera::create([
                'category_id' => $katDSLR->id,
                'name' => 'Canon EOS 5D Mark IV',
                'brand' => 'Canon',
                'price_per_day' => 250000,
                'status' => 'available',
                'description' => 'Kamera full-frame andalan para profesional.'
            ]);
        }

        if($katMirrorless) {
            Camera::create([
                'category_id' => $katMirrorless->id,
                'name' => 'Sony A7 III',
                'brand' => 'Sony',
                'price_per_day' => 300000,
                'status' => 'rented',
                'description' => 'Mirrorless serbaguna dengan autofokus cepat.'
            ]);
        }

        if($katAction) {
            Camera::create([
                'category_id' => $katAction->id,
                'name' => 'GoPro Hero 11',
                'brand' => 'GoPro',
                'price_per_day' => 100000,
                'status' => 'rented',
                'description' => 'Rekam aksimu dengan stabil dan resolusi tinggi.'
            ]);
        }
    }
}
