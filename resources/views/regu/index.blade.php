@extends('layouts.master')
@section('title', 'Kelola Regu')
@section('content')
<div class="page-inner">
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4 class="page-title mb-0">Kelola Regu</h4>
        <a href="{{ route('regu.create') }}" class="btn btn-success">Tambah Regu</a>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="mb-4" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <label>UPT</label>
                                <select name="upt_id" id="upt_id" class="form-control">
                                    <option value="">Pilih UPT</option>
                                    @foreach($upts as $upt)
                                        <option value="{{ $upt->id }}" {{ request('upt_id') == $upt->id ? 'selected' : '' }}>{{ $upt->nama_upt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>ULTG</label>
                                <select name="ultg_id" id="ultg_id" class="form-control">
                                    <option value="">Pilih ULTG</option>
                                    @foreach($ultgs as $ultg)
                                        @if(request('upt_id') == $ultg->upt_id)
                                            <option value="{{ $ultg->id }}" {{ request('ultg_id') == $ultg->id ? 'selected' : '' }}>{{ $ultg->nama_ultg }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Lokasi Kerja</label>
                                <select name="lokasikerja_id" id="lokasikerja_id" class="form-control">
                                    <option value="">Pilih Lokasi Kerja</option>
                                    @foreach($lokasikerjas as $lokasi)
                                        @if(request('ultg_id') == $lokasi->ultg_id)
                                            <option value="{{ $lokasi->id }}" {{ request('lokasikerja_id') == $lokasi->id ? 'selected' : '' }}>{{ $lokasi->nama_lokasikerja }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:5%">No</th>
                                    <th style="width:25%">Nama Regu</th>
                                    <th>Anggota Satpam</th>
                                    <th style="width:15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($regus as $regu)
                                    @if($regu->satpams->count() > 0)
                                        <tr>
                                            <td>{{ ($regus->currentPage() - 1) * $regus->perPage() + $loop->iteration }}</td>
                                            <td>{{ $regu->nama_regu_full }}</td>
                                            <td>
                                                @forelse($regu->satpams as $satpam)
                                                    <span class="badge badge-info mb-1">{{ $satpam->nama }}</span>
                                                @empty
                                                    <span class="text-muted">-</span>
                                                @endforelse
                                            </td>
                                            <td>
                                                <a href="{{ route('regu.edit', $regu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('regu.destroy', $regu->id) }}" method="POST" style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus regu?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data regu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{ $regus->appends(request()->query())->links() }}
                        </div>
                    </div>
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
        if (ultgID) {
            $.get('/get-lokasi/' + ultgID, function(data) {
                $.each(data, function(id, nama) {
                    $('#lokasikerja_id').append('<option value="' + id + '">' + nama + '</option>');
                });
            });
        }
    });
</script>
@endsection 