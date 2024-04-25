<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Empresa;
use App\Models\Role;
use App\Models\Sucursal;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with(['roles', 'empresa', 'sucursals', 'media'])->get();

        $roles = Role::get();

        $empresas = Empresa::get();

        $sucursals = Sucursal::get();

        return view('frontend.users.index', compact('empresas', 'roles', 'sucursals', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $empresas = Empresa::pluck('razon_social', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sucursals = Sucursal::pluck('nombre', 'id');

        return view('frontend.users.create', compact('empresas', 'roles', 'sucursals'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        $user->sucursals()->sync($request->input('sucursals', []));
        if ($request->input('foto_perfil', false)) {
            $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('foto_perfil'))))->toMediaCollection('foto_perfil');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $user->id]);
        }

        return redirect()->route('frontend.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $empresas = Empresa::pluck('razon_social', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sucursals = Sucursal::pluck('nombre', 'id');

        $user->load('roles', 'empresa', 'sucursals');

        return view('frontend.users.edit', compact('empresas', 'roles', 'sucursals', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));
        $user->sucursals()->sync($request->input('sucursals', []));
        if ($request->input('foto_perfil', false)) {
            if (! $user->foto_perfil || $request->input('foto_perfil') !== $user->foto_perfil->file_name) {
                if ($user->foto_perfil) {
                    $user->foto_perfil->delete();
                }
                $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('foto_perfil'))))->toMediaCollection('foto_perfil');
            }
        } elseif ($user->foto_perfil) {
            $user->foto_perfil->delete();
        }

        return redirect()->route('frontend.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles', 'empresa', 'sucursals', 'userUserAlerts');

        return view('frontend.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $users = User::find(request('ids'));

        foreach ($users as $user) {
            $user->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_create') && Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new User();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
