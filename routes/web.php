<?php

use App\Http\Controllers\soporte;
use Illuminate\Support\Facades\Artisan;

Route::view('/', 'welcome');
Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/kpis', 'HomeController@kpis')->name('kpis');
    Route::get('/metricas', 'HomeController@metricas')->name('metricas');
    Route::get('/metricas-pie', 'HomeController@metricaspie')->name('metricaspie');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::post('users/getsucursales', 'UsersController@getSucursales')->name('users.getSucursales');
    Route::resource('users', 'UsersController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Empresa
    Route::delete('empresas/destroy', 'EmpresaController@massDestroy')->name('empresas.massDestroy');
    Route::post('empresas/media', 'EmpresaController@storeMedia')->name('empresas.storeMedia');
    Route::post('empresas/ckmedia', 'EmpresaController@storeCKEditorImages')->name('empresas.storeCKEditorImages');
    Route::resource('empresas', 'EmpresaController');

    // Sucursal
    Route::delete('sucursals/destroy', 'SucursalController@massDestroy')->name('sucursals.massDestroy');
    Route::resource('sucursals', 'SucursalController');

    // Proyecto
    Route::post('proyectos/storeCarpetacliente', 'ProyectoController@storeCarpetacliente')->name('proyectos.storeCarpetacliente');
    Route::post('proyectos/storeFasepostventa', 'ProyectoController@storeFasepostventa')->name('proyectos.storeFasepostventa');
    Route::post('proyectos/storeFasedespachos', 'ProyectoController@storeFasedespachos')->name('proyectos.storeFasedespachos');
    Route::post('proyectos/storeFasefabricacion', 'ProyectoController@storeFasefabricacion')->name('proyectos.storeFasefabricacion');
    Route::post('proyectos/storeFasecomercialproyecto', 'ProyectoController@storeFasecomercialproyecto')->name('proyectos.storeFasecomercialproyecto');
    Route::post('proyectos/storeFasecontable', 'ProyectoController@storeFasecontable')->name('proyectos.storeFasecontable');
    Route::post('proyectos/storeFasecomercial', 'ProyectoController@storeFasecomercial')->name('proyectos.storeFasecomercial');
    Route::post('proyectos/storeFasediseno', 'ProyectoController@storeFasediseno')->name('proyectos.storeFasediseno');
    Route::delete('proyectos/destroy', 'ProyectoController@massDestroy')->name('proyectos.massDestroy');
    Route::post('proyectos/getusuario', 'ProyectoController@getUsuario')->name('proyectos.getUsuario');
    Route::resource('proyectos', 'ProyectoController');
    Route::get('/proyectos/descargar', function (Request $request) {
        $filePath = $request->query('file');

        // Validar que el archivo existe y está dentro de un directorio permitido
        $baseDirectory = "E:/OHFFICE/Usuarios/TI_Ohffice/Proyectos/PROYECTOS/";
        $realPath = realpath($filePath);

        if (!$realPath || !str_starts_with($realPath, realpath($baseDirectory))) {
            abort(403, 'Acceso no permitido.');
        }

        if (file_exists($realPath)) {
            return response()->file($realPath);
        }

        abort(404, 'Archivo no encontrado');
    })->name('descargar.archivo');


    // Fase Diseno
    Route::delete('fase-disenos/destroy', 'FaseDisenoController@massDestroy')->name('fase-disenos.massDestroy');
    Route::post('fase-disenos/store_proyecto', 'FaseDisenoController@store_proyecto')->name('fase-disenos.store_proyecto');
    Route::post('fase-disenos/media', 'FaseDisenoController@storeMedia')->name('fase-disenos.storeMedia');
    Route::post('fase-disenos/ckmedia', 'FaseDisenoController@storeCKEditorImages')->name('fase-disenos.storeCKEditorImages');

    Route::resource('fase-disenos', 'FaseDisenoController');

    // Fasecomercial
    Route::delete('fasecomercials/destroy', 'FasecomercialController@massDestroy')->name('fasecomercials.massDestroy');
    Route::post('fasecomercials/media', 'FasecomercialController@storeMedia')->name('fasecomercials.storeMedia');
    Route::post('fasecomercials/ckmedia', 'FasecomercialController@storeCKEditorImages')->name('fasecomercials.storeCKEditorImages');
    Route::resource('fasecomercials', 'FasecomercialController');

    // Fasecontable
    Route::delete('fasecontables/destroy', 'FasecontableController@massDestroy')->name('fasecontables.massDestroy');
    Route::post('fasecontables/media', 'FasecontableController@storeMedia')->name('fasecontables.storeMedia');
    Route::post('fasecontables/ckmedia', 'FasecontableController@storeCKEditorImages')->name('fasecontables.storeCKEditorImages');
    Route::resource('fasecontables', 'FasecontableController');

    // Fasedespacho
    Route::delete('fasedespachos/destroy', 'FasedespachoController@massDestroy')->name('fasedespachos.massDestroy');
    Route::post('fasedespachos/media', 'FasedespachoController@storeMedia')->name('fasedespachos.storeMedia');
    Route::post('fasedespachos/ckmedia', 'FasedespachoController@storeCKEditorImages')->name('fasedespachos.storeCKEditorImages');
    Route::resource('fasedespachos', 'FasedespachoController');

    // Fasefabrica
    Route::delete('fasefabricas/destroy', 'FasefabricaController@massDestroy')->name('fasefabricas.massDestroy');
    Route::post('fasefabricas/media', 'FasefabricaController@storeMedia')->name('fasefabricas.storeMedia');
    Route::post('fasefabricas/ckmedia', 'FasefabricaController@storeCKEditorImages')->name('fasefabricas.storeCKEditorImages');
    Route::post('fasefabricas/update-estado-produccion', 'FasefabricaController@updateEstadoProduccion')->name('fasefabricas.updateEstadoProduccion');
    Route::resource('fasefabricas', 'FasefabricaController');

    // Fasecomercialproyecto
    Route::delete('fasecomercialproyectos/destroy', 'FasecomercialproyectoController@massDestroy')->name('fasecomercialproyectos.massDestroy');
    Route::post('fasecomercialproyectos/media', 'FasecomercialproyectoController@storeMedia')->name('fasecomercialproyectos.storeMedia');
    Route::post('fasecomercialproyectos/ckmedia', 'FasecomercialproyectoController@storeCKEditorImages')->name('fasecomercialproyectos.storeCKEditorImages');
    Route::resource('fasecomercialproyectos', 'FasecomercialproyectoController');

    // Carpetacliente
    Route::delete('carpetaclientes/destroy', 'CarpetaclienteController@massDestroy')->name('carpetaclientes.massDestroy');
    Route::post('carpetaclientes/media', 'CarpetaclienteController@storeMedia')->name('carpetaclientes.storeMedia');
    Route::post('carpetaclientes/ckmedia', 'CarpetaclienteController@storeCKEditorImages')->name('carpetaclientes.storeCKEditorImages');
    Route::resource('carpetaclientes', 'CarpetaclienteController');

    // Ticket
    Route::post('tickets/cerrarTicket', 'TicketController@cerrarTicket')->name('tickets.cerrarTicket');
    Route::post('tickets/asignarVendedor', 'TicketController@asignarVendedor')->name('tickets.asignarVendedor');
    Route::post('tickets/getVendedor', 'TicketController@getVendedor')->name('tickets.getVendedor');
    Route::post('tickets/storeMensaje', 'TicketController@storeMensaje')->name('tickets.storeMensaje');
    Route::delete('tickets/destroy', 'TicketController@massDestroy')->name('tickets.massDestroy');
    Route::resource('tickets', 'TicketController');

    // Encuesta
    Route::delete('encuesta/destroy', 'EncuestaController@massDestroy')->name('encuesta.massDestroy');
    Route::resource('encuesta', 'EncuestaController');

    // Fase Postventa
    Route::delete('fase-postventa/destroy', 'FasePostventaController@massDestroy')->name('fase-postventa.massDestroy');
    Route::resource('fase-postventa', 'FasePostventaController');

    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Empresa
    Route::delete('empresas/destroy', 'EmpresaController@massDestroy')->name('empresas.massDestroy');
    Route::resource('empresas', 'EmpresaController');

    // Sucursal
    Route::delete('sucursals/destroy', 'SucursalController@massDestroy')->name('sucursals.massDestroy');
    Route::resource('sucursals', 'SucursalController');

    // Proyecto

    Route::post('proyectos/aceptaConforme', 'ProyectoController@aceptaConforme')->name('proyectos.aceptaConforme');
    Route::post('proyectos/confirmarHorario', 'ProyectoController@confirmarHorario')->name('proyectos.confirmarHorario');
    Route::post('proyectos/storeFacturacion', 'ProyectoController@storeFacturacion')->name('proyectos.storeFacturacion');
    Route::delete('proyectos/destroy', 'ProyectoController@massDestroy')->name('proyectos.massDestroy');
    Route::resource('proyectos', 'ProyectoController');

    // Fase Diseno
    Route::delete('fase-disenos/destroy', 'FaseDisenoController@massDestroy')->name('fase-disenos.massDestroy');
    Route::post('fase-disenos/media', 'FaseDisenoController@storeMedia')->name('fase-disenos.storeMedia');
    Route::post('fase-disenos/ckmedia', 'FaseDisenoController@storeCKEditorImages')->name('fase-disenos.storeCKEditorImages');
    Route::resource('fase-disenos', 'FaseDisenoController');

    // Fasecomercial
    Route::delete('fasecomercials/destroy', 'FasecomercialController@massDestroy')->name('fasecomercials.massDestroy');
    Route::post('fasecomercials/media', 'FasecomercialController@storeMedia')->name('fasecomercials.storeMedia');
    Route::post('fasecomercials/ckmedia', 'FasecomercialController@storeCKEditorImages')->name('fasecomercials.storeCKEditorImages');
    Route::resource('fasecomercials', 'FasecomercialController');

    // Fasecontable
    Route::delete('fasecontables/destroy', 'FasecontableController@massDestroy')->name('fasecontables.massDestroy');
    Route::post('fasecontables/media', 'FasecontableController@storeMedia')->name('fasecontables.storeMedia');
    Route::post('fasecontables/ckmedia', 'FasecontableController@storeCKEditorImages')->name('fasecontables.storeCKEditorImages');
    Route::resource('fasecontables', 'FasecontableController');

    // Fasedespacho
    Route::delete('fasedespachos/destroy', 'FasedespachoController@massDestroy')->name('fasedespachos.massDestroy');
    Route::post('fasedespachos/media', 'FasedespachoController@storeMedia')->name('fasedespachos.storeMedia');
    Route::post('fasedespachos/ckmedia', 'FasedespachoController@storeCKEditorImages')->name('fasedespachos.storeCKEditorImages');
    Route::resource('fasedespachos', 'FasedespachoController');

    // Fasefabrica
    Route::delete('fasefabricas/destroy', 'FasefabricaController@massDestroy')->name('fasefabricas.massDestroy');
    Route::post('fasefabricas/media', 'FasefabricaController@storeMedia')->name('fasefabricas.storeMedia');
    Route::post('fasefabricas/ckmedia', 'FasefabricaController@storeCKEditorImages')->name('fasefabricas.storeCKEditorImages');
    Route::resource('fasefabricas', 'FasefabricaController');

    // Fasecomercialproyecto
    Route::delete('fasecomercialproyectos/destroy', 'FasecomercialproyectoController@massDestroy')->name('fasecomercialproyectos.massDestroy');
    Route::post('fasecomercialproyectos/media', 'FasecomercialproyectoController@storeMedia')->name('fasecomercialproyectos.storeMedia');
    Route::post('fasecomercialproyectos/ckmedia', 'FasecomercialproyectoController@storeCKEditorImages')->name('fasecomercialproyectos.storeCKEditorImages');
    Route::resource('fasecomercialproyectos', 'FasecomercialproyectoController');

    // Carpetacliente
    Route::delete('carpetaclientes/destroy', 'CarpetaclienteController@massDestroy')->name('carpetaclientes.massDestroy');
    Route::post('carpetaclientes/media', 'CarpetaclienteController@storeMedia')->name('carpetaclientes.storeMedia');
    Route::post('carpetaclientes/ckmedia', 'CarpetaclienteController@storeCKEditorImages')->name('carpetaclientes.storeCKEditorImages');
    Route::resource('carpetaclientes', 'CarpetaclienteController');

    // Ticket
    Route::post('tickets/getVendedor', 'TicketController@getVendedor')->name('tickets.getVendedor');
    Route::post('tickets/storeMensaje', 'TicketController@storeMensaje')->name('tickets.storeMensaje');
    Route::delete('tickets/destroy', 'TicketController@massDestroy')->name('tickets.massDestroy');
    Route::resource('tickets', 'TicketController');


    // Encuesta

    //Route::post('encuesta/create/{id_proyecto}', 'EncuestaController@create')->name('encuesta.create');
    Route::delete('encuesta/destroy', 'EncuestaController@massDestroy')->name('encuesta.massDestroy');
    Route::resource('encuesta', 'EncuestaController');
    Route::get('encuesta/responder/{id_proyecto}', 'EncuestaController@Responder')->name('encuesta.Responder');

    // Fase Postventa
    Route::delete('fase-postventa/destroy', 'FasePostventaController@massDestroy')->name('fase-postventa.massDestroy');
    Route::resource('fase-postventa', 'FasePostventaController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');

    // soporte
    /*Route::get(
        '/soporte',
        'HomeController@soporte'
    )->name('soporte');*/

    Route::get('/route-cache', function () {
        //$exitCode = Artisan::call('make:migration add_tipo_empresa_to_empresas_table');
        $exitCode = Artisan::call('route:cache');

        // Puedes manejar la salida del comando si es necesario
        $output = Artisan::output();

        return "Migration completed. Exit code: $exitCode\n$output";
    });

    Route::get('/route-clear', function () {
        //$exitCode = Artisan::call('make:migration add_tipo_empresa_to_empresas_table');
        $exitCode = Artisan::call('route:clear');

        // Puedes manejar la salida del comando si es necesario
        $output = Artisan::output();

        return "Migration completed. Exit code: $exitCode\n$output";
    });

    Route::get('/route-list', function () {
        //$exitCode = Artisan::call('make:migration add_tipo_empresa_to_empresas_table');
        $exitCode = Artisan::call('route:list');

        // Puedes manejar la salida del comando si es necesario
        $output = Artisan::output();

        return "Migration completed. Exit code: $exitCode\n$output";
    });

});
