<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o recuperar el usuario administrador
        $user = User::firstOrCreate(
            [
                'email' => 'admin@gmail.com',
            ],
            [
                'name' => 'Sak Eliazar',
                'password' => bcrypt('12345678'),
            ]
        );

        // Crear o recuperar el rol administrador
        $rol = Role::firstOrCreate(
            [
                'name' => 'administrador',
                'guard_name' => 'web',
            ]
        );

        // Asignar todos los permisos al rol
        $rol->syncPermissions(Permission::all());

        // Asignar el rol al usuario
        if (!$user->hasRole($rol->name)) {
            $user->assignRole($rol);
        }
    }
}