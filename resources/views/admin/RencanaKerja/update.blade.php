@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Rencana Kerja</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item">Rencana Kerja</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body mt-3">
                            <form action="{{ route('rencana.update', $rencana->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- Sub Program --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Sub Program</label>
                                    <div class="col-sm-10">
                                        <select name="e_subprogram" class="form-select" required>
                                            <option value="">-- Pilih Subprogram --</option>
                                            @foreach ($subprogram as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $rencana->id_subprogram == $item->id ? 'selected' : '' }}>
                                                    {{ $item->subprogram }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Judul --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="e_judul" class="form-control"
                                            value="{{ $rencana->judul }}" required>
                                    </div>
                                </div>

                                {{-- Lokasi --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Lokasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="e_lokasi" class="form-control"
                                            value="{{ $rencana->lokasi }}" required>
                                    </div>
                                </div>

                                {{-- Tahun --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tahun</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="e_tanggal" class="form-control"
                                            value="{{ $rencana->tanggal }}" required>
                                    </div>
                                </div>

                                {{-- Anggaran --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Anggaran</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="e_anggaran" class="form-control"
                                            value="{{ $rencana->anggaran }}" required>
                                    </div>
                                </div>

                                {{-- OPD (hanya untuk Super Admin) --}}
                                @if (Auth::guard('pengguna')->user()->level === 'Super Admin')
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">OPD</label>
                                        <div class="col-sm-10">
                                            <select name="e_opd" class="form-select" required>
                                                <option value="">-- Pilih OPD --</option>
                                                @foreach ($opd as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $rencana->id_opd == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif


                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea name="e_keterangan" class="form-control" rows="4" required>{{ $rencana->keterangan }}</textarea>
                                    </div>
                                </div>


                                {{-- Tombol --}}
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="{{ route('rencanakerja') }}" class="btn btn-warning">Kembali</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
