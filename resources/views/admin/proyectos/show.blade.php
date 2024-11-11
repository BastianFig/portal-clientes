@extends('layouts.admin')
@section('content')
@if(session('success'))
    <div class="alert alert-success">
        <ul class="list-unstyled">
            <li>Datos guardados correctamente.</li>
        </ul>
    </div>
@endif
<div class="card">
    <div class="card-header text-center pt-4 pb-4">
       <h3> {{ $proyecto->nombre_proyecto }}</h3>
    </div>

    <div class="card-body">
        <div class="form-group">
            <table class="table table-bordered table-responsive-md text-center">
                <thead class="font-weight-bold text-white bg-azul">
                    <tr>
                        <td>Empresa</td>
                        <td>Rut</td>
                        <td>Sucursal</td>
                        <td>Cliente</td>
                        <td>Tipo Proyecto</td>
                        <td>Estado</td>
                    </tr>
                </thead>
                <tbody class="font-weight-bold" >
                    <tr>
                        <td>{{ $proyecto->id_cliente->nombe_de_fantasia ?? '' }}</td>
                        <td>{{$proyecto->id_cliente->rut}}</td>
                        <td>{{ $proyecto->sucursal->nombre ?? '' }}</td>
                        <td>
                            @foreach($proyecto->id_usuarios_clientes as $key => $id_usuarios_cliente)
                                <span class="label label-info">{{ $id_usuarios_cliente->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ App\Models\Proyecto::TIPO_PROYECTO_SELECT[$proyecto->tipo_proyecto] ?? '' }}</td>
                        <td> {{ App\Models\Proyecto::ESTADO_SELECT[$proyecto->estado] ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group mb-5">
                <button class="btn btn-success text-white float-right" id="btn_ver_carpeta" data-toggle="modal" data-target="#myModal2">Ver Carpeta Cliente</button>
            </div>
        </div>
    </div>
</div>

    

    <div class="card">
        <div class="card-body">
            <ul class="c-process">
                <li class="c-process__item2 mx-5" id="fase_prev">
                    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                </li>
                <li class="c-process__item active" id="fase_1">1<div class="div_pasos1">Diseño</div></li>
                <li class="c-process__item" id="fase_2">2<div class="div_pasos2">Propuesta Comercial</div></li>
                <li class="c-process__item" id="fase_3">3<div class="div_pasos3">Contable</div></li>
                <li class="c-process__item" id="fase_4">4<div class="div_pasos4">Acuerdo Comercial</div></li>
                <li class="c-process__item" id="fase_5">5<div class="div_pasos5">Fabricación</div></li>
                <li class="c-process__item" id="fase_6">6<div class="div_pasos6">Despachos</div></li>
                <li class="c-process__item" id="fase_7">7<div class="div_pasos7">Postventa </div></li>
                <li class="c-process__item2 mx-5" id="fase_next">
                    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </li>
            </ul>
            <div id="myCarousel" class="" data-ride="false">
                <div class="mx-5">
                    <div class="carousel-inner">
                        <div class="carousel-item my-5 active" id="slide_fase_1">
                            <div class="form-group text-center">
                                <h2>FASE DISEÑO</h2>
                            </div>
                            <form method="POST" action="{{route("admin.proyectos.storeFasediseno")}}" enctype="multipart/form-data">
                            @csrf                   
                                <input type="hidden" name="id_proyecto_id" id="id_proyecto_id" value="{{$proyecto->id}}">
                                <input type="hidden" name="id_fasediseno" id="id_fasediseno" value="{{$proyecto->id_fasediseno}}">  
                                <div class="form-group">
                                    <label for="descripcion">{{ trans('cruds.faseDiseno.fields.descripcion') }}</label>
                                    <input class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" type="text" name="descripcion" id="descripcion" value="{{ old('descripcion', $proyecto->fasediseno->descripcion ?? '') }}">
                                    @if($errors->has('descripcion'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('descripcion') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.faseDiseno.fields.descripcion_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="imagenes">{{ trans('cruds.faseDiseno.fields.imagenes') }} (Plano, fftt, Presentación, Renders)<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .JPG .PNG .DWG .XLSX .PDF)</strong></small></label>
                                    <div class="needsclick dropzone {{ $errors->has('imagenes') ? 'is-invalid' : '' }}" id="imagenes-dropzone">
                                    </div>
                                    @if($errors->has('imagenes'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('imagenes') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.faseDiseno.fields.imagenes_helper') }}</span>
                                </div>
                                
                                <div class="form-group">
                                    <table id="tabla_imagenes" class="table table-bordered">
                                        <thead>
                                            <th>Imagen</th>
                                            <th>URL</th>
                                            <th>Fecha de Carga</th>
                                        </thead>
                                        @if($proyecto->fasediseno)
                                            @foreach($proyecto->fasediseno->imagenes as $archivo)
                                            
                                            <tr>
                                                <td>{{$archivo['file_name']}}</td>
                                                <td><a href="{{$archivo->getUrl()}}" target="_blank">Ver imagen</a></td>
                                                <td>{{$archivo['created_at']->format('d-m-Y')}}</td>
                                            </tr>
                                                
                                            @endforeach
                                        @else
                                            <tr>
                                                <td> No Disponible</td>
                                                <td> No Disponible</td>
                                                <td> No Disponible</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="form-group">
                                    <label for="propuesta">Documentos de Apoyo (Imágenes inspiradoras)<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                    <div class="needsclick dropzone {{ $errors->has('propuesta') ? 'is-invalid' : '' }}" id="propuesta-dropzone">
                                    </div>
                                    @if($errors->has('propuesta'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('propuesta') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.faseDiseno.fields.propuesta_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <input class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" type="hidden" name="estado" id="estado" value="{{ old('estado', $proyecto->fasediseno->estado ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-danger" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="carousel-item my-5" id="slide_fase_2">
                            <div class="form-group text-center">
                                <h2>FASE PROPUESTA COMERCIAL</h2>
                            </div>
                            <form method="POST" action="{{ route("admin.proyectos.storeFasecomercial") }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_proyecto_id" id="id_proyecto_id" value="{{$proyecto->id}}"> 
                                <input type="hidden" name="id_fasecomercial" id="id_fasecomercial" value="{{$proyecto->id_fasecomercial}}">  
                                <div class="form-group">
                                    <label for="comentarios">{{ trans('cruds.fasecomercial.fields.comentarios') }}</label>
                                    <input class="form-control {{ $errors->has('comentarios') ? 'is-invalid' : '' }}" type="text" name="comentarios" id="comentarios" value="{{ old('comentarios', $proyecto->fasecomercial->comentarios ?? '') }}">
                                    @if($errors->has('comentarios'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('comentarios') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasecomercial.fields.comentarios_helper') }}</span>
                                </div>
                                
                                <div class="form-group">
                                    <label>Monto Neto</label>
                                    <input class="form-control {{ $errors->has('monto') ? 'is-invalid' : '' }}" type="text" name="monto" id="monto" value="{{ old('monto', $proyecto->faseComercial->monto ?? '') }}">     
                                </div>
                                <script>
                                    $('#monto').on('keyup', function() {
                                        const value = $(this).val();
                                        // Reemplaza cualquier carácter que no sea un dígito por una cadena vacía
                                        const filteredValue = value.replace(/\D/g, '');
                                        // Si el valor ha cambiado, actualiza el campo de entrada
                                        if (value !== filteredValue) {
                                          $(this).val(filteredValue);
                                        }
                                      });
                                </script>
                            
                                <div class="form-group">
                                    <label for="cotizacion">{{ trans('cruds.fasecomercial.fields.cotizacion') }}<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF .XLSX)</strong></small></label>
                                    <div class="needsclick dropzone {{ $errors->has('cotizacion') ? 'is-invalid' : '' }}" id="cotizacion-dropzone">
                                    </div>
                                    @if($errors->has('cotizacion'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('cotizacion') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasecomercial.fields.cotizacion_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <table id="tabla_archivos" class="table table-bordered">
                                        <thead>
                                            <th>Archivo</th>
                                            <th>URL</th>
                                            <th>Fecha de Carga</th>
                                        </thead>
                                        @if($proyecto->fasecomercial)
                                            @foreach($proyecto->fasecomercial->cotizacion as $archivo)
                                            <tr>
                                                <td>{{$archivo['file_name']}}</td>
                                                <td><a href="{{$archivo['url']}}" target="_blank">Ver Archivo</a></td>
                                                <td>{{$archivo['created_at']->format('d-m-Y')}}</td>
                                            </tr>
                                                
                                            @endforeach
                                        @else
                                            <tr>
                                                <td> No Disponible</td>
                                                <td> No Disponible</td>
                                                <td> No Disponible</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>    
                
                                <div class="form-group">
                                    <label for="oc">Orden de Compra <br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                    <div class="needsclick dropzone {{ $errors->has('oc') ? 'is-invalid' : '' }}" id="oc-dropzone">
                                    </div>
                                    @if($errors->has('oc'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('oc') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasecomercial.fields.oc_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <input class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" type="hidden" name="estado" id="estado" value="{{ old('estado', $proyecto->fasecomercial->estado ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-danger" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="carousel-item my-5" id="slide_fase_3">
                            <div class="form-group text-center">
                                <h2>FASE CONTABLE</h2>
                            </div>
                            <form method="POST" action="{{ route("admin.proyectos.storeFasecontable") }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_proyecto_id" id="id_proyecto_id" value="{{$proyecto->id}}"> 
                                <input type="hidden" name="id_fasecontables" id="id_fasecontables" value="{{$proyecto->id_fasecontables}}">  
                                
                                @if($proyecto->id_cliente->antiguedad_empresa == 'Nuevo')
                                    <div class="form-group">
                                        <label for="anticipo_50">{{ trans('cruds.fasecontable.fields.anticipo_50') }} (Subir Comprobante de Transferencia)<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                        <div class="needsclick dropzone {{ $errors->has('anticipo_50') ? 'is-invalid' : '' }}" id="anticipo_50-dropzone">
                                            
                                        </div>
                                        @if($errors->has('anticipo_50'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('anticipo_50') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.fasecontable.fields.anticipo_50_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="anticipo_40">{{ trans('cruds.fasecontable.fields.anticipo_40') }}  (Subir Comprobante de Transferencia)<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                        <div class="needsclick dropzone {{ $errors->has('anticipo_40') ? 'is-invalid' : '' }}" id="anticipo_40-dropzone">
                                        </div>
                                        @if($errors->has('anticipo_40'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('anticipo_40') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.fasecontable.fields.anticipo_40_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="anticipo_10">{{ trans('cruds.fasecontable.fields.anticipo_10') }}  (Subir Comprobante de Transferencia)<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                        <div class="needsclick dropzone {{ $errors->has('anticipo_10') ? 'is-invalid' : '' }}" id="anticipo_10-dropzone">
                                        </div>
                                        @if($errors->has('anticipo_10'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('anticipo_10') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.fasecontable.fields.anticipo_10_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-danger" type="submit">
                                            {{ trans('global.save') }}
                                        </button>
                                    </div>
                                @endif
                                @if($proyecto->id_cliente->antiguedad_empresa == 'Confiable')
                                    <div class="form-group">
                                        <label for="anticipo_50">{{ trans('cruds.fasecontable.fields.anticipo_50') }} (Subir Comprobante de Transferencia)<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                        <div class="needsclick dropzone {{ $errors->has('anticipo_50') ? 'is-invalid' : '' }}" id="anticipo_50-dropzone">
                                            
                                        </div>
                                        @if($errors->has('anticipo_50'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('anticipo_50') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.fasecontable.fields.anticipo_50_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="anticipo_40">Pago 50%  (Subir Comprobante de Transferencia)<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                        <div class="needsclick dropzone {{ $errors->has('anticipo_40') ? 'is-invalid' : '' }}" id="anticipo_40-dropzone">
                                        </div>
                                        @if($errors->has('anticipo_40'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('anticipo_40') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.fasecontable.fields.anticipo_40_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-danger" type="submit">
                                            {{ trans('global.save') }}
                                        </button>
                                    </div>
                                @endif
                                @if($proyecto->id_cliente->antiguedad_empresa == 'Especial')
                                    <div class="form-group">
                                        <label for="anticipo_50">Pagos (Subir Comprobante de Transferencia)<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                        <div class="needsclick dropzone {{ $errors->has('anticipo_50') ? 'is-invalid' : '' }}" id="anticipo_50-dropzone">
                                            
                                        </div>
                                        @if($errors->has('anticipo_50'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('anticipo_50') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.fasecontable.fields.anticipo_50_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-danger" type="submit">
                                            {{ trans('global.save') }}
                                        </button>
                                    </div>
                                @endif
                                @if($proyecto->id_cliente->antiguedad_empresa == Null)
                                    <h4>Debe ingresar la Antigüedad de la Empresa</h4>
                                @endif
                            </form>
                        </div>    

                        <!-- POPUP O MODAL CARGAR CARPETA CLIENTE -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">{{ trans('global.create') }} {{ trans('cruds.carpetacliente.title_singular') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route("admin.proyectos.storeCarpetacliente") }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id_proyecto_id" id="id_proyecto_id" value="{{$proyecto->id}}"> 
                                            <input type="hidden" name="id_carpetacliente" id="id_carpetacliente" value="{{$proyecto->id_carpetacliente}}">  
                                            <div class="form-group">
                                                <label for="presupuesto">{{ trans('cruds.carpetacliente.fields.presupuesto') }}</label>
                                                <div class="needsclick dropzone {{ $errors->has('presupuesto') ? 'is-invalid' : '' }}" id="presupuesto-dropzone">
                                                </div>
                                                @if($errors->has('presupuesto'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('presupuesto') }}
                                                    </div>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.carpetacliente.fields.presupuesto_helper') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="plano">{{ trans('cruds.carpetacliente.fields.plano') }}</label>
                                                <div class="needsclick dropzone {{ $errors->has('plano') ? 'is-invalid' : '' }}" id="plano-dropzone">
                                                </div>
                                                @if($errors->has('plano'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('plano') }}
                                                    </div>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.carpetacliente.fields.plano_helper') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="fftt">{{ trans('cruds.carpetacliente.fields.fftt') }}</label>
                                                <div class="needsclick dropzone {{ $errors->has('fftt') ? 'is-invalid' : '' }}" id="fftt-dropzone">
                                                </div>
                                                @if($errors->has('fftt'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('fftt') }}
                                                    </div>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.carpetacliente.fields.fftt_helper') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="presentacion">{{ trans('cruds.carpetacliente.fields.presentacion') }}</label>
                                                <div class="needsclick dropzone {{ $errors->has('presentacion') ? 'is-invalid' : '' }}" id="presentacion-dropzone">
                                                </div>
                                                @if($errors->has('presentacion'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('presentacion') }}
                                                    </div>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.carpetacliente.fields.presentacion_helper') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="rectificacion">{{ trans('cruds.carpetacliente.fields.rectificacion') }}</label>
                                                <div class="needsclick dropzone {{ $errors->has('rectificacion') ? 'is-invalid' : '' }}" id="rectificacion-dropzone">
                                                </div>
                                                @if($errors->has('rectificacion'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('rectificacion') }}
                                                    </div>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.carpetacliente.fields.rectificacion_helper') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="nb">{{ trans('cruds.carpetacliente.fields.nb') }}</label>
                                                <div class="needsclick dropzone {{ $errors->has('nb') ? 'is-invalid' : '' }}" id="nb-dropzone">
                                                </div>
                                                @if($errors->has('nb'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('nb') }}
                                                    </div>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.carpetacliente.fields.nb_helper') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="course">Curse</label>
                                                <div class="needsclick dropzone {{ $errors->has('course') ? 'is-invalid' : '' }}" id="course-dropzone">
                                                </div>
                                                @if($errors->has('course'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('course') }}
                                                    </div>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.carpetacliente.fields.course_helper') }}</span>
                                            </div>                                        
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            <button class="btn btn-success" type="submit">
                                                {{ trans('global.save') }}
                                            </button>
                                    
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        
                        <!-- POPUP O MODAL 2 VER CARPETA CLIENTE -->
                        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">{{ trans('global.show') }} {{ trans('cruds.carpetacliente.title') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>
                                                       
                                                        {{ trans('cruds.carpetacliente.fields.id') }}
                                                    </th>
                                                    <td>
                                                        @if(!empty($proyecto) && !empty($proyecto->carpetacliente) && !empty($proyecto->carpetacliente->id))
                                                            {{ $proyecto->carpetacliente->id }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        {{ trans('cruds.carpetacliente.fields.presupuesto') }}
                                                    </th>
                                                    <td>
                                                        @if(!empty($proyecto) && !empty($proyecto->carpetacliente) && !empty($proyecto->carpetacliente->presupuesto))
                                                            <a href="{{ $proyecto->carpetacliente->presupuesto->getUrl() }}" target="_blank">
                                                                {{ trans('global.view_file') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        {{ trans('cruds.carpetacliente.fields.plano') }}
                                                    </th>
                                                    <td>
                                                        @if(!empty($proyecto) && !empty($proyecto->carpetacliente) && !empty($proyecto->carpetacliente->plano))
                                                            @foreach($proyecto->carpetacliente->plano as $key => $media)
                                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                                    {{ trans('global.view_file') }}
                                                                </a>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        {{ trans('cruds.carpetacliente.fields.fftt') }}
                                                    </th>
                                                    <td>
                                                        @if(!empty($proyecto) && !empty($proyecto->carpetacliente) && !empty($proyecto->carpetacliente->fftt))
                                                            @foreach($proyecto->carpetacliente->fftt as $key => $media)
                                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                                    {{ trans('global.view_file') }}
                                                                </a>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        {{ trans('cruds.carpetacliente.fields.presentacion') }}
                                                    </th>
                                                    <td>
                                                        @if(!empty($proyecto) && !empty($proyecto->carpetacliente) && !empty($proyecto->carpetacliente->presentacion))
                                                            @foreach($proyecto->carpetacliente->presentacion as $key => $media)
                                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                                    {{ trans('global.view_file') }}
                                                                </a>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        {{ trans('cruds.carpetacliente.fields.rectificacion') }}
                                                    </th>
                                                    <td>
                                                        @if(!empty($proyecto) && !empty($proyecto->carpetacliente) && !empty($proyecto->carpetacliente->rectificacion))
                                                            <a href="{{ $proyecto->carpetacliente->rectificacion->getUrl() }}" target="_blank">
                                                                {{ trans('global.view_file') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        {{ trans('cruds.carpetacliente.fields.nb') }}
                                                    </th>
                                                    <td>
                                                        @if(!empty($proyecto) && !empty($proyecto->carpetacliente) && !empty($proyecto->carpetacliente->nb))
                                                            <a href="{{ $proyecto->carpetacliente->nb->getUrl() }}" target="_blank">
                                                                {{ trans('global.view_file') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Curse
                                                    </th>
                                                    <td>
                                                        @if(!empty($proyecto) && !empty($proyecto->carpetacliente) && !empty($proyecto->carpetacliente->course))
                                                            <a href="{{ $proyecto->carpetacliente->course->getUrl() }}" target="_blank">
                                                                {{ trans('global.view_file') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item my-5" id="slide_fase_4">
                            <div class="form-group text-center">
                                <h2>FASE ACUERDO COMERCIAL</h2>
                            </div>
                            <div class="form-group mb-5">
                                <button class="btn btn-warning text-white float-right" id="btn_cargar_carpeta" data-toggle="modal" data-target="#myModal">Cargar Carpeta Cliente</button>
                            </div>
                            <form method="POST" action="{{ route("admin.proyectos.storeFasecomercialproyecto") }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_proyecto_id" id="id_proyecto_id" value="{{$proyecto->id}}"> 
                                <input type="hidden" name="id_fasecomercialproyectos" id="id_fasecomercialproyectos" value="{{$proyecto->id_fasecomercialproyectos}}">
                                 <input type="hidden" name="tipo_proyecto" id="tipo_proyecto" value="{{$proyecto->tipo_proyecto}}">
                              {{-- <div class="form-group">
                                    <label>Tipo de Proyecto</label>
                                    <select class="form-control {{ $errors->has('tipo_proyecto') ? 'is-invalid' : '' }}" name="tipo_proyecto" id="tipo_proyecto">
                                        <option value disabled {{ old('tipo_proyecto', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach(App\Models\Fasecomercialproyecto::TIPO_PROYECTO_SELECT as $key => $label)
                                            <option value="{{ $key }}" {{ old('tipo_proyecto', $proyecto->faseComercialproyecto->tipo_proyecto ?? '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('tipo_proyecto'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('tipo_proyecto') }}
                                        </div>
                                    @endif
                                </div> --}}
                                
                                <div class="form-group">
                                    <label for="facturas">Facturas<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                    <div class="needsclick dropzone {{ $errors->has('facturas') ? 'is-invalid' : '' }}" id="facturas-dropzone">
                                    </div>
                                    @if($errors->has('facturas'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('facturas') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="credito">Nota de Crédito/Débito<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                    <div class="needsclick dropzone {{ $errors->has('credito') ? 'is-invalid' : '' }}" id="credito-dropzone">
                                    </div>
                                    @if($errors->has('credito'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('credito') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="fecha_despacho">Plazo de Entrega</label>
                                    <input class="form-control {{ $errors->has('fecha_despacho') ? 'is-invalid' : '' }}" type="date" name="fecha_despacho" id="fecha_despacho" value="{{ old('fecha_entrega',  $proyecto->faseComercialproyecto->fecha_despacho ?? '') }}">
                                    @if($errors->has('fecha_despacho'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('fecha_despacho') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group" id="div-monto-mobiliario">
                                    @if($proyecto->faseComercialproyecto)
                                        <label for="monto_mobiliario">Monto neto mobiliario</label>
                                            <input type="text" id="monto_mobiliario" name="monto_mobiliario" class="form-control" value="{{ old('monto_mobiliario',  $proyecto->faseComercialproyecto->monto_mobiliario ?? '') }}">
                                    @else
                                            <label for="monto_mobiliario">Monto neto mobiliario</label>
                                            <input type="text" id="monto_mobiliario" name="monto_mobiliario" class="form-control" >
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="nota_venta">{{ trans('cruds.fasecomercialproyecto.fields.nota_venta') }}<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                    <div class="needsclick dropzone {{ $errors->has('nota_venta') ? 'is-invalid' : '' }}" id="nota_venta-dropzone">
                                    </div>
                                    @if($errors->has('nota_venta'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('nota_venta') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasecomercialproyecto.fields.nota_venta_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-danger" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="carousel-item my-5" id="slide_fase_5">
                            <div class="form-group text-center">
                                <h2>FASE FABRICACIÓN</h2>
                            </div>
                            <form method="POST" action="{{ route("admin.proyectos.storeFasefabricacion") }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_proyecto_id" id="id_proyecto_id" value="{{$proyecto->id}}"> 
                                <input type="hidden" name="id_fasefabricas" id="id_fasefabricas" value="{{$proyecto->id_fasefabricas}}"> 
                                <div class="form-group">
                                    <label>Aprobación Curse</label>
                                    <select class="form-control {{ $errors->has('aprobacion_course') ? 'is-invalid' : '' }}" name="aprobacion_course" id="aprobacion_course">
                                        <option value disabled {{ old('aprobacion_course', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }} una alternativa</option>
                                        @foreach(App\Models\Fasefabrica::APROBACION_COURSE_SELECT as $key => $label)
                                        <option value="{{ $key }}" {{ old('aprobacion_course',  $proyecto->fasefabrica->aprobacion_course ?? '')  === (string) $key ? 'selected' : '' }}>{{ $label }}</option>                                        
                                        @endforeach
                                    </select>
                                    @if($errors->has('aprobacion_course'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('aprobacion_course') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasefabrica.fields.aprobacion_course_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Etapa Fabril</label>
                                    <select class="form-control {{ $errors->has('fase') ? 'is-invalid' : '' }}" name="fase" id="fase">
                                        <option value disabled {{ old('fase', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }} una alternativa</option>
                                        @foreach(App\Models\Fasefabrica::FASE as $key => $label)
                                        <option value="{{ $key }}" {{ old('fase',  $proyecto->fasefabrica->fase ?? '')  === (string) $key ? 'selected' : '' }}>{{ $label }}</option>                                        
                                        @endforeach
                                    </select>
                                    @if($errors->has('fase'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('fase') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasefabrica.fields.aprobacion_course_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="oc_proveedores">Orden de Compra Proveedores<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                    <div class="needsclick dropzone {{ $errors->has('oc_proveedores') ? 'is-invalid' : '' }}" id="oc_proveedores-dropzone">
                                    </div>
                                    @if($errors->has('oc_proveedores'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('oc_proveedores') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasefabrica.fields.oc_proveedores_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('cruds.fasefabrica.fields.estado_produccion') }}</label>
                                    <select class="form-control {{ $errors->has('estado_produccion') ? 'is-invalid' : '' }}" name="estado_produccion" id="estado_produccion">
                                        <option value disabled {{ old('estado_produccion', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }} una alternativa</option>
                                        @foreach(App\Models\Fasefabrica::ESTADO_PRODUCCION_SELECT as $key => $label)
                                            <option value="{{ $key }}" {{ old('estado_produccion', $proyecto->fasefabrica->estado_produccion ?? '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('estado_produccion'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('estado_produccion') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasefabrica.fields.estado_produccion_helper') }}</span>
                                 </div>
                                {{-- <div class="form-group">
                                    <label for="fecha_entrega">{{ trans('cruds.fasefabrica.fields.fecha_entrega') }}</label>
                                    <input class="form-control date {{ $errors->has('fecha_entrega') ? 'is-invalid' : '' }}" type="text" name="fecha_entrega" id="fecha_entrega" value="{{ old('fecha_entrega',  $proyecto->fasefabrica->fecha_entrega ?? '') }}">
                                    @if($errors->has('fecha_entrega'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('fecha_entrega') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasefabrica.fields.fecha_entrega_helper') }}</span>
                                </div>  --}}
                                <div class="form-group">
                                    <label for="galeria_estado_entrega">{{ trans('cruds.fasefabrica.fields.galeria_estado_entrega') }}<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .JPG .PNG .DWG .XLSX)</strong></small></label>
                                    <div class="needsclick dropzone {{ $errors->has('galeria_estado_entrega') ? 'is-invalid' : '' }}" id="galeria_estado_entrega-dropzone">
                                    </div>
                                    @if($errors->has('galeria_estado_entrega'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('galeria_estado_entrega') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasefabrica.fields.galeria_estado_entrega_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <input class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" type="hidden" name="estado" id="estado" value="{{ old('estado',  $proyecto->fasefabrica->estado ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-danger" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="carousel-item my-5" id="slide_fase_6">
                            <div class="form-group text-center">
                                <h2>FASE DESPACHOS</h2>
                            </div>
                            <form method="POST" id="form-despachos" action="{{ route("admin.proyectos.storeFasedespachos") }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_proyecto_id" id="id_proyecto_id" value="{{$proyecto->id}}"> 
                                <input type="hidden" name="id_fasedespachos" id="id_fasedespachos" value="{{$proyecto->id_fasedespachos}}"> 
                                <div class="form-group">
                                    <h4>DATOS DE DESPACHO</h4>
                                    <div class="form-group">
                                        <label for="total_parcial">Tipo de Despacho</label>
                                        <select class="form-control {{ $errors->has('total_parcial') ? 'is-invalid' : '' }}" name="total_parcial" id="total_parcial">
                                            <option value disabled {{ old('total_parcial', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }} una alternativa</option>
                                            @foreach(App\Models\Fasedespacho::TOTAL_PARCIAL_SELECT as $key => $label)
                                                <option value="{{ $key }}" {{ old('total_parcial', $proyecto->fasedespacho->total_parcial ?? '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>                                             
                                        @if($errors->has('total_parcial'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('total_parcial') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="lotes">Lotes</label>
                                        <input class="form-control {{ $errors->has('lotes') ? 'is-invalid' : '' }}" type="number" name="lotes" id="lotes" value="{{ old('lotes', $proyecto->fasedespacho->lotes ?? '') }}">
                                        @if($errors->has('lotes'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('lotes') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_despacho">{{ trans('cruds.fasedespacho.fields.fecha_despacho') }}</label>
                                        <input class="form-control  {{ $errors->has('fecha_despacho') ? 'is-invalid' : '' }}" type="date" name="fecha_despacho" id="fecha_despacho" value="{{ old('fecha_despacho', $proyecto->fasedespacho->fecha_despacho ?? '') }}">
                                        @if($errors->has('fecha_despacho'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('fecha_despacho') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.fasedespacho.fields.fecha_despacho_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="horario">Horario</label>
                                        <select class="form-control {{ $errors->has('horario') ? 'is-invalid' : '' }}" name="horario" id="horario">
                                            <option value disabled {{ old('horario', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }} una alternativa</option>
                                            @foreach(App\Models\Fasedespacho::HORARIO_SELECT as $key => $label)
                                                <option value="{{ $key }}" {{ old('horario', $proyecto->fasedespacho->horario ?? '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>                                        
                                        @if($errors->has('horario'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('horario') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="empresa_transporte">Empresa de Transporte</label>
                                        <input class="form-control {{ $errors->has('empresa_transporte') ? 'is-invalid' : '' }}" type="text" name="empresa_transporte" id="empresa_transporte" value="{{ old('empresa_transporte', $proyecto->fasedespacho->empresa_transporte ?? '') }}">
                                        @if($errors->has('empresa_transporte'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('empresa_transporte') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre_conductor">Nombre del Conductor</label>
                                        <input class="form-control {{ $errors->has('nombre_conductor') ? 'is-invalid' : '' }}" type="text" name="nombre_conductor" id="nombre_conductor" value="{{ old('nombre_conductor', $proyecto->fasedespacho->nombre_conductor ?? '') }}">
                                        @if($errors->has('nombre_conductor'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('nombre_conductor') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="celular_conductor">Número de Celular del Conductor</label>
                                        <input class="form-control {{ $errors->has('celular_conductor') ? 'is-invalid' : '' }}" type="text" name="celular_conductor" id="celular_conductor" value="{{ old('celular_conductor', $proyecto->fasedespacho->celular_conductor ?? '') }}">
                                        @if($errors->has('celular_conductor'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('celular_conductor') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre_acompañantes">Nombre de los Acompañantes</label>
                                        <input class="form-control {{ $errors->has('nombre_acompañantes') ? 'is-invalid' : '' }}" type="text" name="nombre_acompañantes" id="nombre_acompañantes" value="{{ old('nombre_acompañantes', $proyecto->fasedespacho->nombre_acompañantes ?? '') }}">
                                        @if($errors->has('nombre_acompañantes'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('nombre_acompañantes') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">                    
                                    <h4>Checklist Despacho</h4>
                                    <div class="form-check">
                                        @if (!$proyecto->fasedespacho)
                                            <input class="form-check-input carguio" type="checkbox" value="1" id="carguio" name="carguio">
                                            <input class="form-check-input carguio2" type="hidden" value="0" id="carguio" name="carguio">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Carguío
                                            </label>
                                        @else
                                            @if(  $proyecto->fasedespacho->carguio == 1)
                                            <input class="form-check-input carguio" type="checkbox" value="1" id="carguio" name="carguio" checked>
                                            <input class="form-check-input carguio2" type="hidden" value="0" id="carguio" name="carguio">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Carguío
                                            </label>
                                        @else
                                            <input class="form-check-input carguio" type="checkbox" value="1" id="carguio" name="carguio">
                                            <input class="form-check-input carguio2" type="hidden" value="0" id="carguio" name="carguio">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Carguío
                                            </label>
                                        @endif
                                        @endif
                                        

                                    </div>
                                    <div class="form-check">
                                        @if (!$proyecto->fasedespacho)
                                            <input class="form-check-input transporte" type="checkbox" value="1" id="transporte" name="transporte">
                                            <input class="form-check-input transporte2" type="hidden" value="0" id="transporte" name="transporte">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Transporte
                                            </label>
                                        @else
                                            @if($proyecto->fasedespacho->transporte == 1)
                                            <input class="form-check-input transporte" type="checkbox" value="1" id="transporte" name="transporte" checked>
                                            <input class="form-check-input transporte2" type="hidden" value="0" id="transporte" name="transporte">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Transporte
                                            </label>
                                        @else
                                            <input class="form-check-input transporte" type="checkbox" value="1" id="transporte" name="transporte">
                                            <input class="form-check-input transporte2" type="hidden" value="0" id="transporte" name="transporte">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Transporte
                                            </label>
                                        @endif
                                        @endif
                                        
                                    </div>
                                    <div class="form-check">
                                        @if (!$proyecto->fasedespacho)
                                            <input class="form-check-input entrega" type="checkbox" value="1" id="entrega" name="entrega">
                                            <input class="form-check-input entrega2" type="hidden" value="0" id="entrega" name="entrega">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Entrega
                                            </label>
                                        @else
                                            @if($proyecto->fasedespacho->entrega == 1)
                                            <input class="form-check-input entrega" type="checkbox" value="1" id="entrega" name="entrega" checked>
                                            <input class="form-check-input entrega2" type="hidden" value="0" id="entrega" name="entrega">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Entrega
                                            </label>
                                        @else
                                            <input class="form-check-input entrega" type="checkbox" value="1" id="entrega" name="entrega">
                                            <input class="form-check-input entrega2" type="hidden" value="0" id="entrega" name="entrega">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Entrega
                                            </label>
                                        @endif
                                        @endif
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="guia_despacho">{{ trans('cruds.fasedespacho.fields.guia_despacho') }}<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .PDF)</strong></small></label>
                                    <div class="needsclick dropzone {{ $errors->has('guia_despacho') ? 'is-invalid' : '' }}" id="guia_despacho-dropzone">
                                    </div>
                                    @if($errors->has('guia_despacho'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('guia_despacho') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasedespacho.fields.guia_despacho_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('cruds.fasedespacho.fields.estado_instalacion') }}</label>
                                    <select class="form-control {{ $errors->has('estado_instalacion') ? 'is-invalid' : '' }}" name="estado_instalacion" id="estado_instalacion">
                                        <option value disabled {{ old('estado_instalacion', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }} una alternativa</option>
                                        @foreach(App\Models\Fasedespacho::ESTADO_INSTALACION_SELECT as $key => $label)
                                            <option value="{{ $key }}" {{ old('estado_instalacion', $proyecto->fasedespacho->estado_instalacion ?? '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('estado_instalacion'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('estado_instalacion') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasedespacho.fields.estado_instalacion_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <h4>Instalación</h4>
                                    <div class="form-check">
                                        @if (!$proyecto->fasedespacho)
                                            <input class="form-check-input distribucion" type="checkbox" value="1" id="distribucion" name="distribucion">
                                            <input class="form-check-input distribucion2" type="hidden" value="0" id="distribucion" name="distribucion">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Distribución
                                            </label>
                                        @else
                                            @if($proyecto->fasedespacho->distribucion == 1)
                                            <input class="form-check-input distribucion" type="checkbox" value="1" id="distribucion" name="distribucion" checked>
                                            <input class="form-check-input distribucion2" type="hidden" value="0" id="distribucion" name="distribucion">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Distribución
                                            </label>
                                            @else
                                            <input class="form-check-input distribucion" type="checkbox" value="1" id="distribucion" name="distribucion">
                                            <input class="form-check-input distribucion2" type="hidden" value="0" id="distribucion" name="distribucion">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Distribución
                                            </label>
                                        @endif
                                        @endif
                                        
                                      </div>
                                      <div class="form-check">
                                        @if(!$proyecto->fasedespacho)
                                         <input class="form-check-input armado" type="checkbox" value="1" id="armado" name="armado" >
                                         <input class="form-check-input armado2" type="hidden" value="0" id="armado" name="armado">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Armado
                                            </label>
                                        @else
                                            @if($proyecto->fasedespacho->armado == 1)
                                                <input class="form-check-input armado" type="checkbox" value="1" id="armado" name="armado" checked>
                                                <input class="form-check-input armado2" type="hidden" value="0" id="armado" name="armado">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                Armado
                                                </label>
                                            @else
                                                <input class="form-check-input armado" type="checkbox" value="1" id="armado" name="armado" >
                                                <input class="form-check-input armado2" type="hidden" value="0" id="armado" name="armado">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                Armado
                                                </label>
                                            @endif
                                        @endif
                                        
                                      </div>
                                      <div class="form-check">
                                        @if (!$proyecto->fasedespacho)
                                            <input class="form-check-input entrega_conforme" type="checkbox" value="1" id="entrega_conforme" name="entrega_conforme">
                                            <input class="form-check-input entrega_conforme2" type="hidden" value="0" id="entrega_conforme" name="entrega_conforme">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Entrega conforme
                                            </label>
                                            @else
                                            @if($proyecto->fasedespacho->entrega_conforme == 1)
                                            <input class="form-check-input entrega_conforme" type="checkbox" value="1" id="entrega_conforme" name="entrega_conforme" checked>
                                            <input class="form-check-input entrega_conforme2" type="hidden" value="0" id="entrega_conforme" name="entrega_conforme">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Entrega conforme
                                            </label>
                                            @else
                                            <input class="form-check-input entrega_conforme" type="checkbox" value="1" id="entrega_conforme" name="entrega_conforme">
                                            <input class="form-check-input entrega_conforme2" type="hidden" value="0" id="entrega_conforme" name="entrega_conforme">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Entrega conforme
                                            </label>
                                        @endif
                                        @endif
                                        
                                      </div>
                                </div>
                                <div class="form-group">
                                    <label for="comentario">{{ trans('cruds.fasedespacho.fields.comentario') }}</label>
                                    <textarea class="form-control ckeditor {{ $errors->has('comentario') ? 'is-invalid' : '' }}" name="comentario" id="comentario">{!! old('comentario', $proyecto->fasedespacho->comentario ?? '') !!}</textarea>
                                    @if($errors->has('comentario'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('comentario') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasedespacho.fields.comentario_helper') }}</span>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('cruds.fasedespacho.fields.recibe_conforme') }}</label>
                                    <select class="form-control {{ $errors->has('recibe_conforme') ? 'is-invalid' : '' }}" name="recibe_conforme" id="recibe_conforme">
                                        <option value disabled {{ old('recibe_conforme', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }} una alternativa</option>
                                        @foreach(App\Models\Fasedespacho::RECIBE_CONFORME_SELECT as $key => $label)
                                            <option value="{{ $key }}" {{ old('recibe_conforme', $proyecto->fasedespacho->recibe_conforme ?? '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('recibe_conforme'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('recibe_conforme') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasedespacho.fields.recibe_conforme_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="galeria_estado_muebles">Galería Mobiliario entregado<br><small style="color:rgba(255, 0, 0, 0.562);"><strong>(Archivos Permitidos: .JPG .PNG)</strong></small></label>
                                    <div class="needsclick dropzone {{ $errors->has('galeria_estado_muebles') ? 'is-invalid' : '' }}" id="galeria_estado_muebles-dropzone">
                                    </div>
                                    @if($errors->has('galeria_estado_muebles'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('galeria_estado_muebles') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.fasedespacho.fields.galeria_estado_muebles_helper') }}</span>
                                </div>
                               
                                <div class="form-group">
                                    <input class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" type="hidden" name="estado" id="estado" value="{{ old('estado', $proyecto->fasedespacho->estado ?? '') }}">
                                </div>

                                
                                <div class="form-group">
                                    <button class="btn btn-danger" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </form>
                            
                        </div>
                        <div class="carousel-item my-5" id="slide_fase_7">
                            <div class="form-group text-center">
                                <h2>FASE POSTVENTA</h2>
                            </div>

                            <form method="POST" action="{{ route("admin.proyectos.storeFasepostventa") }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_proyecto_id" id="id_proyecto_id" value="{{$proyecto->id}}"> 
                                <input type="hidden" name="id_fasepostventa" id="id_fasepostventa" value="{{$proyecto->id_fasepostventa}}"> 
                                <div class="form-group">
                                    <label for="estado">{{ trans('cruds.fasePostventum.fields.estado') }}</label>
                                    <select class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" name="estado" id="estado">
                                        @foreach(App\Models\FasePostventum::ESTADO_SELECT as $key => $label)
                                            <option value="{{ $key }}" {{ old('estado', $proyecto->fasepostventa->estado ?? '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-danger" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
    /*$(document).ready(()=>{
        let tipoProyecto;
        //$('#monto_mobiliario').prop('readonly',true);
        $('#tipo_proyecto').on('change',function(){
            tipoProyecto = $(this).val();
            if(tipoProyecto=='Fábrica' || tipoProyecto=='Sillas y Fábrica'){
                $('#monto_mobiliario').prop('readonly',false);
            }else{
                $('#monto_mobiliario').val('');
                $('#monto_mobiliario').prop('readonly',true);
            }
        })

    })*/
    $(document).ready(()=>{
        let tipoProyecto;
        $('#div-monto-mobiliario').hide();
        const tipo_proyecto = $('#tipo_proyecto').val();
        if(tipo_proyecto == 'Mobiliario'){
            $('#div-monto-mobiliario').show();
        }else{
            $('#div-monto-mobiliario').hide();
        }
        
        /*$('#tipo_proyecto').on('change',function(){
            tipoProyecto = $(this).val();
            if(tipoProyecto=='Fábrica' || tipoProyecto=='Sillas y Fábrica'){
                $('#div-monto-mobiliario').show();
            }else{
                $('#div-monto-mobiliario').hide();
            }
        })*/
    })
        $('#form-despachos').on('submit', function(e) {
            if($('.carguio').is(':checked')){
                $('.carguio2').attr('disabled', true);
            }else{
                $('.carguio2').attr('disabled', false);
            }

            if($('.transporte').is(':checked')){
                $('.transporte2').attr('disabled', true);
            }else{
                $('.transporte2').attr('disabled', false);
            }

            if($('.entrega').is(':checked')){
                $('.entrega2').attr('disabled', true);
            }else{
                $('.entrega2').attr('disabled', false);
            }

            if($('.distribucion').is(':checked')){
                $('.distribucion2').attr('disabled', true);
            }else{
                $('.distribucion2').attr('disabled', false);
            }

            if($('.armado').is(':checked')){
                $('.armado2').attr('disabled', true);
            }else{
                $('.armado2').attr('disabled', false);
            }

            if($('.entrega_conforme').is(':checked')){
                $('.entrega_conforme2').attr('disabled', true);
            }else{
                $('.entrega_conforme2').attr('disabled', false);
            }
        });

        var fase = "<?php echo $proyecto->fase; ?>";
            if(fase == "Fase Diseño"){
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
            }else if(fase == "Fase Propuesta Comercial"){
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
            }else if(fase == "Fase Contable"){
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
            }else if(fase == "Fase Comercial"){
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
            }else if(fase == "Fase Fabricacion"){
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
            }else if(fase == "Fase Despacho"){
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
            }else if(fase == "Fase Postventa"){
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

            $('#fase_3').on('click', function() {
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
            });

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
                    $('#slide_fase_2').css({ 'opacity': 0, 'position': 'relative', 'left': '100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                }else if(nextPhase.attr('id') === 'fase_3'){
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').css({ 'opacity': 0, 'position': 'relative', 'left': '100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                }else if(nextPhase.attr('id') === 'fase_4'){
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').css({ 'opacity': 0, 'position': 'relative', 'left': '100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                }else if(nextPhase.attr('id') === 'fase_5'){
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').css({ 'opacity': 0, 'position': 'relative', 'left': '100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                }else if(nextPhase.attr('id') === 'fase_6'){
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').css({ 'opacity': 0, 'position': 'relative', 'left': '100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
                    $('#slide_fase_7').hide();
                }else if (nextPhase.attr('id') === 'fase_7') {
                    $('#fase_next').hide();
                    $('#fase_prev').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').css({ 'opacity': 0, 'position': 'relative', 'left': '100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
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
                    $('#slide_fase_1').css({ 'opacity': 0, 'position': 'relative', 'left': '-100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();
                }else if(prevPhase.attr('id') === 'fase_2'){ 
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').css({ 'opacity': 0, 'position': 'relative', 'left': '-100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();                
                }else if(prevPhase.attr('id') === 'fase_3'){
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').css({ 'opacity': 0, 'position': 'relative', 'left': '-100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();                  
                }else if(prevPhase.attr('id') === 'fase_4'){
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').css({ 'opacity': 0, 'position': 'relative', 'left': '-100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();                  
                }else if(prevPhase.attr('id') === 'fase_5'){
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').css({ 'opacity': 0, 'position': 'relative', 'left': '-100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').hide();                   
                }else if (prevPhase.attr('id') === 'fase_6') {
                    $('#fase_prev').show();
                    $('#fase_next').show();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').css({ 'opacity': 0, 'position': 'relative', 'left': '-100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();
                    $('#slide_fase_7').hide();                     
                }else if (prevPhase.attr('id') === 'fase_7') {
                    $('#fase_prev').show();
                    $('#fase_next').hide();
                    $('#slide_fase_1').hide();
                    $('#slide_fase_2').hide();
                    $('#slide_fase_3').hide();
                    $('#slide_fase_4').hide();
                    $('#slide_fase_5').hide();
                    $('#slide_fase_6').hide();
                    $('#slide_fase_7').css({ 'opacity': 0, 'position': 'relative', 'left': '-100%' })
                .animate({ 'opacity': 1, 'left': '0' }, 500).show();                   
                }

                
            });
        });
    </script>

    <script>
        /*FASE DISEÑO*/
        var uploadedImagenesMap = {}
        Dropzone.options.imagenesDropzone = {
        url: '{{ route('admin.fase-disenos.storeMedia') }}',
        maxFilesize: 5, // MB
        acceptedFiles: '.jpg,.png,.dwg,.xlsx,.pdf',
        addRemoveLinks: true,
        dictInvalidFileType: 'No puedes subir archivos de este tipo.',
        dictCancelUpload: 'Cancelar subida',
        dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
        dictRemoveFile: 'Eliminar archivo',
        dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 30
        },
        success: function (file, response) {
        $('form').append('<input type="hidden" name="imagenes[]" value="' + response.name + '">')
        uploadedImagenesMap[file.name] = response.name
        },
        removedfile: function (file) {
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedImagenesMap[file.name]
        }
        $('form').find('input[name="imagenes[]"][value="' + name + '"]').remove()
        },
        init: function () {
        @if(isset($proyecto->fasediseno) && $proyecto->fasediseno->imagenes)
            var files =
                {!! json_encode($proyecto->fasediseno->imagenes) !!}
                for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="imagenes[]" value="' + file.file_name + '">')
                 // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#imagenes-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: files[i].original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
                }
        @endif
        },
        error: function (file, response) {
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

        var uploadedPropuestaMap = {}
        Dropzone.options.propuestaDropzone = {
        url: '{{ route('admin.fase-disenos.storeMedia') }}',
        maxFilesize: 5, // MB
        acceptedFiles: '.pdf',
        addRemoveLinks: true,
        dictInvalidFileType: 'No puedes subir archivos de este tipo.',
        dictCancelUpload: 'Cancelar subida',
        dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
        dictRemoveFile: 'Eliminar archivo',
        dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4
        },
        success: function (file, response) {
        $('form').append('<input type="hidden" name="propuesta[]" value="' + response.name + '">')
        uploadedPropuestaMap[file.name] = response.name
        },
        removedfile: function (file) {
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedPropuestaMap[file.name]
        }
        $('form').find('input[name="propuesta[]"][value="' + name + '"]').remove()
        },
        init: function () {
        @if(isset($proyecto->fasediseno) && $proyecto->fasediseno->propuesta)
            var files =
                {!! json_encode($proyecto->fasediseno->propuesta) !!}
                for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="propuesta[]" value="' + file.file_name + '">')
                 // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#propuesta-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: files[i].original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
                }
        @endif
        },
        error: function (file, response) {
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
    </script>

    <script>
        /* FASE PROPUESTA COMERCIAL */
         var uploadedCotizacionMap = {}
         Dropzone.options.cotizacionDropzone = {
            url: '{{ route('admin.fasecomercials.storeMedia') }}',
            maxFilesize: 4, // MB
            //maxFiles: 1,
            addRemoveLinks: true,
            acceptedFiles: '.pdf,.xlsx',
            dictInvalidFileType: 'No puedes subir archivos de este tipo.',
            dictCancelUpload: 'Cancelar subida',
            dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
            dictRemoveFile: 'Eliminar archivo',
            dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
            size: 30
            },
            success: function (file, response) {
            $('form').find('input[name="cotizacion"]').remove()
            $('form').append('<input type="hidden" name="cotizacion[]" value="' + response.name + '">')
            },
            removedfile: function (file) {
                console.log(file);
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedCotizacionMap[file.name]
            }
            $('form').find('input[name="cotizacion[]"][value="' + name + '"]').remove()
            },
            init: function () {
            @if(isset($proyecto->faseComercial) && $proyecto->faseComercial->cotizacion)
            var files = {!! json_encode($proyecto->faseComercial->cotizacion) !!}
            for (var i in files){
                var file = files[i]
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                //file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="cotizacion[]" value="' + file.file_name + '">')
                 // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#cotizacion-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: file.original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
            }
                
            @endif
            },
            error: function (file, response) {
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
        
        
        
        Dropzone.options.ocDropzone = {
        url: '{{ route('admin.fasecomercials.storeMedia') }}',
        maxFilesize: 4, // MB
        maxFiles: 1,
        addRemoveLinks: true,
        acceptedFiles: '.pdf',
        dictInvalidFileType: 'No puedes subir archivos de este tipo.',
        dictCancelUpload: 'Cancelar subida',
        dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
        dictRemoveFile: 'Eliminar archivo',
        dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4
        },
        success: function (file, response) {
        $('form').find('input[name="oc"]').remove()
        $('form').append('<input type="hidden" name="oc" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="oc"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
        @if(isset($proyecto->faseComercial) && $proyecto->faseComercial->oc)
        var file = {!! json_encode($proyecto->faseComercial->oc) !!}
            this.options.addedfile.call(this, file)
        file.previewElement.classList.add('dz-complete')
        $('form').append('<input type="hidden" name="oc" value="' + file.file_name + '">')
        this.options.maxFiles = this.options.maxFiles - 1
         // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#oc-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: file.original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
        @endif
        },
        error: function (file, response) {
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
    </script>

    <script>
        /* FASE CONTABLE */
        var uploadedAnticipo50Map = {}
        Dropzone.options.anticipo50Dropzone = {
        url: '{{ route('admin.fasecontables.storeMedia') }}',
        maxFilesize: 4, // MB
        //maxFiles: 1,
        acceptedFiles: '.pdf',
        addRemoveLinks: true,
        dictInvalidFileType: 'No puedes subir archivos de este tipo.',
        dictCancelUpload: 'Cancelar subida',
        dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
        dictRemoveFile: 'Eliminar archivo',
        dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4
        },
        success: function (file, response) {
        $('form').append('<input type="hidden" name="anticipo_50[]" value="' + response.name + '">')
        uploadedAnticipo50Map[file.name] = response.name
        },
       removedfile: function (file) {
                console.log(file);
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedAnticipo50Map[file.name]
            }
            $('form').find('input[name="anticipo_50[]"][value="' + name + '"]').remove()
        },
        init: function () {
        @if(isset($proyecto->fasecontable) && $proyecto->fasecontable->anticipo_50)
        var files = {!! json_encode($proyecto->fasecontable->anticipo_50) !!}
            for (var i in files) {
            var file = files[i]
            this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="anticipo_50[]" value="' + file.file_name + '">')
            // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#anticipo_50-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: files[i].original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
            }
        @endif
        },
        error: function (file, response) {
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
        Dropzone.options.anticipo40Dropzone = {
        url: '{{ route('admin.fasecontables.storeMedia') }}',
        maxFilesize: 4, // MB
        maxFiles: 1,
        acceptedFiles: '.pdf',
        addRemoveLinks: true,
        dictInvalidFileType: 'No puedes subir archivos de este tipo.',
        dictCancelUpload: 'Cancelar subida',
        dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
        dictRemoveFile: 'Eliminar archivo',
        dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4
        },
        success: function (file, response) {
        $('form').find('input[name="anticipo_40"]').remove()
        $('form').append('<input type="hidden" name="anticipo_40" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="anticipo_40"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
        @if(isset($proyecto->fasecontable) && $proyecto->fasecontable->anticipo_40)
        var file = {!! json_encode($proyecto->fasecontable->anticipo_40) !!}
            this.options.addedfile.call(this, file)
        file.previewElement.classList.add('dz-complete')
        $('form').append('<input type="hidden" name="anticipo_40" value="' + file.file_name + '">')
        this.options.maxFiles = this.options.maxFiles - 1
         // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#anticipo_40-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: file.original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
        @endif
        },
        error: function (file, response) {
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

        Dropzone.options.anticipo10Dropzone = {
        url: '{{ route('admin.fasecontables.storeMedia') }}',
        maxFilesize: 4, // MB
        maxFiles: 1,
        acceptedFiles: '.pdf',
        addRemoveLinks: true,
        dictInvalidFileType: 'No puedes subir archivos de este tipo.',
        dictCancelUpload: 'Cancelar subida',
        dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
        dictRemoveFile: 'Eliminar archivo',
        dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4
        },
        success: function (file, response) {
        $('form').find('input[name="anticipo_10"]').remove()
        $('form').append('<input type="hidden" name="anticipo_10" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="anticipo_10"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
        @if(isset($proyecto->fasecontable) && $proyecto->fasecontable->anticipo_10)
        var file = {!! json_encode($proyecto->fasecontable->anticipo_10) !!}
            this.options.addedfile.call(this, file)
        file.previewElement.classList.add('dz-complete')
        $('form').append('<input type="hidden" name="anticipo_10" value="' + file.file_name + '">')
        this.options.maxFiles = this.options.maxFiles - 1
         // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#anticipo_10-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: file.original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
        @endif
        },
        error: function (file, response) {
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
    </script>

    <script>
        /* FASE DESPACHOS */
        
        var uploadedGuiaDespachoMap = {}
        Dropzone.options.guiaDespachoDropzone = {
        url: '{{ route('admin.fasedespachos.storeMedia') }}',
        maxFilesize: 4, // MB
        acceptedFiles: '.pdf',
        //maxFiles: 1,
        addRemoveLinks: true,
        dictInvalidFileType: 'No puedes subir archivos de este tipo.',
        dictCancelUpload: 'Cancelar subida',
        dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
        dictRemoveFile: 'Eliminar archivo',
        dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4,
        },
         success: function (file, response) {
        $('form').append('<input type="hidden" name="guia_despacho[]" value="' + response.name + '">')
        uploadedGuiaDespachoMap[file.name] = response.name
        },
        removedfile: function (file) {
        console.log(file)
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedGuiaDespachoMap[file.name]
        }
        $('form').find('input[name="guia_despacho[]"][value="' + name + '"]').remove()
        },
        init: function () {
        @if(isset($proyecto->fasedespacho) && $proyecto->fasedespacho->guia_despacho)
        var files = {!! json_encode($proyecto->fasedespacho->guia_despacho) !!}
            for (var i in files) {
            var file = files[i]
            this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="guia_despacho[]" value="' + file.file_name + '">')
            // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#guia_despacho-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: files[i].original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
            }
        @endif
        },
        error: function (file, response) {
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
        
        $(document).ready(function () {
        function SimpleUploadAdapter(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
            return {
                upload: function() {
                return loader.file
                    .then(function (file) {
                    return new Promise(function(resolve, reject) {
                        // Init request
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', '{{ route('admin.fasedespachos.storeCKEditorImages') }}', true);
                        xhr.setRequestHeader('x-csrf-token', window._token);
                        xhr.setRequestHeader('Accept', 'application/json');
                        xhr.responseType = 'json';

                        // Init listeners
                        var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                        xhr.addEventListener('error', function() { reject(genericErrorText) });
                        xhr.addEventListener('abort', function() { reject() });
                        xhr.addEventListener('load', function() {
                        var response = xhr.response;

                        if (!response || xhr.status !== 201) {
                            return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                        }

                        $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                        resolve({ default: response.url });
                        });

                        if (xhr.upload) {
                        xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                            loader.uploadTotal = e.total;
                            loader.uploaded = e.loaded;
                            }
                        });
                        }

                        // Send request
                        var data = new FormData();
                        data.append('upload', file);
                        data.append('crud_id', '{{ $proyecto->fasedespacho->id ?? 0 }}');
                        xhr.send(data);
                    });
                    })
                }
            };
            }
        }

        var allEditors = document.querySelectorAll('.ckeditor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(
            allEditors[i], {
                extraPlugins: [SimpleUploadAdapter]
            }
            );
        }
        });
        
        var uploadedGaleriaEstadoMueblesMap = {}
        Dropzone.options.galeriaEstadoMueblesDropzone = {
        url: '{{ route('admin.fasedespachos.storeMedia') }}',
        maxFilesize: 4, // MB
        acceptedFiles: '.jpg,.png',
        addRemoveLinks: true,
        dictInvalidFileType: 'No puedes subir archivos de este tipo.',
        dictCancelUpload: 'Cancelar subida',
        dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
        dictRemoveFile: 'Eliminar archivo',
        dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4,
        width: 4096,
        height: 4096
        },
        success: function (file, response) {
        $('form').append('<input type="hidden" name="galeria_estado_muebles[]" value="' + response.name + '">')
        uploadedGaleriaEstadoMueblesMap[file.name] = response.name
        },
        removedfile: function (file) {
        console.log(file)
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedGaleriaEstadoMueblesMap[file.name]
        }
        $('form').find('input[name="galeria_estado_muebles[]"][value="' + name + '"]').remove()
        },
        init: function () {
        @if(isset($proyecto->fasedespacho) && $proyecto->fasedespacho->galeria_estado_muebles)
        var files = {!! json_encode($proyecto->fasedespacho->galeria_estado_muebles) !!}
            for (var i in files) {
            var file = files[i]
            this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="galeria_estado_muebles[]" value="' + file.file_name + '">')
            // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#galeria_estado_muebles-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: files[i].original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
            }
        @endif
        },
        error: function (file, response) {
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

    </script>

    <script>
        /* FASE ACUERDO COMERCIAL */
        Dropzone.options.notaVentaDropzone = {
            url: '{{ route('admin.fasecomercialproyectos.storeMedia') }}',
            maxFilesize: 4, // MB
            maxFiles: 1,
            acceptedFiles: '.pdf',
            addRemoveLinks: true,
            dictInvalidFileType: 'No puedes subir archivos de este tipo.',
            dictCancelUpload: 'Cancelar subida',
            dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
            dictRemoveFile: 'Eliminar archivo',
            dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
            size: 4
            },
            success: function (file, response) {
            $('form').find('input[name="nota_venta"]').remove()
            $('form').append('<input type="hidden" name="nota_venta" value="' + response.name + '">')
            },
            removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="nota_venta"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
            },
            init: function () {
            @if(isset($proyecto->fasecomercialproyecto) && $proyecto->fasecomercialproyecto->nota_venta)
            var file = {!! json_encode($proyecto->fasecomercialproyecto->nota_venta) !!}
                this.options.addedfile.call(this, file)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="nota_venta" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
            // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#nota_venta-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: file.original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
            @endif
            },
            error: function (file, response) {
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

        var uploadedFacturasMap = {}
        Dropzone.options.facturasDropzone = {
            url: '{{ route('admin.fasecomercialproyectos.storeMedia') }}',
            maxFilesize: 20, // MB
            //maxFiles: 1,
            acceptedFiles: '.pdf',
            addRemoveLinks: true,
            dictInvalidFileType: 'No puedes subir archivos de este tipo.',
            dictCancelUpload: 'Cancelar subida',
            dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
            dictRemoveFile: 'Eliminar archivo',
            dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
            size: 30
            },
            success: function (file, response) {
            $('form').append('<input type="hidden" name="facturas[]" value="' + response.name + '">')
            uploadedFacturasMap[file.name] = response.name
            },
            removedfile: function (file) {
            console.log(file);
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedFacturasMap[file.name]
            }
            $('form').find('input[name="facturas[]"][value="' + name + '"]').remove()
            },
            init: function () {
            @if(isset($proyecto->fasecomercialproyecto) && $proyecto->fasecomercialproyecto->facturas)
            var files = {!! json_encode($proyecto->fasecomercialproyecto->facturas) !!}
                for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="facturas[]" value="' + file.file_name + '">')
                // Obtener el último elemento <a> con la clase "dz-remove"
                    var lastAnchor = $('#facturas-dropzone').find('a.dz-remove').last();
                    
                    // Crear el nuevo enlace
                    var newLink = $('<a>', {
                        href: files[i].original_url,
                        class: 'dz-ver',
                        target: '_blank',
                        text: 'Ver Archivo'
                    });
                    
                    // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                    lastAnchor.after(newLink);
                }
            @endif
            },
            error: function (file, response) {
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

        Dropzone.options.creditoDropzone = {
            url: '{{ route('admin.fasecomercialproyectos.storeMedia') }}',
            maxFilesize: 4, // MB
            maxFiles: 1,
            acceptedFiles: '.pdf',
            addRemoveLinks: true,
            dictInvalidFileType: 'No puedes subir archivos de este tipo.',
            dictCancelUpload: 'Cancelar subida',
            dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
            dictRemoveFile: 'Eliminar archivo',
            dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
            size: 4
            },
            success: function (file, response) {
            $('form').find('input[name="credito"]').remove()
            $('form').append('<input type="hidden" name="credito" value="' + response.name + '">')
            },
            removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="credito"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
            },
            init: function () {
            @if(isset($proyecto->fasecomercialproyecto) && $proyecto->fasecomercialproyecto->credito)
            var file = {!! json_encode($proyecto->fasecomercialproyecto->credito) !!}
                this.options.addedfile.call(this, file)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="credito" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
             // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#credito-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: file.original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
            @endif
            },
            error: function (file, response) {
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

        

    </script>

    <script>
        /* FASE FABRICACIÓN */
        var uploadedOcProveedoresMap = {}
        Dropzone.options.ocProveedoresDropzone = {
        url: '{{ route('admin.fasefabricas.storeMedia') }}',
        maxFilesize: 4, // MB
        acceptedFiles: '.pdf',
        addRemoveLinks: true,
        dictInvalidFileType: 'No puedes subir archivos de este tipo.',
        dictCancelUpload: 'Cancelar subida',
        dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
        dictRemoveFile: 'Eliminar archivo',
        dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4
        },
        success: function (file, response) {
        $('form').append('<input type="hidden" name="oc_proveedores[]" value="' + response.name + '">')
        uploadedOcProveedoresMap[file.name] = response.name
        },
        removedfile: function (file) {
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedOcProveedoresMap[file.name]
        }
        $('form').find('input[name="oc_proveedores[]"][value="' + name + '"]').remove()
        },
        init: function () {
        @if(isset($proyecto->fasefabrica) && $proyecto->fasefabrica->oc_proveedores)
            var files =
                {!! json_encode($proyecto->fasefabrica->oc_proveedores) !!}
                for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="oc_proveedores[]" value="' + file.file_name + '">')
                // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#oc_proveedores-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: files[i].original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
                }
        @endif
        },
        error: function (file, response) {
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
        
        var uploadedGaleriaEstadoEntregaMap = {}
        Dropzone.options.galeriaEstadoEntregaDropzone = {
        url: '{{ route('admin.fasefabricas.storeMedia') }}',
        maxFilesize: 4, // MB
        acceptedFiles: '.jpg,.png,.dwg,.xlsx',
        addRemoveLinks: true,
        dictInvalidFileType: 'No puedes subir archivos de este tipo.',
        dictCancelUpload: 'Cancelar subida',
        dictCancelUploadConfirmation: '¿Estás seguro que quieres cancelar esta subida?',
        dictRemoveFile: 'Eliminar archivo',
        dictMaxFilesExceeded: 'Ya has alcanzado el límite de archivos permitidos.',
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4,
        width: 4096,
        height: 4096
        },
        success: function (file, response) {
        $('form').append('<input type="hidden" name="galeria_estado_entrega[]" value="' + response.name + '">')
        uploadedGaleriaEstadoEntregaMap[file.name] = response.name
        },
        removedfile: function (file) {
        console.log(file)
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedGaleriaEstadoEntregaMap[file.name]
        }
        $('form').find('input[name="galeria_estado_entrega[]"][value="' + name + '"]').remove()
        },
        init: function () {
        @if(isset($proyecto->fasefabrica) && $proyecto->fasefabrica->galeria_estado_entrega)
        var files = {!! json_encode($proyecto->fasefabrica->galeria_estado_entrega) !!}
            for (var i in files) {
            var file = files[i]
            this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="galeria_estado_entrega[]" value="' + file.file_name + '">')
            // Obtener el último elemento <a> con la clase "dz-remove"
                var lastAnchor = $('#galeria_estado_entrega-dropzone').find('a.dz-remove').last();
                
                // Crear el nuevo enlace
                var newLink = $('<a>', {
                    href: files[i].original_url,
                    class: 'dz-ver',
                    target: '_blank',
                    text: 'Ver Archivo'
                });
                
                // Insertar el nuevo enlace después del último elemento <a> con la clase "dz-remove"
                lastAnchor.after(newLink);
            }
        @endif
        },
        error: function (file, response) {
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

    </script>

    <script>
        Dropzone.options.presupuestoDropzone = {
        url: '{{ route('admin.carpetaclientes.storeMedia') }}',
        maxFilesize: 4, // MB
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4
        },
        success: function (file, response) {
        $('form').find('input[name="presupuesto"]').remove()
        $('form').append('<input type="hidden" name="presupuesto" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="presupuesto"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
        @if(isset($proyecto->carpetacliente) && $proyecto->carpetacliente->presupuesto)
            var file = {!! json_encode($proyecto->carpetacliente->presupuesto) !!}
                this.options.addedfile.call(this, file)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="presupuesto" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
        @endif
            },
            error: function (file, response) {
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
    </script>

    <script>
        var uploadedPlanoMap = {}
        Dropzone.options.planoDropzone = {
            url: '{{ route('admin.carpetaclientes.storeMedia') }}',
            maxFilesize: 8, // MB
            addRemoveLinks: true,
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
            size: 8
            },
            success: function (file, response) {
            $('form').append('<input type="hidden" name="plano[]" value="' + response.name + '">')
            uploadedPlanoMap[file.name] = response.name
            },
            removedfile: function (file) {
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedPlanoMap[file.name]
            }
                $('form').find('input[name="plano[]"][value="' + name + '"]').remove()
        },
        init: function () {
            @if(isset($proyecto->carpetacliente) && $proyecto->carpetacliente->plano)
            var files =
                {!! json_encode($proyecto->carpetacliente->plano) !!}
                for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="plano[]" value="' + file.file_name + '">')
                }
            @endif
            },
            error: function (file, response) {
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
    </script>

    <script>
        var uploadedFfttMap = {}
        Dropzone.options.ffttDropzone = {
        url: '{{ route('admin.carpetaclientes.storeMedia') }}',
        maxFilesize: 8, // MB
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 8
        },
        success: function (file, response) {
        $('form').append('<input type="hidden" name="fftt[]" value="' + response.name + '">')
        uploadedFfttMap[file.name] = response.name
        },
        removedfile: function (file) {
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedFfttMap[file.name]
        }
        $('form').find('input[name="fftt[]"][value="' + name + '"]').remove()
        },
        init: function () {
        @if(isset($proyecto->carpetacliente) && $proyecto->carpetacliente->fftt)
            var files =
                {!! json_encode($proyecto->carpetacliente->fftt) !!}
                for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="fftt[]" value="' + file.file_name + '">')
                }
        @endif
        },
            error: function (file, response) {
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
    </script>

    <script>
        var uploadedPresentacionMap = {}
        Dropzone.options.presentacionDropzone = {
        url: '{{ route('admin.carpetaclientes.storeMedia') }}',
        maxFilesize: 8, // MB
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 8
        },
        success: function (file, response) {
        $('form').append('<input type="hidden" name="presentacion[]" value="' + response.name + '">')
        uploadedPresentacionMap[file.name] = response.name
        },
        removedfile: function (file) {
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedPresentacionMap[file.name]
        }
        $('form').find('input[name="presentacion[]"][value="' + name + '"]').remove()
        },
        init: function () {
        @if(isset($proyecto->carpetacliente) && $proyecto->carpetacliente->presentacion)
            var files =
                {!! json_encode($proyecto->carpetacliente->presentacion) !!}
                for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="presentacion[]" value="' + file.file_name + '">')
                }
        @endif
        },
        error: function (file, response) {
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
    </script>

    <script>
        Dropzone.options.rectificacionDropzone = {
        url: '{{ route('admin.carpetaclientes.storeMedia') }}',
        maxFilesize: 8, // MB
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 8
        },
        success: function (file, response) {
        $('form').find('input[name="rectificacion"]').remove()
        $('form').append('<input type="hidden" name="rectificacion" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="rectificacion"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
        @if(isset($proyecto->carpetacliente) && $proyecto->carpetacliente->rectificacion)
        var file = {!! json_encode($proyecto->carpetacliente->rectificacion) !!}
            this.options.addedfile.call(this, file)
        file.previewElement.classList.add('dz-complete')
        $('form').append('<input type="hidden" name="rectificacion" value="' + file.file_name + '">')
        this.options.maxFiles = this.options.maxFiles - 1
        @endif
        },
        error: function (file, response) {
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
    </script>

    <script>
        Dropzone.options.nbDropzone = {
        url: '{{ route('admin.carpetaclientes.storeMedia') }}',
        maxFilesize: 4, // MB
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4
        },
        success: function (file, response) {
        $('form').find('input[name="nb"]').remove()
        $('form').append('<input type="hidden" name="nb" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="nb"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
        @if(isset($proyecto->carpetacliente) && $proyecto->carpetacliente->nb)
        var file = {!! json_encode($proyecto->carpetacliente->nb) !!}
            this.options.addedfile.call(this, file)
        file.previewElement.classList.add('dz-complete')
        $('form').append('<input type="hidden" name="nb" value="' + file.file_name + '">')
        this.options.maxFiles = this.options.maxFiles - 1
        @endif
        },
        error: function (file, response) {
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
    </script>

    <script>
        Dropzone.options.courseDropzone = {
        url: '{{ route('admin.carpetaclientes.storeMedia') }}',
        acceptedFiles: '.pdf',
        maxFilesize: 4, // MB
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4
        },
        success: function (file, response) {
        $('form').find('input[name="course"]').remove()
        $('form').append('<input type="hidden" name="course" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="course"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
        @if(isset($proyecto->carpetacliente) && $proyecto->carpetacliente->course)
        var file = {!! json_encode($proyecto->carpetacliente->course) !!}
            this.options.addedfile.call(this, file)
        file.previewElement.classList.add('dz-complete')
        $('form').append('<input type="hidden" name="course" value="' + file.file_name + '">')
        this.options.maxFiles = this.options.maxFiles - 1
        @endif
        },
        error: function (file, response) {
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
        

    </script>

@endsection