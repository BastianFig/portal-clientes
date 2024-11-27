<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProyectoRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Requests\StoreProyectoRequest;
use App\Http\Requests\StoreFaseDisenoRequest;
use App\Http\Requests\StoreFasecomercialRequest;
use App\Http\Requests\StoreFasecontableRequest;
use App\Http\Requests\StoreFasecomercialproyectoRequest;
use App\Http\Requests\StoreFasefabricaRequest;
use App\Http\Requests\StoreFasedespachoRequest;
use App\Http\Requests\StoreFasePostventumRequest;
use App\Http\Requests\StoreCarpetaclienteRequest;
use App\Http\Requests\UpdateProyectoRequest;
use App\Models\Empresa;
use App\Models\Proyecto;
use App\Models\Sucursal;
use App\Models\FaseDiseno;
use App\Models\Fasecomercial;
use App\Models\Fasecomercialproyecto;
use App\Models\Fasecontable;
use App\Models\Fasedespacho;
use App\Models\Fasefabrica;
use App\Models\FasePostventum;
use App\Models\Carpetacliente;
use App\Models\User;
use Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\UserAlert;
use App\Mail\CambioDeFase;
use App\Mail\ConfirmaHorario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Storage;



class ProyectoController extends Controller
{
    use MediaUploadingTrait;

    public function Alerta_modifica($id_proyecto, $texto)
    {
        $proyecto_info = Proyecto::with('id_usuarios_clientes')->find($id_proyecto);

        // Datos básicos de la alerta
        $data_alerta = ["alert_text" => $texto, "aler_link" => "test test test"];

        // Acumular los IDs de los usuarios clientes
        $data_alert_users = []; // Inicializamos como un array vacío

        foreach ($proyecto_info->id_usuarios_clientes as $usuario_cliente) {
            $data_alert_users[] = $usuario_cliente->id; // Añadimos el ID al array
        }

        // Crear la alerta de usuario
        $userAlert = UserAlert::create($data_alerta);

        // Asociar los usuarios a la alerta
        $userAlert->users()->sync($data_alert_users);
    }

    public function storeFasediseno(StoreFaseDisenoRequest $request)
    {
        abort_if(Gate::denies('fase_diseno_create') && Gate::denies('fase_diseno_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $aux = $request->all();
        if (empty($request->input('id_fasediseno'))) { //NUEVA
            if ($request->descripcion != NULL && $request->input('imagenes') != NULL) { //LLENA DE DATOS
                $faseDiseno = FaseDiseno::create($request->all());

                foreach ($request->input('imagenes', []) as $file) {
                    $faseDiseno->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('imagenes');
                }

                foreach ($request->input('propuesta', []) as $file) {
                    $faseDiseno->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('propuesta');
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $faseDiseno->id]);
                }
                $faseDiseno->estado = 'Completa';
                $faseDiseno->save();
                DB::update('UPDATE proyectos SET fase = "Fase Propuesta Comercial" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase de Diseño de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);

            } elseif ($request->descripcion == NULL && $request->input('imagenes') == NULL) { //VACIA
                $mensaje_aux = "Debe llenar los campos para continuar a la siguiente fase.";
                return back()->withErrors($mensaje_aux);
            } else {//POCOS DATOS

                $faseDiseno = FaseDiseno::create($request->all());
                $faseDiseno->estado = 'Activa';
                $faseDiseno->save();
                $txt = "Se ha modificado la Fase de Diseño de tu proyecto";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
            }
            DB::update('UPDATE proyectos SET id_fasediseno = ' . $faseDiseno->id . ' WHERE id = ' . $request->id_proyecto_id);
        } else { //EXISTENTE
            $faseDiseno = FaseDiseno::find($request->input('id_fasediseno'));
            $faseDiseno->update($request->all());

            if (count($faseDiseno->imagenes) > 0) {
                foreach ($faseDiseno->imagenes as $media) {
                    if (!in_array($media->file_name, $request->input('imagenes', []))) {
                        $media->delete();
                    }
                }
            }
            $media = $faseDiseno->imagenes->pluck('file_name')->toArray();
            foreach ($request->input('imagenes', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $faseDiseno->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('imagenes');
                }
            }

            if (count($faseDiseno->propuesta) > 0) {
                foreach ($faseDiseno->propuesta as $media) {
                    if (!in_array($media->file_name, $request->input('propuesta', []))) {
                        $media->delete();
                    }
                }
            }
            $media = $faseDiseno->propuesta->pluck('file_name')->toArray();
            foreach ($request->input('propuesta', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $faseDiseno->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('propuesta');
                }
            }
            if ($request->descripcion != NULL && $request->input('imagenes') != NULL) {//LLENA DE DATOS
                $faseDiseno->estado = 'Completa';
                $faseDiseno->save();
                DB::update('UPDATE proyectos SET fase = "Fase Propuesta Comercial" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase de Diseño de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
            } elseif ($request->descripcion == NULL && $request->input('imagenes') == NULL) {//VACIA
                $mensaje_aux = "Debe llenar los campos para continuar a la siguiente fase.";
                return back()->withErrors($mensaje_aux);
            } else {//POCOS DATOS
                $txt = "Se ha modificado la Fase de Diseño de tu proyecto";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                $faseDiseno->estado = 'Activa';
                $faseDiseno->save();
            }


            DB::update('UPDATE proyectos SET id_fasediseno = ' . $faseDiseno->id . ' WHERE id = ' . $request->id_proyecto_id);
        }


        return back()->with('success', 'Datos guardados correctamente');
    }

    public function storeFasecomercial(StoreFasecomercialRequest $request)
    {
        abort_if(Gate::denies('fasecomercial_create') && Gate::denies('fasecomercial_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $id_proyecto_aux = $request->id_proyecto_id;
        $fasedisenoaux = Proyecto::find($id_proyecto_aux)->fasediseno;

        $proyecto = Proyecto::find($id_proyecto_aux);
        $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal', 'fasediseno', 'fasecomercial', 'fasecomercialproyecto', 'fasecontable', 'fasedespacho', 'fasefabrica', 'fasepostventa', 'carpetacliente');

        $messages_aux = "Debe Completar la Fase de Diseño.";
        if ($fasedisenoaux) {
            if ($fasedisenoaux->estado == 'Completa') {
                //return back()->with('success', 'Datos guardados correctamente');
            } else {
                return back()->withErrors($messages_aux);
            }
        } else {
            return back()->withErrors($messages_aux);
        }


        $aux = $request->all();
        if (empty($request->input('id_fasecomercial'))) {//NUEVA
            $txt = "Ha comenzado la fase comercial de tu proyecto";
            $this->Alerta_modifica($request->id_proyecto_id, $txt);

            if ($request->comentarios != NULL && $request->input('cotizacion') != NULL) { //LLENA DE DATOS
                $faseComercial = Fasecomercial::create($request->all());
                /*if ($request->input('cotizacion', false)) {
                    $faseComercial->addMedia(storage_path('tmp/uploads/' . basename($request->input('cotizacion'))))->toMediaCollection('cotizacion');
                }*/
                foreach ($request->input('cotizacion', []) as $file) {
                    $faseComercial->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('cotizacion');
                }

                if ($request->input('oc', false)) {
                    $faseComercial->addMedia(storage_path('tmp/uploads/' . basename($request->input('oc'))))->toMediaCollection('oc');
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $faseComercial->id]);
                }
                $faseComercial->estado = 'Completa';
                $faseComercial->save();
                DB::update('UPDATE proyectos SET fase = "Fase Contable" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase de Propuesta Comercial de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);

                $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                $id_proyecto = $proyecto->id;
                if ($proyecto) {
                    $nombre_proyecto = $proyecto->nombre_proyecto;

                    if ($userID) {
                        $user = User::find($userID->user_id);
                        $email = $user->email;
                        $name = $user->name;
                        $fase_anterior = "Fase de Propuesta Comercial";
                        $fase_actual = "Fase Contable";
                        $estado = $faseComercial->estado;

                        DB::update('UPDATE proyectos SET id_fasecomercial = ' . $faseComercial->id . ' WHERE id = ' . $request->id_proyecto_id);
                        if ($email) {
                            Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto, $estado));
                        }
                    }
                }
            } elseif ($request->comentarios == NULL && $request->input('cotizacion') == NULL) {//VACIA
                $mensaje_aux = "Debe llenar los campos para continuar a la siguiente fase.";
                return back()->withErrors($mensaje_aux);
            } else {// POCOS DATOS
                $faseComercial = Fasecomercial::create($request->all());
                /*if ($request->input('cotizacion', false)) {
                    $faseComercial->addMedia(storage_path('tmp/uploads/' . basename($request->input('cotizacion'))))->toMediaCollection('cotizacion');
                }*/
                foreach ($request->input('cotizacion', []) as $file) {
                    $faseComercial->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('cotizacion');
                }

                if ($request->input('oc', false)) {
                    $faseComercial->addMedia(storage_path('tmp/uploads/' . basename($request->input('oc'))))->toMediaCollection('oc');
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $faseComercial->id]);
                }
                $txt = "Se ha modificado la Fase de Propuesta Comercial de tu proyecto";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                $faseComercial->estado = 'Activa';
                $faseComercial->save();
                DB::update('UPDATE proyectos SET id_fasecomercial = ' . $faseComercial->id . ' WHERE id = ' . $request->id_proyecto_id);
            }

        } else {//EXISTENTE
            $faseComercial = Fasecomercial::find($request->input('id_fasecomercial'));
            $faseComercial->update($request->all());

            /*if ($request->input('cotizacion', false)) {
                if (!$faseComercial->cotizacion || $request->input('cotizacion') !== $faseComercial->cotizacion->file_name) {
                    if ($faseComercial->cotizacion) {
                        $faseComercial->cotizacion->delete();
                    }
                    $faseComercial->addMedia(storage_path('tmp/uploads/' . basename($request->input('cotizacion'))))->toMediaCollection('cotizacion');
                }
            } elseif ($faseComercial->cotizacion) {
                $faseComercial->cotizacion->delete();
            }*/

            if (count($faseComercial->cotizacion) > 0) {
                foreach ($faseComercial->cotizacion as $media) {
                    if (!in_array($media->file_name, $request->input('cotizacion', []))) {
                        $media->delete();
                    }
                }
            }
            $media2 = $faseComercial->cotizacion->pluck('file_name')->toArray();
            foreach ($request->input('cotizacion', []) as $file) {
                if (count($media2) === 0 || !in_array($file, $media2)) {
                    $faseComercial->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('cotizacion');
                }
            }

            if ($request->input('oc', false)) {
                if (!$faseComercial->oc || $request->input('oc') !== $faseComercial->oc->file_name) {
                    if ($faseComercial->oc) {
                        $faseComercial->oc->delete();
                    }
                    $faseComercial->addMedia(storage_path('tmp/uploads/' . basename($request->input('oc'))))->toMediaCollection('oc');
                }
            } elseif ($faseComercial->oc) {
                $faseComercial->oc->delete();
            }


            if ($request->comentarios != NULL && $request->input('cotizacion') != NULL) {
                $faseComercial->estado = 'Completa';
                $faseComercial->save();
                DB::update('UPDATE proyectos SET fase = "Fase Contable" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase de Propuesta Comercial de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);

                $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                $id_proyecto = $proyecto->id;
                if ($proyecto) {
                    $nombre_proyecto = $proyecto->nombre_proyecto;
                    $fase_anterior = "Fase de Propuesta Comercial";
                    $fase_actual = "Fase Contable";
                    if ($userID) {
                        $user = User::find($userID->user_id);
                        $email = $user->email;
                        $name = $user->name;
                        DB::update('UPDATE proyectos SET id_fasecomercial = ' . $faseComercial->id . ' WHERE id = ' . $request->id_proyecto_id);
                        if ($email) {
                            Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto, $txt));
                        }
                    }
                }

            } elseif ($request->comentarios == NULL && $request->input('cotizacion') == NULL) {
                $mensaje_aux = "Debe llenar los campos para continuar a la siguiente fase.";
                return back()->withErrors($mensaje_aux);
            } else {
                $faseComercial->estado = 'Activa';
                $faseComercial->save();
                $txt = "Se ha actualizado la Fase de Propuesta Comercial de tu proyecto";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                DB::update('UPDATE proyectos SET id_fasecomercial = ' . $faseComercial->id . ' WHERE id = ' . $request->id_proyecto_id);
            }


        }


        return back()->with('success', 'Datos guardados correctamente');
    }

    public function storeFasecontable(StoreFasecontableRequest $request)
    {
        abort_if(Gate::denies('fasecontable_create') && Gate::denies('fasecontable_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $id_proyecto_aux = $request->id_proyecto_id;
        $fasecomercialaux = Proyecto::find($id_proyecto_aux)->fasecomercial;

        $proyecto = Proyecto::find($id_proyecto_aux);
        $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal', 'fasediseno', 'fasecomercial', 'fasecomercialproyecto', 'fasecontable', 'fasedespacho', 'fasefabrica', 'fasepostventa', 'carpetacliente');
        $antiguedad = $proyecto->id_cliente->antiguedad_empresa;
        $messages_aux = "Debe Completar la Fase de Propuesta Comercial.";

        if ($fasecomercialaux) {
            if ($fasecomercialaux->estado == 'Completa') {
            } else {
                return back()->withErrors($messages_aux);
            }
        } else {
            return back()->withErrors($messages_aux);
        }

        $aux = $request->all();
        if (empty($request->input('id_fasecontables'))) {
            if ($request->input('anticipo_50') != NULL && $request->input('anticipo_40') != NULL && $request->input('anticipo_10') != NULL) {
                $faseContable = Fasecontable::create($request->all());
                /*if ($request->input('anticipo_50', false)) {
                    $faseContable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_50'))))->toMediaCollection('anticipo_50');
                }*/
                foreach ($request->input('anticipo_50', []) as $file) {
                    $faseContable->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('anticipo_50');
                }

                if ($request->input('anticipo_40', false)) {
                    $faseContable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_40'))))->toMediaCollection('anticipo_40');
                }

                if ($request->input('anticipo_10', false)) {
                    $faseContable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_10'))))->toMediaCollection('anticipo_10');
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $faseContable->id]);
                }
                $faseContable->estado = 'Completa';
                $faseContable->save();
                DB::update('UPDATE proyectos SET fase = "Fase Comercial" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase Contable de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                $id_proyecto = $proyecto->id;
                if ($proyecto) {
                    $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                    $nombre_proyecto = $proyecto->nombre_proyecto;
                    $fase_anterior = "Fase Contable";
                    $fase_actual = "Fase Comercial";
                    if ($userID) {
                        $user = User::find($userID->user_id);
                        $email = $user->email;
                        $name = $user->name;
                        DB::update('UPDATE proyectos SET id_fasecontables = ' . $faseContable->id . ' WHERE id = ' . $request->id_proyecto_id);
                        if ($email) {
                            Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
                        }
                    }
                }
            } elseif ($request->input('anticipo_50') == NULL && $antiguedad == "Nuevo") {
                $mensaje_aux = "Debe adjuntar el anticipo del 50% para continuar a la siguiente fase.";
                return back()->withErrors($mensaje_aux);
            } else {
                $faseContable = Fasecontable::create($request->all());
                /* if ($request->input('anticipo_50', false)) {
                     $faseContable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_50'))))->toMediaCollection('anticipo_50');
                 }*/

                foreach ($request->input('anticipo_50', []) as $file) {
                    $faseContable->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('anticipo_50');
                }

                if ($request->input('anticipo_40', false)) {
                    $faseContable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_40'))))->toMediaCollection('anticipo_40');
                }

                if ($request->input('anticipo_10', false)) {
                    $faseContable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_10'))))->toMediaCollection('anticipo_10');
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $faseContable->id]);
                }
                $faseContable->estado = 'Activa';
                $faseContable->save();
                $txt = "Se ha modificado la Fase Contable de tu proyecto";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                DB::update('UPDATE proyectos SET id_fasecontables = ' . $faseContable->id . ' WHERE id = ' . $request->id_proyecto_id);
                DB::update('UPDATE proyectos SET fase = "Fase Comercial" WHERE id = ' . $request->id_proyecto_id);
            }


        } else {
            $faseContable = Fasecontable::find($request->input('id_fasecontables'));
            $faseContable->update($request->all());

            /*if ($request->input('anticipo_50', false)) {
                if (!$faseContable->anticipo_50 || $request->input('anticipo_50') !== $faseContable->anticipo_50->file_name) {
                    if ($faseContable->anticipo_50) {
                        $faseContable->anticipo_50->delete();
                    }
                    $faseContable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_50'))))->toMediaCollection('anticipo_50');
                }
            } elseif ($faseContable->anticipo_50) {
                $faseContable->anticipo_50->delete();
            }*/

            if (count($faseContable->anticipo_50) > 0) {
                foreach ($faseContable->anticipo_50 as $media) {
                    if (!in_array($media->file_name, $request->input('anticipo_50', []))) {
                        $media->delete();
                    }
                }
            }
            $media = $faseContable->anticipo_50->pluck('file_name')->toArray();
            foreach ($request->input('anticipo_50', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $faseContable->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('anticipo_50');
                }
            }

            if ($request->input('anticipo_40', false)) {
                if (!$faseContable->anticipo_40 || $request->input('anticipo_40') !== $faseContable->anticipo_40->file_name) {
                    if ($faseContable->anticipo_40) {
                        $faseContable->anticipo_40->delete();
                    }
                    $faseContable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_40'))))->toMediaCollection('anticipo_40');
                }
            } elseif ($faseContable->anticipo_40) {
                $faseContable->anticipo_40->delete();
            }

            if ($request->input('anticipo_10', false)) {
                if (!$faseContable->anticipo_10 || $request->input('anticipo_10') !== $faseContable->anticipo_10->file_name) {
                    if ($faseContable->anticipo_10) {
                        $faseContable->anticipo_10->delete();
                    }
                    $faseContable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_10'))))->toMediaCollection('anticipo_10');
                }
            } elseif ($faseContable->anticipo_10) {
                $faseContable->anticipo_10->delete();
            }

            if ($request->input('anticipo_50') != NULL && $request->input('anticipo_40') != NULL && $request->input('anticipo_10') != NULL) {
                $faseContable->estado = 'Completa';
                $faseContable->save();
                DB::update('UPDATE proyectos SET fase = "Fase Comercial" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase Contable de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                $id_proyecto = $proyecto->id;
                if ($proyecto) {
                    $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                    $nombre_proyecto = $proyecto->nombre_proyecto;
                    $fase_anterior = "Fase Contable";
                    $fase_actual = "Fase Comercial";
                    if ($userID) {
                        $user = User::find($userID->user_id);
                        $email = $user->email;
                        $name = $user->name;
                        DB::update('UPDATE proyectos SET id_fasecontables = ' . $faseContable->id . ' WHERE id = ' . $request->id_proyecto_id);
                        if ($email) {
                            Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
                        }
                    }
                }
            } elseif ($request->input('anticipo_50') == NULL && $antiguedad == "Nuevo") {
                $mensaje_aux = "Debe adjuntar el anticipo del 50% para continuar a la siguiente fase.";
                return back()->withErrors($mensaje_aux);
            } else {
                $faseContable->estado = 'Activa';
                $faseContable->save();
                $txt = "Se ha modificado la Fase Contable de tu proyecto";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                DB::update('UPDATE proyectos SET id_fasecontables = ' . $faseContable->id . ' WHERE id = ' . $request->id_proyecto_id);
                DB::update('UPDATE proyectos SET fase = "Fase Comercial" WHERE id = ' . $request->id_proyecto_id);
            }
        }


        return back()->with('success', 'Datos guardados correctamente');
    }

    public function storeFasecomercialproyecto(StoreFasecomercialproyectoRequest $request)
    {
        abort_if(Gate::denies('fasecomercialproyecto_create') && Gate::denies('fasecomercialproyecto_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $id_proyecto_aux = $request->id_proyecto_id;
        $fasecontableaux = Proyecto::find($id_proyecto_aux)->fasecontable;

        $proyecto = Proyecto::find($id_proyecto_aux);
        $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal', 'fasediseno', 'fasecomercial', 'fasecomercialproyecto', 'fasecontable', 'fasedespacho', 'fasefabrica', 'fasepostventa', 'carpetacliente');

        $messages_aux = "Debe Completar la Fase Contable.";

        if ($fasecontableaux) {

        } else {
            return back()->withErrors($messages_aux);
        }

        $aux = $request->all();
        //dd($request->all());
        if (empty($request->input('id_fasecomercialproyectos'))) {

            if ($request->input('nota_venta') != NULL && $request->fecha_despacho != NULL) {
                $faseComercialproyecto = Fasecomercialproyecto::create($request->all());

                if ($request->input('nota_venta', false)) {
                    $faseComercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('nota_venta'))))->toMediaCollection('nota_venta');
                }

                /*if ($request->input('facturas', false)) {
                    $faseComercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('facturas'))))->toMediaCollection('facturas');
                }*/

                foreach ($request->input('facturas', []) as $file) {
                    $faseComercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('facturas');
                }


                if ($request->input('credito', false)) {
                    $faseComercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('credito'))))->toMediaCollection('credito');
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $faseComercialproyecto->id]);
                }
                //dd($request);
                if ($request->tipo_proyecto == "Sillas") {
                    $faseComercialproyecto->estado = 'Completa';
                    $faseComercialproyecto->save();
                    $faseFabricacion = Fasefabrica::create($request->all());
                    $faseFabricacion->estado = 'Completa';
                    $faseFabricacion->save();

                    DB::update('UPDATE proyectos SET fase = "Fase Despacho" WHERE id = ' . $request->id_proyecto_id);
                    $txt = "La Fase de Acuerdo Comercial de tu proyecto ha terminado";
                    $this->Alerta_modifica($request->id_proyecto_id, $txt);
                    $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                    $id_proyecto = $proyecto->id;
                    if ($proyecto) {
                        $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                        $nombre_proyecto = $proyecto->nombre_proyecto;
                        $fase_anterior = "Fase Comercial";
                        $fase_actual = "Fase de Despacho";
                        if ($userID) {
                            $user = User::find($userID->user_id);
                            $email = $user->email;
                            $name = $user->name;
                            DB::update('UPDATE proyectos SET id_fasecomercialproyectos = ' . $faseComercialproyecto->id . ' WHERE id = ' . $request->id_proyecto_id);
                            DB::update('UPDATE proyectos SET id_fasefabricas = ' . $faseFabricacion->id . ' WHERE id = ' . $request->id_proyecto_id);
                            if ($email) {
                                Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
                            }
                        }
                    }
                } else {
                    $faseComercialproyecto->estado = 'Completa';
                    $faseComercialproyecto->save();
                    DB::update('UPDATE proyectos SET fase = "Fase Fabricacion" WHERE id = ' . $request->id_proyecto_id);
                    $txt = "La Fase de Acuerdo Comercial de tu proyecto ha terminado";
                    $this->Alerta_modifica($request->id_proyecto_id, $txt);
                    $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                    $id_proyecto = $proyecto->id;
                    if ($proyecto) {
                        $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                        $nombre_proyecto = $proyecto->nombre_proyecto;
                        $fase_anterior = "Fase Comercial";
                        $fase_actual = "Fase de Fabricación";
                        if ($userID) {
                            $user = User::find($userID->user_id);
                            $email = $user->email;
                            $name = $user->name;
                            DB::update('UPDATE proyectos SET id_fasecomercialproyectos = ' . $faseComercialproyecto->id . ' WHERE id = ' . $request->id_proyecto_id);
                            if ($email) {
                                Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
                            }
                        }
                    }
                }
            } elseif ($request->input('nota_venta') == NULL || $request->tipo_proyecto == NULL || $request->fecha_despacho == NULL) {
                $faseComercialproyecto = Fasecomercialproyecto::create($request->all());

                /* if ($request->input('facturas', false)) {
                     $faseComercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('facturas'))))->toMediaCollection('facturas');
                 }*/

                foreach ($request->input('facturas', []) as $file) {
                    $faseComercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('facturas');
                }

                if ($request->input('credito', false)) {
                    $faseComercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('credito'))))->toMediaCollection('credito');
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $faseComercialproyecto->id]);
                }

                $faseComercialproyecto->estado = 'Activa';
                $faseComercialproyecto->save();

                DB::update('UPDATE proyectos SET id_fasecomercialproyectos = ' . $faseComercialproyecto->id . ' WHERE id = ' . $request->id_proyecto_id);

                if ($request->input('nota_venta') == NULL && $request->tipo_proyecto == NULL) {
                    $mensaje_aux = "Debe llenar los campos Nota de Venta y Tipo de Proyecto para continuar a la siguiente fase.";
                } elseif ($request->input('nota_venta') == NULL && $request->fecha_despacho == NULL) {
                    $mensaje_aux = "Debe llenar los campos Nota de Venta y Fecha de Despacho para continuar a la siguiente fase.";
                } elseif ($request->tipo_proyecto == NULL && $request->fecha_despacho == NULL) {
                    $mensaje_aux = "Debe llenar los campos Tipo de Proyecto y Fecha de Despacho para continuar a la siguiente fase.";
                } elseif ($request->input('nota_venta') == NULL) {
                    $mensaje_aux = "Debe llenar el campo Nota de Venta para continuar a la siguiente fase.";
                } elseif ($request->tipo_proyecto == NULL) {
                    $mensaje_aux = "Debe llenar el campo Tipo de Proyecto para continuar a la siguiente fase.";
                } elseif ($request->fecha_despacho == NULL) {
                    $mensaje_aux = "Debe llenar el campo Fecha de Despacho para continuar a la siguiente fase.";
                } else {
                    $mensaje_aux = "Debe llenar los campos Nota de Venta, Tipo de Proyecto y Fecha de Despacho para continuar a la siguiente fase.";
                }


                return back()->withErrors($mensaje_aux);
            } else {


                // $faseComercialproyecto->estado = 'Activa';
                // $faseComercialproyecto->save();
                // $txt = "Se ha modificado la Fase Comercial de tu proyecto";
                // $this->Alerta_modifica($request->id_proyecto_id, $txt);
                // DB::update('UPDATE proyectos SET id_fasecomercialproyectos = ' . $faseComercialproyecto->id . ' WHERE id = ' . $request->id_proyecto_id);
            }

        } else {    //CUANDO EXISTE, MODIFICA.
            $faseComercialproyecto = Fasecomercialproyecto::find($request->input('id_fasecomercialproyectos'));
            $faseComercialproyecto->update($request->all());

            if ($request->input('nota_venta', false)) {
                if (!$faseComercialproyecto->nota_venta || $request->input('nota_venta') !== $faseComercialproyecto->nota_venta->file_name) {
                    if ($faseComercialproyecto->nota_venta) {
                        $faseComercialproyecto->nota_venta->delete();
                    }
                    $faseComercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('nota_venta'))))->toMediaCollection('nota_venta');
                }
            } elseif ($faseComercialproyecto->nota_venta) {
                $faseComercialproyecto->nota_venta->delete();
            }

            /*if ($request->input('facturas', false)) {
                if (!$faseComercialproyecto->facturas || $request->input('facturas') !== $faseComercialproyecto->facturas->file_name) {
                    if ($faseComercialproyecto->facturas) {
                        $faseComercialproyecto->facturas->delete();
                    }
                    $faseComercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('facturas'))))->toMediaCollection('facturas');
                }
            }elseif($faseComercialproyecto->facturas) {
                $faseComercialproyecto->facturas->delete();
            }*/


            if (count($faseComercialproyecto->facturas) > 0) {
                foreach ($faseComercialproyecto->facturas as $media) {
                    if (!in_array($media->file_name, $request->input('facturas', []))) {
                        $media->delete();
                    }
                }
            }
            $media = $faseComercialproyecto->facturas->pluck('file_name')->toArray();
            foreach ($request->input('facturas', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $faseComercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('facturas');
                }
            }





            if ($request->input('credito', false)) {
                if (!$faseComercialproyecto->credito || $request->input('credito') !== $faseComercialproyecto->credito->file_name) {
                    if ($faseComercialproyecto->credito) {
                        $faseComercialproyecto->credito->delete();
                    }
                    $faseComercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('credito'))))->toMediaCollection('credito');
                }
            } elseif ($faseComercialproyecto->credito) {
                $faseComercialproyecto->credito->delete();
            }

            if ($request->input('nota_venta') != NULL && $request->fecha_despacho != NULL && $request->fecha_despacho != NULL) {
                if ($request->tipo_proyecto == "Sillas") {
                    $faseComercialproyecto->estado = 'Completa';
                    $faseComercialproyecto->save();
                    $faseFabricacion = Fasefabrica::create($request->all());
                    $faseFabricacion->estado = 'Completa';
                    $faseFabricacion->save();

                    DB::update('UPDATE proyectos SET fase = "Fase Despacho" WHERE id = ' . $request->id_proyecto_id);
                    $txt = "La Fase de Acuerdo Comercial de tu proyecto ha terminado";
                    $this->Alerta_modifica($request->id_proyecto_id, $txt);
                    $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                    $id_proyecto = $proyecto->id;
                    if ($proyecto) {
                        $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                        $nombre_proyecto = $proyecto->nombre_proyecto;
                        $fase_anterior = "Fase Comercial";
                        $fase_actual = "Fase de Despacho";
                        if ($userID) {
                            $user = User::find($userID->user_id);
                            $email = $user->email;
                            $name = $user->name;
                            DB::update('UPDATE proyectos SET id_fasecomercialproyectos = ' . $faseComercialproyecto->id . ' WHERE id = ' . $request->id_proyecto_id);
                            DB::update('UPDATE proyectos SET id_fasefabricas = ' . $faseFabricacion->id . ' WHERE id = ' . $request->id_proyecto_id);
                            if ($email) {
                                Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
                            }
                        }
                    }
                } else {
                    $faseComercialproyecto->estado = 'Completa';
                    $faseComercialproyecto->save();
                    DB::update('UPDATE proyectos SET fase = "Fase Fabricacion" WHERE id = ' . $request->id_proyecto_id);
                    $txt = "La Fase de Acuerdo Comercial de tu proyecto ha terminado";
                    $this->Alerta_modifica($request->id_proyecto_id, $txt);
                    $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                    $id_proyecto = $proyecto->id;
                    if ($proyecto) {
                        $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                        $nombre_proyecto = $proyecto->nombre_proyecto;
                        $fase_anterior = "Fase Comercial";
                        $fase_actual = "Fase de Fabricación";
                        if ($userID) {
                            $user = User::find($userID->user_id);
                            $email = $user->email;
                            $name = $user->name;
                            DB::update('UPDATE proyectos SET id_fasecomercialproyectos = ' . $faseComercialproyecto->id . ' WHERE id = ' . $request->id_proyecto_id);
                            if ($email) {
                                Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
                            }
                        }
                    }
                }
            } elseif ($request->input('nota_venta') == NULL || $request->tipo_proyecto == NULL || $request->fecha_despacho == NULL) {
                $faseComercialproyecto->estado = 'Activa';
                $faseComercialproyecto->save();

                DB::update('UPDATE proyectos SET id_fasecomercialproyectos = ' . $faseComercialproyecto->id . ' WHERE id = ' . $request->id_proyecto_id);

                if ($request->input('nota_venta') == NULL && $request->tipo_proyecto == NULL) {
                    $mensaje_aux = "Debe llenar los campos Nota de Venta y Tipo de Proyecto para continuar a la siguiente fase.";
                } elseif ($request->input('nota_venta') == NULL && $request->fecha_despacho == NULL) {
                    $mensaje_aux = "Debe llenar los campos Nota de Venta y Fecha de Despacho para continuar a la siguiente fase.";
                } elseif ($request->tipo_proyecto == NULL && $request->fecha_despacho == NULL) {
                    $mensaje_aux = "Debe llenar los campos Tipo de Proyecto y Fecha de Despacho para continuar a la siguiente fase.";
                } elseif ($request->input('nota_venta') == NULL) {
                    $mensaje_aux = "Debe llenar el campo Nota de Venta para continuar a la siguiente fase.";
                } elseif ($request->tipo_proyecto == NULL) {
                    $mensaje_aux = "Debe llenar el campo Tipo de Proyecto para continuar a la siguiente fase.";
                } elseif ($request->fecha_despacho == NULL) {
                    $mensaje_aux = "Debe llenar el campo Fecha de Despacho para continuar a la siguiente fase.";
                } else {
                    $mensaje_aux = "Debe llenar los campos Nota de Venta, Tipo de Proyecto y Fecha de Despacho para continuar a la siguiente fase.";
                }

                return back()->withErrors($mensaje_aux);
            } else {
                // $faseComercialproyecto->estado = 'Activa';
                // $faseComercialproyecto->save();
                // $txt = "Se ha modificado la Fase Comercial de tu proyecto";
                // $this->Alerta_modifica($request->id_proyecto_id, $txt);
                // DB::update('UPDATE proyectos SET id_fasecomercialproyectos = ' . $faseComercialproyecto->id . ' WHERE id = ' . $request->id_proyecto_id);
            }
        }


        return back()->with('success', 'Datos guardados correctamente');
    }

    public function storeFasefabricacion(StoreFasefabricaRequest $request)
    {
        abort_if(Gate::denies('fasefabrica_create') && Gate::denies('fasefabrica_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $id_proyecto_aux = $request->id_proyecto_id;
        $fasecomercialproyectolaux = Proyecto::find($id_proyecto_aux)->fasecomercialproyecto;

        $proyecto = Proyecto::find($id_proyecto_aux);
        $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal', 'fasediseno', 'fasecomercial', 'fasecomercialproyecto', 'fasecontable', 'fasedespacho', 'fasefabrica', 'fasepostventa', 'carpetacliente');

        $messages_aux = "Debe Completar la Fase de Acuerdo Comercial.";

        if ($fasecomercialproyectolaux) {
            if ($fasecomercialproyectolaux->estado == 'Completa') {
            } else {
                return back()->withErrors($messages_aux);
            }
        } else {
            return back()->withErrors($messages_aux);
        }

        $aux = $request->all();
        if (empty($request->input('id_fasefabricas'))) {
            if ($request->estado_produccion == 'finalizado' && $request->fase == "Limpieza/Embalaje" && $request->aprobacion_course != NULL && $request->fecha_entrega != NULL && $request->input('oc_proveedores') != NULL && $request->input('galeria_estado_entrega') != NULL) {
                $faseFabricacion = Fasefabrica::create($request->all());
                foreach ($request->input('oc_proveedores', []) as $file) {
                    $faseFabricacion->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('oc_proveedores');
                }

                foreach ($request->input('galeria_estado_entrega', []) as $file) {
                    $faseFabricacion->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('galeria_estado_entrega');
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $faseFabricacion->id]);
                }
                $faseFabricacion->estado = 'Completa';
                $faseFabricacion->save();
                DB::update('UPDATE proyectos SET fase = "Fase Despacho" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase de Fabricación de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                $id_proyecto = $proyecto->id;
                if ($proyecto) {
                    $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                    $nombre_proyecto = $proyecto->nombre_proyecto;
                    $fase_anterior = "Fase de Fabricación";
                    $fase_actual = "Fase de Despacho";
                    if ($userID) {
                        $user = User::find($userID->user_id);
                        $email = $user->email;
                        $name = $user->name;
                        DB::update('UPDATE proyectos SET id_fasefabricas = ' . $faseFabricacion->id . ' WHERE id = ' . $request->id_proyecto_id);
                        if ($email) {
                            Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
                        }
                    }
                }
            } elseif ($request->fase == NULL && $request->aprobacion_course == NULL && $request->estado_produccion == NULL && $request->fecha_entrega == NULL && $request->input('oc_proveedores') == NULL && $request->input('galeria_estado_entrega') == NULL) {
                $mensaje_aux = "Debe llenar los campos para continuar a la siguiente fase.";
                return back()->withErrors($mensaje_aux);
            } else {
                $faseFabricacion = Fasefabrica::create($request->all());
                foreach ($request->input('oc_proveedores', []) as $file) {
                    $faseFabricacion->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('oc_proveedores');
                }

                foreach ($request->input('galeria_estado_entrega', []) as $file) {
                    $faseFabricacion->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('galeria_estado_entrega');
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $faseFabricacion->id]);
                }
                $faseFabricacion->estado = 'Activa';
                $faseFabricacion->save();
                $txt = "Se ha modificado la Fase de Fabricación de tu proyecto";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                DB::update('UPDATE proyectos SET id_fasefabricas = ' . $faseFabricacion->id . ' WHERE id = ' . $request->id_proyecto_id);
            }
        } else {
            $faseFabricacion = Fasefabrica::find($request->input('id_fasefabricas'));
            $faseFabricacion->update($request->all());

            //dd($request);

            if (count($faseFabricacion->oc_proveedores) > 0) {
                foreach ($faseFabricacion->oc_proveedores as $media) {
                    if (!in_array($media->file_name, $request->input('oc_proveedores', []))) {
                        $media->delete();
                    }
                }
            }
            $media = $faseFabricacion->oc_proveedores->pluck('file_name')->toArray();
            foreach ($request->input('oc_proveedores', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $faseFabricacion->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('oc_proveedores');
                }
            }

            if (count($faseFabricacion->galeria_estado_entrega) > 0) {
                foreach ($faseFabricacion->galeria_estado_entrega as $media) {
                    if (!in_array($media->file_name, $request->input('galeria_estado_entrega', []))) {
                        $media->delete();
                    }
                }
            }
            $media = $faseFabricacion->galeria_estado_entrega->pluck('file_name')->toArray();
            foreach ($request->input('galeria_estado_entrega', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $faseFabricacion->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('galeria_estado_entrega');
                }
            }

            if ($request->fase != NULL && $request->aprobacion_course != NULL && $request->estado_produccion != NULL && $request->input('oc_proveedores') != NULL && $request->input('galeria_estado_entrega') != NULL) {
                $faseFabricacion->estado = 'Completa';
                $faseFabricacion->save();
                DB::update('UPDATE proyectos SET fase = "Fase Despacho" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase de Fabricación de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                $id_proyecto = $proyecto->id;
                if ($proyecto) {
                    $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                    $nombre_proyecto = $proyecto->nombre_proyecto;
                    $fase_anterior = "Fase de Fabricación";
                    $fase_actual = "Fase de Despacho";
                    if ($userID) {
                        $user = User::find($userID->user_id);
                        $email = $user->email;
                        $name = $user->name;
                        DB::update('UPDATE proyectos SET id_fasefabricas = ' . $faseFabricacion->id . ' WHERE id = ' . $request->id_proyecto_id);
                        if ($email) {
                            Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
                        }
                    }
                }
            } elseif ($request->fase == NULL && $request->aprobacion_course == NULL && $request->estado_produccion == NULL && $request->input('oc_proveedores') == NULL && $request->input('galeria_estado_entrega') == NULL) {
                $mensaje_aux = "Debe llenar los campos para continuar a la siguiente fase.";
                return back()->withErrors($mensaje_aux);
            } else {
                $faseFabricacion->estado = 'Activa';
                $faseFabricacion->save();
                $txt = "Se ha modificado la Fase de Fabricación de tu proyecto";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                DB::update('UPDATE proyectos SET id_fasefabricas = ' . $faseFabricacion->id . ' WHERE id = ' . $request->id_proyecto_id);
            }
        }


        return back()->with('success', 'Datos guardados correctamente');
    }

    public function storeFasedespachos(StoreFasedespachoRequest $request)
    {
        //dd($request);
        abort_if(Gate::denies('fasedespacho_create') && Gate::denies('fasedespacho_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $id_proyecto_aux = $request->id_proyecto_id;
        $fasefabricaaux = Proyecto::find($id_proyecto_aux)->fasefabrica;

        $proyecto = Proyecto::find($id_proyecto_aux);
        $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal', 'fasediseno', 'fasecomercial', 'fasecomercialproyecto', 'fasecontable', 'fasedespacho', 'fasefabrica', 'fasepostventa', 'carpetacliente');

        $messages_aux = "Debe Completar la Fase de Fabricación.";

        if ($fasefabricaaux) {
            if ($fasefabricaaux->estado == 'Completa') {
            } else {
                return back()->withErrors($messages_aux);
            }
        } else {
            return back()->withErrors($messages_aux);
        }

        $aux = $request->all();
        if (empty($request->input('id_fasedespachos'))) {
            if (($request->distribucion != 0 || $request->armado != 0 || $request->entrega_conformne != 0) && ($request->carguio != 0 || $request->transporte != 0 || $request->entrega != 0) && $request->fecha_despacho != NULL && $request->estado_instalacion != NULL && $request->comentario != NULL && $request->recibe_conforme != NULL && $request->input('guia_despacho') != NULL && $request->input('galeria_estado_muebles') != NULL) {
                $faseDespacho = Fasedespacho::create($request->all());

                foreach ($request->input('guia_despacho', []) as $file) {
                    $faseDespacho->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('guia_despacho');
                }
                foreach ($request->input('galeria_estado_muebles', []) as $file) {
                    $faseDespacho->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('galeria_estado_muebles');
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $faseDespacho->id]);
                }
                $faseDespacho->estado = 'Completa';
                $faseDespacho->save();
                $fasePostventum = FasePostventum::create(['estado' => 'En Proceso']);
                DB::update('UPDATE proyectos SET id_fasepostventa = ' . $fasePostventum->id . ' WHERE id = ' . $request->id_proyecto_id);
                DB::update('UPDATE proyectos SET estado = "Despachado" WHERE id = ' . $request->id_proyecto_id);
                DB::update('UPDATE proyectos SET fase = "Fase Postventa" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase de Despacho de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                $id_proyecto = $request->id_proyecto_id;
                if ($proyecto) {
                    $userID = DB::table('proyecto_user')->where('proyecto_id', $id_proyecto)->first();
                    $nombre_proyecto = $proyecto->nombre_proyecto;
                    $fase_anterior = "Fase de Despacho";
                    $fase_actual = "Fase de Postventa";
                    if ($userID) {
                        $user = User::find($userID->user_id);
                        $email = $user->email;
                        $name = $user->name;
                        DB::update('UPDATE proyectos SET id_fasedespachos = ' . $faseDespacho->id . ' WHERE id = ' . $request->id_proyecto_id);
                        if ($email) {
                            Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
                            if ($faseDespacho->horario != NULL) {
                                Mail::to($email)->send(new ConfirmaHorario($name, $nombre_proyecto, $id_proyecto, $faseDespacho->horario));
                            }
                        }
                    }
                }
            } elseif (($request->distribucion == 0 && $request->armado == 0 && $request->entrega_conformne == 0) && ($request->carguio == 0 && $request->transporte == 0 && $request->entrega == 0) && $request->fecha_despacho == NULL && $request->estado_instalacion == NULL && $request->comentario == NULL && $request->recibe_conforme == NULL && $request->input('guia_despacho') == NULL && $request->input('galeria_estado_muebles') == NULL) {
                $mensaje_aux = "Debe llenar los campos para continuar a la siguiente fase.";
                return back()->withErrors($mensaje_aux);
            } else {
                $faseDespacho = Fasedespacho::create($request->all());

                foreach ($request->input('guia_despacho', []) as $file) {
                    $faseDespacho->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('guia_despacho');
                }

                foreach ($request->input('galeria_estado_muebles', []) as $file) {
                    $faseDespacho->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('galeria_estado_muebles');
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $faseDespacho->id]);
                }
                $faseDespacho->estado = 'Activa';
                $faseDespacho->save();
                $txt = "Se ha modificado la Fase de Diseño de tu proyecto";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                DB::update('UPDATE proyectos SET id_fasedespachos = ' . $faseDespacho->id . ' WHERE id = ' . $request->id_proyecto_id);
            }
        } else {
            $faseDespacho = Fasedespacho::find($request->input('id_fasedespachos'));
            $faseDespacho->update($request->all());

            /*if ($request->input('guia_despacho', false)) {
                if (!$faseDespacho->guia_despacho || $request->input('guia_despacho') !== $faseDespacho->guia_despacho->file_name) {
                    if ($faseDespacho->guia_despacho) {
                        $faseDespacho->guia_despacho->delete();
                    }
                    $faseDespacho->addMedia(storage_path('tmp/uploads/' . basename($request->input('guia_despacho'))))->toMediaCollection('guia_despacho');
                }
            } elseif ($faseDespacho->guia_despacho) {
                $faseDespacho->guia_despacho->delete();
            }*/

            /* */

            if (count($faseDespacho->guia_despacho) > 0) {
                foreach ($faseDespacho->guia_despacho as $media) {
                    if (!in_array($media->file_name, $request->input('guia_despacho', []))) {
                        $media->delete();
                    }
                }
            }
            $media2 = $faseDespacho->guia_despacho->pluck('file_name')->toArray();
            foreach ($request->input('guia_despacho', []) as $file) {
                if (count($media2) === 0 || !in_array($file, $media2)) {
                    $faseDespacho->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('guia_despacho');
                }
            }

            if (count($faseDespacho->galeria_estado_muebles) > 0) {
                foreach ($faseDespacho->galeria_estado_muebles as $media) {
                    if (!in_array($media->file_name, $request->input('galeria_estado_muebles', []))) {
                        $media->delete();
                    }
                }
            }
            $media = $faseDespacho->galeria_estado_muebles->pluck('file_name')->toArray();
            foreach ($request->input('galeria_estado_muebles', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $faseDespacho->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('galeria_estado_muebles');
                }
            }


            if (($request->distribucion != 0 || $request->armado != 0 || $request->entrega_conformne != 0) && ($request->carguio != 0 || $request->transporte != 0 || $request->entrega != 0) && $request->fecha_despacho != NULL && $request->estado_instalacion != NULL && $request->comentario != NULL && $request->recibe_conforme != NULL && $request->input('guia_despacho') != NULL && $request->input('galeria_estado_muebles') != NULL) {

                $faseDespacho->estado = 'Completa';
                $faseDespacho->save();
                $fasePostventum = FasePostventum::create(['estado' => 'En Proceso']);
                DB::update('UPDATE proyectos SET id_fasepostventa = ' . $fasePostventum->id . ' WHERE id = ' . $request->id_proyecto_id);
                DB::update('UPDATE proyectos SET estado = "Despachado" WHERE id = ' . $request->id_proyecto_id);
                DB::update('UPDATE proyectos SET fase = "Fase Postventa" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase de Despacho de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                $id_proyecto = $request->id_proyecto_id;
                if ($proyecto) {
                    $userID = DB::table('proyecto_user')->where('proyecto_id', $id_proyecto)->first();
                    $nombre_proyecto = $proyecto->nombre_proyecto;
                    $fase_anterior = "Fase de Despacho";
                    $fase_actual = "Fase de Postventa";
                    if ($userID) {
                        $user = User::find($userID->user_id);
                        $email = $user->email;
                        $name = $user->name;
                        DB::update('UPDATE proyectos SET id_fasedespachos = ' . $faseDespacho->id . ' WHERE id = ' . $request->id_proyecto_id);
                        if ($email) {
                            Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
                            //dd($email);
                            if ($faseDespacho->horario != NULL) {
                                Mail::to($email)->send(new ConfirmaHorario($name, $nombre_proyecto, $id_proyecto, $faseDespacho->horario));
                            }
                        }
                    }
                }
            } elseif (($request->distribucion == 0 && $request->armado == 0 && $request->entrega_conformne == 0) && ($request->carguio == 0 && $request->transporte == 0 && $request->entrega == 0) && $request->fecha_despacho == NULL && $request->estado_instalacion == NULL && $request->comentario == NULL && $request->recibe_conforme == NULL && $request->input('guia_despacho') == NULL && $request->input('galeria_estado_muebles') == NULL) {
                $mensaje_aux = "Debe llenar los campos para continuar a la siguiente fase.";
                return back()->withErrors($mensaje_aux);
            } else {
                $faseDespacho->estado = 'Activa';
                $faseDespacho->save();
                $txt = "Se ha modificado la Fase de Diseño de tu proyecto";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                DB::update('UPDATE proyectos SET id_fasedespachos = ' . $faseDespacho->id . ' WHERE id = ' . $request->id_proyecto_id);
            }
        }


        return back()->with('success', 'Datos guardados correctamente');
    }

    public function storeFasepostventa(StoreFasePostventumRequest $request)
    {
        abort_if(Gate::denies('fase_postventum_create') && Gate::denies('fase_postventum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyecto_aux = $request->id_proyecto_id;
        $fasedespachoaux = Proyecto::find($id_proyecto_aux)->fasedespacho;

        $proyecto = Proyecto::find($id_proyecto_aux);
        $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal', 'fasediseno', 'fasecomercial', 'fasecomercialproyecto', 'fasecontable', 'fasedespacho', 'fasefabrica', 'fasepostventa', 'carpetacliente');

        $messages_aux = "Debe Completar la Fase de Despachos.";

        if ($fasedespachoaux) {
            if ($fasedespachoaux->estado == 'Completa') {
            } else {
                return back()->withErrors($messages_aux);
            }
        } else {
            return back()->withErrors($messages_aux);
        }

        $aux = $request->all();
        if (empty($request->input('id_fasepostventa'))) {
            $fasePostventum = FasePostventum::create($request->all());
            $fasePostventum->id_usuarios()->sync($request->input('id_usuarios', []));

            DB::update('UPDATE proyectos SET id_fasepostventa = ' . $fasePostventum->id . ' WHERE id = ' . $request->id_proyecto_id);
            if ($aux['estado'] == 'Finalizada') {
                DB::update('UPDATE proyectos SET estado = "Negocio Ganado" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase de Post Venta de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                $id_proyecto = $proyecto->id;
                if ($proyecto) {
                    $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                    $nombre_proyecto = $proyecto->nombre_proyecto;
                    $fase_anterior = "Fase de Postventa";
                    $fase_actual = "Finalizado";
                    if ($userID) {
                        $user = User::find($userID->user_id);
                        $email = $user->email;
                        $name = $user->name;
                        //dd($fase_actual);
                        if ($email) {
                            Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
                        } else {
                        }
                    }
                }
            }
        } else {

            $fasePostventum = FasePostventum::find($request->input('id_fasepostventa'));
            $fasePostventum->estado = $aux['estado'];
            $fasePostventum->save();
            $fasePostventum->id_usuarios()->sync($request->input('id_usuarios', []));
            if ($aux['estado'] == 'Finalizada') {
                DB::update('UPDATE proyectos SET estado = "Negocio Ganado" WHERE id = ' . $request->id_proyecto_id);
                $txt = "La Fase de Post Venta de tu proyecto ha terminado";
                $this->Alerta_modifica($request->id_proyecto_id, $txt);
                $proyecto = Proyecto::find($request->id_proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
                $id_proyecto = $proyecto->id;
                if ($proyecto) {
                    $userID = DB::table('proyecto_user')->where('proyecto_id', $request->id_proyecto_id)->first();
                    $nombre_proyecto = $proyecto->nombre_proyecto;
                    $fase_anterior = "Fase de Postventa";
                    $fase_actual = "Finalizado";
                    if ($userID) {
                        $user = User::find($userID->user_id);
                        $email = $user->email;
                        $name = $user->name;
                        //dd($fase_actual);
                    }
                }
            }
            DB::update('UPDATE proyectos SET id_fasepostventa = ' . $fasePostventum->id . ' WHERE id = ' . $request->id_proyecto_id);
            if ($email) {
                Mail::to($email)->send(new CambioDeFase($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto));
            }
        }


        return back()->with('success', 'Datos guardados correctamente');
    }

    public function storeCarpetacliente(StoreCarpetaclienteRequest $request)
    {
        $aux = $request->all();
        if (empty($request->input('id_carpetacliente'))) {
            $carpetaCliente = Carpetacliente::create($request->all());

            if ($request->input('presupuesto', false)) {
                $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('presupuesto'))))->toMediaCollection('presupuesto');
            }

            foreach ($request->input('plano', []) as $file) {
                $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('plano');
            }

            foreach ($request->input('fftt', []) as $file) {
                $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('fftt');
            }

            foreach ($request->input('presentacion', []) as $file) {
                $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('presentacion');
            }

            if ($request->input('rectificacion', false)) {
                $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('rectificacion'))))->toMediaCollection('rectificacion');
            }

            if ($request->input('nb', false)) {
                $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('nb'))))->toMediaCollection('nb');
            }

            if ($request->input('course', false)) {
                $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('course'))))->toMediaCollection('course');
            }

            if ($media = $request->input('ck-media', false)) {
                Media::whereIn('id', $media)->update(['model_id' => $carpetaCliente->id]);
            }

            DB::update('UPDATE proyectos SET id_carpetacliente = ' . $carpetaCliente->id . ' WHERE id = ' . $request->id_proyecto_id);
        } else {
            $carpetaCliente = Carpetacliente::find($request->input('id_carpetacliente'));
            $carpetaCliente->update($request->all());

            if ($request->input('presupuesto', false)) {
                if (!$carpetaCliente->presupuesto || $request->input('presupuesto') !== $carpetaCliente->presupuesto->file_name) {
                    if ($carpetaCliente->presupuesto) {
                        $carpetaCliente->presupuesto->delete();
                    }
                    $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('presupuesto'))))->toMediaCollection('presupuesto');
                }
            } elseif ($carpetaCliente->presupuesto) {
                $carpetaCliente->presupuesto->delete();
            }

            if (count($carpetaCliente->plano) > 0) {
                foreach ($carpetaCliente->plano as $media) {
                    if (!in_array($media->file_name, $request->input('plano', []))) {
                        $media->delete();
                    }
                }
            }
            $media = $carpetaCliente->plano->pluck('file_name')->toArray();
            foreach ($request->input('plano', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('plano');
                }
            }

            if (count($carpetaCliente->fftt) > 0) {
                foreach ($carpetaCliente->fftt as $media) {
                    if (!in_array($media->file_name, $request->input('fftt', []))) {
                        $media->delete();
                    }
                }
            }
            $media = $carpetaCliente->fftt->pluck('file_name')->toArray();
            foreach ($request->input('fftt', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('fftt');
                }
            }

            if (count($carpetaCliente->presentacion) > 0) {
                foreach ($carpetaCliente->presentacion as $media) {
                    if (!in_array($media->file_name, $request->input('presentacion', []))) {
                        $media->delete();
                    }
                }
            }
            $media = $carpetaCliente->presentacion->pluck('file_name')->toArray();
            foreach ($request->input('presentacion', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('presentacion');
                }
            }

            if ($request->input('rectificacion', false)) {
                if (!$carpetaCliente->rectificacion || $request->input('rectificacion') !== $carpetaCliente->rectificacion->file_name) {
                    if ($carpetaCliente->rectificacion) {
                        $carpetaCliente->rectificacion->delete();
                    }
                    $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('rectificacion'))))->toMediaCollection('rectificacion');
                }
            } elseif ($carpetaCliente->rectificacion) {
                $carpetaCliente->rectificacion->delete();
            }

            if ($request->input('nb', false)) {
                if (!$carpetaCliente->nb || $request->input('nb') !== $carpetaCliente->nb->file_name) {
                    if ($carpetaCliente->nb) {
                        $carpetaCliente->nb->delete();
                    }
                    $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('nb'))))->toMediaCollection('nb');
                }
            } elseif ($carpetaCliente->nb) {
                $carpetaCliente->nb->delete();
            }

            if ($request->input('course', false)) {
                if (!$carpetaCliente->course || $request->input('course') !== $carpetaCliente->course->file_name) {
                    if ($carpetaCliente->course) {
                        $carpetaCliente->course->delete();
                    }
                    $carpetaCliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('course'))))->toMediaCollection('course');
                }
            } elseif ($carpetaCliente->course) {
                $carpetaCliente->course->delete();
            }

            DB::update('UPDATE proyectos SET id_carpetacliente = ' . $carpetaCliente->id . ' WHERE id = ' . $request->id_proyecto_id);
        }


        return back()->with('success', 'Datos guardados correctamente');
    }


    public function index(Request $request)
    {
        abort_if(Gate::denies('proyecto_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // Obtener el ID del usuario autenticado
        $userId = auth()->id();
        // Verificar si el usuario tiene el rol de administrador
        $isAdmin = \DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', $userId)
            ->where('roles.title', 'Admin')
            ->exists();
        if ($request->ajax()) {

            error_log('Valor de la columna fase recibido desde la solicitud: ' . $request->input('columns')[12]['search']['value']);

            if ($isAdmin) {
                $query = Proyecto::with(['id_cliente', 'id_usuarios_clientes', 'sucursal'])
                    ->select(sprintf('%s.*', (new Proyecto)->table));
                $query->orderBy('created_at', 'desc');
                $table = Datatables::of($query);
            } else {
                $query = Proyecto::with(['id_cliente', 'id_usuarios_clientes', 'sucursal'])
                    ->where('id_vendedor', auth()->id()) // Filtrar proyectos por el usuario conectado
                    ->orWhere('disenador', auth()->user()->name)
                    ->select(sprintf('%s.*', (new Proyecto)->table));
                $query->orderBy('created_at', 'desc');
                $table = Datatables::of($query);
            }


            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'proyecto_show';
                $editGate = 'proyecto_edit';
                $deleteGate = 'proyecto_delete';
                $crudRoutePart = 'proyectos';

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
            $table->addColumn('id_cliente_nombe_de_fantasia', function ($row) {
                return $row->id_cliente ? $row->id_cliente->nombe_de_fantasia : '';
            });

            $table->addColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at : '';
            });

            $table->editColumn('id_cliente.rut', function ($row) {
                return $row->id_cliente ? (is_string($row->id_cliente) ? $row->id_cliente : $row->id_cliente->rut) : '';
            });
            $table->editColumn('id_usuarios_cliente', function ($row) {
                $labels = [];
                foreach ($row->id_usuarios_clientes as $id_usuarios_cliente) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $id_usuarios_cliente->name);
                }

                return implode(' ', $labels);
            });
            $table->addColumn('sucursal_nombre', function ($row) {
                return $row->sucursal ? $row->sucursal->nombre : '';
            });

            $table->editColumn('sucursal.direccion_sucursal', function ($row) {
                return $row->sucursal ? (is_string($row->sucursal) ? $row->sucursal : $row->sucursal->direccion_sucursal) : '';
            });
            $table->editColumn('categoria_proyecto', function ($row) {
                return $row->categoria_proyecto ? Proyecto::CATEGORIA_PROYECTO_SELECT[$row->categoria_proyecto] : '';
            });
            $table->editColumn('estado', function ($row) {
                return $row->estado ? Proyecto::ESTADO_SELECT[$row->estado] : '';
            });
            $table->editColumn('fase', function ($row) {
                return $row->fase ? Proyecto::FASE_SELECT[$row->fase] : '';
            });
            $table->editColumn('nombre_proyecto', function ($row) {
                return $row->nombre_proyecto ? $row->nombre_proyecto : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'id_cliente', 'id_usuarios_cliente', 'sucursal']);

            return $table->make(true);

        }

        $empresas = Empresa::orderBy('nombe_de_fantasia', 'asc')->get();
        $empresas2 = Empresa::orderBy('rut', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();
        $sucursals = Sucursal::orderBy('nombre', 'asc')->get();
        return view('admin.proyectos.index', compact('empresas', 'users', 'sucursals', 'empresas2'));
    }

    public function getUsuario(Request $request)
    {

        $id_sucursal = $request->id_sucursal;
        $usuarios = DB::select("SELECT users.name, users.id FROM sucursal_user JOIN users ON sucursal_user.user_id = users.id WHERE sucursal_user.sucursal_id = " . $id_sucursal);
        $response = array();
        foreach ($usuarios as $usuario) {
            $response[] = array(
                "id" => $usuario->id,
                "text" => $usuario->name
            );
        }
        return response()->json($response);
    }

    public function create()
    {
        abort_if(Gate::denies('proyecto_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userId = Auth::id();

        $id_clientes = Empresa::orderBy('nombe_de_fantasia')->pluck('nombe_de_fantasia', 'id')->prepend(trans('global.pleaseSelect'), '');


        $id_usuarios_clientes = User::pluck('name', 'id');

        $sucursals = Sucursal::orderBy('nombre')->pluck('nombre', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.proyectos.create', compact('id_clientes', 'id_usuarios_clientes', 'sucursals', 'userId'));
    }

    public function store(StoreProyectoRequest $request)
    {
        $proyecto = Proyecto::create($request->all());
        $proyecto->id_usuarios_clientes()->sync($request->input('id_usuarios_clientes', []));

        $userId = Auth::id();
        //$nombre_empresa = Empresa::where('id', $request->id_cliente_id)->value('razon_social');
        $nombre_empresa = strtoupper(str_replace(' ', '_', Empresa::where('id', $request->id_cliente_id)->value('razon_social')));
        $rut_empresa = Empresa::where('id', $request->id_cliente_id)->value('rut');
        $nombre_vendedor = User::where('id', $userId)->value('name');


        try {
            // Definir la ruta donde se quiere crear la carpeta
            $rutaDirectorio = "E:/OHFFICE/Usuarios/TI_Ohffice/Proyectos/PROYECTOS/{$rut_empresa}_{$nombre_empresa}/{$request->nombre_proyecto}/{$nombre_vendedor}";
            if (!file_exists($rutaDirectorio)) {
                mkdir($rutaDirectorio . '/COMERCIAL\/01 COTIZACION', 0777, true);
                mkdir($rutaDirectorio . '/COMERCIAL\/02 NOTA DE VENTA', 0777, true);
                mkdir($rutaDirectorio . '/COMERCIAL\/03 ORDEN DE COMPRA', 0777, true);
                mkdir($rutaDirectorio . '/COMERCIAL\/04 DISENO', 0777, true);
                mkdir($rutaDirectorio . '/COMERCIAL\/05 CURSE', 0777, true);
                mkdir($rutaDirectorio . '/COMERCIAL\/06 FACTURAS', 0777, true);
                mkdir($rutaDirectorio . '/DISEÑO', 0777, true);
                echo "Directorio creado exitosamente";
            } else {
                echo "El directorio ya existe";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return redirect()->route('admin.proyectos.index');
    }

    public function edit(Proyecto $proyecto)
    {
        abort_if(Gate::denies('proyecto_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $userId = Auth::id();

        $id_clientes = Empresa::Orderby('nombe_de_fantasia')->pluck('nombe_de_fantasia', 'id')->prepend(trans('global.pleaseSelect'), '');

        $id_usuarios_clientes = User::pluck('name', 'id');

        $sucursals = Sucursal::pluck('nombre', 'id')->prepend(trans('global.pleaseSelect'), '');

        $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal');

        return view('admin.proyectos.edit', compact('id_clientes', 'id_usuarios_clientes', 'proyecto', 'sucursals', 'userId'));
    }

    public function update(UpdateProyectoRequest $request, Proyecto $proyecto)
    {
        $proyecto->update($request->all());
        $proyecto->id_usuarios_clientes()->sync($request->input('id_usuarios_clientes', []));

        return redirect()->route('admin.proyectos.index');
    }

    // public function show(Proyecto $proyecto)
    // {
    //     abort_if(Gate::denies('proyecto_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal', 'fasediseno', 'fasecomercial', 'fasecomercialproyecto', 'fasecontable', 'fasedespacho', 'fasefabrica', 'fasepostventa', 'carpetacliente');

    //     //  dd($proyecto);
    //     return view('admin.proyectos.show', compact('proyecto'));
    // }

    public function show(Proyecto $proyecto)
    {
        abort_if(Gate::denies('proyecto_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal', 'fasediseno', 'fasecomercial', 'fasecomercialproyecto', 'fasecontable', 'fasedespacho', 'fasefabrica', 'fasepostventa', 'carpetacliente');

        // Definir la ruta del directorio basado en los atributos del proyecto
        $rut_empresa = $proyecto->id_cliente->rut; // Asumiendo que existe este campo relacionado
        $nombre_empresa = strtoupper(str_replace(' ', '_', ($proyecto->id_cliente->razon_social)));
        $nombre_proyecto = $proyecto->nombre_proyecto;

        $userId = $proyecto->id_vendedor;
        $nombre_vendedor = User::where('id', $userId)->value('name');

        $rutaDirectorio = "E:/OHFFICE/Usuarios/TI_Ohffice/Proyectos/PROYECTOS/{$rut_empresa}_{$nombre_empresa}/{$nombre_proyecto}/{$nombre_vendedor}/COMERCIAL/01 COTIZACION";

        // Listar archivos del directorio
        $archivos = [];
        try {
            if (file_exists($rutaDirectorio)) {
                $archivos = array_diff(scandir($rutaDirectorio), ['.', '..']); // Excluir "." y ".."
                $archivos = array_map(function ($archivo) use ($rutaDirectorio) {
                    $rutaCompleta = $rutaDirectorio . DIRECTORY_SEPARATOR . $archivo;
                    $destino = 'temporal/' . $archivo; // Ruta destino en storage/app/public/temporal

                    // Copiar el archivo a la carpeta temporal
                    if (file_exists($rutaCompleta)) {
                        // Copiar el archivo a storage/app/public/temporal
                        Storage::disk('public')->put($destino, file_get_contents($rutaCompleta));
                    }

                    return [
                        'nombre' => $archivo,
                        'ruta' => str_replace('\\', '/', Storage::disk('public')->url($destino)), // URL pública
                    ];
                }, $archivos);
            }
        } catch (\Exception $e) {
            // Manejar errores si es necesario
            $archivos = [];
        }

        return view('admin.proyectos.show', compact('proyecto', 'archivos'));
    }



    public function destroy(Proyecto $proyecto)
    {
        abort_if(Gate::denies('proyecto_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proyecto->delete();

        return back();
    }

    public function massDestroy(MassDestroyProyectoRequest $request)
    {
        $proyectos = Proyecto::find(request('ids'));

        foreach ($proyectos as $proyecto) {
            $proyecto->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
