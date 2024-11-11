@extends('layouts.frontend')
@section('content')
    <style>
         canvas {
            display: block;
            position: relative;
            border: 1px solid;    
        }
        .modal-body {
            background-color: white;
        }

        .ekko-lightbox {
            display: flex !important;
            align-items: center;
            justify-content: center;
            padding-right: 0px !important;
        }

        .ekko-lightbox-container {
            position: relative;
        }

        .ekko-lightbox-container>div.ekko-lightbox-item {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
        }

        .ekko-lightbox iframe {
            width: 100%;
            height: 100%;
        }

        .ekko-lightbox-nav-overlay {
            z-index: 100;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
        }

        .ekko-lightbox-nav-overlay a {
            flex: 1;
            display: flex;
            align-items: center;
            opacity: 0;
            transition: opacity 0.5s;
            color: #fff;
            text-shadow: 2px 2px 2px rgb(18 18 18);
            font-size: 30px;
            z-index: 100;
        }

        .ekko-lightbox-nav-overlay a>* {
            flex-grow: 1;
        }

        .ekko-lightbox-nav-overlay a>*:focus {
            outline: none;
        }

        .ekko-lightbox-nav-overlay a span {
            padding: 0 30px;
        }

        .ekko-lightbox-nav-overlay a:last-child span {
            text-align: right;
        }

        .ekko-lightbox-nav-overlay a:hover {
            text-decoration: none;
        }

        .ekko-lightbox-nav-overlay a:focus {
            outline: none;
        }

        .ekko-lightbox-nav-overlay a.disabled {
            cursor: default;
            visibility: hidden;
        }

        .ekko-lightbox a:hover {
            opacity: 1;
            text-decoration: none;
        }

        .ekko-lightbox .modal-dialog {
            display: none;
        }

        .ekko-lightbox .modal-footer {
            text-align: left;
        }

        .ekko-lightbox-loader {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            display: flex;
            /* establish flex container */
            flex-direction: column;
            /* make main axis vertical */
            justify-content: center;
            /* center items vertically, in this case */
            align-items: center;
        }

        .ekko-lightbox-loader>div {
            width: 40px;
            height: 40px;
            position: relative;
            text-align: center;
        }

        .ekko-lightbox-loader>div>div {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #fff;
            opacity: 0.6;
            position: absolute;
            top: 0;
            left: 0;
            animation: sk-bounce 2s infinite ease-in-out;
        }

        .ekko-lightbox-loader>div>div:last-child {
            animation-delay: -1s;
        }

        .modal-dialog .ekko-lightbox-loader>div>div {
            background-color: #333;
        }

        @-webkit-keyframes sk-bounce {

            0%,
            100% {
                -webkit-transform: scale(0);
            }

            50% {
                -webkit-transform: scale(1);
            }
        }

        @keyframes sk-bounce {

            0%,
            100% {
                transform: scale(0);
                -webkit-transform: scale(0);
            }

            50% {
                transform: scale(1);
                -webkit-transform: scale(1);
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
    <div class="modal fade rounded" id="alertafacturacion" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document"id="mimodal">
            <div class="modal-content modal-facturacion text-white" style="background-color: white;">
                <div class="modal-image">
                    <img src="{{ asset('storage/img/PELIGRO_F.png') }}" alt="imagen equis roja de advertencia" class="" style="max-width: 50%; max-height: auto">
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel" style="font-weight: bold;">No has ingresado la información
                        de
                        facturación</h5>

                </div>

                <div class="modal-footer custon-modal-footer">
                    <button type="button" class="btn btn-primary m-2 btn-datos-modal-proyectos" data-toggle="modal" data-target="#datosfacturacion"style="border-radius: 10px; " id="mostrar-modal">Ingresar
                        datos</button>
                    <button type="button" class="btn btn-secondary btn-close-modal-proyectos" data-dismiss="modal"style="border-radius: 10px;">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade modal-datos-facturacion" id="datosfacturacion" tabindex="-1" role="dialog" aria- labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-ohffice rounded" role="document" style="min-width: 90vw !important; min-height: 60vh !important">
            <div class="modal-content">
                <div class="row">
                    <div class="modal-header col-12">
                        <h5 class="fs-6" id="demoModalLabel" style="font-size: clamp(18px, 1.7vw, 2vw); font-weight: bold;">Ingresa tu Información
                            de facturación</h5>
                    </div>
                </div>
                <input type="hidden" name="rzn_empresa" id="rzn_empresa" value="{{$empresa->razon_social}}">
                <input type="hidden" name="rut_empresa" id="rut_empresa" value="{{$empresa->rut}}">
                <input type="hidden" name="direc_empresa" id="direc_empresa" value="{{$empresa->direccion}}">
                <input type="hidden" name="comu_empresa" id="comu_empresa" value="{{$empresa->comuna}}">
                <input type="hidden" name="region_empresa" id="region_empresa" value="{{$empresa->region}}">
                <div class="modal-body-custom p-5">
                    <form class="form-horizontal" action="{{ route('frontend.proyectos.storeFacturacion') }}" method="post">
                        <input type="hidden" name="id_proyecto" value="{{ $proyecto->id }}">
                        @csrf
                        <!-- Text input-->
                        <div class="row">
                            <div class="form-group col-md-6 pl-4 pr-4 pt-1 pb-1">
                                <label class="control-label required" for="Razon_social">Razon social</label>
                                <input id="razon_social" name="razon_social" type="text" placeholder="Razon social" class="form-control input-md input-custom"style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                            </div>


                            <!-- Text input-->
                            @csrf
                            <div class="form-group col-md-6 pl-4 pr-4 pt-1 pb-1"">
                                <label class="required" for="rut">{{ trans('cruds.empresa.fields.rut') }}</label>
                                <input class="form-control input-custom {{ $errors->has('rut') ? 'is-invalid' : '' }}" type="text" name="rut" id="rut" placeholder="Rut" value="{{ old('rut', '') }}" required style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                @if ($errors->has('rut'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('rut') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.empresa.fields.rut_helper') }}</span>
                            </div>
                        </div>


                        <!-- Text input-->
                        <div class="row">
                            <div class="form-group col-md-6 pl-4 pr-4 pt-1 pb-1"">
                                <label class="required" for="giro">Giro</label>
                                <input id="giro" name="giro" type="text" placeholder="Giro" class="form-control input-md input-custom" required="" style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                            </div>

                            <!-- Text input-->
                            <div class="form-group col-md-6 pl-4 pr-4 pt-1 pb-1"">
                                <label class="required" for="direcccicon">Dirección</label>
                                <input id="direccion" name="direccion" type="text" placeholder="Direccion" class="form-control input-md input-custom" style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="row">
                            <div class="form-group col-md-6 pl-4 pr-4 pt-1 pb-1"">
                                <label for="email" class="required">Email</label>
                                <input id="email" name="email" type="text" placeholder="Email" class="form-control input-md input-custom" required="" style="border: none; background-color: #f8f8f8; border-radius: 10px;">


                            </div>

                            <!-- Text input-->
                            <div class="form-group col-md-6 pl-4 pr-4 pt-1 pb-1"">
                                <label for="nombre_contacto" class="required">Nombre de contacto</label>

                                <input id="nombre_contacto" name="nombre_contacto" type="text" placeholder="Nombre de contacto" class="form-control input-md input-custom" required="" style="border: none; background-color: #f8f8f8; border-radius: 10px;">


                            </div>
                            <div class="form-group col-md-6 pl-4 pr-4 pt-1 pb-1"">
                                <label for="direccion_despacho" class="required">Dirección de despacho</label>

                                <input id="direccion_despacho" name="direccion_despacho" type="text" placeholder="Dirección de despacho" class="form-control input-md input-custom" required="" style="border: none; background-color: #f8f8f8; border-radius: 10px;">


                            </div>
                            <div class="form-group col-md-6 pl-4 pr-4 pt-1 pb-1"">
                                <label for="direccion_despacho" class="required">Quien recibe</label>

                                <input id="nombre_despacho" name="nombre_despacho" type="text" placeholder="Nombre de quien recibe" class="form-control input-md input-custom" required="" style="border: none; background-color: #f8f8f8; border-radius: 10px;">


                            </div>
                            <div class="form-group col-md-6 pl-4 pr-4 pt-1 pb-1"">
                                <label for="direccion_despacho" class="required">Teléfono de contacto</label>

                                <input id="telefono_despacho" name="telefono_despacho" type="text" placeholder="Teléfono de contacto" class="form-control input-md input-custom" required="" style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 pl-4 pr-4 pt-1 pb-1"">
                                <label for="comentario" class="required">Comentario</label>

                                <textarea id="comentario" name="comentario" placeholder="Comentario" class="form-control input-md input-custom" required="" style="border: none; background-color: #f8f8f8; border-radius: 10px;"  rows="3"></textarea>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="row p-4">
                            <div class="col-lg-10 col-md-6 col-sm-6">

                                <button id="singlebutton" name="singlebutton" class="btn btn-primary btn-datos-modal-proyectos"style="border-radius: 10px; margin-right:auto;">Guardar</button>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-6">
                                <button type="button" class="btn btn-secondary btn-close-modal-proyectos" data-dismiss="modal"style="border-radius: 10px;" id="mostrar-modal2">Cerrar</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="success-modal"></div>
    <div class="col">
        <div class="row">
            <div class="col-xl-8 col-xs-12">
                <div class="card mb-5">
                    <div class="card-body card-carrousel">
                        <h3 class="card-title mb-5">Estado del proyecto</h3>
                        <div class="overflow-hidden carrousel-desktop">
                            <ul class="c-process mb-lg-5 w-100">
                                {{-- <li class="c-process__item2" id="fase_prev" style="display: none;">
                                    <a class="carousel-control-prev" href="#myCarousel" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </a>
                                </li> --}}
                                <li class="c-process__item active" id="fase_1">
                                    <span class="circle-number h4">1</span>
                                    <div class="div_pasos1">Diseño</div>
                                </li>
                                <li class="c-process__item" id="fase_2">
                                    <span class="circle-number h4">2</span>
                                    <div class="div_pasos2">Propuesta Comercial</div>
                                </li>{{-- 
                                <li class="c-process__item" id="fase_3">
                                    <span class="circle-number h4">3</span>
                                    <div class="div_pasos3">Contable</div>
                                </li> --}}
                                <li class="c-process__item" id="fase_4">
                                    <span class="circle-number h4">3</span>
                                    <div class="div_pasos2">Acuerdo Comercial</div>
                                </li>
                                <li class="c-process__item" id="fase_5">
                                    <span class="circle-number h4">4</span>
                                    <div class="div_pasos5">Fabricación</div>
                                </li>
                                <li class="c-process__item" id="fase_6">
                                    <span class="circle-number h4">5</span>
                                    <div class="div_pasos6">Despachos</div>
                                </li>
                                <li class="c-process__item" id="fase_7">
                                    <span class="circle-number h4">6</span>
                                    <div class="div_pasos7">Postventa</div>
                                </li>{{-- 
                                <li class="c-process__item2" id="fase_next">
                                    <a class="carousel-control-next" href="#myCarousel" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="carrousel-mobile">
                            <div class="container-item-carrousel-mobile">
                                <button id="btn-prev-mobile">
                                    < </button>
                            </div>
                            <div class="container-item-carrousel-mobile">
                                <ul>
                                    <li id="fase-list-1" class="mobile-inactive">Diseño</li>
                                    <li id="fase-list-2" class="mobile-inactive">Propuesta comercial</li>
                                    {{-- 
                                    <li id="fase-list-3" class="mobile-inactive" style="display: none;">Contable</li> --}}
                                    <li id="fase-list-4" class="mobile-inactive">Comercial</li>
                                    <li id="fase-list-5" class="mobile-inactive">Fabricación</li>
                                    <li id="fase-list-6" class="mobile-inactive">Despachos</li>
                                    <li id="fase-list-7" class="mobile-inactive">Postventa</li>
                                </ul>
                            </div>
                            <div class="container-item-carrousel-mobile">
                                <button id="btn-next-mobile">></button>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
                                <div class="d-flex flex-column">
                                    <div class="progress">
                                        @switch($proyecto->fase)
                                            @case('Fase Diseño')
                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-danger
                                                    " role="progressbar progress-bar-centered" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100" style="width: 14%">
                                                    <span class="txt-porcentaje">14%</span>
                                                </div>
                                            @break

                                            @case('Fase Propuesta Comercial')
                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-danger
                                                    " role="progressbar progress-bar-centered" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100" style="width: 28%">
                                                    <span class="txt-porcentaje"> 28% </span>
                                                </div>
                                            @break

                                            @case('Fase Contable')
                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-warning
                                                    " role="progressbar progress-bar-centered" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100" style="width: 42%">
                                                    <span class="txt-porcentaje">42%</span>
                                                </div>
                                            @break

                                            @case('Fase Comercial')
                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-warning
                                                    " role="progressbar progress-bar-centered" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                                                    <span class="txt-porcentaje">57%</span>
                                                </div>
                                            @break

                                            @case('Fase Fabricacion')
                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-info
                                                    " role="progressbar progress-bar-centered" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100" style="width: 72%">
                                                    <span class="txt-porcentaje">72%</span>
                                                </div>
                                            @break

                                            @case('Fase Despacho')
                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-info
                                                    " role="progressbar progress-bar-centered" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100" style="width: 86%">
                                                    <span class="txt-porcentaje">86%</span>
                                                </div>
                                            @break

                                            @case('Fase Postventa')
                                                <div class="progress-bar progress-bar-striped progress-bar-animated
                                                    bg-success
                                                    " role="progressbar progress-bar-centered" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                    <span class="txt-porcentaje">100%</span>
                                                </div>
                                            @break

                                            @default
                                        @endswitch

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="show-tables">

                            <table class="table" id="slide_fase_1">
                                <thead style="border: none;">
                                    <tr class="tabla-personalizada">
                                        <th>Item</th>
                                        <th>Información</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="tabla-personalizada" data-entry-id="{{ $proyecto->id }}">

                                        <td style="font-weight: bold;">Descripción</td>
                                        <td>{{ $proyecto->fasediseno->descripcion ?? 'Sin descripción...' }}</td>
                                    </tr>
                                    <tr class="tabla-personalizada">

                                        <td style="font-weight: bold;">Imagenes</td>
                                        <td>
                                            @if ($proyecto->fasediseno)
                                                @php
                                                    $imagenes = $proyecto->fasediseno->imagenes;
                                                @endphp

                                                @if ($imagenes->isEmpty())
                                                    No hay imágenes
                                                @else
                                                    @php $i = 0; @endphp

                                                    @foreach ($imagenes as $imagen)
                                                        @php $i++; @endphp
                                                        <a href="{{ $imagen->getFullUrl() }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" data-toggle="lightbox" data-gallery="diseno-galery">
                                                            Ver imagen {{ $i }}
                                                        </a>
                                                    @endforeach
                                                @endif
                                            @else
                                                No hay imágenes disponibles
                                            @endif
                                        </td>

                                    </tr>
                                    <tr class="tabla-personalizada">
                                        <td style="font-weight: bold;">Propuesta</td>
                                        <td>
                                            @if ($proyecto->fasediseno)
                                                @php
                                                    $propuesta = $proyecto->fasediseno->getPropuestaAttribute();
                                                @endphp

                                                @if ($propuesta === null)
                                                    No Documento Cargado.
                                                @else
                                                    @php $i = 0; @endphp

                                                    @foreach ($propuesta as $documento)
                                                        @php $i++; @endphp
                                                        <a href="{{ $documento->getFullUrl() }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                            Ver Documento {{ $i }}
                                                        </a>
                                                    @endforeach
                                                @endif
                                            @endif
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                            <table class="table" id="slide_fase_2">
                                <thead style="border: none;">
                                    <tr class="tabla-personalizada">
                                        <th>Nombre</th>
                                        <th>Información</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="tabla-personalizada" data-entry-id="{{ $proyecto->id }}">

                                        <td style="font-weight: bold;">Comentarios</td>
                                        <td>{{ $proyecto->fasecomercial->comentarios ?? 'Sin comentarios...' }}</td>
                                    </tr>
                                    <tr class="tabla-personalizada">

                                        <td style="font-weight: bold;">Cotización</td>
                                        <td>
                                            @if ($proyecto->fasecomercial)
                                                @php
                                                    $cotizacion = $proyecto->fasecomercial->cotizacion;
                                                    $ultimaCotizacion = $cotizacion->last(); // Obtener la última cotización
                                                @endphp
                                                @if ($ultimaCotizacion)
                                                    <a href="{{ $ultimaCotizacion->getUrl() }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                        Ver última cotización
                                                    </a>
                                                @else
                                                    No hay cotización disponible
                                                @endif
                                            @else
                                                No hay cotización disponible
                                            @endif

                                        </td>
                                    </tr>
                                    <tr class="tabla-personalizada">
                                        <td style="font-weight: bold;">Orden de compra</td>
                                        <td>
                                            @if ($proyecto->fasecomercial)
                                                @php
                                                    $oc = $proyecto->fasecomercial->oc;
                                                @endphp
                                                @if ($oc)
                                                    <a href="{{ $oc->getFullUrl() }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                        Ver última orden de compra
                                                    </a>
                                                @else
                                                    No hay orden de compra
                                                @endif
                                            @endif
                                        <td>
                                    </tr>
                                </tbody>
                            </table>
                            <table btn-personalizadole class="table" id="slide_fase_3">
                                <thead style="border: none;">
                                    <tr class="tabla-personalizada">
                                        <th>Nombre</th>
                                        <th>Información</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                        <tr class="tabla-personalizada" data-entry-id="{{ $proyecto->id }}">
                                            <td style="font-weight: bold;">Anticipo 50%</td>
                                            <td>
                                                @if ($proyecto->fasecontable)
                                                @php
                                                    $anticipo50  = $proyecto->fasecontable->anticipo_50;
                                                    $fullUrl = []; // Inicializar $fullUrl como un array vacío
                                                    $i = 0;
                                                    if ($anticipo50) {
                                                        foreach ($anticipo50 as $mediaItem) {
                                                            // Obtener la URL completa del elemento de media actual
                                                            $fullUrl[] = $mediaItem->getUrl();
                                                        }
                                                    }
                                                @endphp
                                                @if ($anticipo50)
                                                    @if($fullUrl)
                                                        @foreach($fullUrl as $item)
                                                            @php
                                                                $i=$i+1;
                                                            @endphp
                                                            <a href="{{ $item }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                                Ver Pago {{$i}}
                                                            </a>
                                                        @endforeach
                                                    @else
                                                        No hay Pago disponible
                                                    @endif
                                                @else
                                                    No hay Pago disponible
                                                @endif
                                            @else
                                                No hay Pago disponible
                                            @endif
                                            </td>
                                        </tr>
                                        <tr class="tabla-personalizada">
    
                                            <td style="font-weight: bold;">Comentario</td>
                                            <td>{{ $proyecto->fasecontable->comentario ?? 'Sin comentarios...' }}</td>
                                        </tr>
                                        <tr class="tabla-personalizada">
                                            <td style="font-weight: bold;">Anticipo 40%</td>
                                            <td>
                                                @if ($proyecto->fasecontable)
                                                    @php
                                                        $anticipo40 = $proyecto->fasecontable->anticipo40;
                                                    @endphp
                                                    @if ($anticipo40)
                                                        <a href="{{ $anticipo40->getFullUrl() }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                            Ver anticipo
                                                        </a>
                                                    @endif
                                                @else
                                                    No hay anticipo del 40%
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="tabla-personalizada">
                                            <td style="font-weight: bold;">Pago 10%</td>
                                            <td>
                                                @if ($proyecto->fasecontable)
                                                    @php
                                                        $anticipo10 = $proyecto->fasecontable->anticipo10;
                                                    @endphp
                                                    @if ($anticipo10)
                                                        <a href="{{ $anticipo10->getFullUrl() }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                            Ver anticipo
                                                        </a>
                                                    @endif
                                                @else
                                                    No hay anticipo del 10%
                                                @endif
                                            </td>
                                        </tr>
                                        
                                </tbody>
                            </table>
                            <table class="table" id="slide_fase_4">
                                <thead style="border: none;">
                                    <tr class="tabla-personalizada">
                                        <th>Nombre</th>
                                        <th>Información</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="tabla-personalizada">

                                        <td style="font-weight: bold;">Nota de venta</td>
                                        <td>
                                            @if ($proyecto->fasecomercialproyecto)
                                                @php
                                                    $notaVenta = $proyecto->fasecomercialproyecto->nota_venta;
                                                @endphp
                                                @if ($notaVenta)
                                                    <a href="{{ $notaVenta->getFullUrl() }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                        Ver Nota de Venta
                                                    </a>
                                                @endif
                                            @else
                                                No hay Nota de Venta disponible
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="tabla-personalizada">

                                        <td style="font-weight: bold;">Fecha de entrega</td>
                                        <td>
                                            @if ($proyecto->fasecomercialproyecto)
                                                {{$proyecto->fasecomercialproyecto->fecha_despacho}}

                                            @else
                                                No hay fecha de entrega disponible
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="tabla-personalizada">
                                        <td style="font-weight: bold;">Factura</td>
                                        <td>
                                            @if ($proyecto->fasecomercialproyecto)
                                                @php
                                                    $facturas  = $proyecto->fasecomercialproyecto->facturas;
                                                    $fullUrl = []; // Inicializar $fullUrl como un array vacío
                                                    $i = 0;
                                                    if ($facturas) {
                                                        foreach ($facturas as $mediaItem) {
                                                            // Obtener la URL completa del elemento de media actual
                                                            $fullUrl[] = $mediaItem->getUrl();
                                                        }
                                                    }
                                                @endphp
                                                @if ($facturas)
                                                    @if($fullUrl)
                                                        @foreach($fullUrl as $item)
                                                            @php
                                                                $i=$i+1;
                                                            @endphp
                                                            <a href="{{ $item }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                                Ver Factura {{$i}}
                                                            </a>
                                                        @endforeach
                                                    @else
                                                        No hay Facturas disponible
                                                    @endif
                                                @else
                                                    No hay Facturas disponible
                                                @endif
                                            @else
                                                No hay Facturas disponible
                                            @endif
                                                
                                        </td>
                                    </tr>
                                    <tr class="tabla-personalizada">
                                        <td style="font-weight: bold;">Notas de Crédito/Débito</td>
                                        <td>
                                            @if ($proyecto->fasecomercialproyecto)
                                                @php
                                                    $credito = $proyecto->fasecomercialproyecto->credito;
                                                @endphp
                                                @if ($credito)
                                                    <a href="{{ $credito->getFullUrl() }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                        Ver Nota de Crédito/Débito
                                                    </a>
                                                @endif
                                            @else
                                                No hay Nota de Crédito/Débito disponible
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="tabla-personalizada">
                                        <td style="font-weight: bold;">Acepta Conforme</td>
                                        <td>
                                            <script>
                                                $(function () {
                                                    var wrapper = document.getElementById("signature-pad"),
                                                        clearButton = wrapper.querySelector("[data-action=clear]"),
                                                        saveButton = document.getElementById("guarda_firma-pad"),
                                                        canvas = wrapper.querySelector("canvas"),
                                                        signaturePad;

                                                        signaturePad = new SignaturePad(canvas);

                                                        clearButton.addEventListener("click", function(event) {
                                                            signaturePad.clear();
                                                        });


                                                        $('#guarda_firma').on('click',function(event){
                                                            //event.preventDefault();

                                                            if (signaturePad.isEmpty()) {
                                                            alert("Please provide a signature first.");
                                                            } else {
                                                            var dataUrl = signaturePad.toDataURL();
                                                            var image_data = $("#signature-pad").val();
                                                            //alert(dataUrl);
                                                            var acepta = $("#acepto_conforme").val();
                                                            var token = $("input[name='_token']").val();
                                                            var id_fasecomercialproyectos = $("input[name='id_faseacuerdocomercial']").val();
                                                            $.ajax({
                                                                url: '{{route('frontend.proyectos.aceptaConforme')}}',
                                                                type: 'POST',
                                                                headers: {
                                                                    'X-CSRF-TOKEN': token
                                                                },
                                                                data: {
                                                                    dataUrl: dataUrl, acepta: acepta, id_fasecomercialproyectos: id_fasecomercialproyectos,
                                                                },
                                                            }).done(function(response) {
                                                                alert('Se han aceptado las condiciones del acuerdo comercial.');
                                                                location.reload();
                                                            });
                                                            }
                                                        });
                                                    });
                                            </script>
                                            @if($proyecto->fasecomercialproyecto != NULL)
                                                @if($proyecto->fasecomercialproyecto->firma != NULL && $proyecto->fasecomercialproyecto->acepta == "Si")
                                                    <h4 class="font-weight-bold">Ya has aceptado las condiciones del Acuerdo Comercial </h4>
<<<<<<< HEAD
                                                    <img src="{{$proyecto->fasecomercialproyecto->firma}}" width="100%" height="auto">
=======
                                                    <img src="{{$proyecto->fasecomercialproyecto->firma}}" width="100%"
                                                    height="auto">
>>>>>>> f8b8892aa497a248de78c3b8d9d63f4ffdcf8d99
                                                @else
                                                    <form method="POST" enctype="multipart/form-data" >
                                                        @method('POST')
                                                        @csrf
                                                        <input type="checkbox" name="acepto_conforme" id="acepto_conforme" value="Si" required>
                                                        <input type="hidden" name="id_faseacuerdocomercial" value="{{$proyecto->id_fasecomercialproyectos}}" required>
                                                        {{-- <div id="signature-pad" class="signature-pad">
                                                            <canvas id="signature-pad" width="400" height="200"></canvas>
                                                        </div>
                                                        <button class="btn btn-primary" id="save-btn-acepta">Guardar Firma</button>
                                                        <input type="hidden" id="signature-img" name="signature_img"> --}}
                                                        <h4 class="font-weight-bold">Firma en el siguiente recuadro</h4>
                                                        <div id="signature-pad" class="m-signature-pad container-firma">
                                                            <div class="m-signature-pad--body container-firma ">
                                                            <canvas style="border: 2px dashed #ccc" class="canvas"></canvas>
                                                            </div>
                                                        
                                                            <div class="m-signature-pad--footer">
                                                            <button type="button" class="btn btn-sm btn-danger" data-action="clear">Limpiar</button>
                                                            <button type="button" class="btn btn-sm btn-primary" data-action="save" name="guarda_firma" id="guarda_firma">Guardar Firma</button>
                                                            </div>
                                                        </div>
                                                    </form>    
                                                @endif    
                                            @else
                                                
                                                <form method="POST" enctype="multipart/form-data" >
                                                    @method('POST')
                                                    @csrf
                                                    <input type="checkbox" name="acepto_conforme" id="acepto_conforme" value="Si" required>
                                                    <input type="hidden" name="id_faseacuerdocomercial" value="{{$proyecto->id_fasecomercialproyectos}}" required>
                                                    {{-- <div id="signature-pad" class="signature-pad">
                                                        <canvas id="signature-pad" width="400" height="200"></canvas>
                                                    </div>
                                                    <button class="btn btn-primary" id="save-btn-acepta">Guardar Firma</button>
                                                    <input type="hidden" id="signature-img" name="signature_img"> --}}
                                                    <h4 class="font-weight-bold">Firma en el siguiente recuadro</h4>
                                                    <div id="signature-pad" class="m-signature-pad container-firma">
                                                        <div class="m-signature-pad--body container-firma">
                                                        <canvas style="border: 2px dashed #ccc;" class="canvas" ></canvas>
                                                        </div>
                                                    
                                                        <div class="m-signature-pad--footer">
                                                        <button type="button" class="btn btn-sm btn-danger" data-action="clear">Limpiar</button>
                                                        <button type="button" class="btn btn-sm btn-primary" data-action="save" name="guarda_firma" id="guarda_firma">Guardar Firma</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            @endif                                                         
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table" id="slide_fase_5">

                                <tr class="tabla-personalizada">
                                    <td style="font-weight: bold;">Estado de preparación</td>
                                    <td>
                                        <div class="card-body-custom">

                                            <div class="card-body "style="border-radius: 16px;">
                                                    <div class="row g-0">
                                                        <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                                            <div class="w-100 d-flex sh-1 position-relative justify-content-center">
                                                                <div class="line-w-1 bg-separator h-100 position-absolute">
                                                                </div>
                                                            </div>
                                                            <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                                                <div class="bg-gradient-light sw-1 sh-1 rounded-xl position-relative" id="bg-gradient-light-ingenieria">
                                                                </div>
                                                            </div>
                                                            <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                                                <div class="line-w-1 bg-separator h-100 position-absolute">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                            <div class="col mb-4">
                                                                <div class="h-100">
                                                                    <div class="d-flex flex-column justify-content-start">
                                                                        <div class="d-flex flex-column">
                                                                            <p href="#" class="fabricacion-custom" id="fase-ingenieria">
                                                                                Diseño</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>        
                                                    </div>
                                                    <div class="row g-0">
                                                        <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                                            <div class="w-100 d-flex sh-1 position-relative justify-content-center">
                                                                <div class="line-w-1 bg-separator h-100 position-absolute">
                                                                </div>
                                                            </div>
                                                            <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                                                <div class="bg-gradient-light sw-1 sh-1 rounded-xl position-relative" id="bg-gradient-light-dimensionado">
                                                                </div>
                                                            </div>
                                                            <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                                                <div class="line-w-1 bg-separator h-100 position-absolute">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col mb-4">
                                                            <div class="h-100">
                                                                <div class="d-flex flex-column justify-content-start">
                                                                    <div class="d-flex flex-column">
                                                                        <p href="#" class="fabricacion-custom" id="fase-dimension">
                                                                            Producción</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-0">
                                                        <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                                            <div class="w-100 d-flex sh-1 position-relative justify-content-center">
                                                                <div class="line-w-1 bg-separator h-100 position-absolute">
                                                                </div>
                                                            </div>
                                                            <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                                                <div class="bg-gradient-light sw-1 sh-1 rounded-xl position-relative" id="bg-gradient-light-limpieza">
                                                                </div>
                                                            </div>
                                                            <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="h-100">
                                                                <div class="d-flex flex-column justify-content-start">
                                                                    <div class="d-flex flex-column">
                                                                        <p href="#" class="fabricacion-custom" id="fase-limpieza">
                                                                            Limpieza/Embalaje</p>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table" id="slide_fase_6">
                                <thead style="border: none;">
                                    <tr class="tabla-personalizada">
                                        <th>Nombre</th>
                                        <th>Información</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="tabla-personalizada" data-entry-id="{{ $proyecto->id }}">

                                        <td style="font-weight: bold;">Guia despacho</td>
                                        <td>
                                            @if ($proyecto->fasedespacho)
                                                @php
                                                    $guiaDespacho  = $proyecto->fasedespacho->guia_despacho;
                                                    $fullUrl = []; // Inicializar $fullUrl como un array vacío
                                                    $i = 0;
                                                    if ($guiaDespacho) {
                                                        foreach ($guiaDespacho as $mediaItem) {
                                                            // Obtener la URL completa del elemento de media actual
                                                            $fullUrl[] = $mediaItem->getUrl();
                                                        }
                                                    }
                                                @endphp
                                                @if ($guiaDespacho)
                                                    @if($fullUrl)
                                                        @foreach($fullUrl as $item)
                                                            @php
                                                                $i=$i+1;
                                                            @endphp
                                                            <a href="{{ $item }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                                Ver guia de despacho {{$i}}
                                                            </a>
                                                        @endforeach
                                                    @else
                                                        No hay guia de despacho disponible
                                                    @endif
                                                @else
                                                    No hay guia de despacho disponible
                                                @endif
                                            @else
                                                No hay guia de despacho disponible
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="tabla-personalizada">

                                        <td style="font-weight: bold;">Fecha despacho</td>
                                        <td>{{ $proyecto->fasedespacho->fecha_despacho ?? 'Sin fase de despacho' }}</td>
                                    </tr>
                                    <tr class="tabla-personalizada">
                                        <td style="font-weight: bold;">Horario de despacho</td>
                                        <td>
                                            @if($proyecto->fasedespacho != NULL)
                                                <form style="width: 100%;height: 100%;display:flex;" action="{{route('frontend.proyectos.confirmarHorario')}}" method="POST" enctype="multipart/form-data" id="form-confirmar-horario">
                                                    @method('POST')
                                                    @csrf
                                                    <input type="hidden" value="{{$proyecto->id_fasedespachos}}" name="idproyecto">
                                                    <input type="hidden" name="confirma_horario" id="confirma_horario">

                                                    @if($proyecto->fasedespacho->confirma_horario == "Si")
                                                        @if($proyecto->fasedespacho->horario == 'AM')
                                                            <select class="form-control {{ $errors->has('horarioDespacho') ? 'is-invalid' : '' }}" name="horarioDespacho" id="horarioDespacho" style="max-width: 40%;" disabled>
                                                                <option value="AM" selected>AM</option>
                                                            </select>
                                                        @endif
                                                        @if($proyecto->fasedespacho->horario == 'PM')
                                                            <select class="form-control {{ $errors->has('horarioDespacho') ? 'is-invalid' : '' }}" name="horarioDespacho" id="horarioDespacho" style="max-width: 40%;" disabled>
                                                                <option value="PM" selected>PM</option> 
                                                            </select>
                                                        @endif
                                                    @else
                                                        @if($proyecto->fasedespacho->horario == NULL)
                                                            <select class="form-control {{ $errors->has('horarioDespacho') ? 'is-invalid' : '' }}" name="horarioDespacho" id="horarioDespacho" style="max-width: 40%;">
                                                                <option value disabled selected>{{ trans('global.pleaseSelect') }}</option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option> 
                                                            </select>
                                                            <input class="btn btn-success btn-personalizado" style="border-radius: 10px;max-width:40%;color:white;" value="Confirmar selección" type="submit"/>
                                                        @endif
                                                        @if($proyecto->fasedespacho->horario == 'AM')
                                                            <select class="form-control {{ $errors->has('horarioDespacho') ? 'is-invalid' : '' }}" name="horarioDespacho" id="horarioDespacho" style="max-width: 40%;">
                                                                <option value disabled>{{ trans('global.pleaseSelect') }}</option>
                                                                <option value="AM" selected>AM</option>
                                                                <option value="PM">PM</option> 
                                                            </select>
                                                            <input class="btn btn-success btn-personalizado" style="border-radius: 10px;max-width:40%;color:white;" value="Confirmar selección" type="submit"/>
                                                        @endif
                                                        @if($proyecto->fasedespacho->horario == 'PM')
                                                            <select class="form-control {{ $errors->has('horarioDespacho') ? 'is-invalid' : '' }}" name="horarioDespacho" id="horarioDespacho" style="max-width: 40%;">
                                                                <option value disabled>{{ trans('global.pleaseSelect') }}</option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM" selected>PM</option> 
                                                            </select>
                                                            <input class="btn btn-success btn-personalizado" style="border-radius: 10px;max-width:40%;color:white;" value="Confirmar selección" type="submit"/>
                                                        @endif
                                                    @endif                                           
                                                </form>
                                            @else
                                                No hay horario de Despacho
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="tabla-personalizada">
                                        <td style="font-weight: bold;">Estado instalación</td>
                                        <td>{{ $proyecto->fasedespacho->estado_instalacion ?? 'Sin estado de instalación' }}
                                        </td>
                                    </tr>
                                    <tr class="tabla-personalizada">
                                        <td style="font-weight: bold;">Comentario</td>
                                        <td>
                                            @if ($proyecto->fasedespacho)
                                                @php

                                                    $comentarioHTML = $proyecto->fasedespacho->comentario;
                                                @endphp
                                                {{ strip_tags($comentarioHTML) }}
                                            @else
                                                Sin comentarios
                                            @endif
                                        <td>
                                    </tr>
                                    <tr class="tabla-personalizada">
                                        <td style="font-weight: bold;">Recibe conforme</td>
                                        <td>{{ $proyecto->fasedespacho->recibe_conforme ?? 'Sin información' }}
                                        <td>
                                    </tr>

                                </tbody>
                            </table>
                            <table class="table" id="slide_fase_7">
                                <thead style="border: none;">
                                    <tr class="tabla-personalizada">
                                        <th>Nombre</th>
                                        <th>Información</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="tabla-persolizada">
                                        <td style="font-weight: bold;">Estado</td>
                                        <td>{{ $proyecto->fasepostventa->estado ?? 'Sin estado' }}</td>
                                    </tr>
                                    <tr>
                                        @if ($proyecto->fasepostventa)
                                        <td style="font-weight: bold;">Encuesta de satisfacción</td>
                                        <td>
                                            @if($proyecto->encuesta_id != NULL)
                                                <h4 class="font-weight-bold">Encuesta Respondida</h4>
                                            @else
                                                <a href="{{ url('encuesta/responder/') . '/' .$proyecto->id}}" class="btn btn-success btn-personalizado" style="border-radius: 10px;">Responder Encuesta</a>
                                            @endif
                                        </td>
                                        
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- CUADRO DE INFORMACION CONTABLE-->
                <div class="card mb-5">
                    <div class="card-body"style="border-radius: 10px;">
                        <div class="row">
                            <h3 class="card-title">Información contable</h3>

                            <div class="form-group col-12">
                                <table class="table">
                                    <tbody>
                                        @php
                                        error_log($proyecto);    
                                        if ($proyecto->fasecomercial==NULL){
                                            $monto=0;
                                        }
                                        else{
                                            $monto = $proyecto->fasecomercial->monto;
                                        }
                                        
                                        @endphp
                                             
                                        @if($proyecto->id_cliente->antiguedad_empresa == 'Nuevo')
                                            <tr class="tabla-personalizada">
                                                <th>Monto Total del Proyecto</th>
                                                <td>
                                                    @if ($proyecto->fasecomercial)
                                                        @if( $monto != NULL)
                                                            <h4 class="font-weight-bold">$ {{number_format( $monto, 0, ',', '.')}} </h4>
                                                        @else
                                                            <p class="text-danger">Monto No Disponible</p>
                                                        @endif
                                                    @else
                                                        <p class="text-danger">Monto No Disponible</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="tabla-personalizada">
                                                @if ($monto != NULL)
                                                    <th>Abono 50% : ${{number_format(($monto*0.5), 0, ',', '.')}}</th>
                                                @else
                                                    <th>Abono 50%</th>
                                                @endif
                                                <td>
                                                    @if ($proyecto->fasecontable)
                                                        @php
                                                            $anticipo50  = $proyecto->fasecontable->anticipo_50;
                                                            $fullUrl = []; // Inicializar $fullUrl como un array vacío
                                                            $i = 0;
                                                            if ($anticipo50) {
                                                                foreach ($anticipo50 as $mediaItem) {
                                                                    // Obtener la URL completa del elemento de media actual
                                                                    $fullUrl[] = $mediaItem->getUrl();
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($anticipo50)
                                                            @if($fullUrl)
                                                                @foreach($fullUrl as $item)
                                                                    @php
                                                                        $i=$i+1;
                                                                    @endphp
                                                                    <a href="{{ $item }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                                        Ver Pago {{$i}}
                                                                    </a>
                                                                @endforeach
                                                            @else
                                                                No hay Pago disponible
                                                            @endif
                                                        @else
                                                            No hay Pago disponible
                                                        @endif
                                                    @else
                                                        No hay Pago disponible
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="tabla-personalizada">
                                                @if ($monto != NULL)
                                                    <th>Abono 40% : ${{number_format(($monto*0.4), 0, ',', '.')}}</th>
                                                @else
                                                    <th>Abono 40%</th>
                                                @endif
                                                <td>
                                                    @if ($proyecto->fasecomercialproyecto)
                                                        @if ($proyecto->fasecontable->anticipo40)
                                                            <a href="{{ $proyecto->fasecontable->anticipo40->getFullUrl() }}" class="btn btn-success btn-personalizado" target="_blank">Ver pago</a>
                                                        @else
                                                            <p class=" text-danger text-start">Comprobante de pago pendiente</p>
                                                        @endif
                                                    @else
                                                        <p class="text-success">Pago en siguentes fases</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="tabla-personalizada">
                                                @if ($monto != NULL)
                                                    <th>Abono 10% : ${{number_format(($monto*0.1), 0, ',', '.')}}</th>
                                                @else
                                                    <th>Abono 10%</th>
                                                @endif
                                                <td>
                                                    @if ($proyecto->fasefabrica)
                                                        @if ($proyecto->fasecontable->anticipo10)
                                                            <a href="{{ $proyecto->fasecontable->anticipo10->getFullUrl() }}" class="btn btn-success btn-personalizado" target="_blank">Ver pago</a>
                                                        @else
                                                            <p class=" text-danger text-start">Comprobante de pago pendiente</p>
                                                        @endif
                                                    @else
                                                        <p class="text-success">Pago en siguentes fases</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                        
                                        @if($proyecto->id_cliente->antiguedad_empresa == 'Confiable')
                                            <tr class="tabla-personalizada">
                                                <th>Monto Total del Proyecto</th>
                                                <td>
                                                    @if ($proyecto->fasecomercial)
                                                        @if( $monto != NULL)
                                                            <h4 class="font-weight-bold">$ {{number_format( $monto, 0, ',', '.')}} </h4>
                                                        @else
                                                            <p class="text-danger">Monto No Disponible</p>
                                                        @endif
                                                    @else
                                                        <p class="text-danger">Monto No Disponible</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="tabla-personalizada">
                                                @if ($monto != NULL)
                                                    <th>Abono 50% : ${{number_format(($monto*0.5), 0, ',', '.')}}</th>
                                                @else
                                                    <th>Abono 50%</th>
                                                @endif
                                                <td>  
                                                    @if ($proyecto->fasecontable)
                                                        @php
                                                            $anticipo50  = $proyecto->fasecontable->anticipo_50;
                                                            $fullUrl = []; // Inicializar $fullUrl como un array vacío
                                                            $i = 0;
                                                            if ($anticipo50) {
                                                                foreach ($anticipo50 as $mediaItem) {
                                                                    // Obtener la URL completa del elemento de media actual
                                                                    $fullUrl[] = $mediaItem->getUrl();
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($anticipo50)
                                                            @if($fullUrl)
                                                                @foreach($fullUrl as $item)
                                                                    @php
                                                                        $i=$i+1;
                                                                    @endphp
                                                                    <a href="{{ $item }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                                        Ver Pago
                                                                    </a>
                                                                @endforeach
                                                            @else
                                                                No hay Pago disponible
                                                            @endif
                                                        @else
                                                            No hay Pago disponible
                                                        @endif
                                                    @else
                                                        No hay Pago disponible
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="tabla-personalizada">
                                                @if ($monto != NULL)
                                                    <th>Pago 50% : ${{number_format(($monto*0.5), 0, ',', '.')}}</th>
                                                @else
                                                    <th>Pago 50%</th>
                                                @endif
                                                <td>
                                                    @if ($proyecto->fasecomercialproyecto)
                                                        @if ($proyecto->fasecontable->anticipo40)
                                                            <a href="{{ $proyecto->fasecontable->anticipo40->getFullUrl() }}" class="btn btn-success btn-personalizado" target="_blank">Ver pago</a>
                                                        @else
                                                            <p class=" text-danger text-start">Comprobante de pago pendiente</p>
                                                        @endif
                                                    @else
                                                        <p class="text-success">Pago en siguentes fases</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        
                                        @endif
                                        
                                        @if($proyecto->id_cliente->antiguedad_empresa == 'Especial')
                                            <tr class="tabla-personalizada">
                                                <th>Monto Total del Proyecto</th>
                                                <td>
                                                    @if ($proyecto->fasecomercial)
                                                        @if( $monto != NULL)
                                                            <h4 class="font-weight-bold">$ {{number_format( $monto, 0, ',', '.')}} </h4>
                                                        @else
                                                            <p class="text-danger">Monto No Disponible</p>
                                                        @endif
                                                    @else
                                                        <p class="text-danger">Monto No Disponible</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="tabla-personalizada">
                                                @if ($monto != NULL)
                                                    <th>Pago : ${{number_format(($monto), 0, ',', '.')}}</th>
                                                @else
                                                    <th>Pago</th>
                                                @endif
                                                <td>
                                                    
                                                @if ($proyecto->fasecontable)
                                                @php
                                                    $anticipo50  = $proyecto->fasecontable->anticipo_50;
                                                    $fullUrl = []; // Inicializar $fullUrl como un array vacío
                                                    $i = 0;
                                                    if ($anticipo50) {
                                                        foreach ($anticipo50 as $mediaItem) {
                                                            // Obtener la URL completa del elemento de media actual
                                                            $fullUrl[] = $mediaItem->getUrl();
                                                        }
                                                    }
                                                @endphp
                                                @if ($anticipo50)
                                                    @if($fullUrl)
                                                        @foreach($fullUrl as $item)
                                                            @php
                                                                $i=$i+1;
                                                            @endphp
                                                            <a href="{{ $item }}" class="btn btn-success btn-personalizado" style="border-radius: 10px;" target="_blank">
                                                                Ver Pago {{$i}}
                                                            </a>
                                                        @endforeach
                                                    @else
                                                        No hay Pago disponible
                                                    @endif
                                                @else
                                                    No hay Pago disponible
                                                @endif
                                            @else
                                                No hay Pago disponible
                                            @endif
                                                </td>
                                            </tr>
                                        @endif
                                        @if($proyecto->id_cliente->antiguedad_empresa == NULL)
                                            <h4>La Empresa no posee antigüedad, no es posible ver la información contable.</h4>
                                        @endif
                                       
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row justify-content-center ">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="border:none;">
                                <h3>Información del proyecto</h3>
                            </div>
 <input type="hidden" id="estado_proyecto" name="estado_proyecto" value="{{ App\Models\Proyecto::ESTADO_SELECT[$proyecto->estado] ?? '' }}">
 <input type="hidden" id="fase_proyecto" name="fase_proyecto" value="{{ App\Models\Proyecto::FASE_SELECT[$proyecto->fase] ?? '' }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <table class="table">
                                        <tbody style="overflow: hidden !important">
                                            <tr class="tabla-personalizada">
                                                <th>
                                                    {{ trans('cruds.proyecto.fields.id_cliente') }}
                                                </th>
                                                <td style="overflow: hidden !important">

                                                    @if ($proyecto->id_cliente?->getLogoAttribute() == null)
                                                        {{ $proyecto->id_cliente->nombe_de_fantasia ?? '' }}
                                                    @else
                                                        <?php $media = $proyecto->id_cliente->getLogoAttribute();
                                                        $media->getFullUrl(); ?>
                                                        <img src="{{ $media->getFullUrl() }}" alt="imagen del proyecto" class="img-thumbnail img-fluid" style="max-width: 100% ; width: 200px;">
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="tabla-personalizada">
                                                <th>
                                                    {{ trans('cruds.proyecto.fields.id_usuarios_cliente') }}
                                                </th>
                                                <td>
                                                    @foreach ($proyecto->id_usuarios_clientes as $key => $id_usuarios_cliente)
                                                        <span class="label label-info">{{ $id_usuarios_cliente->name }}</span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr class="tabla-personalizada">
                                                <th>
                                                    {{ trans('cruds.proyecto.fields.sucursal') }}
                                                </th>
                                                <td>
                                                    {{ $proyecto->sucursal->nombre ?? '' }}
                                                </td>
                                            </tr>
                                            <tr class="tabla-personalizada" style="border-bottom: 2px solid #f1f1f1">
                                                <th>
                                                    {{ trans('cruds.proyecto.fields.nombre_proyecto') }}
                                                </th>
                                                <td>
                                                    {{ $proyecto->nombre_proyecto }}
                                                </td>
                                            </tr>
                                            <tr class="tabla-personalizada">
                                                <th>
                                                    {{ trans('cruds.proyecto.fields.tipo_proyecto') }}
                                                </th>
                                                <td>
                                                    {{ App\Models\Proyecto::TIPO_PROYECTO_SELECT[$proyecto->tipo_proyecto] ?? '' }}
                                                </td>
                                            {{-- </tr>
                                            <tr class="tabla-personalizada">
                                                <th>
                                                    {{ trans('cruds.proyecto.fields.estado') }}
                                                </th>
                                                <td>
                                                    {{ App\Models\Proyecto::ESTADO_SELECT[$proyecto->estado] ?? '' }}
                                                   
                                                </td>
                                            </tr> --}}
                                            <tr class="tabla-personalizada">
                                                <th style="border-bottom: 2px solid #f1f1f1 !important;">
                                                    {{ trans('cruds.proyecto.fields.fase') }}
                                                </th>
                                                <td>
                                                    {{ App\Models\Proyecto::FASE_SELECT[$proyecto->fase] ?? '' }}
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <a class="btn btn-default" href="{{ route('frontend.proyectos.index') }}" style="border-radius: 10px;">
                                            Volver al listado
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-xs-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <p class="card-title h3">Imagen del proyecto</p>
                        @if($proyecto->fasediseno !== null)
                        @if ($proyecto->fasediseno->getImagenesAttribute()->isEmpty())
                            <img src="{{ url('/storage/no-imagen-proyecto.png') }}" alt="imagen por defecto" style="filter: grayscale(100%);" class="img-thumbnail img-fluid">
                        @else
                            <?php $media = $proyecto->fasediseno->getImagenesAttribute()->first(); ?>
                            <img src="{{ $media->getFullUrl() }}" alt="imagen del proyecto" style="max-width: 100%; height: auto;" class="img-thumbnail img-fluid">
                        @endif
                        @endif
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <p class="card-title h3">Carpeta de proyecto</p>
                        <table class=" table table-hover">
                            <tbody>
                                @if($proyecto->carpetacliente)
                                    @if ($proyecto->carpetacliente->presupuesto?->original_url ?? '')
                                        <tr>
                                            <th>Presupuesto</th>
                                            <th class="text-center">
                                                <a href="{{ $proyecto->carpetacliente->presupuesto->original_url ?? '' }}" target="_blank">
                                                    <button type="button" class="btn btn-outline-primary">Ver</button></a>
                                            </th>
                                        </tr>
                                    @else
                                    @endif
                                    @if ($proyecto->carpetacliente?->plano ?? '')
                                        @foreach ($proyecto->carpetacliente->plano as $key => $media)
                                            <tr>
                                                <th>Plano</th>
                                                <th class="text-center">
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        <button type="button" class="btn btn-outline-primary">Ver</button></a>
                                                    </a>
    
                                                </th>
                                            </tr>
                                        @endforeach
                                    @else
                                    @endif
                                    @if ($proyecto->carpetacliente->fftt ?? '')
                                        @foreach ($proyecto->carpetacliente->fftt as $key => $media)
                                            <tr>
                                                <th>FFTT</th>
                                                <th class="text-center">
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        <button type="button" class="btn btn-outline-primary">Ver</button></a>
                                                    </a>
    
                                                </th>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if ($proyecto->carpetacliente->presentacion ?? '')
                                        @foreach ($proyecto->carpetacliente->presentacion as $key => $media)
                                            <tr>
                                                <th>Presentación</th>
                                                <th class="text-center">
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        <button type="button" class="btn btn-outline-primary">Ver</button></a>
                                                    </a>
                                                </th>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if (!empty($proyecto) && !empty($proyecto->carpetacliente) && !empty($proyecto->carpetacliente->rectificacion))
                                        <tr>
                                            <th>Rectificación</th>
                                            <th class="text-center">
                                                <a href="{{ $proyecto->carpetacliente->rectificacion->getUrl() }}" target="_blank">
                                                    <button type="button" class="btn btn-outline-primary">Ver</button>
                                                </a>
                                            </th>
                                        </tr>
                                    @endif
                                @else
                                    No hay carpeta disponible
                                @endif
                                    
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mt-4" id="card-facturacion">
                    <div class="card-body">
                        <p class="card-title h3">Información de facturación</p>
                        <table class="table table-hover">
                            @if (!empty($proyecto->facturacion_id))
                                <tbody>
                                    <tr>
                                        <th>Rut:</th>
                                        <th>{{ $proyecto->facturacion->rut }}</th>
                                    </tr>
                                    <tr>
                                        <th>Razon social</th>
                                        <th>{{ $proyecto->facturacion->razon_social }}</th>
                                    </tr>
                                    <tr>
                                        <th>Dirección</th>
                                        <th>{{ $proyecto->facturacion->direccion }}</th>
                                    </tr>
                                    <tr>
                                        <th>Correo</th>
                                        <th>{{ $proyecto->facturacion->email }}</th>
                                    </tr>
                                    <tr>
                                        <th>Giro</th>
                                        <th>{{ $proyecto->facturacion->giro }}</th>
                                    </tr>
                                    <tr>
                                        <th>Contacto</th>
                                        <th>{{ $proyecto->facturacion->nombre_contacto }}</th>
                                    </tr>
                                    <tr>
                                        <th>Comentarios</th>
                                        <th>{{ $proyecto->facturacion->comentario}}</th>
                                    </tr>
                                </tbody>
                            @else
                                <tbody style="display: flex; align-items: center; justify-content: center; width:100%;">
                                    <div style="display: flex; align-items: center; justify-content: center; width:100%;">
                                        <img src="{{ asset('storage/img/PELIGRO_F.png') }}" alt="sin informacion" style="max-width: 60%; height: auto;" class="">
                                    </div>
                                </tbody>
                            @endif
                        </table>

                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <p class="card-title h3">Información de Personal Asignado</p>
                        <table class="table table-hover">
                            @if (!empty($proyecto))
                                <tbody>
                                    <tr>
                                        <th>Ejecutivo Comercial:</th>
                                        <th>{{$vendedor->name}}</th>
                                    </tr>
                                    <tr>
                                        <th>Teléfono:</th>
                                        <th><a href="tel:{{$vendedor->telefono}}">{{$vendedor->telefono}}</a></th>
                                        
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <th><a href="mailto:{{$vendedor->email}}">{{$vendedor->email}}</a></th>
                                        
                                    </tr>
                                    <tr>
                                        <th>Diseñador:</th>
                                        @if($proyecto->disenador == NULL || $proyecto->disenador == "")
                                            <th>No Seleccionado</th>
                                        @else
                                            <th>{{$proyecto->disenador}}</th>
                                        @endif
                                        
                                    </tr>
                                    {{--<tr>
                                        <th>Instalador:</th>
                                        @if($proyecto->instalador == NULL || $proyecto->instalador == "")
                                            <th>No Seleccionado</th>
                                        @else
                                            <th>{{$proyecto->instalador}}</th>
                                        @endif
                                    </tr>--}}
                                    
                                </tbody>
                            @else
                                <tbody style="display: flex; align-items: center; justify-content: center; width:100%;">
                                    <div style="display: flex; align-items: center; justify-content: center; width:100%;">
                                        <img src="{{ asset('storage/img/PELIGRO_F.png') }}" alt="sin informacion" style="max-width: 60%; height: auto;" class="">
                                    </div>
                                </tbody>
                            @endif
                        </table>

                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <p class="card-title h3">Información de Despacho</p>
                        <table class="table table-hover">
                            @if (!empty($proyecto->id_fasedespachos))
                                <tbody>
                                    <tr>
                                        <th>Tipo de Despacho:</th>
                                        <th>{{$proyecto->fasedespacho->total_parcial}}</th>
                                    </tr>
                                    <tr>
                                        <th>Lotes:</th>
                                        <th>{{$proyecto->fasedespacho->lotes}}</th>
                                    </tr>
                                    <tr>
                                        <th>Fecha de Despacho:</th>
                                        <th>{{$proyecto->fasedespacho->fecha_despacho}}</th>
                                    </tr>
                                     <tr>
                                        <th>Horario de Despacho:</th>
                                        <th>{{$proyecto->fasedespacho->horario}}</th>
                                    </tr>
                                    <tr>
                                        <th>Empresa Transporte:</th>
                                        @if ($proyecto->fasedespacho==null)
                                            <th>No disponible</th>
                                        @else
                                                <th>{{$proyecto->fasedespacho->empresa_transporte}}</th>
                                        @endif
                                        
                                        
                                    </tr>
                                    <tr>
                                        <th>Nombre del Conductor:</th>
                                        <th>{{$proyecto->fasedespacho->nombre_conductor}}</th>
                                    </tr>
                                    <tr>
                                        <th>Número de Celular del Conductor:</th>
                                        <th>{{$proyecto->fasedespacho->celular_conductor}}</th>
                                    </tr>
                                    <tr>
                                        <th>Nombre de los Acompañantes:</th>
                                        <th>{{$proyecto->fasedespacho->nombre_acompañantes}}</th>
                                    </tr>
                                    
                                </tbody>
                            @else
                                <tbody style="display: flex; align-items: center; justify-content: center; width:100%;">
                                    <div style="display: flex; align-items: center; justify-content: center; width:100%;">
                                        <img src="{{ asset('storage/img/PELIGRO_F.png') }}" alt="sin informacion" style="max-width: 60%; height: auto;" class="">
                                    </div>
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (!empty($proyecto->facturacion))
        <input type="hidden" id="facturacion_id" name="facturacion_id" value="{{ $proyecto->facturacion_id }}">
    @else
        <input type="hidden" id="facturacion_id" name="facturacion_id" value="0">
    @endif
@endsection


@section('scripts')
    <script>

        $("#form-confirmar-horario").submit(function(event) {
            $("#confirma_horario").val("Si");
        });

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: false,
            });
        });
        const raz_emp = $('#rzn_empresa').val();
        const rut_emp = $('#rut_empresa').val();
        const direc_emp = $('#direc_empresa').val();
        const comuna_emp = $('#comu_empresa').val();
        const region_emp = $('#region_empresa').val();
        
        $('#razon_social').val(raz_emp);
        $('#rut').val(rut_emp);
        $('#direccion').val(direc_emp + ', '+comuna_emp+', '+region_emp);
        $('#direccion_despacho').val(direc_emp + ', '+comuna_emp+', '+region_emp);
        
        const miModal = document.getElementById('mimodal');
        let modalState = true;
        const btnModal = document.getElementById('mostrar-modal').addEventListener('click', () => {
            $('#mimodal').hide();
        });
        const btnModal2 = document.getElementById('mostrar-modal2').addEventListener('click', () => {
            $('#mimodal').show();
        })
        var facturacion = $('#facturacion_id').val();
        var estado_proyecto = $('#estado_proyecto').val();
        var fase_proyecto = $('#fase_proyecto').val();
        $('#card-facturacion').hide();
        if ((facturacion == 0 && estado_proyecto == 'Negocio Ganado' && fase_proyecto == 'Fase Comercial') || (facturacion == 0 && estado_proyecto == 'Negocio Ganado' && fase_proyecto == 'Fase Fabricacion') || (facturacion == 0 && estado_proyecto == 'Negocio Ganado' && fase_proyecto == 'Fase Despacho') || (facturacion == 0 && estado_proyecto == 'Negocio Ganado' && fase_proyecto == 'Fase Postventa')){
            $('#alertafacturacion').modal('show');
            $('#card-facturacion').show();
        };
        var fase = "<?php echo $proyecto->fase; ?>";
        if (fase == "Fase Diseño") {
            $('#fase_1').addClass('active');
            $('#fase_2').removeClass('active');
            $('#fase_3').removeClass('active');
            $('#fase_4').removeClass('active');
            $('#fase_5').removeClass('active');
            $('#fase_6').removeClass('active');
            $('#fase_7').removeClass('active');

            $('#slide_fase_1').fadeIn();
            $('#slide_fase_2').hide();
            $('#slide_fase_3').hide();
            $('#slide_fase_4').hide();
            $('#slide_fase_5').hide();
            $('#slide_fase_6').hide();
            $('#slide_fase_7').hide();
        } else if (fase == "Fase Propuesta Comercial") {
            $('#fase_1').removeClass('active');
            $('#fase_2').addClass('active');
            $('#fase_3').removeClass('active');
            $('#fase_4').removeClass('active');
            $('#fase_5').removeClass('active');
            $('#fase_6').removeClass('active');
            $('#fase_7').removeClass('active');

            $('#slide_fase_1').hide();
            $('#slide_fase_2').fadeIn();
            $('#slide_fase_3').hide();
            $('#slide_fase_4').hide();
            $('#slide_fase_5').hide();
            $('#slide_fase_6').hide();
            $('#slide_fase_7').hide();
        }
        /* else if (fase == "Fase Contable") {
                   $('#fase_1').removeClass('active');
                   $('#fase_2').removeClass('active');
                   $('#fase_3').addClass('active');
                   $('#fase_4').removeClass('active');
                   $('#fase_5').removeClass('active');
                   $('#fase_6').removeClass('active');
                   $('#fase_7').removeClass('active');

                   $('#slide_fase_1').hide();
                   $('#slide_fase_2').hide();
                   $('#slide_fase_3').fadeIn();
                   $('#slide_fase_4').hide();
                   $('#slide_fase_5').hide();
                   $('#slide_fase_6').hide();
                   $('#slide_fase_7').hide();
               } */
        else if (fase == "Fase Comercial") {
            $('#fase_1').removeClass('active');
            $('#fase_2').removeClass('active');
            $('#fase_3').removeClass('active');
            $('#fase_4').addClass('active');
            $('#fase_5').removeClass('active');
            $('#fase_6').removeClass('active');
            $('#fase_7').removeClass('active');

            $('#slide_fase_1').hide();
            $('#slide_fase_2').hide();
            $('#slide_fase_3').hide();
            $('#slide_fase_4').fadeIn();
            $('#slide_fase_5').hide();
            $('#slide_fase_6').hide();
            $('#slide_fase_7').hide();
        } else if (fase == "Fase Fabricacion") {
            $('#fase_1').removeClass('active');
            $('#fase_2').removeClass('active');
            $('#fase_3').removeClass('active');
            $('#fase_4').removeClass('active');
            $('#fase_5').addClass('active');
            $('#fase_6').removeClass('active');
            $('#fase_7').removeClass('active');

            $('#slide_fase_1').hide();
            $('#slide_fase_2').hide();
            $('#slide_fase_3').hide();
            $('#slide_fase_4').hide();
            $('#slide_fase_5').fadeIn();
            $('#slide_fase_6').hide();
            $('#slide_fase_7').hide();
        } else if (fase == "Fase Despacho") {
            $('#fase_1').removeClass('active');
            $('#fase_2').removeClass('active');
            $('#fase_3').removeClass('active');
            $('#fase_4').removeClass('active');
            $('#fase_5').removeClass('active');
            $('#fase_6').addClass('active');
            $('#fase_7').removeClass('active');

            $('#slide_fase_1').hide();
            $('#slide_fase_2').hide();
            $('#slide_fase_3').hide();
            $('#slide_fase_4').hide();
            $('#slide_fase_5').hide();
            $('#slide_fase_6').fadeIn();
            $('#slide_fase_7').hide();
        } else if (fase == "Fase Postventa") {
            $('#fase_1').removeClass('active');
            $('#fase_2').removeClass('active');
            $('#fase_3').removeClass('active');
            $('#fase_4').removeClass('active');
            $('#fase_5').removeClass('active');
            $('#fase_6').removeClass('active');
            $('#fase_7').addClass('active');

            $('#slide_fase_1').hide();
            $('#slide_fase_2').hide();
            $('#slide_fase_3').hide();
            $('#slide_fase_4').hide();
            $('#slide_fase_5').hide();
            $('#slide_fase_6').hide();
            $('#slide_fase_7').fadeIn();
        }
        $('#fase_prev').hide();
        $(document).ready(function() {
            $('#slide_fase_2').hide();
            $('#slide_fase_3').hide();
            $('#slide_fase_4').hide();
            $('#slide_fase_5').hide();
            $('#slide_fase_6').hide();
            $('#slide_fase_7').hide();


            $('#fase_1').on('click', function() {
                $('#fase_prev').hide();
                $('#fase_next').show();
                $(this).addClass('active');
                $('#fase_2').removeClass('active');
                $('#fase_3').removeClass('active');
                $('#fase_4').removeClass('active');
                $('#fase_5').removeClass('active');
                $('#fase_6').removeClass('active');
                $('#fase_7').removeClass('active');
                $('#slide_fase_1').fadeIn();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            });

            $('#fase_2').on('click', function() {
                $('#fase_prev').show();
                $('#fase_next').show();
                $(this).addClass('active');
                $('#fase_1').removeClass('active');
                $('#fase_3').removeClass('active');
                $('#fase_4').removeClass('active');
                $('#fase_5').removeClass('active');
                $('#fase_6').removeClass('active');
                $('#fase_7').removeClass('active');
                $('#slide_fase_2').fadeIn();
                $('#slide_fase_1').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            });

            /* $('#fase_3').on('click', function() {
                $('#fase_prev').show();
                $('#fase_next').show();
                $(this).addClass('active');
                $('#fase_1').removeClass('active');
                $('#fase_2').removeClass('active');
                $('#fase_4').removeClass('active');
                $('#fase_5').removeClass('active');
                $('#fase_6').removeClass('active');
                $('#fase_7').removeClass('active');
                $('#slide_fase_3').fadeIn();
                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            }); */

            $('#fase_4').on('click', function() {
                $('#fase_prev').show();
                $('#fase_next').show();
                $(this).addClass('active');
                $('#fase_1').removeClass('active');
                $('#fase_2').removeClass('active');
                $('#fase_3').removeClass('active');
                $('#fase_5').removeClass('active');
                $('#fase_6').removeClass('active');
                $('#fase_7').removeClass('active');
                $('#slide_fase_4').fadeIn();
                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            });

            $('#fase_5').on('click', function() {
                $('#fase_prev').show();
                $('#fase_next').show();
                $(this).addClass('active');
                $('#fase_1').removeClass('active');
                $('#fase_2').removeClass('active');
                $('#fase_3').removeClass('active');
                $('#fase_4').removeClass('active');
                $('#fase_6').removeClass('active');
                $('#fase_7').removeClass('active');
                $('#slide_fase_5').fadeIn();
                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            });

            $('#fase_6').on('click', function() {
                $('#fase_prev').show();
                $('#fase_next').show();
                $(this).addClass('active');
                $('#fase_1').removeClass('active');
                $('#fase_2').removeClass('active');
                $('#fase_3').removeClass('active');
                $('#fase_4').removeClass('active');
                $('#fase_5').removeClass('active');
                $('#fase_7').removeClass('active');
                $('#slide_fase_6').fadeIn();
                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_7').hide();
            });

            $('#fase_7').on('click', function() {
                $('#fase_prev').show();
                $('#fase_next').hide();
                $(this).addClass('active');
                $('#fase_1').removeClass('active');
                $('#fase_2').removeClass('active');
                $('#fase_3').removeClass('active');
                $('#fase_4').removeClass('active');
                $('#fase_5').removeClass('active');
                $('#fase_6').removeClass('active');
                $('#slide_fase_7').fadeIn();
                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
            });

            $('.carousel-control-next').on('click', function(event) {
                event.preventDefault();
                var currentPhase = $('.c-process__item.active');
                var nextPhase = currentPhase.next('.c-process__item');

                if (nextPhase.length !== 0) {
                    currentPhase.removeClass('active');
                    nextPhase.addClass('active');
                }

                if (nextPhase.attr('id') === 'fase_2') {
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').css({
                            'opacity': 0,
                            'position': 'relative',
                            'left': '100%'
                        })
                        .animate({
                            'opacity': 1,
                            'left': '0'
                        }, 500).show();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                }
                /* else if (nextPhase.attr('id') === 'fase_3') {
                                   $('#fase_prev').show();
                                   $('#fase_next').show();
                                   $('#slide_fase_1').hide();
                                   $('#slide_fase_2').hide();
                                   $('#slide_fase_3').css({
                                           'opacity': 0,
                                           'position': 'relative',
                                           'left': '100%'
                                       })
                                       .animate({
                                           'opacity': 1,
                                           'left': '0'
                                       }, 500).show();
                                   $('#slide_fase_4').hide();
                                   $('#slide_fase_5').hide();
                                   $('#slide_fase_6').hide();
                                   $('#slide_fase_7').hide();
                               }  */
                else if (nextPhase.attr('id') === 'fase_4') {
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').css({
                            'opacity': 0,
                            'position': 'relative',
                            'left': '100%'
                        })
                        .animate({
                            'opacity': 1,
                            'left': '0'
                        }, 500).show();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                } else if (nextPhase.attr('id') === 'fase_5') {
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').css({
                            'opacity': 0,
                            'position': 'relative',
                            'left': '100%'
                        })
                        .animate({
                            'opacity': 1,
                            'left': '0'
                        }, 500).show();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                } else if (nextPhase.attr('id') === 'fase_6') {
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').css({
                            'opacity': 0,
                            'position': 'relative',
                            'left': '100%'
                        })
                        .animate({
                            'opacity': 1,
                            'left': '0'
                        }, 500).show();
                    $('#slide_fase_7').hide();
                } else if (nextPhase.attr('id') === 'fase_7') {
                    $('#fase_next').hide();
                    $('#fase_prev').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').css({
                            'opacity': 0,
                            'position': 'relative',
                            'left': '100%'
                        })
                        .animate({
                            'opacity': 1,
                            'left': '0'
                        }, 500).show();
                }
            });

            $('.carousel-control-prev').on('click', function(event) {
                event.preventDefault();
                var currentPhase = $('.c-process__item.active');
                var prevPhase = currentPhase.prev('.c-process__item');

                if (prevPhase.length !== 0) {
                    currentPhase.removeClass('active');
                    prevPhase.addClass('active');
                }

                if (prevPhase.attr('id') === 'fase_1') {
                    $('#fase_prev').hide();
                    $('#fase_next').show();
                    $('#slide_fase_1').css({
                            'opacity': 0,
                            'position': 'relative',
                            'left': '-100%'
                        })
                        .animate({
                            'opacity': 1,
                            'left': '0'
                        }, 500).show();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                } else if (prevPhase.attr('id') === 'fase_2') {
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').css({
                            'opacity': 0,
                            'position': 'relative',
                            'left': '-100%'
                        })
                        .animate({
                            'opacity': 1,
                            'left': '0'
                        }, 500).show();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                }
                /*  else if (prevPhase.attr('id') === 'fase_3') {
                                    $('#fase_prev').show();
                                    $('#fase_next').show();
                                    $('#slide_fase_1').hide();
                                    $('#slide_fase_2').hide();
                                    $('#slide_fase_3').css({
                                            'opacity': 0,
                                            'position': 'relative',
                                            'left': '-100%'
                                        })
                                        .animate({
                                            'opacity': 1,
                                            'left': '0'
                                        }, 500).show();
                                    $('#slide_fase_4').hide();
                                    $('#slide_fase_5').hide();
                                    $('#slide_fase_6').hide();
                                    $('#slide_fase_7').hide();
                                }  */
                else if (prevPhase.attr('id') === 'fase_4') {
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').css({
                            'opacity': 0,
                            'position': 'relative',
                            'left': '-100%'
                        })
                        .animate({
                            'opacity': 1,
                            'left': '0'
                        }, 500).show();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                } else if (prevPhase.attr('id') === 'fase_5') {
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').css({
                            'opacity': 0,
                            'position': 'relative',
                            'left': '-100%'
                        })
                        .animate({
                            'opacity': 1,
                            'left': '0'
                        }, 500).show();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                } else if (prevPhase.attr('id') === 'fase_6') {
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').css({
                            'opacity': 0,
                            'position': 'relative',
                            'left': '-100%'
                        })
                        .animate({
                            'opacity': 1,
                            'left': '0'
                        }, 500).show();
                    $('#slide_fase_7').hide();
                } else if (prevPhase.attr('id') === 'fase_7') {
                    $('#fase_prev').show();
                    $('#fase_next').hide();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').css({
                            'opacity': 0,
                            'position': 'relative',
                            'left': '-100%'
                        })
                        .animate({
                            'opacity': 1,
                            'left': '0'
                        }, 500).show();
                }
            });

            // Inicializa Signature Pad
            var canvas = document.querySelector("canvas");
            var signaturePad = new SignaturePad(canvas);

            // Evento de clic en el botón de guardar firma
            $("#save-btn").on("click", function() {
                // Obtén la imagen de la firma como base64
                var signatureImg = signaturePad.toDataURL();

                // Asigna la imagen de la firma al campo de entrada oculto
                $("#signature-img").val(signatureImg);

                // Puedes enviar la imagen de la firma a tu servidor o realizar otras acciones aquí
                // Por ejemplo, puedes enviarla mediante Ajax o enviarla junto con un formulario.

                // Ejemplo de cómo mostrar la imagen de la firma en una etiqueta de imagen
                // $("<img>").attr("src", signatureImg).appendTo("body");
            });
        });
    </script>
    <script>
        Dropzone.options.anticipo50Dropzone = {
            url: '{{ route('admin.fasecontables.storeMedia') }}',
            maxFilesize: 4, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 4
            },
            success: function(file, response) {
                $('form').find('input[name="anticipo_50"]').remove()
                $('form').append('<input type="hidden" name="anticipo_50" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="anticipo_50"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($fasecontable) && $fasecontable->anticipo_50)
                    var file = {!! json_encode($fasecontable->anticipo_50) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="anticipo_50" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

        function formatearYValidarRutInput(rut) {
            rut = rut.replace(/[^\dkK]+/g, '');
            if (rut.length < 2) {
                // RUT inválido, mostrar mensaje de error o realizar alguna acción
                return;
            }
            var dv = rut.charAt(rut.length - 1);
            var rutNumeros = rut.slice(0, -1);
            // Verificar si rutNumeros es '0' después de quitar el guion
            if (rutNumeros === '0') {
                // Manejar el caso especial donde el RUT es '-0'
                rut = '';
                return rut;
            }
            rutNumeros = rutNumeros.padStart(8, '0');
            if (isNaN(rutNumeros)) {
                // RUT inválido, mostrar mensaje de error o realizar alguna acción
                rut = '';
                return rut;
            }
            var suma = 0;
            var factor = 2;
            for (var i = rutNumeros.toString().length - 1; i >= 0; i--) {
                suma += factor * rutNumeros.toString().charAt(i);
                factor++;
                if (factor > 7) {
                    factor = 2;
                }
            }
            var dvEsperado = 11 - (suma % 11);
            dvEsperado = (dvEsperado === 11) ? 0 : ((dvEsperado === 10) ? 'K' : dvEsperado.toString());

            // Corregir la comparación del dígito verificador
            if (dv.toString().toUpperCase() !== dvEsperado.toString().toUpperCase()) {
                // RUT inválido, mostrar mensaje de error o realizar alguna acción
                rut = '';
                return rut;
            }

            var rutTotal = rutNumeros + dvEsperado;
            rut = rutTotal.toString().replace(/^(\d{1,2})(\d{3})(\d{3})([\dkK0-9]{1})$/, "$1.$2.$3-$4");

            return rut;
        }

        jQuery(document).ready(function() {
            jQuery('#rut').on('blur', function() {
                var rut = jQuery(this).val();
                var rutFormateado = formatearYValidarRutInput(rut);

                if (rutFormateado == 0 || rutFormateado == "" || rutFormateado == "NaN") {
                    jQuery(this).addClass("error");
                    jQuery(this).val(rutFormateado);
                    alert("El rut no es Válido.");
                } else {
                    jQuery(this).val(rutFormateado);
                    jQuery(this).removeClass("error");
                }
            });
        });


        // listado fase de fabricacion
        const handleFase = (fase) => {
            console.log(fase);


            let faseIngenieria = $('#fase-ingenieria');
            let faseDimensionado = $('#fase-dimension');
            let fasePrensado = $('#fase-prensado');
            let faseEnchape = $('#fase-enchape');
            let fasePerforado = $('#fase-peforado');
            let faseArmado = $('#fase-armado');
            let faseLimpieza = $('#fase-limpieza');

            let circleIngenieria = $('#bg-gradient-light-ingenieria');
            let circleDimensionado = $('#bg-gradient-light-dimensionado');
            let circlePrensado = $('#bg-gradient-light-prensado');
            let circleEnchape = $('#bg-gradient-light-enchape');
            let circlePerforado = $('#bg-gradient-light-perforado');
            let circleArmado = $('#bg-gradient-light-armado');
            let circleLimpieza = $('#bg-gradient-light-limpieza');

            switch (fase) {
                case 'Ingenieria':
                    faseIngenieria.addClass('fabricacion-custom-active');
                    faseDimensionado.removeClass('fabricacion-custom-active');
                    fasePrensado.removeClass('fabricacion-custom-active');
                    faseEnchape.removeClass('fabricacion-custom-active');
                    fasePerforado.removeClass('fabricacion-custom-active');
                    faseArmado.removeClass('fabricacion-custom-active');
                    faseLimpieza.removeClass('fabricacion-custom-active');

                    circleIngenieria.addClass('circle-active');
                    circleDimensionado.removeClass('circle-active');
                    circlePrensado.removeClass('circle-active');
                    circleEnchape.removeClass('circle-active');
                    circlePerforado.removeClass('circle-active');
                    circleArmado.removeClass('circle-active');
                    circleLimpieza.removeClass('circle-active');
                    $('.circle-active').removeClass('bg-gradient-light');
                    break;
                case 'Dimensionado':
                    faseIngenieria.addClass('fabricacion-custom-active');
                    faseDimensionado.removeClass('fabricacion-custom-active');
                    fasePrensado.removeClass('fabricacion-custom-active');
                    faseEnchape.removeClass('fabricacion-custom-active');
                    fasePerforado.removeClass('fabricacion-custom-active');
                    faseArmado.removeClass('fabricacion-custom-active');
                    faseLimpieza.removeClass('fabricacion-custom-active');

                    circleIngenieria.removeClass('circle-active');
                    circleDimensionado.addClass('circle-active');
                    circlePrensado.removeClass('circle-active');
                    circleEnchape.removeClass('circle-active');
                    circlePerforado.removeClass('circle-active');
                    circleArmado.removeClass('circle-active');
                    circleLimpieza.removeClass('circle-active');
                    $('.circle-active').removeClass('bg-gradient-light');
                    break;
                case 'Prensado':
                    faseIngenieria.removeClass('fabricacion-custom-active');
                    faseDimensionado.addClass('fabricacion-custom-active');
                    fasePrensado.removeClass('fabricacion-custom-active');
                    faseEnchape.removeClass('fabricacion-custom-active');
                    fasePerforado.removeClass('fabricacion-custom-active');
                    faseArmado.removeClass('fabricacion-custom-active');
                    faseLimpieza.removeClass('fabricacion-custom-active');

                    circleIngenieria.removeClass('circle-active');
                    circleDimensionado.addClass('circle-active');
                    circlePrensado.removeClass('circle-active');
                    circleEnchape.removeClass('circle-active');
                    circlePerforado.removeClass('circle-active');
                    circleArmado.removeClass('circle-active');
                    circleLimpieza.removeClass('circle-active');
                    $('.circle-active').removeClass('bg-gradient-light');
                    break;
                case 'Enchape':
                    faseIngenieria.removeClass('fabricacion-custom-active');
                    faseDimensionado.addClass('fabricacion-custom-active');
                    fasePrensado.removeClass('fabricacion-custom-active');
                    faseEnchape.removeClass('fabricacion-custom-active');
                    fasePerforado.removeClass('fabricacion-custom-active');
                    faseArmado.removeClass('fabricacion-custom-active');
                    faseLimpieza.removeClass('fabricacion-custom-active');

                    circleIngenieria.removeClass('circle-active');
                    circleDimensionado.addClass('circle-active');
                    circlePrensado.removeClass('circle-active');
                    circleEnchape.removeClass('circle-active');
                    circlePerforado.removeClass('circle-active');
                    circleArmado.removeClass('circle-active');
                    circleLimpieza.removeClass('circle-active');

                    $('.circle-active').removeClass('bg-gradient-light');
                    break;
                case 'Perforado':
                    faseIngenieria.removeClass('fabricacion-custom-active');
                    faseDimensionado.addClass('fabricacion-custom-active');
                    fasePrensado.removeClass('fabricacion-custom-active');
                    faseEnchape.removeClass('fabricacion-custom-active');
                    fasePerforado.removeClass('fabricacion-custom-active');
                    faseArmado.removeClass('fabricacion-custom-active');
                    faseLimpieza.removeClass('fabricacion-custom-active');

                    circleIngenieria.removeClass('circle-active');
                    circleDimensionado.addClass('circle-active');
                    circlePrensado.removeClass('circle-active');
                    circleEnchape.removeClass('circle-active');
                    circlePerforado.removeClass('circle-active');
                    circleArmado.removeClass('circle-active');
                    circleLimpieza.removeClass('circle-active');
                    $('.circle-active').removeClass('bg-gradient-light');
                    break;
                case 'Armado':
                    faseIngenieria.removeClass('fabricacion-custom-active');
                    faseDimensionado.addClass('fabricacion-custom-active');
                    fasePrensado.removeClass('fabricacion-custom-active');
                    faseEnchape.removeClass('fabricacion-custom-active');
                    fasePerforado.removeClass('fabricacion-custom-active');
                    faseArmado.removeClass('fabricacion-custom-active');
                    faseLimpieza.removeClass('fabricacion-custom-active');

                    circleIngenieria.removeClass('circle-active');
                    circleDimensionado.addClass('circle-active');
                    circlePrensado.removeClass('circle-active');
                    circleEnchape.removeClass('circle-active');
                    circlePerforado.removeClass('circle-active');
                    circleArmado.removeClass('circle-active');
                    circleLimpieza.removeClass('circle-active');
                    $('.circle-active').removeClass('bg-gradient-light');
                    break;
                case 'Limpieza/Embalaje':
                    faseIngenieria.removeClass('fabricacion-custom-active');
                    faseDimensionado.removeClass('fabricacion-custom-active');
                    fasePrensado.removeClass('fabricacion-custom-active');
                    faseEnchape.removeClass('fabricacion-custom-active');
                    fasePerforado.removeClass('fabricacion-custom-active');
                    faseArmado.removeClass('fabricacion-custom-active');
                    faseLimpieza.addClass('fabricacion-custom-active');

                    circleIngenieria.removeClass('circle-active');
                    circleDimensionado.removeClass('circle-active');
                    circlePrensado.removeClass('circle-active');
                    circleEnchape.removeClass('circle-active');
                    circlePerforado.removeClass('circle-active');
                    circleArmado.removeClass('circle-active');
                    circleLimpieza.addClass('circle-active');
                    $('.circle-active').removeClass('bg-gradient-light');
                    break;
                default:
                    break;
            }
        };
        @if ($proyecto->fasefabrica)
            const fases = '{{ $proyecto->fasefabrica->fase }}';
            document.addEventListener('DOMContentLoaded', function() {
                handleFase(fases.toString());
            });
        @endif
        if (document.getElementById('btn-abono50')) {
            document.getElementById('btn-abono50').addEventListener('click', () => {
                document.getElementById('abono50file').click();
            });
        }
        if (document.getElementById('btn-abono40')) {
            document.getElementById('btn-abono40').addEventListener('click', () => {
                document.getElementById('abono40file').click();
            });
        }
        if (document.getElementById('btn-abono10')) {
            document.getElementById('btn-abono10').addEventListener('click', () => {
                document.getElementById('abono10file').click();
            });
        }
        // mostrar tablas segun fases
        $(document).ready(() => {

            const faseActual = '<?php echo $proyecto->fase; ?>';
            console.log(faseActual)
            switch (faseActual) {
                case 'Fase Diseño':
                    $('#slide_fase_1').fadeIn();
                    break;
                case 'Fase Propuesta Comercial':
                    $('#slide_fase_2').fadeIn();
                    break;
                case 'Fase Comercial':
                    $('#slide_fase_4').fadeIn();
                    break;
                case 'Fase Fabricacion':
                    $('#slide_fase_5').fadeIn();
                    break;
                case 'Fase Despacho':
                    $('#slide_fase_6').fadeIn();
                    break;
                case 'Fase Postventa':
                    $('#slide_fase_7').fadeIn();
                    break;
                case 'Fase Contable':
                    $('#fase_1').removeClass('active');
                    $('#fase_2').addClass('active');
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').fadeIn();
                    break;
                default:

                    break;
            }
        });
        const handleMobileFase = (fases) => {
            console.log(fases)
            $('#fase-list-1').fadeIn();
            $('#fase-list-2').hide();
            $('#fase-list-3').hide();
            $('#fase-list-4').hide();
            $('#fase-list-5').hide();
            $('#fase-list-6').hide();
            $('#fase-list-7').hide();
            if (fases == "Fase Diseño") {
                $('#fase-list-1').fadeIn()
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#fase-list-1').addClass('mobile-active');
                $('#fase-list-2').removeClass('mobile-active');
                $('#fase-list-3').removeClass('mobile-active');
                $('#fase-list-4').removeClass('mobile-active');
                $('#fase-list-5').removeClass('mobile-active');
                $('#fase-list-6').removeClass('mobile-active');
                $('#fase-list-7').removeClass('mobile-active');


                $('#slide_fase_1').fadeIn();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (fases == "Fase Propuesta Comercial") {
                $('#fase-list-1').hide();
                $('#fase-list-2').fadeIn();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#fase-list-1').removeClass('mobile-active');
                $('#fase-list-2').addClass('mobile-active');
                $('#fase-list-3').removeClass('mobile-active');
                $('#fase-list-4').removeClass('mobile-active');
                $('#fase-list-5').removeClass('mobile-active');
                $('#fase-list-6').removeClass('mobile-active');
                $('#fase-list-7').removeClass('mobile-active');


                $('#slide_fase_1').hide();
                $('#slide_fase_2').fadeIn();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            }
            /* else if (fases == "Fase Contable") {
                           $('#fase-list-1').hide();
                           $('#fase-list-2').hide();
                           $('#fase-list-3').fadeIn();
                           $('#fase-list-4').hide();
                           $('#fase-list-5').hide();
                           $('#fase-list-6').hide();
                           $('#fase-list-7').hide();

                           $('#fase-list-1').removeClass('mobile-active');
                           $('#fase-list-2').removeClass('mobile-active');
                           $('#fase-list-3').addClass('mobile-active');
                           $('#fase-list-4').removeClass('mobile-active');
                           $('#fase-list-5').removeClass('mobile-active');
                           $('#fase-list-6').removeClass('mobile-active');
                           $('#fase-list-7').removeClass('mobile-active');

                           $('#slide_fase_1').hide();
                           $('#slide_fase_2').hide();
                           $('#slide_fase_3').fadeIn();
                           $('#slide_fase_4').hide();
                           $('#slide_fase_5').hide();
                           $('#slide_fase_6').hide();
                           $('#slide_fase_7').hide();
                       } */
            else if (fases == "Fase Comercial") {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').fadeIn();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#fase-list-1').removeClass('mobile-active');
                $('#fase-list-2').removeClass('mobile-active');
                $('#fase-list-3').removeClass('mobile-active');
                $('#fase-list-4').addClass('mobile-active');
                $('#fase-list-5').removeClass('mobile-active');
                $('#fase-list-6').removeClass('mobile-active');
                $('#fase-list-7').removeClass('mobile-active');

                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').fadeIn();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (fases == "Fase Fabricacion") {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').fadeIn();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#fase-list-1').removeClass('mobile-active');
                $('#fase-list-2').removeClass('mobile-active');
                $('#fase-list-3').removeClass('mobile-active');
                $('#fase-list-4').removeClass('mobile-active');
                $('#fase-list-5').addClass('mobile-active');
                $('#fase-list-6').removeClass('mobile-active');
                $('#fase-list-7').removeClass('mobile-active');

                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').fadeIn();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (fases == "Fase Despacho") {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').fadeIn();
                $('#fase-list-7').hide();

                $('#fase-list-1').removeClass('mobile-active');
                $('#fase-list-2').removeClass('mobile-active');
                $('#fase-list-3').removeClass('mobile-active');
                $('#fase-list-4').removeClass('mobile-active');
                $('#fase-list-5').removeClass('mobile-active');
                $('#fase-list-6').addClass('mobile-active');
                $('#fase-list-7').removeClass('mobile-active');

                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').fadeIn();
                $('#slide_fase_7').hide();
            } else if (fases == "Fase Postventa") {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').fadeIn();

                $('#fase-list-1').removeClass('mobile-active');
                $('#fase-list-2').removeClass('mobile-active');
                $('#fase-list-3').removeClass('mobile-active');
                $('#fase-list-4').removeClass('mobile-active');
                $('#fase-list-5').removeClass('mobile-active');
                $('#fase-list-6').removeClass('mobile-active');
                $('#fase-list-7').addClass('mobile-active');

                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').fadeIn();
            };
        };
        @if ($proyecto->fasefabrica)
            $(document).ready(function() {
                handleMobileFase('{{ $proyecto->fasefabrica->fase }}');
            })
        @endif
        $('#btn-prev-mobile').on('click', function(event) {
            event.preventDefault();
            let currentPhase = $('.mobile-inactive.mobile-active');
            let prevPhase = currentPhase.prev('.mobile-inactive');

            if (prevPhase.length === 0) {
                $('#fase-list-2').addClass('mobile-active')
            }

            if (prevPhase.length !== 0) {

                $('#btn-prev-mobile').fadeIn();
                currentPhase.removeClass('mobile-active');
                prevPhase.addClass('mobile-active');
            }


            if (prevPhase.attr('id') === 'fase-list-1') {
                $('#fase-list-1').fadeIn()
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#slide_fase_1').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '-100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (prevPhase.attr('id') === 'fase-list-2') {
                $('#fase-list-1').hide();
                $('#fase-list-2').fadeIn();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#fase_prev').show();
                $('#fase_next').show();
                $('#slide_fase_1').hide();
                $('#slide_fase_2').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '-100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (prevPhase.attr('id') === 'fase-list-3') {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').fadeIn();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#fase_prev').show();
                $('#fase_next').show();
                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '-100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (prevPhase.attr('id') === 'fase-list-4') {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').fadeIn();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#fase_prev').show();
                $('#fase_next').show();
                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '-100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (prevPhase.attr('id') === 'fase-list-5') {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').fadeIn();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#fase_prev').show();
                $('#fase_next').show();
                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '-100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (prevPhase.attr('id') === 'fase-list-6') {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').fadeIn();
                $('#fase-list-7').hide();

                $('#fase_prev').show();
                $('#fase_next').show();
                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '-100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_7').hide();
            } else if (prevPhase.attr('id') === 'fase-list-7') {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').fadeIn();

                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '-100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
            }
        });

        $('#btn-next-mobile').on('click', function(event) {
            event.preventDefault();
            let currentPhase = $('.mobile-inactive.mobile-active');
            let nextPhase = currentPhase.next('.mobile-inactive');


            if (nextPhase.length === 0) {
                $('#fase-list-1').addClass('mobile-active')
            }

            if (nextPhase.length !== 0) {
                currentPhase.removeClass('mobile-active');
                nextPhase.addClass('mobile-active');
            }

            if (nextPhase.attr('id') === 'fase-list-1') {
                $('#fase-list-1').fadeIn()
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#btn-prev-mobile').hide();
                $('#slide_fase_1').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '-100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (nextPhase.attr('id') === 'fase-list-2') {
                $('#fase-list-1').hide();
                $('#fase-list-2').fadeIn();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#slide_fase_1').hide();
                $('#slide_fase_2').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (nextPhase.attr('id') === 'fase-list-3') {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').fadeIn();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (nextPhase.attr('id') === 'fase-list-4') {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').fadeIn();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (nextPhase.attr('id') === 'fase-list-5') {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').fadeIn();
                $('#fase-list-6').hide();
                $('#fase-list-7').hide();

                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').hide();
            } else if (nextPhase.attr('id') === 'fase-list-6') {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').fadeIn();
                $('#fase-list-7').hide();

                $('#btn-next-mobile').fadeIn()
                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
                $('#slide_fase_7').hide();
            } else if (nextPhase.attr('id') === 'fase-list-7') {
                $('#fase-list-1').hide();
                $('#fase-list-2').hide();
                $('#fase-list-3').hide();
                $('#fase-list-4').hide();
                $('#fase-list-5').hide();
                $('#fase-list-6').hide();
                $('#fase-list-7').fadeIn();

                $('#slide_fase_1').hide();
                $('#slide_fase_2').hide();
                $('#slide_fase_3').hide();
                $('#slide_fase_4').hide();
                $('#slide_fase_5').hide();
                $('#slide_fase_6').hide();
                $('#slide_fase_7').css({
                        'opacity': 0,
                        'position': 'relative',
                        'left': '100%'
                    })
                    .animate({
                        'opacity': 1,
                        'left': '0'
                    }, 500).show();
            }
        });
    </script>
@endsection
