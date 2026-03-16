<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('test@example.com'),
        ]);

        Kategori::create([
            'nama_kategori' => 'Kategori 1',
        ]);

        Berita::create([
            'judul_berita' => 'Lorem Ipsum',
            'isi_berita' => 'Lorem Ipsum',
            'gambar_berita' => 'Jordan.jpg',
            'id_kategori' => '1',
        ]);
    }
}
