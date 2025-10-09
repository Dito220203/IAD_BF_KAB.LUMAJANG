@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>RENCANA KEGIATAN {{ $subprogram->subprogram }}</h2>
        </div>

        <section class="detail-form-section" id="rencana">
            <div class="container">
                <div class="card-table-container">
                    <div class="table-header">
                        <form action="{{ route('client.rencanakegiatan', ['id' => $subprogram->id]) }}" method="GET"
                            id="yearFilterForm" class="filter-form">
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
                        <table class="detail-table" style="min-width: 1500px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sub Program</th>
                                    <th>Rencana Aksi/Aktivitas</th>
                                    <th>Sub Kegiatan</th>
                                    <th>Kegiatan</th>
                                    <th>Program</th>
                                    <th>Lokasi</th>
                                    <th>Volume</th>
                                    <th>Satuan</th>
                                    <th>Sumber Dana</th>
                                    <th>Tahun Pelaksanaan</th>
                                    <th>Perangkat Daerah</th>
                                    <th>keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rencanaKegiatan as $index => $rk)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $rk->subprogram->subprogram ?? '-' }}</td>
                                        <td style="text-align: left;" class="kolom-lebar">{{ $rk->rencana_aksi }}</td>
                                        <td style="text-align: left;" class="kolom-lebar">{{ $rk->sub_kegiatan }}</td>
                                        <td style="text-align: left;" class="kolom-lebar">{{ $rk->kegiatan }}</td>
                                        <td style="text-align: left;" class="kolom-lebar">{{ $rk->nama_program }}</td>
                                        <td>{{ $rk->lokasi }}</td>
                                        <td>{{ $rk->volume }}</td>
                                        <td>{{ $rk->satuan }}</td>
                                        <td>{{ $rk->sumberdana }}</td>
                                        <td>{{ $rk->tahun }}</td>
                                        <td>{{ $rk->opd->nama ?? '-' }}</td>
                                        <td>{{ $rk->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="20">Belum ada data rencana kegiatan untuk
                                            subprogram
                                            ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="table-footer">
                        {{-- Taruh info pagination di sini --}}
                        <div class="summary">
                            Showing {{ $rencanaKegiatan->firstItem() ?? 0 }} to {{ $rencanaKegiatan->lastItem() ?? 0 }} of
                            {{ $rencanaKegiatan->total() }} results
                        </div>
                        <div class="pagination-sm">
                            {{-- Panggil view pagination kustom kita --}}
                            {{ $rencanaKegiatan->appends(['tahun' => $selectedYear])->onEachSide(1)->links('vendor.pagination.buttons-only') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </section>
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
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
                        this.classList.toggle("select-arrow-active");
                    });
                }
                document.addEventListener("click", closeAllSelect);
            });
        </script>
    @endpush
@endsection
