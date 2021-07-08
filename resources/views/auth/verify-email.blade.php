@extends('template.app')

@section('title','Verify Email')

@section('content')
<div class="container">
  <div>Verify Your Email Address</div>
  <div>
      @if (session('resent'))
          <div>A fresh verification link has been sent to your email address.</div>
      @endif

      {{ __('Before proceeding, please check your email for a verification link.') }}
      {{ __('If you did not receive the email') }},
      <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
          @csrf
          <button type="submit">click here to request another</button>.
      </form>
  </div>
</div>
@endsection