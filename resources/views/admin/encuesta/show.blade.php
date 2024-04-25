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
                <select class="form-control select2 {{ $errors->has('empresa') ? 'is-invalid' : '' }}" name="empresa_id" id="empresa_id" readonly disabled required>
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
                <input class="form-control {{ $errors->has('nombre_encuestado') ? 'is-invalid' : '' }}" type="text" name="nombre_encuestado" id="nombre_encuestado" value="{{$encuestum->nombre_encuestado}}" readonly required>
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
                  <input class="form-check-input" type="radio" name="como_llegaste" id="como_llegaste1" value="Sitio Web" disabled>
                  <label class="form-check-label" for="como_llegaste1">
                    Sitio Web
                  </label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="como_llegaste" id="como_llegaste2" value="Redes Sociales" disabled>
                  <label class="form-check-label" for="como_llegaste2">
                    Redes Sociales
                  </label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="como_llegaste" id="como_llegaste3" value="Por una recomendación" disabled>
                  <label class="form-check-label" for="como_llegaste3">
                    Por una recomendación
                  </label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="como_llegaste" id="como_llegaste4" value="" disabled>
                  <div class="input-group">
                    <input type="text" name="como_llegaste" class="form-control col-2" placeholder="Otras" id="otro" aria-label="Otra respuesta" readonly>
                  </div>
                </div>
            </div>

            <!-- GROUP CALIFIACION 1 A 10 -->
              <div class="form-group pt-2 pb-2">
                <label for="calificacion" class="font-weight-bold fs-3 required">Del 1 al 10, ¿Cómo calificarías la atención de tu ejecutivo?</label>
                <div class="calificacion-input">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion1" value="1" disabled>
                    <label class="form-check-label" for="calificacion1">1</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion2" value="2" disabled>
                    <label class="form-check-label" for="calificacion2">2</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion3" value="3" disabled>
                    <label class="form-check-label" for="calificacion3">3</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion4" value="4" disabled>
                    <label class="form-check-label" for="calificacion4">4</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion5" value="5" disabled>
                    <label class="form-check-label" for="calificacion5">5</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion6" value="6" disabled>
                    <label class="form-check-label" for="calificacion6">6</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion7" value="7" disabled>
                    <label class="form-check-label" for="calificacion7">7</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion8" value="8" disabled>
                    <label class="form-check-label" for="calificacion8">8</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion9" value="9" disabled>
                    <label class="form-check-label" for="calificacion9">9</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="calificacion" id="calificacion10" value="10" disabled>
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
                                <input type="radio" name="satisfaccion1" id="satisfaccion1_d" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion1" id="satisfaccion1_n" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion1" id="satisfaccion1_a" value="" disabled>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">Los productos llegaron en buenas condiciones.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion2" id="satisfaccion2_d" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion2" id="satisfaccion2_n" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion2" id="satisfaccion2_a" value="" disabled>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">El personal de Ohffice se preocupó de dejar limpio luego de instalar el mobiliario.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion3" id="satisfaccion3_d" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion3" id="satisfaccion3_n" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion3" id="satisfaccion3_a" value="" disabled>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">El ejecutivo me explicó y asesoró sobre el uso de los productos.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion4" id="satisfaccion4_d" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion4" id="satisfaccion4_n" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion4" id="satisfaccion4_a" value="" disabled>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">El ejecutivo logró entender mis necesidades.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion5" id="satisfaccion5_d" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion5" id="satisfaccion5_n" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion5" id="satisfaccion5_a" value="" disabled>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">El ejecutivo se preocupó de entender mis necesidades.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion6" id="satisfaccion6_d" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion6" id="satisfaccion6_n" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion6" id="satisfaccion6_a" value="" disabled>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="likert-statement">La instalación se realizó de acuerdo a lo especificado en el plano.</td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion7" id="satisfaccion7_d" value="" disabled>
                                </label>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion7" id="satisfaccion7_n" value="" disabled>
                            </td>
                            <td class="likert-option">
                                <label class="form-check-label">
                                <input type="radio" name="satisfaccion7" id="satisfaccion7_a" value="" disabled>
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
                    <input type="radio" id="star5" name="rating" value="" disabled>
                    <label for="star5" class="star"></label>
                    <input type="radio" id="star4" name="rating" value="" disabled>
                    <label for="star4" class="star"></label>
                    <input type="radio" id="star3" name="rating" value="" disabled>
                    <label for="star3" class="star"></label>
                    <input type="radio" id="star2" name="rating" value="" disabled>
                    <label for="star2" class="star"></label>
                    <input type="radio" id="star1" name="rating" value="" disabled>
                    <label for="star1" class="star"></label>
                </div>
            </div>

            <div class="form-group pt-2 pb-2">
                <label class="font-weight-bold fs-3 required" for="mejorar_servicio">¿Qué nos sugerirías para mejorar nuestro servicio?</label>
                <input class="form-control {{ $errors->has('mejorar_servicio') ? 'is-invalid' : '' }}" type="text" name="mejorar_servicio" id="mejorar_servicio" value="" readonly required>
                @if($errors->has('mejorar_servicio'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mejorar_servicio') }}
                    </div>
                @endif
            </div>
              
            <div class="form-group pt-2 pb-2">
                <label for="observacion" class="font-weight-bold fs-3 required">¡Compártenos tu experiencia!</label>
                <input class="form-control {{ $errors->has('observacion') ? 'is-invalid' : '' }}" type="text" name="observacion" id="observacion" value="" readonly required>
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
                  <input class="form-check-input" type="radio" name="autorizacion" id="autorizacionSi" value="" disabled>
                  <label class="form-check-label" for="autorizacionSi">Si</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="autorizacion" id="autorizacionNo" value="" disabled>
                  <label class="form-check-label" for="autorizacionNo">No</label>
                </div>
              </div>
              
            <div class="form-group">
                <a class="btn btn-danger" href="{{ route('admin.encuesta.index') }}">
                    Volver
                </a>
            </div>
        </form>
    </div>
</div>
{{ $encuestum->mejorar_servicio }}

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var experiencia = "<?php echo $encuestum->observacion;?>";
        var mejorar_servicio = "<?php echo $encuestum->mejorar_servicio;?>";
        var autorizacion = "<?php echo $encuestum->autorizacion;?>";
        var rating = "<?php echo $encuestum->rating;?>";
        var satisfaccion1 = "<?php echo $encuestum->satisfaccion1;?>";
        var satisfaccion2 = "<?php echo $encuestum->satisfaccion2;?>";
        var satisfaccion3 = "<?php echo $encuestum->satisfaccion3;?>";
        var satisfaccion4 = "<?php echo $encuestum->satisfaccion4;?>";
        var satisfaccion5 = "<?php echo $encuestum->satisfaccion5;?>";
        var satisfaccion6 = "<?php echo $encuestum->satisfaccion6;?>";
        var satisfaccion7 = "<?php echo $encuestum->satisfaccion7;?>";
        var calificacion = "<?php echo $encuestum->calificacion;?>";
        var como_llegaste = "<?php echo $encuestum->como_llegaste;?>";


        if(autorizacion == "Si"){
            $("#autorizacionSi").prop("checked", true).prop("disabled", false);
        }else{            
            $("#autorizacionNo").prop("checked", true).prop("disabled", false);
        }

        if(rating == 1){
            $("#star1").prop("checked", true).prop("disabled", false);
        }else if(rating == 2){
            $("#star2").prop("checked", true).prop("disabled", false);
        }else if(rating == 3){
            $("#star3").prop("checked", true).prop("disabled", false);
        }else if(rating == 4){
            $("#star4").prop("checked", true).prop("disabled", false);
        }else{
            $("#star5").prop("checked", true).prop("disabled", false);
        }

        if(satisfaccion1 == "En Desacuerdo"){
            $("#satisfaccion1_d").prop("checked", true).prop("disabled", false);
        }else if(satisfaccion1 == "Neutro"){
            $("#satisfaccion1_n").prop("checked", true).prop("disabled", false);
        }else{
            $("#satisfaccion1_a").prop("checked", true).prop("disabled", false);            
        }

        if(satisfaccion2 == "En Desacuerdo"){
            $("#satisfaccion2_d").prop("checked", true).prop("disabled", false);
        }else if(satisfaccion2 == "Neutro"){
            $("#satisfaccion2_n").prop("checked", true).prop("disabled", false);
        }else{
            $("#satisfaccion2_a").prop("checked", true).prop("disabled", false);            
        }

        if(satisfaccion3 == "En Desacuerdo"){
            $("#satisfaccion3_d").prop("checked", true).prop("disabled", false);
        }else if(satisfaccion3 == "Neutro"){
            $("#satisfaccion3_n").prop("checked", true).prop("disabled", false);
        }else{
            $("#satisfaccion3_a").prop("checked", true).prop("disabled", false);            
        }

        if(satisfaccion4 == "En Desacuerdo"){
            $("#satisfaccion4_d").prop("checked", true).prop("disabled", false);
        }else if(satisfaccion4 == "Neutro"){
            $("#satisfaccion4_n").prop("checked", true).prop("disabled", false);
        }else{
            $("#satisfaccion4_a").prop("checked", true).prop("disabled", false);            
        }

        if(satisfaccion5 == "En Desacuerdo"){
            $("#satisfaccion5_d").prop("checked", true).prop("disabled", false);
        }else if(satisfaccion5 == "Neutro"){
            $("#satisfaccion5_n").prop("checked", true).prop("disabled", false);
        }else{
            $("#satisfaccion5_a").prop("checked", true).prop("disabled", false);            
        }

        if(satisfaccion6 == "En Desacuerdo"){
            $("#satisfaccion6_d").prop("checked", true).prop("disabled", false);
        }else if(satisfaccion6 == "Neutro"){
            $("#satisfaccion6_n").prop("checked", true).prop("disabled", false);
        }else{
            $("#satisfaccion6_a").prop("checked", true).prop("disabled", false);            
        }

        if(satisfaccion7 == "En Desacuerdo"){
            $("#satisfaccion7_d").prop("checked", true).prop("disabled", false);
        }else if(satisfaccion7 == "Neutro"){
            $("#satisfaccion7_n").prop("checked", true).prop("disabled", false);
        }else{
            $("#satisfaccion7_a").prop("checked", true).prop("disabled", false);            
        }

        if(calificacion == 1){
            $("#calificacion1").prop("checked", true).prop("disabled", false);
        }else if(calificacion == 2){
            $("#calificacion2").prop("checked", true).prop("disabled", false);
        }else if(calificacion == 3){
            $("#calificacion3").prop("checked", true).prop("disabled", false);
        }else if(calificacion == 4){
            $("#calificacion4").prop("checked", true).prop("disabled", false);
        }else if(calificacion == 5){
            $("#calificacion5").prop("checked", true).prop("disabled", false);
        }else if(calificacion == 6){
            $("#calificacion6").prop("checked", true).prop("disabled", false);
        }else if(calificacion == 7){
            $("#calificacion7").prop("checked", true).prop("disabled", false);
        }else if(calificacion == 8){
            $("#calificacion8").prop("checked", true).prop("disabled", false);
        }else if(calificacion == 9){
            $("#calificacion9").prop("checked", true).prop("disabled", false);
        }else if(calificacion == 10){
            $("#calificacion10").prop("checked", true).prop("disabled", false);
        }

        if(como_llegaste == "Sitio Web"){
            $("#como_llegaste1").prop("checked", true).prop("disabled", false);
        }else if(como_llegaste == "Redes Sociales"){
            $("#como_llegaste2").prop("checked", true).prop("disabled", false);
        }else if(como_llegaste == "Por una Recomendación"){
            $("#como_llegaste3").prop("checked", true).prop("disabled", false);
        }else{
            $("#como_llegaste4").prop("checked", true).prop("disabled", false);
            $('#otro').val(como_llegaste);
        }

        $('#observacion').val(experiencia);
        $('#mejorar_servicio').val(mejorar_servicio);
    });

</script>
@endsection