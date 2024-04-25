<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Portal de clientes') }}</title>

    <!-- Fonts -->  
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" /> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css"
        rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/front.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/front2.css')}}">
    @yield('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm probit nav-desktop">
            <div class="container">
                <a class="navbar-brand" href="{{ route('frontend.home') }}">
                    <img src="{{ asset('storage/logo-ohffice-azul.jpeg') }}" width="100" >
                </a>
                <div style="display: flex">
                 <a id="notificaciones" class="nav-link no-hello" href="#" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre>
                                    <!-- ICONO CAMPANA -->
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16"
                                        height="1.5rem" width="1.5rem" xmlns="http://www.w3.org/2000/svg"
                                        style="overflow: visible;">
                                        <path
                                            d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z">
                                        </path>
                                        <!-- Círculo agrandado para representar el número de notificaciones -->

                                        <!-- Número denotificaciones -->
                                        @php(
                                        $alertsCount = \Auth::user()->userUserAlerts()->where('read', false)->count())


                                        @if ($alertsCount > 0)
                                            <circle cx="12" cy="4" r="6" fill="#059ed5"
                                                id="circle-notifications"></circle>
                                            <text x="12" y="5" font-size="7" fill="white"
                                                text-anchor="middle" font-weight="bolder"
                                                id="notification-counter">{{ $alertsCount }}</text>
                                        @endif
                                    </svg>
                </a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                   
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                            <li class="nav-item">

                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <div class="hello" style="display: flex; flex-wrap: nowrap; align-items: center; justify-content: space-around; ">
                            <p style="font-size: 1.3vw;" class="pt-4">Hola {{ Auth::user()->name }}!  </p>
                        
                        <a id="notificaciones" class="nav-link hello" href="#" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre>
                                    <!-- ICONO CAMPANA -->
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16"
                                        height="1.5rem" width="1.5rem" xmlns="http://www.w3.org/2000/svg"
                                        style="overflow: visible;">
                                        <path
                                            d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z">
                                        </path>
                                        <!-- Círculo agrandado para representar el número de notificaciones -->

                                        <!-- Número de notificaciones -->
                                        @php(
                                        $alertsCount = \Auth::user()->userUserAlerts()->where('read', false)->count())


                                        @if ($alertsCount > 0)
                                            <circle cx="12" cy="4" r="6" fill="#059ed5"
                                                id="circle-notifications"></circle>
                                            <text x="12" y="5" font-size="7" fill="white"
                                                text-anchor="middle" font-weight="bolder"
                                                id="notification-counter">{{ $alertsCount }}</text>
                                        @endif
                                    </svg>
                        </a>
                    </div>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        
                            <li class="nav-item dropdown">
                                
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right alerts-dropdown">
                                    @if (count(
                                            $alerts = \Auth::user()->userUserAlerts()->withPivot('read')->limit(10)->orderBy('created_at', 'ASC')->get()->reverse()) > 0)
                                        @foreach ($alerts as $alert)
                                            <div class="dropdown-item">
                                                <a href="{{ $alert->alert_link ? $alert->alert_link : '#' }}"
                                                    target="_blank" rel="noopener noreferrer">
                                                    @if ($alert->pivot->read === 0)
                                                        <strong>
                                                    @endif
                                                    {{ $alert->alert_text }}
                                                    @if ($alert->pivot->read === 0)
                                                        </strong>
                                                    @endif
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center">
                                            {{ trans('global.no_alerts') }}
                                        </div>
                                    @endif
                                </div>
                            </li>
                            
                            <li class="nav-item  nav-mobile">
                                <a 
                                     
                                    style="line-height:2">
                                    Hola {{ Auth::user()->name }}! 
                                </a>

                                

                                    {{-- <a class="dropdown-item"
                                        href="{{ route('frontend.profile.index') }}">{{ __('My profile') }}</a>FF¿¿

                                    @can('user_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.userManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('permission_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.permissions.index') }}">
                                            {{ trans('cruds.permission.title') }}
                                        </a>
                                    @endcan
                                    @can('role_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.roles.index') }}">
                                            {{ trans('cruds.role.title') }}
                                        </a>
                                    @endcan
                                    @can('user_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.users.index') }}">
                                            {{ trans('cruds.user.title') }}
                                        </a>
                                    @endcan
                                    @can('user_alert_access')
                                        <a class="dropdown-item" href="{{ route('frontend.user-alerts.index') }}">
                                            {{ trans('cruds.userAlert.title') }}
                                        </a>
                                    @endcan
                                    @can('empresas_cliente_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.empresasCliente.title') }}
                                        </a>
                                    @endcan
                                    @can('empresa_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.empresas.index') }}">
                                            {{ trans('cruds.empresa.title') }}
                                        </a>
                                    @endcan
                                    @can('sucursal_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.sucursals.index') }}">
                                            {{ trans('cruds.sucursal.title') }}
                                        </a>
                                    @endcan
                                    @can('proyecto_access')
                                        <a class="dropdown-item" href="{{ route('frontend.proyectos.index') }}">
                                            {{ trans('cruds.proyecto.title') }}
                                        </a>
                                    @endcan
                                    @can('fase_diseno_access')
                                        <a class="dropdown-item" href="{{ route('frontend.fase-disenos.index') }}">
                                            {{ trans('cruds.faseDiseno.title') }}
                                        </a>
                                    @endcan
                                    @can('fasecomercial_access')
                                        <a class="dropdown-item" href="{{ route('frontend.fasecomercials.index') }}">
                                            {{ trans('cruds.fasecomercial.title') }}
                                        </a>
                                    @endcan
                                    @can('fasecontable_access')
                                        <a class="dropdown-item" href="{{ route('frontend.fasecontables.index') }}">
                                            {{ trans('cruds.fasecontable.title') }}
                                        </a>
                                    @endcan
                                    @can('fasedespacho_access')
                                        <a class="dropdown-item" href="{{ route('frontend.fasedespachos.index') }}">
                                            {{ trans('cruds.fasedespacho.title') }}
                                        </a>
                                    @endcan
                                    @can('fasefabrica_access')
                                        <a class="dropdown-item" href="{{ route('frontend.fasefabricas.index') }}">
                                            {{ trans('cruds.fasefabrica.title') }}
                                        </a>
                                    @endcan
                                    @can('fasecomercialproyecto_access')
                                        <a class="dropdown-item" href="{{ route('frontend.fasecomercialproyectos.index') }}">
                                            {{ trans('cruds.fasecomercialproyecto.title') }}
                                        </a>
                                    @endcan
                                    @can('carpetacliente_access')
                                        <a class="dropdown-item" href="{{ route('frontend.carpetaclientes.index') }}">
                                            {{ trans('cruds.carpetacliente.title') }}
                                        </a>
                                    @endcan
                                    @can('ticket_access')
                                        <a class="dropdown-item" href="{{ route('frontend.tickets.index') }}">
                                            {{ trans('cruds.ticket.title') }}
                                        </a>
                                    @endcan
                                    @can('encuestum_access')
                                        <a class="dropdown-item" href="{{ route('frontend.encuesta.index') }}">
                                            {{ trans('cruds.encuestum.title') }}
                                        </a>
                                    @endcan
                                    @can('fase_postventum_access')
                                        <a class="dropdown-item" href="{{ route('frontend.fase-postventa.index') }}">
                                            {{ trans('cruds.fasePostventum.title') }}
                                        </a>
                                    @endcan

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
--}}
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form> 
                                <ul class="sw-25 side-menu mb-0 primary" id="menuSide">
                            <li>
                                <a href="#" data-bs-target="#dashboard" class="active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="acorn-icons acorn-icons-grid-1 icon">
                                        <path
                                            d="M2 3.75001C2 3.04778 2 2.69666 2.16853 2.44443 2.24149 2.33524 2.33524 2.24149 2.44443 2.16853 2.69666 2 3.04778 2.00001 3.75001 2.00001L6.25001 2.00003C6.95224 2.00003 7.30335 2.00004 7.55557 2.16857 7.66476 2.24152 7.75851 2.33528 7.83147 2.44446 8 2.69669 8 3.0478 8 3.75003V6.25C8 6.95223 8 7.30335 7.83147 7.55557 7.75851 7.66476 7.66476 7.75851 7.55557 7.83147 7.30335 8 6.95223 8 6.25 8H3.75C3.04777 8 2.69665 8 2.44443 7.83147 2.33524 7.75851 2.24149 7.66476 2.16853 7.55557 2 7.30335 2 6.95223 2 6.25V3.75001zM12 3.75C12 3.04777 12 2.69665 12.1685 2.44443 12.2415 2.33524 12.3352 2.24149 12.4444 2.16853 12.6967 2 13.0478 2 13.75 2H16.25C16.9522 2 17.3033 2 17.5556 2.16853 17.6648 2.24149 17.7585 2.33524 17.8315 2.44443 18 2.69665 18 3.04777 18 3.75V6.25C18 6.95223 18 7.30335 17.8315 7.55557 17.7585 7.66476 17.6648 7.75851 17.5556 7.83147 17.3033 8 16.9522 8 16.25 8H13.75C13.0478 8 12.6967 8 12.4444 7.83147 12.3352 7.75851 12.2415 7.66476 12.1685 7.55557 12 7.30335 12 6.95223 12 6.25V3.75zM2 13.75C2 13.0478 2 12.6967 2.16853 12.4444 2.24149 12.3352 2.33524 12.2415 2.44443 12.1685 2.69665 12 3.04777 12 3.75 12H6.25C6.95223 12 7.30335 12 7.55557 12.1685 7.66476 12.2415 7.75851 12.3352 7.83147 12.4444 8 12.6967 8 13.0478 8 13.75V16.25C8 16.9522 8 17.3033 7.83147 17.5556 7.75851 17.6648 7.66476 17.7585 7.55557 17.8315 7.30335 18 6.95223 18 6.25 18H3.75C3.04777 18 2.69665 18 2.44443 17.8315 2.33524 17.7585 2.24149 17.6648 2.16853 17.5556 2 17.3033 2 16.9522 2 16.25V13.75zM12 13.75C12 13.0478 12 12.6967 12.1685 12.4444 12.2415 12.3352 12.3352 12.2415 12.4444 12.1685 12.6967 12 13.0478 12 13.75 12H16.25C16.9522 12 17.3033 12 17.5556 12.1685 17.6648 12.2415 17.7585 12.3352 17.8315 12.4444 18 12.6967 18 13.0478 18 13.75V16.25C18 16.9522 18 17.3033 17.8315 17.5556 17.7585 17.6648 17.6648 17.7585 17.5556 17.8315 17.3033 18 16.9522 18 16.25 18H13.75C13.0478 18 12.6967 18 12.4444 17.8315 12.3352 17.7585 12.2415 17.6648 12.1685 17.5556 12 17.3033 12 16.9522 12 16.25V13.75z">
                                        </path>
                                    </svg>
                                    <span class="label">Dashboard</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('frontend.home') }}"
                                            class="{{ request()->is('home') ? 'active' : '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="acorn-icons acorn-icons-navigate-diagonal icon">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 24 24" height="22" width="22"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12.71 2.29a1 1 0 0 0-1.42 0l-9 9a1 1 0 0 0 0 1.42A1 1 0 0 0 3 13h1v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7h1a1 1 0 0 0 1-1 1 1 0 0 0-.29-.71zM6 20v-9.59l6-6 6 6V20z">
                                                    </path>
                                                </svg>
                                                <span class="label">Inicio</span>
                                        </a>
                                    </li>
                                    <li>
                                        @can('ticket_access')
                                            <a href="{{ route('frontend.tickets.index') }}"
                                                class="{{ request()->is('tickets') ? 'active' : '' }}">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 256 256" height="20" width="20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M227.19,104.48A16,16,0,0,0,240,88.81V64a16,16,0,0,0-16-16H32A16,16,0,0,0,16,64V88.81a16,16,0,0,0,12.81,15.67,24,24,0,0,1,0,47A16,16,0,0,0,16,167.19V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V167.19a16,16,0,0,0-12.81-15.67,24,24,0,0,1,0-47ZM32,167.2a40,40,0,0,0,0-78.39V64H88V192H32Zm192,0V192H104V64H224V88.8a40,40,0,0,0,0,78.39Z">
                                                    </path>
                                                </svg>
                                                <span class="label">Solicitudes</span>
                                            </a>
                                        @endcan

                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-bs-target="#services">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="acorn-icons acorn-icons-grid-1 icon">
                                        <path
                                            d="M2 3.75001C2 3.04778 2 2.69666 2.16853 2.44443 2.24149 2.33524 2.33524 2.24149 2.44443 2.16853 2.69666 2 3.04778 2.00001 3.75001 2.00001L6.25001 2.00003C6.95224 2.00003 7.30335 2.00004 7.55557 2.16857 7.66476 2.24152 7.75851 2.33528 7.83147 2.44446 8 2.69669 8 3.0478 8 3.75003V6.25C8 6.95223 8 7.30335 7.83147 7.55557 7.75851 7.66476 7.66476 7.75851 7.55557 7.83147 7.30335 8 6.95223 8 6.25 8H3.75C3.04777 8 2.69665 8 2.44443 7.83147 2.33524 7.75851 2.24149 7.66476 2.16853 7.55557 2 7.30335 2 6.95223 2 6.25V3.75001zM12 3.75C12 3.04777 12 2.69665 12.1685 2.44443 12.2415 2.33524 12.3352 2.24149 12.4444 2.16853 12.6967 2 13.0478 2 13.75 2H16.25C16.9522 2 17.3033 2 17.5556 2.16853 17.6648 2.24149 17.7585 2.33524 17.8315 2.44443 18 2.69665 18 3.04777 18 3.75V6.25C18 6.95223 18 7.30335 17.8315 7.55557 17.7585 7.66476 17.6648 7.75851 17.5556 7.83147 17.3033 8 16.9522 8 16.25 8H13.75C13.0478 8 12.6967 8 12.4444 7.83147 12.3352 7.75851 12.2415 7.66476 12.1685 7.55557 12 7.30335 12 6.95223 12 6.25V3.75zM2 13.75C2 13.0478 2 12.6967 2.16853 12.4444 2.24149 12.3352 2.33524 12.2415 2.44443 12.1685 2.69665 12 3.04777 12 3.75 12H6.25C6.95223 12 7.30335 12 7.55557 12.1685 7.66476 12.2415 7.75851 12.3352 7.83147 12.4444 8 12.6967 8 13.0478 8 13.75V16.25C8 16.9522 8 17.3033 7.83147 17.5556 7.75851 17.6648 7.66476 17.7585 7.55557 17.8315 7.30335 18 6.95223 18 6.25 18H3.75C3.04777 18 2.69665 18 2.44443 17.8315 2.33524 17.7585 2.24149 17.6648 2.16853 17.5556 2 17.3033 2 16.9522 2 16.25V13.75zM12 13.75C12 13.0478 12 12.6967 12.1685 12.4444 12.2415 12.3352 12.3352 12.2415 12.4444 12.1685 12.6967 12 13.0478 12 13.75 12H16.25C16.9522 12 17.3033 12 17.5556 12.1685 17.6648 12.2415 17.7585 12.3352 17.8315 12.4444 18 12.6967 18 13.0478 18 13.75V16.25C18 16.9522 18 17.3033 17.8315 17.5556 17.7585 17.6648 17.6648 17.7585 17.5556 17.8315 17.3033 18 16.9522 18 16.25 18H13.75C13.0478 18 12.6967 18 12.4444 17.8315 12.3352 17.7585 12.2415 17.6648 12.1685 17.5556 12 17.3033 12 16.9522 12 16.25V13.75z">
                                        </path>
                                    </svg>
                                    <span class="label">Proyectos</span>
                                </a>
                                <ul>
                                    <li>
                                        @can('proyecto_access')
                                            <a href="{{ route('frontend.proyectos.index') }}"
                                                class="{{ request()->is('proyectos') ? 'active' : '' }}">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 16 16" height="18" width="18"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z">
                                                    </path>
                                                </svg>
                                                <span class="label">Ver proyectos</span>
                                            </a>
                                        @endcan
                                    </li>
                                    <li>
                                        @can('carpetacliente_access')
                                            <a href="{{ route('frontend.carpetaclientes.index') }}"
                                                class="{{ request()->is('carpetaclientes') ? 'active' : '' }}">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 16 16" height="18" width="18"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z">
                                                    </path>
                                                </svg>
                                                <span class="label">Carpetas</span>
                                            </a>
                                        @endcan
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-bs-target="#account">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="acorn-icons acorn-icons-user icon">
                                        <path
                                            d="M10.0179 8C10.9661 8 11.4402 8 11.8802 7.76629C12.1434 7.62648 12.4736 7.32023 12.6328 7.06826C12.8989 6.64708 12.9256 6.29324 12.9789 5.58557C13.0082 5.19763 13.0071 4.81594 12.9751 4.42106C12.9175 3.70801 12.8887 3.35148 12.6289 2.93726C12.4653 2.67644 12.1305 2.36765 11.8573 2.2256C11.4235 2 10.9533 2 10.0129 2V2C9.03627 2 8.54794 2 8.1082 2.23338C7.82774 2.38223 7.49696 2.6954 7.33302 2.96731C7.07596 3.39365 7.05506 3.77571 7.01326 4.53982C6.99635 4.84898 6.99567 5.15116 7.01092 5.45586C7.04931 6.22283 7.06851 6.60631 7.33198 7.03942C7.4922 7.30281 7.8169 7.61166 8.08797 7.75851C8.53371 8 9.02845 8 10.0179 8V8Z">
                                        </path>
                                        <path
                                            d="M16.5 17.5L16.583 16.6152C16.7267 15.082 16.7986 14.3154 16.2254 13.2504C16.0456 12.9164 15.5292 12.2901 15.2356 12.0499C14.2994 11.2842 13.7598 11.231 12.6805 11.1245C11.9049 11.048 11.0142 11 10 11C8.98584 11 8.09511 11.048 7.31945 11.1245C6.24021 11.231 5.70059 11.2842 4.76443 12.0499C4.47077 12.2901 3.95441 12.9164 3.77462 13.2504C3.20144 14.3154 3.27331 15.082 3.41705 16.6152L3.5 17.5">
                                        </path>
                                    </svg>
                                    <span class="label">Mi cuenta</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('frontend.profile.index') }}"
                                            class="{{ request()->is('frontend/profile') ? 'active' : '' }}">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 1024 1024" height="18" width="18"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M858.5 763.6a374 374 0 0 0-80.6-119.5 375.63 375.63 0 0 0-119.5-80.6c-.4-.2-.8-.3-1.2-.5C719.5 518 760 444.7 760 362c0-137-111-248-248-248S264 225 264 362c0 82.7 40.5 156 102.8 201.1-.4.2-.8.3-1.2.5-44.8 18.9-85 46-119.5 80.6a375.63 375.63 0 0 0-80.6 119.5A371.7 371.7 0 0 0 136 901.8a8 8 0 0 0 8 8.2h60c4.4 0 7.9-3.5 8-7.8 2-77.2 33-149.5 87.8-204.3 56.7-56.7 132-87.9 212.2-87.9s155.5 31.2 212.2 87.9C779 752.7 810 825 812 902.2c.1 4.4 3.6 7.8 8 7.8h60a8 8 0 0 0 8-8.2c-1-47.8-10.9-94.3-29.5-138.2zM512 534c-45.9 0-89.1-17.9-121.6-50.4S340 407.9 340 362c0-45.9 17.9-89.1 50.4-121.6S466.1 190 512 190s89.1 17.9 121.6 50.4S684 316.1 684 362c0 45.9-17.9 89.1-50.4 121.6S557.9 534 512 534z">
                                                </path>
                                            </svg>
                                            <span class="label">Mi perfil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 32 32" height="20" width="20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M 3.6992188 2.3007812 L 2.3007812 3.6992188 L 9.1425781 10.541016 C 9.1296473 10.594288 9.1113631 10.645487 9.0996094 10.699219 L 11 12.5 L 11 12.398438 L 15.601562 17 L 15.5 17 L 17.800781 19.300781 C 17.841141 19.300781 17.881516 19.313812 17.921875 19.320312 L 18.300781 19.699219 L 19.800781 21.199219 L 23.900391 25.298828 C 23.900536 25.299439 23.900245 25.30017 23.900391 25.300781 L 25.699219 27.099609 L 25.701172 27.099609 L 28.300781 29.699219 L 29.699219 28.300781 L 25.556641 24.158203 C 24.687255 21.339567 22.604721 19.027195 19.900391 17.900391 C 21.800391 16.600391 23 14.499609 23 12.099609 C 23 8.1996094 19.9 5.0996094 16 5.0996094 C 13.41738 5.0996094 11.187909 6.4883581 9.9550781 8.5566406 L 3.6992188 2.3007812 z M 16 7 C 18.8 7 21 9.2 21 12 C 21 14.086994 19.776043 15.83791 17.994141 16.595703 L 11.404297 10.005859 C 12.16209 8.2239568 13.913006 7 16 7 z M 9.1992188 13.300781 C 9.5992188 15.200781 10.599219 16.800781 12.199219 17.800781 C 8.4992188 19.300781 6 22.9 6 27 L 8 27 C 8 24.1 9.5007812 21.599219 11.800781 20.199219 C 12.500781 21.799219 14.1 23 16 23 C 16.8 23 17.599219 22.800391 18.199219 22.400391 L 16.699219 20.900391 C 16.499219 21.000391 16.2 21 16 21 C 14.9 21 13.999219 20.300781 13.699219 19.300781 L 14.900391 19 L 9.1992188 13.300781 z">
                                                </path>
                                            </svg>
                                            <span class="label">Cerrar sesión</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> 
        

        


        <main class="py-4 py-4probit">
            @if (session('message'))
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($errors->count() > 0)
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="container">
                <div class="row">
                    <div class="col-auto d-none d-lg-flex">
                        <ul class="sw-25 side-menu mb-0 primary" id="menuSide">
                            <li>
                                <a href="#" data-bs-target="#dashboard" class="active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="acorn-icons acorn-icons-grid-1 icon">
                                        <path
                                            d="M2 3.75001C2 3.04778 2 2.69666 2.16853 2.44443 2.24149 2.33524 2.33524 2.24149 2.44443 2.16853 2.69666 2 3.04778 2.00001 3.75001 2.00001L6.25001 2.00003C6.95224 2.00003 7.30335 2.00004 7.55557 2.16857 7.66476 2.24152 7.75851 2.33528 7.83147 2.44446 8 2.69669 8 3.0478 8 3.75003V6.25C8 6.95223 8 7.30335 7.83147 7.55557 7.75851 7.66476 7.66476 7.75851 7.55557 7.83147 7.30335 8 6.95223 8 6.25 8H3.75C3.04777 8 2.69665 8 2.44443 7.83147 2.33524 7.75851 2.24149 7.66476 2.16853 7.55557 2 7.30335 2 6.95223 2 6.25V3.75001zM12 3.75C12 3.04777 12 2.69665 12.1685 2.44443 12.2415 2.33524 12.3352 2.24149 12.4444 2.16853 12.6967 2 13.0478 2 13.75 2H16.25C16.9522 2 17.3033 2 17.5556 2.16853 17.6648 2.24149 17.7585 2.33524 17.8315 2.44443 18 2.69665 18 3.04777 18 3.75V6.25C18 6.95223 18 7.30335 17.8315 7.55557 17.7585 7.66476 17.6648 7.75851 17.5556 7.83147 17.3033 8 16.9522 8 16.25 8H13.75C13.0478 8 12.6967 8 12.4444 7.83147 12.3352 7.75851 12.2415 7.66476 12.1685 7.55557 12 7.30335 12 6.95223 12 6.25V3.75zM2 13.75C2 13.0478 2 12.6967 2.16853 12.4444 2.24149 12.3352 2.33524 12.2415 2.44443 12.1685 2.69665 12 3.04777 12 3.75 12H6.25C6.95223 12 7.30335 12 7.55557 12.1685 7.66476 12.2415 7.75851 12.3352 7.83147 12.4444 8 12.6967 8 13.0478 8 13.75V16.25C8 16.9522 8 17.3033 7.83147 17.5556 7.75851 17.6648 7.66476 17.7585 7.55557 17.8315 7.30335 18 6.95223 18 6.25 18H3.75C3.04777 18 2.69665 18 2.44443 17.8315 2.33524 17.7585 2.24149 17.6648 2.16853 17.5556 2 17.3033 2 16.9522 2 16.25V13.75zM12 13.75C12 13.0478 12 12.6967 12.1685 12.4444 12.2415 12.3352 12.3352 12.2415 12.4444 12.1685 12.6967 12 13.0478 12 13.75 12H16.25C16.9522 12 17.3033 12 17.5556 12.1685 17.6648 12.2415 17.7585 12.3352 17.8315 12.4444 18 12.6967 18 13.0478 18 13.75V16.25C18 16.9522 18 17.3033 17.8315 17.5556 17.7585 17.6648 17.6648 17.7585 17.5556 17.8315 17.3033 18 16.9522 18 16.25 18H13.75C13.0478 18 12.6967 18 12.4444 17.8315 12.3352 17.7585 12.2415 17.6648 12.1685 17.5556 12 17.3033 12 16.9522 12 16.25V13.75z">
                                        </path>
                                    </svg>
                                    <span class="label">Dashboard</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('frontend.home') }}"
                                            class="{{ request()->is('home') ? 'active' : '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="acorn-icons acorn-icons-navigate-diagonal icon">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 24 24" height="22" width="22"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12.71 2.29a1 1 0 0 0-1.42 0l-9 9a1 1 0 0 0 0 1.42A1 1 0 0 0 3 13h1v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7h1a1 1 0 0 0 1-1 1 1 0 0 0-.29-.71zM6 20v-9.59l6-6 6 6V20z">
                                                    </path>
                                                </svg>
                                                <span class="label">Inicio</span>
                                        </a>
                                    </li>
                                    <li>
                                        @can('ticket_access')
                                            <a href="{{ route('frontend.tickets.index') }}"
                                                class="{{ request()->is('tickets') ? 'active' : '' }}">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 256 256" height="20" width="20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M227.19,104.48A16,16,0,0,0,240,88.81V64a16,16,0,0,0-16-16H32A16,16,0,0,0,16,64V88.81a16,16,0,0,0,12.81,15.67,24,24,0,0,1,0,47A16,16,0,0,0,16,167.19V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V167.19a16,16,0,0,0-12.81-15.67,24,24,0,0,1,0-47ZM32,167.2a40,40,0,0,0,0-78.39V64H88V192H32Zm192,0V192H104V64H224V88.8a40,40,0,0,0,0,78.39Z">
                                                    </path>
                                                </svg>
                                                <span class="label">Solicitudes</span>
                                            </a>
                                        @endcan

                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-bs-target="#services">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="acorn-icons acorn-icons-grid-1 icon">
                                        <path
                                            d="M2 3.75001C2 3.04778 2 2.69666 2.16853 2.44443 2.24149 2.33524 2.33524 2.24149 2.44443 2.16853 2.69666 2 3.04778 2.00001 3.75001 2.00001L6.25001 2.00003C6.95224 2.00003 7.30335 2.00004 7.55557 2.16857 7.66476 2.24152 7.75851 2.33528 7.83147 2.44446 8 2.69669 8 3.0478 8 3.75003V6.25C8 6.95223 8 7.30335 7.83147 7.55557 7.75851 7.66476 7.66476 7.75851 7.55557 7.83147 7.30335 8 6.95223 8 6.25 8H3.75C3.04777 8 2.69665 8 2.44443 7.83147 2.33524 7.75851 2.24149 7.66476 2.16853 7.55557 2 7.30335 2 6.95223 2 6.25V3.75001zM12 3.75C12 3.04777 12 2.69665 12.1685 2.44443 12.2415 2.33524 12.3352 2.24149 12.4444 2.16853 12.6967 2 13.0478 2 13.75 2H16.25C16.9522 2 17.3033 2 17.5556 2.16853 17.6648 2.24149 17.7585 2.33524 17.8315 2.44443 18 2.69665 18 3.04777 18 3.75V6.25C18 6.95223 18 7.30335 17.8315 7.55557 17.7585 7.66476 17.6648 7.75851 17.5556 7.83147 17.3033 8 16.9522 8 16.25 8H13.75C13.0478 8 12.6967 8 12.4444 7.83147 12.3352 7.75851 12.2415 7.66476 12.1685 7.55557 12 7.30335 12 6.95223 12 6.25V3.75zM2 13.75C2 13.0478 2 12.6967 2.16853 12.4444 2.24149 12.3352 2.33524 12.2415 2.44443 12.1685 2.69665 12 3.04777 12 3.75 12H6.25C6.95223 12 7.30335 12 7.55557 12.1685 7.66476 12.2415 7.75851 12.3352 7.83147 12.4444 8 12.6967 8 13.0478 8 13.75V16.25C8 16.9522 8 17.3033 7.83147 17.5556 7.75851 17.6648 7.66476 17.7585 7.55557 17.8315 7.30335 18 6.95223 18 6.25 18H3.75C3.04777 18 2.69665 18 2.44443 17.8315 2.33524 17.7585 2.24149 17.6648 2.16853 17.5556 2 17.3033 2 16.9522 2 16.25V13.75zM12 13.75C12 13.0478 12 12.6967 12.1685 12.4444 12.2415 12.3352 12.3352 12.2415 12.4444 12.1685 12.6967 12 13.0478 12 13.75 12H16.25C16.9522 12 17.3033 12 17.5556 12.1685 17.6648 12.2415 17.7585 12.3352 17.8315 12.4444 18 12.6967 18 13.0478 18 13.75V16.25C18 16.9522 18 17.3033 17.8315 17.5556 17.7585 17.6648 17.6648 17.7585 17.5556 17.8315 17.3033 18 16.9522 18 16.25 18H13.75C13.0478 18 12.6967 18 12.4444 17.8315 12.3352 17.7585 12.2415 17.6648 12.1685 17.5556 12 17.3033 12 16.9522 12 16.25V13.75z">
                                        </path>
                                    </svg>
                                    <span class="label">Proyectos</span>
                                </a>
                                <ul>
                                    <li>
                                        @can('proyecto_access')
                                            <a href="{{ route('frontend.proyectos.index') }}"
                                                class="{{ request()->is('proyectos') ? 'active' : '' }}">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 16 16" height="18" width="18"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z">
                                                    </path>
                                                </svg>
                                                <span class="label">Ver proyectos</span>
                                            </a>
                                        @endcan
                                    </li>
                                    <li>
                                        @can('carpetacliente_access')
                                            <a href="{{ route('frontend.carpetaclientes.index') }}"
                                                class="{{ request()->is('carpetaclientes') ? 'active' : '' }}">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 16 16" height="18" width="18"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z">
                                                    </path>
                                                </svg>
                                                <span class="label">Carpetas</span>
                                            </a>
                                        @endcan
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-bs-target="#account">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="acorn-icons acorn-icons-user icon">
                                        <path
                                            d="M10.0179 8C10.9661 8 11.4402 8 11.8802 7.76629C12.1434 7.62648 12.4736 7.32023 12.6328 7.06826C12.8989 6.64708 12.9256 6.29324 12.9789 5.58557C13.0082 5.19763 13.0071 4.81594 12.9751 4.42106C12.9175 3.70801 12.8887 3.35148 12.6289 2.93726C12.4653 2.67644 12.1305 2.36765 11.8573 2.2256C11.4235 2 10.9533 2 10.0129 2V2C9.03627 2 8.54794 2 8.1082 2.23338C7.82774 2.38223 7.49696 2.6954 7.33302 2.96731C7.07596 3.39365 7.05506 3.77571 7.01326 4.53982C6.99635 4.84898 6.99567 5.15116 7.01092 5.45586C7.04931 6.22283 7.06851 6.60631 7.33198 7.03942C7.4922 7.30281 7.8169 7.61166 8.08797 7.75851C8.53371 8 9.02845 8 10.0179 8V8Z">
                                        </path>
                                        <path
                                            d="M16.5 17.5L16.583 16.6152C16.7267 15.082 16.7986 14.3154 16.2254 13.2504C16.0456 12.9164 15.5292 12.2901 15.2356 12.0499C14.2994 11.2842 13.7598 11.231 12.6805 11.1245C11.9049 11.048 11.0142 11 10 11C8.98584 11 8.09511 11.048 7.31945 11.1245C6.24021 11.231 5.70059 11.2842 4.76443 12.0499C4.47077 12.2901 3.95441 12.9164 3.77462 13.2504C3.20144 14.3154 3.27331 15.082 3.41705 16.6152L3.5 17.5">
                                        </path>
                                    </svg>
                                    <span class="label">Mi cuenta</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('frontend.profile.index') }}"
                                            class="{{ request()->is('frontend/profile') ? 'active' : '' }}">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 1024 1024" height="18" width="18"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M858.5 763.6a374 374 0 0 0-80.6-119.5 375.63 375.63 0 0 0-119.5-80.6c-.4-.2-.8-.3-1.2-.5C719.5 518 760 444.7 760 362c0-137-111-248-248-248S264 225 264 362c0 82.7 40.5 156 102.8 201.1-.4.2-.8.3-1.2.5-44.8 18.9-85 46-119.5 80.6a375.63 375.63 0 0 0-80.6 119.5A371.7 371.7 0 0 0 136 901.8a8 8 0 0 0 8 8.2h60c4.4 0 7.9-3.5 8-7.8 2-77.2 33-149.5 87.8-204.3 56.7-56.7 132-87.9 212.2-87.9s155.5 31.2 212.2 87.9C779 752.7 810 825 812 902.2c.1 4.4 3.6 7.8 8 7.8h60a8 8 0 0 0 8-8.2c-1-47.8-10.9-94.3-29.5-138.2zM512 534c-45.9 0-89.1-17.9-121.6-50.4S340 407.9 340 362c0-45.9 17.9-89.1 50.4-121.6S466.1 190 512 190s89.1 17.9 121.6 50.4S684 316.1 684 362c0 45.9-17.9 89.1-50.4 121.6S557.9 534 512 534z">
                                                </path>
                                            </svg>
                                            <span class="label">Mi perfil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 32 32" height="20" width="20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M 3.6992188 2.3007812 L 2.3007812 3.6992188 L 9.1425781 10.541016 C 9.1296473 10.594288 9.1113631 10.645487 9.0996094 10.699219 L 11 12.5 L 11 12.398438 L 15.601562 17 L 15.5 17 L 17.800781 19.300781 C 17.841141 19.300781 17.881516 19.313812 17.921875 19.320312 L 18.300781 19.699219 L 19.800781 21.199219 L 23.900391 25.298828 C 23.900536 25.299439 23.900245 25.30017 23.900391 25.300781 L 25.699219 27.099609 L 25.701172 27.099609 L 28.300781 29.699219 L 29.699219 28.300781 L 25.556641 24.158203 C 24.687255 21.339567 22.604721 19.027195 19.900391 17.900391 C 21.800391 16.600391 23 14.499609 23 12.099609 C 23 8.1996094 19.9 5.0996094 16 5.0996094 C 13.41738 5.0996094 11.187909 6.4883581 9.9550781 8.5566406 L 3.6992188 2.3007812 z M 16 7 C 18.8 7 21 9.2 21 12 C 21 14.086994 19.776043 15.83791 17.994141 16.595703 L 11.404297 10.005859 C 12.16209 8.2239568 13.913006 7 16 7 z M 9.1992188 13.300781 C 9.5992188 15.200781 10.599219 16.800781 12.199219 17.800781 C 8.4992188 19.300781 6 22.9 6 27 L 8 27 C 8 24.1 9.5007812 21.599219 11.800781 20.199219 C 12.500781 21.799219 14.1 23 16 23 C 16.8 23 17.599219 22.800391 18.199219 22.400391 L 16.699219 20.900391 C 16.499219 21.000391 16.2 21 16 21 C 14.9 21 13.999219 20.300781 13.699219 19.300781 L 14.900391 19 L 9.1992188 13.300781 z">
                                                </path>
                                            </svg>
                                            <span class="label">Cerrar sesión</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                    </div>@yield('content')
                </div>

            </div>


        </main>
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Dashboard</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Proyectos</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Tickets</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Web Ohffice</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Soporte</a></li>
            </ul>
            <p class="text-center text-muted">Portal Clientes Ohffice 1.0 2023</p>
        </footer>
    </div>
</body>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js" integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!--<script src="https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"></script>-->
<script src="{{ asset('js/main.js') }}"></script>
@yield('scripts')





</html>
