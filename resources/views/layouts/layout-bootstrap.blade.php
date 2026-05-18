<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lezioni Informatica</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f6f7fb;
        }

        .app-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }
    </style>
</head>

<body>

    <div class="app-shell">

        <x-navbar />

        <main class="container pb-4">
            @yield('content')
        </main>

        <x-footer />

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Echo (solo se serve) --}}
    @if (isset($enableEcho) && $enableEcho)
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script src="https://unpkg.com/laravel-echo@1.16.1/dist/echo.iife.js"></script>

        <script>
            window.Pusher = Pusher;

            window.Echo = new Echo({
                broadcaster: 'reverb',
                key: 'local',
                wsHost: window.location.hostname,
                wsPort: 8080,
                forceTLS: false,
                enabledTransports: ['ws', 'wss'],
            });
        </script>
    @endif

</body>

</html>
