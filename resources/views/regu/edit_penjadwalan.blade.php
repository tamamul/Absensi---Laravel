@extends('layouts.master')
@section('title', 'Edit Penjadwalan Regu')
@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Penjadwalan Regu</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('regu.penjadwalan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                        <div class="form-group">
                            <label>UPT</label>
                            <select name="upt_id" id="upt_id" class="form-control">
                                <option value="">Pilih UPT</option>
                                @foreach($upts as $upt)
                                    <option value="{{ $upt->id }}" {{ optional($jadwal->regu->satpams[0]->lokasikerja->ultg->upt ?? null)->id == $upt->id ? 'selected' : '' }}>{{ $upt->nama_upt }}</option>
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
                                <option value="{{ $jadwal->regu_id }}" selected>{{ $jadwal->regu->nama_regu ?? '-' }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ $jadwal->tanggal }}" required>
                        </div>
                        <div class="form-group">
                            <label>Shift</label>
                            <select name="shift" class="form-control" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="P" {{ $jadwal->shift == 'P' ? 'selected' : '' }}>Pagi</option>
                                <option value="S" {{ $jadwal->shift == 'S' ? 'selected' : '' }}>Siang</option>
                                <option value="M" {{ $jadwal->shift == 'M' ? 'selected' : '' }}>Malam</option>
                                <option value="L" {{ $jadwal->shift == 'L' ? 'selected' : '' }}>Libur</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Update Jadwal</button>
                        <a href="{{ route('regu.penjadwalan.form') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var upt_id = $('#upt_id').val();
    var ultg_id = '{{ optional($jadwal->regu->satpams[0]->lokasikerja->ultg ?? null)->id ?? '' }}';
    var lokasikerja_id = '{{ optional($jadwal->regu->satpams[0]->lokasikerja ?? null)->id ?? '' }}';
    if(upt_id) {
        $.get('/get-ultg/' + upt_id, function(data) {
            $.each(data, function(id, nama) {
                var selected = (id == ultg_id) ? 'selected' : '';
                $('#ultg_id').append('<option value="' + id + '" '+selected+'>' + nama + '</option>');
            });
            if(ultg_id) {
                $('#ultg_id').val(ultg_id);
                $.get('/get-lokasi/' + ultg_id, function(data) {
                    $.each(data, function(id, nama) {
                        var selected = (id == lokasikerja_id) ? 'selected' : '';
                        $('#lokasikerja_id').append('<option value="' + id + '" '+selected+'>' + nama + '</option>');
                    });
                    if(lokasikerja_id) {
                        $('#lokasikerja_id').val(lokasikerja_id);
                    }
                });
            }
        });
    }
});
</script>
@endsection 