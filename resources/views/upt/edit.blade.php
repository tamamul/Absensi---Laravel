@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Edit Data UPT</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Edit UPT</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <form action="{{ route('upt.update', $upt->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Kolom ID sebagai readonly (tidak bisa diubah) -->
                                    <div class="form-group">
                                        <label for="id">Kode UPT</label>
                                        <input type="text" class="form-control" id="id" name="id"
                                            value="{{ $upt->kode_upt }}" readonly>
                                    </div>

                                    <!-- Kolom Nama UPT yang bisa diedit -->
                                    <div class="form-group">
                                        <label for="nama_upt">Nama UPT</label>
                                        <input type="text" class="form-control @error('nama_upt') is-invalid @enderror"
                                            id="nama_upt" name="nama_upt" value="{{ old('nama_upt', $upt->nama_upt) }}"
                                            placeholder="Masukkan Nama UPT">
                                        @error('nama_upt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ url('upt') }}" class="btn btn-danger">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
