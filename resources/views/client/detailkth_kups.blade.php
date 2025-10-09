@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>IAD Kelompok Tani Hutan</h2>
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
                                    <th>Kecamatan</th>
                                    <th>Desa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kthKups as $data)
                                    <tr>
                                        <td>{{ ($kthKups->currentPage() - 1) * $kthKups->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $data->kth }}</td>
                                        <td>{{ $data->kecamatan }}</td>
                                        <td>{{ $data->desa }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-footer">
                        <div class="summary">
                            Showing {{ $kthKups->firstItem() }} to {{ $kthKups->lastItem() }} of {{ $kthKups->total() }}
                            results
                        </div>
                        <div class="pagination-sm">
                            {{-- Panggil view pagination kustom kita --}}
                            {{ $kthKups->onEachSide(1)->links('vendor.pagination.buttons-only') }}
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
