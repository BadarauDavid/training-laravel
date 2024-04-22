<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Order') }}</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
<h1>{{ __('Order') }}</h1>
<a href="{{ route('orders') }}">{{ __('All Orders') }}</a>
@foreach ($order['products'] as $product)
    <div class="container">
        <div class="item">
            <img style="height: 120px; width: 120px;" alt="img"
                 src="{{ asset('storage/images/' . $product->img_link) }}">
        </div>
        <div class="item">
            <h3>{{ __('Title') }}: {{ $product->title }}</h3>
            <p>{{ __('Description') }}: {{ $product->description }}</p>
            <p>{{ __('Price') }}: {{ $product->price }}</p>
        </div>
    </div>
@endforeach
<h3>{{ __('Customer Name') }}: {{ $order['details']->customer_name }}</h3>
<p>{{ __('Customer Contact') }}: {{ $order['details']->customer_contact }}</p>
<p>{{ __('Customer Comment') }}: {{ $order['details']->customer_comment }}</p>
</body>
</html>
