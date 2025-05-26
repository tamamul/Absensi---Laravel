@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tambah Data UPT</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Data UPT</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">

                                <form action="{{ route('upt.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="kode_upt">Id UPT</label>
                                        <input type="text" class="form-control" id="kode_upt" name="kode_upt"
                                            value="{{ $newID }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama UPT</label>
                                        <input type="text" class="form-control @error('nama_upt') is-invalid @enderror"
                                            id="nama_upt" name="nama_upt" placeholder="Masukkan Nama UPT"
                                            value="{{ old('nama_upt') }}">
                                        @error('nama_upt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ url('upt') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
