@extends('template.app')

@section('title','Edit Profile')

@section('content')
<div class="container mx-auto my-5">
  <form method="POST" action="{{ route('user-profile-information.update') }}">
      @csrf
      @method('PUT')
        {{-- Username --}}
        <div>
            <input id="username" type="text" name="username" value="{{ old('username') ?? auth()->user()->username }}">
            @error('username')
                <span>
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- Email --}}
        <div>
            <input id="email" type="email" name="email" value="{{ old('email') ?? auth()->user()->email}}">
            @error('email')
                <span>
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- Uang --}}
        <div>
          <input id="uang" type="number" name="uang" value="{{ old('uang') ?? auth()->user()->uang }}">
          @error('uang')
              <span>
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        {{-- Alamat --}}
        <div>
          <input id="alamat" type="text" name="alamat" value="{{ old('alamat') ?? auth()->user()->alamat }}">
          @error('alamat')
              <span>
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <button type="submit">Update Profile</button>
        <a href="{{ url('/profile/password') }}">Update Password</a>
  </form>
</div>
@endsection