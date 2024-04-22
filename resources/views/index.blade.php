<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Home') }}</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
<h1>{{ __('All products') }}</h1>
<a href="{{ route('cart') }}">{{ __('Go to cart') }}</a>
@guest
    <a href="{{ route('login') }}">{{ __('Login') }}</a>
@else
    <a href="{{ route('products') }}">{{ __('All Products') }}</a>
<form method="POST" action="/logout">
    @csrf
    <button type="submit">Log Out</button>
</form>
@endguest
{{--<a href="{{ route('products.index') }}">{{ __('Products') }}</a>--}}
@if (empty($products))
    <h3>{{ __('No Products') }}</h3>
@else
    @foreach ($products as $product)
        <div class="container">
            <div class="item">
                <img style="height: 120px; width: 120px;" alt="img" src="{{ asset('storage/images/' . $product->img_link) }}">
            </div>

            <div class="item">
                <h3>{{ __('Title') }}: {{ $product->title }}</h3>
                <p>{{ __('Description') }}: {{ $product->description }}</p>
                <p>{{ __('Price') }}: {{ $product->price }}</p>
            </div>

            <div class="item">
                <a href="{{ route('addToCart', ['productId' => $product->id]) }}">{{ __('Add') }}</a>
            </div>
        </div>
    @endforeach
@endif
@if(session()->has('success'))
    <div class="success">
        <p>
            {{session('success')}}
        </p>
    </div>

@endif
</body>
</html>
