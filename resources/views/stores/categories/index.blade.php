<h1>Categoría: {{ $category->name_categorie }}</h1>

@foreach ($products as $product)
    <div>
        <h3><a href="{{ route('stores.products.show', [$server->slug, $product->id]) }}">{{ $product->name_product }}</a></h3>
        <p>{{ $product->description }}</p>
        <p>Precio: ${{ $product->price }}</p>
    </div>
@endforeach
