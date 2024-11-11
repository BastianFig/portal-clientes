@extends('layouts.admin')
@section('content')
    
    @foreach ($proyectos as $proyecto)
        <div class="card">
            <div class="card-head">
                <h2>{{$proyecto->vendedor_nombre }}</h2>
            </div>
            <div class="card-body">
                <p>{{ $proyecto->fase }}</p>
                <p>{{ $proyecto->total_proyectos }}</p>
            </div>
            <div class="card-footer">

            </div>
        </div>
    @endforeach
        
@endsection