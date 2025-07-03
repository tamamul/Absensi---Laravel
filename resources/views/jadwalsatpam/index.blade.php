@extends('layouts.master')
@section('title', 'Jadwal Satpam')
@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Jadwal Satpam</h4>
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
                        <a href="/jadwalsatpam/create" class="btn btn-success">
                            <div class="fa fa-plus-circle"></div>
                            <span class="d-none d-lg-block" style="float: right;  margin-left:3px;"> Tambah Data</span>
                        </a>
                        <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modalUploadExcel">
                            <i class="fa fa-upload"></i> Upload Excel Jadwal
                        </a>
                    </div>
                    <div class="card-header">
                        <div class="container">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <strong>Filter Data</strong>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="upt_id">Nama UPT</label>
                                                <select id="upt_id" name="upt_id" class="form-control">
                                                    <option value="">Pilih UPT</option>
                                                    @foreach ($upts as $upt)
                                                        <option value="{{ $upt->id }}"
                                                            {{ request('upt_id') == $upt->id ? 'selected' : '' }}>
                                                            {{ $upt->nama_upt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="ultg_id">Nama ULTG</label>
                                                <select id="ultg_id" name="ultg_id" class="form-control">
                                                    <option value="">Pilih ULTG</option>
                                                    @foreach ($ultgs as $ultg)
                                                        @if (request('upt_id') == $ultg->upt_id)
                                                            <option value="{{ $ultg->id }}"
                                                                {{ request('ultg_id') == $ultg->id ? 'selected' : '' }}>
                                                                {{ $ultg->nama_ultg }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="lokasikerja_id">Lokasi Kerja</label>
                                                <select id="lokasikerja_id" name="lokasikerja_id" class="form-control">
                                                    <option value="">Pilih Lokasi Kerja</option>
                                                    @foreach ($lokasikerjas as $lokasi)
                                                        @if (request('ultg_id') == $lokasi->ultg_id)
                                                            <option value="{{ $lokasi->id }}"
                                                                {{ request('lokasikerja_id') == $lokasi->id ? 'selected' : '' }}>
                                                                {{ $lokasi->nama_lokasikerja }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="picker_bulan_tahun">Tahun - Bulan</label>
                                                <input type="month" class="form-control" id="picker_bulan_tahun"
                                                    name="bulan_tahun" value="{{ request('bulan_tahun', date('Y-m')) }}">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Lokasi Kerja</th>
                                            <th>ULTG</th>
                                            <th>UPT</th>
                                            <th>Periode</th>
                                            <th>Total Jadwal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                            $currentBulanTahun = request('bulan_tahun');

                                            if ($currentBulanTahun) {
                                                [$tahun, $bulan] = explode('-', $currentBulanTahun);
                                                $periodeText =
                                                    DateTime::createFromFormat('!m', $bulan)->format('F') .
                                                    ' ' .
                                                    $tahun;
                                            } else {
                                                $tahun = date('Y');
                                                $periodeText = 'Tahun ' . $tahun;
                                            }
                                        @endphp

                                        @foreach ($groupedJadwal as $lokasiId => $data)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $data['lokasi']->nama_lokasikerja }}</td>
                                                <td>{{ $data['lokasi']->ultg->nama_ultg ?? '-' }}</td>
                                                <td>{{ $data['lokasi']->ultg->upt->nama_upt ?? '-' }}</td>
                                                <td>{{ $periodeText }}</td>
                                                <td>
                                                    <span class="badge badge-info">{{ $data['total'] }} Jadwal</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $uptId = $data['lokasi']->ultg->upt->id ?? '';
                                                        $ultgId = $data['lokasi']->ultg->id ?? '';
                                                    @endphp
                                                    <a href="{{ route('jadwalsatpam.edit', [
                                                        'upt_id' => $uptId,
                                                        'ultg_id' => $ultgId,
                                                        'lokasikerja_id' => $lokasiId,
                                                        'bulan' => $currentBulanTahun ? explode('-', $currentBulanTahun)[1] : date('m'),
                                                        'tahun' => $tahun,
                                                    ]) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fa fa-edit"></i> Edit Jadwal
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if (count($groupedJadwal) == 0)
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <em>Tidak ada data jadwal untuk periode dan filter yang dipilih</em>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // UPT -> ULTG
            $('#upt_id').on('change', function() {
                var uptID = $(this).val();
                $('#ultg_id').html('<option value="">Pilih ULTG</option>');
                $('#lokasikerja_id').html('<option value="">Pilih Lokasi Kerja</option>');
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
                $('#lokasikerja_id').html('<option value="">Pilih Lokasi Kerja</option>');
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
    </div>

    <!-- Modal Upload Excel -->
    <div class="modal fade" id="modalUploadExcel" tabindex="-1" role="dialog" aria-labelledby="modalUploadExcelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('jadwalsatpam.importExcel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUploadExcelLabel">Upload Excel Jadwal Satpam</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file_excel">Pilih File Excel (.xlsx)</label>
                            <input type="file" class="form-control" name="file_excel" accept=".xlsx,.xls" required>
                            <small>Download contoh file: <a href="/sample_jadwal_satpam.xlsx" target="_blank">sample_jadwal_satpam.xlsx</a></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Upload & Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
