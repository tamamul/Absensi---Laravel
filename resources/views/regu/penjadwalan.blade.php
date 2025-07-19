@extends('layouts.master')
@section('title', 'Penjadwalan Regu')
@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Penjadwalan Regu</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-10 offset-md-1">
            <div class="card mb-4">
                <div class="card-header bg-light"><strong>Daftar Penjadwalan Regu</strong></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Regu</th>
                                    <th>Shift</th>
                                    <th>Anggota Regu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwalRegu ?? [] as $jadwal)
                                    <tr>
                                        <td>{{ $jadwal->tanggal }}</td>
                                        <td>
                                            @php
                                                $regu = $jadwal->regu;
                                                $nama_upt = $nama_ultg = $nama_lokasi = '-';
                                                if ($regu && $regu->satpams->count() > 0) {
                                                    $lokasi = $regu->satpams[0]->lokasikerja;
                                                    $nama_lokasi = $lokasi->nama_lokasikerja ?? '-';
                                                    $nama_ultg = optional($lokasi->ultg)->nama_ultg ?? '-';
                                                    $nama_upt = optional($lokasi->ultg->upt ?? null)->nama_upt ?? '-';
                                                }
                                            @endphp
                                            {{ $regu->nama_regu ?? '-' }} - {{ $nama_upt }} - {{ $nama_ultg }} - {{ $nama_lokasi }}
                                        </td>
                                        <td>{{ $jadwal->shift }}</td>
                                        <td>
                                            @foreach($regu->satpams ?? [] as $satpam)
                                                <span class="badge badge-info mb-1">{{ $satpam->nama }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('regu.penjadwalan.edit', ['id' => $jadwal->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('regu.penjadwalan.delete', ['id' => $jadwal->id]) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin hapus jadwal regu ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center">Belum ada penjadwalan regu</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('regu.penjadwalan.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>UPT</label>
                            <select name="upt_id" id="upt_id" class="form-control">
                                <option value="">Pilih UPT</option>
                                @foreach($upts as $upt)
                                    <option value="{{ $upt->id }}">{{ $upt->nama_upt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ULTG</label>
                            <select name="ultg_id" id="ultg_id" class="form-control">
                                <option value="">Pilih ULTG</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Kerja</label>
                            <select name="lokasikerja_id" id="lokasikerja_id" class="form-control">
                                <option value="">Pilih Lokasi Kerja</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Regu</label>
                            <select name="regu_id" id="regu_id" class="form-control" required>
                                <option value="">Pilih Regu</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <div id="tanggal-list">
                                <div class="input-group mb-2">
                                    <input type="date" name="tanggal[]" class="form-control" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info btn-add-tanggal">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Shift</label>
                            <select name="shift" class="form-control" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="P">Pagi</option>
                                <option value="S">Siang</option>
                                <option value="M">Malam</option>
                                <option value="L">Libur</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Jadwal</button>
                    </form>
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
        $('#lokasikerja_id').html('<option value="">Pilih Lokasi Kerja</option>');
        $('#regu_id').html('<option value="">Pilih Regu</option>');
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
        $('#lokasikerja_id').html('<option value="">Pilih Lokasi Kerja</option>');
        $('#regu_id').html('<option value="">Pilih Regu</option>');
        if (ultgID) {
            $.get('/get-lokasi/' + ultgID, function(data) {
                $.each(data, function(id, nama) {
                    $('#lokasikerja_id').append('<option value="' + id + '">' + nama + '</option>');
                });
            });
        }
    });
    $('#lokasikerja_id').on('change', function() {
        var lokasiID = $(this).val();
        $('#regu_id').html('<option value="">Pilih Regu</option>');
        if (lokasiID) {
            $.get('/get-regu-by-lokasi/' + lokasiID, function(data) {
                $.each(data, function(id, nama) {
                    $('#regu_id').append('<option value="' + id + '">' + nama + '</option>');
                });
            });
        }
    });
$(document).on('click', '.btn-add-tanggal', function() {
    var html = '<div class="input-group mb-2">'+
        '<input type="date" name="tanggal[]" class="form-control" required>'+ 
        '<div class="input-group-append">'+
        '<button type="button" class="btn btn-danger btn-remove-tanggal">-</button>'+ 
        '</div></div>';
    $('#tanggal-list').append(html);
});
$(document).on('click', '.btn-remove-tanggal', function() {
    $(this).closest('.input-group').remove();
});
</script>
@endsection 