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
                    <div class="card-header">
                        <div class="card-title">Edit Data Satpam</div>
                    </div>
                    <form action="{{ route('datasatpam.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="kode_satpam">Kode Satpam</label>
                                        <input type="text" class="form-control" id="kode_satpam" name="kode_satpam"
                                            value="{{ $data->kode_satpam }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nip">No Induk Pegawai</label>
                                        <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                            id="nip" name="nip" value="{{ old('nip', $data->nip) }}">
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nik">NIK</label>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                            id="nik" name="nik" value="{{ old('nik', $data->nik) }}">
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="foto">Foto (Max 2MB)</label>
                                        <input type="file" class="form-control-file @error('foto') is-invalid @enderror"
                                            id="foto" name="foto" accept="image/*" onchange="previewImage(this)">
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($data->foto)
                                            <img id="imagePreview" src="{{ asset('storage/' . $data->foto) }}"
                                                alt="Current Photo" style="max-width: 200px; margin-top: 10px;">
                                        @else
                                            <img id="imagePreview" src="#" alt="Preview"
                                                style="display: none; max-width: 200px; margin-top: 10px;">
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama', $data->nama) }}">
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <input type="text" class="form-control" name="pekerjaan" id="pekerjaan"
                                            value="Satpam" readonly>
                                    </div>
                                    <div class="form-check">
                                        <label>Status</label><br />
                                        <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" name="status" value="PKWT"
                                                {{ old('status', $data->status) == 'PKWT' ? 'checked' : '' }}>
                                            <span class="form-radio-sign">PKWT</span>
                                        </label>
                                        <label class="form-radio-label ml-3">
                                            <input class="form-radio-input" type="radio" name="status" value="PKWTT"
                                                {{ old('status', $data->status) == 'PKWTT' ? 'checked' : '' }}>
                                            <span class="form-radio-sign">PKWTT</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_pkwt_pkwtt">No PKWT/PKWTT</label>
                                        <input type="text"
                                            class="form-control @error('no_pkwt_pkwtt') is-invalid @enderror"
                                            id="no_pkwt_pkwtt" name="no_pkwt_pkwtt"
                                            value="{{ old('no_pkwt_pkwtt', $data->no_pkwt_pkwtt) }}">
                                        @error('no_pkwt_pkwtt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kontrak">Kontrak</label>
                                        <input type="text" class="form-control @error('kontrak') is-invalid @enderror"
                                            id="kontrak" name="kontrak" value="{{ old('kontrak', $data->kontrak) }}">
                                        @error('kontrak')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="terhitung_mulai_tugas">Terhitung Mulai Tugas</label>
                                        <input type="date" id="terhitung_mulai_tugas" name="terhitung_mulai_tugas"
                                            class="form-control @error('terhitung_mulai_tugas') is-invalid @enderror"
                                            value="{{ old('terhitung_mulai_tugas', $data->terhitung_mulai_tugas) }}">
                                        @error('terhitung_mulai_tugas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan</label>
                                        <select class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                                            name="jabatan">
                                            <option value="">Pilih Jabatan</option>
                                            <option value="Komandan Regu"
                                                {{ old('jabatan', $data->jabatan) == 'Komandan Regu' ? 'selected' : '' }}>
                                                Komandan Regu</option>
                                            <option value="Anggota"
                                                {{ old('jabatan', $data->jabatan) == 'Anggota' ? 'selected' : '' }}>Anggota
                                            </option>
                                        </select>
                                        @error('jabatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_upt">UPT</label>
                                        <select class="form-control @error('upt_id') is-invalid @enderror" id="nama_upt"
                                            name="upt_id">
                                            <option value="">Pilih Nama UPT</option>
                                            @foreach ($allUptNames as $upt)
                                                <option value="{{ $upt->id }}"
                                                    {{ old('upt_id', $data->lokasikerja->ultg->upt_id ?? '') == $upt->id ? 'selected' : '' }}>
                                                    {{ $upt->nama_upt }}
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
                                            <option value="">Pilih Nama ULTG</option>
                                            @foreach ($allUltgNames as $ultg)
                                                <option value="{{ $ultg->id }}"
                                                    {{ old('ultg_id', $data->lokasikerja->ultg_id ?? '') == $ultg->id ? 'selected' : '' }}>
                                                    {{ $ultg->nama_ultg }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('ultg_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="lokasikerja_id">Lokasi Kerja</label>
                                        <select class="form-control @error('lokasikerja_id') is-invalid @enderror"
                                            id="lokasikerja_id" name="lokasikerja_id">
                                            <option value="">Pilih Lokasi Kerja</option>
                                            @foreach ($allLokasikerjaNames as $lokasi)
                                                <option value="{{ $lokasi->id }}"
                                                    {{ old('lokasikerja_id', $data->lokasikerja_id) == $lokasi->id ? 'selected' : '' }}>
                                                    {{ $lokasi->nama_lokasikerja }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('lokasikerja_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="wilayah_kerja">Wilayah Kerja</label>
                                        <input type="text"
                                            class="form-control @error('wilayah_kerja') is-invalid @enderror"
                                            id="wilayah_kerja" name="wilayah_kerja"
                                            value="{{ old('wilayah_kerja', $data->wilayah_kerja) }}">
                                        @error('wilayah_kerja')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-check">
                                        <label>Jenis Kelamin</label><br />
                                        <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" name="jenis_kelamin"
                                                value="Laki-laki"
                                                {{ old('jenis_kelamin', $data->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}>
                                            <span class="form-radio-sign">Laki-Laki</span>
                                        </label>
                                        <label class="form-radio-label ml-3">
                                            <input class="form-radio-input" type="radio" name="jenis_kelamin"
                                                value="Perempuan"
                                                {{ old('jenis_kelamin', $data->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                            <span class="form-radio-sign">Perempuan</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text"
                                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                                            id="tempat_lahir" name="tempat_lahir"
                                            value="{{ old('tempat_lahir', $data->tempat_lahir) }}">
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                            value="{{ old('tanggal_lahir', $data->tanggal_lahir) }}">
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="usia">Usia</label>
                                        <input type="text" class="form-control @error('usia') is-invalid @enderror"
                                            id="usia" name="usia" value="{{ old('usia', $data->usia) }}">
                                        @error('usia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-check">
                                        <label>Warga Negara</label><br />
                                        <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" name="warga_negara"
                                                value="WNI"
                                                {{ old('warga_negara', $data->warga_negara) == 'WNI' ? 'checked' : '' }}>
                                            <span class="form-radio-sign">WNI</span>
                                        </label>
                                        <label class="form-radio-label ml-3">
                                            <input class="form-radio-input" type="radio" name="warga_negara"
                                                value="WNA"
                                                {{ old('warga_negara', $data->warga_negara) == 'WNA' ? 'checked' : '' }}>
                                            <span class="form-radio-sign">WNA</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="agama">Agama</label>
                                        <select class="form-control @error('agama') is-invalid @enderror" id="agama"
                                            name="agama">
                                            <option value="">Pilih Agama</option>
                                            <option value="Islam"
                                                {{ old('agama', $data->agama) == 'Islam' ? 'selected' : '' }}>Islam
                                            </option>
                                            <option value="Kristen"
                                                {{ old('agama', $data->agama) == 'Kristen' ? 'selected' : '' }}>Kristen
                                            </option>
                                            <option value="Katolik"
                                                {{ old('agama', $data->agama) == 'Katolik' ? 'selected' : '' }}>Katolik
                                            </option>
                                            <option value="Hindu"
                                                {{ old('agama', $data->agama) == 'Hindu' ? 'selected' : '' }}>Hindu
                                            </option>
                                            <option value="Buddha"
                                                {{ old('agama', $data->agama) == 'Buddha' ? 'selected' : '' }}>Buddha
                                            </option>
                                            <option value="Konghucu"
                                                {{ old('agama', $data->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                            </option>
                                        </select>
                                        @error('agama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_hp">No HP (WA)</label>
                                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                            id="no_hp" name="no_hp" value="{{ old('no_hp', $data->no_hp) }}">
                                        @error('no_hp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $data->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="5">{{ old('alamat', $data->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan</label>
                                        <input type="text"
                                            class="form-control @error('kelurahan') is-invalid @enderror" id="kelurahan"
                                            name="kelurahan" value="{{ old('kelurahan', $data->kelurahan) }}">
                                        @error('kelurahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text"
                                            class="form-control @error('kecamatan') is-invalid @enderror" id="kecamatan"
                                            name="kecamatan" value="{{ old('kecamatan', $data->kecamatan) }}">
                                        @error('kecamatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kabupaten">Kabupaten/Kota</label>
                                        <input type="text"
                                            class="form-control @error('kabupaten') is-invalid @enderror" id="kabupaten"
                                            name="kabupaten" value="{{ old('kabupaten', $data->kabupaten) }}">
                                        @error('kabupaten')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi</label>
                                        <input type="text"
                                            class="form-control @error('provinsi') is-invalid @enderror" id="provinsi"
                                            name="provinsi" value="{{ old('provinsi', $data->provinsi) }}">
                                        @error('provinsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="negara">Negara</label>
                                        <input type="text" class="form-control @error('negara') is-invalid @enderror"
                                            id="negara" name="negara" value="{{ old('negara', $data->negara) }}">
                                        @error('negara')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_ibu">Nama Ibu</label>
                                        <input type="text"
                                            class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu"
                                            name="nama_ibu" value="{{ old('nama_ibu', $data->nama_ibu) }}">
                                        @error('nama_ibu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_kontak_darurat">Nomor Kontak Darurat</label>
                                        <input type="text"
                                            class="form-control @error('no_kontak_darurat') is-invalid @enderror"
                                            id="no_kontak_darurat" name="no_kontak_darurat"
                                            value="{{ old('no_kontak_darurat', $data->no_kontak_darurat) }}">
                                        @error('no_kontak_darurat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_kontak_darurat">Nama Kontak Darurat</label>
                                        <input type="text"
                                            class="form-control @error('nama_kontak_darurat') is-invalid @enderror"
                                            id="nama_kontak_darurat" name="nama_kontak_darurat"
                                            value="{{ old('nama_kontak_darurat', $data->nama_kontak_darurat) }}">
                                        @error('nama_kontak_darurat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_ahli_waris">Nama Ahli Waris</label>
                                        <input type="text"
                                            class="form-control @error('nama_ahli_waris') is-invalid @enderror"
                                            id="nama_ahli_waris" name="nama_ahli_waris"
                                            value="{{ old('nama_ahli_waris', $data->nama_ahli_waris) }}">
                                        @error('nama_ahli_waris')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tempat_lahir_ahli_waris">Tempat Lahir Ahli Waris</label>
                                        <input type="text"
                                            class="form-control @error('tempat_lahir_ahli_waris') is-invalid @enderror"
                                            id="tempat_lahir_ahli_waris" name="tempat_lahir_ahli_waris"
                                            value="{{ old('tempat_lahir_ahli_waris', $data->tempat_lahir_ahli_waris) }}">
                                        @error('tempat_lahir_ahli_waris')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_lahir_ahli_waris">Tanggal Lahir Ahli Waris</label>
                                        <input type="date" id="tanggal_lahir_ahli_waris"
                                            name="tanggal_lahir_ahli_waris"
                                            class="form-control @error('tanggal_lahir_ahli_waris') is-invalid @enderror"
                                            value="{{ old('tanggal_lahir_ahli_waris', $data->tanggal_lahir_ahli_waris) }}">
                                        @error('tanggal_lahir_ahli_waris')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="hub_ahli_waris">Hubungan Ahli Waris</label>
                                        <input type="text"
                                            class="form-control @error('hub_ahli_waris') is-invalid @enderror"
                                            id="hub_ahli_waris" name="hub_ahli_waris"
                                            value="{{ old('hub_ahli_waris', $data->hub_ahli_waris) }}">
                                        @error('hub_ahli_waris')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status_nikah">Status Nikah</label>
                                        <select class="form-control @error('status_nikah') is-invalid @enderror"
                                            id="status_nikah" name="status_nikah">
                                            <option value="">Pilih Status Nikah</option>
                                            <option value="TK"
                                                {{ old('status_nikah', $data->status_nikah) == 'TK' ? 'selected' : '' }}>TK
                                            </option>
                                            <option value="K"
                                                {{ old('status_nikah', $data->status_nikah) == 'K' ? 'selected' : '' }}>K
                                            </option>
                                            <option value="K1"
                                                {{ old('status_nikah', $data->status_nikah) == 'K1' ? 'selected' : '' }}>K1
                                            </option>
                                            <option value="K2"
                                                {{ old('status_nikah', $data->status_nikah) == 'K2' ? 'selected' : '' }}>K2
                                            </option>
                                            <option value="K3"
                                                {{ old('status_nikah', $data->status_nikah) == 'K3' ? 'selected' : '' }}>K3
                                            </option>
                                            <option value="K4"
                                                {{ old('status_nikah', $data->status_nikah) == 'K4' ? 'selected' : '' }}>K4
                                            </option>
                                        </select>
                                        @error('status_nikah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="jumlah_anak">Jumlah Anak</label>
                                        <input type="text"
                                            class="form-control @error('jumlah_anak') is-invalid @enderror"
                                            id="jumlah_anak" name="jumlah_anak"
                                            value="{{ old('jumlah_anak', $data->jumlah_anak) }}">
                                        @error('jumlah_anak')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp">NPWP</label>
                                        <input type="text" class="form-control @error('npwp') is-invalid @enderror"
                                            id="npwp" name="npwp" value="{{ old('npwp', $data->npwp) }}">
                                        @error('npwp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_bank">Nama Bank</label>
                                        <input type="text"
                                            class="form-control @error('nama_bank') is-invalid @enderror" id="nama_bank"
                                            name="nama_bank" value="{{ old('nama_bank', $data->nama_bank) }}">
                                        @error('nama_bank')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_rek">No. Rekening</label>
                                        <input type="text" class="form-control @error('no_rek') is-invalid @enderror"
                                            id="no_rek" name="no_rek" value="{{ old('no_rek', $data->no_rek) }}">
                                        @error('no_rek')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_pemilik_rek">Nama Pemilik Rekening</label>
                                        <input type="text"
                                            class="form-control @error('nama_pemilik_rek') is-invalid @enderror"
                                            id="nama_pemilik_rek" name="nama_pemilik_rek"
                                            value="{{ old('nama_pemilik_rek', $data->nama_pemilik_rek) }}">
                                        @error('nama_pemilik_rek')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_dplk">No. DPLK</label>
                                        <input type="text" class="form-control @error('no_dplk') is-invalid @enderror"
                                            id="no_dplk" name="no_dplk" value="{{ old('no_dplk', $data->no_dplk) }}">
                                        @error('no_dplk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pend_terakhir">Pendidikan Terakhir</label>
                                        <input type="text"
                                            class="form-control @error('pend_terakhir') is-invalid @enderror"
                                            id="pend_terakhir" name="pend_terakhir"
                                            value="{{ old('pend_terakhir', $data->pend_terakhir) }}">
                                        @error('pend_terakhir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="sertifikasi_satpam">Sertifikasi Satpam</label>
                                        <select class="form-control @error('sertifikasi_satpam') is-invalid @enderror"
                                            id="sertifikasi_satpam" name="sertifikasi_satpam">
                                            <option value="">Pilih Sertifikasi</option>
                                            <option value="Gada Pratama"
                                                {{ old('sertifikasi_satpam', $data->sertifikasi_satpam) == 'Gada Pratama' ? 'selected' : '' }}>
                                                Gada Pratama</option>
                                            <option value="Gada Madya"
                                                {{ old('sertifikasi_satpam', $data->sertifikasi_satpam) == 'Gada Madya' ? 'selected' : '' }}>
                                                Gada Madya</option>
                                            <option value="Gada Utama"
                                                {{ old('sertifikasi_satpam', $data->sertifikasi_satpam) == 'Gada Utama' ? 'selected' : '' }}>
                                                Gada Utama</option>
                                        </select>
                                        @error('sertifikasi_satpam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_reg_kta">No. Registrasi KTA Satpam</label>
                                        <input type="text"
                                            class="form-control @error('no_reg_kta') is-invalid @enderror"
                                            id="no_reg_kta" name="no_reg_kta"
                                            value="{{ old('no_reg_kta', $data->no_reg_kta) }}">
                                        @error('no_reg_kta')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_kta">No. KTA</label>
                                        <input type="text" class="form-control @error('no_kta') is-invalid @enderror"
                                            id="no_kta" name="no_kta" value="{{ old('no_kta', $data->no_kta) }}">
                                        @error('no_kta')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="polda">Polda</label>
                                        <input type="text" class="form-control @error('polda') is-invalid @enderror"
                                            id="polda" name="polda" value="{{ old('polda', $data->polda) }}">
                                        @error('polda')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="polres">Polres</label>
                                        <input type="text" class="form-control @error('polres') is-invalid @enderror"
                                            id="polres" name="polres" value="{{ old('polres', $data->polres) }}">
                                        @error('polres')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_bpjs_kesehatan">No. Kartu BPJS Kesehatan</label>
                                        <input type="text"
                                            class="form-control @error('no_bpjs_kesehatan') is-invalid @enderror"
                                            id="no_bpjs_kesehatan" name="no_bpjs_kesehatan"
                                            value="{{ old('no_bpjs_kesehatan', $data->no_bpjs_kesehatan) }}">
                                        @error('no_bpjs_kesehatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_bpjs_ketenagakerjaan">No. Kartu BPJS Ketenagakerjaan</label>
                                        <input type="text"
                                            class="form-control @error('no_bpjs_ketenagakerjaan') is-invalid @enderror"
                                            id="no_bpjs_ketenagakerjaan" name="no_bpjs_ketenagakerjaan"
                                            value="{{ old('no_bpjs_ketenagakerjaan', $data->no_bpjs_ketenagakerjaan) }}">
                                        @error('no_bpjs_ketenagakerjaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Ukuran Baju</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="ukuran_baju" value="S"
                                                    class="selectgroup-input"
                                                    {{ old('ukuran_baju', $data->ukuran_baju) == 'S' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">S</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="ukuran_baju" value="M"
                                                    class="selectgroup-input"
                                                    {{ old('ukuran_baju', $data->ukuran_baju) == 'M' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">M</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="ukuran_baju" value="L"
                                                    class="selectgroup-input"
                                                    {{ old('ukuran_baju', $data->ukuran_baju) == 'L' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">L</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="ukuran_baju" value="XL"
                                                    class="selectgroup-input"
                                                    {{ old('ukuran_baju', $data->ukuran_baju) == 'XL' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">XL</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="ukuran_baju" value="XXL"
                                                    class="selectgroup-input"
                                                    {{ old('ukuran_baju', $data->ukuran_baju) == 'XXL' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">XXL</span>
                                            </label>
                                        </div>
                                        @error('ukuran_baju')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="ukuran_celana">Ukuran Celana</label>
                                        <input type="number"
                                            class="form-control @error('ukuran_celana') is-invalid @enderror"
                                            id="ukuran_celana" name="ukuran_celana"
                                            value="{{ old('ukuran_celana', $data->ukuran_celana) }}">
                                        @error('ukuran_celana')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="ukuran_sepatu">Ukuran Sepatu</label>
                                        <input type="number"
                                            class="form-control @error('ukuran_sepatu') is-invalid @enderror"
                                            id="ukuran_sepatu" name="ukuran_sepatu"
                                            value="{{ old('ukuran_sepatu', $data->ukuran_sepatu) }}">
                                        @error('ukuran_sepatu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Ukuran Topi</label>
                                        <input type="number"
                                            class="form-control @error('ukuran_topi') is-invalid @enderror"
                                            id="ukuran_topi" name="ukuran_topi" placeholder="Masukkan Ukuran Topi"
                                            value="{{ old('ukuran_topi', $data->ukuran_topi) }}">
                                        @error('ukuran_topi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('datasatpam.index') }}" class="btn btn-danger">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fungsi preview image
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Saat UPT dipilih, isi ULTG
        $('#nama_upt').on('change', function() {
            var uptID = $(this).val();
            $('#nama_ultg').empty().append('<option value="" disabled selected>Pilih Nama ULTG</option>');
            $('#lokasikerja_id').empty().append('<option value="" disabled selected>Pilih Lokasi Kerja</option>');
            if (uptID) {
                $.get('/get-ultg/' + uptID, function(data) {
                    $.each(data, function(id, nama) {
                        $('#nama_ultg').append('<option value="' + id + '">' + nama + '</option>');
                    });
                    // Set nilai ULTG yang sudah ada
                    @if (isset($data->ultg_id))
                        $('#nama_ultg').val('{{ $data->ultg_id }}').trigger('change');
                    @endif
                });
            }
        });

        // Saat ULTG dipilih, isi Lokasi Kerja
        $('#nama_ultg').on('change', function() {
            var ultgID = $(this).val();
            $('#lokasikerja_id').empty().append('<option value="" disabled selected>Pilih Lokasi Kerja</option>');
            if (ultgID) {
                $.get('/get-lokasi/' + ultgID, function(data) {
                    $.each(data, function(id, nama) {
                        $('#lokasikerja_id').append('<option value="' + id + '">' + nama +
                            '</option>');
                    });
                    // Set nilai Lokasi Kerja yang sudah ada
                    @if (isset($data->lokasikerja_id))
                        $('#lokasikerja_id').val('{{ $data->lokasikerja_id }}');
                    @endif
                });
            }
        });

        // Trigger change event untuk UPT saat pertama kali load
        @if (isset($data->upt_id))
            $('#nama_upt').val('{{ $data->upt_id }}').trigger('change');
        @endif
    </script>
@endsection
