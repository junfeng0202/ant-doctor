<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="X-CSRF-TOKEN" content="{{csrf_token()}}">
        <title>Laravel</title>

    </head>
    <body>
        <div id="app">
            <example-component></example-component>
            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
