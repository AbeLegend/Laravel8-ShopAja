@extends('template.app')

@section('title','ShopAja')

@section('content')
  <div class="container mx-auto">
    <div class="bg-gray-100 min-h-screen p-5 justify-center items-center">
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <!-- card -->
        @foreach ($items as $item)
          @if ($item->id_user != auth()->user()->id)
            <div class="bg-white p-3 rounded shadow-lg flex flex-col space-y-2">
              <img class="rounded-md object-cover" src="{{ asset('images/' . $item->item_image) }}" alt="{{ $item->item_name }}" />
              <h1 class="text-xl font-semibold">{{ $item->item_name }}</h1>
              <p class="text-sm truncate">{{ $item->item_description }}</p>
              <div class="flex justify-between items-center">
                <h2 class="text-red-500 font-bold">{{ $item->price }}</h2>
                <a href="{{ url('/items/' . $item->id) }}" class="bg-green-600 px-3 py-2 rounded text-white font-medium hover:bg-green-700 transform hover:-translate-y-1 duration-300 ease-in-out">Detail</a>
              </div>
              <p class="text-sm truncate">Seller: {{ $item->username }}</p>
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </div>
@endsection