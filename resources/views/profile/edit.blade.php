@extends('layouts.app')

@section('content')
<div class="mb-10 border-b-4 border-black pb-4 flex justify-between items-end">
    <h2 class="text-4xl font-black uppercase tracking-tight">My Profile</h2>
    <a href="{{ url()->previous() }}" class="text-sm font-bold uppercase tracking-widest hover:bg-black hover:text-white border-2 border-black px-4 py-2 transition-colors">
        &larr; Back
    </a>
</div>

<div class="max-w-2xl mx-auto">
    <div class="border-4 border-black bg-white p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">

        <!-- Account Info Section -->
        <h3 class="text-2xl font-black uppercase tracking-tight mb-2 border-b-4 border-black pb-2">Account Info</h3>
        <p class="text-sm font-medium text-gray-500 mb-6">Update your display name below.</p>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold uppercase tracking-widest mb-2">Email</label>
                <div class="block w-full border-2 border-gray-300 bg-gray-100 p-3 font-medium text-gray-500">
                    {{ $user->email }}
                </div>
                <p class="text-xs font-medium text-gray-400 mt-1 uppercase tracking-wider">Email cannot be changed.</p>
            </div>

            <div>
                <label class="block text-sm font-bold uppercase tracking-widest mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
                @error('name')
                    <p class="text-red-600 text-sm font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full border-2 border-black bg-black text-white py-4 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors duration-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                Update Name
            </button>
        </form>

        <!-- Divider -->
        <div class="border-t-4 border-black my-8"></div>

        <!-- Change Password Section -->
        <h3 class="text-2xl font-black uppercase tracking-tight mb-2 border-b-4 border-black pb-2">Change Password</h3>
        <p class="text-sm font-medium text-gray-500 mb-6">Make sure to use a strong and unique password.</p>

        <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold uppercase tracking-widest mb-2">Current Password</label>
                <input type="password" name="current_password" required
                       class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
                @error('current_password')
                    <p class="text-red-600 text-sm font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold uppercase tracking-widest mb-2">New Password</label>
                <input type="password" name="password" required
                       class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
                @error('password')
                    <p class="text-red-600 text-sm font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold uppercase tracking-widest mb-2">Confirm New Password</label>
                <input type="password" name="password_confirmation" required
                       class="block w-full border-2 border-black p-3 font-medium focus:outline-none focus:ring-0 focus:border-black bg-gray-50">
            </div>

            <button type="submit" class="w-full border-2 border-black bg-black text-white py-4 text-sm font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors duration-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                Update Password
            </button>
        </form>

    </div>
</div>
@endsection
