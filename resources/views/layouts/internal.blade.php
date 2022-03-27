<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">

    
    <style>
        /* TOASTR BUGFIX */
        #toast-container > div {
        opacity: 1;
        }
        .toast {
        font-size: initial !important;
        border: initial !important;
        backdrop-filter: blur(0) !important;
        }
        .toast-success {
        background-color: #51A351 !important;
        }
        .toast-error {
        background-color: #BD362F !important;
        }
        .toast-info {
        background-color: #2F96B4 !important;
        }
        .toast-warning {
        background-color: #F89406 !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 p-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

                <!--  Show this only on mobile to medium screens  -->
                <a class="navbar-brand d-lg-none" href="#">Navbar</a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!--  Use flexbox utility classes to change how the child elements are justified  -->
                <div class="collapse navbar-collapse justify-content-between" id="navbarToggle">

                    <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{Route::is('home') ? 'active' : ''}}" href="{{route('home')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Route::is('tarefa.index') ? 'active' : ''}}" href="{{route('tarefa.index')}}">tarefas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Link</a>
                    </li>
                    </ul>
                    
                    
                <!--   Show this only lg screens and up   -->
                    <a class="navbar-brand d-none d-lg-block" href="#">Navbar</a>
                    
                    
                    
                    <ul class="navbar-nav">

                        <li class="nav-item" style="display: flex; align-items: center;"> 
                            <div class="badge bg-secondary"> {{ Auth::user()->name }}</div>
                        </li>

                    <li class="nav-item">
                        <a class="nav-link"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('sair') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    </ul>
                </div>
            </nav>
            </div>
        </div>
        @yield('content')
        <footer class="footer py-3 bg-light text-center" style="position: fixed; bottom: 0; width: 100%; background-color: #8000803d !important; left: 0;">
            <span class="text-muted">Task manager &copy; | 2022</span>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(function(){
            @if(Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif

            @if(Session::has('info'))
                toastr.info("{{ Session::get('info') }}");
            @endif

            @if(Session::has('warning'))
                toastr.warning("{{ Session::get('warning') }}");
            @endif

            @if(Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @endif
        });
        </script>
    @yield('script')
    @yield('modals')
</body>
</html>