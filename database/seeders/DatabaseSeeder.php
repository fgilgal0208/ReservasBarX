<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creamos el único usuario del sistema
        User::updateOrCreate(
            ['name' => 'barx'], // Nombre de usuario
            [
                'email' => 'admin@barequis.com', // Correo ficticio (obligatorio en Laravel)
                'password' => Hash::make('barx40'), // Contraseña encriptada
            ]
        );
    }
}