@extends('template.app')

@section('title','My Item')

@section('content')
  <div class="container mx-auto">
    <h1 class="text-center my-5 font-light text-2xl">Your Item For Sell</h1>
    @if (session('status'))<p class="text-green-500 ml-1 text-xl font-semibold text-center">{{ session('status')}}</p>@endif
    <a href="{{ url('items/create') }}" class="bg-blue-600 px-3 py-2 rounded text-white font-medium hover:bg-blue-700 transform duration-300">Create Item</a>
    <div class="bg-gray-100 min-h-screen p-5 justify-center items-center">
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <!-- card -->
        @foreach ($items as $item)
          <div class="bg-white p-3 rounded shadow-lg flex flex-col space-y-2">
            <img class="rounded-md object-cover" src="{{ asset('images/' . $item->item_image) }}" alt="{{ $item->item_name }}" />
            <h1 class="text-xl font-semibold">{{ $item->item_name }}</h1>
            <p class="text-sm">{{ $item->item_description }}</p>
            <p class="text-sm">Stock: {{ $item->item_stock }}</p>
            <div class="flex justify-between items-center">
              <h2 class="text-red-500 font-bold">Rp {{ number_format($item->price,0,'.','.') }},-</h2>
              <div class="flex space-x-2">
                <form action="{{ url('items/'.$item->id) }}" method="POST">
                  @csrf
                  @method('delete')
                  <button type="submit" class="bg-red-600 px-3 py-2 rounded text-white font-medium hover:bg-red-700 transform hover:-translate-y-1 duration-300 ease-in-out">Delete</button>
                </form>
                <a href="{{ url('/items/' . $item->id).'/edit' }}" class="bg-indigo-600 px-3 py-2 rounded text-white font-medium hover:bg-indigo-700 transform hover:-translate-y-1 duration-300 ease-in-out">Edit</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection