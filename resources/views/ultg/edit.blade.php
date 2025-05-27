@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Edit Data ULTG</h4>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Edit ULTG</div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 col-lg-4">
              
              
              <form action="{{ route('ultg.update', $ultg->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                  <label for="id">Kode ULTG</label>
                  <input type="text" class="form-control" id="id" name="id" value="{{ $ultg->kode_ultg }}" readonly>
                </div>

                <div class="form-group">
                  <label for="nama_upt">Nama UPT</label>
                  <select class="form-control @error('nama_upt') is-invalid @enderror" id="nama_upt" name="nama_upt">
                    <option value="" disabled>Pilih Nama UPT</option>
                    @foreach ($allUptNames as $item)
                    <option value="{{ $item->id }}" 
                    {{ old('nama_upt', $ultg->nama_upt) == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_upt }}
                  </option>
                  @endforeach
                </select>
                @error('nama_upt')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

                <div class="form-group">
                  <label for="nama_ultg">Nama ULTG</label>
                  <input type="text" 
                         class="form-control @error('nama_ultg') is-invalid @enderror" 
                         id="nama_ultg" name="nama_ultg" 
                         value="{{ old('nama_ultg', $ultg->nama_ultg) }}" 
                         placeholder="Masukkan Nama ULTG">
                  @error('nama_ultg')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="card-action mt-3">
                  <button type="submit" class="btn btn-success">Update</button>
                  <a href="{{ url('ultg') }}" class="btn btn-danger">Cancel</a>
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
