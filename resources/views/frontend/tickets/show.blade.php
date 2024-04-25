@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h2 class="fs-1">Información general</h2>
                    </div>

                    <div class="card-body">
                        <div class="row row-custom">
                            <div
                                class="form-group col-6  d-flex justify-content-center align-items-center flex-column card-body-custom">

                                <div class="card-body"style="width: 30vw; border-radius:16px;">
                                    <div class="mb-3">
                                        <div class="text-muted text-small mb-1">
                                            PROYECTO
                                        </div>
                                        <div>{{ $ticket->proyecto->nombre_proyecto ?? '' }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="text-muted text-small mb-1">CREADOR</div>
                                        <div>
                                            {{ $ticket->users->name }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="text-muted text-small mb-1">ASIGNADO</div>
                                        <div>{{ $ticket->vendedor->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="text-muted text-small mb-1">ASUNTO</div>
                                        <div> {{ $ticket->asunto }}</div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-6 card-body-custom">

                                <div class="card-body "style="border-radius: 16px;">
                                    <div class="row g-0">
                                        <div
                                            class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                            <div class="w-100 d-flex sh-1"></div>
                                            <div
                                                class=" shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                                <div class="bg-gradient-light sw-1 sh-1 rounded-xl position-relative">
                                                </div>
                                            </div>
                                            <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                                <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                                            </div>
                                        </div>
                                        <div class="col mb-4">
                                            <div class="h-100">
                                                <div class="d-flex flex-column justify-content-start">
                                                    <div class="d-flex flex-column">
                                                        <a href="#" class="heading stretched-link">Creacion de la
                                                            solicitud</a>
                                                        <p class="text-alternate">
                                                            {{ $ticket->created_at ? $ticket->created_at : 'Pendiente' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-0">
                                        <div
                                            class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                            <div class="w-100 d-flex sh-1 position-relative justify-content-center">
                                                <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                                            </div>
                                            <div
                                                class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                                <div class="bg-gradient-light sw-1 sh-1 rounded-xl position-relative">
                                                </div>
                                            </div>
                                            <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                                <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                                            </div>
                                        </div>
                                        <div class="col mb-4">
                                            <div class="h-100">
                                                <div class="d-flex flex-column justify-content-start">
                                                    <div class="d-flex flex-column">
                                                        <a href="#" class="heading stretched-link">Respuesta</a>
                                                        <p class="text-alternate">
                                                            {{ $ticket->updated_at ? $ticket->updated_at : 'Pendiente' }}
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-0">
                                        <div
                                            class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                            <div class="w-100 d-flex sh-1 position-relative justify-content-center">
                                                <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                                            </div>
                                            <div
                                                class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                                <div class="bg-gradient-light sw-1 sh-1 rounded-xl position-relative">
                                                </div>
                                            </div>
                                            <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="h-100">
                                                <div class="d-flex flex-column justify-content-start">
                                                    <div class="d-flex flex-column">
                                                        <a href="#" class="heading stretched-link pt-0">Solicitud
                                                            resuelta</a>
                                                        <p class="text-alternate">
                                                            {{ $ticket->deleted_at ? $ticket->created_at : 'Aun sin resolver' }}
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div>
                            <p>
                            <h2>Historial de solicitud</h2>
                            <p><strong>Fecha de cierre:</strong> En curso</p>
                            </p>


                            @foreach ($ticket->mensaje as $mensaje)
                                @if ($loop->last)
                                @endif
                                <div class="card mb-2">
                                    <div class="card-body ">

                                        <div class="mb-4 pb-4 border-bottom border-separator-light">






                                            <div class="col ps-3">
                                                <div class="row h-100 row-custom-chat">
                                                    <div class="col-4 col-md-2 custom-img-perfil">
                                                        @if ($mensaje->sender?->getFotoPerfilAttribute() == null)
                                                            <div class="small text-medium-emphasis text-nowrap fw-bold">
                                                                <img src="" alt="user image"
                                                                    class="card-img rounded-xl sh-5 sw-5">
                                                            </div>
                                                        @else
                                                            <?php $media = $mensaje->sender->getFotoPerfilAttribute();
                                                            $media->getFullUrl(); ?>
                                                            <img src="{{ $media->getFullUrl() }}" alt="foto-perfil-usuario"
                                                                style="object-fit: cover" class="img-fluid rounded-xl">
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="col-8 col-md-10 h-sm-100 d-flex flex-column justify-content-sm-center mb-1 mb-sm-0">
                                                        <h5 class="card-title custom-chat-title pt-4 fs-4">
                                                            {{ $mensaje->sender->name }}
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="row pt-4">
                                                    <div class="col-12 order-3 text-small text-muted text-sm-end d-flex flex-column justify-content-sm-center"
                                                        style="padding: 0 !important; margin: 0 !important;">
                                                        Fecha: {{ $mensaje->created_at }}
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <p class="pt-5"
                                                            style="padding-left: 0 !important; margin-left:0 !important;">
                                                            {{ $mensaje->mensaje }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="label label-info"></span>
                            @endforeach
                            <form action="{{ route('frontend.tickets.storeMensaje') }}" method="post">
                                @csrf
                                <div class="input-group mb-3 col-12">


                                    <input type="hidden" name="proyecto_id" value="{{ $ticket->proyecto_id }}">
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                    <textarea style="border-radius:10px; background-color: #f8f8f8 !important" class="form-control" name="mensaje"
                                        placeholder="Envía un nuevo mensaje..." aria-label="Recipient's new message" aria-describedby="button-addon2"
                                        style=""></textarea>
                                    <input class="btn btn-outline-success" style="border-radius:10px; margin:0 1rem"
                                        type="submit" id="btn-enviar-mensaje-ticket" value="Enviar" />
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

                <div class="form-group mb-3 col-12">
                    <a class="btn btn-default" href="{{ route('frontend.tickets.index') }}" style="border-radius:10px">
                        Salir
                    </a>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    </div>
@endsection
