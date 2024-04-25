@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="row p-4">
                        <div class="col-xl-9">
                            <div class="card mb-4">
                                <div class="card-body p-4">
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="card-title fs-4 fw-semibold">
                                                <h3>PROYECTOS</h3>
                                            </div>
                                        </div>
                                        <div class="col-auto ms-auto">
                                            <a class="btn btn-success" href="{{ route('admin.proyectos.create') }}">
                                                {{ trans('global.add') }} {{ trans('cruds.proyecto.title_singular') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="fw-semibold text-disabled">
                                                <tr class="align-middle">
                                                    <th>Empresa Cliente</th>
                                                    <th>Nombre Proyecto</th>
                                                    <th>Vendedor</th>
                                                    <th>Avance</th>
                                                    <th>Fase Actual</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($proyectos as $item)
                                                    <tr class="align-middle">
                                                        <td class="col-2">
                                                            <div class="avatar avatar-md">
                                                                @if ($item->id_cliente?->getLogoAttribute() == null)
                                                                    <div
                                                                        class="small text-medium-emphasis text-nowrap fw-bold">
                                                                        @foreach ($empresas as $empresa)
                                                                            @if ($empresa->id === $item->id_cliente_id)
                                                                                <h6 class="fw-bold">
                                                                                    {{ $empresa->razon_social }}</h6>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <?php $media = $item->id_cliente->getLogoAttribute();
                                                                    $media->getFullUrl(); ?>
                                                                    <img src="{{ $media->getFullUrl() }}"
                                                                        alt="imagen del proyecto"
                                                                        style="max-width: 80%; height: auto;">
                                                                @endif

                                                            </div>

                                                        </td>
                                                        <td class="col-3 align-middle">
                                                            <div class="text-nowrap">{{ $item->nombre_proyecto }}</div>
                                                        </td>
                                                        <td class="col-2 align-middle">
                                                            @foreach ($item->id_usuarios_clientes as $usuario)
                                                                {{ $usuario->name }}
                                                            @endforeach
                                                        </td>
                                                        <td class="col-3 align-middle">

                                                            <div class="progress progress-thin"> @switch($item->fase)
                                                                    @case('Fase Diseño')
                                                                        <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-danger
                                                    "
                                                                            role="progressbar progress-bar-centered"
                                                                            aria-valuenow="14" aria-valuemin="0" aria-valuemax="100"
                                                                            style="width: 14%">
                                                                            <span class="txt-porcentaje">14%</span>
                                                                        </div>
                                                                    @break

                                                                    @case('Fase Propuesta Comercial')
                                                                        <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-danger
                                                    "
                                                                            role="progressbar progress-bar-centered"
                                                                            aria-valuenow="28" aria-valuemin="0" aria-valuemax="100"
                                                                            style="width: 28%">
                                                                            <span class="txt-porcentaje"> 28% </span>
                                                                        </div>
                                                                    @break

                                                                    @case('Fase Contable')
                                                                        <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-warning
                                                    "
                                                                            role="progressbar progress-bar-centered"
                                                                            aria-valuenow="42" aria-valuemin="0" aria-valuemax="100"
                                                                            style="width: 42%">
                                                                            <span class="txt-porcentaje">42%</span>
                                                                        </div>
                                                                    @break

                                                                    @case('Fase Comercial')
                                                                        <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-warning
                                                    "
                                                                            role="progressbar progress-bar-centered"
                                                                            aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"
                                                                            style="width: 57%">
                                                                            <span class="txt-porcentaje">57%</span>
                                                                        </div>
                                                                    @break

                                                                    @case('Fase Fabricacion')
                                                                        <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-info
                                                    "
                                                                            role="progressbar progress-bar-centered"
                                                                            aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"
                                                                            style="width: 72%">
                                                                            <span class="txt-porcentaje">72%</span>
                                                                        </div>
                                                                    @break

                                                                    @case('Fase Despacho')
                                                                        <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-info
                                                    "
                                                                            role="progressbar progress-bar-centered"
                                                                            aria-valuenow="86" aria-valuemin="0" aria-valuemax="100"
                                                                            style="width: 86%">
                                                                            <span class="txt-porcentaje">86%</span>
                                                                        </div>
                                                                    @break

                                                                    @case('Fase Postventa')
                                                                        <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-success
                                                    "
                                                                            role="progressbar progress-bar-centered"
                                                                            aria-valuenow="100" aria-valuemin="0"
                                                                            aria-valuemax="100" style="width: 100%">
                                                                            <span class="txt-porcentaje">100%</span>
                                                                        </div>
                                                                    @break

                                                                    @default
                                                                @endswitch
                                                                <!--<div class="progress-bar" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">30%</div>-->
                                                            </div>
                                                        </td>
                                                        <td class="col-2 align-middle">
                                                            <div class="fw-semibold text-nowrap">{{ $item->fase }}</div>
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn btn-transparent p-0 dark:text-high-emphasis"
                                                                    type="button" data-coreui-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fa-sharp fa-solid fa-ellipsis-vertical fa-2xl"
                                                                        style="color: #019ed5;"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.proyectos.show', ['proyecto' => $item->id]) }}"><i
                                                                            class="fa-solid fa-pencil fa-xs mr-2"></i>Ver</a>
                                                                    <div class="separator"></div>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.proyectos.massDestroy', ['proyecto' => $item->id]) }}"><i
                                                                            class="fa-solid fa-trash fa-xs mr-2"></i>Eliminar</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- INICIO PAGINACION -->
                                    <div class="pagination">
                                        <ul class="pagination-list">
                                            @if ($proyectos->onFirstPage())
                                                <li class="pagination-item disabled" aria-disabled="true"
                                                    aria-label="@lang('pagination.previous')">
                                                    <span class="pagination-link" aria-hidden="true">&laquo;</span>
                                                </li>
                                            @else
                                                <li class="pagination-item">
                                                    <a href="{{ $proyectos->previousPageUrl() }}" class="pagination-link"
                                                        rel="prev" aria-label="@lang('pagination.previous')">&laquo;</a>
                                                </li>
                                            @endif

                                            <!-- Mostrar los enlaces de paginación -->
                                            @foreach ($proyectos->getUrlRange(1, $proyectos->lastPage()) as $pageNumber => $url)
                                                @if ($pageNumber == $proyectos->currentPage())
                                                    <li class="pagination-item active">
                                                        <span class="pagination-link">{{ $pageNumber }}</span>
                                                    </li>
                                                @else
                                                    <li class="pagination-item">
                                                        <a href="{{ $url }}"
                                                            class="pagination-link">{{ $pageNumber }}</a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            @if ($proyectos->hasMorePages())
                                                <li class="pagination-item">
                                                    <a href="{{ $proyectos->nextPageUrl() }}" class="pagination-link"
                                                        rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
                                                </li>
                                            @else
                                                <li class="pagination-item disabled" aria-disabled="true"
                                                    aria-label="@lang('pagination.next')">
                                                    <span class="pagination-link" aria-hidden="true">&raquo;</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <!-- FIN PAGINACION -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="row">
                                <!-- INICIO PRIMER CUADRO DERECHA -->
                                <div class="col-md-4 col-xl-12">
                                    <div class="card mb-4 text-white bg-primary-gradient">
                                        <div class="card-body p-4 pb-0 text-center">
                                            <div>
                                                <div class="fs-4 fw-normal">Proyectos Totales: <span
                                                        class="fs-4 fw-bold">{{ count($proyectos) }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIN PRIMER CUADRO DERECHA -->

                                <!-- INICIO PRIMER CUADRO DERECHA -->
                                <div class="col-md-4 col-xl-12">
                                    <div class="card mb-4 text-white bg-danger-gradient">
                                        <!--<div class="card-body p-4 pb-0 d-flex justify-content-between align-items-start">-->
                                        <div class="card-body p-4 pb-0 text-center">
                                            <div>
                                                <div class="fs-4 fw-normal">Proyectos Activos: <span
                                                        class="fs-4 fw-bold">{{ $p_activos }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIN PRIMER CUADRO DERECHA -->
                                <div class="col-md-4 col-xl-12">
                                    <div class="card mb-4 text-white bg-success-gradient">
                                        <div class="card-body p-4 pb-0 text-center">
                                            <div>
                                                <div class="fs-4 fw-normal">Proyectos Finalizados: <span
                                                        class="fs-4 fw-bold">{{ $p_finalizados }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="row p-4">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-body p-4">
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="card-title fs-4 fw-semibold">
                                                <h3>SOLICITUDES</h3>
                                            </div>
                                            <div class="row row-cols-1 row-cols-md-12 text-center">
                                                <div class="col-4 mb-sm-4 mb-0">
                                                    <div class="text-medium-emphasis">Total</div>
                                                    <div class="fw-semibold">{{ $tickets }}</div>
                                                    <div class="progress progress-thin mt-2">
                                                        <div class="progress-bar bg-primary-gradient" role="progressbar"
                                                            style="width: 100%" aria-valuenow="80" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="col-4 mb-sm-4 mb-0">
                                                    <div class="text-medium-emphasis">Activos</div>
                                                    <div class="fw-semibold">{{ $t_activos }}</div>
                                                    <div class="progress progress-thin mt-2">
                                                        <div class="progress-bar bg-danger-gradient" role="progressbar"
                                                            style="width: {{ $percent_activos }}%" aria-valuenow="60"
                                                            aria-valuemin="0" aria-valuemax="100">{{ $percent_activos }}%
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 mb-sm-4 mb-0">
                                                    <div class="text-medium-emphasis">Finalizados</div>
                                                    <div class="fw-semibold">{{ $t_finalizados }}</div>
                                                    <div class="progress progress-thin mt-2">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ $percent_finalizados }}%" aria-valuenow="40"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            {{ $percent_finalizados }}%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="row p-4">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-body p-4">
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="card-title fs-4 fw-semibold">
                                                <h3>ENCUESTAS</h3>
                                            </div>
                                            <div class="row row-cols-1 row-cols-md-12 text-center">
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <thead class="fw-semibold text-disabled">
                                                            <tr class="align-middle">
                                                                <th>Proyecto</th>
                                                                <th>Empresa</th>
                                                                <th>Usuario</th>
                                                                <th>Calificación</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($encuesta as $item)
                                                                <tr class="align-middle">
                                                                    <td class="col-2">
                                                                        <div
                                                                            class="small text-medium-emphasis text-nowrap fw-bold">
                                                                            <h6 class="fw-bold">
                                                                                {{ $item->proyecto->nombre_proyecto }}</h6>
                                                                        </div>
                                                                    </td>
                                                                    <td class="col-3 align-middle">
                                                                        <h6 class="fw-bold">
                                                                            {{ $item->empresa->razon_social }}</h6>
                                                                    </td>
                                                                    <td class="col-2 align-middle">
                                                                        <h6 class="fw-bold">{{ $item->nombre_encuestado }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="col-3 align-middle">
                                                                        <div class="rating">
                                                                            @for ($i = 5; $i >= 1; $i--)
                                                                                <input type="radio"
                                                                                    id="star-{{ $item->id }}"
                                                                                    name="rating-{{ $item->id }}"
                                                                                    value="{{ $i }}" disabled
                                                                                    {{ $item->rating == $i ? 'checked' : '' }}>
                                                                                <label for="star{{ $i }}"
                                                                                    class="star"></label>
                                                                            @endfor
                                                                        </div>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <div class="dropdown">
                                                                            <button
                                                                                class="btn btn-transparent p-0 dark:text-high-emphasis"
                                                                                type="button"
                                                                                data-coreui-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-sharp fa-solid fa-ellipsis-vertical fa-2xl"
                                                                                    style="color: #019ed5;"></i>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('admin.encuesta.show', ['encuestum' => $item->id]) }}"><i
                                                                                        class="fa-solid fa-pencil fa-xs mr-2"></i>Ver</a>
                                                                                <div class="separator"></div>
                                                                                <!--<a class="dropdown-item"
                                                                                    href="{{ route('admin.encuesta.massDestroy', ['encuestum' => $item->id]) }}"><i
                                                                                        class="fa-solid fa-trash fa-xs mr-2"></i>Eliminar</a>-->
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- INICIO PAGINACION -->
                                                <div class="pagination">
                                                    <ul class="pagination-list">
                                                        @if ($encuesta->onFirstPage())
                                                            <li class="pagination-item disabled" aria-disabled="true"
                                                                aria-label="@lang('pagination.previous')">
                                                                <span class="pagination-link"
                                                                    aria-hidden="true">&laquo;</span>
                                                            </li>
                                                        @else
                                                            <li class="pagination-item">
                                                                <a href="{{ $encuesta->previousPageUrl() }}"
                                                                    class="pagination-link" rel="prev"
                                                                    aria-label="@lang('pagination.previous')">&laquo;</a>
                                                            </li>
                                                        @endif

                                                        <!-- Mostrar los enlaces de paginación -->
                                                        @foreach ($encuesta->getUrlRange(1, $encuesta->lastPage()) as $pageNumber => $url)
                                                            @if ($pageNumber == $encuesta->currentPage())
                                                                <li class="pagination-item active">
                                                                    <span
                                                                        class="pagination-link">{{ $pageNumber }}</span>
                                                                </li>
                                                            @else
                                                                <li class="pagination-item">
                                                                    <a href="{{ $url }}"
                                                                        class="pagination-link">{{ $pageNumber }}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @if ($encuesta->hasMorePages())
                                                            <li class="pagination-item">
                                                                <a href="{{ $encuesta->nextPageUrl() }}"
                                                                    class="pagination-link" rel="next"
                                                                    aria-label="@lang('pagination.next')">&raquo;</a>
                                                            </li>
                                                        @else
                                                            <li class="pagination-item disabled" aria-disabled="true"
                                                                aria-label="@lang('pagination.next')">
                                                                <span class="pagination-link"
                                                                    aria-hidden="true">&raquo;</span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                                <!-- FIN PAGINACION -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // Obtener todos los elementos dropdown
        const dropdowns = document.querySelectorAll('[data-coreui-toggle="dropdown"]');

        // Agregar evento click a cada elemento dropdown
        dropdowns.forEach((dropdown) => {
            dropdown.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                // Cerrar todos los demás dropdowns abiertos
                closeOtherDropdowns(this);

                // Obtener el menú desplegable asociado al dropdown actual
                const dropdownMenu = this.nextElementSibling;

                // Mostrar u ocultar el menú desplegable
                if (dropdownMenu.style.display === 'block') {
                    dropdownMenu.style.display = 'none';
                } else {
                    dropdownMenu.style.display = 'block';
                }
            });
        });

        // Cerrar todos los demás dropdowns abiertos
        function closeOtherDropdowns(currentDropdown) {
            dropdowns.forEach((dropdown) => {
                if (dropdown !== currentDropdown) {
                    const dropdownMenu = dropdown.nextElementSibling;
                    dropdownMenu.style.display = 'none';
                }
            });
        }

        // Cerrar el menú desplegable al hacer clic en cualquier parte del documento
        document.addEventListener('click', function() {
            dropdowns.forEach((dropdown) => {
                const dropdownMenu = dropdown.nextElementSibling;
                dropdownMenu.style.display = 'none';
            });
        });
    </script>
    @parent
@endsection
