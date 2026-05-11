@extends('layouts.app')

@section('content')
<div class="mb-10 border-b-4 border-black pb-4 flex justify-between items-end">
    <h2 class="text-4xl font-black uppercase tracking-tight">Categories</h2>
    <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold uppercase tracking-widest hover:bg-black hover:text-white border-2 border-black px-4 py-2 transition-colors">
        &larr; Back
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-10">
    <div class="md:col-span-1">
        <div class="border-4 border-black bg-white p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] sticky top-28">
            <h3 class="text-2xl font-black uppercase tracking-tight mb-6 border-b-4 border-black pb-2">Add New</h3>
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest mb-2">Category Name</label>
                    <input type="text" name="name" required class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest mb-2">Description (Optional)</label>
                    <textarea name="description" rows="4" class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50"></textarea>
                </div>
                <button type="submit" class="w-full border-2 border-black bg-black text-white py-4 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors duration-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                    Save
                </button>
            </form>
        </div>
    </div>
    <div class="md:col-span-2">
        <div class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
            <div class="overflow-x-auto p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b-4 border-black pb-4 px-4 text-sm font-bold uppercase tracking-widest">Name</th>
                            <th class="border-b-4 border-black pb-4 px-4 text-sm font-bold uppercase tracking-widest">Description</th>
                            <th class="border-b-4 border-black pb-4 px-4 text-sm font-bold uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-gray-200">
                        @foreach($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4 font-black uppercase tracking-tight text-lg">
                                {{ $category->name }}
                            </td>
                            <td class="py-4 px-4 text-sm font-medium">
                                {{ $category->description ?: '-' }}
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="border-2 border-black bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-colors inline-block">
                                        Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');" class="inline-block m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-2 border-black bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-widest hover:bg-red-600 hover:text-white hover:border-red-600 transition-colors">
                                            Delete
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
