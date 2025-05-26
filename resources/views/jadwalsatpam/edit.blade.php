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
                    <div class="card-title">Jadwal Satpam: <b>{{ $satpam->nama }}</b></div>
                </div>
                <div class="card-body">

                    {{-- Filter Bulan & Tahun --}}
                    <form action="{{ route('jadwalsatpam.edit', $satpam->id) }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-control" required>
                                    @for ($i = 1; $i <= 12; $i++)
                                        @php $dt = DateTime::createFromFormat('!m', $i); @endphp
                                        <option value="{{ $i }}"
                                            {{ $selectedBulan == $i ? 'selected' : '' }}>
                                            {{ $dt ? $dt->format('F') : $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="tahun">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="form-control"
                                    value="{{ $selectedTahun }}" required>
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button type="submit" class="btn btn-primary">Tampilkan Jadwal</button>
                            </div>
                        </div>
                    </form>

                    {{-- Jadwal Kalender --}}
                    <form action="{{ route('jadwalsatpam.update', $satpam->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="bulan" value="{{ $selectedBulan }}">
                        <input type="hidden" name="tahun" value="{{ $selectedTahun }}">
                        <input type="hidden" name="lokasikerja_id" value="{{ $satpam->lokasikerja_id }}">
                        <input type="hidden" name="satpam_id" value="{{ $satpam->id }}">

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
                                        $days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
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
                                    for ($i = 0, $w = 0, $d = $firstDayOfWeek; $day <= $jumlahHari; $i++, $d++) {
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
                                                        $fullDate = sprintf('%04d-%02d-%02d', $tahun, $bulan, $tgl);
                                                        $shift = $jadwalData[$fullDate] ?? '';
                                                    @endphp
                                                    <select name="jadwal[{{ $tgl }}]" class="form-control form-control-sm mt-1">
                                                        <option value="">-</option>
                                                        <option value="P" {{ $shift == 'P' ? 'selected' : '' }}>P</option>
                                                        <option value="S" {{ $shift == 'S' ? 'selected' : '' }}>S</option>
                                                        <option value="M" {{ $shift == 'M' ? 'selected' : '' }}>M</option>
                                                        <option value="L" {{ $shift == 'L' ? 'selected' : '' }}>L</option>
                                                    </select>
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

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