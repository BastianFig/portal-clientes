@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.edit') }} {{ trans('cruds.fasecomercial.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('frontend.fasecomercials.update', [$fasecomercial->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="comentarios">{{ trans('cruds.fasecomercial.fields.comentarios') }}</label>
                                <input class="form-control input-custom"
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;" type="text"
                                    name="comentarios" id="comentarios"
                                    value="{{ old('comentarios', $fasecomercial->comentarios) }}" placeholder="Comentarios">
                                @if ($errors->has('comentarios'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('comentarios') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.fasecomercial.fields.comentarios_helper') }}</span>
                            </div>
                            <div class="form-group input-custom p-4"
                                style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                <label for="cotizacion">{{ trans('cruds.fasecomercial.fields.cotizacion') }}</label>
                                <div class="needsclick dropzone" id="cotizacion-dropzone">
                                </div>
                                @if ($errors->has('cotizacion'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('cotizacion') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.fasecomercial.fields.cotizacion_helper') }}</span>
                            </div>
                            <div class="form-group input-custom p-4"
                                style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                <label for="oc">{{ trans('cruds.fasecomercial.fields.oc') }}</label>
                                <div class="needsclick dropzone" id="oc-dropzone">
                                </div>
                                @if ($errors->has('oc'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('oc') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.fasecomercial.fields.oc_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="estado">{{ trans('cruds.fasecomercial.fields.estado') }}</label>
                                <input class="form-control input-custom"
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;" type="text"
                                    name="estado" id="estado" value="{{ old('estado', $fasecomercial->estado) }}"
                                    placeholder="Estado">
                                @if ($errors->has('estado'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('estado') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.fasecomercial.fields.estado_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="id_proyecto_id">{{ trans('cruds.fasecomercial.fields.id_proyecto') }}</label>
                                <select class="form-control select2" name="id_proyecto_id" id="id_proyecto_id">
                                    @foreach ($id_proyectos as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ (old('id_proyecto_id') ? old('id_proyecto_id') : $fasecomercial->id_proyecto->id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_proyecto'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_proyecto') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.fasecomercial.fields.id_proyecto_helper') }}</span>
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

@section('scripts')
    <script>
        Dropzone.options.cotizacionDropzone = {
            url: '{{ route('frontend.fasecomercials.storeMedia') }}',
            maxFilesize: 4, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 4
            },
            success: function(file, response) {
                $('form').find('input[name="cotizacion"]').remove()
                $('form').append('<input type="hidden" name="cotizacion" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="cotizacion"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($fasecomercial) && $fasecomercial->cotizacion)
                    var file = {!! json_encode($fasecomercial->cotizacion) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="cotizacion" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
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
        Dropzone.options.ocDropzone = {
            url: '{{ route('frontend.fasecomercials.storeMedia') }}',
            maxFilesize: 4, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 4
            },
            success: function(file, response) {
                $('form').find('input[name="oc"]').remove()
                $('form').append('<input type="hidden" name="oc" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="oc"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($fasecomercial) && $fasecomercial->oc)
                    var file = {!! json_encode($fasecomercial->oc) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="oc" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
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
