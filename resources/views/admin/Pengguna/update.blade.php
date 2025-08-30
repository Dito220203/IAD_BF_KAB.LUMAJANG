@extends('components.layout')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Pengguna</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Beranda</li>
                <li class="breadcrumb-item">Pengguna</li>
                <li class="breadcrumb-item active">Edit Pengguna</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12"> {{-- Full width --}}
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 mt-3">

                            <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Username --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="e_username" class="form-control"
                                            value="{{ old('username', $pengguna->username) }}" required>
                                    </div>
                                </div>

                                {{-- Nama --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="e_nama" class="form-control"
                                            value="{{ old('nama', $pengguna->nama) }}" required>
                                    </div>
                                </div>

                                {{-- Password opsional --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Password Baru</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="e_password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                                    </div>
                                </div>

                                {{-- Perangkat Daerah --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Perangkat Daerah</label>
                                    <div class="col-sm-10">
                                        <select name="e_id_opd" class="form-select" required>
                                            <option value="">Pilih</option>
                                            @foreach ($opd as $data)
                                                <option value="{{ $data->id }}" {{ old('id_opd', $pengguna->id_opd) == $data->id ? 'selected' : '' }}>
                                                    {{ $data->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Level --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Level</label>
                                    <div class="col-sm-10">
                                        <select name="e_level" class="form-select" required>
                                            <option value="">Pilih</option>
                                            <option value="Super Admin" {{ old('level', $pengguna->level) == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="Admin" {{ old('level', $pengguna->level) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="adminsekretariat" {{ old('level', $pengguna->level) == 'adminsekretariat' ? 'selected' : '' }}>Admin Sekretariat</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Tombol --}}
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="{{ route('pengguna') }}" class="btn btn-warning">Kembali</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
