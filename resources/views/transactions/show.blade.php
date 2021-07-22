@extends('template.app')

@section('title','Transaction Page')

@section('content')

<div class="min-h-screen bg-gray-100 flex flex-col">
  <a href="{{ url('transactions/history') }}" class="text-white bg-blue-600 px-3 py-2 rounded font-medium hover:bg-blue-700 transform hover:-translate-y-1 duration-300 ease-in-out self-end mr-5 mt-5">List Transactions</a>
    @if (count($cekTrx)>0)
    <h1 class="text-2xl font-semibold mx-auto">Total: {{ number_format($newPrice,0,'.','.') }},-</h1>
  <form action="{{ url('transactions/pay') }}" method="POST" class="mx-10">
    @csrf
    <input type="number" name="pay" class="border h-5 px-2 py-4 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md" />
    <button type="submit" class="text-white bg-indigo-600 px-2 py-1 rounded font-medium hover:bg-indigo-700 transform hover:-translate-y-1 duration-300 ease-in-out self-end mr-5 mt-5">Pay</button>
    @if (session('status'))
      <span>{{ session('status') }}</span>
    @endif
  </form>
    @forelse ($trx as $t)
      <div class="bg-green-400 mx-10 my-5 rounded shadow flex p-2">
        <img class="max-w-xs" src="{{ asset('images/' . $t->item_image) }}" alt="{{ $t->item_image }}" />
        <div class="flex flex-col ml-5 justify-center font-semibold">
          <h1>Nama Barang: {{ $t->item_name }}</h1>
          <h1>Deskripsi: {{ $t->item_description }}</h1>
          <h1>Jumlah: {{ $t->count }}</h1>
          <h1>Harga: Rp {{ number_format($t->price,0,'.','.') }},-</h1>
          <h1>Seller: {{ $t->username }}</h1>
        </div>
      </div>
    @empty
  <h1 class="text-2xl font-semibold mx-auto">Empty</h1>
    @endforelse
  
  @else
    <h1 class="text-2xl font-semibold mx-auto">Empty</h1>
  @endif
</div>

@endsection