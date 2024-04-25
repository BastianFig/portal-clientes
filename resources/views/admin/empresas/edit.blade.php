@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.empresa.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.empresas.update", [$empresa->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label>Antiguedad Empresa</label>
                <select class="form-control {{ $errors->has('antiguedad_empresa') ? 'is-invalid' : '' }}" name="antiguedad_empresa" id="antiguedad_empresa">
                    <option value="" disabled {{ old('antiguedad_empresa', $empresa->antiguedad_empresa) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach(App\Models\Empresa::ANTIGUEDAD_EMPRESA as $key => $label)
                        <option value="{{ $key }}" {{ old('antiguedad_empresa', $empresa->antiguedad_empresa) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                @if($errors->has('antiguedad_empresa'))
                    <div class="invalid-feedback">
                        {{ $errors->first('antiguedad_empresa') }}
                    </div>
                @endif
            </div> 
            <div class="form-group">
                <label>Tipo de Empresa</label>
                <select class="form-control {{ $errors->has('tipo_empresa') ? 'is-invalid' : '' }}" name="tipo_empresa" id="tipo_empresa">
                    <option value="" disabled {{ old('tipo_empresa', $empresa->tipo_empresa) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach(App\Models\Empresa::TIPO_EMPRESA_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('tipo_empresa', $empresa->tipo_empresa) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                @if($errors->has('tipo_empresa'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tipo_empresa') }}
                    </div>
                @endif
            </div> 
            <div class="form-group">
                <label class="required" for="rut">{{ trans('cruds.empresa.fields.rut') }}</label>
                <input class="form-control {{ $errors->has('rut') ? 'is-invalid' : '' }}" type="text" name="rut" id="rut" value="{{ old('rut', $empresa->rut) }}" required>
                @if($errors->has('rut'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rut') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.rut_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="razon_social">{{ trans('cruds.empresa.fields.razon_social') }}</label>
                <input class="form-control {{ $errors->has('razon_social') ? 'is-invalid' : '' }}" type="text" name="razon_social" id="razon_social" value="{{ old('razon_social', $empresa->razon_social) }}" required>
                @if($errors->has('razon_social'))
                    <div class="invalid-feedback">
                        {{ $errors->first('razon_social') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.razon_social_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nombe_de_fantasia">{{ trans('cruds.empresa.fields.nombe_de_fantasia') }}</label>
                <input class="form-control {{ $errors->has('nombe_de_fantasia') ? 'is-invalid' : '' }}" type="text" name="nombe_de_fantasia" id="nombe_de_fantasia" value="{{ old('nombe_de_fantasia', $empresa->nombe_de_fantasia) }}">
                @if($errors->has('nombe_de_fantasia'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nombe_de_fantasia') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.nombe_de_fantasia_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rubro">{{ trans('cruds.empresa.fields.rubro') }}</label>
                <input class="form-control {{ $errors->has('rubro') ? 'is-invalid' : '' }}" type="text" name="rubro" id="rubro" value="{{ old('rubro', $empresa->rubro) }}">
                @if($errors->has('rubro'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rubro') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.rubro_helper') }}</span>
            </div>
            <div class="form-group">
                <label>Región</label>
                <select class="form-control {{ $errors->has('region') ? 'is-invalid' : '' }}" name="region" id="region">
                    <option value="" disabled {{ old('region', $empresa->region) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach(App\Models\Empresa::REGION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('region', $empresa->region) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('region'))
                    <div class="invalid-feedback">
                        {{ $errors->first('region') }}
                    </div>
                @endif
            </div>
                            
            <div class="form-group">
                <label>{{ trans('cruds.empresa.fields.comuna') }}</label>
                
                <select class="form-control {{ $errors->has('comuna') ? 'is-invalid' : '' }}" name="comuna" id="comuna">
                    <option value disabled {{ old('comuna', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    <option value="{{  $empresa->comuna }}" selected>{{  $empresa->comuna }}</option>
                            
                </select>
                
                @if($errors->has('comuna'))re
                    <div class="invalid-feedback">
                        {{ $errors->first('comuna') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.comuna_helper') }}</span>
            </div>           
            <div class="form-group">
                <label for="direccion">{{ trans('cruds.empresa.fields.direccion') }}</label>
                <input class="form-control {{ $errors->has('direccion') ? 'is-invalid' : '' }}" type="text" name="direccion" id="direccion" value="{{ old('direccion', $empresa->direccion) }}">
                @if($errors->has('direccion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('direccion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.direccion_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="logo">Logo</label>
                <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                </div>
                @if($errors->has('logo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('logo') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.empresa.fields.estado') }}</label>
                <select class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" name="estado" id="estado">
                    <option value disabled {{ old('estado', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Empresa::ESTADO_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('estado', $empresa->estado) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('estado'))
                    <div class="invalid-feedback">
                        {{ $errors->first('estado') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.estado_helper') }}</span>
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
@section('scripts')
<script>
     Dropzone.options.logoDropzone = {
    url: '{{ route('admin.empresas.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="logo"]').remove()
      $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="logo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($empresa) && $empresa->logo)
      var file = {!! json_encode($empresa->logo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
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