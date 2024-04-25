@extends('layouts.frontend')
@section('content')
    <div class="col ">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.edit') }} {{ trans('cruds.carpetacliente.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('frontend.carpetaclientes.update', [$carpetacliente->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="presupuesto">{{ trans('cruds.carpetacliente.fields.presupuesto') }}</label>
                                <div class="needsclick dropzone" id="presupuesto-dropzone">
                                </div>
                                @if ($errors->has('presupuesto'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('presupuesto') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.carpetacliente.fields.presupuesto_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="plano">{{ trans('cruds.carpetacliente.fields.plano') }}</label>
                                <div class="needsclick dropzone" id="plano-dropzone">
                                </div>
                                @if ($errors->has('plano'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('plano') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.carpetacliente.fields.plano_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="fftt">{{ trans('cruds.carpetacliente.fields.fftt') }}</label>
                                <div class="needsclick dropzone" id="fftt-dropzone">
                                </div>
                                @if ($errors->has('fftt'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('fftt') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.carpetacliente.fields.fftt_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="presentacion">{{ trans('cruds.carpetacliente.fields.presentacion') }}</label>
                                <div class="needsclick dropzone" id="presentacion-dropzone">
                                </div>
                                @if ($errors->has('presentacion'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('presentacion') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.carpetacliente.fields.presentacion_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="rectificacion">{{ trans('cruds.carpetacliente.fields.rectificacion') }}</label>
                                <div class="needsclick dropzone" id="rectificacion-dropzone">
                                </div>
                                @if ($errors->has('rectificacion'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('rectificacion') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.carpetacliente.fields.rectificacion_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="nb">{{ trans('cruds.carpetacliente.fields.nb') }}</label>
                                <div class="needsclick dropzone" id="nb-dropzone">
                                </div>
                                @if ($errors->has('nb'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nb') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.carpetacliente.fields.nb_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="course">{{ trans('cruds.carpetacliente.fields.course') }}</label>
                                <div class="needsclick dropzone" id="course-dropzone">
                                </div>
                                @if ($errors->has('course'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('course') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.carpetacliente.fields.course_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label
                                    for="id_fase_comercial_id">{{ trans('cruds.carpetacliente.fields.id_fase_comercial') }}</label>
                                <select class="form-control select2" name="id_fase_comercial_id" id="id_fase_comercial_id">
                                    @foreach ($id_fase_comercials as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ (old('id_fase_comercial_id') ? old('id_fase_comercial_id') : $carpetacliente->id_fase_comercial->id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_fase_comercial'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_fase_comercial') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.carpetacliente.fields.id_fase_comercial_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger" style="border-radius: 10px;" type="submit">
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
        Dropzone.options.presupuestoDropzone = {
            url: '{{ route('frontend.carpetaclientes.storeMedia') }}',
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
                $('form').find('input[name="presupuesto"]').remove()
                $('form').append('<input type="hidden" name="presupuesto" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="presupuesto"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($carpetacliente) && $carpetacliente->presupuesto)
                    var file = {!! json_encode($carpetacliente->presupuesto) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="presupuesto" value="' + file.file_name + '">')
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
        var uploadedPlanoMap = {}
        Dropzone.options.planoDropzone = {
            url: '{{ route('frontend.carpetaclientes.storeMedia') }}',
            maxFilesize: 8, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 8
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="plano[]" value="' + response.name + '">')
                uploadedPlanoMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedPlanoMap[file.name]
                }
                $('form').find('input[name="plano[]"][value="' + name + '"]').remove()
            },
            init: function() {
                @if (isset($carpetacliente) && $carpetacliente->plano)
                    var files =
                        {!! json_encode($carpetacliente->plano) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="plano[]" value="' + file.file_name + '">')
                    }
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
        var uploadedFfttMap = {}
        Dropzone.options.ffttDropzone = {
            url: '{{ route('frontend.carpetaclientes.storeMedia') }}',
            maxFilesize: 8, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 8
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="fftt[]" value="' + response.name + '">')
                uploadedFfttMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedFfttMap[file.name]
                }
                $('form').find('input[name="fftt[]"][value="' + name + '"]').remove()
            },
            init: function() {
                @if (isset($carpetacliente) && $carpetacliente->fftt)
                    var files =
                        {!! json_encode($carpetacliente->fftt) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="fftt[]" value="' + file.file_name + '">')
                    }
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
        var uploadedPresentacionMap = {}
        Dropzone.options.presentacionDropzone = {
            url: '{{ route('frontend.carpetaclientes.storeMedia') }}',
            maxFilesize: 8, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 8
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="presentacion[]" value="' + response.name + '">')
                uploadedPresentacionMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedPresentacionMap[file.name]
                }
                $('form').find('input[name="presentacion[]"][value="' + name + '"]').remove()
            },
            init: function() {
                @if (isset($carpetacliente) && $carpetacliente->presentacion)
                    var files =
                        {!! json_encode($carpetacliente->presentacion) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="presentacion[]" value="' + file.file_name +
                            '">')
                    }
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
        Dropzone.options.rectificacionDropzone = {
            url: '{{ route('frontend.carpetaclientes.storeMedia') }}',
            maxFilesize: 8, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 8
            },
            success: function(file, response) {
                $('form').find('input[name="rectificacion"]').remove()
                $('form').append('<input type="hidden" name="rectificacion" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="rectificacion"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($carpetacliente) && $carpetacliente->rectificacion)
                    var file = {!! json_encode($carpetacliente->rectificacion) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="rectificacion" value="' + file.file_name + '">')
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
        Dropzone.options.nbDropzone = {
            url: '{{ route('frontend.carpetaclientes.storeMedia') }}',
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
                $('form').find('input[name="nb"]').remove()
                $('form').append('<input type="hidden" name="nb" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="nb"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($carpetacliente) && $carpetacliente->nb)
                    var file = {!! json_encode($carpetacliente->nb) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="nb" value="' + file.file_name + '">')
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
        Dropzone.options.courseDropzone = {
            url: '{{ route('frontend.carpetaclientes.storeMedia') }}',
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
                $('form').find('input[name="course"]').remove()
                $('form').append('<input type="hidden" name="course" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="course"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($carpetacliente) && $carpetacliente->course)
                    var file = {!! json_encode($carpetacliente->course) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="course" value="' + file.file_name + '">')
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
