@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Form Ubah</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('kategori.prosesUbah') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" id="nama_kategori" name="nama_kategori"
                            value="{{ $kategori->nama_kategori ?? ''}}"
                            class="form-control @error('nama_kategori') is-invalid @enderror">
                        @error('nama_kategori')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>  

                    <input type="hidden" name="id_kategori" value="{{ $kategori->id_kategori }}">

                    <button type="submit" class="btn btn-primary">Ubah</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>

                </form>
            </div>
        </div>
    </div>
@endsection
