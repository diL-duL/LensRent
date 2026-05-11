<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Rental;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $rentals = Rental::all();

        foreach($rentals as $rental) {
            Payment::create([
                'rental_id' => $rental->id,
                'payment_proof' => 'dummy_proof.jpg',
                'status' => 'verified'
            ]);
        }
    }
}
