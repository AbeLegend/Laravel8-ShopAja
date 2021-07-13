@extends('template.app')

@section('title','Detail Item')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col lg:flex-row">
  <!-- Image -->
  <div class="lg:w-2/5 flex justify-center flex-col items-center my-5 lg:my-0">
    <img src="{{ asset('images/' . $itemSell->item_image) }}" alt="{{ $itemSell->item_name }}" class="cover max-w-sm lg:max-w-md rounded shadow-md" />
  </div>
  <!-- Name, Description, Stock, & Price -->
  <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 lg:w-3/5 mx-5 lg:mx-3 my-1 lg:my-10 rounded p-5 flex flex-col h-full text-white">
    <h1 class="text-2xl font-semibold px-5 border-b-2 border-indigo-400">{{ $itemSell->item_name }}</h1>
    <p class="text-justify px-5 py-1 ">Detail:</p>
    <p class="text-justify px-5 py-1 border-b-2 border-indigo-400">{{ $itemSell->item_description }}</p>
    <p class="font-medium">Stock: {{ $itemSell->item_stock }}</p>
    <p class="font-bold my-2">Price: Rp {{ $itemSell->price }} /pcs</p>
    <form action="{{ url('items/'. $itemSell->id .'/buyOne') }}" method="POST" class="flex flex-col">
      @csrf
      <div class="flex items-center space-x-3">
        <input type="hidden" name="uang" value="{{ auth()->user()->uang }}">
        <label class="block font-semibold">Purchase amount:</label>
        <input type="number" name="purchase_amount" class="border h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-green-400 rounded-md text-black" value="1" required/>
      </div>
      <button type="submit" class="my-5 bg-green-600 px-3 py-2 rounded  font-medium hover:bg-green-700 transform hover:-translate-y-1 duration-300 ease-in-out">Buy</button>
    </form>
    {{-- @dd($inCart) --}}
    @if ($inCart != null)
    
      <form action="{{ url('carts/'.$inCart->id) }}" method="POST" class="flex flex-col">
        @csrf
        @method('delete')
        <button type="submit" class="my-5 bg-red-600 px-3 py-2 rounded  font-medium hover:bg-red-700 transform hover:-translate-y-1 duration-300 ease-in-out">Delete from cart</button>
      </form>
    
    @else
    <form action="{{ url('carts') }}" method="POST" class="flex flex-col">
      @csrf
      <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
      <input type="hidden" name="id_item" value="{{ $itemSell->id }}">
      <input type="hidden" name="count" value="1">
      <button type="submit" class="my-5 bg-blue-600 px-3 py-2 rounded  font-medium hover:bg-blue-700 transform hover:-translate-y-1 duration-300 ease-in-out">Add to cart</button>
    </form>
    @endif
    @if (session('status'))<p class="text-green-200 ml-1 text-xl font-semibold text-center">{{ session('status')}}</p>@endif
  </div>

</div>

@endsection