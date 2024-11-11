@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.empresa.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.empresas.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Antigüedad Empresa</label>
                <select class="form-control {{ $errors->has('antiguedad_empresa') ? 'is-invalid' : '' }}" name="antiguedad_empresa" id="antiguedad_empresa">
                    <option value disabled {{ old('antiguedad_empresa', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Empresa::ANTIGUEDAD_EMPRESA as $key => $label)
                        <option value="{{ $key }}" {{ old('antiguedad_empresa', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                    <option value disabled {{ old('tipo_empresa', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Empresa::TIPO_EMPRESA_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('tipo_empresa', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                <input class="form-control {{ $errors->has('rut') ? 'is-invalid' : '' }}" type="text" name="rut" id="rut" value="{{ old('rut', '') }}" required>
                @if($errors->has('rut'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rut') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.rut_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="razon_social">{{ trans('cruds.empresa.fields.razon_social') }}</label>
                <input class="form-control {{ $errors->has('razon_social') ? 'is-invalid' : '' }}" type="text" name="razon_social" id="razon_social" value="{{ old('razon_social', '') }}" required>
                @if($errors->has('razon_social'))
                    <div class="invalid-feedback">
                        {{ $errors->first('razon_social') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.razon_social_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nombe_de_fantasia">{{ trans('cruds.empresa.fields.nombe_de_fantasia') }}</label>
                <input class="form-control {{ $errors->has('nombe_de_fantasia') ? 'is-invalid' : '' }}" type="text" name="nombe_de_fantasia" id="nombe_de_fantasia" value="{{ old('nombe_de_fantasia', '') }}">
                @if($errors->has('nombe_de_fantasia'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nombe_de_fantasia') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.nombe_de_fantasia_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rubro">{{ trans('cruds.empresa.fields.rubro') }}</label>
                <input class="form-control {{ $errors->has('rubro') ? 'is-invalid' : '' }}" type="text" name="rubro" id="rubro" value="{{ old('rubro', '') }}">
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
                    <option value="" disabled {{ old('region', '') === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach(App\Models\Empresa::REGION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('region', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                    @foreach(App\Models\Empresa::COMUNA_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('comuna', 'Seleccionar comuna') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('comuna'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comuna') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.comuna_helper') }}</span>
            </div>
            
            <div class="form-group">
                <label for="direccion">{{ trans('cruds.empresa.fields.direccion') }}</label>
                <input class="form-control {{ $errors->has('direccion') ? 'is-invalid' : '' }}" type="text" name="direccion" id="direccion" value="{{ old('direccion', '') }}">
                @if($errors->has('direccion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('direccion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.empresa.fields.direccion_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.empresa.fields.estado') }}</label>
                <select class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" name="estado" id="estado">
                    <option value disabled {{ old('estado', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Empresa::ESTADO_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('estado', 'activo') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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

    function formatearYValidarRutInput(rut) {
    rut = rut.replace(/[^\dkK]+/g, ''); // Eliminar caracteres no numéricos ni la letra 'k'
    if (rut.length < 2) {
        return '';
    }

    var dv = rut.charAt(rut.length - 1).toUpperCase();
    var rutNumeros = parseInt(rut.slice(0, -1), 10);
    if (isNaN(rutNumeros)) {
        return '';
    }

    var suma = 0;
    var factor = 2;

    // Calcular la suma ponderada de los dígitos del Rut
    for (var i = rutNumeros.toString().length - 1; i >= 0; i--) {
        suma += factor * parseInt(rutNumeros.toString().charAt(i), 10);
        factor = (factor === 7) ? 2 : factor + 1;
    }

    var dvEsperado = 11 - (suma % 11);
    dvEsperado = (dvEsperado === 11) ? '0' : ((dvEsperado === 10) ? 'K' : dvEsperado.toString());

    if (dv !== dvEsperado) {
        return '';
    }

    // Formatear el Rut con puntos y guion
    var rutFormateado = rutNumeros.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    rutFormateado += '-' + dv;

    return rutFormateado;
}

    jQuery( document ).ready(function() {
        jQuery('#rut').on('blur', function() {
            var rut = jQuery(this).val();
            var rutFormateado = formatearYValidarRutInput(rut);

            if(rutFormateado == 0 || rutFormateado == "" || rutFormateado == "NaN"){
                jQuery(this).addClass("error");
                jQuery(this).val(rutFormateado);
                alert("El rut no es Válido.");
            }else{
                jQuery(this).val(rutFormateado);
                jQuery(this).removeClass("error");
            }
        });
    });
</script>
@endsection