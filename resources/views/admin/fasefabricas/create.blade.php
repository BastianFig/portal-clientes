@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.fasefabrica.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.fasefabricas.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>{{ trans('cruds.fasefabrica.fields.aprobacion_course') }}</label>
                <select class="form-control {{ $errors->has('aprobacion_course') ? 'is-invalid' : '' }}" name="aprobacion_course" id="aprobacion_course">
                    <option value disabled {{ old('aprobacion_course', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Fasefabrica::APROBACION_COURSE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('aprobacion_course', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                <label for="oc_proveedores">{{ trans('cruds.fasefabrica.fields.oc_proveedores') }}</label>
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
                    <option value disabled {{ old('estado_produccion', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Fasefabrica::ESTADO_PRODUCCION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('estado_produccion', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('estado_produccion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('estado_produccion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasefabrica.fields.estado_produccion_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fecha_entrega">{{ trans('cruds.fasefabrica.fields.fecha_entrega') }}</label>
                <input class="form-control date {{ $errors->has('fecha_entrega') ? 'is-invalid' : '' }}" type="text" name="fecha_entrega" id="fecha_entrega" value="{{ old('fecha_entrega') }}">
                @if($errors->has('fecha_entrega'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fecha_entrega') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasefabrica.fields.fecha_entrega_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="galeria_estado_entrega">{{ trans('cruds.fasefabrica.fields.galeria_estado_entrega') }}</label>
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
                <label for="id_proyecto_id">{{ trans('cruds.fasefabrica.fields.id_proyecto') }}</label>
                <select class="form-control select2 {{ $errors->has('id_proyecto') ? 'is-invalid' : '' }}" name="id_proyecto_id" id="id_proyecto_id">
                    @foreach($id_proyectos as $id => $entry)
                        <option value="{{ $id }}" {{ old('id_proyecto_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('id_proyecto'))
                    <div class="invalid-feedback">
                        {{ $errors->first('id_proyecto') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasefabrica.fields.id_proyecto_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="estado">{{ trans('cruds.fasefabrica.fields.estado') }}</label>
                <input class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" type="text" name="estado" id="estado" value="{{ old('estado', '') }}">
                @if($errors->has('estado'))
                    <div class="invalid-feedback">
                        {{ $errors->first('estado') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasefabrica.fields.estado_helper') }}</span>
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
    var uploadedOcProveedoresMap = {}
Dropzone.options.ocProveedoresDropzone = {
    url: '{{ route('admin.fasefabricas.storeMedia') }}',
    maxFilesize: 4, // MB
    addRemoveLinks: true,
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
@if(isset($fasefabrica) && $fasefabrica->oc_proveedores)
          var files =
            {!! json_encode($fasefabrica->oc_proveedores) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="oc_proveedores[]" value="' + file.file_name + '">')
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
    var uploadedGaleriaEstadoEntregaMap = {}
Dropzone.options.galeriaEstadoEntregaDropzone = {
    url: '{{ route('admin.fasefabricas.storeMedia') }}',
    maxFilesize: 4, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
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
@if(isset($fasefabrica) && $fasefabrica->galeria_estado_entrega)
      var files = {!! json_encode($fasefabrica->galeria_estado_entrega) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="galeria_estado_entrega[]" value="' + file.file_name + '">')
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
@endsection