@extends('template.app')

@section('title','Detail Item')

@section('content')
  {{ $item->item_name }}
@endsection