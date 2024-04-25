@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.my_profile') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('frontend.profile.update') }}">
                            @csrf
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }} input-custom"
                                    type="text" name="name" id="name"
                                    value="{{ old('name', auth()->user()->name) }}" required
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;"
                                    placeholder="Nombre">
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }} input-custom"
                                    type="text" name="email" id="email"
                                    value="{{ old('email', auth()->user()->email) }}" required
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;"
                                    placeholder="Email">
                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <button class="btn btn-ohffice" type="submit" style="border-radius: 5px">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.change_password') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('frontend.profile.password') }}">
                            @csrf
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label class="required" for="password">Nuevo
                                    {{ trans('cruds.user.fields.password') }}</label>
                                <input class="form-control input-custom" placeholder="Contraseña" type="password"
                                    name="password" id="password" required
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                @if ($errors->has('password'))
                                    <span class="help-block" role="alert">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="required" for="password_confirmation">Repetir nueva
                                    {{ trans('cruds.user.fields.password') }}</label>
                                <input class="form-control input-custom"placeholder="Repetir contraseña"
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;" type="password"
                                    name="password_confirmation" id="password_confirmation" required>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-ohffice" type="submit" style="border-radius: 5px">
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
