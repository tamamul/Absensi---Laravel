@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Laporan</h4>
            <ul class="breadcrumbs">
                <li class="nav-home"><a href="/"><i class="flaticon-home"></i></a></li>
                <li class="separator"><i class="flaticon-right-arrow"></i></li>
                <li class="nav-item"><a href="#">Tables</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="container">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <strong>Select Data</strong>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="nama_upt">Nama UPT</label>
                                                <select class="form-control" id="nama_upt" name="upt_id">
                                                    <option value="">Pilih Nama UPT</option>
                                                    @foreach ($allUptNames as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('upt_id', $upt_id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->nama_upt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="nama_ultg">Nama ULTG</label>
                                                <select class="form-control" id="nama_ultg" name="ultg_id">
                                                    <option value="">Pilih Nama ULTG</option>
                                                    @foreach ($ultgs as $ultg)
                                                        <option value="{{ $ultg->id }}"
                                                            {{ old('ultg_id', $ultg_id) == $ultg->id ? 'selected' : '' }}>
                                                            {{ $ultg->nama_ultg }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="nama_lokasikerja">Nama Lokasi Kerja</label>
                                                <select class="form-control" id="nama_lokasikerja" name="lokasikerja_id">
                                                    <option value="">Pilih Nama Lokasi Kerja</option>
                                                    @foreach ($lokasikerjas as $lokasi)
                                                        <option value="{{ $lokasi->id }}"
                                                            {{ old('lokasikerja_id', $lokasikerja_id) == $lokasi->id ? 'selected' : '' }}>
                                                            {{ $lokasi->nama_lokasikerja }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="tanggal">Tahun - Bulan</label>
                                                <input type="month" class="form-control" id="tanggal" name="tanggal"
                                                    value="{{ old('tanggal', $tanggal ?? date('Y-m')) }}">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($laporan) > 0)
                            <div class="mb-3">
                                <form method="GET" action="{{ route('laporan.export') }}" target="_blank">
                                    <input type="hidden" name="upt_id" value="{{ $upt_id }}">
                                    <input type="hidden" name="ultg_id" value="{{ $ultg_id }}">
                                    <input type="hidden" name="lokasikerja_id" value="{{ $lokasikerja_id }}">
                                    <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-file-pdf"></i> Export PDF
                                    </button>
                                </form>
                            </div>
                        @endif
                        {{-- Tabel Laporan --}}
                        @if (count($laporan) > 0)
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered table-striped">
                                    <thead class="text-center">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Satpam</th>
                                            <th>Lokasi Kerja</th>
                                            <th>Total Masuk</th>
                                            <th>Terlambat</th>
                                            <th>Ijin</th>
                                            <th>Sakit</th>
                                            <th>Alpha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Group absensi by satpam
                                            $grouped = $laporan->groupBy('satpam_id');
                                        @endphp
                                        @foreach ($grouped as $satpam_id => $absensis)
                                            @php
                                                $satpam = $absensis->first()->satpam ?? null;
                                                $lokasi = $satpam->lokasikerja->nama_lokasikerja ?? '-';
                                                $total_masuk = $absensis->where('status', 'hadir')->count();
                                                $terlambat = $absensis->where('status', 'terlambat')->count();
                                                $ijin = $absensis->where('status', 'ijin')->count();
                                                $sakit = $absensis->where('status', 'sakit')->count();
                                                $alpha = $absensis->where('status', 'alpha')->count();
                                            @endphp
                                            <tr>
                                                <td>{{ $satpam_id }}</td>
                                                <td>{{ $satpam->nama ?? '-' }}</td>
                                                <td>{{ $lokasi }}</td>
                                                <td>{{ $total_masuk }}</td>
                                                <td>{{ $terlambat }}</td>
                                                <td>{{ $ijin }}</td>
                                                <td>{{ $sakit }}</td>
                                                <td>{{ $alpha }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif(request()->filled(['upt_id', 'ultg_id', 'lokasikerja_id', 'tanggal']))
                            <div class="alert alert-warning mt-4">Data tidak ditemukan untuk filter yang dipilih.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- AJAX Script --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // UPT -> ULTG
        $('#nama_upt').on('change', function() {
            var uptID = $(this).val();
            $('#nama_ultg').html('<option value="">Pilih Nama ULTG</option>');
            $('#nama_lokasikerja').html('<option value="">Pilih Nama Lokasi Kerja</option>');
            if (uptID) {
                $.get('/get-ultg/' + uptID, function(data) {
                    $.each(data, function(id, nama) {
                        $('#nama_ultg').append('<option value="' + id + '">' + nama + '</option>');
                    });
                });
            }
        });

        // ULTG -> Lokasi Kerja
        $('#nama_ultg').on('change', function() {
            var ultgID = $(this).val();
            $('#nama_lokasikerja').html('<option value="">Pilih Nama Lokasi Kerja</option>');
            if (ultgID) {
                $.get('/get-lokasi/' + ultgID, function(data) {
                    $.each(data, function(index, item) {
                        $('#nama_lokasikerja').append('<option value="' + index + '">' + item +
                            '</option>');
                    });
                });
            }
        });

        // Saat reload, jika sudah ada upt/ultg terpilih, isi ulang select option via AJAX
        $(document).ready(function() {
            var uptID = $('#nama_upt').val();
            var ultgID = "{{ old('ultg_id', $ultg_id) }}";
            var lokasiID = "{{ old('lokasikerja_id', $lokasikerja_id) }}";

            if (uptID && $('#nama_ultg option').length <= 1) {
                $.get('/get-ultg/' + uptID, function(data) {
                    $.each(data, function(id, nama) {
                        var selected = (id == ultgID) ? 'selected' : '';
                        $('#nama_ultg').append('<option value="' + id + '" ' + selected + '>' +
                            nama + '</option>');
                    });
                    if (ultgID) {
                        // Isi lokasi kerja jika ultg sudah terpilih
                        $.get('/get-lokasi/' + ultgID, function(data) {
                            $.each(data, function(index, item) {
                                $('#nama_lokasikerja').append('<option value="' + index +
                                    '">' + item + '</option>');
                            });
                        });
                    }
                });
            }
        });
    </script>
@endsection
