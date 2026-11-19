<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Usuario de prueba para Postman (password: "password")
        // Usuario registrado desde la web para las capturas: oscar@gmail.com (password: "Change2026!")
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        foreach (['Medio ambiente', 'Educación', 'Sanidad', 'Animales', 'Derechos humanos'] as $nombre) {
            Categoria::create(['nombre' => $nombre]);
        }
    }
}
