@extends('template.app')

@section('title','ShopAja')

@section('content')
<div class="container mx-auto my-5">
    <h1 class="text-2xl font-bold">Home</h1>
    @foreach ($items as $item)
        @if ($item->id_user != auth()->user()->id)
            <h1>{{ $loop->iteration }}</h1>
            <h1>{{ $item->item_name }}</h1>
        @endif
    @endforeach
    <a href="{{ url('items/create') }}">create item</a>
</div>
@endsection