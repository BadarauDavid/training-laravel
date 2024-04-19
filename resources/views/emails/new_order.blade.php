<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Home') }}</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
<h1>{{ __('Order') }}</h1>

@foreach ($products as $product)
    <div class="container">
        <div class="item">
            <img style="height: 120px; width: 120px;" alt="img" src="{{ asset('images/' . $product->img_link) }}">
        </div>

        <div class="item">
            <h3>{{ __('Title') }}: {{ $product->title }}</h3>
            <p>{{ __('Description') }}: {{ $product->description }}</p>
            <p>{{ __('Price') }}: {{ $product->price }}</p>
        </div>

    </div>
@endforeach

<h3>{{__('Name')}} : {{$customerName}}</h3>
<h3>{{__('Contact')}} : {{$customerContact}}</h3>
<h3>{{__('Comment')}} : {{$comment}}</h3>
</body>
</html>
