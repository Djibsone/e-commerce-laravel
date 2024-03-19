
@extends('layouts.master')


@section('content')
    <div class="col-md-12">
        <div class="row no-gutters border rounded overflow-hidden flex-md-row shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary">Categorie 1</strong>
                <h5 class="mb-0">{{ $product->title }}</h5>
                <div class="mb-1 text-muted">{{ $product->created_at->format('d/m/y') }}</div>
                <p class="mb-auto">{!! $product->subtitle !!}</p>
                <strong class="card-text mb-auto">{{ $product->getPrice() }}</strong>
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    {{-- <div class="form-group row mb-3 my-2">
                        <label class="col-sm-2 col-form-label">Quantité</label>
                        <div class="col-sm-2">
                          <input type="number"name="quantity" placeholder="Quantité ?" class="form-control @error('quantity') is-invalid @enderror">
                        </div>
                        @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-dark">Ajouter au panier</button>
                </form>
            </div>
            <div class="col-auto d-none d-lg-block">
                <img src="{{ $product->image }}" alt="">
            </div>
        </div>
    </div>
@endsection
