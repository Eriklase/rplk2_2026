<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Page;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::whereNull('parent_menu')
            ->with(['submenu' => fn($q) => $q->orderBy('urutan_menu', 'asc')])
            ->orderBy('urutan_menu', 'asc')
            ->get();

        return view('backend.content.menu.index', compact('menu'));
    }

    public function order($idMenu, $idSwap)
    {
        $menu = Menu::findOrFail($idMenu);
        $menuOrder = $menu->urutan_menu;

        $swap = Menu::findOrFail($idSwap);
        $swapOrder = $swap->urutan_menu;

        $menu->urutan_menu = $swapOrder;
        $swap->urutan_menu = $menuOrder;

        try {
            $menu->save();
            $swap->save();
            return redirect()
                ->route('menu.index')
                ->with('pesan', ['success', 'Menu order updated successfully.']);
        } catch (\Exception $e) {
            return redirect()
                ->route('menu.index')
                ->with('pesan', ['danger', 'Failed to update menu order.']);
        }
    }

    public function tambah()
    {
        $page = Page::where('status_page', '=', 1)->get();
        $parent = Menu::whereNull('parent_menu')->where('status_menu', '=', 1)->get();
        return view('backend.content.menu.tambah', compact('page', 'parent'));
    }

    public function prosesTambah(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'jenis_menu' => 'required',
            'target_menu' => 'required',
        ]);

        $parent_menu = $request->parent_menu;
        if ($parent_menu == null) {
            $urut = $this->generateUrutanMenu();
        } else {
            $urut = $this->generateUrutanMenu($parent_menu);
        }

        // try {
        //     $menu->save();
        //     return redirect()->route('menu.index')->with('success', ['Menu added successfully.']);
        // } catch (\Exception $e) {
        //     return redirect()->route('menu.index')->with('danger', ['Failed to add menu.']);
        // }
        $url_menu = '';
        if ($request->jenis_menu == 'url') {
            $url_menu = $request->link_url;
        } else {
            $url_menu = $request->link_page;
        }
        $menu = new Menu();
        $menu->nama_menu = $request->nama_menu;
        $menu->jenis_menu = $request->jenis_menu;
        $menu->url_menu = $url_menu;
        $menu->target_menu = $request->target_menu;
        $menu->urutan_menu = $urut;
        $menu->parent_menu = $request->parent_menu;

        try {
            $menu->save();
            return redirect()
                ->route('menu.index')
                ->with('pesan', ['success', 'Berhasil menambahkan menu.']);
        } catch (\Exception $e) {
            return redirect()
                ->route('menu.index')
                ->with('pesan', ['danger', 'Gagal menambahkan menu.']);
        }
    }

    public function ubah($id)
    {
        $menu = Menu::findOrFail($id);

        $page = Page::where('status_page', 1)
            ->orderBy('judul_page', 'asc')
            ->get();

        $parentMenu = Menu::whereNull('parent_menu')
            ->where('id_menu', '!=', $menu->id_menu)
            ->orderBy('urutan_menu', 'asc')
            ->get();

        return view('backend.content.menu.ubah', compact('menu', 'parentMenu', 'page'));
    }

    public function prosesUbah(Request $request)
    {
        $validated = $request->validate([
            'id_menu' => 'required|integer|exists:menu,id_menu',
            'nama_menu' => 'required|string|max:255',
            'jenis_menu' => 'required|in:url,page',
            'target_menu' => 'required|in:_self,_blank',

            // link sesuai jenis menu
            'link_url' => 'nullable|required_if:jenis_menu,url|string|max:255',
            'link_page' => 'nullable|required_if:jenis_menu,page|integer|exists:page,id_page',

            'urutan_menu' => 'required|integer',
            'parent_menu' => 'nullable|integer|exists:menu,id_menu',
            'status_menu' => 'required|in:0,1',
        ]);

        $url_menu = $validated['jenis_menu'] === 'url'
            ? $validated['link_url']
            : (string) $validated['link_page'];

        $menu = Menu::findOrFail($validated['id_menu']);
        $menu->nama_menu = $validated['nama_menu'];
        $menu->jenis_menu = $validated['jenis_menu'];
        $menu->url_menu = $url_menu;
        $menu->target_menu = $validated['target_menu'];
        $menu->urutan_menu = $validated['urutan_menu'];
        $menu->parent_menu = $validated['parent_menu'] ?? null;
        $menu->status_menu = (int) $validated['status_menu'];

        try {
            $menu->save();

            return redirect(route('menu.index'))->with('pesan', ['success', 'Menu berhasil diubah']);
        } catch (\Exception $e) {
            return redirect(route('menu.index'))->with('pesan', ['danger', 'Menu gagal diubah']);
        }
    }

    public function hapus($id)
    {
        $menu = Menu::findOrFail($id);
        try {
            $menu->delete();
            return redirect()
                ->route('menu.index')
                ->with('pesan', ['success', 'Berhasil menghapus menu.']);
        } catch (\Exception $e) {
            return redirect()
                ->route('menu.index')
                ->with('pesan', ['danger', 'Gagal menghapus menu.']);
        }
    }

    private function generateUrutanMenu($parent = null)
    {
        if ($parent == null) {
            #menu
            $noUrutMenu = null;
            $urut = Menu::select('urutan_menu')->whereNull('parent_menu')->orderBy('urutan_menu', 'desc')->first();
            if ($urut == null) {
                $noUrut = 1;
            } else {
                $noUrutMenu = $urut->urutan_menu + 1;
            }
            return $noUrutMenu;
        } else {
            #submenu
            $noUrutSubMenu = null;
            $urutSubMenu = Menu::select('urutan_menu')->whereNull('parent_menu')->where('parent_menu', '=', $parent)->orderBy('urutan_menu', 'desc')->first();
            if ($urutSubMenu == null) {
                $noUrutSubMenu = 1;
            } else {
                $noUrutSubMenu = $urutSubMenu->urutan_menu + 1;
            }
            return $noUrutSubMenu;
        }
    }
}
