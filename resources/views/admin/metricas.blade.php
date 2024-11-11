@extends('layouts.admin')
<div class="card">
    <div class="card-head">

    </div>
    <div class="card-body">
        @foreach ($proyectos as $proyecto)
            <p>{{$proyecto->id}}</p>
        @endforeach
    </div>
    <div class="card-footer">

    </div>
</div>