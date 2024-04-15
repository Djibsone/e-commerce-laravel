@extends('layouts.master')


@section('content')
    <div class="col-md-12">
        <div class="row no-gutters border rounded overflow-hidden flex-md-row shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
                <muted class="d-inline-block mb-2 text-primary">
                    <div class="badge badge-pill badge-info">{{ $stock }}</div>
                    @foreach ($product->categories as $category)
                        {{ $category->name }}{{ $loop->last ? '' : ', ' }}
                    @endforeach
                </muted>
                <h5 class="mb-0">{{ $product->title }}</h5>
                <div class="mb-1 text-muted">{{ $product->created_at->format('d/m/y') }}</div>
                <p class="mb-auto">{!! $product->subtitle !!}</p>
                <strong class="card-text mb-auto">{{ $product->getPrice() }}</strong>
                @if ($stock === 'Disponible')
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
                @endif
            </div>
            <div class="col-auto d-none d-lg-block">
                <img src="{{ $product->image }}" alt="Image" id="mainImage">
                <div class="mt-2">
                    @if ($product->images)
                        <img src="{{ $product->image }}" alt="Image" class="img-thumbnail">
                        @foreach (json_decode($product->images, true) as $image)
                            <img src="{{ asset('storage/' . $image) }}" width="50" alt="Image"
                                class="img-thumbnail">
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script>
        var mainImage = document.querySelector('#mainImage');
        var thumbnail = document.querySelectorAll('.img-thumbnail');

        thumbnail.forEach((element) => element.addEventListener('click', changeImage));

        function changeImage(e) {
            mainImage.src = this.src;
        }
    </script>
@endsection
