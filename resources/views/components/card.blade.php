<div class="col-md-6 mb-4 px-3">
    <div class="row no-gutters border rounded overflow-hidden flex-md-row shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <small class="d-inline-block mb-2">
                
                @php
                    $path = request()->query();
                    $param = reset($path);
                @endphp

                @foreach ($product->categories as $category)
                    {!! ($category->slug == $param) ? "<span class='badge bg-secondary'>$category->name</span>" : $category->name !!}
                @endforeach
            </small>
            <h5 class="mb-0">{{ $product->title }}</h5>
            <div class="mb-1 text-muted">{{ $product->created_at->format('d/m/y') }}</div>
            <p class="mb-auto">{{ $product->subtitle }}</p>
            <strong class="card-text mb-auto">{{ $product->getPrice() }}</strong>
            <a href="{{ route('product.show', ['slug' => $product->slug, 'product' => $product]) }}" class="stretched-link btn btn-primary">Voir Article</a>
        </div>
        <div class="col-auto d-none d-lg-block">
            <img src="{{ $product->image }}" alt="">
        </div>
    </div>
</div>


{{-- @section('content')
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach($products as $product)
            <div class="col">
                <div class="card h-100">
                    <div class="row g-0">
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->title }}</h5>
                                <p class="card-text">{{ $product->subtitle }}</p>
                                <p class="card-text"><strong>{{ $product->getPrice() }}</strong></p>
                                <p class="card-text"><small class="text-muted">{{ $product->created_at->format('d/m/y') }}</small></p>
                                <a href="{{ route('product.show', ['slug' => $product->slug, 'product' => $product->id]) }}" class="stretched-link btn btn-primary">Voir Article</a>
                            </div>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <img src="{{ $product->image }}" class="img-fluid rounded-start" alt="{{ $product->title }}">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="my-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection --}}
