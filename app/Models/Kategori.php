<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'id_kategori',
        'nama_kategori',
    ];
    public function kategori(){
        return $this->hasMany(Berita::class, 'id_kategori', 'id_kategori');
    }
}
