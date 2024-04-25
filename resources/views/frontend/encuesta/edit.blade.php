@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.edit') }} {{ trans('cruds.encuestum.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('frontend.encuesta.update', [$encuestum->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="observacion">{{ trans('cruds.encuestum.fields.observacion') }}</label>
                                <input class="form-control input-custom" type="text" name="observacion" id="observacion"
                                    value="{{ old('observacion', $encuestum->observacion) }}"
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                @if ($errors->has('observacion'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('observacion') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.encuestum.fields.observacion_helper') }}</span>
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
