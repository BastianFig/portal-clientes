@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.encuestum.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.encuesta.update", [$encuestum->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="observacion">{{ trans('cruds.encuestum.fields.observacion') }}</label>
                <input class="form-control {{ $errors->has('observacion') ? 'is-invalid' : '' }}" type="text" name="observacion" id="observacion" value="{{ old('observacion', $encuestum->observacion) }}">
                @if($errors->has('observacion'))
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



@endsection