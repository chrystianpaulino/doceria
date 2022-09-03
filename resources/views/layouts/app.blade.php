<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    {{--    @vite(['resources/sass/app.scss', 'resources/js/app.js'])--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" id="light-style"/>
    <link href="{{ asset('css/select2-bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <style>

    </style>

    @yield('css')

</head>
<body class="d-flex flex-column h-100">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href=" {{ route('home') }}">
                <span style="color: #6cb2eb">Adocicare</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @if(Auth::check())
                <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('products.index') }}"><i class="fas fa-burger-soda"></i> Produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('aditionals.index') }}"><i class="fas fa-candy-cane"></i> Adicionais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('customers.index') }}"><i class="fas fa-user"></i> Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('orders.index') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('feedstocks.index') }}"><i class="fas fa-inventory"></i> Insumos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('providers.index') }}"><i class="fas fa-industry"></i> Fornecedores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('costs.index') }}"><i class="fa fa-money" aria-hidden="true"></i> Despesas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#"><i class="fa fa-file" aria-hidden="true"></i> Relatórios</a>
                        </li>
                    </ul>
            @endif

            <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4" class="flex-shrink-0">

        @yield('breads')

        @yield('content')
    </main>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.full.js') }}"></script>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script src="https://kit.fontawesome.com/4a05637478.js" crossorigin="anonymous"></script>

<script>
    $('#price').mask('000.000.000.000.000,00', {reverse: true});
    $(".placa").mask("aaa-9*99");
    $(".cartao").mask("9999999999999999");
    $(".ccv").mask("999");
    $(".ano").mask("9999");
    $(".mes").mask("99");
    $(".cep").mask("99999-999");
    $(".mesano").mask("99/9999");
    $(".hora").mask("99:99");
    $(".datas").mask("99/99/9999");
    $(".cnpj").mask("99.999.999/9999-99");
    $(".cpf").mask("999.999.999-99");
    $(".phone").mask("(99) 99999-9999")
</script>

@yield('js')

</body>
</html>
