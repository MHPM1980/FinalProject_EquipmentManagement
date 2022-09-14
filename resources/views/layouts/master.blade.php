<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ATEC - GE</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">

    <link rel="shortcut icon" href="{{ asset('./img/logo.png') }}">
    <style>
        body{
            background-color: rgba(12, 48, 72, 1);
            background: linear-gradient(180deg, rgba(43, 121, 180, 1) 0%, rgba(32, 95, 142, 1) 30%, rgba(12, 48, 72, 1) 60%, rgba(9, 41, 61, 1) 100%);
        }
    </style>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="/dashboard" class="brand-link">
            <img src="./img/logo.png" alt="atec Logo" class="brand-image" >
            <span class="brand-text font-weight-light">ATEC - GE</span>
        </a>

        <div class="sidebar">

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    @switch(Auth::user()->role->name)
                        @case(Auth::user()->role->name=='ADMIN')
                            <img src="./img/roles/Admin.png" class="img-circle elevation-2" alt="User Image">
                        @break
                        @case(Auth::user()->role->name=='GESTOR')
                            <img src="./img/roles/Gestor.png" class="img-circle elevation-2" alt="User Image">
                        @break
                        @case(Auth::user()->role->name=='FORMADOR')
                            <img src="./img/roles/Formador.png" class="img-circle elevation-2" alt="User Image">
                        @break
                        @case(Auth::user()->role->name=='FORMANDO')
                            <img src="./img/roles/Formando.png" class="img-circle elevation-2" alt="User Image">
                        @break
                    @endswitch
                </div>
                <div class="info">
                    <a href="#" class="d-block h5">
                        {{ Auth::user()->name }}
                    </a>
                    <p class="d-block text-white h6">
                        {{ Auth::user()->role->name }}
                    </p>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="#" class="nav-link">
                            <i class="fas fa-solid fa-screwdriver-wrench nav-icon"></i>
                            <p>Equipamentos</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/reservations" class="nav-link">
                            <i class="fas fa-regular fa-calendar-check nav-icon"></i>
                            <p>Reservas</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/profile" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Perfil
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Gestão
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/users" class="nav-link">
                                    <i class="fas fa-users nav-icon"></i>
                                    <p>Utilizadores</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/roles" class="nav-link">
                                    <i class="fas fa-solid fa-lock nav-icon"></i>
                                    <p>Permissões Utilizador</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/equipments" class="nav-link">
                                    <i class="fas fa-solid fa-screwdriver-wrench nav-icon"></i>
                                    <p>Equipamentos</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/categories" class="nav-link">
                                    <i class="fas fa-solid fa-gears nav-icon"></i>
                                    <p>Categorias Equipamento</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/entities" class="nav-link">
                                    <i class="fas fa-regular fa-building nav-icon"></i>
                                    <p>Entidades</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/warehouses" class="nav-link">
                                    <i class="fas fa-solid fa-warehouse nav-icon"></i>
                                    <p>Armazéns</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/costs" class="nav-link">
                                    <i class="fas fa-solid fa-euro-sign nav-icon"></i>
                                    <p>Centro Custos</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-power-off text-red"></i>
                            <p>
                                {{ __('Sair') }}
                            </p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <div class="content-wrapper bg-transparent">
        <div class="content">
            <div class="container-fluid">
                <router-view></router-view>

                <vue-progress-bar></vue-progress-bar>
            </div>
        </div>
    </div>
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Renato Rodrigues | Márcio Miguel |Tiago Machado
        </div>
        <strong>Copyright &copy; ATEC <a href="https://www.atec.pt/">atec.pt</a>.</strong> Todos os direitos reservados.
    </footer>
</div>
<script src="/js/app.js"></script>
</body>
</html>

