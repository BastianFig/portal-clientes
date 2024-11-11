@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-head">

        </div>
        <div class="card-body">
            @foreach ($proyectos as $proyecto)
                {{$proyecto->vendedor_nombre }}
                {{ $proyecto->fase }}
                {{ $proyecto->total_proyectos }}
            @endforeach
        </div>
        <div class="card-footer">

        </div>
    </div>
@endsection