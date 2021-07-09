@extends('template.app')

@section('title','Detail Item')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col lg:flex-row">
  <!-- Image -->
  <div class="lg:w-2/5 flex justify-center flex-col items-center my-5 lg:my-0">
    <img src="{{ asset('images/' . $item->item_image) }}" alt="{{ $item->item_name }}" class="cover max-w-sm lg:max-w-md rounded shadow-md" />
  </div>
  <!-- Name, Description, Stock, & Price -->
  <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 lg:w-3/5 mx-5 lg:mx-3 my-1 lg:my-10 rounded p-5 flex flex-col h-full text-white">
    <h1 class="text-2xl font-semibold px-5 border-b-2 border-indigo-400">{{ $item->item_name }}</h1>
    <p class="text-justify px-5 py-1 ">Detail:</p>
    <p class="text-justify px-5 py-1 border-b-2 border-indigo-400">{{ $item->item_description }}</p>
    <p class="font-medium">Stock: {{ $item->item_stock }}</p>
    <p class="font-bold my-2">Price: Rp {{ $item->price }} /pcs</p>
    <form action="" method="POST" class="flex flex-col">
      <div class="flex items-center space-x-3">
        <label class="block font-semibold">Purchase amount:</label>
        <input type="number" class="border h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-green-400 rounded-md text-black"/>
      </div>
      <button class="my-5 bg-green-600 px-3 py-2 rounded  font-medium hover:bg-green-700 transform hover:-translate-y-1 duration-300 ease-in-out">Checkout</button>
    </form>
  </div>
</div>

@endsection