@extends('template.app')

@section('title','Cart')

@section('content')

<div class="min-h-screen bg-gray-100 flex flex-col space-y-2">
  @if (count($myCart) > 0)
  <div class="my-5 flex justify-evenly items-center">
    <span class="text-2xl font-medium">Cart</span>
      <a href="{{ url('checkout') }}" class="my-5 text-sm text-white bg-green-600 px-3 py-2 rounded font-medium hover:bg-green-700 transform hover:-translate-y-1 duration-300 ease-in-out">Buy</a>
  </div>
  @else
    <span class="text-2xl font-medium text-center my-5">Cart</span>
  @endif
  @forelse ( $myCart as $cart )
  <div class="flex space-x-3 items-center justify-center p-3 shadow-md">
    <img class="w-2/12" src="{{ asset('images/' . $cart->item_image) }}" alt="{{ $cart->item_name.$cart->id_cart }}" />
    <div class="flex flex-col w-4/12 lg:w-6/12">
      <h1 class="text-xl font-medium border-b-2 border-indigo-600">{{ $cart->item_name }}</h1>
      <p class="truncate">{{ $cart->item_description }}</p>
    </div>
    <h1 class="font-bold">Rp {{ $cart->price }},-</h1>
    <form action="{{ url('carts/'.$cart->id_cart) }}" method="POST">
      @csrf
      @method('delete')
      <button type="submit" class="my-5 text-sm text-white bg-red-600 px-3 py-2 rounded font-medium hover:bg-red-700 transform hover:-translate-y-1 duration-300 ease-in-out">Remove</button>
    </form>
  </div>
  @empty
    <h1 class="text-2xl font-light text-center">Empty</h1>
  @endforelse
</div>
@endsection