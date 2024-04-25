<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCarpetaclienteRequest;
use App\Http\Requests\StoreCarpetaclienteRequest;
use App\Http\Requests\UpdateCarpetaclienteRequest;
use App\Models\Carpetacliente;
use App\Models\Fasecomercialproyecto;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CarpetaclienteController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('carpetacliente_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Carpetacliente::with(['id_fase_comercial'])->select(sprintf('%s.*', (new Carpetacliente)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'carpetacliente_show';
                $editGate      = 'carpetacliente_edit';
                $deleteGate    = 'carpetacliente_delete';
                $crudRoutePart = 'carpetaclientes';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('presupuesto', function ($row) {
                return $row->presupuesto ? '<a href="' . $row->presupuesto->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('plano', function ($row) {
                if (! $row->plano) {
                    return '';
                }
                $links = [];
                foreach ($row->plano as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });
            $table->editColumn('fftt', function ($row) {
                if (! $row->fftt) {
                    return '';
                }
                $links = [];
                foreach ($row->fftt as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });
            $table->editColumn('presentacion', function ($row) {
                if (! $row->presentacion) {
                    return '';
                }
                $links = [];
                foreach ($row->presentacion as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });
            $table->editColumn('rectificacion', function ($row) {
                return $row->rectificacion ? '<a href="' . $row->rectificacion->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('nb', function ($row) {
                return $row->nb ? '<a href="' . $row->nb->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('course', function ($row) {
                return $row->course ? '<a href="' . $row->course->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->addColumn('id_fase_comercial_estado', function ($row) {
                return $row->id_fase_comercial ? $row->id_fase_comercial->estado : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'presupuesto', 'plano', 'fftt', 'presentacion', 'rectificacion', 'nb', 'course', 'id_fase_comercial']);

            return $table->make(true);
        }

        return view('admin.carpetaclientes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('carpetacliente_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_fase_comercials = Fasecomercialproyecto::pluck('estado', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.carpetaclientes.create', compact('id_fase_comercials'));
    }

    public function store(StoreCarpetaclienteRequest $request)
    {
        $carpetacliente = Carpetacliente::create($request->all());

        if ($request->input('presupuesto', false)) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('presupuesto'))))->toMediaCollection('presupuesto');
        }

        foreach ($request->input('plano', []) as $file) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('plano');
        }

        foreach ($request->input('fftt', []) as $file) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('fftt');
        }

        foreach ($request->input('presentacion', []) as $file) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('presentacion');
        }

        if ($request->input('rectificacion', false)) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('rectificacion'))))->toMediaCollection('rectificacion');
        }

        if ($request->input('nb', false)) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('nb'))))->toMediaCollection('nb');
        }

        if ($request->input('course', false)) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('course'))))->toMediaCollection('course');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $carpetacliente->id]);
        }

        return redirect()->route('admin.carpetaclientes.index');
    }

    public function edit(Carpetacliente $carpetacliente)
    {
        abort_if(Gate::denies('carpetacliente_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_fase_comercials = Fasecomercialproyecto::pluck('estado', 'id')->prepend(trans('global.pleaseSelect'), '');

        $carpetacliente->load('id_fase_comercial');

        return view('admin.carpetaclientes.edit', compact('carpetacliente', 'id_fase_comercials'));
    }

    public function update(UpdateCarpetaclienteRequest $request, Carpetacliente $carpetacliente)
    {
        $carpetacliente->update($request->all());

        if ($request->input('presupuesto', false)) {
            if (! $carpetacliente->presupuesto || $request->input('presupuesto') !== $carpetacliente->presupuesto->file_name) {
                if ($carpetacliente->presupuesto) {
                    $carpetacliente->presupuesto->delete();
                }
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('presupuesto'))))->toMediaCollection('presupuesto');
            }
        } elseif ($carpetacliente->presupuesto) {
            $carpetacliente->presupuesto->delete();
        }

        if (count($carpetacliente->plano) > 0) {
            foreach ($carpetacliente->plano as $media) {
                if (! in_array($media->file_name, $request->input('plano', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carpetacliente->plano->pluck('file_name')->toArray();
        foreach ($request->input('plano', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('plano');
            }
        }

        if (count($carpetacliente->fftt) > 0) {
            foreach ($carpetacliente->fftt as $media) {
                if (! in_array($media->file_name, $request->input('fftt', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carpetacliente->fftt->pluck('file_name')->toArray();
        foreach ($request->input('fftt', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('fftt');
            }
        }

        if (count($carpetacliente->presentacion) > 0) {
            foreach ($carpetacliente->presentacion as $media) {
                if (! in_array($media->file_name, $request->input('presentacion', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carpetacliente->presentacion->pluck('file_name')->toArray();
        foreach ($request->input('presentacion', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('presentacion');
            }
        }

        if ($request->input('rectificacion', false)) {
            if (! $carpetacliente->rectificacion || $request->input('rectificacion') !== $carpetacliente->rectificacion->file_name) {
                if ($carpetacliente->rectificacion) {
                    $carpetacliente->rectificacion->delete();
                }
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('rectificacion'))))->toMediaCollection('rectificacion');
            }
        } elseif ($carpetacliente->rectificacion) {
            $carpetacliente->rectificacion->delete();
        }

        if ($request->input('nb', false)) {
            if (! $carpetacliente->nb || $request->input('nb') !== $carpetacliente->nb->file_name) {
                if ($carpetacliente->nb) {
                    $carpetacliente->nb->delete();
                }
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('nb'))))->toMediaCollection('nb');
            }
        } elseif ($carpetacliente->nb) {
            $carpetacliente->nb->delete();
        }

        if ($request->input('course', false)) {
            if (! $carpetacliente->course || $request->input('course') !== $carpetacliente->course->file_name) {
                if ($carpetacliente->course) {
                    $carpetacliente->course->delete();
                }
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('course'))))->toMediaCollection('course');
            }
        } elseif ($carpetacliente->course) {
            $carpetacliente->course->delete();
        }

        return redirect()->route('admin.carpetaclientes.index');
    }

    public function show(Carpetacliente $carpetacliente)
    {
        abort_if(Gate::denies('carpetacliente_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carpetacliente->load('id_fase_comercial');

        return view('admin.carpetaclientes.show', compact('carpetacliente'));
    }

    public function destroy(Carpetacliente $carpetacliente)
    {
        abort_if(Gate::denies('carpetacliente_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carpetacliente->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarpetaclienteRequest $request)
    {
        $carpetaclientes = Carpetacliente::find(request('ids'));

        foreach ($carpetaclientes as $carpetacliente) {
            $carpetacliente->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('carpetacliente_create') && Gate::denies('carpetacliente_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Carpetacliente();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
