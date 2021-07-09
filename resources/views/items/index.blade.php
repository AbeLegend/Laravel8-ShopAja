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
          @if ($item->id_user == auth()->user()->id)
            <div class="bg-white p-3 rounded shadow-lg flex flex-col space-y-2">
              <img class="rounded-md object-cover" src="{{ asset('images/' . $item->item_image) }}" alt="{{ $item->item_name }}" />
              <h1 class="text-xl font-semibold">{{ $item->item_name }}</h1>
              <p class="text-sm">{{ $item->item_description }}</p>
              <p class="text-sm">Stock: {{ $item->item_stock }}</p>
              <div class="flex justify-between items-center">
                <h2 class="text-red-500 font-bold">{{ $item->price }}</h2>
                <a href="{{ url('/items/' . $item->id).'/edit' }}" class="bg-green-600 px-3 py-2 rounded text-white font-medium hover:bg-green-700 transform hover:-translate-y-1 duration-300 ease-in-out">Edit</a>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </div>
@endsection