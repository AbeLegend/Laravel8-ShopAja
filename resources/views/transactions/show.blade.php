@extends('template.app')

@section('title','Transaction Page')

@section('content')

<a href="{{ url('transactions/history') }}" class="p-2 bg-purple-500 ">List Trx</a>

  @if (count($cekTrx)>0)
    @forelse ($trx as $t)
      <h1>{{ $t->item_name }}</h1>
      <img class="max-w-xs" src="{{ asset('images/' . $t->item_image) }}" alt="{{ $t->item_image }}">
      <h1>{{ $t->price }}</h1>
      <h1>{{ $t->count }}</h1>
      <h1>{{ $t->status }}</h1>
    @empty

    <h1>kosong</h1>
    @endforelse

    <h1>total {{ $newPrice }}</h1>
    <form action="{{ url('transactions/pay') }}" method="POST">
      @csrf
      <input type="number" name="pay">
      <button type="submit">Pay</button>
    </form>
    
  @else
    <h1>kosong</h1>
  @endif

@endsection