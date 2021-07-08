@extends('template.app')

@section('title','Register')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12 text-gray-800 antialiased">
  <div class="relative py-3 sm:w-96 mx-auto text-center">
    <span class="text-2xl font-light">Register</span>
    <div class="mt-4 bg-white shadow-md rounded-lg text-left">
      <div class="h-2 bg-indigo-400 rounded-t-md"></div>
      <div class="px-8 py-6">
        <form action="register" method="POST">
          @csrf
          {{-- username --}}
          <label class="block font-semibold">Username</label>
          <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('username') ring-1 ring-red-500 @enderror" />
          @error('username')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- email --}}
          <label class="block font-semibold">Email</label>
          <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('email') ring-1 ring-red-500 @enderror" />
          @error('email')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- alamat --}}
          <label class="block font-semibold">Alamat</label>
          <input type="text" id="alamat" name="alamat" placeholder="Alamat" value="{{ old('Alamat') }}" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('alamat') ring-1 ring-red-500 @enderror" />
          @error('alamat')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- uang --}}
          <input type="hidden" id="uang" name="uang" value="0">
          {{-- password --}}
          <label class="block font-semibold">Password</label>
          <input type="password" id="password" name="password" placeholder="Password" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('alamat') ring-1 ring-red-500 @enderror" />
          @error('password')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- confirm password --}}
          <label class="block font-semibold">Confirm Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md" />

          {{-- button --}}
          <div class="flex justify-between items-baseline">
            <button type="submit" class="mt-4 bg-indigo-500 text-white py-2 px-6 rounded-md hover:bg-indigo-600">Register</button>
            <a href="{{ route('login') }}" class="text-sm hover:underline hover:text-indigo-500">Have an account?</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection