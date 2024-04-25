@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.fasedespacho.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.fasedespachos.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="guia_despacho">{{ trans('cruds.fasedespacho.fields.guia_despacho') }}</label>
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
                <label for="fecha_despacho">{{ trans('cruds.fasedespacho.fields.fecha_despacho') }}</label>
                <input class="form-control date {{ $errors->has('fecha_despacho') ? 'is-invalid' : '' }}" type="text" name="fecha_despacho" id="fecha_despacho" value="{{ old('fecha_despacho') }}">
                @if($errors->has('fecha_despacho'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fecha_despacho') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasedespacho.fields.fecha_despacho_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.fasedespacho.fields.estado_instalacion') }}</label>
                <select class="form-control {{ $errors->has('estado_instalacion') ? 'is-invalid' : '' }}" name="estado_instalacion" id="estado_instalacion">
                    <option value disabled {{ old('estado_instalacion', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Fasedespacho::ESTADO_INSTALACION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('estado_instalacion', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                <label for="comentario">{{ trans('cruds.fasedespacho.fields.comentario') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('comentario') ? 'is-invalid' : '' }}" name="comentario" id="comentario">{!! old('comentario') !!}</textarea>
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
                    <option value disabled {{ old('recibe_conforme', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Fasedespacho::RECIBE_CONFORME_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('recibe_conforme', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                <label for="galeria_estado_muebles">{{ trans('cruds.fasedespacho.fields.galeria_estado_muebles') }}</label>
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
                <label for="id_proyecto_id">{{ trans('cruds.fasedespacho.fields.id_proyecto') }}</label>
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
                <span class="help-block">{{ trans('cruds.fasedespacho.fields.id_proyecto_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="estado">{{ trans('cruds.fasedespacho.fields.estado') }}</label>
                <input class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" type="text" name="estado" id="estado" value="{{ old('estado', '') }}">
                @if($errors->has('estado'))
                    <div class="invalid-feedback">
                        {{ $errors->first('estado') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasedespacho.fields.estado_helper') }}</span>
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
    Dropzone.options.guiaDespachoDropzone = {
    url: '{{ route('admin.fasedespachos.storeMedia') }}',
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
      $('form').find('input[name="guia_despacho"]').remove()
      $('form').append('<input type="hidden" name="guia_despacho" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="guia_despacho"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($fasedespacho) && $fasedespacho->guia_despacho)
      var file = {!! json_encode($fasedespacho->guia_despacho) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="guia_despacho" value="' + file.file_name + '">')
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
                data.append('crud_id', '{{ $fasedespacho->id ?? 0 }}');
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
</script>

<script>
    var uploadedGaleriaEstadoMueblesMap = {}
Dropzone.options.galeriaEstadoMueblesDropzone = {
    url: '{{ route('admin.fasedespachos.storeMedia') }}',
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
@if(isset($fasedespacho) && $fasedespacho->galeria_estado_muebles)
      var files = {!! json_encode($fasedespacho->galeria_estado_muebles) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="galeria_estado_muebles[]" value="' + file.file_name + '">')
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