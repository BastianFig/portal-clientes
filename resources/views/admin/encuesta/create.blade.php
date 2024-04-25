@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} Encuesta
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("admin.encuesta.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" class="user_id" id="user_id" value="{{$userID}}">
            <div class="form-group pb-2">
                <label class="font-weight-bold fs-3 required" for="empresa_id">{{ trans('cruds.sucursal.fields.empresa') }}</label>
                <select class="form-control select2 {{ $errors->has('empresa') ? 'is-invalid' : '' }}" name="empresa_id" id="empresa_id"  required>
                    <option value="{{$empresa_user->id}}">{{$empresa_user->razon_social}}</option>
                </select>
                @if($errors->has('empresa'))
                    <div class="invalid-feedback">
                        {{ $errors->first('empresa') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sucursal.fields.empresa_helper') }}</span>
            </div>
            <div class="form-group pt-2 pb-2">
                <label class="font-weight-bold fs-3 required" for="nombre_encuestado">Nombre</label>
                <input class="form-control {{ $errors->has('nombre_encuestado') ? 'is-invalid' : '' }}" type="text" name="nombre_encuestado" id="nombre_encuestado" value="{{$user->name}}" readonly required>
                @if($errors->has('nombre_encuestado'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nombre_encuestado') }}
                    </div>
                @endif
            </div>
            <!-- GROUP COMO LLEGASTE A OHFFICE -->
            <div class="form-group pt-2 pb-2">
                <label class="font-weight-bold fs-3 required" for="como_llegaste">¿Cómo llegaste a Ohffice?</label>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="como_llegaste" id="como_llegaste1" value="Sitio Web">
                  <label class="form-check-label" for="como_llegaste1">
                    Sitio Web
                  </label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="como_llegaste" id="como_llegaste2" value="Redes Sociales">
                  <label class="form-check-label" for="como_llegaste2">
                    Redes Sociales
                  </label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="como_llegaste" id="como_llegaste3" value="Por una recomendación">
                  <label class="form-check-label" for="como_llegaste3">
                    Por una recomendación
                  </label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="como_llegaste" id="como_llegaste4" value="">
                  <div class="input-group">
                    <input type="text" name="como_llegaste" class="form-control col-2" placeholder="Otras" id="otras" aria-label="Otra respuesta">
                  </div>
                </div>
              </div>

            <!-- GROUP CALIFIACION 1 A 10 -->
              <div class="form-group pt-2 pb-2">
                <label for="calificacion" class="font-weight-bold fs-3 required">Del 1 al 10, ¿Cómo calificarías la atención de tu ejecutivo?</label>
                <div class="calificacion-input">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion1" value="1">
                    <label class="form-check-label" for="calificacion1">1</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion2" value="2">
                    <label class="form-check-label" for="calificacion2">2</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion3" value="3">
                    <label class="form-check-label" for="calificacion3">3</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion4" value="4">
                    <label class="form-check-label" for="calificacion4">4</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion5" value="5">
                    <label class="form-check-label" for="calificacion5">5</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion6" value="6">
                    <label class="form-check-label" for="calificacion6">6</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion7" value="7">
                    <label class="form-check-label" for="calificacion7">7</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion8" value="8">
                    <label class="form-check-label" for="calificacion8">8</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion9" value="9">
                    <label class="form-check-label" for="calificacion9">9</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion10" value="10">
                    <label class="form-check-label" for="calificacion10">10</label>
                  </div>
                </div>
              </div>

            <!-- GROUP SATISFACCION -->
            <div class="table-responsive pt-2 pb-2">
                <label for="satisfaccion" class="font-weight-bold fs-3 required">Responde según el nivel de satisfacción de acuerdo a las siguientes afirmaciones.</label>
                <table class="table table-bordered">
                    <colgroup>
                        <col class="likert-statement-col">
                        <col class="likert-option-col">
                        <col class="likert-option-col">
                        <col class="likert-option-col">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="col-3"></th>
                            <th class="likert-option col-3">En Desacuerdo</th>
                            <th class="likert-option col-3">Neutro</th>
                            <th class="likert-option col-3">De Acuerdo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="likert-statement">Los productos llegaron en el horario acordado para el despacho.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion1" value="En Desacuerdo">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion1" value="Neutro">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion1" value="De Acuerdo">
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">Los productos llegaron en buenas condiciones.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion2" value="En Desacuerdo">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion2" value="Neutro">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion2" value="De Acuerdo">
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">El personal de Ohffice se preocupó de dejar limpio luego de instalar el mobiliario.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion3" value="En Desacuerdo">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion3" value="Neutro">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion3" value="De Acuerdo">
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">El ejecutivo me explicó y asesoró sobre el uso de los productos.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion4" value="En Desacuerdo">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion4" value="Neutro">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion4" value="De Acuerdo">
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">El ejecutivo logró entender mis necesidades.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion5" value="En Desacuerdo">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion5" value="Neutro">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion5" value="De Acuerdo">
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">El ejecutivo se preocupó de entender mis necesidades.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion6" value="En Desacuerdo">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion6" value="Neutro">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion6" value="De Acuerdo">
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">La instalación se realizó de acuerdo a lo especificado en el plano.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion7" value="En Desacuerdo">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion7" value="Neutro">
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion7" value="De Acuerdo">
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
              
            <!-- GROUP RATING -->
            <div class="form-group">
                <label for="rating" class="font-weight-bold fs-3 required">A grandes rasgos, ¿Cómo calificarías nuestro servicio?</label><br>
                <div class="rating">
                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5" class="star"></label>
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4" class="star"></label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3" class="star"></label>
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2" class="star"></label>
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1" class="star"></label>
                </div>
            </div>

            <div class="form-group pt-2 pb-2">
                <label class="font-weight-bold fs-3 required" for="mejorar_servicio">¿Qué nos sugerirías para mejorar nuestro servicio?</label>
                <input class="form-control {{ $errors->has('mejorar_servicio') ? 'is-invalid' : '' }}" type="text" name="mejorar_servicio" id="mejorar_servicio" value="{{ old('razon_social', '') }}" required>
                @if($errors->has('mejorar_servicio'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mejorar_servicio') }}
                    </div>
                @endif
            </div>
              
            <div class="form-group pt-2 pb-2">
                <label for="observacion" class="font-weight-bold fs-3 required">¡Compártenos tu experiencia!</label>
                <input class="form-control {{ $errors->has('observacion') ? 'is-invalid' : '' }}" type="text" name="observacion" id="observacion" value="{{ old('observacion', '') }}" required>
                @if($errors->has('observacion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('observacion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.encuestum.fields.observacion_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="autorizacion" class="font-weight-bold fs-3 required">¿Autorizas compartir tu experiencia (punto anterior del formulario) para uso comercial de Ohffice?</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="autorizacion" id="autorizacionSi" value="Si">
                  <label class="form-check-label" for="autorizacionSi">Si</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="autorizacion" id="autorizacionNo" value="No">
                  <label class="form-check-label" for="autorizacionNo">No</label>
                </div>
              </div>
              
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection