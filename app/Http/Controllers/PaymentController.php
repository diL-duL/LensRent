<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function upload(Request $request, Rental $rental)
    {
        \Illuminate\Support\Facades\Gate::authorize('manage-rental', $rental);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payments', 'public');

        Payment::updateOrCreate(
            ['rental_id' => $rental->id],
            ['payment_proof' => $path, 'status' => 'pending']
        );

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);

        $payment->update(['status' => $request->status]);

        if ($request->status === 'verified') {
            $payment->rental->update(['status' => 'approved']);
        } else {
            // Jika reject, batalkan penyewaan dan buat kamera tersedia kembali
            $payment->rental->update(['status' => 'rejected']);
            $payment->rental->camera->update(['status' => 'tersedia']);
        }

        return back()->with('success', 'Status pembayaran berhasil diupdate.');
    }
}
