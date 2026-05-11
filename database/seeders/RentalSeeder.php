<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rental;
use App\Models\User;
use App\Models\Camera;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('email', 'budi@mail.com')->first();
        $cameraGoPro = Camera::where('name', 'GoPro Hero 11')->first();
        $cameraSony = Camera::where('name', 'Sony A7 III')->first();

        if($customer && $cameraGoPro) {
            // Rental Aktif (Belum Telat)
            Rental::create([
                'user_id' => $customer->id,
                'camera_id' => $cameraGoPro->id,
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(2),
                'total_price' => 300000,
                'status' => 'approved' 
            ]);
        }

        if($customer && $cameraSony) {
            // Rental Terlambat (Sudah lewat end_date)
            Rental::create([
                'user_id' => $customer->id,
                'camera_id' => $cameraSony->id,
                'start_date' => now()->subDays(5),
                'end_date' => now()->subDays(2), // Harusnya kembali 2 hari yang lalu
                'total_price' => 900000, // 3 hari sewa
                'status' => 'approved' 
            ]);
        }
    }
}
