@extends('layouts.app')

@section('content')
<div class="mb-10 border-b-4 border-black pb-4 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
    <h2 class="text-4xl font-black uppercase tracking-tight">Command Center</h2>
    <div class="flex space-x-4">
        <a href="{{ route('categories.index') }}" class="border-2 border-black bg-white px-6 py-2 text-sm font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-colors shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">Categories</a>
        <a href="{{ route('cameras.index') }}" class="border-2 border-black bg-white px-6 py-2 text-sm font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-colors shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">Cameras</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <!-- Stat Cards with Brutalist Design -->
    <div class="border-4 border-black bg-white p-6 relative shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
        <div class="absolute top-0 right-0 w-8 h-8 bg-black"></div>
        <h3 class="text-sm font-bold uppercase tracking-widest text-gray-500 mb-2 border-b-2 border-black pb-2 inline-block">Total Camera</h3>
        <p class="text-5xl font-black">{{ $camerasCount }}</p>
    </div>
    
    <div class="border-4 border-black bg-black text-white p-6 relative shadow-[8px_8px_0px_0px_rgba(0,0,0,0.2)] hover:translate-x-1 hover:translate-y-1 hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,0.2)] transition-all">
        <div class="absolute top-0 right-0 w-8 h-8 bg-white"></div>
        <h3 class="text-sm font-bold uppercase tracking-widest text-gray-400 mb-2 border-b-2 border-white pb-2 inline-block">Active Rentals</h3>
        <p class="text-5xl font-black">{{ $activeRentalsCount }}</p>
    </div>

    <div class="border-4 border-black bg-yellow-300 p-6 relative shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
        <div class="absolute top-0 right-0 w-8 h-8 bg-black"></div>
        <h3 class="text-sm font-bold uppercase tracking-widest text-black mb-2 border-b-2 border-black pb-2 inline-block">Waiting for Verification</h3>
        <p class="text-5xl font-black">{{ $pendingPaymentsCount }}</p>
    </div>

    <div class="border-4 border-black bg-red-500 text-white p-6 relative shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
        <div class="absolute top-0 right-0 w-8 h-8 bg-black"></div>
        <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-2 border-b-2 border-black pb-2 inline-block">Late Rentals</h3>
        <p class="text-5xl font-black">{{ $lateRentals->count() }}</p>
    </div>
</div>

@if($lateRentals->count() > 0)
    <div class="border-4 border-black bg-red-500 text-white p-6 mb-12 relative shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transform -rotate-1">
        <div class="flex items-start">
            <svg class="h-10 w-10 text-black mt-1 bg-white p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div class="ml-6">
                <h3 class="text-2xl font-black uppercase tracking-tight mb-2">
                    Alert: {{ $lateRentals->count() }} Late Rentals!
                </h3>
                <div class="mt-4">
                    <ul class="list-none space-y-2">
                        @foreach($lateRentals as $late)
                            @php
                                $days_late = abs(now()->startOfDay()->diffInDays($late->end_date->startOfDay()));
                                $estimated_fine = $days_late * $late->camera->price_per_day;
                            @endphp
                            <li class="border-b border-black pb-2 flex justify-between font-bold">
                                <span>{{ $late->user->name }} - {{ $late->camera->name }} <span class="text-xs text-red-200 ml-2 font-black tracking-widest">(+Rp {{ number_format($estimated_fine, 0, ',', '.') }})</span></span>
                                <span class="bg-black text-white px-2 uppercase tracking-widest text-xs py-1">Due: {{ $late->end_date->format('d M Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] mb-12">
    <div class="border-b-4 border-black p-6 bg-gray-50 flex justify-between items-center">
        <h3 class="text-2xl font-black uppercase tracking-tight">Transactions Log</h3>
    </div>
    <div class="overflow-x-auto p-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b-4 border-black pb-4 text-sm font-bold uppercase tracking-widest w-1/4">Customer</th>
                    <th class="border-b-4 border-black pb-4 text-sm font-bold uppercase tracking-widest w-1/4">Order Details</th>
                    <th class="border-b-4 border-black pb-4 text-sm font-bold uppercase tracking-widest w-1/4">Status</th>
                    <th class="border-b-4 border-black pb-4 text-sm font-bold uppercase tracking-widest w-1/4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-gray-200">
                @forelse($rentals as $rental)
                <tr class="hover:bg-gray-50 transition-colors group">
                    <td class="py-6 pr-4">
                        <div class="font-black uppercase tracking-tight text-lg">{{ $rental->user->name }}</div>
                        <div class="text-sm font-medium text-gray-500 mt-1">{{ $rental->user->email }}</div>
                    </td>
                    <td class="py-6 px-4">
                        <div class="font-bold border border-black inline-block px-2 py-0.5 mb-2 bg-black text-white">{{ $rental->camera->name }}</div>
                        <div class="text-sm font-bold flex gap-4 mt-2">
                            <span>Start Date: {{ $rental->start_date->format('d/m/y') }}</span>
                            <span>End Date: {{ $rental->end_date->format('d/m/y') }}</span>
                        </div>
                        <div class="font-black text-lg mt-2">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</div>
                    </td>
                    <td class="py-6 px-4">
                        @if($rental->status == 'pending')
                            <span class="border-2 border-black bg-yellow-300 px-3 py-1 text-xs font-black uppercase tracking-widest shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                Pending
                            </span>
                        @elseif($rental->status == 'approved')
                            <span class="border-2 border-black bg-blue-400 px-3 py-1 text-xs font-black uppercase tracking-widest shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                Approved
                            </span>
                        @elseif($rental->status == 'completed')
                            <span class="border-2 border-black bg-green-400 px-3 py-1 text-xs font-black uppercase tracking-widest shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                Completed
                            </span>
                        @else
                            <span class="border-2 border-black bg-gray-200 px-3 py-1 text-xs font-black uppercase tracking-widest">
                                {{ $rental->status }}
                            </span>
                        @endif

                        @if($rental->payment && $rental->payment->status == 'pending')
                            <div class="mt-4 text-xs font-black uppercase tracking-widest text-red-600 flex items-center gap-1 animate-pulse">
                                <div class="w-2 h-2 bg-red-600 rounded-full"></div>
                                Check Payment
                            </div>
                        @endif
                    </td>
                    <td class="py-6 pl-4 text-right">
                        @if($rental->payment && $rental->payment->status == 'pending')
                            <div class="flex flex-col items-end gap-2">
                                <a href="{{ asset('storage/' . $rental->payment->payment_proof) }}" target="_blank" class="border-2 border-black bg-white px-4 py-1 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-colors">Check Payment</a>
                                
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.payments.verify', $rental->payment->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="verified">
                                        <button type="submit" class="border-2 border-black bg-black text-white px-4 py-1 text-xs font-bold uppercase tracking-widest hover:bg-green-500 transition-colors">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.payments.verify', $rental->payment->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="border-2 border-black bg-white text-black px-4 py-1 text-xs font-bold uppercase tracking-widest hover:bg-red-500 hover:text-white transition-colors">Reject</button>
                                    </form>
                                </div>
                            </div>
                        @elseif($rental->status == 'approved')
                            <form action="{{ route('admin.rentals.return', $rental->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="border-2 border-black bg-black text-white px-6 py-3 text-xs font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">Return</button>
                            </form>
                        @else
                            <span class="text-xs font-bold uppercase tracking-widest text-gray-400">No Action</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 text-center text-gray-500 font-bold uppercase tracking-widest">
                        No transactions recorded yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
