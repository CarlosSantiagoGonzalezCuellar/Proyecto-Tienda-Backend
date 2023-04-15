<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $role = new Role();
        $role->rolNombre = "Usuario";
        $role->save();

        $role2 = new Role();
        $role2->rolNombre = "Administrador";
        $role2->save();

        $role = new Category();
        $role->catNombre = "Electrodomestico";
        $role->save();

        $role2 = new Category();
        $role2->catNombre = "Calzado";
        $role2->save();
    }
}
