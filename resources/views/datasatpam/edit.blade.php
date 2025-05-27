@extends('layouts.master')
@section('title', 'Edit Data Satpam')
@section('content')

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Data Satpam</h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('datasatpam.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Data Pribadi -->
                        <h4>Data Pribadi</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Satpam</label>
                                    <input type="text" class="form-control" name="kode_satpam" value="{{ $data->kode_satpam }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" class="form-control" name="nip" value="{{ $data->nip }}" required>
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control" name="nik" value="{{ $data->nik }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" value="{{ $data->nama }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir" value="{{ $data->tempat_lahir }}">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" value="{{ $data->tanggal_lahir }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Foto</label>
                                    <input type="file" class="form-control" name="foto">
                                    @if($data->foto)
                                        <img src="{{ asset('storage/'.$data->foto) }}" width="100" class="mt-2">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin">
                                        <option value="Laki-laki" {{ $data->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ $data->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Agama</label>
                                    <input type="text" class="form-control" name="agama" value="{{ $data->agama }}">
                                </div>
                                <div class="form-group">
                                    <label>Golongan Darah</label>
                                    <input type="text" class="form-control" name="golongan_darah" value="{{ $data->golongan_darah }}">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat">{{ $data->alamat }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Data Pekerjaan -->
                        <h4 class="mt-4">Data Pekerjaan</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="PKWT" {{ $data->status == 'PKWT' ? 'selected' : '' }}>PKWT</option>
                                        <option value="PKWTT" {{ $data->status == 'PKWTT' ? 'selected' : '' }}>PKWTT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <select class="form-control" name="jabatan">
                                        <option value="Komandan Regu" {{ $data->jabatan == 'Komandan Regu' ? 'selected' : '' }}>Komandan Regu</option>
                                        <option value="Anggota" {{ $data->jabatan == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tanggal_masuk" value="{{ $data->tanggal_masuk }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>UPT</label>
                                    <select class="form-control" name="upt_id" id="upt_id">
                                        @foreach($allUptNames as $upt)
                                            <option value="{{ $upt->id }}" {{ $data->upt_id == $upt->id ? 'selected' : '' }}>
                                                {{ $upt->nama_upt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>ULTG</label>
                                    <select class="form-control" name="ultg_id" id="ultg_id">
                                        @foreach($allUltgNames as $ultg)
                                            <option value="{{ $ultg->id }}" {{ $data->ultg_id == $ultg->id ? 'selected' : '' }}>
                                                {{ $ultg->nama_ultg }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Lokasi Kerja</label>
                                    <select class="form-control" name="lokasikerja_id" id="lokasikerja_id">
                                        @foreach($allLokasikerjaNames as $lokasi)
                                            <option value="{{ $lokasi->id }}" {{ $data->lokasikerja_id == $lokasi->id ? 'selected' : '' }}>
                                                {{ $lokasi->nama_lokasikerja }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Data Kontak -->
                        <h4 class="mt-4">Data Kontak</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No HP</label>
                                    <input type="text" class="form-control" name="no_hp" value="{{ $data->no_hp }}">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $data->email }}">
                                </div>
                            </div>
                        </div>

                        <!-- Data Kontak Darurat -->
                        <h4 class="mt-4">Kontak Darurat</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Kontak Darurat</label>
                                    <input type="text" class="form-control" name="nama_kontak_darurat" value="{{ $data->nama_kontak_darurat }}">
                                </div>
                                <div class="form-group">
                                    <label>Hubungan Kontak Darurat</label>
                                    <input type="text" class="form-control" name="hubungan_kontak_darurat" value="{{ $data->hubungan_kontak_darurat }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No HP Kontak Darurat</label>
                                    <input type="text" class="form-control" name="nohp_kontak_darurat" value="{{ $data->nohp_kontak_darurat }}">
                                </div>
                                <div class="form-group">
                                    <label>Alamat Kontak Darurat</label>
                                    <textarea class="form-control" name="alamat_kontak_darurat">{{ $data->alamat_kontak_darurat }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Data Bank -->
                        <h4 class="mt-4">Data Bank</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Bank</label>
                                    <input type="text" class="form-control" name="nama_bank" value="{{ $data->nama_bank }}">
                                </div>
                                <div class="form-group">
                                    <label>Nomor Rekening</label>
                                    <input type="text" class="form-control" name="nomor_rekening" value="{{ $data->nomor_rekening }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Pemilik Rekening</label>
                                    <input type="text" class="form-control" name="nama_rekening" value="{{ $data->nama_rekening }}">
                                </div>
                            </div>
                        </div>

                        <!-- Data Sertifikasi -->
                        <h4 class="mt-4">Data Sertifikasi</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Sertifikat Gada Pratama</label>
                                    <input type="text" class="form-control" name="no_sertifikat_gada_pratama" value="{{ $data->no_sertifikat_gada_pratama }}">
                                </div>
                                <div class="form-group">
                                    <label>Masa Berlaku Sertifikat</label>
                                    <input type="date" class="form-control" name="masa_berlaku_sertifikat" value="{{ $data->masa_berlaku_sertifikat }}">
                                </div>
                            </div>
                        </div>

                        <!-- Data Ukuran Seragam -->
                        <h4 class="mt-4">Data Ukuran Seragam</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ukuran Baju</label>
                                    <input type="text" class="form-control" name="ukuran_baju" value="{{ $data->ukuran_baju }}">
                                </div>
                                <div class="form-group">
                                    <label>Ukuran Celana</label>
                                    <input type="text" class="form-control" name="ukuran_celana" value="{{ $data->ukuran_celana }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ukuran Sepatu</label>
                                    <input type="text" class="form-control" name="ukuran_sepatu" value="{{ $data->ukuran_sepatu }}">
                                </div>
                                <div class="form-group">
                                    <label>Ukuran Topi</label>
                                    <input type="text" class="form-control" name="ukuran_topi" value="{{ $data->ukuran_topi }}">
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('datasatpam.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Cascade dropdown UPT -> ULTG
    $('#upt_id').change(function() {
        var uptId = $(this).val();
        $.ajax({
            url: '/get-ultg/' + uptId,
            type: 'GET',
            success: function(data) {
                $('#ultg_id').empty();
                $.each(data, function(id, nama) {
                    $('#ultg_id').append(new Option(nama, id));
                });
                $('#ultg_id').trigger('change');
            }
        });
    });

    // Cascade dropdown ULTG -> Lokasi Kerja
    $('#ultg_id').change(function() {
        var ultgId = $(this).val();
        $.ajax({
            url: '/get-lokasi-kerja/' + ultgId,
            type: 'GET',
            success: function(data) {
                $('#lokasikerja_id').empty();
                $.each(data, function(id, nama) {
                    $('#lokasikerja_id').append(new Option(nama, id));
                });
            }
        });
    });
});
</script>
@endpush

@endsection