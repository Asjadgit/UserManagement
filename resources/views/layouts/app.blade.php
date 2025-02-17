<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    {{-- select2 library --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


    

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

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
                            @if (auth()->user()->hasRole('Super Admin'))
                                <li class="nav-item dropdown">
                                    <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        User Management
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                        <a class="dropdown-item" href="{{ route('roles.index') }}">Manage Roles</a>
                                        <a class="dropdown-item" href="{{ route('permissions.index') }}">Manage
                                            Permissions</a>
                                        <a class="dropdown-item" href="{{ route('users.index') }}">Manage Users</a>
                                        <a class="dropdown-item" href="{{ route('teams.index') }}">Manage Teams</a>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Plan Management
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                        <a class="dropdown-item" href="{{ route('currencies.index') }}">Manage Currencies</a>
                                        <a class="dropdown-item" href="{{ route('plans.index') }}">Manage Plans</a>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Visibility Groups
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                        <a class="dropdown-item" href="{{ route('visibility_groups.index') }}">Manage Visibility Groups</a>
                                    </div>
                                </li>


                                <li class="nav-item dropdown">
                                    <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Items
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                        <a class="dropdown-item" href="{{ route('leads.index') }}">Manage Leads</a>

                                        <a class="dropdown-item" href="{{ route('deals.index') }}">Manage Deals</a>
                                    </div>
                                </li>
                            @endif

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

        <main class="py-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>

<!-- DataTables JS -->
    <!-- jQuery (Before DataTables JS) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 on the user selection dropdown
        $('#user_id').select2({
            placeholder: 'Select users',
            allowClear: true
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#Table').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            "language": {
                "search": "Filter records:"
            }
        });
    });
</script>



</html>
