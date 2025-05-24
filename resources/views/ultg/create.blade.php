@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Tambah Data ULTG</h4>
    <!-- <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="#">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Forms</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Basic Form</a>
      </li>
    </ul> -->
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Data ULTG</div>
        </div>
        <div class="card-body">
          <div class="row">
          <div class="col-md-6 col-lg-4">
          
          <form action="{{ route('ultg.store') }}" method="POST">
          @csrf
          <div class="form-group">
                    <label for="id">Id ULTG</label>
                    <input type="text" class="form-control" id="id" name="id" value="{{ $newID }}" readonly>
                </div>
                <div class="form-group">
                  <label for="nama">Nama UPT</label>
                  <select class="form-control @error('nama_upt') is-invalid @enderror" id="nama_upt" name="nama_upt">
                      <option value="" disabled selected>Pilih Nama UPT</option>
                      @foreach ($allUptNames as $item)
                          <option value="{{ $item->id }}" {{ old('nama_upt') == $item->id ? 'selected' : '' }}>
                              {{ $item->nama_upt }}
                          </option>
                      @endforeach
                  </select>
                  @error('nama_upt')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>

              <div class="form-group">
                  <label for="nama">Nama ULTG</label>
                  <input type="text" 
                        class="form-control @error('nama_ultg') is-invalid @enderror" 
                        id="nama_ultg" name="nama_ultg" 
                        placeholder="Masukkan Nama ULTG"
                        value="{{ old('nama_ultg') }}">
                  @error('nama_ultg')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>

              
              
              </div>
              </div>
        <div class="card-action">
          <button type="submit" class="btn btn-success">Submit</button>
          <a href="{{ url('ultg') }}" class="btn btn-danger">Cancel</a>        
        </div>
      </div>
    </div>
  </div>
</div>
</div>

@endsection