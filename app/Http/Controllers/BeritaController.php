<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(){
        $berita = Berita::with('kategori')->get();
        return view('backend.content.berita.index',compact('berita'));
    }

    public function tambah(){
        $kategori = Kategori::all();
        return view('backend.content.berita.tambah',compact('kategori'));
    }

    public function prosesTambah(Request $request){
        $request->validate([
            'judul_berita' => 'required',
            'isi_berita' => 'required',
            'id_kategori' => 'required',
            'gambar_berita' => 'required',
        ]);

        $request->file('gambar_berita')->store('berita','public');
        $gambar_berita = $request->file('gambar_berita')->hashName();

        $berita = new Berita();
        $berita->judul_berita = $request->judul_berita;
        $berita->isi_berita = $request->isi_berita;
        $berita->id_kategori = $request->id_kategori;
        $berita->gambar_berita =$gambar_berita;

        try {
            $berita->save();
            return redirect(route('berita.index'))->with('pesan',['success','berita berhasil ditambahkan']);
        }catch (\Exception $e){
            return redirect(route('berita.index'))->with('pesan',['danger','berita gagal ditambahkan']);
        }
    }

    public function ubah($id){
        $berita = Berita::findOrFail($id);
        $kategori = Kategori::all();
        return view('backend.content.berita.ubah',compact('berita','kategori'));
    }

    public function prosesUbah(Request $request){
        $request->validate([
            'judul_berita' => 'required',
            'isi_berita' => 'required',
            'id_kategori' => 'required',
        ]);
        $berita = Berita::findOrFail($request->id_berita);
        $berita->judul_berita = $request->judul_berita;
        $berita->isi_berita = $request->isi_berita;
        $berita->id_kategori = $request->id_kategori;

        if($request->file('gambar_berita')){
            $request->file('gambar_berita')->store('berita','public');
            $gambar_berita = $request->file('gambar_berita')->hashName();
            $berita->gambar_berita = $gambar_berita;
        }

        try {
            $berita->save();
            return redirect(route('berita.index'))->with('pesan',['success','berita berhasil ubah']);
        }catch (\Exception $e){
            return redirect(route('berita.index'))->with('pesan',['danger','berita gagal ubah']);
        }
    }

    public function hapus($id){
        $berita = Berita::findOrFail($id);

        try {
            $berita->delete();
            return redirect(route('berita.index'))->with('pesan',['success','berita berhasil dihapus']);
        }catch (\Exception $e){
            return redirect(route('berita.index'))->with('pesan',['danger','berita gagal dihapus']);
        }
    }
}
