@extends('template.app')

@section('title','Checkout Page')

@section('content')
<div class="min-h-screen bg-gray-100 container mx-auto my-2">
  <table class="table-auto">
    <thead>
      <tr class="border-2 bg-indigo-200">
        <th class="border-2 p-1 text-center">No</th>
        <th class="border-2 p-1 text-center">Image</th>
        <th class="border-2 p-1 text-center">Item</th>
        <th class="border-2 p-1 text-center">Price</th>
        <th class="border-2 p-1 text-center">Purchase Amount</th>
        <th class="border-2 p-1 text-center">Total</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($myCart as $cart)
      <tr>
        <td class="border-2 p-1 text-center font-semibold">{{ $loop->iteration }}</td>
        <td class="border-2 p-1 text-center w-1/12"><img src="{{ asset('images/' . $cart->item_image) }}" alt="image" /></td>
        <td class="border-2 p-1 text-center">
          <div>
            <h1 class="font-bold">{{ $cart->item_name }}</h1>
            <p class="text-sm">{{ $cart->item_description }}</p>
          </div>
        </td>
        <td class="border-2 p-1 text-center">Rp {{ number_format($cart->price,0,'.','.') }},-</td>
        <td class="border-2 text-center">
          <form action="{{ url('carts/purchase-amount') }}" method="POST">
            @csrf
            <select name="count" >
              @for ($i = 0; $i < $cart->item_stock; $i++)
                <option value="{{ $i+1 }}" @if($i+1 == $cart->count) selected @endif>{{ $i+1 }}</option>
              @endfor
            </select> 
            <input type="hidden" value="{{ $cart->id_cart }}" name="id_cart">
            <button type="submit">Cek</button>
          </form>
        </td>
        <td class="border-2 p-1 text-center">Rp {{ number_format($cart->price * $cart->count,0,'.','.') }},-</td>
      </tr>
      @empty
      <h1>checkout kosong</h1>
      @endforelse 

      @if (count($myCart) > 0)
      <tr>
        <td colspan="5" class="border-2 p-1 text-right font-semibold">Total Price</td>
        <?php
          $pricee=0;
        ?>
        @foreach ($myCart as $cart)
          <?php 
            $pricee = $pricee+($cart->price * $cart->count);
          ?>
        @endforeach
          <td class="border-2 p-1 text-center">Rp {{ number_format($pricee,0,'.','.') }},-</td>
      </tr>
      @endif
    </tbody>
  </table>

    <form action="{{ url('checkout/now') }}" method="POST" class="flex justify-center mt-5">
      @csrf
      <input type="hidden" value="{{ $pricee }}" name="total_price">
        @forelse ($myCart as $cart)
          <input type="hidden" value="{{ $cart->id_item }}" name="id_item[]">
          <input type="hidden" value="{{ $cart->id_cart }}" name="id_cart[]">
          <input type="hidden" value="{{ $cart->price }}" name="price[]">
          <input type="hidden" value="{{ $cart->count }}" name="count[]">
          <input type="hidden" value="pending" name="status[]">
        @empty
        @endforelse

      <button type="submit" class="bg-green-600 px-3 py-2 rounded text-white font-medium hover:bg-green-700 transform hover:-translate-y-1 duration-300 ease-in-out">Checkout</button>
    </form>

</div>

@endsection