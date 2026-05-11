@extends('layouts.app')

@section('content')
<div class="mb-10 border-b-4 border-black pb-4 flex justify-between items-end">
    <h2 class="text-4xl font-black uppercase tracking-tight">Edit Kategori</h2>
    <a href="{{ route('categories.index') }}" class="text-sm font-bold uppercase tracking-widest hover:bg-black hover:text-white border-2 border-black px-4 py-2 transition-colors">
        &larr; Kembali
    </a>
</div>

<div class="max-w-2xl border-4 border-black bg-white p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-bold uppercase tracking-widest mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ $category->name }}" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
        </div>
        <div>
            <label class="block text-sm font-bold uppercase tracking-widest mb-2">Deskripsi (Opsional)</label>
            <textarea name="description" rows="4" class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">{{ $category->description }}</textarea>
        </div>
        <button type="submit" class="w-full border-2 border-black bg-black text-white py-4 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors duration-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
