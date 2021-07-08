@extends('template.app')

@section('title','Login')

@section('content')
      <form action="login" method="POST">
        @csrf
        <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
          @error('email')
              <span>
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        <input type="password" id="password" name="password" placeholder="Password">
          @error('password')
              <span>
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        <button type="submit">Login</button>
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </form>
@endsection