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
            Peralatan profesional untuk visi tanpa batas. Jelajahi koleksi gear premium kami dan wujudkan karya terbaikmu hari ini.
        </p>
    </div>
</div>

<div class="flex justify-between items-end mb-10 border-b-2 border-black pb-4">
    <h2 class="text-4xl font-bold uppercase tracking-tight">Katalog Gear</h2>
    <span class="font-bold text-xl uppercase">{{ count($cameras) }} Item</span>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
    @foreach($cameras as $camera)
    <div class="group border-4 border-black bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] transition-all duration-200 flex flex-col">
        
        <div class="relative border-b-4 border-black h-64 overflow-hidden bg-gray-100">
            @if($camera->status != 'tersedia')
                <div class="absolute top-4 right-4 z-20 bg-black text-white px-4 py-1 text-sm font-bold uppercase tracking-wider transform rotate-3 shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] border border-white">
                    Sedang Disewa
                </div>
                <!-- Overlay grayscale for unavailable -->
                <div class="absolute inset-0 bg-white/40 z-10 backdrop-grayscale"></div>
            @endif

            @if($camera->photo)
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 {{ $camera->status != 'tersedia' ? 'grayscale' : '' }}" src="{{ asset('storage/' . $camera->photo) }}" alt="{{ $camera->name }}">
            @else
                <div class="w-full h-full flex items-center justify-center text-black">
                    <svg class="h-20 w-20 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                </div>
            @endif
        </div>

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
                    <span class="text-sm font-bold uppercase tracking-widest">Tarif Sewa</span>
                    <span class="text-2xl font-black">Rp {{ number_format($camera->price_per_day, 0, ',', '.') }}</span>
                </div>

                @auth
                    @if(auth()->user()->role == 'customer')
                        @if($camera->status == 'tersedia')
                            <button onclick="document.getElementById('modal-{{ $camera->id }}').classList.remove('hidden')" class="w-full border-2 border-black bg-black text-white text-lg font-bold uppercase tracking-widest py-3 hover:bg-white hover:text-black transition-colors duration-200">
                                Sewa Sekarang
                            </button>
                        @else
                            <button disabled class="w-full border-2 border-gray-400 bg-gray-100 text-gray-400 text-lg font-bold uppercase tracking-widest py-3 cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        @endif
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block text-center w-full border-2 border-black bg-white text-black text-lg font-bold uppercase tracking-widest py-3 hover:bg-black hover:text-white transition-colors duration-200">
                        Login Untuk Sewa
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Modal Sewa (Brutalist style) -->
    @if($camera->status == 'tersedia')
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
                            Formulir Sewa
                        </h3>
                        <p class="text-xl font-bold border-b-2 border-black inline-block mb-8 pb-1">{{ $camera->name }}</p>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold uppercase tracking-widest mb-2">Tanggal Mulai</label>
                                <input type="date" name="start_date" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-sm font-bold uppercase tracking-widest mb-2">Tanggal Selesai</label>
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
        <h2 class="text-4xl md:text-5xl font-black uppercase mb-4">Butuh Bantuan?</h2>
        <p class="text-lg md:text-xl font-medium text-gray-300">Tim profesional kami siap membantu Anda memilih gear yang tepat untuk proyek Anda selanjutnya.</p>
    </div>
    <div class="mt-8 md:mt-0 relative z-10">
        <a href="#" class="inline-block border-2 border-white bg-white text-black font-bold uppercase tracking-widest py-4 px-10 hover:bg-black hover:text-white transition-colors duration-300">
            Hubungi Kami
        </a>
    </div>
</div>
@endsection
