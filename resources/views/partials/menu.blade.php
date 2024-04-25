<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <img src="{{ asset('storage/logo-ohffice-azul.jpeg') }}" width="200"> 
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.home') }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                Inicio
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.kpis') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/kpis') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">
                    </i>
                    Kpi's
                </a>
            </li>
        @endcan
        @can('user_management_access')
            <li
                class="c-sidebar-nav-dropdown {{ request()->is('admin/permissions*') ? 'c-show' : '' }} {{ request()->is('admin/roles*') ? 'c-show' : '' }} {{ request()->is('admin/users*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.permissions.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.roles.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('user_alert_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.user-alerts.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/user-alerts') || request()->is('admin/user-alerts/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-bell c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userAlert.title') }}
                </a>
            </li>
        @endcan



        
        @can('empresas_cliente_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is('admin/empresas*') ? 'c-show' : '' }} {{ request()->is('admin/sucursals*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw far fa-building c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.empresasCliente.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('empresa_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.empresas.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/empresas') || request()->is('admin/empresas/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.empresa.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('sucursal_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.sucursals.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/sucursals') || request()->is('admin/sucursals/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.sucursal.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('proyecto_access')
    <li class="c-sidebar-nav-dropdown {{ request()->is('admin/empresas*') ? 'c-show' : '' }} {{ request()->is('admin/sucursals*') ? 'c-show' : '' }}">

         <a class="c-sidebar-nav-dropdown-toggle" href="#" >
                    <i class="fa-solid fa-box-archive c-sidebar-nav-icon">
                        {{-- <svg class='' stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z">
                            </path>
                        </svg> --}}
                    </i>
                    {{trans('cruds.proyecto.title')}}
                </a>

        <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.proyectos.index') }}" class="c-sidebar-nav-link {{ request()->is('admin/empresas') || request()->is('admin/empresas/*') ? 'c-active' : '' }}">
                    <i class="fa-solid fa-box-archive c-sidebar-nav-icon"></i>
                    Proyectos
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a href="{{route('admin.fasefabricas.index')}}" class="c-sidebar-nav-link {{ request()->is('admin/empresas') || request()->is('admin/empresas/*') ? 'c-active' : '' }}" >
                    <i class="fa-solid fa-hammer c-sidebar-nav-icon"></i>
                    Fabricacion
                    
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a href="{{route('admin.fasedespachos.index')}}" class="c-sidebar-nav-link {{ request()->is('admin/empresas') || request()->is('admin/empresas/*') ? 'c-active' : '' }}" >
                    <i class="fa-solid fa-box c-sidebar-nav-icon"></i>
                    Despacho
                </a>
            </li>
        </ul>
    </li>
@endcan

        @can('ticket_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.tickets.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/tickets') || request()->is('admin/tickets/*') ? 'c-active' : '' }}">
                    <i class="c-side-bar-nav-icon mr-4">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1.5em"
                            width="1.5em" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5Zm4-1v1h1v-1H4Zm1 3v-1H4v1h1Zm7 0v-1h-1v1h1Zm-1-2h1v-1h-1v1Zm-6 3H4v1h1v-1Zm7 1v-1h-1v1h1Zm-7 1H4v1h1v-1Zm7 1v-1h-1v1h1Zm-8 1v1h1v-1H4Zm7 1h1v-1h-1v1Z">
                            </path>
                        </svg>
                    </i>
                    {{ trans('cruds.ticket.title') }}
                </a>
            </li>
        @endcan
        @can('encuestum_access')
            <li class="c-sidebar-nav-icon">
                <a href="{{ route('admin.encuesta.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/encuesta') || request()->is('admin/encuesta/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.encuestum.title') }}
                </a>
            </li>
        @endcan
        @php($unread = \App\Models\QaTopic::unreadCount())
        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.messenger.index') }}"
                class="{{ request()->is('admin/messenger') || request()->is('admin/messenger/*') ? 'c-active' : '' }} c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fa-fw fa fa-envelope">

                </i>
                <span>{{ trans('global.messages') }}</span>
                @if ($unread > 0)
                    <strong>( {{ $unread }} )</strong>
                @endif

            </a>
        </li>
        @if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}"
                        href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link"
                onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>
</div>
