@extends('layouts.master')
@section('title', 'atlantis')
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
                                                <select id="upt_id" name="upt_id" class="form-control" required>
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
                                                <select id="ultg_id" name="ultg_id" class="form-control" required>
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
                                                <select id="lokasikerja_id" name="lokasikerja_id" class="form-control"
                                                    required>
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
                                                    name="bulan_tahun" value="{{ request('bulan_tahun', date('Y-m')) }}"
                                                    required>
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
                                            <th>Id Jadwal</th>
                                            <th>Nama Satpam</th>
                                            <th>Nama Lokasi Kerja</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jadwalsatpams as $no => $jadwal)
                                            <tr>
                                                <td>{{ $no + 1 }}</td>
                                                <td>{{ $jadwal->id }}</td>
                                                <td>{{ $jadwal->datasatpam->nama ?? '-' }}</td>
                                                <td>
                                                    {{ $jadwal->datasatpam->lokasikerja->nama_lokasikerja ?? '-' }}<br />
                                                    <small>
                                                        ULTG:
                                                        {{ $jadwal->datasatpam->lokasikerja->ultg->nama_ultg ?? '-' }}<br />
                                                        UPT:
                                                        {{ $jadwal->datasatpam->lokasikerja->ultg->upt->nama_upt ?? '-' }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <a href="{{ route('jadwalsatpam.edit', $jadwal->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('jadwalsatpam.destroy', $jadwal->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    </form>
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
    @endsection
