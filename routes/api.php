<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Empresa
    Route::apiResource('empresas', 'EmpresaApiController');

    // Sucursal
    Route::apiResource('sucursals', 'SucursalApiController');

    // Proyecto
    Route::apiResource('proyectos', 'ProyectoApiController');

    // Fase Diseno
    Route::post('fase-disenos/media', 'FaseDisenoApiController@storeMedia')->name('fase-disenos.storeMedia');
    Route::apiResource('fase-disenos', 'FaseDisenoApiController');

    // Fasecomercial
    Route::post('fasecomercials/media', 'FasecomercialApiController@storeMedia')->name('fasecomercials.storeMedia');
    Route::apiResource('fasecomercials', 'FasecomercialApiController');

    // Fasecontable
    Route::post('fasecontables/media', 'FasecontableApiController@storeMedia')->name('fasecontables.storeMedia');
    Route::apiResource('fasecontables', 'FasecontableApiController');

    // Fasedespacho
    Route::post('fasedespachos/media', 'FasedespachoApiController@storeMedia')->name('fasedespachos.storeMedia');
    Route::apiResource('fasedespachos', 'FasedespachoApiController');

    // Fasefabrica
    Route::post('fasefabricas/media', 'FasefabricaApiController@storeMedia')->name('fasefabricas.storeMedia');
    Route::apiResource('fasefabricas', 'FasefabricaApiController');

    // Fasecomercialproyecto
    Route::post('fasecomercialproyectos/media', 'FasecomercialproyectoApiController@storeMedia')->name('fasecomercialproyectos.storeMedia');
    Route::apiResource('fasecomercialproyectos', 'FasecomercialproyectoApiController');

    // Carpetacliente
    Route::post('carpetaclientes/media', 'CarpetaclienteApiController@storeMedia')->name('carpetaclientes.storeMedia');
    Route::apiResource('carpetaclientes', 'CarpetaclienteApiController');

    // Ticket
    Route::apiResource('tickets', 'TicketApiController');

    // Encuesta
    Route::apiResource('encuesta', 'EncuestaApiController');

    // Fase Postventa
    Route::apiResource('fase-postventa', 'FasePostventaApiController');
    
});

 //AUTH
    Route::post('register', 'Api\\AuthController@register');
    Route::post('login', 'Api\\AuthController@login');
