@extends('layouts.app')

@section('content')
<div class="py-16 md:py-24 border-b-4 border-black mb-16 relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute -right-20 -top-20 w-64 h-64 border-8 border-black rounded-full opacity-10"></div>
    <div class="absolute -left-10 bottom-10 w-32 h-32 bg-black opacity-5 transform rotate-45"></div>
    
    <div class="relative z-10">
        <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter mb-6 leading-none">
            Capture<br/>The Moment.
        </h1>
        <p class="text-xl md:text-2xl font-medium max-w-2xl border-l-4 border-black pl-6 py-2">
            Professional gear for limitless vision. Explore our premium collection and bring your best work to life today.
        </p>
    </div>
</div>

<div class="flex justify-between items-end mb-10 border-b-2 border-black pb-4">
    <h2 class="text-4xl font-bold uppercase tracking-tight">Catalog</h2>
    <span class="font-bold text-xl uppercase">{{ count($cameras) }} Item</span>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
    @foreach($cameras as $camera)
    <div class="group border-4 border-black bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] transition-all duration-200 flex flex-col">

        <div class="p-6 flex flex-col flex-grow">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-2xl font-bold uppercase tracking-tight">{{ $camera->name }}</h3>
            </div>
            <p class="text-sm font-bold uppercase tracking-widest border border-black inline-block px-2 py-1 mb-4 self-start">
                {{ $camera->brand }}
            </p>
            <p class="text-base mb-6 flex-grow font-medium leading-relaxed">
                {{ $camera->description }}
            </p>
            
            <div class="border-t-2 border-black pt-4 mt-auto">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-bold uppercase tracking-widest">Rental Price</span>
                    <span class="text-2xl font-black">Rp {{ number_format($camera->price_per_day, 0, ',', '.') }}</span>
                </div>

                @auth
                    <a href="{{ route('cameras.show', $camera->id) }}" class="block text-center w-full border-2 border-black bg-white text-black text-sm font-bold uppercase tracking-widest py-3 hover:bg-gray-100 transition-colors duration-200 mb-2">
                        View Detail &rarr;
                    </a>
                    @if(auth()->user()->role == 'customer')
                        @if($camera->status == 'available')
                            <button onclick="document.getElementById('modal-{{ $camera->id }}').classList.remove('hidden')" class="w-full border-2 border-black bg-black text-white text-lg font-bold uppercase tracking-widest py-3 hover:bg-white hover:text-black transition-colors duration-200 mb-2">
                                Rent Now
                            </button>
                        @else
                            <button disabled class="w-full border-2 border-gray-400 bg-gray-100 text-gray-400 text-lg font-bold uppercase tracking-widest py-3 cursor-not-allowed mb-2">
                                Not Available
                            </button>
                        @endif
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block text-center w-full border-2 border-black bg-white text-black text-lg font-bold uppercase tracking-widest py-3 hover:bg-black hover:text-white transition-colors duration-200 mb-2">
                        Login to Rent
                    </a>
                @endauth

                <!-- View Image button - opens Google Images search in new tab -->
                <a href="https://www.google.com/search?tbm=isch&q={{ urlencode($camera->name . ' ' . $camera->brand . ' camera') }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="flex items-center justify-center gap-2 w-full border-2 border-black bg-white text-black text-sm font-bold uppercase tracking-widest py-3 hover:bg-black hover:text-white transition-colors duration-200 group/img">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    View Image
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Sewa (Brutalist style) -->
    @if($camera->status == 'available')
    <div id="modal-{{ $camera->id }}" class="hidden fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-white bg-opacity-90 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('modal-{{ $camera->id }}').classList.add('hidden')"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white border-4 border-black text-left overflow-hidden shadow-[16px_16px_0px_0px_rgba(0,0,0,1)] transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative">
                
                <!-- Close Button -->
                <button type="button" onclick="document.getElementById('modal-{{ $camera->id }}').classList.add('hidden')" class="absolute top-4 right-4 text-black hover:text-gray-600 focus:outline-none">
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
                        <button type="button" onclick="document.getElementById('modal-{{ $camera->id }}').classList.add('hidden')" class="w-full sm:w-auto border-2 border-black bg-white px-8 py-3 text-sm font-bold uppercase tracking-widest hover:bg-gray-100 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto border-2 border-black bg-black text-white px-8 py-3 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors">
                            Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>

<!-- Support info section -->
<div class="mt-32 border-4 border-black p-12 bg-black text-white flex flex-col md:flex-row justify-between items-center relative overflow-hidden">
    <div class="absolute -right-10 -top-10 text-9xl opacity-10 font-black">SUPPORT</div>
    <div class="relative z-10 max-w-2xl">
        <h2 class="text-4xl md:text-5xl font-black uppercase mb-4">Need Help?</h2>
        <p class="text-lg md:text-xl font-medium text-gray-300">Our professional team is ready to help you choose the right gear for your next project.</p>
    </div>
    <div class="mt-8 md:mt-0 relative z-10">
        <a href="#" class="inline-block border-2 border-white bg-white text-black font-bold uppercase tracking-widest py-4 px-10 hover:bg-black hover:text-white transition-colors duration-300">
            Contact Us
        </a>
    </div>
</div>
@endsection
