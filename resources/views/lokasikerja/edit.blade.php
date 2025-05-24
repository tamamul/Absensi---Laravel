@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Edit Data Lokasi Kerja</h4>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Edit Lokasi Kerja</div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 col-lg-4">
              <form action="{{ route('lokasikerja.update', $lokasikerja->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Kolom ID sebagai readonly (tidak bisa diubah) -->
                <div class="form-group">
                  <label for="id">Id Lokasi Kerja</label>
                  <input type="text" class="form-control" id="id" name="id" value="{{ $lokasikerja->id }}" readonly>
                </div>
                
                <!-- Kolom Nama UPT yang bisa diedit -->
                <div class="form-group">
                <label for="nama_upt">Nama Lokasi Kerja</label>
                  <input type="text" 
                         class="form-control @error('nama_lokasikerja') is-invalid @enderror" 
                         id="nama_lokasikerja" name="nama_lokasikerja" 
                         value="{{ old('nama_lokasikerja', $lokasikerja->nama_lokasikerja) }}" 
                         placeholder="Masukkan Nama Lokasi Kerja">
                  @error('nama_lokasikerja')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <!-- <div class="form-group">
                <label for="nama_upt">Latitude</label>
                  <input type="text" 
                         class="form-control @error('nama_lokasikerja') is-invalid @enderror" 
                         id="nama_lokasikerja" name="nama_lokasikerja" 
                         value="{{ old('nama_lokasikerja', $lokasikerja->nama_lokasikerja) }}" 
                         placeholder="Masukkan Nama Lokasi Kerja">
                  @error('nama_lokasikerja')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                 -->
              </div>
            </div>
        </div>
        <div class="card-action">
          <button type="submit" class="btn btn-success">Update</button>
          <a href="{{ url('lokasikerja') }}" class="btn btn-danger">Batal</a>        
        </div>
      </div>
    </div>
  </div>
</div>
</div>

@endsection
