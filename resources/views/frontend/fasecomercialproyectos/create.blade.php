@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.fasecomercialproyecto.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('frontend.fasecomercialproyectos.store') }}"
                            enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="form-group input-custom p-4"
                                style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                <label for="nota_venta">{{ trans('cruds.fasecomercialproyecto.fields.nota_venta') }}</label>
                                <div class="needsclick dropzone" id="nota_venta-dropzone">
                                </div>
                                @if ($errors->has('nota_venta'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nota_venta') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.fasecomercialproyecto.fields.nota_venta_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label
                                    for="id_proyecto_id">{{ trans('cruds.fasecomercialproyecto.fields.id_proyecto') }}</label>
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
                                    class="help-block">{{ trans('cruds.fasecomercialproyecto.fields.id_proyecto_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="estado">{{ trans('cruds.fasecomercialproyecto.fields.estado') }}</label>
                                <input class="form-control input-custom"
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;" type="text"
                                    name="estado" id="estado" value="{{ old('estado', '') }}" placeholder="Estado">
                                @if ($errors->has('estado'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('estado') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.fasecomercialproyecto.fields.estado_helper') }}</span>
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
        Dropzone.options.notaVentaDropzone = {
            url: '{{ route('frontend.fasecomercialproyectos.storeMedia') }}',
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
                $('form').find('input[name="nota_venta"]').remove()
                $('form').append('<input type="hidden" name="nota_venta" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="nota_venta"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($fasecomercialproyecto) && $fasecomercialproyecto->nota_venta)
                    var file = {!! json_encode($fasecomercialproyecto->nota_venta) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="nota_venta" value="' + file.file_name + '">')
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
