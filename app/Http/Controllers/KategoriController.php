<?php

namespace App\Http\Controllers;

use App\Exports\KategoriExport;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('backend.content.kategori.index', compact('kategori'));
    }

    public function tambah()
    {
        return view('backend.content.kategori.tambah');
    }

    public function prosesTambah(Request $request)
    {
        $$request->validate([
            'nama_kategori' => 'required',
        ]);
        
        $kategori = new kategori();
        $kategori->nama_kategori = $request->nama_kategori;

        try {
            $kategori->save();
            return redirect(route('kategori.index'))->with('pesan', ['success', 'Kategori berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect(route('kategori.index'))->with('pesan', ['danger', 'Kategori gagal ditambahkan']);
        }
    }

    public function ubah($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        return view('backend.content.kategori.ubah', compact('kategori'));
    }

    public function prosesUbah(Request $request)
    {
        $validated = $request->validate([
            'id_kategori' => 'required',
            'nama_kategori' => 'required',
        ]);

        $kategori = Kategori::findOrFail($request->id_kategori);
        $kategori->nama_kategori = $request->nama_kategori;

        try {
            $kategori->save();
            return redirect(route('kategori.index'))->with('pesan', ['success', 'Kategori berhasil diubah']);
        } catch (\Exception $e) {
            return redirect(route('kategori.index'))->with('pesan', ['danger', 'Kategori gagal di ubah']);
        }
    }

    public function hapus($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);

        try {
            $kategori->delete();
            return redirect(route('kategori.index'))->with('pesan', ['success', 'Kategori berhasil di hapus']);
        } catch (\Exception $e) {
            return redirect(route('kategori.index'))->with('pesan', ['danger', 'Kategori gagal dihapus']);
        }
    }

    public function exportPdf()
    {
        $kategori = Kategori::all();
        $pdf = PDF::loadView('backend.content.kategori.exportPdf', compact('kategori'));
        return $pdf->download('kategori.pdf');
    }
    public function export()
    {
        $kategori = Kategori::all();
        $pdf = Pdf::loadView('backend.content.kategori.export', compact('kategori'));
        //return $pdf->download('kategori.pdf');
        return $pdf->stream('kategori.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new KategoriExport(), 'kategori.xlsx');
    }
}
