<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penyewaan Kamera</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #ffffff;
            color: #000000;
        }
        /* Custom minimalist scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #000; 
        }
    </style>
</head>
<body class="antialiased selection:bg-black selection:text-white">
    <!-- Revamped Minimalist Navbar -->
    <nav class="border-b-2 border-black sticky top-0 bg-white z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="text-3xl font-bold tracking-tighter uppercase flex items-center gap-2">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="miter"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        LENS<span class="font-light">RENT</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-sm font-semibold tracking-widest uppercase hover:underline decoration-2 underline-offset-4">Katalog</a>
                    
                    @auth
                        @if(auth()->user()->role == 'admin')
                            <a href="/admin/dashboard" class="text-sm font-semibold tracking-widest uppercase hover:underline decoration-2 underline-offset-4">Dashboard Admin</a>
                        @else
                            <a href="/dashboard" class="text-sm font-semibold tracking-widest uppercase hover:underline decoration-2 underline-offset-4">Pesanan Saya</a>
                        @endif
                        
                        <div class="h-6 w-px bg-black"></div>
                        
                        <span class="text-sm font-semibold tracking-widest uppercase">
                            {{ auth()->user()->name }}
                        </span>
                        
                        <form action="/logout" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="border-2 border-black bg-black text-white px-5 py-2 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors duration-200">Keluar</button>
                        </form>
                    @else
                        <div class="h-6 w-px bg-black hidden sm:block"></div>
                        @if(!request()->is('login'))
                            <a href="/login" class="text-sm font-semibold tracking-widest uppercase hover:underline decoration-2 underline-offset-4">Masuk</a>
                        @endif
                        @if(!request()->is('register'))
                            <a href="/register" class="border-2 border-black bg-black text-white px-5 py-2 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors duration-200">Daftar</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
            <div class="border-2 border-black bg-white text-black p-4 mb-8 flex justify-between items-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <span class="font-medium tracking-wide">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="border-2 border-black bg-black text-white p-4 mb-8 flex justify-between items-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <span class="font-medium tracking-wide">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t-2 border-black mt-20 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="font-medium tracking-widest uppercase text-sm">&copy; {{ date('Y') }} LENSRENT. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
</body>
</html>
