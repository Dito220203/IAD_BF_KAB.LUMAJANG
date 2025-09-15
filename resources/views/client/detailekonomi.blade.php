@extends('componentsclient.layout')
@section('content')
    <section class="section_page">

        <div class="global-title" data-aos="fade-up">

            <h2>IAD Nilai Ekonomi</h2>

        </div>

        <section class="detail-form-section">
            <div class="container">
                <div class="card-table-container">
                    <div class="table-header">
                        <form action="{{ route('client.detailekonomi') }}" method="GET" id="yearFilterForm"
                            class="filter-form">
                            <div class="custom-select-wrapper">
                                <div class="year-filter">
                                    <label for="tahun">Pilih Tahun:</label>

                                    <select name="tahun" id="tahun">

                                        <option value="semua" {{ !$selectedYear ? 'selected' : '' }}>Semua Tahun</option>

                                        @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                {{ $year == $selectedYear ? 'selected' : '' }}>

                                                {{ $year }}

                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        </form>

                    </div>

                    <div class="table-wrapper">

                        <table class="detail-table">

                            <thead>

                                <tr>

                                    <th>No</th>

                                    <th>KELOMPOK TANI HUTAN (KTH)</th>

                                    <th>JENIS KOMODITAS KUPS</th>

                                    <th>KATEGORI</th>

                                    <th>TAHUN</th>

                                    <th>JUMLAH PENDAPATAN PERTAHUN</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse ($kups as $data)
                                    <tr>

                                        <td>
                                            {{ $loop->iteration + ($kups->currentPage() - 1) * $kups->perPage() }}</td>

                                        <td>{{ $data->kth->kth ?? '-' }}</td>

                                        <td>{{ $data->kups }}</td>

                                        <td>{{ $data->kategori }}</td>

                                        <td>{{ $data->tahun }}</td>

                                        <td>Rp
                                            {{ number_format($data->pendapatan, 0, ',', '.') }}</td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="6" style="text-align: center;">Tidak ada data untuk ditampilkan.

                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>
                    @if ($kups->hasPages())
                        <div class="pagination-summary-wrapper">

                            <div class="summary">

                                Showing {{ $kups->firstItem() }} to
                                {{ $kups->lastItem() }} of {{ $kups->total() }}

                                results

                            </div>

                            <div class="pagination-sm">


                                {{ $kups->appends(['tahun' => $selectedYear])->onEachSide(1)->links('vendor.pagination.buttons-only') }}

                            </div>

                        </div>
                    @endif

                </div>
            </div>
        </section>



        <div class="text-center mt-4">

            <a href="{{ url('/') }}" class="btn-footer-back">

                ← Kembali

            </a>

        </div>

    </section>



    {{-- JS langsung di sini, sama kayak chart --}}


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var x, i, j, l, ll, selElmnt, a, b, c;

            x = document.getElementsByClassName("custom-select-wrapper");

            l = x.length;



            for (i = 0; i < l; i++) {

                selElmnt = x[i].getElementsByTagName("select")[0];

                if (!selElmnt) continue;



                ll = selElmnt.length;

                a = document.createElement("DIV");

                a.setAttribute("class", "select-selected");

                a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;

                x[i].appendChild(a);



                b = document.createElement("DIV");

                b.setAttribute("class", "select-items select-hide");

                for (j = 0; j < ll; j++) {

                    c = document.createElement("DIV");

                    c.innerHTML = selElmnt.options[j].innerHTML;

                    c.addEventListener("click", function(e) {

                        var s = this.parentNode.parentNode.getElementsByTagName("select")[0];

                        var h = this.parentNode.previousSibling;

                        var oldValue = s.value;

                        for (var k = 0; k < s.length; k++) {

                            if (s.options[k].innerHTML == this.innerHTML) {

                                s.selectedIndex = k;

                                h.innerHTML = this.innerHTML;



                                var y = this.parentNode.getElementsByClassName("same-as-selected");

                                for (var m = 0; m < y.length; m++) {

                                    y[m].removeAttribute("class");

                                }

                                this.setAttribute("class", "same-as-selected");



                                // submit form hanya kalau value berubah

                                if (s.value !== oldValue) {

                                    s.form.submit();

                                }

                                break;

                            }

                        }

                        h.click();

                    });

                    b.appendChild(c);

                }

                x[i].appendChild(b);



                a.addEventListener("click", function(e) {

                    e.stopPropagation();

                    closeAllSelect(this);

                    this.nextSibling.classList.toggle("select-hide");

                });

            }



            function closeAllSelect(elmnt) {

                var x = document.getElementsByClassName("select-items");

                var y = document.getElementsByClassName("select-selected");

                for (var i = 0; i < y.length; i++) {

                    if (elmnt != y[i]) {

                        y[i].classList.remove("select-arrow-active");

                    }

                }

                for (var i = 0; i < x.length; i++) {

                    if (elmnt != y[i]) {

                        x[i].classList.add("select-hide");

                    }

                }

            }

            document.addEventListener("click", closeAllSelect);

        });
    </script>
@endsection
