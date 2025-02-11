<h1>{{ $products->name_product }}</h1>
<p>{{ $products->description }}</p>
<p>Precio: ${{ $products->price }}</p>
<a href="{{ route('stores.products.index', $server->slug) }}">Volver a productos</a>
