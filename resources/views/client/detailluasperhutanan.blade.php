@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>IAD Luas Perhutanan Sosial</h2>
        </div>

        <section class="detail-form-section">
            <div class="container">
                <div class="card-table-container">
                    <div class="table-wrapper">
                        <table class="detail-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>KELOMPOK TANI HUTAN (KTH)</th>
                                    <th>LUAS AREAL KELOLA SESUAI SK (Ha)</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kth as $data)
                                    <tr>
                                        <td>{{ ($kth->currentPage() - 1) * $kth->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $data->kth }}</td>
                                        <td>{{ $data->luas }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="table-footer">
                        <div class="summary">
                            Showing {{ $kth->firstItem() }} to {{ $kth->lastItem() }} of {{ $kth->total() }} results
                        </div>
                        <div class="pagination-sm">
                            {{-- Panggil view pagination kustom kita --}}
                            {{ $kth->onEachSide(1)->links('vendor.pagination.buttons-only') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn-footer-back">
                ← Kembali
            </a>
        </div>
    </section>
@endsection
