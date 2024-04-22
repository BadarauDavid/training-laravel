<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Orders') }}</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
<h1>{{ __('All orders') }}</h1>
<a href="{{ route('index') }}">{{ __('Go to index') }}</a>

@if (empty($orders))
    <h3>{{ __('No Orders') }}</h3>
@else
    @foreach ($orders as $order)

        <h4># <a href="{{ route('order', ['productId' => $order->order_id]) }}">{{$order->order_id}}</a></h4>
        <h4>{{__('Price')}} : {{$order->total_price}}</h4>
        <h4>{{__('Summary')}} : {{$order->product_titles}}</h4>
        <h4>{{__('Data')}} : {{$order->order_created_at}}</h4>
        <hr>
    @endforeach
@endif
</body>
</html>
