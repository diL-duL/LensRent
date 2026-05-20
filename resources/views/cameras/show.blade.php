@extends('layouts.app')

@section('content')
<div class="mb-10">
    <a href="{{ url('/') }}" class="text-sm font-bold uppercase tracking-widest hover:bg-black hover:text-white border-2 border-black px-4 py-2 transition-colors inline-block">
        &larr; Back to Catalog
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

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
            @if($camera->status == 'available')
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
                @if($camera->status == 'available')
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
    <!-- AI Insight Section -->
    @if(!empty($aiInsight))
    <div class="mt-12 border-4 border-black bg-white p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative overflow-hidden">
        <div class="absolute -right-6 -top-6 text-8xl opacity-5 font-black select-none transform rotate-12">AI</div>
        
        <div class="flex items-center gap-3 mb-6 border-b-4 border-black pb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            <h2 class="text-2xl font-black uppercase tracking-tight">Optic's Category Insight</h2>
            <span class="border-2 border-black bg-black text-white px-3 py-1 text-xs font-bold uppercase tracking-widest ml-auto">
                {{ $camera->category->name ?? 'Umum' }}
            </span>
        </div>
    
        <div class="prose prose-lg max-w-none font-medium leading-relaxed
                    prose-headings:font-black prose-headings:uppercase prose-headings:tracking-tight
                    prose-strong:font-black
                    prose-ul:list-disc prose-ul:pl-6
                    prose-li:my-1">
            {!! Str::markdown($aiInsight) !!}
        </div>
    </div>
    @endif
</div>

<!-- Rental Modal -->
@if(auth()->user()->role == 'customer' && $camera->status == 'available')
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
