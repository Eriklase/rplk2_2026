<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $page = Page::all();
        return view('backend.content.page.index', compact('page'));
    }

    public function tambah()
    {
        return view('backend.content.page.tambah');
    }

    public function prosesTambah(Request $request)
    {
        $validated = $request->validate([
            'judul_page' => 'required',
            'isi_page' => 'required',
        ]);
        $page = new page();
        $page->judul_page = $request->judul_page;
        $page->isi_page = $request->isi_page;
        $page->status_page = 1;

        try {
            $page->save();
            return redirect(route('page.index'))->with('pesan', ['success', 'Page berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect(route('page.index'))->with('pesan', ['danger', 'Page gagal ditambahkan']);
        }
    }

    public function ubah($id_kategori)
    {
        $page = Page::findOrFail($id_kategori);
        return view('backend.content.page.ubah', compact('page'));
    }

    public function prosesUbah(Request $request)
    {
        $request->validate([
            'id_page' => 'required',
            'judul_page' => 'required',
            'isi_page' => 'required',
            'status_page' => 'required',
        ]);

        try {
            $page = Page::findOrFail($request->id_page);
            $page->judul_page = $request->judul_page;
            $page->isi_page = $request->isi_page;
            $page->status_page =$request->status_page;
            $page->save();

            return redirect(route('page.index'))->with('pesan', ['success', 'Page berhasil diubah']);
        } catch (\Exception $e) {
            return redirect(route('page.index'))->with('pesan', ['danger', 'Page gagal di ubah']);
        }
    }

    public function hapus($id_kategori)
    {
        $page = Page::findOrFail($id_kategori);

        try {
            $page->delete();
            return redirect(route('page.index'))->with('pesan', ['success', 'Kategori berhasil di hapus']);
        } catch (\Exception $e) {
            return redirect(route('page.index'))->with('pesan', ['danger', 'Kategori gagal dihapus']);
        }
    }
}
