<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crée un utilisateur admin avec les valeurs définies dans .env
        User::create([
            'username' => env('ADMIN_USERNAME', 'admin'), // Valeur par défaut si non défini dans .env
            'email' => env('ADMIN_EMAIL', 'admin@example.com'), // Valeur par défaut si non défini dans .env
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')), // Hash du mot de passe
            'role' => 'admin' // Rôle d'administrateur
        ]);
    }
}
