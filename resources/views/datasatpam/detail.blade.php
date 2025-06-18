@extends('layouts.master')
@section('title', 'Detail Data Satpam')
@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Detail Data Satpam</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="/">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('datasatpam.index') }}">Data Satpam</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Detail Data Satpam</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Detail Data Satpam</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Kode Satpam</label>
                                    <p class="form-control-static">{{ $datasatpam->kode_satpam }}</p>
                                </div>
                                <div class="form-group">
                                    <label>No Induk Pegawai</label>
                                    <p class="form-control-static">{{ $datasatpam->nip }}</p>
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <p class="form-control-static">{{ $datasatpam->nik }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Foto</label><br>
                                    @if ($datasatpam->foto)
                                        <img src="{{ asset('storage/' . $datasatpam->foto) }}" alt="Foto Satpam" style="max-width: 200px;">
                                    @else
                                        <i class="fas fa-user fa-3x"></i>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <p class="form-control-static">{{ $datasatpam->nama }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <p class="form-control-static">{{ $datasatpam->pekerjaan }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <p class="form-control-static">{{ $datasatpam->status }}</p>
                                </div>
                                <div class="form-group">
                                    <label>No PKWT/PKWTT</label>
                                    <p class="form-control-static">{{ $datasatpam->no_pkwt_pkwtt }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Kontrak</label>
                                    <p class="form-control-static">{{ $datasatpam->kontrak }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Terhitung Mulai Tugas</label>
                                    <p class="form-control-static">{{ $datasatpam->terhitung_mulai_tugas }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <p class="form-control-static">{{ $datasatpam->jabatan }}</p>
                                </div>
                                <div class="form-group">
                                    <label>UPT</label>
                                    <p class="form-control-static">{{ optional($datasatpam->lokasikerja->ultg->upt)->nama_upt ?? '-' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>ULTG</label>
                                    <p class="form-control-static">{{ optional($datasatpam->lokasikerja->ultg)->nama_ultg ?? '-' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Lokasi Kerja</label>
                                    <p class="form-control-static">{{ optional($datasatpam->lokasikerja)->nama_lokasikerja ?? '-' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Wilayah Kerja</label>
                                    <p class="form-control-static">{{ $datasatpam->wilayah_kerja }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <p class="form-control-static">{{ $datasatpam->jenis_kelamin }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <p class="form-control-static">{{ $datasatpam->tempat_lahir }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <p class="form-control-static">{{ $datasatpam->tanggal_lahir }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Usia</label>
                                    <p class="form-control-static">{{ $datasatpam->usia }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Warga Negara</label>
                                    <p class="form-control-static">{{ $datasatpam->warga_negara }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Agama</label>
                                    <p class="form-control-static">{{ $datasatpam->agama }}</p>
                                </div>
                                <div class="form-group">
                                    <label>No HP (WA)</label>
                                    <p class="form-control-static">{{ $datasatpam->no_hp }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <p class="form-control-static">{{ $datasatpam->email }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <p class="form-control-static">{{ $datasatpam->alamat }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Kelurahan</label>
                                    <p class="form-control-static">{{ $datasatpam->kelurahan }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <p class="form-control-static">{{ $datasatpam->kecamatan }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Kabupaten/Kota</label>
                                    <p class="form-control-static">{{ $datasatpam->kabupaten }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <p class="form-control-static">{{ $datasatpam->provinsi }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Negara</label>
                                    <p class="form-control-static">{{ $datasatpam->negara }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Nama Ibu</label>
                                    <p class="form-control-static">{{ $datasatpam->nama_ibu }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Kontak Darurat</label>
                                    <p class="form-control-static">{{ $datasatpam->no_kontak_darurat }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Nama Kontak Darurat</label>
                                    <p class="form-control-static">{{ $datasatpam->nama_kontak_darurat }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Nama Ahli Waris</label>
                                    <p class="form-control-static">{{ $datasatpam->nama_ahli_waris }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir Ahli Waris</label>
                                    <p class="form-control-static">{{ $datasatpam->tempat_lahir_ahli_waris }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir Ahli Waris</label>
                                    <p class="form-control-static">{{ $datasatpam->tanggal_lahir_ahli_waris }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Hubungan Ahli Waris</label>
                                    <p class="form-control-static">{{ $datasatpam->hub_ahli_waris }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Status Nikah</label>
                                    <p class="form-control-static">{{ $datasatpam->status_nikah }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Jumlah Anak</label>
                                    <p class="form-control-static">{{ $datasatpam->jumlah_anak }}</p>
                                </div>
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <p class="form-control-static">{{ $datasatpam->npwp }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Nama Bank</label>
                                    <p class="form-control-static">{{ $datasatpam->nama_bank }}</p>
                                </div>
                                <div class="form-group">
                                    <label>No. Rekening</label>
                                    <p class="form-control-static">{{ $datasatpam->no_rek }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Nama Pemilik Rekening</label>
                                    <p class="form-control-static">{{ $datasatpam->nama_pemilik_rek }}</p>
                                </div>
                                <div class="form-group">
                                    <label>No. DPLK</label>
                                    <p class="form-control-static">{{ $datasatpam->no_dplk }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Pendidikan Terakhir</label>
                                    <p class="form-control-static">{{ $datasatpam->pend_terakhir }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Sertifikasi Satpam</label>
                                    <p class="form-control-static">{{ $datasatpam->sertifikasi_satpam }}</p>
                                </div>
                                <div class="form-group">
                                    <label>No. Registrasi KTA Satpam</label>
                                    <p class="form-control-static">{{ $datasatpam->no_reg_kta }}</p>
                                </div>
                                <div class="form-group">
                                    <label>No. KTA</label>
                                    <p class="form-control-static">{{ $datasatpam->no_kta }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Polda</label>
                                    <p class="form-control-static">{{ $datasatpam->polda }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Polres</label>
                                    <p class="form-control-static">{{ $datasatpam->polres }}</p>
                                </div>
                                <div class="form-group">
                                    <label>No. Kartu BPJS Kesehatan</label>
                                    <p class="form-control-static">{{ $datasatpam->no_bpjs_kesehatan }}</p>
                                </div>
                                <div class="form-group">
                                    <label>No. Kartu BPJS Ketenagakerjaan</label>
                                    <p class="form-control-static">{{ $datasatpam->no_bpjs_ketenagakerjaan }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Ukuran Baju</label>
                                    <p class="form-control-static">{{ $datasatpam->ukuran_baju }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Ukuran Celana</label>
                                    <p class="form-control-static">{{ $datasatpam->ukuran_celana }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Ukuran Sepatu</label>
                                    <p class="form-control-static">{{ $datasatpam->ukuran_sepatu }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Ukuran Topi</label>
                                    <p class="form-control-static">{{ $datasatpam->ukuran_topi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="{{ route('datasatpam.index') }}" class="btn btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection