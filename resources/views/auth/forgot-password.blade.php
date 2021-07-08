@extends('template.app')

@section('title','Forgot Password')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12 text-gray-800 antialiased">
  <div class="relative py-3 sm:w-96 mx-auto text-center">
    <span class="text-2xl font-light">Forgot Password</span>
    <div class="mt-4 bg-white shadow-md rounded-lg text-left">
      <div class="h-2 bg-indigo-400 rounded-t-md"></div>
      <div class="px-8 py-6">
        <form method="POST" action="{{ route('password.email') }}">
          @csrf
          @if (session('status'))<span class="text-green-500 ml-1 text-xs font-semibold">{{ session('status') }}</span>@endif
          {{-- Email --}}
          <label class="block font-semibold">Email Address</label>
          <input id="email" type="email" name="email" placeholder="Email Address" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('email') ring-1 ring-red-500 @enderror"  value="{{ old('email') }}"/>
          @error('email')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          <div class="flex justify-between items-baseline">
            <button type="submit" class="mt-4 bg-indigo-500 text-white py-2 px-6 rounded-md hover:bg-indigo-600">Send Reset Password Link</button>
            <a href="{{ url('login') }}" class="text-sm hover:underline hover:text-indigo-500">Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection