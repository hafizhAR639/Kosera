@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>{{ $title }}</h1>
    <p class="text-muted">Tambahkan portfolio proyek baru Anda</p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('mitra.portfolio.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Proyek <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                            id="judul" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Instalasi AC Split 5 Unit">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                            id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan detail proyek Anda..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori') is-invalid @enderror" 
                                id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Instalasi AC" @selected(old('kategori') === 'Instalasi AC')>Instalasi AC</option>
                                <option value="Instalasi Listrik" @selected(old('kategori') === 'Instalasi Listrik')>Instalasi Listrik</option>
                                <option value="Service AC" @selected(old('kategori') === 'Service AC')>Service AC</option>
                                <option value="Elektronik" @selected(old('kategori') === 'Elektronik')>Perbaikan Elektronik</option>
                                <option value="Keamanan" @selected(old('kategori') === 'Keamanan')>Instalasi Keamanan (CCTV)</option>
                                <option value="Lainnya" @selected(old('kategori') === 'Lainnya')>Lainnya</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="client_name" class="form-label">Nama Klien <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                                id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_project" class="form-label">Tanggal Proyek</label>
                            <input type="date" class="form-control @error('tanggal_project') is-invalid @enderror" 
                                id="tanggal_project" name="tanggal_project" value="{{ old('tanggal_project') }}">
                            @error('tanggal_project')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="lokasi" class="form-label">Lokasi Proyek</label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                id="lokasi" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Surabaya, Jawa Timur">
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nilai_project" class="form-label">Nilai Proyek (Rp)</label>
                            <input type="number" class="form-control @error('nilai_project') is-invalid @enderror" 
                                id="nilai_project" name="nilai_project" value="{{ old('nilai_project') }}" 
                                placeholder="0" min="0" step="1000">
                            @error('nilai_project')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="durasi_hari" class="form-label">Durasi (Hari)</label>
                            <input type="number" class="form-control @error('durasi_hari') is-invalid @enderror" 
                                id="durasi_hari" name="durasi_hari" value="{{ old('durasi_hari') }}" 
                                placeholder="0" min="0">
                            @error('durasi_hari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Portfolio
                        </button>
                        <a href="{{ route('mitra.portfolio.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="fas fa-lightbulb"></i> Tips
                </h5>
                <ul class="list-unstyled small text-muted">
                    <li class="mb-2">
                        <strong>Judul yang menarik</strong> membantu klien lebih mudah menemukan proyek Anda
                    </li>
                    <li class="mb-2">
                        <strong>Deskripsi detail</strong> tentang scope pekerjaan dan hasil akhir
                    </li>
                    <li class="mb-2">
                        <strong>Fotografi profesional</strong> meningkatkan kepercayaan klien
                    </li>
                    <li class="mb-2">
                        <strong>Jelaskan metodologi</strong> dan keahlian yang Anda gunakan
                    </li>
                    <li class="mb-2">
                        <strong>Cantumkan sertifikat</strong> yang relevan dengan proyek
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
