@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2> Kelompok Usaha Perhutanan Sosial (KUPS)</h2>
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
                                    <th>Kelompok Usaha Perhutanan Sosial (KUPS)</th>
                                    <th>Kategori</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Kups as $data)
                                    <tr>
                                        <td>{{ ($Kups->currentPage() - 1) * $Kups->perPage() + $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->kth->kth ?? '-' }}</td>
                                        <td class="text-center">{{ $data->kups }}</td>
                                        <td class="text-center">{{ $data->kategori }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-footer">
                        <div class="summary">
                            Showing {{ $Kups->firstItem() }} to {{ $Kups->lastItem() }} of {{ $Kups->total() }} results
                        </div>
                        <div class="pagination-sm">
                            {{-- Panggil view pagination kustom kita --}}
                            {{ $Kups->onEachSide(1)->links('vendor.pagination.buttons-only') }}
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
