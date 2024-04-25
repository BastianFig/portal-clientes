@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.ticket.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tickets.update", [$ticket->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="proyecto_id">{{ trans('cruds.ticket.fields.proyecto') }}</label>
                <select class="form-control select2 {{ $errors->has('proyecto') ? 'is-invalid' : '' }}" name="proyecto_id" id="proyecto_id" required>
                    @foreach($proyectos as $id => $entry)
                        <option value="{{ $id }}" {{ (old('proyecto_id') ? old('proyecto_id') : $ticket->proyecto->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('proyecto'))
                    <div class="invalid-feedback">
                        {{ $errors->first('proyecto') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ticket.fields.proyecto_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="users">{{ trans('cruds.ticket.fields.user') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}" name="users[]" id="users" multiple>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (in_array($id, old('users', [])) || $ticket->users->contains($id)) ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('users'))
                    <div class="invalid-feedback">
                        {{ $errors->first('users') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ticket.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="asunto">{{ trans('cruds.ticket.fields.asunto') }}</label>
                <input class="form-control {{ $errors->has('asunto') ? 'is-invalid' : '' }}" type="text" name="asunto" id="asunto" value="{{ old('asunto', $ticket->asunto) }}">
                @if($errors->has('asunto'))
                    <div class="invalid-feedback">
                        {{ $errors->first('asunto') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ticket.fields.asunto_helper') }}</span>
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