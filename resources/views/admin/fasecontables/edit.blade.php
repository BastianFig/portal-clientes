@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.fasecontable.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.fasecontables.update", [$fasecontable->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="anticipo_50">{{ trans('cruds.fasecontable.fields.anticipo_50') }}</label>
                <div class="needsclick dropzone {{ $errors->has('anticipo_50') ? 'is-invalid' : '' }}" id="anticipo_50-dropzone">
                </div>
                @if($errors->has('anticipo_50'))
                    <div class="invalid-feedback">
                        {{ $errors->first('anticipo_50') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasecontable.fields.anticipo_50_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comentario">{{ trans('cruds.fasecontable.fields.comentario') }}</label>
                <input class="form-control {{ $errors->has('comentario') ? 'is-invalid' : '' }}" type="text" name="comentario" id="comentario" value="{{ old('comentario', $fasecontable->comentario) }}">
                @if($errors->has('comentario'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comentario') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasecontable.fields.comentario_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="anticipo_40">{{ trans('cruds.fasecontable.fields.anticipo_40') }}</label>
                <div class="needsclick dropzone {{ $errors->has('anticipo_40') ? 'is-invalid' : '' }}" id="anticipo_40-dropzone">
                </div>
                @if($errors->has('anticipo_40'))
                    <div class="invalid-feedback">
                        {{ $errors->first('anticipo_40') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasecontable.fields.anticipo_40_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="anticipo_10">{{ trans('cruds.fasecontable.fields.anticipo_10') }}</label>
                <div class="needsclick dropzone {{ $errors->has('anticipo_10') ? 'is-invalid' : '' }}" id="anticipo_10-dropzone">
                </div>
                @if($errors->has('anticipo_10'))
                    <div class="invalid-feedback">
                        {{ $errors->first('anticipo_10') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasecontable.fields.anticipo_10_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="id_proyecto_id">{{ trans('cruds.fasecontable.fields.id_proyecto') }}</label>
                <select class="form-control select2 {{ $errors->has('id_proyecto') ? 'is-invalid' : '' }}" name="id_proyecto_id" id="id_proyecto_id">
                    @foreach($id_proyectos as $id => $entry)
                        <option value="{{ $id }}" {{ (old('id_proyecto_id') ? old('id_proyecto_id') : $fasecontable->id_proyecto->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('id_proyecto'))
                    <div class="invalid-feedback">
                        {{ $errors->first('id_proyecto') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasecontable.fields.id_proyecto_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="estado">{{ trans('cruds.fasecontable.fields.estado') }}</label>
                <input class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" type="text" name="estado" id="estado" value="{{ old('estado', $fasecontable->estado) }}">
                @if($errors->has('estado'))
                    <div class="invalid-feedback">
                        {{ $errors->first('estado') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.fasecontable.fields.estado_helper') }}</span>
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
    Dropzone.options.anticipo50Dropzone = {
    url: '{{ route('admin.fasecontables.storeMedia') }}',
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
      $('form').find('input[name="anticipo_50"]').remove()
      $('form').append('<input type="hidden" name="anticipo_50" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="anticipo_50"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($fasecontable) && $fasecontable->anticipo_50)
      var file = {!! json_encode($fasecontable->anticipo_50) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="anticipo_50" value="' + file.file_name + '">')
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
    Dropzone.options.anticipo40Dropzone = {
    url: '{{ route('admin.fasecontables.storeMedia') }}',
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
      $('form').find('input[name="anticipo_40"]').remove()
      $('form').append('<input type="hidden" name="anticipo_40" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="anticipo_40"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($fasecontable) && $fasecontable->anticipo_40)
      var file = {!! json_encode($fasecontable->anticipo_40) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="anticipo_40" value="' + file.file_name + '">')
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
    Dropzone.options.anticipo10Dropzone = {
    url: '{{ route('admin.fasecontables.storeMedia') }}',
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
      $('form').find('input[name="anticipo_10"]').remove()
      $('form').append('<input type="hidden" name="anticipo_10" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="anticipo_10"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($fasecontable) && $fasecontable->anticipo_10)
      var file = {!! json_encode($fasecontable->anticipo_10) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="anticipo_10" value="' + file.file_name + '">')
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