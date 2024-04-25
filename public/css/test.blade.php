<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <div class="text-muted text-small mb-1">
                {{ trans('cruds.ticket.fields.proyecto') }}
            </div>
            <div>{{ $ticket->proyecto->nombre_proyecto ?? '' }}</div>
        </div>
        <div class="mb-3">
            <div class="text-muted text-small mb-1">Creador</div>
            <div>
                {{ $ticket->users->name }}
            </div>
        </div>
        <div class="mb-3">
            <div class="text-muted text-small mb-1">Asignado</div>
            <div>{{ $ticket->vendedor->name }}</div>
        </div>
        <div class="mb-3">
            <div class="text-muted text-small mb-1">Asunto</div>
            <div> {{ $ticket->asunto }}</div>
        </div>
    </div>
</div>
