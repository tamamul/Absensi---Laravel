@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tambah Jadwal Satpam</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Jadwal Satpam</div>
                    </div>
                    <div class="card-body">

                        {{-- Filter Form --}}
                        <form action="{{ route('jadwalsatpam.create') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="upt_id">UPT</label>
                                    <select name="upt_id" id="upt_id" class="form-control" required>
                                        <option value="">Pilih UPT</option>
                                        @foreach ($upts as $upt)
                                            <option value="{{ $upt->id }}"
                                                {{ request('upt_id') == $upt->id ? 'selected' : '' }}>{{ $upt->nama_upt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="ultg_id">ULTG</label>
                                    <select name="ultg_id" id="ultg_id" class="form-control" required>
                                        <option value="">Pilih ULTG</option>
                                        @foreach ($ultgs as $ultg)
                                            @if ($ultg->upt_id == request('upt_id'))
                                                <option value="{{ $ultg->id }}"
                                                    {{ request('ultg_id') == $ultg->id ? 'selected' : '' }}>
                                                    {{ $ultg->nama_ultg }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="lokasikerja_id">Lokasi Kerja</label>
                                    <select name="lokasikerja_id" id="lokasikerja_id" class="form-control" required>
                                        <option value="">Pilih Lokasi</option>
                                        @foreach ($lokasikerjas as $lokasi)
                                            @if ($lokasi->ultg_id == request('ultg_id'))
                                                <option value="{{ $lokasi->id }}"
                                                    {{ request('lokasikerja_id') == $lokasi->id ? 'selected' : '' }}>
                                                    {{ $lokasi->nama_lokasikerja }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="satpam_id">Nama Satpam</label>
                                    <select name="satpam_id" id="satpam_id" class="form-control" required>
                                        <option value="">Pilih Satpam</option>
                                        @foreach ($satpamList as $s)
                                            <option value="{{ $s->id }}"
                                                {{ request('satpam_id') == $s->id ? 'selected' : '' }}>{{ $s->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <label for="bulan">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-control" required>
                                        @for ($i = 1; $i <= 12; $i++)
                                            @php $dt = DateTime::createFromFormat('!m', $i); @endphp
                                            <option value="{{ $i }}"
                                                {{ request('bulan') == $i ? 'selected' : '' }}>
                                                {{ $dt ? $dt->format('F') : $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-1 mt-2">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" name="tahun" id="tahun" class="form-control"
                                        value="{{ request('tahun', date('Y')) }}" required>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <button type="submit" class="btn btn-primary">Tampilkan Jadwal</button>
                                </div>
                            </div>
                        </form>

                        {{-- Jadwal Form --}}
                        @if ($selectedSatpam && $selectedBulan && $selectedTahun)
                            <form action="{{ route('jadwalsatpam.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="bulan" value="{{ $selectedBulan }}">
                                <input type="hidden" name="tahun" value="{{ $selectedTahun }}">
                                <input type="hidden" name="lokasikerja_id" value="{{ request('lokasikerja_id') }}">
                                <input type="hidden" name="satpam_id" value="{{ $selectedSatpam }}">

                                <table class="table table-bordered table-calendar">
                                    <thead>
                                        <tr>
                                            <th colspan="8" class="text-center">
                                                Jadwal Bulan
                                                {{ DateTime::createFromFormat('!m', $selectedBulan)->format('F') }}
                                                {{ $selectedTahun }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Hari</th>
                                            @php
                                                $days = [
                                                    'Minggu',
                                                    'Senin',
                                                    'Selasa',
                                                    'Rabu',
                                                    'Kamis',
                                                    'Jumat',
                                                    'Sabtu',
                                                ];
                                            @endphp
                                            @foreach ($days as $hari)
                                                <th>{{ $hari }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $bulan = intval($selectedBulan);
                                            $tahun = intval($selectedTahun);
                                            $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                            $calendar = [];
                                            $day = 1;
                                            $firstDayOfWeek = date('w', strtotime("$tahun-$bulan-01")); // 0 = Minggu
                                            $totalWeeks = ceil(($jumlahHari + $firstDayOfWeek) / 7);
                                            for ($week = 0; $week < $totalWeeks; $week++) {
                                                for ($d = 0; $d < 7; $d++) {
                                                    $calendar[$week][$d] = null;
                                                }
                                            }
                                            for (
                                                $i = 0, $w = 0, $d = $firstDayOfWeek;
                                                $day <= $jumlahHari;
                                                $i++, $d++
                                            ) {
                                                if ($d == 7) {
                                                    $w++;
                                                    $d = 0;
                                                }
                                                $calendar[$w][$d] = $day;
                                                $day++;
                                            }
                                        @endphp
                                        @for ($w = 0; $w < count($calendar); $w++)
                                            <tr>
                                                <td>Minggu {{ $w + 1 }}</td>
                                                @for ($d = 0; $d < 7; $d++)
                                                    @php $tgl = $calendar[$w][$d]; @endphp
                                                    <td style="padding:2px;">
                                                        @if ($tgl)
                                                            <strong>{{ $tgl }}</strong>
                                                            @php
                                                                $fullDate = sprintf(
                                                                    '%04d-%02d-%02d',
                                                                    $tahun,
                                                                    $bulan,
                                                                    $tgl,
                                                                );
                                                                $shift = $jadwalData[$fullDate] ?? '';
                                                            @endphp
                                                            <select name="jadwal[{{ $tgl }}]"
                                                                class="form-control form-control-sm mt-1">
                                                                <option value="">-</option>
                                                                <option value="P"
                                                                    {{ $shift == 'P' ? 'selected' : '' }}>P</option>
                                                                <option value="S"
                                                                    {{ $shift == 'S' ? 'selected' : '' }}>S</option>
                                                                <option value="M"
                                                                    {{ $shift == 'M' ? 'selected' : '' }}>M</option>
                                                                <option value="L"
                                                                    {{ $shift == 'L' ? 'selected' : '' }}>L</option>
                                                            </select>
                                                        @endif
                                                    </td>
                                                @endfor
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-success">Simpan Jadwal</button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#upt_id').on('change', function() {
            var uptID = $(this).val();
            $('#ultg_id').html('<option value="">Pilih ULTG</option>');
            $('#lokasikerja_id').html('<option value="">Pilih Lokasi</option>');
            $('#satpam_id').html('<option value="">Pilih Satpam</option>');
            if (uptID) {
                $.get('/get-ultg/' + uptID, function(data) {
                    $.each(data, function(id, nama) {
                        $('#ultg_id').append('<option value="' + id + '">' + nama + '</option>');
                    });
                });
            }
        });

        $('#ultg_id').on('change', function() {
            var ultgID = $(this).val();
            $('#lokasikerja_id').html('<option value="">Pilih Lokasi</option>');
            $('#satpam_id').html('<option value="">Pilih Satpam</option>');
            if (ultgID) {
                $.get('/get-lokasi/' + ultgID, function(data) {
                    $.each(data, function(id, nama) {
                        $('#lokasikerja_id').append('<option value="' + id + '">' + nama +
                            '</option>');
                    });
                });
            }
        });

        $('#lokasikerja_id').on('change', function() {
            var lokasiID = $(this).val();
            $('#satpam_id').html('<option value="">Pilih Satpam</option>');
            if (lokasiID) {
                $.get('/get-satpam/' + lokasiID, function(data) {
                    $.each(data, function(id, nama) {
                        $('#satpam_id').append('<option value="' + id + '">' + nama + '</option>');
                    });
                });
            }
        });
    </script>
    <style>
        .table-calendar td,
        .table-calendar th {
            text-align: center;
            vertical-align: middle;
            padding: 4px !important;
            font-size: 12px;
        }

        .table-calendar select {
            width: 48px;
            margin: 0 auto;
            font-size: 11px;
        }
    </style>
@endsection
