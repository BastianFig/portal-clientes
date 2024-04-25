<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 18,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 21,
                'title' => 'empresa_create',
            ],
            [
                'id'    => 22,
                'title' => 'empresa_edit',
            ],
            [
                'id'    => 23,
                'title' => 'empresa_show',
            ],
            [
                'id'    => 24,
                'title' => 'empresa_delete',
            ],
            [
                'id'    => 25,
                'title' => 'empresa_access',
            ],
            [
                'id'    => 26,
                'title' => 'empresas_cliente_access',
            ],
            [
                'id'    => 27,
                'title' => 'sucursal_create',
            ],
            [
                'id'    => 28,
                'title' => 'sucursal_edit',
            ],
            [
                'id'    => 29,
                'title' => 'sucursal_show',
            ],
            [
                'id'    => 30,
                'title' => 'sucursal_delete',
            ],
            [
                'id'    => 31,
                'title' => 'sucursal_access',
            ],
            [
                'id'    => 32,
                'title' => 'proyecto_create',
            ],
            [
                'id'    => 33,
                'title' => 'proyecto_edit',
            ],
            [
                'id'    => 34,
                'title' => 'proyecto_show',
            ],
            [
                'id'    => 35,
                'title' => 'proyecto_delete',
            ],
            [
                'id'    => 36,
                'title' => 'proyecto_access',
            ],
            [
                'id'    => 37,
                'title' => 'fase_diseno_create',
            ],
            [
                'id'    => 38,
                'title' => 'fase_diseno_edit',
            ],
            [
                'id'    => 39,
                'title' => 'fase_diseno_show',
            ],
            [
                'id'    => 40,
                'title' => 'fase_diseno_delete',
            ],
            [
                'id'    => 41,
                'title' => 'fase_diseno_access',
            ],
            [
                'id'    => 42,
                'title' => 'fasecomercial_create',
            ],
            [
                'id'    => 43,
                'title' => 'fasecomercial_edit',
            ],
            [
                'id'    => 44,
                'title' => 'fasecomercial_show',
            ],
            [
                'id'    => 45,
                'title' => 'fasecomercial_delete',
            ],
            [
                'id'    => 46,
                'title' => 'fasecomercial_access',
            ],
            [
                'id'    => 47,
                'title' => 'fasecontable_create',
            ],
            [
                'id'    => 48,
                'title' => 'fasecontable_edit',
            ],
            [
                'id'    => 49,
                'title' => 'fasecontable_show',
            ],
            [
                'id'    => 50,
                'title' => 'fasecontable_delete',
            ],
            [
                'id'    => 51,
                'title' => 'fasecontable_access',
            ],
            [
                'id'    => 52,
                'title' => 'fasedespacho_create',
            ],
            [
                'id'    => 53,
                'title' => 'fasedespacho_edit',
            ],
            [
                'id'    => 54,
                'title' => 'fasedespacho_show',
            ],
            [
                'id'    => 55,
                'title' => 'fasedespacho_delete',
            ],
            [
                'id'    => 56,
                'title' => 'fasedespacho_access',
            ],
            [
                'id'    => 57,
                'title' => 'fasefabrica_create',
            ],
            [
                'id'    => 58,
                'title' => 'fasefabrica_edit',
            ],
            [
                'id'    => 59,
                'title' => 'fasefabrica_show',
            ],
            [
                'id'    => 60,
                'title' => 'fasefabrica_delete',
            ],
            [
                'id'    => 61,
                'title' => 'fasefabrica_access',
            ],
            [
                'id'    => 62,
                'title' => 'fases_de_proyecto_access',
            ],
            [
                'id'    => 63,
                'title' => 'fasecomercialproyecto_create',
            ],
            [
                'id'    => 64,
                'title' => 'fasecomercialproyecto_edit',
            ],
            [
                'id'    => 65,
                'title' => 'fasecomercialproyecto_show',
            ],
            [
                'id'    => 66,
                'title' => 'fasecomercialproyecto_delete',
            ],
            [
                'id'    => 67,
                'title' => 'fasecomercialproyecto_access',
            ],
            [
                'id'    => 68,
                'title' => 'carpetacliente_create',
            ],
            [
                'id'    => 69,
                'title' => 'carpetacliente_edit',
            ],
            [
                'id'    => 70,
                'title' => 'carpetacliente_show',
            ],
            [
                'id'    => 71,
                'title' => 'carpetacliente_delete',
            ],
            [
                'id'    => 72,
                'title' => 'carpetacliente_access',
            ],
            [
                'id'    => 73,
                'title' => 'ticket_create',
            ],
            [
                'id'    => 74,
                'title' => 'ticket_edit',
            ],
            [
                'id'    => 75,
                'title' => 'ticket_show',
            ],
            [
                'id'    => 76,
                'title' => 'ticket_delete',
            ],
            [
                'id'    => 77,
                'title' => 'ticket_access',
            ],
            [
                'id'    => 78,
                'title' => 'encuestum_create',
            ],
            [
                'id'    => 79,
                'title' => 'encuestum_edit',
            ],
            [
                'id'    => 80,
                'title' => 'encuestum_show',
            ],
            [
                'id'    => 81,
                'title' => 'encuestum_delete',
            ],
            [
                'id'    => 82,
                'title' => 'encuestum_access',
            ],
            [
                'id'    => 83,
                'title' => 'fase_postventum_create',
            ],
            [
                'id'    => 84,
                'title' => 'fase_postventum_edit',
            ],
            [
                'id'    => 85,
                'title' => 'fase_postventum_show',
            ],
            [
                'id'    => 86,
                'title' => 'fase_postventum_delete',
            ],
            [
                'id'    => 87,
                'title' => 'fase_postventum_access',
            ],
            [
                'id'    => 88,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
