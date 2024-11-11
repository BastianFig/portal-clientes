@extends('layouts.frontend')

@section('content')
    <div class="col col-probit">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container mb-3">
            <div class="row">
                <!-- Title Start -->

                <!-- Title End -->
                <!-- Top Buttons End -->
            </div>
        </div>
        <!-- Title and Top Buttons End -->

        <!-- Stats Start -->
        <div class="mb-5">
            <h2 class="small-title">Estadisticas</h2>
            <div class="row g-2">
                <div class="col-12 col-lg-6 col-xxl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading mb-0 d-flex justify-content-between lh-1-25 mb-3">
                                <span>Proyectos</span>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 32 32"
                                    height="25" width="25" xmlns="http://www.w3.org/2000/svg" class="text-primary">
                                    <path
                                        d="M 4 5 L 4 11 L 5 11 L 5 27 L 27 27 L 27 11 L 28 11 L 28 5 Z M 6 7 L 26 7 L 26 9 L 6 9 Z M 7 11 L 25 11 L 25 25 L 7 25 Z M 12.8125 13 C 12.261719 13.050781 11.855469 13.542969 11.90625 14.09375 C 11.957031 14.644531 12.449219 15.050781 13 15 L 19 15 C 19.359375 15.003906 19.695313 14.816406 19.878906 14.503906 C 20.058594 14.191406 20.058594 13.808594 19.878906 13.496094 C 19.695313 13.183594 19.359375 12.996094 19 13 L 13 13 C 12.96875 13 12.9375 13 12.90625 13 C 12.875 13 12.84375 13 12.8125 13 Z">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-small text-success mb-1">
                            </div>
                            <div class="cta-1 text-primary">{{ $proyectos->count() }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xxl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading mb-0 d-flex justify-content-between lh-1-25 mb-3">
                                <span>Activos</span>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16"
                                    height="25" width="25" xmlns="http://www.w3.org/2000/svg" class="text-primary">
                                    <path fill-rule="evenodd"
                                        d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z">
                                    </path>
                                    <path
                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z">
                                    </path>
                                    <path
                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-small text-success mb-1">
                            </div>
                            <div class="cta-1 text-primary">{{ $activos }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xxl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading mb-0 d-flex justify-content-between lh-1-25 mb-3">
                                <span>Finalizados</span>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16"
                                    height="25" width="25" xmlns="http://www.w3.org/2000/svg" class="text-primary">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path
                                        d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-small text-danger mb-1">
                            </div>
                            <div class="cta-1 text-primary">{{ $finalizados }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xxl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading mb-0 d-flex justify-content-between lh-1-25 mb-3">
                                <span>Solicitudes Activas</span>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 256 256"
                                    height="25" width="25" xmlns="http://www.w3.org/2000/svg" class="text-primary">
                                    <path
                                        d="M227.19,104.48A16,16,0,0,0,240,88.81V64a16,16,0,0,0-16-16H32A16,16,0,0,0,16,64V88.81a16,16,0,0,0,12.81,15.67,24,24,0,0,1,0,47A16,16,0,0,0,16,167.19V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V167.19a16,16,0,0,0-12.81-15.67,24,24,0,0,1,0-47ZM32,167.2a40,40,0,0,0,0-78.39V64H88V192H32Zm192,0V192H104V64H224V88.8a40,40,0,0,0,0,78.39Z">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-small text-success mb-1">
                            </div>
                            <div class="cta-1 text-primary">{{ $solicitudes }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Stats End -->
        <!-- seccion proyectos -->
        <div class="no-mobile">
            <div class="mb-5">
                <h2 class="small-title">Lista de proyectos</h2>
                <div class="os-viewport">
                    <div class="os-content">
                        <!--INICIO Card para proyectos -->
                        @if($resultados > 0)
                            @foreach ($proyectos as $item)
                                <div class="card mb-2 hover-ohffice">
                                    <div class="row g-0 sh-9">
                                        <div class="col-1 align-items-center">
                                            <div
                                                class="sw-9 sh-9 d-inline-block d-flex justify-content-center align-items-center">
                                                <div class="fw-bold text-primary align-content-center">
                                                    @if ($item->id_cliente?->getLogoAttribute() == null)
                                                        <img src="{{ url('/storage/logo-ohffice-azul.jpeg') }}"
                                                            alt="imagen por defecto" style="max-width: 100%; height: auto;">
                                                    @else
                                                        <?php $media = $item->id_cliente->getLogoAttribute();
                                                        $media->getFullUrl(); ?>
                                                        <img src="{{ $media->getFullUrl() }}" alt="imagen del proyecto"
                                                            style="max-width: 100%; height: auto;"
                                                            class="ml-3 img-fluid img-thumbnail">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 no-padding-right">
                                            <div
                                                class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                                <div class="d-flex flex-column">
                                                    <p class="text-alternate"
                                                        style="font-size: .7vw; margin:0 !important; padding:0 !important; ">
                                                        {{ $item->nombre_proyecto }}</p>
                                                    <div class="text-small text-muted"></div>
                                                    <p class="text-small text-muted"
                                                        style=" margin:0 !important; padding:0 !important; ">
                                                        Ejecutivo comercial
                                                        :
                                                        {{ $item->vendedor->name }}</p>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-5">
                                            <div
                                                class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                                <div class="d-flex flex-column  mr-4 pl-0">
                                                    <div class="progress">
                                                        @switch($item->fase)
                                                            @case('Fase Dise���o')
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                        bg-danger
                                                        "
                                                                    role="progressbar progress-bar-centered" aria-valuenow="14"
                                                                    aria-valuemin="0" aria-valuemax="100" style="width: 14%">
                                                                    <span class="txt-porcentaje">14%</span>
                                                                </div>
                                                            @break
    
                                                            @case('Fase Propuesta Comercial')
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                        bg-danger
                                                        "
                                                                    role="progressbar progress-bar-centered" aria-valuenow="28"
                                                                    aria-valuemin="0" aria-valuemax="100" style="width: 28%">
                                                                    <span class="txt-porcentaje"> 28% </span>
                                                                </div>
                                                            @break
    
                                                            @case('Fase Contable')
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                        bg-warning
                                                        "
                                                                    role="progressbar progress-bar-centered" aria-valuenow="42"
                                                                    aria-valuemin="0" aria-valuemax="100" style="width: 42%">
                                                                    <span class="txt-porcentaje">42%</span>
                                                                </div>
                                                            @break
    
                                                            @case('Fase Comercial')
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                        bg-warning
                                                        "
                                                                    role="progressbar progress-bar-centered" aria-valuenow="57"
                                                                    aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                                                                    <span class="txt-porcentaje">57%</span>
                                                                </div>
                                                            @break
    
                                                            @case('Fase Fabricacion')
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                        bg-info
                                                        "
                                                                    role="progressbar progress-bar-centered" aria-valuenow="72"
                                                                    aria-valuemin="0" aria-valuemax="100" style="width: 72%">
                                                                    <span class="txt-porcentaje">72%</span>
                                                                </div>
                                                            @break
    
                                                            @case('Fase Despacho')
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                        bg-info
                                                        "
                                                                    role="progressbar progress-bar-centered" aria-valuenow="86"
                                                                    aria-valuemin="0" aria-valuemax="100" style="width: 86%">
                                                                    <span class="txt-porcentaje">86%</span>
                                                                </div>
                                                            @break
    
                                                            @case('Fase Postventa')
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                        bg-success
                                                        "
                                                                    role="progressbar progress-bar-centered" aria-valuenow="100"
                                                                    aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                                    <span class="txt-porcentaje">100%</span>
                                                                </div>
                                                            @break
    
                                                            @default
                                                        @endswitch
    
                                                    </div>
                                                    <div class="text-small text-muted">Fase actual: {{ $item->fase }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group ps-0 pt-0 pb-0 h-100 .justify-content-center d-flex align-items-center justify-content-center"
                                                style="display:flex">
                                                <a href="{{ url('proyectos/') . '/' . $item->id }}">
                                                    <button class="btn btn-ohffice"
                                                        style="border-radius:10px; max-height:40px; width:100px; margin:15px 5px 5px 5px;"
                                                        type="submit">Ver proyecto</button></a>
                                                @if ($item->fase != 'Fase Dise���o')
                                                    <a href="{{ url('tickets/create') }}?proyecto_id={{ $item->id }}"><button class="btn btn-ohffice"
                                                            style="border-radius:10px; max-height:40px; width:100px; margin:15px 5px 5px 5px;">
                                                            Abrir solicitud</button></a>
                                                            
                                                @endif
                                                @if ($item->fase == 'Fase Postventa')
                                                    @if (empty($item->encuesta_id))
                                                        <a href="{{ url('encuesta/responder/') . '/' . $item->id }}">
    
                                                            <button class="btn btn-ohffice"
                                                                style="border-radius:10px; max-height:40px; width:90px; margin:15px 5px 5px 5px;"
                                                                type="submit">Encuesta</button>
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h4>No se han asignado proyectos.</h4>
                        @endif
                        <!--FIN Card para proyectos -->
                    </div>
                </div>
            </div>

        </div>
        <!-- Fin grilla PC -->
        <div class="mobile">
            <div class="row g-2">
                @foreach ($proyectos as $item)
                <div class="card mb-2 hover-ohffice col-12" onclick="window.location.href='{{ url('proyectos/') . '/' . $item->id }}';">
                    <div class="row g-0 sh-9">
                                    <div class="col-4 align-items-center pl-4">
                                        <div
                                            class="sw-9 sh-9 d-inline-block d-flex justify-content-center align-items-center">
                                            <div class="fw-bold text-primary align-content-center">
                                                @if ($item->id_cliente?->getLogoAttribute() == null)
                                                    <img src="{{ url('/storage/logo-ohffice-azul.jpeg') }}"
                                                        alt="imagen por defecto" style="max-width: 100%; height: auto;">
                                                @else
                                                    <?php $media = $item->id_cliente->getLogoAttribute();
                                                    $media->getFullUrl(); ?>
                                                    <img src="{{ $media->getFullUrl() }}" alt="imagen del proyecto"
                                                        style="max-width: 100%; height: auto;"
                                                        class="ml-3 img-fluid img-thumbnail">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-38 no-padding-right">
                                        <div
                                            class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                            <div class="d-flex flex-column">
                                                <p class="text-alternate"
                                                    style="font-size: 2.5vw; margin:0 !important; padding:0 !important; ">
                                                    {{ $item->nombre_proyecto }}</p>
                                                <div class="text-small text-muted"></div>
                                                <p class="text-small text-muted"
                                                    style=" margin:0 !important; padding:0 !important; ">
                                                    Ejecutivo comercial
                                                    :
                                                    {{ $item->vendedor->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                    </div>
                    <div class="row pt-2 pb-4">
                                        <div class="col-12">
                                        <div
                                            class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                            <div class="d-flex flex-column">
                                                <div class="progress">
                                                    @switch($item->fase)
                                                        @case('Fase Dise���o')
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-danger
                                                    "
                                                                role="progressbar progress-bar-centered" aria-valuenow="14"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 14%">
                                                                <span class="txt-porcentaje">14%</span>
                                                            </div>
                                                        @break

                                                        @case('Fase Propuesta Comercial')
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-danger
                                                    "
                                                                role="progressbar progress-bar-centered" aria-valuenow="28"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 28%">
                                                                <span class="txt-porcentaje"> 28% </span>
                                                            </div>
                                                        @break

                                                        @case('Fase Contable')
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-warning
                                                    "
                                                                role="progressbar progress-bar-centered" aria-valuenow="42"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 42%">
                                                                <span class="txt-porcentaje">42%</span>
                                                            </div>
                                                        @break

                                                        @case('Fase Comercial')
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-warning
                                                    "
                                                                role="progressbar progress-bar-centered" aria-valuenow="57"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                                                                <span class="txt-porcentaje">57%</span>
                                                            </div>
                                                        @break

                                                        @case('Fase Fabricacion')
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-info
                                                    "
                                                                role="progressbar progress-bar-centered" aria-valuenow="72"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 72%">
                                                                <span class="txt-porcentaje">72%</span>
                                                            </div>
                                                        @break

                                                        @case('Fase Despacho')
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-info
                                                    "
                                                                role="progressbar progress-bar-centered" aria-valuenow="86"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 86%">
                                                                <span class="txt-porcentaje">86%</span>
                                                            </div>
                                                        @break

                                                        @case('Fase Postventa')
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-success
                                                    "
                                                                role="progressbar progress-bar-centered" aria-valuenow="100"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                                <span class="txt-porcentaje">100%</span>
                                                            </div>
                                                        @break

                                                        @default
                                                    @endswitch

                                                </div>
                                                <div class="text-small text-muted">Fase actual: {{ $item->fase }}</div>
                                                 @if ($item->fase != 'Fase Dise���o')
                                                    <a href="{{ url('tickets/create') }}?proyecto_id={{ $item->id }}"
                                                        style="margin: 10px 0 ;margin-left:-8px;"
                                                        ><button class="btn btn-ohffice"
                                                            style="border-radius:10px; max-height:40px; width:100px; margin:25px 5px 5px 0px;">
                                                            Abrir solicitud</button></a>
                                                            
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                    </div>
                </div>
                            @endforeach
            </div>
        </div>

    </div>
@endsection
