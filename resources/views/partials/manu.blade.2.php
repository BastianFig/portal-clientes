<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <img src="{{ asset("storage/logo-ohffice-azul.jpeg" )}}" width="200">
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
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
                <a href="{{ route("admin.user-alerts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-bell c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userAlert.title') }}
                </a>
            </li>
        @endcan
        @can('empresas_cliente_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/empresas*") ? "c-show" : "" }} {{ request()->is("admin/sucursals*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw far fa-building c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.empresasCliente.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('empresa_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.empresas.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/empresas") || request()->is("admin/empresas/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.empresa.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('sucursal_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sucursals.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sucursals") || request()->is("admin/sucursals/*") ? "c-active" : "" }}">
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
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.proyectos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/proyectos") || request()->is("admin/proyectos/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.proyecto.title') }}
                </a>
            </li>
        @endcan
        @can('fase_diseno_access')
           / <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.fase-disenos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/fase-disenos") || request()->is("admin/fase-disenos/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.faseDiseno.title') }}
                </a>
            </li>
        @endcan
        @can('fasecomercial_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.fasecomercials.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/fasecomercials") || request()->is("admin/fasecomercials/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.fasecomercial.title') }}
                </a>
            </li>
        @endcan
        @can('fasecontable_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.fasecontables.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/fasecontables") || request()->is("admin/fasecontables/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.fasecontable.title') }}
                </a>
            </li>
        @endcan
        @can('fasedespacho_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.fasedespachos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/fasedespachos") || request()->is("admin/fasedespachos/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.fasedespacho.title') }}
                </a>
            </li>
        @endcan
        @can('fasefabrica_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.fasefabricas.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/fasefabricas") || request()->is("admin/fasefabricas/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.fasefabrica.title') }}
                </a>
            </li>
        @endcan
        @can('fasecomercialproyecto_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.fasecomercialproyectos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/fasecomercialproyectos") || request()->is("admin/fasecomercialproyectos/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.fasecomercialproyecto.title') }}
                </a>
            </li>
        @endcan
        @can('carpetacliente_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.carpetaclientes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/carpetaclientes") || request()->is("admin/carpetaclientes/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.carpetacliente.title') }}
                </a>
            </li>
        @endcan
        @can('ticket_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.tickets.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tickets") || request()->is("admin/tickets/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.ticket.title') }}
                </a>
            </li>
        @endcan
        @can('encuestum_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.encuesta.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/encuesta") || request()->is("admin/encuesta/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.encuestum.title') }}
                </a>
            </li>
        @endcan
        @can('fase_postventum_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.fase-postventa.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/fase-postventa") || request()->is("admin/fase-postventa/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.fasePostventum.title') }}
                </a>
            </li>
        @endcan
        @php($unread = \App\Models\QaTopic::unreadCount())
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "c-active" : "" }} c-sidebar-nav-link">
                    <i class="c-sidebar-nav-icon fa-fw fa fa-envelope">

                    </i>
                    <span>{{ trans('global.messages') }}</span>
                    @if($unread > 0)
                        <strong>( {{ $unread }} )</strong>
                    @endif

                </a>
            </li>
            @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                @can('profile_password_edit')
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                            <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                            </i>
                            {{ trans('global.change_password') }}
                        </a>
                    </li>
                @endcan
            @endif
            <li class="c-sidebar-nav-item">
                <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
    </ul>

</div>