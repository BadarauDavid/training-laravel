<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Home') }}</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
<h1>{{ __('Add product') }}</h1>

<form method="post" action="/handleAddProduct" enctype="multipart/form-data">
    @csrf

    <input type="text"
           name="title"
           placeholder="{{ __('Title')}}"
           value="{{old('title')}}"
    ><br>

    <input type="text"
           name="description"
           placeholder="{{ __('Description')}}"
           value="{{old('description')}}"
    ><br>

    <input type="number"
           name="price"
           placeholder="{{ __('Price')}}"
           value="{{old('price')}}"
    ><br>

    <input type="file"
           name="img_link"
    ><br>

    <button type="submit">{{__('Save')}}</button>
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
