@extends('template.app')

@section('title','List Transaction Page')

@section('content')
<div class="flex flex-col space-y-2">
  <!-- buy -->
  <h1 class="font-semibold mx-auto text-2xl">Buy</h1>
  @forelse ($trxs as $key=>$trx )
    <div class="bg-blue-100 p-3 rounded flex max-w-3xl items-center mx-auto">
      <img class="max-w-xs h-1/2 rounded " src="{{ asset('images/' . $trx->item_image) }}" alt="image" />
      <div class="flex flex-col ml-5 justify-center p-1">
        <h1>Invoice: {{ $trx->no_trx }}</h1>
        <h1>Nama barang: {{ $trx->item_name }}</h1>
        <h1>Deskripsi: {{ $trx->item_description }}</h1>
        <h1>Jumlah pembelian: {{ $trx->count }}</h1>
        <h1>Rp {{ number_format($trx->price*$trx->count,0,'.','.') }},-</h1>
        <h1>Seller: {{ $trx->username }}</h1>
        <h1>{{ $trx->created_at }}</h1>
      </div>
      @if ($key != 0 && $trx->no_trx == $trxs[$key-1]->no_trx)
      @else
      <button class="ml-4 bg-indigo-400 px-3 py-2 rounded shadow text-white font-semibold">Print</button>
      @endif
    </div>
    @empty
      <h1 class="font-semibold mx-auto text-2xl">Empty</h1>
  @endforelse
  <!-- sell -->
  <h1 class="font-semibold mx-auto text-2xl">Sell</h1>
    @forelse ($seller as $key=>$me)
    <div class="bg-green-100 p-3 rounded flex max-w-3xl items-center mx-auto">
      <img class="max-w-xs h-1/2 rounded " src="{{ asset('images/' . $me->item_image) }}" alt="image" />
      <div class="flex flex-col ml-5 justify-center p-1">
        <h1>Invoice: {{ $me->no_trx }}</h1>
        <h1>Nama barang: {{ $me->item_name }}</h1>
        <h1>Deskripsi: {{ $me->item_description }}</h1>
        <h1>Jumlah pembelian: {{ $me->count }}</h1>
        <h1>Rp {{ number_format($me->price*$me->count,0,'.','.') }},-</h1>
        <h1>{{ $me->created_at }}</h1>
      </div>
      @if ($key != 0 && $me->no_trx == $seller[$key-1]->no_trx)
      @else
      <button class="ml-4 bg-indigo-400 px-3 py-2 rounded shadow text-white font-semibold">Print</button>
      @endif
    </div>
    @empty
      <h1 class="font-semibold mx-auto text-2xl">Empty</h1>
    @endforelse
</div>
@endsection