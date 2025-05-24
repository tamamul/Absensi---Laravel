@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Tambah Data Satpam</h4>
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
          <div class="card-title">Data Satpam</div>
        </div>
        <form action="{{ route('datasatpam.store') }}" method="POST">
          @csrf 
        <div class="card-body">
          <div class="row">
          <div class="col-md-6 col-lg-4">
          <div class="form-group">
                    <label for="id">Id</label>
                    <input type="text" class="form-control" id="id" name="id" value="{{ $newID }}" readonly>
                </div>
                <div class="form-group">
              <label for="nama">No Induk Pegawai</label>
                  <input type="text" 
                        class="form-control @error('nip') is-invalid @enderror" 
                        id="nip" name="nip" 
                        placeholder="Masukkan No Induk Pegawai"
                        value="{{ old('nip') }}">
                  @error('nip')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
              <label for="nama">NIK</label>
                  <input type="text" 
                        class="form-control @error('nik') is-invalid @enderror" 
                        id="nik" name="nik" 
                        placeholder="Masukkan No Induk Kependudukan"
                        value="{{ old('nik') }}">
                  @error('nik')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
        <div class="form-group">
                <label for="foto">Foto</label>
                <input type="file" class="form-control-file" id="exampleFormControlFile1">
              </div>
              <div class="form-group">
              <label for="nama">Nama Lengkap</label>
                  <input type="text" 
                        class="form-control @error('nama') is-invalid @enderror" 
                        id="nama" name="nama" 
                        placeholder="Masukkan Nama Lengkap"
                        value="{{ old('nama') }}">
                  @error('nama')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" placeholder="Satpam" disabled>
              </div>
              <div class="form-check">
                <label>Status</label><br/>
                <label class="form-radio-label">
                  <input class="form-radio-input" type="radio" name="status" value=""  checked="">
                  <span class="form-radio-sign">PKWT</span>
                </label>
                <label class="form-radio-label ml-3">
                  <input class="form-radio-input" type="radio" name="status" value="">
                  <span class="form-radio-sign">PKWTT</span>
                </label>
              </div>
              <div class="form-group">
              <label for="nama">No PKWT/PKWTT</label>
                  <input type="text" 
                        class="form-control @error('no_pkwt_pkwtt') is-invalid @enderror" 
                        id="no_pkwt_pkwtt" name="no_pkwt_pkwtt" 
                        placeholder="Masukkan No PKWT/PKWTT"
                        value="{{ old('no_pkwt_pkwtt') }}">
                  @error('no_pkwt_pkwtt')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
              <label for="nama">Kontrak</label>
                  <input type="text" 
                        class="form-control @error('kontrak') is-invalid @enderror" 
                        id="kontrak" name="kontrak" 
                        placeholder="Masukkan Kontrak"
                        value="{{ old('kontrak') }}">
                  @error('kontrak')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                <label for="tanggal_lahir">Terhitung Mulai Tugas</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" required>
            </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">Jabatan</label>
                <select class="form-control" id="exampleFormControlSelect1">
                <option value="" disabled selected>Pilih Jabatan</option>
                <option value="Komandan Regu">Komandan Regu</option>
                <option value="Anggota">Anggota</option>
                </select>
              </div>
              <div class="form-group">
    <label for="nama_upt">UPT</label>
    <select class="form-control @error('upt_id') is-invalid @enderror" id="nama_upt" name="upt_id">
        <option value="" disabled selected>Pilih Nama UPT</option>
        @foreach ($allUptNames as $item)
            <option value="{{ $item->id }}" {{ old('upt_id') == $item->id ? 'selected' : '' }}>
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
    <select class="form-control @error('ultg_id') is-invalid @enderror" id="nama_ultg" name="ultg_id">
        <option value="" disabled selected>Pilih Nama ULTG</option>
        <!-- akan dinamis -->
    </select>
    @error('ultg_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="lokasikerja">Lokasi Kerja</label>
    <select class="form-control @error('lokasikerja_id') is-invalid @enderror" id="lokasikerja" name="lokasikerja_id">
        <option value="" disabled selected>Pilih Lokasi Kerja</option>
        <!-- akan dinamis -->
    </select>
    @error('lokasikerja_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

              <div class="form-group">
              <label for="nama">Wilayah Kerja</label>
                  <input type="text" 
                        class="form-control @error('wilayah_kerja') is-invalid @enderror" 
                        id="wilayah_kerja" name="wilayah_kerja" 
                        placeholder="Masukkan Wilayah Kerja"
                        value="{{ old('wilayah_kerja') }}">
                  @error('wilayah_kerja')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
        <div class="form-check">
                <label>Jenis Kelamin</label><br/>
                <label class="form-radio-label">
                  <input class="form-radio-input" type="radio" name="jenis_kelamin" value=""  checked="">
                  <span class="form-radio-sign">Laki-Laki</span>
                </label>
                <label class="form-radio-label ml-3">
                  <input class="form-radio-input" type="radio" name="jenis_kelamin" value="">
                  <span class="form-radio-sign">Perempuan</span>
                </label>
              </div>
              <div class="form-group">
              <label for="nama">Tempat Lahir</label>
                  <input type="text" 
                        class="form-control @error('tempat_lahir') is-invalid @enderror" 
                        id="tempat_lahir" name="tempat_lahir" 
                        placeholder="Masukkan Tempat Lahir"
                        value="{{ old('tempat_lahir') }}">
                  @error('tempat_lahir')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="nama">Usia</label>
                  <input type="text" 
                        class="form-control @error('usia') is-invalid @enderror" 
                        id="usia" name="usia" 
                        placeholder="Masukkan Usia"
                        value="{{ old('usia') }}">
                  @error('usia')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-check">
                <label>Warga Negara</label><br/>
                <label class="form-radio-label">
                  <input class="form-radio-input" type="radio" name="warga_negara" value=""  checked="">
                  <span class="form-radio-sign">WNI</span>
                </label>
                <label class="form-radio-label ml-3">
                  <input class="form-radio-input" type="radio" name="warga_negara" value="">
                  <span class="form-radio-sign">WNA</span>
                </label>
              </div>
          </div>
          <div class="col-md-6 col-lg-4">
          <div class="form-group">
                <label for="agama">Agama</label>
                <select class="form-control" id="agama">
                <option value="" disabled selected>Pilih Agama</option>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddha">Buddha</option>
                <option value="Konghucu">Konghucu</option>
                </select>
                @error('agama')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
              <label for="nama">No HP (WA)</label>
                  <input type="text" 
                        class="form-control @error('no_hp') is-invalid @enderror" 
                        id="no_hp" name="no_hp" 
                        placeholder="Masukkan No Hp"
                        value="{{ old('no_hp') }}">
                  @error('no_hp')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
            <div class="form-group">
                <label for="email2">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Masukkan Email">
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
          <div class="form-group">
                <label for="comment">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="5">
                </textarea>
                @error('alamat')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
              <label for="nama">Kelurahan</label>
                  <input type="text" 
                        class="form-control @error('kelurahan') is-invalid @enderror" 
                        id="kelurahan" name="kelurahan" 
                        placeholder="Masukkan Kelurahan"
                        value="{{ old('kelurahan') }}">
                  @error('kelurahan')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
              <label for="nama">Kecamatan</label>
                  <input type="text" 
                        class="form-control @error('kecamatan') is-invalid @enderror" 
                        id="kecamatan" name="kecamatan" 
                        placeholder="Masukkan Kecamatan"
                        value="{{ old('kecamatan') }}">
                  @error('kecamatan')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
              <label for="nama">Kabupaten/Kota</label>
                  <input type="text" 
                        class="form-control @error('kabupaten') is-invalid @enderror" 
                        id="kabupaten" name="kabupaten" 
                        placeholder="Masukkan Kabupaten"
                        value="{{ old('kabupaten') }}">
                  @error('kabupaten')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
              <label for="nama">Provinsi</label>
                  <input type="text" 
                        class="form-control @error('provinsi') is-invalid @enderror" 
                        id="provinsi" name="provinsi" 
                        placeholder="Masukkan Provinsi"
                        value="{{ old('provinsi') }}">
                  @error('provinsi')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
              <label for="nama">Negara</label>
                  <input type="text" 
                        class="form-control @error('negara') is-invalid @enderror" 
                        id="negara" name="negara" 
                        placeholder="Masukkan Negara"
                        value="{{ old('negara') }}">
                  @error('negara')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
              <label for="nama">Nama Ibu</label>
                  <input type="text" 
                        class="form-control @error('nama_ibu') is-invalid @enderror" 
                        id="nama_ibu" name="nama_ibu" 
                        placeholder="Masukkan Nama Ibu"
                        value="{{ old('nama_ibu') }}">
                  @error('nama_ibu')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
              <label for="nama">Nomor Kontak Darurat</label>
                  <input type="text" 
                        class="form-control @error('no_kontak_darurat') is-invalid @enderror" 
                        id="no_kontak_darurat" name="no_kontak_darurat" 
                        placeholder="Masukkan Nomor Kontak Darurat"
                        value="{{ old('no_kontak_darurat') }}">
                  @error('no_kontak_darurat')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
              <label for="nama">Nama Kontak Darurat</label>
                  <input type="text" 
                        class="form-control @error('nama_kontak_darurat') is-invalid @enderror" 
                        id="nama_kontak_darurat" name="nama_kontak_darurat" 
                        placeholder="Masukkan Nama Kontak Darurat"
                        value="{{ old('nama_kontak_darurat') }}">
                  @error('nama_kontak_darurat')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
              <label for="nama">Nama Ahli Waris</label>
                  <input type="text" 
                        class="form-control @error('nama_ahli_waris') is-invalid @enderror" 
                        id="nama_ahli_waris" name="nama_ahli_waris" 
                        placeholder="Masukkan Nama Ahli Waris"
                        value="{{ old('nama_ahli_waris') }}">
                  @error('nama_ahli_waris')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
              <label for="nama">Tempat Lahir Ahli Waris</label>
                  <input type="text" 
                        class="form-control @error('tempat_lahir_ahli_waris') is-invalid @enderror" 
                        id="tempat_lahir_ahli_waris" name="tempat_lahir_ahli_waris" 
                        placeholder="Masukkan Tempat Lahir Ahli Waris"
                        value="{{ old('tempat_lahir_ahli_waris') }}">
                  @error('tempat_lahir_ahli_waris')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
                <label for="tanggal_lahir_ahli_waris">Tanggal Lahir Ahli Waris</label>
                <input type="date" id="tanggal_lahir_ahli_waris" name="tanggal_lahir_ahli_waris" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="nama">Hubungan Ahli Waris</label>
                  <input type="text" 
                        class="form-control @error('hub_ahli_waris') is-invalid @enderror" 
                        id="hub_ahli_waris" name="hub_ahli_waris" 
                        placeholder="Masukkan Hubungan Ahli Waris"
                        value="{{ old('hub_ahli_waris') }}">
                  @error('hub_ahli_waris')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div> 
              <div class="form-group">
                <label for="status_nikah">Status Nikah</label>
                <select class="form-control" id="status_nikah">
                <option value="" disabled selected>Pilih Status Nikah</option>
                <option value="TK">TK</option>
                <option value="K">K</option>
                <option value="K1">K1</option>
                <option value="K2">K2</option>
                <option value="K3">K3</option>
                <option value="K4">K4</option>
                </select>
                @error('status_nikah')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
          </div>
          <div class="col-md-6 col-lg-4">	
          <div class="form-group">
              <label for="nama">Jumlah Anak</label>
                  <input type="text" 
                        class="form-control @error('jumlah_anak') is-invalid @enderror" 
                        id="jumlah_anak" name="jumlah_anak" 
                        placeholder="Masukkan Jumlah Anak"
                        value="{{ old('jumlah_anak') }}">
                  @error('jumlah_anak')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
              <label for="nama">NPWP</label>
                  <input type="text" 
                        class="form-control @error('npwp') is-invalid @enderror" 
                        id="npwp" name="npwp" 
                        placeholder="Masukkan Nomor Pokok Wajib Pajak"
                        value="{{ old('npwp') }}">
                  @error('npwp')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
              <label for="nama">Nama Bank</label>
                  <input type="text" 
                        class="form-control @error('nama_bank') is-invalid @enderror" 
                        id="nama_bank" name="nama_bank" 
                        placeholder="Masukkan Nama Bank"
                        value="{{ old('nama_bank') }}">
                  @error('nama_bank')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
              <label for="nama">No. Rekening</label>
                  <input type="text" 
                        class="form-control @error('no_rek') is-invalid @enderror" 
                        id="no_rek" name="no_rek" 
                        placeholder="Masukkan Nomor Rekening"
                        value="{{ old('no_rek') }}">
                  @error('no_rek')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
              <label for="nama">Nama Pemilik Rekening</label>
                  <input type="text" 
                        class="form-control @error('nama_pemilik_rek') is-invalid @enderror" 
                        id="nama_pemilik_rek" name="nama_pemilik_rek" 
                        placeholder="Masukkan Nama Pemilik Rekening"
                        value="{{ old('nama_pemilik_rek') }}">
                  @error('nama_pemilik_rek')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
              <label for="nama">No. DPLK</label>
                  <input type="text" 
                        class="form-control @error('no_dplk') is-invalid @enderror" 
                        id="no_dplk" name="no_dplk" 
                        placeholder="Masukkan Nomor Dana Pensiun Lembaga Keuangan"
                        value="{{ old('no_dplk') }}">
                  @error('no_dplk')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
              <label for="nama">Pendidikan Terakhir</label>
                  <input type="text" 
                        class="form-control @error('pend_terakhir') is-invalid @enderror" 
                        id="pend_terakhir" name="pend_terakhir" 
                        placeholder="Masukkan Pendidikan Terakhir"
                        value="{{ old('pend_terakhir') }}">
                  @error('pend_terakhir')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                <label for="ertifikasi_satpam">Sertifikasi Satpam</label>
                <select class="form-control" id="sertifikasi_satpam">
                <option value="" disabled selected>Pilih Sertifikasi</option>
                <option value="Gada Pratama">Gada Pratama</option>
                <option value="Gada Madya">Gada Madya</option>
                <option value="Gada Utama">Gada Utama</option>
                </select>
                @error('sertifikasi_satpam')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="nama">No. Registrasi KTA Satpam</label>
                  <input type="text" 
                        class="form-control @error('no_reg_kta') is-invalid @enderror" 
                        id="no_reg_kta" name="no_reg_kta" 
                        placeholder="Masukkan No. Registrasi KTA Satpam"
                        value="{{ old('no_reg_kta') }}">
                  @error('no_reg_kta')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="nama">No. KTA</label>
                  <input type="text" 
                        class="form-control @error('no_kta') is-invalid @enderror" 
                        id="no_kta" name="no_kta" 
                        placeholder="Masukkan No. KTA"
                        value="{{ old('no_kta') }}">
                  @error('no_kta')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="nama">Polda</label>
                  <input type="text" 
                        class="form-control @error('polda') is-invalid @enderror" 
                        id="polda" name="polda" 
                        placeholder="Masukkan Nama Polda"
                        value="{{ old('polda') }}">
                  @error('polda')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="nama">Polres</label>
                  <input type="text" 
                        class="form-control @error('polres') is-invalid @enderror" 
                        id="polres" name="polres" 
                        placeholder="Masukkan Nama Polres"
                        value="{{ old('polres') }}">
                  @error('polres')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="nama">No. Kartu BPJS Kesehatan</label>
                  <input type="text" 
                        class="form-control @error('no_bpjs_kesehatan') is-invalid @enderror" 
                        id="no_bpjs_kesehatan" name="no_bpjs_kesehatan" 
                        placeholder="Masukkan No. Kartu BPJS Kesehatan"
                        value="{{ old('no_bpjs_kesehatan') }}">
                  @error('no_bpjs_kesehatan')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="nama">No. Kartu BPJS Ketenagakerjaan</label>
                  <input type="text" 
                        class="form-control @error('no_bpjs_ketenagakerjaan') is-invalid @enderror" 
                        id="no_bpjs_ketenagakerjaan" name="no_bpjs_ketenagakerjaan" 
                        placeholder="Masukkan No. Kartu BPJS Ketenagakerjaan"
                        value="{{ old('no_bpjs_ketenagakerjaan') }}">
                  @error('no_bpjs_ketenagakerjaan')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                <label class="form-label">Ukuran Baju</label>
                <div class="selectgroup w-100">
                  <label class="selectgroup-item">
                    <input type="radio" name="ukuran_baju" value="50" class="selectgroup-input" checked="">
                    <span class="selectgroup-button">S</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="ukuran_baju" value="100" class="selectgroup-input">
                    <span class="selectgroup-button">M</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="ukuran_baju" value="150" class="selectgroup-input">
                    <span class="selectgroup-button">L</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="ukuran_baju" value="200" class="selectgroup-input">
                    <span class="selectgroup-button">XL</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="ukuran_baju" value="200" class="selectgroup-input">
                    <span class="selectgroup-button">XXL</span>
                  </label>
                </div>
                @error('ukuran_baju')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="nama">Ukuran Celana</label>
                  <input type="text" 
                        class="form-control @error('ukuran_celana') is-invalid @enderror" 
                        id="ukuran_celana" name="ukuran_celana" 
                        placeholder="Masukkan Ukuran Celana"
                        value="{{ old('ukuran_celana') }}">
                  @error('ukuran_celana')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="nama">Ukuran Sepatu</label>
                  <input type="text" 
                        class="form-control @error('ukuran_sepatu') is-invalid @enderror" 
                        id="ukuran_sepatu" name="ukuran_sepatu" 
                        placeholder="Masukkan Ukuran Sepatu"
                        value="{{ old('ukuran_sepatu') }}">
                  @error('ukuran_sepatu')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="nama">Ukuran Topi</label>
                  <input type="text" 
                        class="form-control @error('ukuran_topi') is-invalid @enderror" 
                        id="ukuran_topi" name="ukuran_topi" 
                        placeholder="Masukkan Ukuran Topi"
                        value="{{ old('ukuran_topi') }}">
                  @error('ukuran_topi')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              </div>
              </div>
              <div class="card-action">
          <button type="submit" class="btn btn-success">Submit</button>
          <a href="{{ url('tampil-datasatpam') }}" class="btn btn-danger">Cancel</a>        
        </div>
      </div>
    </form>
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
                    $('#nama_ultg').append('<option value="" disabled selected>Pilih Nama ULTG</option>');
                    $.each(data, function(key, value) {
                        $('#nama_ultg').append('<option value="'+ value.id +'">'+ value.nama_ultg +'</option>');
                    });
                }
            });
        } else {
            $('#nama_ultg').empty();
            $('#nama_ultg').append('<option value="" disabled selected>Pilih Nama ULTG</option>');
        }
    });
    $('#nama_ultg').on('change', function() {
        var ultgID = $(this).val();
        if (ultgID) {
            $.ajax({
                url: '/get-lokasi-kerja/' + ultgID,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#lokasikerja').empty();
                    $('#lokasikerja').append('<option value="" disabled selected>Pilih Nama Lokasi Kerja</option>');
                    $.each(data, function(key, value) {
                        $('#lokasikerja').append('<option value="'+ value.id +'">'+ value.nama_lokasikerja +'</option>');
                    });
                }
            });
        } else {
            $('#lokasikerja').empty();
            $('#lokasikerja').append('<option value="" disabled selected>Pilih Nama Lokasi Kerja</option>');
        }
    });
</script>

@endsection