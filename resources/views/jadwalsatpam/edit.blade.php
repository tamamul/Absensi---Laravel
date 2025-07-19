@extends('layouts.master')
@section('title', 'Edit Jadwal Satpam')
@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Edit Jadwal Satpam</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Edit Jadwal Satpam</div>
                    </div>
                    <div class="card-body">

                        {{-- Filter Form --}}
                        <form action="{{ route('jadwalsatpam.edit') }}" method="GET" class="mb-4">
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
                                <div class="col-md-2">
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
                                <div class="col-md-1">
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
                        @if (request('lokasikerja_id') && request('bulan') && request('tahun'))
                            <form action="{{ route('jadwalsatpam.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                                <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                                <input type="hidden" name="lokasikerja_id" value="{{ request('lokasikerja_id') }}">

                                <div class="mb-3">
                                    <h5>Lokasi: {{ $selectedLokasikerja->nama_lokasikerja ?? '' }}</h5>
                                    <h6>Bulan: {{ DateTime::createFromFormat('!m', request('bulan'))->format('F') }}
                                        {{ request('tahun') }}</h6>
                                </div>

                                <table class="table table-bordered table-calendar">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Hari</th>
                                            <th>Shift P</th>
                                            <th>Shift S</th>
                                            <th>Shift M</th>
                                            <th>Shift L</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $bulan = intval(request('bulan'));
                                            $tahun = intval(request('tahun'));
                                            $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                            $namaHari = [
                                                'Minggu',
                                                'Senin',
                                                'Selasa',
                                                'Rabu',
                                                'Kamis',
                                                'Jumat',
                                                'Sabtu',
                                            ];
                                        @endphp

                                        @for ($tanggal = 1; $tanggal <= $jumlahHari; $tanggal++)
                                            @php
                                                $fullDate = sprintf('%04d-%02d-%02d', $tahun, $bulan, $tanggal);
                                                $dayOfWeek = date('w', strtotime($fullDate));
                                                $namaHariIni = $namaHari[$dayOfWeek];
                                            @endphp
                                            <tr>
                                                <td class="text-center"><strong>{{ $tanggal }}</strong></td>
                                                <td class="text-center">{{ $namaHariIni }}</td>

                                                {{-- Shift P --}}
                                                <td>
                                                    <select name="jadwal[{{ $tanggal }}][P][]" class="form-control form-control-sm" multiple>
                                                        @foreach ($satpamList as $satpam)
                                                            @php
                                                                $currentShifts = $jadwalData[$fullDate]['P'] ?? [];
                                                            @endphp
                                                            <option value="{{ $satpam->id }}" {{ in_array($satpam->id, $currentShifts) ? 'selected' : '' }}>
                                                                {{ $satpam->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                {{-- Shift S --}}
                                                <td>
                                                    <select name="jadwal[{{ $tanggal }}][S][]" class="form-control form-control-sm" multiple>
                                                        @foreach ($satpamList as $satpam)
                                                            @php
                                                                $currentShifts = $jadwalData[$fullDate]['S'] ?? [];
                                                            @endphp
                                                            <option value="{{ $satpam->id }}" {{ in_array($satpam->id, $currentShifts) ? 'selected' : '' }}>
                                                                {{ $satpam->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                {{-- Shift M --}}
                                                <td>
                                                    <select name="jadwal[{{ $tanggal }}][M][]" class="form-control form-control-sm" multiple>
                                                        @foreach ($satpamList as $satpam)
                                                            @php
                                                                $currentShifts = $jadwalData[$fullDate]['M'] ?? [];
                                                            @endphp
                                                            <option value="{{ $satpam->id }}" {{ in_array($satpam->id, $currentShifts) ? 'selected' : '' }}>
                                                                {{ $satpam->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                {{-- Shift L --}}
                                                <td>
                                                    <select name="jadwal[{{ $tanggal }}][L][]" class="form-control form-control-sm" multiple>
                                                        @foreach ($satpamList as $satpam)
                                                            @php
                                                                $currentShifts = $jadwalData[$fullDate]['L'] ?? [];
                                                            @endphp
                                                            <option value="{{ $satpam->id }}" {{ in_array($satpam->id, $currentShifts) ? 'selected' : '' }}>
                                                                {{ $satpam->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-success">Update Jadwal</button>
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
            if (ultgID) {
                $.get('/get-lokasi/' + ultgID, function(data) {
                    $.each(data, function(id, nama) {
                        $('#lokasikerja_id').append('<option value="' + id + '">' + nama +
                            '</option>');
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
            padding: 8px !important;
            font-size: 12px;
        }

        .table-calendar select {
            width: 100%;
            font-size: 11px;
        }

        .table-calendar select[multiple] {
            height: 80px;
            min-height: 60px;
        }

        .table-calendar th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .table-calendar tr:nth-child(even) {
            background-color: #f8f9fa;
        }
    </style>
@endsection
