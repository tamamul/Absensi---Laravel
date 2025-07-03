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
                    <div class="card-title">Form Edit Data Satpam</div>
                    <div class="progress mt-3" style="height: 3px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="formProgress"></div>
                    </div>
                </div>

                <form id="formSatpam" action="{{ route('datasatpam.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                        <!-- Step indicators -->
                        <div class="wizard-steps row mb-5">
                            <div class="col text-center wizard-step active" data-step="1">
                                <div class="wizard-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="wizard-label">Data Pribadi</div>
                            </div>
                            <div class="col text-center wizard-step" data-step="2">
                                <div class="wizard-icon">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="wizard-label">Info Pekerjaan</div>
                            </div>
                            <div class="col text-center wizard-step" data-step="3">
                                <div class="wizard-icon">
                                    <i class="fas fa-address-card"></i>
                                </div>
                                <div class="wizard-label">Kontak & Alamat</div>
                            </div>
                            <div class="col text-center wizard-step" data-step="4">
                                <div class="wizard-icon">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <div class="wizard-label">Sertifikasi</div>
                            </div>
                            <div class="col text-center wizard-step" data-step="5">
                                <div class="wizard-icon">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div class="wizard-label">Data Tambahan</div>
                            </div>
                        </div>

                        <!-- Step 1: Data Pribadi -->
                        <div class="step-content" data-step="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kode_satpam">Kode Satpam</label>
                                        <input type="text" class="form-control" id="kode_satpam" name="kode_satpam" value="{{ $data->kode_satpam }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $data->nama) }}" required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nik">NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $data->nik) }}" required>
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nip">NIP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip', $data->nip) }}" required>
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="agama">Agama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="agama" value="{{ old('agama', $data->agama) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_ibu">Nama Ibu</label>
                                        <input type="text" class="form-control" name="nama_ibu" value="{{ old('nama_ibu', $data->nama_ibu) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto">Foto (Max 2MB)</label>
                                        <input type="file" class="form-control-file @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*" onchange="previewImage(this)">
                                        @if ($data->foto)
                                            <img id="imagePreview" src="{{ asset('storage/' . $data->foto) }}" alt="Current Photo" style="max-width: 200px; margin-top: 10px;">
                                        @else
                                            <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px; margin-top: 10px;">
                                        @endif
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="jenis_kelamin" value="Laki-laki" class="selectgroup-input" {{ old('jenis_kelamin', $data->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }} required>
                                                <span class="selectgroup-button">Laki-laki</span>
                                        </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="jenis_kelamin" value="Perempuan" class="selectgroup-input" {{ old('jenis_kelamin', $data->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Perempuan</span>
                                        </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Warga Negara <span class="text-danger">*</span></label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="warga_negara" value="WNI" class="selectgroup-input" {{ old('warga_negara', $data->warga_negara) == 'WNI' ? 'checked' : '' }} required>
                                                <span class="selectgroup-button">WNI</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="warga_negara" value="WNA" class="selectgroup-input" {{ old('warga_negara', $data->warga_negara) == 'WNA' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">WNA</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $data->tempat_lahir) }}" required>
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $data->tanggal_lahir) }}" required>
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Info Pekerjaan -->
                        <div class="step-content" data-step="2" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status Kepegawaian <span class="text-danger">*</span></label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="status" value="PKWT" class="selectgroup-input" {{ old('status', $data->status) == 'PKWT' ? 'checked' : '' }} required>
                                                <span class="selectgroup-button">PKWT</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="status" value="PKWTT" class="selectgroup-input" {{ old('status', $data->status) == 'PKWTT' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">PKWTT</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_pkwt_pkwtt">No PKWT/PKWTT <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="no_pkwt_pkwtt" value="{{ old('no_pkwt_pkwtt', $data->no_pkwt_pkwtt) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="terhitung_mulai_tugas">Terhitung Mulai Tugas <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="terhitung_mulai_tugas" value="{{ old('terhitung_mulai_tugas', $data->terhitung_mulai_tugas) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                        <select class="form-control" name="jabatan" required>
                                            <option value="">Pilih Jabatan</option>
                                            <option value="Komandan Regu" {{ old('jabatan', $data->jabatan) == 'Komandan Regu' ? 'selected' : '' }}>Komandan Regu</option>
                                            <option value="Anggota" {{ old('jabatan', $data->jabatan) == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="wilayah_kerja">Wilayah Kerja</label>
                                        <input type="text" class="form-control" name="wilayah_kerja" value="{{ old('wilayah_kerja', $data->wilayah_kerja) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="kontrak">Kontrak</label>
                                        <input type="text" class="form-control" name="kontrak" value="{{ old('kontrak', $data->kontrak) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_upt">UPT <span class="text-danger">*</span></label>
                                        <select class="form-control" id="nama_upt" name="upt_id" required>
                                            <option value="">Pilih UPT</option>
                                            @foreach($allUptNames as $upt)
                                                <option value="{{ $upt->id }}" {{ old('upt_id', $data->lokasikerja->ultg->upt_id ?? '') == $upt->id ? 'selected' : '' }}>
                                                    {{ $upt->nama_upt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_ultg">ULTG <span class="text-danger">*</span></label>
                                        <select class="form-control" id="nama_ultg" name="ultg_id" required>
                                            <option value="">Pilih ULTG</option>
                                            @foreach($allUltgNames as $ultg)
                                                <option value="{{ $ultg->id }}" {{ old('ultg_id', $data->lokasikerja->ultg_id ?? '') == $ultg->id ? 'selected' : '' }}>
                                                    {{ $ultg->nama_ultg }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="lokasikerja_id">Lokasi Kerja <span class="text-danger">*</span></label>
                                        <select class="form-control" id="lokasikerja_id" name="lokasikerja_id" required>
                                            <option value="">Pilih Lokasi Kerja</option>
                                            @foreach($allLokasikerjaNames as $lokasi)
                                                <option value="{{ $lokasi->id }}" {{ old('lokasikerja_id', $data->lokasikerja_id) == $lokasi->id ? 'selected' : '' }}>
                                                    {{ $lokasi->nama_lokasikerja }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    </div>
                                    </div>

                        <!-- Step 3: Kontak & Alamat -->
                        <div class="step-content" data-step="3" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_hp">No HP (WA) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp', $data->no_hp) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email', $data->email) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="alamat" rows="3" required>{{ old('alamat', $data->alamat) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="negara">Negara</label>
                                        <input type="text" class="form-control" name="negara" value="{{ old('negara', $data->negara) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_kontak_darurat">No Kontak Darurat</label>
                                        <input type="text" class="form-control" name="no_kontak_darurat" value="{{ old('no_kontak_darurat', $data->no_kontak_darurat) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_kontak_darurat">Nama Kontak Darurat</label>
                                        <input type="text" class="form-control" name="nama_kontak_darurat" value="{{ old('nama_kontak_darurat', $data->nama_kontak_darurat) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan</label>
                                        <input type="text" class="form-control" name="kelurahan" value="{{ old('kelurahan', $data->kelurahan) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan', $data->kecamatan) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="kabupaten">Kabupaten/Kota</label>
                                        <input type="text" class="form-control" name="kabupaten" value="{{ old('kabupaten', $data->kabupaten) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi</label>
                                        <input type="text" class="form-control" name="provinsi" value="{{ old('provinsi', $data->provinsi) }}">
                                    </div>
                                </div>
                                    </div>
                                    </div>

                        <!-- Step 4: Sertifikasi -->
                        <div class="step-content" data-step="4" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sertifikasi_satpam">Sertifikasi Satpam <span class="text-danger">*</span></label>
                                        <select class="form-control" name="sertifikasi_satpam" required>
                                            <option value="">Pilih Sertifikasi</option>
                                            <option value="Gada Pratama" {{ old('sertifikasi_satpam', $data->sertifikasi_satpam) == 'Gada Pratama' ? 'selected' : '' }}>Gada Pratama</option>
                                            <option value="Gada Madya" {{ old('sertifikasi_satpam', $data->sertifikasi_satpam) == 'Gada Madya' ? 'selected' : '' }}>Gada Madya</option>
                                            <option value="Gada Utama" {{ old('sertifikasi_satpam', $data->sertifikasi_satpam) == 'Gada Utama' ? 'selected' : '' }}>Gada Utama</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_reg_kta">No. Registrasi KTA</label>
                                        <input type="text" class="form-control" name="no_reg_kta" value="{{ old('no_reg_kta', $data->no_reg_kta) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_kta">No. KTA</label>
                                        <input type="text" class="form-control" name="no_kta" value="{{ old('no_kta', $data->no_kta) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_ahli_waris">Nama Ahli Waris</label>
                                        <input type="text" class="form-control" name="nama_ahli_waris" value="{{ old('nama_ahli_waris', $data->nama_ahli_waris) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="tempat_lahir_ahli_waris">Tempat Lahir Ahli Waris</label>
                                        <input type="text" class="form-control" name="tempat_lahir_ahli_waris" value="{{ old('tempat_lahir_ahli_waris', $data->tempat_lahir_ahli_waris) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_lahir_ahli_waris">Tanggal Lahir Ahli Waris</label>
                                        <input type="date" class="form-control" name="tanggal_lahir_ahli_waris" value="{{ old('tanggal_lahir_ahli_waris', $data->tanggal_lahir_ahli_waris) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="hub_ahli_waris">Hubungan Ahli Waris</label>
                                        <input type="text" class="form-control" name="hub_ahli_waris" value="{{ old('hub_ahli_waris', $data->hub_ahli_waris) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="status_nikah">Status Nikah</label>
                                        <select class="form-control" name="status_nikah">
                                            <option value="">Pilih Status</option>
                                            <option value="TK" {{ old('status_nikah', $data->status_nikah) == 'TK' ? 'selected' : '' }}>TK</option>
                                            <option value="K" {{ old('status_nikah', $data->status_nikah) == 'K' ? 'selected' : '' }}>K</option>
                                            <option value="K1" {{ old('status_nikah', $data->status_nikah) == 'K1' ? 'selected' : '' }}>K1</option>
                                            <option value="K2" {{ old('status_nikah', $data->status_nikah) == 'K2' ? 'selected' : '' }}>K2</option>
                                            <option value="K3" {{ old('status_nikah', $data->status_nikah) == 'K3' ? 'selected' : '' }}>K3</option>
                                            <option value="K4" {{ old('status_nikah', $data->status_nikah) == 'K4' ? 'selected' : '' }}>K4</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah_anak">Jumlah Anak</label>
                                        <input type="number" class="form-control" name="jumlah_anak" value="{{ old('jumlah_anak', $data->jumlah_anak) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="polda">Polda</label>
                                        <input type="text" class="form-control" name="polda" value="{{ old('polda', $data->polda) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="polres">Polres</label>
                                        <input type="text" class="form-control" name="polres" value="{{ old('polres', $data->polres) }}">
                                    </div>
                                </div>
                                    </div>
                                    </div>

                        <!-- Step 5: Data Tambahan -->
                        <div class="step-content" data-step="5" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="npwp">NPWP</label>
                                        <input type="text" class="form-control" name="npwp" value="{{ old('npwp', $data->npwp) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_bpjs_kesehatan">No. BPJS Kesehatan</label>
                                        <input type="text" class="form-control" name="no_bpjs_kesehatan" value="{{ old('no_bpjs_kesehatan', $data->no_bpjs_kesehatan) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_bpjs_ketenagakerjaan">No. BPJS Ketenagakerjaan</label>
                                        <input type="text" class="form-control" name="no_bpjs_ketenagakerjaan" value="{{ old('no_bpjs_ketenagakerjaan', $data->no_bpjs_ketenagakerjaan) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_bank">Nama Bank</label>
                                        <input type="text" class="form-control" name="nama_bank" value="{{ old('nama_bank', $data->nama_bank) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_rek">No Rekening</label>
                                        <input type="text" class="form-control" name="no_rek" value="{{ old('no_rek', $data->no_rek) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_pemilik_rek">Nama Pemilik Rekening</label>
                                        <input type="text" class="form-control" name="nama_pemilik_rek" value="{{ old('nama_pemilik_rek', $data->nama_pemilik_rek) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_dplk">No DPLK</label>
                                        <input type="text" class="form-control" name="no_dplk" value="{{ old('no_dplk', $data->no_dplk) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="pend_terakhir">Pendidikan Terakhir</label>
                                        <input type="text" class="form-control" name="pend_terakhir" value="{{ old('pend_terakhir', $data->pend_terakhir) }}">
                                    </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ukuran Baju</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="ukuran_baju" value="S" class="selectgroup-input" {{ old('ukuran_baju', $data->ukuran_baju) == 'S' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">S</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="ukuran_baju" value="M" class="selectgroup-input" {{ old('ukuran_baju', $data->ukuran_baju) == 'M' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">M</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="ukuran_baju" value="L" class="selectgroup-input" {{ old('ukuran_baju', $data->ukuran_baju) == 'L' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">L</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="ukuran_baju" value="XL" class="selectgroup-input" {{ old('ukuran_baju', $data->ukuran_baju) == 'XL' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">XL</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="ukuran_baju" value="XXL" class="selectgroup-input" {{ old('ukuran_baju', $data->ukuran_baju) == 'XXL' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">XXL</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ukuran_celana">Ukuran Celana</label>
                                        <input type="number" class="form-control" name="ukuran_celana" value="{{ old('ukuran_celana', $data->ukuran_celana) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="ukuran_sepatu">Ukuran Sepatu</label>
                                        <input type="number" class="form-control" name="ukuran_sepatu" value="{{ old('ukuran_sepatu', $data->ukuran_sepatu) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="ukuran_topi">Ukuran Topi</label>
                                        <input type="number" class="form-control" name="ukuran_topi" value="{{ old('ukuran_topi', $data->ukuran_topi) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="card-action">
                        <button type="button" class="btn btn-danger" id="prevStep" style="display: none;">Sebelumnya</button>
                        <button type="button" class="btn btn-success" id="nextStep">Selanjutnya</button>
                        <button type="submit" class="btn btn-primary" id="submitForm" style="display: none;">Update Data</button>
                        <a href="{{ route('datasatpam.index') }}" class="btn btn-danger">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    $(document).ready(function() {
        let currentStep = 1;
        const totalSteps = 5;
        function updateProgress() {
            const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
            $('#formProgress').css('width', progress + '%');
            $('.wizard-step').removeClass('active');
            $(`.wizard-step[data-step="${currentStep}"]`).addClass('active');
        }
        function showStep(step) {
            $('.step-content').hide();
            $(`.step-content[data-step="${step}"]`).show();
            if (step === 1) {
                $('#prevStep').hide();
            } else {
                $('#prevStep').show();
            }
            if (step === totalSteps) {
                $('#nextStep').hide();
                $('#submitForm').show();
            } else {
                $('#nextStep').show();
                $('#submitForm').hide();
            }
            updateProgress();
        }
        function validateStep(step) {
            let valid = true;
            $(`.step-content[data-step="${step}"] :input[required]`).each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    valid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            return valid;
        }
        $('#nextStep').off('click').on('click', function() {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            } else {
                alert('Mohon lengkapi data yang wajib diisi!');
            }
        });
        $('#prevStep').off('click').on('click', function() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });
        showStep(1);
        $('#nama_upt').change(function() {
            var uptId = $(this).val();
            $('#nama_ultg').empty().append('<option value="">Pilih ULTG</option>');
            $('#lokasikerja_id').empty().append('<option value="">Pilih Lokasi Kerja</option>');
            if (uptId) {
                $.get('/get-ultg/' + uptId, function(data) {
                    $.each(data, function(id, nama) {
                        $('#nama_ultg').append(`<option value="${id}">${nama}</option>`);
                    });
                });
            }
        });
        $('#nama_ultg').change(function() {
            var ultgId = $(this).val();
            $('#lokasikerja_id').empty().append('<option value="">Pilih Lokasi Kerja</option>');
            if (ultgId) {
                $.get('/get-lokasi/' + ultgId, function(data) {
                    console.log('Response Lokasi Kerja:', data);
                    $('#lokasikerja_id').empty().append('<option value="">Pilih Lokasi Kerja</option>');
                    $.each(data, function(id, nama) {
                        $('#lokasikerja_id').append(`<option value="${id}">${nama}</option>`);
                    });
                });
            }
        });
    });
    </script>

    <style>
    .wizard-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }
    .wizard-step {
        text-align: center;
        position: relative;
        flex: 1;
    }
    .wizard-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #f4f4f4;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        color: #999;
    }
    .wizard-step.active .wizard-icon {
        background: #1572E8;
        color: white;
    }
    .wizard-label {
        font-size: 14px;
        color: #999;
    }
    .wizard-step.active .wizard-label {
        color: #1572E8;
        font-weight: bold;
    }
    .form-section {
        display: none;
    }
    .form-section.active {
        display: block;
    }
    </style>

@endsection
