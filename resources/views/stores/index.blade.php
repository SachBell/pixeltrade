<h1>Tienda de {{ $server->name_server }}</h1>

@foreach ($categories as $category)
    <h2><a href="{{ route('stores.categories.index', [$server->slug, $category->id]) }}">{{ $category->name_categorie }}</a></h2>
@endforeach

@foreach ($products as $product)
    <div>
        <h3><a href="{{ route('stores.products.show', [$server->slug, $product->id]) }}">{{ $product->name_product }}</a></h3>
        <p>{{ $product->description }}</p>
        <p>Precio: ${{ $product->price }}</p>
    </div>
@endforeach
