<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Home') }}</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
<h1>{{ __('Cart') }}</h1>

<a href="{{ route('index') }}">{{ __('Go to index') }}</a>
@if (empty($products))
    <h5>{{ __('Cart is empty!') }}</h5>
@else
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

            <div class="item">
                <a href="{{ route('deleteFromCart', ['productId' => $product->id]) }}">{{ __('Delete') }}</a>
            </div>
        </div>
    @endforeach

    <form method="POST" action="/checkOutCart">
        @csrf
        <input type="text"
               name="customer_name"
               placeholder="{{ __('Name')}}"
               value="{{old('name')}}"
        ><br>

        <input class="contact"
               type="text"
               name="customer_contact"
               placeholder="{{ __('Contact Details') }}"
               value="{{old('contact')}}"
        ><br>

        <input class="comment"
               type="text"
               name="customer_comment"
               placeholder="{{__('Comments')}}"
               value="{{old('comment')}}"
        ><br>

        <button type="submit">{{__('Checkout')}}</button>
    </form>

    @if ($errors->any())
        <div style="color:red;" class="error">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
@endif
</body>
</html>
