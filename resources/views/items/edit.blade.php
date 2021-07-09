@extends('template.app')

@section('title','Edit Item')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col sm:py-12 text-gray-800 antialiased">
  <div class="relative py-3 sm:w-96 mx-auto text-center">
    <span class="text-2xl font-light">Edit Your Item For Sell</span>
    <div class="mt-4 bg-white shadow-md rounded-lg text-left">
      <div class="h-2 bg-indigo-400 rounded-t-md"></div>
      <div class="px-8 py-6">
        <form action="{{ url('items/'.$item->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('put')
          {{-- name --}}
          <input type="hidden" value="{{ auth()->user()->id }}" name="id_user">
          <label class="block font-semibold">Name</label>
          <input type="text" name="item_name" placeholder="Name" value="{{ $item->item_name }}" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('item_name') ring-1 ring-red-500 @enderror" />
          @error('item_name')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- description --}}
          <label class="block font-semibold">Description</label>
          <textarea name="item_description" id="item_description" placeholder="Description" cols="30" rows="10" class="border w-full px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('item_description') ring-1 ring-red-500 @enderror">{{ $item->item_description }}</textarea>
          @error('item_description')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- stock --}}
          <label class="block font-semibold">Stock</label>
          <input type="number" name="item_stock" value="{{ $item->item_stock }}" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('item_stock') ring-1 ring-red-500 @enderror" />
          @error('item_stock')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- price --}}
          <label class="block font-semibold">Price</label>
          <input type="number" name="price" value="{{ $item->price }}" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('price') ring-1 ring-red-500 @enderror" />
          @error('price')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- image --}}
          <label class="block font-semibold">Image</label>
          <input type="file" name="item_image" value="{{ $item->item_image }}" class="border w-full px-3 py-3 mt-2 hover:outline-none focus:outline-none focus:ring-1 focus:ring-indigo-400 rounded-md @error('item_image') ring-1 ring-red-500 @enderror" />
          @error('item_image')<span class="text-red-500 ml-1 text-xs font-semibold">{{ $message }}</span>@enderror
          {{-- button --}}
          <div class="flex justify-between items-baseline">
            <button type="submit" class="mt-4 bg-indigo-500 text-white py-2 px-6 rounded-md hover:bg-indigo-600">Edit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection