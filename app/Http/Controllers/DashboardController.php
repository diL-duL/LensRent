<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rental;
use App\Models\Camera;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function customerDashboard()
    {
        $rentals = Rental::where('user_id', Auth::id())->with(['camera', 'payment'])->orderBy('created_at', 'desc')->get();
        return view('customer.dashboard', compact('rentals'));
    }

    public function adminDashboard()
    {
        $rentals = Rental::with(['user', 'camera', 'payment'])->orderBy('created_at', 'desc')->get();
        $camerasCount = Camera::count();
        $activeRentalsCount = Rental::where('status', 'approved')->count();
        $pendingPaymentsCount = Rental::whereHas('payment', function($q) {
            $q->where('status', 'pending');
        })->count();

        // Check for late returns
        $lateRentals = Rental::where('status', 'approved')
            ->where('end_date', '<', now()->toDateString())
            ->get();

        return view('admin.dashboard', compact('rentals', 'camerasCount', 'activeRentalsCount', 'pendingPaymentsCount', 'lateRentals'));
    }
}
