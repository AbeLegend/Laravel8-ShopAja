@extends('template.app')

@section('title','Reset Password')

@section('content')
<div class="container mx-auto my-5">
  <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ request()->token }}">

      <div>
          <input id="email" type="email" name="email" placeholder="Email Address" value="{{ old('email') }}">
          @error('email')
              <span>
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>
      <div>
          <input id="password" type="password" name="password" placeholder="Password">
          @error('password')
              <span>
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>
      <div>
          <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Password Confirmation">
      </div>
      <div>
          <button type="submit">Reset Password</button>
      </div>
  </form>
</div>
@endsection