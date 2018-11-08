<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link href="{{ public_path('css/bootstrap.css') }}" rel="stylesheet" media="all" />
    </head>

    <body class="bg-white">
        @yield('content.main')
    </body>
</html>
