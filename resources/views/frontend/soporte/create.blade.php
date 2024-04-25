@extends('layouts.frontend')
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        <ul class="list-unstyled">
            <li>Solicitud enviada correctamente</li>
        </ul>
    </div>
@elseif (session('error'))
    <div class="alert alert-danger">
        <ul class="list-unstyled">
            <li>Error al enviar la solicitud</li>
        </ul>
    </div>
@endif
<div class="col">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Enviar solicitud de soporte 👨‍💻</h3>
                    <p>Si tienes algun problema o duda con la plataforma contactanos por WhatsApp <a href="https://api.whatsapp.com/send?phone=56957291932" target="_blank">Aquí (Whatsapp: +56957291932)</a>.</p>
                </div>
                <div class="card-body">
                    <form action="{{route('frontend.soporteSendmail')}}" method="POST" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input value="{{Auth::user()->name}}" type="text" placeholder="Nombre" class="form-control input-custom" style="border: none; background-color: #f8f8f8; border-radius: 10px;" id="soporte-nombre">
                    </div>
                    <div class="form-group">
                        <label for="mail">Email</label>
                        <input value="{{Auth::user()->email}}" type="mail" placeholder="Mail" class="form-control input-custom" style="border: none; background-color: #f8f8f8; border-radius: 10px;" id="soporte-mail">
                    </div>
                    <div class="form-group">
                        <label for="empresa">Empresa</label>
                        <input value="{{Auth::user()->empresa->nombe_de_fantasia}}" type="text" placeholder="Empresa" class="form-control input-custom" style="border: none; background-color: #f8f8f8; border-radius: 10px;" id="soporte-empresa">
                    </div>
                    <div class="form-group">
                        <label for="asunto">Asunto</label>
                        <input type="text" placeholder="Asunto" class="form-control input-custom" style="border: none; background-color: #f8f8f8; border-radius: 10px;" id="soporte-asunto"> 
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea name="mensaje" id="soporte-mensaje" cols="30" rows="10" placeholder="Mensaje" class="form-control input-custom" style="border: none; background-color: #f8f8f8; border-radius: 10px;"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success">Enviar</button>
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

        $(document).ready(() => {
    $('form').submit(function (e) {
        e.preventDefault();

        let nombre = $('#soporte-nombre').val();
        let mail = $('#soporte-mail').val();
        let empresa = $('#soporte-empresa').val();
        let asunto = $('#soporte-asunto').val();
        let mensaje = $('#soporte-mensaje').val();
        
        $.post('{{ route('frontend.soporteSendmail') }}', {
            _token: $('input[name=_token]').val(),
            nombre: nombre,
            mail: mail,
            empresa: empresa,
            asunto: asunto,
            mensaje: mensaje
        }).done(function (response) {
            $('#soporte-asunto').val('');
            $('#soporte-mensaje').val('');
            alert('Solicitud de soporte enviada correctamente');
        }).fail(function(xhr, textStatus, errorThrown){
            alert('Error al enviar la solicitud de soporte');
        return;
        });
    });
});
    </script>
@endsection 