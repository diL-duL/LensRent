@extends('layouts.app')

@section('content')
<div class="mb-10 border-b-4 border-black pb-4 flex justify-between items-end">
    <h2 class="text-4xl font-black uppercase tracking-tight">Edit Kamera</h2>
    <a href="{{ route('cameras.index') }}" class="text-sm font-bold uppercase tracking-widest hover:bg-black hover:text-white border-2 border-black px-4 py-2 transition-colors">
        &larr; Kembali
    </a>
</div>

<div class="max-w-2xl border-4 border-black bg-white p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
    <form action="{{ route('cameras.update', $camera->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm font-bold uppercase tracking-widest mb-2">Kategori</label>
            <div class="relative">
                <select name="category_id" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-white appearance-none cursor-pointer">
                    <option value="">-- Pilih --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $camera->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-black">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-bold uppercase tracking-widest mb-2">Nama Kamera</label>
            <input type="text" name="name" value="{{ $camera->name }}" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
        </div>
        
        <div>
            <label class="block text-sm font-bold uppercase tracking-widest mb-2">Merk</label>
            <input type="text" name="brand" value="{{ $camera->brand }}" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
        </div>
        
        <div>
            <label class="block text-sm font-bold uppercase tracking-widest mb-2">Tarif Sewa/Hari</label>
            <div class="flex">
                <span class="inline-flex items-center px-4 border-2 border-r-0 border-black bg-black text-white font-bold">Rp</span>
                <input type="number" name="price_per_day" value="{{ $camera->price_per_day }}" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-bold uppercase tracking-widest mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">{{ $camera->description }}</textarea>
        </div>
        
        <button type="submit" class="w-full border-2 border-black bg-black text-white py-4 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors duration-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
