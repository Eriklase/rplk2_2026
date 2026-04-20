<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    protected $table = 'berita';

    protected $primaryKey = 'id_berita';

    protected $fillable = ['id_berita', 'judul_barita', 'isi_barita', 'gambar_barita', 'id_kategori','total_view'];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
