@extends('template.app')

@section('title','Update Password')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12 text-gray-800 antialiased">
  <div class="relative py-3 sm:w-96 mx-auto text-center">
    <span class="text-2xl font-light">Edit Password</span>
    <div class="mt-4 bg-white shadow-md rounded-lg text-left">
      <div class="h-2 bg-indigo-400 rounded-t-md"></div>
      <div class="px-8 py-6">
        <form method="POST" action="{{ route('user-password.update') }}">
          @csrf
          @method('PUT')
          @if (session('status')=="password-updated")<span class="text-green-500 ml-1 text-xs font-semibold">Password updated successfully</span>@endif
          {{-- current password --}}
          <label class="block font-semibold">Current Password</label>
          <input id="current_password" type="password" name="current_password" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('email') ring-1 ring-red-500 @enderror" />
          @error('current_password','updatePassword')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- new password --}}
          <label class="block font-semibold">New Password</label>
          <input id="password" type="password" name="password" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('email') ring-1 ring-red-500 @enderror" />
          @error('password','updatePassword')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- confirm password --}}
          <label class="block font-semibold">Confirm Password</label>
          <input id="password-confirm" type="password"name="password_confirmation" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('email') ring-1 ring-red-500 @enderror" />
          @error('uang')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          <div class="flex justify-between items-baseline">
            <button type="submit" class="mt-4 bg-indigo-500 text-white py-2 px-6 rounded-md hover:bg-indigo-600">Save</button>
            <a href="{{ url('/profile/edit') }}" class="text-sm hover:underline hover:text-indigo-500">Edit Profile</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection