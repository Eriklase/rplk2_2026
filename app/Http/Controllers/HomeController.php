<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Berita;

class HomeController extends Controller
{
    public function index()
    {
         #halaman awal
        $menu = $this->getMenu();
        $berita = Berita::with('kategori')->latest()->take(3)->get();
        $mostView = Berita::with('kategori')->latest()->take(5)->get();
        return view('frontend.content.home', compact('menu', 'berita', 'mostView'));
    }

    public function detailBerita($id)
    {
        #halaman detail berita
        $menu = $this->getMenu();
        $berita = Berita::findOrFail($id);
        return view('frontend.content.detailBerita', compact('menu', 'berita'));
    }

    public function detailPage($id)
    {
        #halaman detail page
         $menu = $this->getMenu();
        $page = Berita::findOrFail($id);
        return view('frontend.content.detailPage', compact('menu', 'page'));
    }

    public function semuaBerita()
    {
        #halaman semua berita
        $menu = $this->getMenu();
        $berita = Berita::with('kategori')->latest()->get();

        #update total view
        // $berita->total_view = $berita->total_view + 1;
        // $berita->save();
        return view('frontend.content.semuaBerita', compact('menu', 'berita'));
    }

    private function getMenu(){
        $menu = Menu::whereNull('parent_menu')
        ->with(['submenu'=> fn($q) => $q->where('status_menu','=',1)->orderBy('urutan_menu','asc')])
        ->where('status_menu','=',1)
        ->orderBy('urutan_menu','asc')
        ->get();


        $dataMenu = [];
        foreach ($menu as $m) {
            $jenis_menu = $m->jenis_menu;
            $url_menu ="";

        }if($jenis_menu =="url"){
            $url_menu = $m->url_menu;
        }else{
            $url_menu = route('home.detailPage', $m->url_menu);
        }

        #itemMenu
        $dItemMenu =[];
        foreach ($m->submenu as $im) {
            $jenisItemMenu = $im->jenis_menu;
            $urlItemMenu ="";

            if($jenisItemMenu =="url"){
                $urlItemMenu = $im->url_menu;
            }else{
                $urlItemMenu = route('home.detailPage', $im->url_menu); 
            }

            $idItemMenu [] = [
                'sub_menu_nama' => $im->nama_menu,
                'sub_menu_target' => $im->target_menu,
                'sub_menu_url' => $urlItemMenu,
            ];
        }

        $dataMenu [] = [
            'menu' => $m->nama_menu,
            'target' => $m->target_menu,
            'url' => $url_menu,
            'item_menu' => $dItemMenu
        ];
        
        return $dataMenu;
    }
    
}