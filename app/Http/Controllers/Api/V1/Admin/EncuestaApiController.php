<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEncuestumRequest;
use App\Http\Requests\UpdateEncuestumRequest;
use App\Http\Resources\Admin\EncuestumResource;
use App\Models\Encuestum;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EncuestaApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('encuestum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EncuestumResource(Encuestum::all());
    }

    public function store(StoreEncuestumRequest $request)
    {
        $encuestum = Encuestum::create($request->all());

        return (new EncuestumResource($encuestum))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Encuestum $encuestum)
    {
        abort_if(Gate::denies('encuestum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EncuestumResource($encuestum);
    }

    public function update(UpdateEncuestumRequest $request, Encuestum $encuestum)
    {
        $encuestum->update($request->all());

        return (new EncuestumResource($encuestum))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Encuestum $encuestum)
    {
        abort_if(Gate::denies('encuestum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $encuestum->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
