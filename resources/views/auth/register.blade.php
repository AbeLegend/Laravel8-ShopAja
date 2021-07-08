@extends('template.app')

@section('title','Register')

@section('content')
      <form action="register" method="POST">
        @csrf
        <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}">
          @error('username')
              <span>
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
          @error('email')
              <span>
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        <input type="text" id="alamat" name="alamat" placeholder="Alamat" value="{{ old('alamat') }}">
          @error('alamat')
              <span>
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        <input type="hidden" id="uang" name="uang" placeholder="uang" value="0">
        <input type="password" id="password" name="password" placeholder="Password">
          @error('password')
              <span>
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
        <button type="submit">Register</button>
    </form>
@endsection