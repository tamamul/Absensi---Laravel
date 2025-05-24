@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

<div class="page-inner">
    <div class="page-header">
    <h4 class="page-title">Laporan</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="/">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Tables</a>
      </li>
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
                        <label for="nama_ultg">Nama UPT</label>
                        <select class="form-control @error('upt_id') is-invalid @enderror" id="nama_upt" name="upt_id">
        <option value="" disabled selected>Pilih Nama UPT</option>
        @foreach ($allUptNames as $item)
            <option value="{{ $item->id }}" {{ old('upt_id') == $item->id ? 'selected' : '' }}>
                {{ $item->nama_upt }}
            </option>
        @endforeach
    </select>
                    </div>

                    <div class="col-md-3">
                        <label for="nama_lokasi_kerja">Nama ULTG</label>
                        <label for="nama_ultg">Nama ULTG</label>
    <select class="form-control @error('ultg_id') is-invalid @enderror" id="nama_ultg" name="ultg_id">
        <option value="" disabled selected>Pilih Nama ULTG</option>
        <!-- akan dinamis -->
    </select>
                    </div>

                    <div class="col-md-3">
                        <label for="nama_lokasi_kerja">Nama Lokasi Kerja</label>
                        <select class="form-control @error('lokasikerja_id') is-invalid @enderror" id="nama_lokasikerja" name="lokasikerja_id">
        <option value="" disabled selected>Pilih Nama Lokasi Kerja</option>
        <!-- akan dinamis -->
    </select>
                    </div>

                    <div class="col-md-3">
                        <label for="tanggal">Bulan- Tahun</label>
                        <input type="month" class="form-control" id="tanggal" name="tanggal">
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">View</button>
                </div>
                </div>
            </form>
        </div>
    </div>
    
</div>
                </div>
            </div>
        </div>
    </div>
    

@endsection

