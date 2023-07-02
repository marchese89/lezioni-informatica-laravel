<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lezioni Informatica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="custom_javascript/livevalidation_standalone.compressed.js"></script>
    <script type="text/javascript" src="custom_javascript/utility.js?ts=<?= time() ?>&quot"></script>
    <link href="custom_css/validation.css" rel="stylesheet" type="text/css">
    <link href="custom_css/admin.css" rel="stylesheet" type="text/css">
    <link href="custom_css/index.css" rel="stylesheet" type="text/css">
    <link href="custom_css/chat.css" rel="stylesheet" type="text/css">
    <style>
        body {
            overflow-y: scroll;
        }

        #navbarSupportedContent ul li a {
            font-size: 1.2em;
            font-weight: 600;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Monomaniac+One&display=swap" rel="stylesheet">
</head>

<body>
    <header>

        <nav class="navbar navbar-expand-sm bg-light navbar-light justify-content-end">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
                @guest
                    <ul class="navbar-nav text-right">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('login') }}">Login</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('registrati') }}">Registrati</a>
                        </li>
                    </ul>
                @endguest
                @auth
                    @if (auth()->user()->role === 'student')
                        <i class="fa fa-shopping-cart" aria-hidden="true"
                            style="display: inline;font-size:24px;cursor: pointer"
                            onclick=location.href="visualizza-carrello" style="">

                        </i>
                        <label style="font-size:24px"> &nbsp;({{ session()->get('carrello')->nElementi() }})</label>
                    @endif
                    <ul class="navbar-nav text-right">
                        <li class="nav-item dropdown">

                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ auth()->user()->name }} (@php
                                    if (auth()->user()->role == 'student') {
                                        echo 'studente';
                                    } else {
                                        echo 'admin';
                                    }
                                @endphp)
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if (auth()->user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ url('dashboard-admin') }}">Area Protetta</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ url('dashboard-studente') }}">Area Protetta</a>
                                    </li>
                                @endif
                                <li><a class="dropdown-item" href="{{ url('logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                @endauth
            </div>

        </nav>

        <div class="text-bg-light p-3">
            <div style="text-align:center;">
                <h1 style="font-family: 'Monomaniac One', sans-serif;font-size:56px">Lezioni Informatica</h1>
            </div>

            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                        <div class="btn-group" role="group">
                            <button class="btn btn-primary" onclick=location.href="/">Home</button>

                            <button class="btn btn-primary" onclick=location.href="aree-tematiche">Aree
                                Tematiche</button>

                            <button class="btn btn-primary" onclick=location.href="lezione-su-richiesta">Materiale
                                su
                                richiesta</button>

                            <button class="btn btn-primary" onclick=location.href="informazioni">Informazioni</button>


                        </div>
                    </div>
                </div>
            </nav>

    </header>

    @yield('content')


    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Lezioni Informatica 2023</div>
                <div>
                    <a href="privacy">Privacy Policy</a>
                    &middot;
                    <a href="coockie">Coockie Policy</a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

</body>

</html>
