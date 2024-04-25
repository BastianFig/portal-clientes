@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.fasePostventum.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('frontend.fase-postventa.store') }}"
                            enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="form-group">
                                <label for="encuesta_id">{{ trans('cruds.fasePostventum.fields.encuesta') }}</label>
                                <select class="form-control select2" name="encuesta_id" id="encuesta_id">
                                    @foreach ($encuestas as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ old('encuesta_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('encuesta'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('encuesta') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.fasePostventum.fields.encuesta_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="ticket_id">{{ trans('cruds.fasePostventum.fields.ticket') }}</label>
                                <select class="form-control select2" name="ticket_id" id="ticket_id">
                                    @foreach ($tickets as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ old('ticket_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('ticket'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('ticket') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.fasePostventum.fields.ticket_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="id_proyecto_id">{{ trans('cruds.fasePostventum.fields.id_proyecto') }}</label>
                                <select class="form-control select2" name="id_proyecto_id" id="id_proyecto_id">
                                    @foreach ($id_proyectos as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ old('id_proyecto_id') == $id ? 'selected' : '' }}>{{ $entry }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_proyecto'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_proyecto') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.fasePostventum.fields.id_proyecto_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="id_usuarios">{{ trans('cruds.fasePostventum.fields.id_usuario') }}</label>
                                <div style="padding-bottom: 4px">
                                    <span class="btn btn-info btn-xs select-all"
                                        style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                    <span class="btn btn-info btn-xs deselect-all"
                                        style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                </div>
                                <select class="form-control select2" name="id_usuarios[]" id="id_usuarios" multiple>
                                    @foreach ($id_usuarios as $id => $id_usuario)
                                        <option value="{{ $id }}"
                                            {{ in_array($id, old('id_usuarios', [])) ? 'selected' : '' }}>
                                            {{ $id_usuario }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_usuarios'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_usuarios') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.fasePostventum.fields.id_usuario_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="estado">{{ trans('cruds.fasePostventum.fields.estado') }}</label>
                                <input class="form-control input-custom"
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;"
                                    placeholder="Estado" type="text" name="estado" id="estado"
                                    value="{{ old('estado', '') }}">
                                @if ($errors->has('estado'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('estado') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.fasePostventum.fields.estado_helper') }}</span>
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
@endsection
