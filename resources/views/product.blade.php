<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Edit Product') }}</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
<h1>{{ __('Edit Product') }}</h1>

<form method="post" action="{{ route('handleProduct') }}?id={{ $product->id }}" enctype="multipart/form-data">
    @csrf

    <input type="text"
           name="title"
           placeholder="{{ __('Title')}}"
           value="{{ old('title', $product->title) }}"
    ><br>

    <input type="text"
           name="description"
           placeholder="{{ __('Description')}}"
           value="{{ old('description', $product->description) }}"
    ><br>

    <input type="number"
           name="price"
           placeholder="{{ __('Price')}}"
           value="{{ old('price', $product->price) }}"
    ><br>

    <input type="file"
           name="img_link"
    ><br>

    <button type="submit">{{__('Update')}}</button>
</form>

@if ($errors->any())
    <div style="color:red;" class="error">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif
</body>
</html>
