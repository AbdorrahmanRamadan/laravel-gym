<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div id="app">
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav ml-auto">
                    @guest
                    @else

                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
            </nav>

            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <a href="#" class="brand-link">

                    <span class="brand-text font-weight-light">Laravel gym</span>
                </a>
                <div class="sidebar">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{ asset('assets/dist/img/profile-placeholder.jpg') }}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        @role('admin')
                        <div class="info">
                            <a class="d-block">Admin</a>
                        </div>
                        @endrole
                        @role('city_manager')
                        <div class="info">
                            <a class="d-block">City Manager</a>
                        </div>
                        @endrole
                        @role('gym_manager')
                        <div class="info">
                            <a class="d-block">Gym Manager</a>
                        </div>
                        @endrole
                    </div>

                    <div class="form-inline">
                        <div class="input-group" data-widget="sidebar-search">
                            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sidebar">
                                    <i class="fas fa-search fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            @role('admin')
                            <li class="nav-item">
                                <a href="{{ route('citiesManagers.index') }}" class="nav-link">
                                    <p>
                                        City Managers
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Cities.index') }}" class="nav-link">
                                    <p>
                                        Cities
                                    </p>
                                </a>
                            </li>
                            @endrole
                            @hasanyrole('city_manager|admin')
                            <li class="nav-item">
                                <a href="{{route('GymManager')}}" class="nav-link">
                                    <p>
                                        Gym Managers
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Gyms.index') }}" class="nav-link">
                                    <p>
                                        Gyms
                                    </p>
                                </a>
                            </li>
                            @endrole
                            <li class="nav-item">
                                <a href="{{ route('Trainees.index') }}" class="nav-link">
                                    <p>
                                        Trainees
                                    </p>
                                </a>
                            </li>

                            @role('admin')
                            <li class="nav-item">
                                <a href="{{ route('TrainingPackages.index') }}" class="nav-link">
                                    <p>
                                        Training Packages
                                    </p>
                                </a>
                            </li>
                            @endrole
                            <li class="nav-item">
                                <a href="{{ route('TrainingSessions.index') }}" class="nav-link">
                                    <p>
                                        Training Sessions
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Coaches.index') }}" class="nav-link">
                                    <p>
                                        Coaches
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Attendance.index') }}" class="nav-link">
                                    <p>
                                        Attendance
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('Boughtpackages.index')}}" class="nav-link">
                                    <p>
                                        Buy packages for users
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('Revenue.index')}}" class="nav-link">
                                    <p>
                                        Revenue
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
            <div class="content-wrapper p-4">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (Session::has('danger'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('danger') }}
                </div>
                @endif


                @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
                @endif
                @yield('page_content')
            </div>
            <aside class="control-sidebar control-sidebar-dark">
                <div class="p-3">
                    <h5>Title</h5>
                    <p>Sidebar content</p>
                </div>
            </aside>
        </div>
    </div>


    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('script')

</body>

</html>
