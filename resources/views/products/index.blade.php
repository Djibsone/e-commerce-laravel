@extends('layouts.master')

@section('content')
    @foreach($products as $product)
        <x-card :product='$product' />
    @endforeach
    <div class="my-4">
        {{ $products->appends(request()->input())->links() }}
    </div>
@endsection 