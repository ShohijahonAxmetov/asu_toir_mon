<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Admin Panel') }}</title> -->
    <title>Панель администратора</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" />
    <link rel="stylesheet" href="/assets/css/libs.bundle.css" />
    <link rel="stylesheet" href="/assets/css/theme.bundle.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    @yield('links')

    <!-- Scripts -->
</head>
<body class="{{isset($no_sidebar) ? 'd-flex align-items-center bg-auth border-top border-top-2 border-primary' : ''}}">
    <div id="preloader">
        <img src="/assets/img/preloader.gif" style="width: 100px;">
    </div>
    @if(!isset($no_sidebar))
        <!-- NAVIGATION -->
        <nav class="navbar navbar-vertical fixed-start navbar-expand-md navbar-light" id="sidebar">
            <div class="container-fluid">

                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse"
                        aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Brand -->
                <a class="navbar-brand">
                    <img src="/assets/img/logo.svg" class="navbar-brand-img mx-auto" alt="...">
                </a>

                <!-- User (xs) -->
                <div class="navbar-user d-md-none">

                    <!-- Dropdown -->
                    <div class="dropdown">

                        <!-- Toggle -->
                        <a href="#" id="sidebarIcon" class="dropdown-toggle" role="button" data-bs-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-sm avatar-online">
                                <img src="/assets/img/avatars/profiles/avatar-6.jpg" class="avatar-img rounded-circle"
                                     alt="...">
                            </div>
                        </a>

                        <!-- Menu -->
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarIcon">
                            <a href="/sign-in.html" class="dropdown-item">Logout</a>
                        </div>

                    </div>

                </div>

                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidebarCollapse">

                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fe fe-home"></i> Дашбоард
                            </a>
                        </li>
                        <hr class="navbar-divider my-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('equipments') || request()->is('equipments/*') ? 'active' : '' }}"
                               href="{{ route('equipments.index') }}">
                                <i class="fe fe-truck"></i> Оборудования
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('details') || request()->is('details/*') ? 'active' : '' }}"
                               href="{{ route('details.index') }}">
                                <i class="fe fe-settings"></i> Агрегаты, узлы
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('technical_inspections') || request()->is('technical_inspections/*') ? 'active' : '' }}"
                               href="{{ route('technical_inspections.index') }}">
                                <i class="fe fe-briefcase"></i> Технические обслуживания и ремонты
                            </a>
                        </li>
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="#posts" data-bs-toggle="collapse" role="button"--}}
{{--                               aria-expanded="{{ request()->is('posts') || request()->is('posts/*') || request()->is('posts_categories') || request()->is('posts_categories/*') ? 'true' : 'false' }}"--}}
{{--                               aria-controls="posts">--}}
{{--                                <i class="fe fe-cast"></i> Посты--}}
{{--                            </a>--}}
{{--                            <div--}}
{{--                                class="collapse {{ request()->is('admin/posts') || request()->is('admin/posts/*') || request()->is('admin/posts_categories') || request()->is('admin/posts_categories/*') ? 'show' : '' }}"--}}
{{--                                id="posts">--}}
{{--                                <ul class="nav nav-sm flex-column">--}}
{{--                                    <li class="nav-item">--}}
{{--                                        <a class="nav-link {{ request()->is('') || request()->is('') ? 'active' : '' }}"--}}
{{--                                           href="">--}}
{{--                                            Посты--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </li>--}}
                        <hr class="navbar-divider my-3">
                        <li class="nav-item">
                            <a class="nav-link" href="#static_info" data-bs-toggle="collapse" role="button"
                               aria-expanded="{{ request()->is('admin/site_infos') || request()->is('admin/site_infos/*') ? 'true' : 'false' }}"
                               aria-controls="documents">
                                <i class="fe fe-book"></i> Справочники
                            </a>
                            <div
                                class="collapse {{ request()->is('type_technical_inspections') || request()->is('type_technical_inspections/*') ? 'show' : '' }}"
                                id="static_info">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('type_technical_inspections') || request()->is('type_technical_inspections/*') ? 'active' : '' }}"
                                           href="{{ route('type_technical_inspections.index') }}">
                                            Типы технических обслуживаний
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>

                    <!-- Push content down -->
                    <div class="mt-auto"></div>


                    <!-- User (md) -->
                    <div class="navbar-user d-none d-md-flex" id="sidebarUser">

                        <!-- Dropup -->
                        <div class="dropup">

                            <!-- Toggle -->
                            <a href="#" id="sidebarIconCopy" class="dropdown-toggle" role="button" data-bs-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-sm avatar-online">
                                    <img src="/assets/img/avatars/profiles/default_user.png"
                                         class="avatar-img rounded-circle" alt="...">
                                </div>
                            </a>

                            <!-- Menu -->
                            <div class="dropdown-menu" aria-labelledby="sidebarIconCopy">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                   class="dropdown-item">Выйти</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>

                        </div>

                    </div>

                </div> <!-- / .navbar-collapse -->

            </div>
        </nav>
    @endif
    <!-- MAIN CONTENT -->
    <div class="main-content">

        @yield('content')

    </div><!-- / .main-content -->

    <!-- JAVASCRIPT -->
    <!-- Map JS -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>

    <!-- Vendor JS -->
    <script src="/assets/js/vendor.bundle.js"></script>

    <!-- Theme JS -->
    <script src="/assets/js/theme.bundle.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"
            integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    @yield('scripts')

    @if (session()->has('success') && session('success') == false)
        <script type="text/javascript">
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                    type: 'error',
                    background: '#b82c46',
                    icon: {
                        className: 'fe fe-x',
                        tagName: 'span',
                        color: '#fff'
                    },
                    dismissible: false
                }]
            });
            notyf.open({
                type: 'error',
                message: <?= json_encode(session('message')) ?>
            });
        </script>
    @endif

    @if (session()->has('success') && session('success') == true)
        <script type="text/javascript">
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                    type: 'success',
                    background: '#00ae65',
                    icon: {
                        className: 'fe fe-check-circle',
                        tagName: 'span',
                        color: '#fff'
                    },
                    dismissible: false
                }]
            });
            notyf.open({
                type: 'success',
                message: <?= json_encode(session('message')) ?>
            });
        </script>
    @endif

    <script>
        const preloader = document.getElementById('preloader');
        preloader.classList.add('d-none');
    </script>
</body>
</html>
