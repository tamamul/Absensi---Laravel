@extends('layouts.master')
@section('title', 'Edit Regu')
@section('content')
<style>
input[type="checkbox"].form-check-input {
    appearance: checkbox !important;
    -webkit-appearance: checkbox !important;
    width: 18px !important;
    height: 18px !important;
    background: initial !important;
    border: initial !important;
    box-shadow: none !important;
    outline: none !important;
}
</style>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Regu</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('regu.update', $regu->id) }}" method="POST" id="formRegu">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Regu</label>
                            <input type="text" name="nama_regu" class="form-control" value="{{ $regu->nama_regu }}" required>
                        </div>
                        <div class="form-group">
                            <label>UPT</label>
                            <select name="upt_id" id="upt_id" class="form-control">
                                <option value="">Pilih UPT</option>
                                @foreach($upts as $upt)
                                    <option value="{{ $upt->id }}" {{ (isset($upt_id) && $upt_id == $upt->id) ? 'selected' : '' }}>{{ $upt->nama_upt }}</option>
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
                            <label>Pilih Anggota Satpam</label>
                            <div id="satpam-list">
                                <span class="text-muted">Pilih lokasi kerja terlebih dahulu</span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('regu.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var checkedSatpam = @json($regu->satpams->pluck('id')->toArray());
    $(document).ready(function() {
        var upt_id = '{{ $upt_id ?? '' }}';
        var ultg_id = '{{ $ultg_id ?? '' }}';
        var lokasikerja_id = '{{ $lokasikerja_id ?? '' }}';
        if(upt_id) {
            $('#upt_id').val(upt_id);
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
                            // Panggil AJAX get-satpam langsung tanpa perlu trigger user
                            $('#satpam-list').html('<span class="text-muted">Memuat data satpam...</span>');
                            $.get('/get-satpam/' + lokasikerja_id, function(data) {
                                var html = '';
                                $.each(data, function(id, nama) {
                                    var checked = checkedSatpam.includes(parseInt(id)) ? 'checked' : '';
                                    html += '<div style="margin-bottom:8px;"><input type="checkbox" name="satpam_id[]" value="'+id+'" id="satpam'+id+'" '+checked+'> <label for="satpam'+id+'">'+nama+'</label></div>';
                                });
                                if(html == '') html = '<span class="text-danger">Tidak ada satpam di lokasi ini</span>';
                                $('#satpam-list').html(html);
                            });
                        }
                    });
                }
            });
        }
    });
    $('#upt_id').on('change', function() {
        var uptID = $(this).val();
        $('#ultg_id').html('<option value="">Pilih ULTG</option>');
        $('#lokasikerja_id').html('<option value="">Pilih Lokasi Kerja</option>');
        $('#satpam-list').html('<span class="text-muted">Pilih lokasi kerja terlebih dahulu</span>');
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
        $('#satpam-list').html('<span class="text-muted">Pilih lokasi kerja terlebih dahulu</span>');
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
        $('#satpam-list').html('<span class="text-muted">Memuat data satpam...</span>');
        if (lokasiID) {
            $.get('/get-satpam/' + lokasiID, function(data) {
                var html = '';
                $.each(data, function(id, nama) {
                    var checked = checkedSatpam.includes(parseInt(id)) ? 'checked' : '';
                    html += '<div style="margin-bottom:8px;"><input type="checkbox" name="satpam_id[]" value="'+id+'" id="satpam'+id+'" '+checked+'> <label for="satpam'+id+'">'+nama+'</label></div>';
                });
                if(html == '') html = '<span class="text-danger">Tidak ada satpam di lokasi ini</span>';
                $('#satpam-list').html(html);
            });
        } else {
            $('#satpam-list').html('<span class="text-muted">Pilih lokasi kerja terlebih dahulu</span>');
        }
    });
</script>
@endsection 