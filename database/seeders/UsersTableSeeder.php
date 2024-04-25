<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Nicolas Salazar',
                'email'          => 'nsalazar@probit.cl',
                'password'       => bcrypt('probitweb901'),
                'remember_token' => null,
                'telefono'       => '',
            ],
            [
                'id'             => 2,
                'name'           => 'Martin Salazar',
                'email'          => 'msalazar@probit.cl',
                'password'       => bcrypt('probitweb901'),
                'remember_token' => null,
                'telefono'       => '',
            ],
            [
                'id'             => 3,
                'name'           => 'Miguel riveros',
                'email'          => 'miguel.riveros@ohffice.cl',
                'password'       => bcrypt('mriveros.2023'),
                'remember_token' => null,
                'telefono'       => '',
            ],
            [
                'id'             => 4,
                'name'           => 'Felipe Bustamante',
                'email'          => 'felipe.bustamante@ohffice.cl',
                'password'       => bcrypt('fbustamante2023'),
                'remember_token' => null,
                'telefono'       => '',
            ],
            [
                'id'             => 5,
                'name'           => 'Jhonatan Vergara',
                'email'          => 'jvergara@probit.cl',
                'password'       => bcrypt('probitweb901'),
                'remember_token' => null,
                'telefono'       => '',
            ],
        ];

        User::insert($users);
    }
}
