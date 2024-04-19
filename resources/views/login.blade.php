<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Login') }}</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
<h1>{{ __('Login') }}</h1>

<form method="POST" action="/handleLogin">
    @csrf
    <input type="email"
           name="email"
           placeholder="{{ __('Email')}}"
           value="{{old('email')}}"
    ><br>

    <input class="contact"
           type="password"
           name="password"
           placeholder="{{ __('Password') }}"
    ><br>

    <button type="submit">{{__('Login')}}</button>
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
