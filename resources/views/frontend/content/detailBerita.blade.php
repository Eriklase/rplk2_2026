@extends('frontend.layout.main')
@section('content')
    <section class="py-5">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-12">
                    <article>
                        <header class="mb-4">
                            <h1 class="fw-bolder mb-1">{{ $berita->judul_berita }}</h1>
                            <div class="text-muted fst-italic mb-2">
                                {{ $berita->created_at?->format('F j, Y') }}
                                &middot; {{ $berita->kategori?->nama_kategori }}
                                &middot; {{ $berita->total_views }} views
                            </div>
                        </header>

                        <figure class="mb-4">
                            <img class="img-fluid rounded" src="{{ asset('storage/berita/' . $berita->gambar_berita) }}"
                                onerror="this.onerror=null;this.src='https://dummyimage.com/900x400/ced4da/6c757d.jpg';"
                                alt="{{ $berita->judul_berita }}" />
                        </figure>

                        <section class="mb-5">
                            <div class="fs-5">{!! $berita->isi_berita !!}</div>
                        </section>

                        <a href="{{ route('home.index') }}" class="text-decoration-none">&larr; Kembali</a>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
