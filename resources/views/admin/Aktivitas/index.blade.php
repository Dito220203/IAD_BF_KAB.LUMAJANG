@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Log Aktivitas Admin Website IAD</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                    <li class="breadcrumb-item active">Log Aktivitas</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card ">
                        <div class="card-body">
                            <!-- Header control: Tambah, Search, Tampilkan Data -->
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">

                                <div class="d-flex align-items-center ">
                                    <label for="entries" class="form-label mb-0">Tampilkan</label>
                                    <select class="form-select form-select-sm w-auto entriesSelect" data-target="TableLog">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span>data</span>
                                </div>

                                <div class="input-group w-auto">
                                   <input type="text" class="form-control searchInput" data-target="TableLog"
                                        placeholder="Cari Data...">
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table .table-active text-center" id="TableLog">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Ip</th>
                                            <th>Waktu</th>
                                            <th>Aktivitas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tbody>
                                        @foreach ($log as $data)
                                            <tr>
                                                <td>{{ $log->firstItem() + $loop->index }}</td>
                                                 <td>{{ $data->pengguna->username ?? '-' }}</td>
                                                <td>{{ $data->ip }}</td>
                                                <td>{{ $data->waktu }}</td>
                                                <td>{{ $data->aktivitas }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $log->links('vendor.pagination.bootstrap-5') }}
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
        </section>
    </main>
@endsection
