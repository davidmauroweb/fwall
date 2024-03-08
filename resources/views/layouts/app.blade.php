<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FWall') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts bootstrap.css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <!-- Scripts bootstrap.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Sweet Alert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="row" id="app">
        <div class="col-1">
        
                <a href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>


                    <!-- Left Side Of Navbar -->
                    <ul class="me-auto">
                    @if(isset(Auth::user()->adm))
                        @if(Auth::user()->adm)
                        <a href="{{ url('/lista') }}"><ul><button type="button" class="btn btn-sm btn-outline-success"><i class="bi bi-person-fill"></i> Usuarios </button></ul></a>
                        <ul></ul>
                        @else
                        <form method="POST" action="{{ route('home.show2') }}">
                        @csrf
                            <input type="hidden" name="clientId" id="clientId" value="{{ Auth::user()->name }}">
                            <button type="submit" class="btn btn-sm btn-outline-warning"><i class="bi bi-list-check"></i> Registros </button></form>
                        <ul></ul>
                        @endif
                    @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li>
                                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end row" aria-labelledby="navbarDropdown">
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
@if (session('mensajeOk'))
<script>
    Swal.fire({
  position: "top-end",
  icon: "success",
  title: "{{session('mensajeOk')}}",
  showConfirmButton: false,
  timer: 3500
});
</script>
@endif
@if (session('mensajeNo'))
<script>
    Swal.fire({
  position: "top-end",
  icon: "error",
  title: "{{session('mensajeNo')}}",
  showConfirmButton: false,
  timer: 3500
});
</script>
@endif

@if (session('messages'))
<script>
    Swal.fire({
  position: "top-end",
  icon: "info",
  title: "{{session('messages')}}",
  showConfirmButton: false,
  timer: 3500
});
</script>
@endif

    </div>
    <div class="col">
    <main class="py-4">
            @yield('content')
    </main>
    </div>
    </div>
</body>
</html>
