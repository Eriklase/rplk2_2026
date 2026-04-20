@extends('frontend/layout/main')
@section('content')
            <section class="py-5">           
                <div class="container px-5">
                    <h2 class="fw-bolder fs-5 mb-4">Semua Berita</h2>
                    <div class="row gx-5">
                        
                        @foreach ($berita as $row)
                            <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-0">
                                <img class="card-img-top" src="{{ asset('storage/berita/' . $row->gambar_berita) }}" width="400" height="600" alt="{{ $row->judul_berita }}" />
                                <div class="card-body p-4">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">{{ $row->kategori->nama_kategori }}</div>
                                    <a class="text-decoration-none link-dark stretched-link" href="{{ route('home.detailBerita', $row->id_berita) }}">
                                        <div class="h5 card-title mb-3">
                                            {{ $row->judul_berita }}
                                        </div>
                                    </a>
                                    <p class="card-text mb-0">{!! Substr($row->isi_berita, 8, 200)!!}</p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="small">
                                                <div class="fw-bold">Admin</div>
                                                <div class="text-muted">{{ $row->created_at?->format('F j, Y') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                      
                    </div>
                    {{-- <div class="text-end mb-5 mb-xl-0">
                        <a class="text-decoration-none" href="{{ route('home.semuaBerita') }}">
                            More stories
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div> --}}
                    
                </div>
                <a href="{{ route('home.index') }}" class="text-decoration-none">&larr; Kembali</a>
            </section>
@endsection            