<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\User;
use DB;
use Dompdf\FrameDecorator\Page;
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
            'email' => 'ph',
            'password' => bcrypt('123456'),
        ]);

        DB::table('kategori')->insert([
            'nama_kategori' => 'Kategori 1',
        ]);

        DB::table('berita')->insert([
            'judul_berita' => 'Kategori 2',
            'isi_berita' => 'Lorem Ipsum',
            'gambar_berita' => 'Lorem Ipsum',
            'id_kategori' => '1'
        ]);

        DB::table('page')->insert([
            'id_page' => '1',
            'judul_page' => 'Lorem Ipsum',
            'isi_page' => 'Lorem Ipsum',
            'status_page' => 1
        ]);

            DB::table('menu')->insert([
            'nama_menu' => 'Lorem',
            'jenis_menu' => 'page',
            'url_menu' => '1',
            'target_menu' => '_blank',
            'urutan_menu' => 1
        ]);

         DB::table('menu')->insert([
            'nama_menu' => 'Google',
            'jenis_menu' => 'url',
            'url_menu' => 'https://www.google.com',
            'target_menu' => '_blank',
            'urutan_menu' => 2
        ]);

         DB::table('menu')->insert([
            'nama_menu' => 'Cloud Storage',
            'jenis_menu' => 'url',
            'url_menu' => '#',
            'target_menu' => '_self',
            'urutan_menu' => 3
        ]);

         DB::table('menu')->insert([
            'nama_menu' => 'GCP',
            'jenis_menu' => 'url',
            'url_menu' => 'https://cloud.google.com',
            'target_menu' => '_self',
            'urutan_menu' => 1,
            'parent_menu' => 3
        ]);

        DB::table('menu')->insert([
            'nama_menu' => 'AWS',
            'jenis_menu' => 'url',
            'url_menu' => 'https://aws.amazon.com',
            'target_menu' => '_self',
            'urutan_menu' => 2,
            'parent_menu' => 3
        ]);

    }
}