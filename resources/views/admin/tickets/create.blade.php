@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.ticket.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.tickets.store') }}" enctype="multipart/form-data">
                @csrf

                <!--ACA VAN LOS ID DEL USER Y DEL VENDEDOR EN HIDDEN -->
                <input type="hidden" name="vendedor_id" id="vendedor_id" value="">
                <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
                <input type="hidden" name="estado" id="estado" value="Activo">
                <div class="form-group">
                    <label class="required" for="proyecto_id">{{ trans('cruds.ticket.fields.proyecto') }}</label>
                    <select class="form-control select-personalizado {{ $errors->has('proyecto') ? 'is-invalid' : '' }}"
                        name="proyecto_id" id="proyecto_id" required>

                        @foreach ($proyectos as $id => $entry)
                            <option value="{{ $id }}" {{ old('proyecto_id') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach

                    </select>
                    @if ($errors->has('proyecto'))
                        <div class="invalid-feedback">
                            {{ $errors->first('proyecto') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.ticket.fields.proyecto_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="asunto">{{ trans('cruds.ticket.fields.asunto') }}</label>
                    <input class="form-control {{ $errors->has('asunto') ? 'is-invalid' : '' }}" type="text"
                        name="asunto" id="asunto" value="{{ old('asunto', '') }}">
                    @if ($errors->has('asunto'))
                        <div class="invalid-feedback">
                            {{ $errors->first('asunto') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.ticket.fields.asunto_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea class="form-control" type="text" name="mensaje" id="mensaje" value="{{ old('mensaje', '') }}"></textarea>
                    @if ($errors->has('mensaje'))
                        <div class="invalid-feedback">
                            {{ $errors->first('mensaje') }}
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
        $(document).ready(function() {
            $('#boton-guardar').prop('disabled', true);
            $('#proyecto_id').on('change', function() {
                var id_proyecto = $(this).val();
                $('#boton-guardar').prop('disabled', false);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.tickets.getVendedor') }}",
                    type: "post",
                    dataType: 'json',
                    data: {
                        id_proyecto: id_proyecto
                    },
                    success: function(response) {
                        $("#vendedor_id").val(response);
                    },
                });
            });
        });
    </script>
@endsection
