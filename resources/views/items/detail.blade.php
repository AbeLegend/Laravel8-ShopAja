@extends('template.app')

@section('title','Detail Item')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col lg:flex-row">
  <!-- Image -->
  <div class="lg:w-2/5 flex justify-center flex-col items-center my-5 lg:my-0">
    <img src="{{ asset('images/' . $item->item_image) }}" alt="{{ $item->item_name }}" class="cover max-w-sm lg:max-w-md rounded shadow-md" />
  </div>
  <!-- Name & Description -->
  <div class="lg:w-2/5 mx-5 lg:mx-3 my-1 lg:my-10 border-l-2 border-r-2 border-indigo-400">
    <h1 class="text-2xl font-semibold px-5 text-indigo-700 border-b-2 border-indigo-400">{{ $item->item_name }}</h1>
    <p class="text-justify px-5 py-1">Detail:</p>
    <p class="text-justify px-5 py-1">{{ $item->item_description }}</p>
  </div>
  <!-- Stock & Price -->
  <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 lg:w-1/5 mx-5 lg:mx-3 my-1 lg:my-10 rounded p-5 flex flex-col h-full">
    <p class="text-white font-medium">Stock: {{ $item->item_stock }}</p>
    <p class="text-white font-bold my-2">Price: Rp {{ $item->price }} /pcs</p>
    <form action="" method="POST" class="flex flex-col">
      <label class="block font-semibold text-white">Purchase amount:</label>
      <input type="number" class="border h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-green-400 rounded-md w-full" />
      <button class="my-5 bg-green-600 px-3 py-2 rounded text-white font-medium hover:bg-green-700 transform hover:-translate-y-1 duration-300 ease-in-out">Checkout</button>
    </form>
  </div>
</div>

@endsection