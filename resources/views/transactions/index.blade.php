@extends('template.app')

@section('title','Checkout Page')

@section('content')
<div>
  <h1>Seller</h1>
  <h1>{{ $user->username }}</h1>
  <p>{{ $user->alamat }}</p>
  
  <h1>buyer</h1>
  <p>{{ auth()->user()->username }}</p>
  <p>{{ auth()->user()->alamat }}</p>

  {{-- table --}}
  <h1>{{ $buyItem->item_name }}</h1>
  <h1>{{ $qty }}</h1>
  <h1>{{ $buyItem->price }}</h1>
  <h1>{{ $buyItem->price * $qty }}</h1>

  <h1>{{ $buyItem->price * $qty }}</h1>

  
  <form action="{{ url('transaction/checkoutOne') }}" method="POST" class="flex flex-col">
      @csrf
      <div class="flex items-center space-x-3">
        {{-- seller --}}
        <input type="hidden" name="seller_username" value="{{ $user->username }}">
        <input type="hidden" name="seller_address" value="{{ $user->alamat }}">
        {{-- buyer --}}
        <input type="hidden" name="buyer_username" value="{{ auth()->user()->username }}">
        <input type="hidden" name="buyer_address" value="{{ auth()->user()->alamat }}">
        {{-- item --}}
        <input type="hidden" name="item_name" value="{{ $buyItem->item_name }}">
        <input type="hidden" name="item_qty" value="{{ $qty }}">
        <input type="hidden" name="item_price" value="{{ $buyItem->price  }}">


      </div>
      <button type="submit" class="my-5 bg-green-600 px-3 py-2 rounded  font-medium hover:bg-green-700 transform hover:-translate-y-1 duration-300 ease-in-out">Checkout</button>
    </form>
</div>
@endsection