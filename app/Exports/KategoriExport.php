<?php

namespace App\Exports;

use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class KategoriExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Kategori::select('id_kategori', 'nama_kategori', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nama Kategori', 'Tanggal'];
    }

    public function map($kategori): array
    {
        return [
            $kategori->id_kategori,
            strtoupper($kategori->nama_kategori), // custom huruf besar
            $kategori->created_at ? Carbon::parse($kategori->created_at)->format('d-m-Y') : '-',
        ];
    }
}
