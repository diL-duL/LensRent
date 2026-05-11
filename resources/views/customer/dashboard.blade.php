@extends('layouts.app')

@section('content')
<div class="mb-10 border-b-4 border-black pb-4 flex justify-between items-end">
    <h2 class="text-4xl font-black uppercase tracking-tight">My Orders</h2>
</div>
    
<div class="grid gap-8">
    @forelse($rentals as $rental)
    <div class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-6 md:p-8 flex flex-col md:flex-row gap-8">
        <!-- Status Indicator Side -->
        <div class="md:w-1/4 border-b-4 md:border-b-0 md:border-r-4 border-black pb-6 md:pb-0 md:pr-6 flex flex-col justify-center items-start md:items-center">
            <span class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Order Status</span>
            @if($rental->status == 'pending')
                <div class="border-4 border-black bg-yellow-300 text-black px-4 py-2 font-black uppercase tracking-widest transform -rotate-2">
                    Pending
                </div>
            @elseif($rental->status == 'approved')
                <div class="border-4 border-black bg-blue-400 text-black px-4 py-2 font-black uppercase tracking-widest transform -rotate-2">
                    Approved
                </div>
            @elseif($rental->status == 'completed')
                <div class="border-4 border-black bg-green-400 text-black px-4 py-2 font-black uppercase tracking-widest transform -rotate-2">
                    Completed
                </div>
            @else
                <div class="border-4 border-black bg-gray-200 text-black px-4 py-2 font-black uppercase tracking-widest transform -rotate-2">
                    {{ $rental->status }}
                </div>
            @endif
        </div>

        <!-- Details -->
        <div class="md:w-3/4 flex flex-col justify-between">
            <div>
                <h3 class="text-2xl font-black uppercase tracking-tight mb-1">{{ $rental->camera->name }}</h3>
                <p class="text-sm font-bold uppercase tracking-widest mb-6 border border-black inline-block px-2 py-1">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                
                <div class="grid grid-cols-2 gap-4 mb-6 bg-gray-50 border-2 border-black p-4">
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Start Date</span>
                        <span class="font-bold">{{ $rental->start_date->format('d M Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">End Date</span>
                        <span class="font-bold">{{ $rental->end_date->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Area -->
            <div class="mt-4 pt-6 border-t-4 border-black">
                @if($rental->status == 'pending')
                    @if($rental->payment)
                        @if($rental->payment->status == 'pending')
                            <div class="bg-black text-white p-4 font-bold tracking-wide uppercase text-sm border-2 border-black flex items-center justify-between">
                                <span>Proof of Payment Being Verified</span>
                                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        @elseif($rental->payment->status == 'rejected')
                            <div class="mb-4 bg-red-100 text-red-900 p-4 font-bold border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] uppercase tracking-wide">
                                Proof of Payment Rejected! Please upload again.
                            </div>
                            <form action="{{ route('payments.upload', $rental->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-4 items-center border-4 border-black p-6 bg-gray-50">
                                @csrf
                                <div class="w-full sm:w-2/3">
                                    <input type="file" name="payment_proof" required class="block w-full border-2 border-black p-2 font-medium bg-white focus:outline-none">
                                </div>
                                <button type="submit" class="w-full sm:w-1/3 border-2 border-black bg-black text-white px-4 py-3 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">Upload Ulang</button>
                            </form>
                        @endif
                    @else
                        <form action="{{ route('payments.upload', $rental->id) }}" method="POST" enctype="multipart/form-data" class="border-4 border-black p-6 bg-gray-50 relative">
                            <!-- Decor -->
                            <div class="absolute top-0 right-0 w-8 h-8 bg-black"></div>
                            
                            @csrf
                            <label class="block text-sm font-bold uppercase tracking-widest mb-4 border-b-2 border-black pb-2">Upload Proof of Transfer (BCA 123456789 a.n LENSRENT)</label>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="flex-grow">
                                    <input type="file" name="payment_proof" required class="block w-full border-2 border-black p-2 font-medium bg-white focus:outline-none">
                                </div>
                                <button type="submit" class="sm:w-auto border-2 border-black bg-black text-white px-8 py-3 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">Submit Proof</button>
                            </div>
                        </form>
                    @endif
                @endif
                
                @if($rental->status == 'approved' && now()->startOfDay()->gt($rental->end_date->startOfDay()))
                    @php
                        $days_late = abs(now()->startOfDay()->diffInDays($rental->end_date->startOfDay()));
                        $estimated_fine = $days_late * $rental->camera->price_per_day;
                    @endphp
                    <div class="bg-black text-white border-4 border-black p-6 flex justify-between items-center transform rotate-1 mt-4 shadow-[8px_8px_0px_0px_rgba(200,0,0,1)]">
                        <div>
                            <span class="block text-xs font-bold uppercase tracking-widest text-red-400 mb-1">Estimated Fine</span>
                            <span class="text-xl font-black uppercase tracking-wider text-red-500">Rp {{ number_format($estimated_fine, 0, ',', '.') }}</span>
                            <span class="block text-xs font-medium text-gray-400 mt-1">({{ $days_late }} Days Late)</span>
                        </div>
                        <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                @elseif($rental->status == 'completed' && $rental->late_fine > 0)
                <div class="bg-black text-white border-4 border-black p-6 flex justify-between items-center transform rotate-1 mt-4 shadow-[8px_8px_0px_0px_rgba(200,0,0,1)]">
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Paid Penalty</span>
                        <span class="text-xl font-black uppercase tracking-wider">Rp {{ number_format($rental->late_fine, 0, ',', '.') }}</span>
                    </div>
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="border-4 border-black border-dashed py-20 text-center flex flex-col items-center justify-center bg-gray-50">
        <svg class="w-20 h-20 mb-6 opacity-20" fill="none" stroke="black" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <h3 class="text-2xl font-black uppercase tracking-tight mb-4">No Rental Orders</h3>
        <a href="/" class="border-2 border-black bg-black text-white px-8 py-3 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">Sewa Kamera Sekarang</a>
    </div>
    @endforelse
</div>
@endsection
