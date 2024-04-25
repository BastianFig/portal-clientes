@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        Crear solicitud
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('frontend.tickets.store') }}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="form-group select-custom">
                                <label for="postventa">Postventa</label>
                                <input type="checkbox" name="postventa" id="postventa">
                                </div>
                                <div class="form-group select-custom">
                                <label for="Comercial">Comercial</label>
                                <input type="checkbox" name="Comercial" id="Comercial">
                            </div>
                            
                            <div class="form-group select-custom">
                                <label class="required"
                                    for="proyecto_id">{{ trans('cruds.ticket.fields.proyecto') }}</label>
                                <select class="form-control select2 select-single-no-search-filled " name="proyecto_id" id="proyecto_id" required style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                    <option value="{{$proyecto_id}}" selected>{{$nombre_proyecto}}</option style="border: none; background-color: #f8f8f8; border-radius: 10px;">                          
                                </select> 
                                @if ($errors->has('proyecto'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('proyecto') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.ticket.fields.proyecto_helper') }}</span>
                            </div>


                            <!--ACA VAN LOS ID DEL USER Y DEL VENDEDOR EN HIDDEN -->
                            <input type="hidden" name="vendedor_id" id="vendedor_id" value="7">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="estado" id="estado" value="Activo">
                            <div class="form-group">
                                <input class="form-control input-custom" type="text" name="asunto" id="asunto"
                                    value="{{ old('asunto', '') }}" style="border: none; background-color: #f8f8f8; border-radius: 10px;"
                                    placeholder="Asunto"
                                    >

                                @if ($errors->has('asunto'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('asunto') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.ticket.fields.asunto_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control input-custom" type="text" name="mensaje" id="mensaje" value="{{ old('mensaje', '') }}" 
                                style="border: none; background-color: #f8f8f8; border-radius: 10px;" placeholder="Mensaje"></textarea>
                                @if ($errors->has('mensaje'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('mensaje') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger" style="border-radius: 10px;" id="boton-guardar"
                                    type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
