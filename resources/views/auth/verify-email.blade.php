@extends('template.app')

@section('title','Verify Email')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12 text-gray-800 antialiased">
  <div class="relative py-3 sm:w-96 mx-auto text-center">
    <span class="text-2xl font-light">Verify Your Email Address</span>
    <div class="mt-4 bg-white shadow-md rounded-lg text-left">
      <div class="h-2 bg-indigo-400 rounded-t-md"></div>
      <div class="px-8 pb-6">
        @if (session('status') == 'verification-link-sent')<span class="text-green-500 ml-1 text-xs font-semibold">A fresh verification link has been sent to your email address.</span>@endif
        <form method="POST" action="{{ route('verification.send') }}">
          @csrf
          <br>
          <p>Before proceeding, please check your email for a verification link.</p>
          <p>If you did not receive the email</p>
          <div class="flex justify-center items-baseline">
            <button type="submit" class="mt-4 bg-indigo-500 text-white py-2 px-6 rounded-md hover:bg-indigo-600">Click here to request another</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection