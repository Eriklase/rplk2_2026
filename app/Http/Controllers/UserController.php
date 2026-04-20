<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('backend.content.user.index', compact('user'));
    }

    public function tambah()
    {
        return view('backend.content.user.tambah');
    }

    public function prosesTambah(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt('12345678');

        try {
            $user->save();
            return redirect(route('user.index'))->with('pesan', ['success', 'User berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect(route('user.index'))->with('pesan', ['danger', 'User gagal ditambahkan']);
        }
    }

    public function ubah($id_user)
    {
        $user = User::findOrFail($id_user);
        return view('backend.content.user.ubah', compact('user'));
    }

    public function prosesUbah(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
        ]);

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;

        try {
            $user->save();
            return redirect(route('user.index'))->with('pesan', ['success', 'User berhasil diubah']);
        } catch (\Exception $e) {
            return redirect(route('user.index'))->with('pesan', ['danger', 'User gagal di ubah']);
        }
    }

    public function hapus($id_kategori)
    {
        $user = User::findOrFail($id_kategori);

        try {
            $user->delete();
            return redirect(route('user.index'))->with('pesan', ['success', 'User berhasil di hapus']);
        } catch (\Exception $e) {
            return redirect(route('user.index'))->with('pesan', ['danger', 'User gagal dihapus']);
        }
    }
}
