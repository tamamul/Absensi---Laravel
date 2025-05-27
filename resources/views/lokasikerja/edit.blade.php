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

                                    <div class="form-group">
                                        <label for="id">Kode Lokasi Kerja</label>
                                        <input type="text" class="form-control" id="id" name="id"
                                            value="{{ $lokasikerja->kode_loker }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_lokasikerja">Nama Lokasi Kerja</label>
                                        <input type="text"
                                            class="form-control @error('nama_lokasikerja') is-invalid @enderror"
                                            id="nama_lokasikerja" name="nama_lokasikerja"
                                            value="{{ old('nama_lokasikerja', $lokasikerja->nama_lokasikerja) }}"
                                            placeholder="Masukkan Nama Lokasi Kerja">
                                        @error('nama_lokasikerja')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="upt_id">UPT</label>
                                        <select name="upt_id" id="upt_id"
                                            class="form-control @error('upt_id') is-invalid @enderror" required>
                                            <option value="">Pilih UPT</option>
                                            @foreach ($upts as $upt)
                                                <option value="{{ $upt->id }}"
                                                    {{ old('upt_id', $lokasikerja->ultg->upt_id ?? '') == $upt->id ? 'selected' : '' }}>
                                                    {{ $upt->nama_upt }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('upt_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="ultg_id">ULTG</label>
                                        <select name="ultg_id" id="ultg_id"
                                            class="form-control @error('ultg_id') is-invalid @enderror" required>
                                            <option value="">Pilih ULTG</option>
                                            @foreach ($ultgs as $ultg)
                                                <option value="{{ $ultg->id }}"
                                                    {{ old('ultg_id', $lokasikerja->ultg_id) == $ultg->id ? 'selected' : '' }}>
                                                    {{ $ultg->nama_ultg }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('ultg_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="latitude">Latitude</label>
                                        <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                            id="latitude" name="latitude"
                                            value="{{ old('latitude', $lokasikerja->latitude) }}"
                                            placeholder="Masukkan Latitude">
                                        @error('latitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="longitude">Longitude</label>
                                        <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                            id="longitude" name="longitude"
                                            value="{{ old('longitude', $lokasikerja->longitude) }}"
                                            placeholder="Masukkan Longitude">
                                        @error('longitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="radius">Radius (meter)</label>
                                        <input type="number" class="form-control @error('radius') is-invalid @enderror"
                                            id="radius" name="radius" value="{{ old('radius', $lokasikerja->radius) }}"
                                            placeholder="Masukkan Radius">
                                        @error('radius')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="card-action mt-3">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="{{ url('lokasikerja') }}" class="btn btn-danger">Batal</a>
                                    </div>
                                </form>
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
            if (uptID) {
                $.get('/get-ultg/' + uptID, function(data) {
                    $.each(data, function(id, nama) {
                        $('#ultg_id').append('<option value="' + id + '">' + nama + '</option>');
                    });
                });
            }
        });
    </script>
@endsection
