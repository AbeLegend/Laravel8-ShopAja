@extends('template.app')

@section('title','Update Password')

@section('content')
<div class="container mx-auto my-5">
    <form method="POST" action="{{ route('user-password.update') }}">
      @csrf
      @method('PUT')

      @if (session('status')=="password-updated")
        <div>
          Password updated successfully
        </div>
      @endif

      <div>
          <label for="current_password">Current Password</label>

          <div>
              <input id="current_password" type="password" name="current_password">

              @error('current_password','updatePassword')
                  <span>
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
      </div>

      <div>
          <label for="password">Password</label>

          <div>
              <input id="password" type="password" name="password">

              @error('password','updatePassword')
                  <span>
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
      </div>

      <div>
          <label for="password-confirm">Confirm Password</label>

          <div>
              <input id="password-confirm" type="password"name="password_confirmation">
          </div>
      </div>

      <div class="form-group row mb-0">
          <div>
              <button type="submit">Save</button>
          </div>
      </div>
    </form>
</div>
@endsection