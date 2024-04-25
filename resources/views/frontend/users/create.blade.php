@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('frontend.users.store') }}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ old('name', '') }}" required placeholder="Nombre">
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                                <input class="form-control" type="email" name="email" id="email"
                                    value="{{ old('email') }}" required placeholder="Email">
                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                                <input class="form-control" type="password" name="password" id="password" required
                                    placeholder="Contraseña">
                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                                <div style="padding-bottom: 4px">
                                    <span class="btn btn-info btn-xs select-all"
                                        style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                    <span class="btn btn-info btn-xs deselect-all"
                                        style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                </div>
                                <select class="form-control select2" name="roles[]" id="roles" multiple required>
                                    @foreach ($roles as $id => $role)
                                        <option value="{{ $id }}"
                                            {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('roles'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('roles') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="empresa_id">{{ trans('cruds.user.fields.empresa') }}</label>
                                <select class="form-control select2" name="empresa_id" id="empresa_id">
                                    @foreach ($empresas as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ old('empresa_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('empresa'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('empresa') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.user.fields.empresa_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="sucursals">{{ trans('cruds.user.fields.sucursal') }}</label>
                                <div style="padding-bottom: 4px">
                                    <span class="btn btn-info btn-xs select-all"
                                        style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                    <span class="btn btn-info btn-xs deselect-all"
                                        style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                </div>
                                <select class="form-control select2" name="sucursals[]" id="sucursals" multiple>
                                    @foreach ($sucursals as $id => $sucursal)
                                        <option value="{{ $id }}"
                                            {{ in_array($id, old('sucursals', [])) ? 'selected' : '' }}>
                                            {{ $sucursal }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('sucursals'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('sucursals') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.user.fields.sucursal_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="foto_perfil">{{ trans('cruds.user.fields.foto_perfil') }}</label>
                                <div class="needsclick dropzone" id="foto_perfil-dropzone">
                                </div>
                                @if ($errors->has('foto_perfil'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('foto_perfil') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.user.fields.foto_perfil_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="telefono">{{ trans('cruds.user.fields.telefono') }}</label>
                                <input class="form-control" type="text" name="telefono" id="telefono"
                                    value="{{ old('telefono', '') }}">
                                @if ($errors->has('telefono'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('telefono') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.user.fields.telefono_helper') }}</span>
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
        Dropzone.options.fotoPerfilDropzone = {
            url: '{{ route('frontend.users.storeMedia') }}',
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
            success: function(file, response) {
                $('form').find('input[name="foto_perfil"]').remove()
                $('form').append('<input type="hidden" name="foto_perfil" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="foto_perfil"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($user) && $user->foto_perfil)
                    var file = {!! json_encode($user->foto_perfil) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="foto_perfil" value="' + file.file_name + '">')
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
