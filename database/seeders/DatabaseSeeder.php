<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::flushEventListeners();
        // Create Roles
        $admin = Role::create(['name' => 'superadmin']);
        $serverOwner = Role::create(['name' => 'server_owner']);

        // Create Permissions
        Permission::create(['name' => 'manage-users']);
        Permission::create(['name' => 'manage-store']);
        Permission::create(['name' => 'buy-items']);

        //Asign perms to roles
        $admin->givePermissionTo(['manage-users', 'manage-store', 'buy-items']);
        $serverOwner->givePermissionTo(['manage-store', 'buy-items']);

        // Crear un usuario administrativo si no existe
        $user = User::firstOrCreate([
            'email' => 'admin@dominio.com', // Cambia al email que desees
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('123456789'), // Cambia la contraseña según sea necesario
        ]);

        // Asignar el rol administrativo (asegúrate de que el rol exista)
        $role = Role::firstOrCreate(['name' => 'superadmin']); // Cambia 'admin' por el rol que prefieras
        $user->assignRole($role);
        User::observe(UserObserver::class);
    }
}
