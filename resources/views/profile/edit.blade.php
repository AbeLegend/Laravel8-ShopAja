@extends('template.app')

@section('title','Edit Profile')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12 text-gray-800 antialiased">
  <div class="relative py-3 sm:w-96 mx-auto text-center">
    <span class="text-2xl font-light">Edit Profile</span>
    <div class="mt-4 bg-white shadow-md rounded-lg text-left">
      <div class="h-2 bg-indigo-400 rounded-t-md"></div>
      <div class="px-8 py-6">
        <form method="POST" action="{{ route('user-profile-information.update') }}">
          @csrf
          @method('PUT')
          {{-- username --}}
          <label class="block font-semibold">Username</label>
          <input id="username" type="text" name="username" value="{{ old('username') ?? auth()->user()->username }}" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('email') ring-1 ring-red-500 @enderror" />
          @error('username')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- email --}}
          <label class="block font-semibold">Email</label>
          <input id="email" type="email" name="email" value="{{ old('email') ?? auth()->user()->email}}" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('email') ring-1 ring-red-500 @enderror" />
          @error('email')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- uang --}}
          <label class="block font-semibold">Money</label>
          <input id="uang" type="number" name="uang" value="{{ old('uang') ?? auth()->user()->uang }}" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('email') ring-1 ring-red-500 @enderror" />
          @error('uang')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- alamat --}}
          <label class="block font-semibold">Alamat</label>
          <input id="alamat" type="text" name="alamat" value="{{ old('alamat') ?? auth()->user()->alamat }}" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md" />
          <div class="flex justify-between items-baseline">
            <button type="submit" class="mt-4 bg-indigo-500 text-white py-2 px-6 rounded-md hover:bg-indigo-600">Update Profile</button>
            <a href="{{ url('/profile/password') }}" class="text-sm hover:underline hover:text-indigo-500">Change Password</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection