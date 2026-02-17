<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Agenda Kunjungan PLN')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    @stack('styles')
    {!! ToastMagic::styles() !!}
</head>

<body>
    <div>
        @yield('content')
    </div>
    @stack('scripts')
    {!! ToastMagic::scripts() !!}
</body>

</html>
