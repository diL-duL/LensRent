@extends('layouts.app')

@section('content')
<div class="mb-10">
    <a href="{{ url('/') }}" class="text-sm font-bold uppercase tracking-widest hover:bg-black hover:text-white border-2 border-black px-4 py-2 transition-colors inline-block">
        &larr; Back to Catalog
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
    <!-- Camera Image -->
    <div class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
        <div class="relative h-96 lg:h-[500px] bg-gray-100">
            @if($camera->status != 'tersedia')
                <div class="absolute top-6 right-6 z-20 bg-black text-white px-6 py-2 text-sm font-bold uppercase tracking-wider transform rotate-3 shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] border border-white">
                    On Rent
                </div>
                <div class="absolute inset-0 bg-white/40 z-10 backdrop-grayscale"></div>
            @endif

            @if($camera->photo)
                <img class="w-full h-full object-cover {{ $camera->status != 'tersedia' ? 'grayscale' : '' }}"
                     src="{{ asset('storage/' . $camera->photo) }}" alt="{{ $camera->name }}">
            @else
                <div class="w-full h-full flex items-center justify-center text-black">
                    <svg class="h-32 w-32 opacity-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                </div>
            @endif
        </div>
    </div>

    <!-- Camera Info -->
    <div class="flex flex-col">
        <!-- Header -->
        <div class="border-b-4 border-black pb-6 mb-6">
            <span class="text-sm font-bold uppercase tracking-widest border-2 border-black inline-block px-3 py-1 mb-4">
                {{ $camera->brand }}
            </span>
            <h1 class="text-5xl md:text-6xl font-black uppercase tracking-tighter leading-none">
                {{ $camera->name }}
            </h1>
        </div>

        <!-- Category -->
        <div class="flex items-center gap-4 mb-6">
            <span class="text-sm font-bold uppercase tracking-widest text-gray-500">Category</span>
            <span class="border-2 border-black bg-black text-white px-4 py-1 text-sm font-bold uppercase tracking-widest">
                {{ $camera->category->name ?? 'Uncategorized' }}
            </span>
        </div>

        <!-- Description -->
        @if($camera->description)
        <div class="mb-8">
            <h2 class="text-sm font-bold uppercase tracking-widest mb-3 border-b-2 border-black pb-2">Description</h2>
            <p class="text-lg font-medium leading-relaxed">{{ $camera->description }}</p>
        </div>
        @endif

        <!-- Status -->
        <div class="flex items-center gap-4 mb-8">
            <span class="text-sm font-bold uppercase tracking-widest text-gray-500">Status</span>
            @if($camera->status == 'tersedia')
                <span class="border-2 border-black bg-white px-4 py-2 text-sm font-black uppercase tracking-widest">
                    ✓ Available
                </span>
            @else
                <span class="border-2 border-black bg-black text-white px-4 py-2 text-sm font-black uppercase tracking-widest">
                    ✕ Not Available
                </span>
            @endif
        </div>

        <!-- Price -->
        <div class="border-4 border-black bg-white p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] mt-auto">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-bold uppercase tracking-widest">Rental Price / Day</span>
                <span class="text-3xl font-black">Rp {{ number_format($camera->price_per_day, 0, ',', '.') }}</span>
            </div>

            @if(auth()->user()->role == 'customer')
                @if($camera->status == 'tersedia')
                    <button onclick="document.getElementById('modal-rent').classList.remove('hidden')"
                            class="w-full border-2 border-black bg-black text-white text-lg font-bold uppercase tracking-widest py-4 hover:bg-white hover:text-black transition-colors duration-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                        Rent This Camera
                    </button>
                @else
                    <button disabled class="w-full border-2 border-gray-400 bg-gray-100 text-gray-400 text-lg font-bold uppercase tracking-widest py-4 cursor-not-allowed">
                        Not Available
                    </button>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Rental Modal -->
@if(auth()->user()->role == 'customer' && $camera->status == 'tersedia')
<div id="modal-rent" class="hidden fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-white bg-opacity-90 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('modal-rent').classList.add('hidden')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white border-4 border-black text-left overflow-hidden shadow-[16px_16px_0px_0px_rgba(0,0,0,1)] transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative">

            <!-- Close Button -->
            <button type="button" onclick="document.getElementById('modal-rent').classList.add('hidden')" class="absolute top-4 right-4 text-black hover:text-gray-600 focus:outline-none">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <form action="{{ route('rentals.store') }}" method="POST">
                @csrf
                <input type="hidden" name="camera_id" value="{{ $camera->id }}">

                <div class="px-8 pt-10 pb-8 border-b-4 border-black">
                    <h3 class="text-3xl font-black uppercase tracking-tight mb-2" id="modal-title">
                        Rental Form
                    </h3>
                    <p class="text-xl font-bold border-b-2 border-black inline-block mb-8 pb-1">{{ $camera->name }}</p>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold uppercase tracking-widest mb-2">Start Date</label>
                            <input type="date" name="start_date" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-bold uppercase tracking-widest mb-2">End Date</label>
                            <input type="date" name="end_date" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-4 bg-gray-50">
                    <button type="button" onclick="document.getElementById('modal-rent').classList.add('hidden')" class="w-full sm:w-auto border-2 border-black bg-white px-8 py-3 text-sm font-bold uppercase tracking-widest hover:bg-gray-100 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="w-full sm:w-auto border-2 border-black bg-black text-white px-8 py-3 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors">
                        Confirm Rental
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
