@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tambah Data Lokasi</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Data Lokasi Kerja</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <form action="{{ route('lokasikerja.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="disableinput">Kode Lokasi</label>
                                        <input type="text" class="form-control" id="kode_loker" name="kode_loker"
                                            value="{{ $newID }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_upt">Nama UPT</label>
                                        <select class="form-control @error('upt_id') is-invalid @enderror" id="nama_upt"
                                            name="upt_id">
                                            <option value="" disabled selected>Pilih Nama UPT</option>
                                            @foreach ($allUptNames as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('upt_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_upt }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('upt_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_ultg">Nama ULTG</label>
                                        <select class="form-control @error('ultg_id') is-invalid @enderror" id="nama_ultg"
                                            name="ultg_id">
                                            <option value="" disabled selected>Pilih Nama ULTG</option>
                                            <!-- akan dinamis -->
                                        </select>
                                        @error('ultg_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="nama">Nama Lokasi Kerja</label>
                                        <input type="text"
                                            class="form-control @error('nama_lokasikerja') is-invalid @enderror"
                                            id="nama_lokasikerja" name="nama_lokasikerja"
                                            placeholder="Masukkan Nama Lokasi Kerja" value="{{ old('nama_lokasikerja') }}">
                                        @error('nama_lokasikerja')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Latitude</label>
                                        <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                            id="latitude" name="latitude" placeholder="Masukkan Latitude"
                                            value="{{ old('latitude') }}">
                                        @error('latitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Longitude</label>
                                        <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                            id="longitude" name="longitude" placeholder="Masukkan Longitude"
                                            value="{{ old('longitude') }}">
                                        @error('longitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Radius</label>
                                        <input type="text" class="form-control @error('radius') is-invalid @enderror"
                                            id="radius" name="radius" placeholder="Masukkan Radius"
                                            value="{{ old('radius') }}">
                                        @error('radius')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ url('lokasikerja') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#nama_upt').on('change', function() {
            var uptID = $(this).val();
            if (uptID) {
                $.ajax({
                    url: '/lokasikerja/get-ultg/' + uptID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#nama_ultg').empty();
                        $('#nama_ultg').append(
                            '<option value="" disabled selected>Pilih Nama ULTG</option>');
                        $.each(data, function(key, value) {
                            $('#nama_ultg').append('<option value="' + value.id + '">' + value
                                .nama_ultg + '</option>');
                        });
                    }
                });
            } else {
                $('#nama_ultg').empty();
                $('#nama_ultg').append('<option value="" disabled selected>Pilih Nama ULTG</option>');
            }
        });
    </script>

@endsection
