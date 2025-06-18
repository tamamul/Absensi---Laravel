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
                        <div class="card">
                            <div class="card-header bg-light">
                                <strong>Select Data</strong>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="upt_id">Nama UPT</label>
                                            <select class="form-control" id="upt_id" name="upt_id">
                                                <option value="">Pilih Nama UPT</option>
                                                @foreach ($allUptNames as $item)
                                                    <option value="{{ $item->id }}" {{ request('upt_id', $upt_id) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama_upt }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="ultg_id">Nama ULTG</label>
                                            <select class="form-control" id="ultg_id" name="ultg_id">
                                                <option value="">Pilih Nama ULTG</option>
                                                @foreach ($ultgs as $ultg)
                                                    <option value="{{ $ultg->id }}" {{ request('ultg_id', $ultg_id) == $ultg->id ? 'selected' : '' }}>
                                                        {{ $ultg->nama_ultg }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="lokasikerja_id">Nama Lokasi Kerja</label>
                                            <select class="form-control" id="lokasikerja_id" name="lokasikerja_id">
                                                <option value="">Pilih Nama Lokasi Kerja</option>
                                                @foreach ($lokasikerjas as $lokasi)
                                                    <option value="{{ $lokasi->id }}" {{ request('lokasikerja_id', $lokasikerja_id) == $lokasi->id ? 'selected' : '' }}>
                                                        {{ $lokasi->nama_lokasikerja }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="tanggal">Periode</label>
                                            <input type="month" class="form-control" id="tanggal" name="tanggal" value="{{ request('tanggal', $tanggal) }}">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (count($laporan) > 0)
                            <div class="mb-3">
                                @if($userRole == 'Pimpinan')
                                    @if(!$isValidated)
                                        <form method="POST" action="{{ route('laporan.validasi') }}">
                                            @csrf
                                            <input type="hidden" name="upt_id" value="{{ $upt_id }}">
                                            <input type="hidden" name="ultg_id" value="{{ $ultg_id }}">
                                            <input type="hidden" name="lokasikerja_id" value="{{ $lokasikerja_id }}">
                                            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-check"></i> Validasi Laporan
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-success">
                                            <i class="fa fa-check"></i> Laporan sudah divalidasi
                                        </div>
                                    @endif
                                @endif

                                @if($userRole == 'Admin')
                                    @if($isValidated)
                                        <form method="GET" action="{{ route('laporan.export') }}" target="_blank">
                                            <input type="hidden" name="upt_id" value="{{ $upt_id }}">
                                            <input type="hidden" name="ultg_id" value="{{ $ultg_id }}">
                                            <input type="hidden" name="lokasikerja_id" value="{{ $lokasikerja_id }}">
                                            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-file-pdf"></i> Export PDF
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fa fa-exclamation-triangle"></i> Laporan belum divalidasi oleh Pimpinan
                                        </div>
                                    @endif
                                @endif
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

                        @if($upt_id && $ultg_id && $lokasikerja_id && $tanggal)
                            {{-- Tabel detail laporan --}}
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h4 class="card-title">Detail Laporan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Satpam</th>
                                                    <!-- <th>Shift</th> -->
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Keluar</th>
                                                    <th>Status</th>
                                                    <!-- <th>Keterangan</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($laporan as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                                    <td>{{ optional($item->satpam)->nama }}</td>
                                                    <!-- <td>{{ $item->shift }}</td> -->
                                                    <td>{{ $item->jam_masuk }}</td>
                                                    <td>{{ $item->jam_keluar }}</td>
                                                    <td>{{ $item->status }}</td>
                                                    <!-- <td>{{ $item->keterangan }}</td> -->
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Ringkasan Laporan Bulanan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Periode</th>
                                            <th>UPT</th>
                                            <th>ULTG</th>
                                            <th>Lokasi Kerja</th>
                                            <th>Status Validasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ringkasanLaporan as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->periode)->format('F Y') }}</td>
                                            <td>{{ optional($item->upt)->nama_upt }}</td>
                                            <td>{{ optional($item->ultg)->nama_ultg }}</td>
                                            <td>{{ optional($item->lokasikerja)->nama_lokasikerja }}</td>
                                            <td>
                                                @if($item->is_validated)
                                                    <span class="badge badge-success">Sudah Divalidasi</span>
                                                @else
                                                    <span class="badge badge-warning">Belum Divalidasi</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('laporan.index', [
                                                    'upt_id' => $item->upt_id,
                                                    'ultg_id' => $item->ultg_id,
                                                    'lokasikerja_id' => $item->lokasikerja_id,
                                                    'tanggal' => \Carbon\Carbon::parse($item->periode)->format('Y-m')
                                                ]) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- AJAX Script --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // UPT -> ULTG
        $('#upt_id').on('change', function() {
            var uptID = $(this).val();
            $('#ultg_id').html('<option value="">Pilih Nama ULTG</option>');
            $('#lokasikerja_id').html('<option value="">Pilih Nama Lokasi Kerja</option>');
            if (uptID) {
                $.get('/get-ultg/' + uptID, function(data) {
                    $.each(data, function(id, nama) {
                        $('#ultg_id').append('<option value="' + id + '">' + nama + '</option>');
                    });
                });
            }
        });

        // ULTG -> Lokasi Kerja
        $('#ultg_id').on('change', function() {
            var ultgID = $(this).val();
            $('#lokasikerja_id').html('<option value="">Pilih Nama Lokasi Kerja</option>');
            if (ultgID) {
                $.get('/get-lokasi/' + ultgID, function(data) {
                    $.each(data, function(index, item) {
                        $('#lokasikerja_id').append('<option value="' + index + '">' + item +
                            '</option>');
                    });
                });
            }
        });

        // Saat reload, jika sudah ada upt/ultg terpilih, isi ulang select option via AJAX
        $(document).ready(function() {
            var uptID = $('#upt_id').val();
            var ultgID = "{{ old('ultg_id', $ultg_id) }}";
            var lokasiID = "{{ old('lokasikerja_id', $lokasikerja_id) }}";

            if (uptID && $('#ultg_id option').length <= 1) {
                $.get('/get-ultg/' + uptID, function(data) {
                    $.each(data, function(id, nama) {
                        var selected = (id == ultgID) ? 'selected' : '';
                        $('#ultg_id').append('<option value="' + id + '" ' + selected + '>' +
                            nama + '</option>');
                    });
                    if (ultgID) {
                        // Isi lokasi kerja jika ultg sudah terpilih
                        $.get('/get-lokasi/' + ultgID, function(data) {
                            $.each(data, function(index, item) {
                                $('#lokasikerja_id').append('<option value="' + index +
                                    '">' + item + '</option>');
                            });
                        });
                    }
                });
            }
        });
    </script>

    
@endsection
