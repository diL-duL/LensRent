@extends('layouts.app')

@section('content')
<div class="mb-10 border-b-4 border-black pb-4 flex justify-between items-end">
    <h2 class="text-4xl font-black uppercase tracking-tight">Katalog Gear</h2>
    <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold uppercase tracking-widest hover:bg-black hover:text-white border-2 border-black px-4 py-2 transition-colors">
        &larr; Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    <!-- Form Tambah Kamera -->
    <div class="lg:col-span-1">
        <div class="border-4 border-black bg-white p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] sticky top-28">
            <h3 class="text-2xl font-black uppercase tracking-tight mb-6 border-b-4 border-black pb-2">Tambah Baru</h3>
            <form action="{{ route('cameras.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest mb-2">Kategori</label>
                    <div class="relative">
                        <select name="category_id" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-white appearance-none cursor-pointer">
                            <option value="">-- Pilih --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-black">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest mb-2">Nama Kamera</label>
                    <input type="text" name="name" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
                </div>
                
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest mb-2">Merk</label>
                    <input type="text" name="brand" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
                </div>
                
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest mb-2">Tarif Sewa/Hari</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-4 border-2 border-r-0 border-black bg-black text-white font-bold">Rp</span>
                        <input type="number" name="price_per_day" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50"></textarea>
                </div>
                
                <button type="submit" class="w-full border-2 border-black bg-black text-white py-4 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors duration-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                    Simpan Data
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Kamera -->
    <div class="lg:col-span-2">
        <div class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
            <div class="overflow-x-auto p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b-4 border-black pb-4 text-sm font-bold uppercase tracking-widest">Produk</th>
                            <th class="border-b-4 border-black pb-4 text-sm font-bold uppercase tracking-widest">Kategori</th>
                            <th class="border-b-4 border-black pb-4 text-sm font-bold uppercase tracking-widest">Tarif</th>
                            <th class="border-b-4 border-black pb-4 text-sm font-bold uppercase tracking-widest">Status</th>
                            <th class="border-b-4 border-black pb-4 text-sm font-bold uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-gray-200">
                        @foreach($cameras as $camera)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 pr-4">
                                <div class="font-black uppercase tracking-tight">{{ $camera->name }}</div>
                                <div class="text-xs font-bold uppercase tracking-widest border border-black inline-block px-1 mt-1">{{ $camera->brand }}</div>
                            </td>
                            <td class="py-4 px-4 text-sm font-bold uppercase tracking-widest">
                                {{ $camera->category->name ?? '-' }}
                            </td>
                            <td class="py-4 px-4 font-black">
                                Rp {{ number_format($camera->price_per_day, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-4">
                                @if($camera->status == 'tersedia')
                                    <span class="border-2 border-black bg-white px-2 py-1 text-xs font-black uppercase tracking-widest">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="border-2 border-black bg-black text-white px-2 py-1 text-xs font-black uppercase tracking-widest">
                                        Disewa
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 pl-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('cameras.edit', $camera->id) }}" class="border-2 border-black bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-colors inline-block">
                                        Edit
                                    </a>
                                    <form action="{{ route('cameras.destroy', $camera->id) }}" method="POST" onsubmit="return confirm('Proses ini tidak dapat dibatalkan. Lanjutkan?');" class="inline-block m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-2 border-black bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-widest hover:bg-red-600 hover:text-white hover:border-red-600 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
