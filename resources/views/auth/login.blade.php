@extends('template.app')

@section('title','Login')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12 text-gray-800 antialiased">
  <div class="relative py-3 sm:w-96 mx-auto text-center">
    <span class="text-2xl font-light">Login to your account</span>
    <div class="mt-4 bg-white shadow-md rounded-lg text-left">
      <div class="h-2 bg-indigo-400 rounded-t-md"></div>
      <div class="px-8 py-6">
        <form action="login" method="POST">
          @csrf
          @if (session('status'))<span class="text-green-500 ml-1 text-xs font-semibold">{{ session('status') }}</span>@endif
          <label class="block font-semibold">Email</label>
          <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('email') ring-1 ring-red-500 @enderror" />
          @error('email')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          <label class="block font-semibold">Password</label>
          <input type="password" id="password" name="password" placeholder="Password" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md" />
          <div class="flex justify-between items-baseline">
              <button type="submit" class="mt-4 bg-indigo-500 text-white py-2 px-6 rounded-md hover:bg-indigo-600">Login</button>
              @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="text-sm hover:underline hover:text-indigo-500">Forgot Password?</a>
              @endif
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection