# Procedimiento para Crear un Nuevo Proyecto

## Descripción General

Este documento detalla el flujo completo para la creación de un nuevo proyecto en el Portal de Clientes de Ohffice, incluyendo todos los archivos del backend (Laravel) y frontend (Blade).

---

## 1. FLUJO GENERAL DEL PROCEDIMIENTO

```
Usuario → Interfaz Frontend → Controlador → Modelo → Base de Datos → Redirección
```

**Pasos principales:**
1. El usuario accede a la vista de crear proyecto
2. Completa el formulario con los datos requeridos
3. Envía el formulario (POST)
4. El controlador valida los datos
5. Se crea el registro en la base de datos
6. Se redirige al listado de proyectos

---

## 2. FLUJO BACKEND (Laravel)

### 2.1 Rutas (Routes)

**Archivo:** `routes/web.php`

```php
// Ruta para mostrar el formulario de crear proyecto
Route::get('proyectos/create', 'ProyectoController@create')->name('proyectos.create');

// Ruta para guardar el nuevo proyecto
Route::post('proyectos', 'ProyectoController@store')->name('proyectos.store');
```

**Grupo de rutas:**
```php
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    // ... otras rutas ...
    Route::resource('proyectos', 'ProyectoController');
    // ... más rutas específicas para fases del proyecto ...
});
```

**Rutas especiales para crear fases:**
- `proyectos.storeFasediseno` → Crea fase de diseño
- `proyectos.storeFasecomercial` → Crea fase comercial
- `proyectos.storeFasecontable` → Crea fase contable
- `proyectos.storeFasedespachos` → Crea fase de despacho
- `proyectos.storeFasefabricacion` → Crea fase de fabricación
- `proyectos.storeFasecomercialproyecto` → Crea acuerdo comercial
- `proyectos.storeFasepostventa` → Crea fase de postventa
- `proyectos.storeCarpetacliente` → Crea carpeta del cliente

---

### 2.2 Controlador (Controller)

**Archivo:** `app/Http/Controllers/Frontend/ProyectoController.php`

#### Método `create()`
```php
public function create()
{
    // Verifica permisos
    abort_if(Gate::denies('proyecto_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    // Obtiene lista de clientes (empresas)
    $id_clientes = Empresa::pluck('nombe_de_fantasia', 'id')
        ->prepend(trans('global.pleaseSelect'), '');

    // Obtiene lista de usuarios
    $id_usuarios_clientes = User::pluck('name', 'id');

    // Obtiene lista de sucursales
    $sucursals = Sucursal::pluck('nombre', 'id')
        ->prepend(trans('global.pleaseSelect'), '');

    // Retorna la vista con los datos
    return view('frontend.proyectos.create', compact('id_clientes', 'id_usuarios_clientes', 'sucursals'));
}
```

#### Método `store()`
```php
public function store(StoreProyectoRequest $request)
{
    // Crea el nuevo proyecto con los datos validados
    $proyecto = Proyecto::create($request->all());
    
    // Asigna los usuarios al proyecto (relación many-to-many)
    $proyecto->id_usuarios_clientes()->sync($request->input('id_usuarios_clientes', []));

    // Redirige al listado de proyectos
    return redirect()->route('frontend.proyectos.index');
}
```

---

### 2.3 Request de Validación

**Archivo:** `app/Http/Requests/StoreProyectoRequest.php`

```php
<?php

namespace App\Http\Requests;

use App\Models\Proyecto;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProyectoRequest extends FormRequest
{
    public function authorize()
    {
        // Verifica que el usuario tiene permiso para crear proyectos
        return Gate::allows('proyecto_create');
    }

    public function rules()
    {
        return [
            'id_cliente_id' => [
                'required',
                'integer',
            ],
            'id_usuarios_clientes.*' => [
                'integer',
            ],
            'id_usuarios_clientes' => [
                'required',
                'array',
            ],
            'nombre_proyecto' => [
                'string',
                'required',
            ],
            'id_vendedor' => [
                'string',
                'required',
            ],
        ];
    }
}
```

**Campos requeridos:**
- `id_cliente_id` → ID de la empresa cliente
- `id_usuarios_clientes[]` → Array de IDs de usuarios asignados
- `nombre_proyecto` → Nombre del proyecto
- `id_vendedor` → ID del vendedor

---

### 2.4 Modelo (Model)

**Archivo:** `app/Models/Proyecto.php`

```php
class Proyecto extends Model implements HasMedia
{
    use SoftDeletes, HasFactory, InteractsWithMedia;

    public $table = 'proyectos';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'id_cliente_id',
        'sucursal_id',
        'tipo_proyecto',
        'categoria_proyecto',
        'estado',
        'fase',
        'nombre_proyecto',
        'created_at',
        'updated_at',
        'deleted_at',
        'id_fasediseno',
        'id_vendedor',
        'encuesta_id',
        'disenador',
        'instalador',
        'orden'
    ];

    // Relaciones
    public function id_cliente()
    {
        return $this->belongsTo(Empresa::class, 'id_cliente_id');
    }

    public function id_usuarios_clientes()
    {
        return $this->belongsToMany(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }

    // Relaciones con las fases
    public function fasecomercial() { ... }
    public function fasecontable() { ... }
    public function fasedespacho() { ... }
    public function fasefabrica() { ... }
    public function fasepostventa() { ... }
    public function carpetacliente() { ... }
}
```

**Constantes de selección:**
```php
ESTADO_SELECT = [
    'Negocio Ganado',
    'Proyecto Caliente',
    'Proyecto Interesante',
    'Proyecto Potencial',
    'Negocio Perdido'
]

FASE_SELECT = [
    'Fase Diseño',
    'Fase Propuesta Comercial',
    'Fase Contable',
    'Fase Comercial',
    'Fase Fabricacion',
    'Fase Despacho',
    'Fase Postventa'
]

TIPO_PROYECTO_SELECT = [
    'Silla',
    'Mobiliario',
    'Silla y Mobiliario'
]

CATEGORIA_PROYECTO_SELECT = [
    'Agrícola',
    'Alimentos',
    'Arquitectura',
    // ... y más categorías
]
```

---

### 2.5 Tabla de Base de Datos

**Tabla:** `proyectos`

```sql
CREATE TABLE proyectos (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_cliente_id BIGINT UNSIGNED NOT NULL,
    sucursal_id BIGINT UNSIGNED,
    tipo_proyecto VARCHAR(255),
    categoria_proyecto VARCHAR(255),
    estado VARCHAR(255),
    fase VARCHAR(255),
    nombre_proyecto VARCHAR(255) NOT NULL,
    id_vendedor BIGINT UNSIGNED,
    id_fasediseno BIGINT UNSIGNED,
    encuesta_id BIGINT UNSIGNED,
    disenador VARCHAR(255),
    instalador VARCHAR(255),
    orden INT,
    facturacion_id BIGINT UNSIGNED,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (id_cliente_id) REFERENCES empresas(id),
    FOREIGN KEY (sucursal_id) REFERENCES sucursals(id),
    FOREIGN KEY (id_vendedor) REFERENCES users(id)
);
```

**Tabla pivot (relación muchos a muchos):**
```sql
CREATE TABLE proyecto_user (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    proyecto_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

---

## 3. FLUJO FRONTEND (Blade Templates)

### 3.1 Vista de Crear Proyecto

**Archivo:** `resources/views/frontend/proyectos/create.blade.php`

```blade
@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.proyecto.title_singular') }}
                    </div>

                    <div class="card-body">
                        <!-- Formulario POST a la ruta de almacenamiento -->
                        <form method="POST" action="{{ route('frontend.proyectos.store') }}" 
                              enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            
                            <!-- 1. Selección de Cliente (Empresa) -->
                            <div class="form-group">
                                <label class="required" for="id_cliente_id">
                                    {{ trans('cruds.proyecto.fields.id_cliente') }}
                                </label>
                                <select class="form-control select2" name="id_cliente_id" 
                                        id="id_cliente_id" required>
                                    @foreach ($id_clientes as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ old('id_cliente_id') == $id ? 'selected' : '' }}>
                                            {{ $entry }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_cliente_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_cliente_id') }}
                                    </div>
                                @endif
                            </div>

                            <!-- 2. Selección de Usuarios Asignados (Many-to-Many) -->
                            <div class="form-group">
                                <label class="required" for="id_usuarios_clientes">
                                    {{ trans('cruds.proyecto.fields.id_usuarios_cliente') }}
                                </label>
                                <div style="padding-bottom: 4px">
                                    <span class="btn btn-info btn-xs select-all"
                                        style="border-radius: 0">
                                        {{ trans('global.select_all') }}
                                    </span>
                                    <span class="btn btn-info btn-xs deselect-all"
                                        style="border-radius: 0">
                                        {{ trans('global.deselect_all') }}
                                    </span>
                                </div>
                                <select class="form-control select2" name="id_usuarios_clientes[]" 
                                        id="id_usuarios_clientes" multiple required>
                                    @foreach ($id_usuarios_clientes as $id => $usuario)
                                        <option value="{{ $id }}"
                                            {{ in_array($id, old('id_usuarios_clientes', [])) ? 'selected' : '' }}>
                                            {{ $usuario }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_usuarios_clientes'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_usuarios_clientes') }}
                                    </div>
                                @endif
                            </div>

                            <!-- 3. Selección de Sucursal -->
                            <div class="form-group">
                                <label for="sucursal_id">
                                    {{ trans('cruds.proyecto.fields.sucursal') }}
                                </label>
                                <select class="form-control select2" name="sucursal_id" id="sucursal_id">
                                    @foreach ($sucursals as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ old('sucursal_id') == $id ? 'selected' : '' }}>
                                            {{ $entry }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 4. Tipo de Proyecto -->
                            <div class="form-group">
                                <label>{{ trans('cruds.proyecto.fields.tipo_proyecto') }}</label>
                                <select class="form-control" name="tipo_proyecto" id="tipo_proyecto">
                                    <option value disabled {{ old('tipo_proyecto', null) === null ? 'selected' : '' }}>
                                        {{ trans('global.pleaseSelect') }}
                                    </option>
                                    @foreach (App\Models\Proyecto::TIPO_PROYECTO_SELECT as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('tipo_proyecto', '') === (string) $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 5. Estado del Proyecto -->
                            <div class="form-group">
                                <label>{{ trans('cruds.proyecto.fields.estado') }}</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value disabled {{ old('estado', null) === null ? 'selected' : '' }}>
                                        {{ trans('global.pleaseSelect') }}
                                    </option>
                                    @foreach (App\Models\Proyecto::ESTADO_SELECT as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('estado', '') === (string) $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 6. Fase del Proyecto -->
                            <div class="form-group">
                                <label>{{ trans('cruds.proyecto.fields.fase') }}</label>
                                <select class="form-control" name="fase" id="fase">
                                    <option value disabled {{ old('fase', null) === null ? 'selected' : '' }}>
                                        {{ trans('global.pleaseSelect') }}
                                    </option>
                                    @foreach (App\Models\Proyecto::FASE_SELECT as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('fase', '') === (string) $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 7. Nombre del Proyecto -->
                            <div class="form-group">
                                <label class="required" for="nombre_proyecto">
                                    {{ trans('cruds.proyecto.fields.nombre_proyecto') }}
                                </label>
                                <input class="form-control input-custom" 
                                       placeholder="Nombre del proyecto" 
                                       type="text"
                                       name="nombre_proyecto" 
                                       id="nombre_proyecto" 
                                       value="{{ old('nombre_proyecto', '') }}"
                                       required 
                                       style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                @if ($errors->has('nombre_proyecto'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nombre_proyecto') }}
                                    </div>
                                @endif
                            </div>

                            <!-- 8. Imagen del Proyecto (Opcional) -->
                            <div class="form-group">
                                <label for="project-img">Imagen del proyecto</label>
                                <input type="file" 
                                       name="project-img" 
                                       class="form-control input-custom" 
                                       style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                            </div>

                            <!-- Botón de Guardar -->
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```

---

### 3.2 Vista de Listado de Proyectos

**Archivo:** `resources/views/frontend/proyectos/index.blade.php`

Este archivo muestra la lista de proyectos después de crear uno:
- Muestra todos los proyectos del usuario autenticado
- Proporciona opciones para editar, ver detalles y eliminar
- Permite acceder al formulario de crear nuevo proyecto

---

### 3.3 Vista de Mostrar Proyecto

**Archivo:** `resources/views/frontend/proyectos/show.blade.php`

Muestra los detalles completos del proyecto incluyendo:
- Información del cliente
- Fases asociadas (diseño, comercial, contable, etc.)
- Datos de facturación
- Información del vendedor

---

### 3.4 Vista de Editar Proyecto

**Archivo:** `resources/views/frontend/proyectos/edit.blade.php`

Permite modificar los datos del proyecto existente. Sigue la misma estructura que el formulario de creación.

---

## 4. FLUJO DE CREACIÓN DE FASES DEL PROYECTO

Una vez creado el proyecto, se pueden crear sus diferentes fases:

### 4.1 Fases Disponibles

1. **Fase Diseño** → `FaseDisenoController`
2. **Fase Comercial** → `FasecomercialController`
3. **Fase Contable** → `FasecontableController`
4. **Fase Despacho** → `FasedespachoController`
5. **Fase Fabricación** → `FasefabricaController`
6. **Fase Postventa** → `FasePostventaController`
7. **Fase Comercial Proyecto** (Acuerdo Comercial) → `FasecomercialproyectoController`
8. **Carpeta Cliente** → `CarpetaclienteController`

### 4.2 Rutas para Crear Fases

```php
// En routes/web.php dentro del grupo 'admin'

Route::post('proyectos/storeFasediseno', 'ProyectoController@storeFasediseno')
    ->name('proyectos.storeFasediseno');

Route::post('proyectos/storeFasecomercial', 'ProyectoController@storeFasecomercial')
    ->name('proyectos.storeFasecomercial');

Route::post('proyectos/storeFasecontable', 'ProyectoController@storeFasecontable')
    ->name('proyectos.storeFasecontable');

Route::post('proyectos/storeFasedespachos', 'ProyectoController@storeFasedespachos')
    ->name('proyectos.storeFasedespachos');

Route::post('proyectos/storeFasefabricacion', 'ProyectoController@storeFasefabricacion')
    ->name('proyectos.storeFasefabricacion');

Route::post('proyectos/storeFasecomercialproyecto', 'ProyectoController@storeFasecomercialproyecto')
    ->name('proyectos.storeFasecomercialproyecto');

Route::post('proyectos/storeFasepostventa', 'ProyectoController@storeFasepostventa')
    ->name('proyectos.storeFasepostventa');

Route::post('proyectos/storeCarpetacliente', 'ProyectoController@storeCarpetacliente')
    ->name('proyectos.storeCarpetacliente');
```

---

## 5. API REST (Backend)

El proyecto también cuenta con una API REST para operaciones CRUD:

**Archivo:** `routes/api.php`

```php
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 
            'middleware' => ['auth:sanctum']], function () {
    
    // Crear, leer, actualizar, eliminar proyectos
    Route::apiResource('proyectos', 'ProyectoApiController');
    
    // Crear, leer, actualizar, eliminar fases
    Route::apiResource('fase-disenos', 'FaseDisenoApiController');
    Route::apiResource('fasecomercials', 'FasecomercialApiController');
    Route::apiResource('fasecontables', 'FasecontableApiController');
    Route::apiResource('fasedespachos', 'FasedespachoApiController');
    Route::apiResource('fasefabricas', 'FasefabricaApiController');
    Route::apiResource('fasecomercialproyectos', 'FasecomercialproyectoApiController');
    Route::apiResource('carpetaclientes', 'CarpetaclienteApiController');
});
```

**Endpoints:**
- `POST /api/v1/proyectos` → Crear proyecto
- `GET /api/v1/proyectos` → Listar proyectos
- `GET /api/v1/proyectos/{id}` → Obtener proyecto
- `PUT /api/v1/proyectos/{id}` → Actualizar proyecto
- `DELETE /api/v1/proyectos/{id}` → Eliminar proyecto

---

## 6. PERMISOS Y AUTENTICACIÓN

### 6.1 Sistema de Permisos

El proyecto utiliza el sistema de permisos de Laravel con Gates:

```php
// En el controlador:
abort_if(Gate::denies('proyecto_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
abort_if(Gate::denies('proyecto_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
abort_if(Gate::denies('proyecto_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
abort_if(Gate::denies('proyecto_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
abort_if(Gate::denies('proyecto_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
```

### 6.2 Autenticación

Requiere estar autenticado. Las rutas están protegidas con:
- `middleware(['auth', 'admin'])` → Para rutas web
- `middleware(['auth:sanctum'])` → Para API

---

## 7. FLUJO COMPLETO VISUAL

```
┌─────────────────────────────────────────────────────────────────┐
│                      CREAR NUEVO PROYECTO                       │
└─────────────────────────────────────────────────────────────────┘

1. Usuario hace clic en "Nuevo Proyecto"
   ↓
2. Se accede a ProyectoController::create()
   ↓
3. Se cargan datos:
   - Empresas/Clientes
   - Usuarios
   - Sucursales
   ↓
4. Se renderiza vista: resources/views/frontend/proyectos/create.blade.php
   ↓
5. Usuario completa formulario y envía (POST)
   ↓
6. Laravel valida con StoreProyectoRequest::rules()
   ↓
7. Controlador ejecuta ProyectoController::store()
   - Crea registro en tabla 'proyectos'
   - Sincroniza relación many-to-many con usuarios
   - Opcionalmente sube imagen si se proporciona
   ↓
8. Se redirige a ProyectoController::index()
   ↓
9. Usuario ve el proyecto creado en el listado

┌─────────────────────────────────────────────────────────────────┐
│              CREAR FASES DEL PROYECTO (POST-CREACIÓN)          │
└─────────────────────────────────────────────────────────────────┘

Después de crear el proyecto, se pueden agregar fases:

1. Usuario desde view/show del proyecto → Agrrega fase
   ↓
2. Se envía POST a rutas como:
   - proyectos.storeFasediseno
   - proyectos.storeFasecomercial
   - proyectos.storeFasecontable
   - etc.
   ↓
3. Controlador crea registros en tablas:
   - fase_disenos
   - fasecomercials
   - fasecontables
   - etc.
   ↓
4. Se relaciona con el proyecto mediante foreign key
   ↓
5. Se actualiza el estado del proyecto
```

---

## 8. ARCHIVOS CLAVE

### Backend
- `app/Http/Controllers/Frontend/ProyectoController.php` → Controlador principal
- `app/Models/Proyecto.php` → Modelo de proyectos
- `app/Http/Requests/StoreProyectoRequest.php` → Validación
- `routes/web.php` → Rutas web
- `routes/api.php` → Rutas API

### Frontend
- `resources/views/frontend/proyectos/create.blade.php` → Formulario crear
- `resources/views/frontend/proyectos/index.blade.php` → Listado
- `resources/views/frontend/proyectos/show.blade.php` → Detalles
- `resources/views/frontend/proyectos/edit.blade.php` → Editar

### Base de Datos
- Tabla: `proyectos`
- Tabla pivot: `proyecto_user`
- Tablas de fases: `fase_disenos`, `fasecomercials`, `fasecontables`, etc.

---

## 9. EJEMPLO DE FLUJO COMPLETO

```
Entrada: Usuario intenta crear proyecto
↓
GET /admin/proyectos/create
  └─ ProyectoController::create()
     └─ Valida permiso: proyecto_create
     └─ Carga empresas, usuarios, sucursales
     └─ Retorna vista con datos
↓
Usuario completa formulario:
  - Cliente: Empresa XYZ
  - Usuarios: Juan, María
  - Sucursal: Santiago
  - Tipo: Mobiliario
  - Estado: Negocio Ganado
  - Fase: Fase Diseño
  - Nombre: Proyecto Nueva Oficina
  - Imagen: (opcional)
↓
POST /admin/proyectos
  └─ StoreProyectoRequest::authorize() → OK
  └─ StoreProyectoRequest::rules() → Valida datos
  └─ ProyectoController::store()
     └─ Proyecto::create($request->all())
        └─ INSERT INTO proyectos (id_cliente_id, nombre_proyecto, ...) VALUES (...)
        └─ Genera ID del proyecto (ej: 123)
     └─ $proyecto->id_usuarios_clientes()->sync([1, 2])
        └─ INSERT INTO proyecto_user VALUES (123, 1), (123, 2)
     └─ Si hay imagen, la sube a storage
     └─ Retorna redirect a /admin/proyectos
↓
GET /admin/proyectos
  └─ ProyectoController::index()
     └─ Carga proyectos del usuario actual
     └─ Retorna vista con listado
     └─ Usuario ve su nuevo proyecto en la lista ✓
```

---

## 10. CONFIGURACIÓN IMPORTANTE

### Permisos Necesarios en Base de Datos
```sql
-- En tabla 'permissions'
INSERT INTO permissions VALUES (..., 'proyecto_create', 'Crear Proyectos', ...);
INSERT INTO permissions VALUES (..., 'proyecto_read', 'Ver Proyectos', ...);
INSERT INTO permissions VALUES (..., 'proyecto_edit', 'Editar Proyectos', ...);
INSERT INTO permissions VALUES (..., 'proyecto_delete', 'Eliminar Proyectos', ...);
```

### Variables de Entorno (.env)
```
APP_NAME=Portal_clientes_Ohffice
APP_ENV=local
APP_DEBUG=true
APP_URL=http://clientes.ohffice.cl

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portal-clientes
DB_USERNAME=root
DB_PASSWORD=
```

### Almacenamiento de Medios
```php
// En Proyecto::registerMediaCollections()
$this->addMediaCollection('cotizacion')->useDisk('public');
```

---

## 11. NOTAS IMPORTANTES

1. **Soft Deletes**: El modelo Proyecto usa soft deletes, por lo que los proyectos eliminados no se pierden realmente, solo se marcan como eliminados.

2. **Relaciones Many-to-Many**: Un proyecto puede tener múltiples usuarios asignados a través de la tabla pivot `proyecto_user`.

3. **Fases del Proyecto**: Las fases se crean posteriormamente al proyecto, no simultáneamente.

4. **Media Library**: Se utiliza Spatie Media Library para manejar archivos adjuntos como imágenes y documentos.

5. **Auditoría**: El sistema registra timestamps de creación y actualización automaticamente.

6. **API**: Además de la interfaz web, existe una API REST para operaciones programáticas.

---

## 12. TROUBLESHOOTING

### Error 403 Forbidden
- Verificar que el usuario tiene el permiso `proyecto_create`
- Verificar que tiene rol de admin

### Validación falla
- Verificar que `id_cliente_id` es válido
- Verificar que `id_usuarios_clientes` es un array
- Verificar que `nombre_proyecto` no está vacío

### Relación many-to-many no se sincroniza
- Verificar que la tabla `proyecto_user` existe
- Verificar que los IDs de usuarios son válidos

