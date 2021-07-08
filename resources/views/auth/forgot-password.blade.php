@extends('template.app')

@section('title','Forgot Password')

@section('content')
<div class="container mx-auto my-5">
  <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div>
          <input id="email" type="email" name="email" placeholder="Email Address" value="{{ old('email') }}">
          @error('email')
              <span>
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>
      <div>
          <button type="submit">Send Reset Password Link</button>
      </div>
  </form>
</div>
@endsection