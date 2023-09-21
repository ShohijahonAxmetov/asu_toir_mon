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
    <style type="text/css">
        table tr:hover {
            --bs-table-hover-bg: rgba(4,7,13,.03);
        }
    </style>
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
                            <a href="/sign-in.html" class="dropdown-item">Выход</a>
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
                            <a class="nav-link" href="#equipments" data-bs-toggle="collapse" role="button"
                               aria-expanded="{{ request()->is('equipments') || request()->is('equipments/*') || request()->is('type_equipments') || request()->is('type_equipments/*') ? 'true' : 'false' }}"
                               aria-controls="documents">
                                <i class="fe fe-truck"></i> Оборудования
                            </a>
                            <div
                                class="collapse {{ request()->is('equipments') || request()->is('equipments/*') || request()->is('type_equipments') || request()->is('type_equipments/*') ? 'show' : '' }}"
                                id="equipments">
                                <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                        <a class="nav-link {{ request()->is('equipments') || request()->is('equipments/*') ? 'active' : '' }}"
                                           href="{{ route('equipments.index') }}">
                                            Оборудования
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('type_equipments') || request()->is('type_equipments/*') ? 'active' : '' }}"
                                           href="{{ route('type_equipments.index') }}">
                                            Типы оборудования
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('vid_equipments') || request()->is('vid_equipments/*') ? 'active' : '' }}"
                                           href="{{ route('vid_equipments.index') }}">
                                            Виды оборудования
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#technical_resources" data-bs-toggle="collapse" role="button"
                               aria-expanded="{{ request()->is('technical_resources') || request()->is('technical_resources/*') || request()->is('technical_resource_type_equipment') || request()->is('technical_resource_type_equipment/*') ? 'true' : 'false' }}"
                               aria-controls="documents">
                                <i class="fe fe-settings"></i> Материально-технические ресурсы
                            </a>
                            <div
                                class="collapse {{ request()->is('technical_resources') || request()->is('technical_resources/*') || request()->is('technical_resource_type_eqs') || request()->is('technical_resource_type_eqs/*') ? 'show' : '' }}"
                                id="technical_resources">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('technical_resources') || request()->is('technical_resources/*') ? 'active' : '' }}"
                                           href="{{ route('technical_resources.index') }}">
                                            Материально-технические ресурсы
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('technical_resource_type_equipment') || request()->is('technical_resource_type_equipment/*') ? 'active' : '' }}"
                                           href="{{ route('technical_resource_type_eqs.index') }}">
                                            Узлы для типа оборудования
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('plan_remonts') || request()->is('plan_remonts/*') ? 'active' : '' }}"
                               href="{{ route('plan_remonts.index') }}">
                                <i class="fe fe-briefcase"></i> Запланированные ремонты
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#applications" data-bs-toggle="collapse" role="button"
                               aria-expanded="{{ request()->is('year_applications') || request()->is('year_applications/*') ? 'true' : 'false' }}"
                               aria-controls="documents">
                                <i class="fe fe-book"></i> Заявки
                            </a>
                            <div
                                class="collapse {{ request()->is('year_applications') || request()->is('year_applications/*') ? 'show' : '' }}"
                                id="applications">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('year_applications') || request()->is('year_applications/*') ? 'active' : '' }}"
                                           href="{{ route('year_applications.index') }}">
                                            Годовая заявка на ремонт
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link {{ request()->is('repair_applications') || request()->is('repair_applications/*') ? 'active' : '' }}"
                                           href="{{ route('repair_applications.index') }}">
                                            Заявки на ремонты
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('emergency_applications') || request()->is('emergency_applications/*') ? 'active' : '' }}"
                                           href="{{ route('emergency_applications.index') }}">
                                            Аварийная разовая заявка
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('order_resources') || request()->is('order_resources/*') ? 'active' : '' }}"
                               href="{{ route('order_resources.index') }}">
                                <i class="fe fe-book"></i> Учет исполнения заявок
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('monitoring') ? 'active' : '' }}"
                               href="{{ route('monitoring') }}">
                                <i class="fe fe-book"></i> Мониторинг
                            </a>
                        </li>
                        <hr class="navbar-divider my-3">
                        <li class="nav-item">
                            <a class="nav-link" href="#static_info" data-bs-toggle="collapse" role="button"
                               aria-expanded="{{ request()->is('departments') || request()->is('departments/*') || request()->is('remont_types') || request()->is('remont_types/*') ? 'true' : 'false' }}"
                               aria-controls="documents">
                                <i class="fe fe-book"></i> Справочники
                            </a>
                            <div
                                class="collapse {{ request()->is('departments') || request()->is('departments/*') || request()->is('remont_types') || request()->is('remont_types/*') ? 'show' : '' }}"
                                id="static_info">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="{{route('departments.index')}}">
                                            Подразделения
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="{{route('remont_types.index')}}">
                                            Виды ремонтов
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="{{route('execution_statuses.index')}}">
                                            Статус исполнения
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="{{route('units.index')}}">
                                            Единицы измерения
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
