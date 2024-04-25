<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFasePostventumRequest;
use App\Http\Requests\UpdateFasePostventumRequest;
use App\Http\Resources\Admin\FasePostventumResource;
use App\Models\FasePostventum;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FasePostventaApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fase_postventum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasePostventumResource(FasePostventum::with(['encuesta', 'ticket', 'id_proyecto', 'id_usuarios'])->get());
    }

    public function store(StoreFasePostventumRequest $request)
    {
        $fasePostventum = FasePostventum::create($request->all());
        $fasePostventum->id_usuarios()->sync($request->input('id_usuarios', []));

        return (new FasePostventumResource($fasePostventum))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FasePostventum $fasePostventum)
    {
        abort_if(Gate::denies('fase_postventum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasePostventumResource($fasePostventum->load(['encuesta', 'ticket', 'id_proyecto', 'id_usuarios']));
    }

    public function update(UpdateFasePostventumRequest $request, FasePostventum $fasePostventum)
    {
        $fasePostventum->update($request->all());
        $fasePostventum->id_usuarios()->sync($request->input('id_usuarios', []));

        return (new FasePostventumResource($fasePostventum))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FasePostventum $fasePostventum)
    {
        abort_if(Gate::denies('fase_postventum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasePostventum->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
