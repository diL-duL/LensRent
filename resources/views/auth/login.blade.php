@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12">
  <div class="w-full max-w-md border-4 border-black bg-white p-10 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]">
    <div class="mb-10 text-center border-b-4 border-black pb-6">
      <h2 class="text-4xl font-black uppercase tracking-tighter text-black">
        Akses Masuk
      </h2>
      <p class="mt-2 text-sm font-bold uppercase tracking-widest text-gray-500">Masuk ke portal member</p>
    </div>
    
    <form class="space-y-8" action="{{ route('login') }}" method="POST">
      @csrf
      <div class="space-y-6">
        <div>
          <label for="email-address" class="block text-sm font-bold uppercase tracking-widest mb-2">Alamat Email</label>
          <input id="email-address" name="email" type="email" required class="w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50" placeholder="nama@email.com" value="{{ old('email') }}">
        </div>
        <div>
          <label for="password" class="block text-sm font-bold uppercase tracking-widest mb-2">Kata Sandi</label>
          <input id="password" name="password" type="password" required class="w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50" placeholder="••••••••">
        </div>
      </div>

      <div class="pt-4">
        <button type="submit" class="w-full border-2 border-black bg-black text-white py-4 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors duration-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
          Masuk Sekarang
        </button>
      </div>
      
      <div class="text-center mt-8 border-t-2 border-black pt-6">
        <span class="text-sm font-medium">Pengguna baru?</span> 
        <a href="{{ route('register') }}" class="text-sm font-bold uppercase tracking-widest border-b-2 border-black pb-0.5 hover:bg-black hover:text-white transition-colors duration-200 ml-2">Buat Akun</a>
      </div>
    </form>
  </div>
</div>
@endsection
