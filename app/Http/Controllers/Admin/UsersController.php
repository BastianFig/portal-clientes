<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\EnvioCredencialesAcceso;
use Illuminate\Support\Facades\DB;
use Auth;




class UsersController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['roles', 'empresa', 'sucursals'])->select(sprintf('%s.*', (new User)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $crudRoutePart = 'users';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });

            $table->editColumn('roles', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });
            $table->addColumn('empresa_razon_social', function ($row) {
                return $row->empresa ? $row->empresa->razon_social : '';
            });

            $table->editColumn('empresa.rut', function ($row) {
                return $row->empresa ? (is_string($row->empresa) ? $row->empresa : $row->empresa->rut) : '';
            });
            $table->editColumn('sucursal', function ($row) {
                $labels = [];
                foreach ($row->sucursals as $sucursal) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $sucursal->nombre);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('foto_perfil', function ($row) {
                if ($photo = $row->foto_perfil) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('telefono', function ($row) {
                return $row->telefono ? $row->telefono : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'roles', 'empresa', 'sucursal', 'foto_perfil']);

            return $table->make(true);
        }

        $roles = Role::get();
        $empresas = Empresa::get();
        $sucursals = Sucursal::get();

        return view('admin.users.index', compact('roles', 'empresas', 'sucursals'));
    }

    public function getSucursales(Request $request)
    {

        $id_empresa = $request->id_empresa;
        $cuando_empresa = [
            ['empresa_id', '=', $id_empresa]
        ];
        $sucursales = Sucursal::orderby('nombre', 'asc')->select('id', 'nombre')->where($cuando_empresa)->get();
        $response = array();
        foreach ($sucursales as $sucursal) {
            $response[] = array(
                "id" => $sucursal->id,
                "text" => $sucursal->nombre
            );
        }
        return response()->json($response);
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $empresas = Empresa::orderby('razon_social')->pluck('razon_social', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sucursals = Sucursal::pluck('nombre', 'id');
        $user = Auth::user();
        //dd($user->roles);
        foreach ($user->roles as $rol) {
            $rol_activo = $rol->title;
        }

        return view('admin.users.create', compact('empresas', 'roles', 'sucursals', 'rol_activo'));
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

        // Obtener los datos necesarios para el correo electrónico
        $email = $user->email;
        $name = $user->name;
        $password = $request->input('password'); // Así asumiremos que el campo "password" viene en el formulario

        // Verificar que el email sea válido antes de enviar el correo
        if ($email) {
            Mail::to($email)->send(new EnvioCredencialesAcceso($name, $email, $password));
        } else {
            // Manejar el caso en que el email es nulo o no válido
            // Por ejemplo, mostrar un mensaje de error o registrar un error en el log.
        }

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$roles = Role::pluck('title', 'id');

        $Userconectado = auth()->user();

        if ($Userconectado->roles->contains('title', 'Admin')) {
            $roles = Role::pluck('title', 'id');
        } else {
            $roles = Role::where('title', 'User')->pluck('title', 'id');
        }


        $empresas = Empresa::Orderby('razon_social')->pluck('razon_social', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sucursals = Sucursal::pluck('nombre', 'id');

        $user->load('roles', 'empresa', 'sucursals');

        return view('admin.users.edit', compact('empresas', 'roles', 'sucursals', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));
        $user->sucursals()->sync($request->input('sucursals', []));
        if ($request->input('foto_perfil', false)) {
            if (!$user->foto_perfil || $request->input('foto_perfil') !== $user->foto_perfil->file_name) {
                if ($user->foto_perfil) {
                    $user->foto_perfil->delete();
                }
                $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('foto_perfil'))))->toMediaCollection('foto_perfil');
            }
        } elseif ($user->foto_perfil) {
            $user->foto_perfil->delete();
        }

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles', 'empresa', 'sucursals', 'userUserAlerts', 'idUsuariosClienteProyectos');

        return view('admin.users.show', compact('user'));
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

        $model = new User();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
