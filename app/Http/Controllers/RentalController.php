<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rental;
use App\Models\Camera;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'camera_id' => 'required|exists:cameras,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $camera = Camera::findOrFail($request->camera_id);
        
        if ($camera->status !== 'available') {
            return back()->with('error', 'Camera is currently not available.');
        }

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end) + 1;
        $total_price = $days * $camera->price_per_day;

        $rental = Rental::create([
            'user_id' => Auth::id(),
            'camera_id' => $camera->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $total_price,
            'status' => 'pending'
        ]);

        $camera->update(['status' => 'rented']);

        return redirect()->route('dashboard')->with('success', 'Camera has been successfully booked. Please upload proof of payment.');
    }

    public function returnCamera(Request $request, Rental $rental)
    {
        if ($rental->status === 'completed') {
            return back()->with('error', 'Camera has already been returned.');
        }

        $actual_return_date = Carbon::now();
        $end_date = Carbon::parse($rental->end_date);
        
        $late_fine = 0;
        if ($actual_return_date->startOfDay()->gt($end_date->startOfDay())) {
            $days_late = $end_date->diffInDays($actual_return_date->startOfDay());
            $late_fine = $days_late * $rental->camera->price_per_day;
        }

        $rental->update([
            'actual_return_date' => $actual_return_date,
            'late_fine' => $late_fine,
            'status' => 'completed'
        ]);

        $rental->camera->update(['status' => 'available']);

        return back()->with('success', 'Camera has been successfully returned. Total fine: Rp ' . number_format($late_fine, 0, ',', '.'));
    }
}
