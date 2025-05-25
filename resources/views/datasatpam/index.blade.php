@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Data Satpam</h4>
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
        <a href="#">Tables</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <!-- <h4 class="card-title">Basic</h4> -->
          @if(Auth::check() && Auth::user()->role == 'Admin')
          <a href="{{route('datasatpam.create')}}" class="btn btn-success" >
            <div class="fa fa-plus-circle"></div>
        <span class="d-none d-lg-block" style="float: right;  margin-left:3px;"> Tambah Data</span>
        </a>
          @endif
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>NIP</th>
                  <th>NIK KTP</th>
                  <th>Foto</th>
                  <th>Nama Lengkap</th>
                  <th>Pekerjaan</th>
                  <th>Status</th>
                  <th>No (PKWT/PKWTT)</th>
                  <th>Kontrak</th>
                  <th>Terhitung Mulai Tugas</th>
                  <th>Jabatan</th>
                  <th>UPT</th>
                  <th>ULTG</th>
                  <th>Lokasi Kerja</th>
                  <th>Wilayah Kerja</th>
                  <th>Jenis Kelamin</th>
                  <th>Tempat Lahir</th>
                  <th>Tanggal Lahir</th>
                  <th>Usia</th>
                  <th>Warga Negara</th>
                  <th>Agama</th>
                  <th>No Hp (WA)</th>
                  <th>Email</th>
                  <th>Alamat</th>
                  <th>Kelurahan</th>
                  <th>Kecamatan</th>
                  <th>Kabupaten/Kota</th>
                  <th>Provinsi</th>
                  <th>Negara</th>
                  <th>Nama Ibu</th>
                  <th>No Kontak Darurat</th>
                  <th>Nama Kontak Darurat</th>
                  <th>Nama Ahli Waris</th>
                  <th>Tempat Lahir Ahli Waris</th>
                  <th>Tanggal Lahir Ahli Waris</th>
                  <th>Hubungan Ahli Waris</th>
                  <th>Status Nikah</th>
                  <th>Jumlah Anak</th>
                  <th>NPWP</th>
                  <th>Nama Bank</th>
                  <th>No Rekening</th>
                  <th>Nama Pemilik Rekening</th>
                  <th>No DPLK</th>
                  <th>Pendidikan Terakhir</th>
                  <th>Sertifikasi Satpam</th>
                  <th>No Registrasi KTA Satpam</th>
                  <th>No KTA</th>
                  <th>Polda</th>
                  <th>Polres</th>
                  <th>No Kartu BPJS Kesehatan</th>
                  <th>No Kartu BPJS Ketenagakerjaan</th>
                  <th>Ukuran Baju</th>
                  <th>Ukuran Celana</th>
                  <th>Ukuran Sepatu</th>
                  <th>Ukuran Topi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              
              <tbody>
                @foreach ($dataDatasatpam as $data)
               
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $data->nip }}</td>
                  <td>{{ $data->nik }}</td>
                  <td>{{ $data->foto }}</td>
                  <td>{{ $data->nama_lengkap }}</td>
                  <td>{{ $data->pekerjaan }}</td>
                  <td>{{ $data->status }}</td>
                  <td>{{ $data->no_pkwt_pkwtt }}</td>
                  <td>{{ $data->kontrak }}</td>
                  <td>{{ $data->terhitung_mulai_tugas }}</td>
                  <td>{{ $data->jabatan }}</td>
                  <td>{{ $data->upt_id }}</td>
                  <td>{{ $data->ultg_id }}</td>
                  <td>{{ $data->lokasikerja_id }}</td>
                  <td>{{ $data->wilayah_kerja }}</td>
                  <td>{{ $data->jenis_kelamin }}</td>
                  <td>{{ $data->tempat_lahir }}</td>
                  <td>{{ $data->tanggal_lahir }}</td>
                  <td>{{ $data->usia }}</td>
                  <td>{{ $data->warga_negara }}</td>
                  <td>{{ $data->agama }}</td>
                  <td>{{ $data->no_hp }}</td>
                  <td>{{ $data->email }}</td>
                  <td>{{ $data->alamat }}</td>
                  <td>{{ $data->kelurahan }}</td>
                  <td>{{ $data->kecamatan }}</td>
                  <td>{{ $data->kabupaten_kota }}</td>
                  <td>{{ $data->provinsi }}</td>
                  <td>{{ $data->negara }}</td>
                  <td>{{ $data->nama_ibu }}</td>
                  <td>{{ $data->no_kontak_darurat }}</td>
                  <td>{{ $data->nama_kontak_darurat }}</td>
                  <td>{{ $data->nama_ahli_waris }}</td>
                  <td>{{ $data->tempat_lahir_ahli_waris }}</td>
                  <td>{{ $data->tanggal_lahir_ahli_waris }}</td>
                  <td>{{ $data->hub_ahli_waris }}</td>
                  <td>{{ $data->status_nikah }}</td>
                  <td>{{ $data->jumlah_anak }}</td>
                  <td>{{ $data->npwp }}</td>
                  <td>{{ $data->nama_bank }}</td>
                  <td>{{ $data->no_reg_kta }}</td>
                  <td>{{ $data->nama_pemilik_rek }}</td>
                  <td>{{ $data->no_dplk }}</td>
                  <td>{{ $data->pend_terakhir }}</td>
                  <td>{{ $data->sertifikasi_satpam }}</td>
                  <td>{{ $data->no_reg_kta }}</td>
                  <td>{{ $data->no_kta }}</td>
                  <td>{{ $data->polda }}</td>
                  <td>{{ $data->polres }}</td>
                  <td>{{ $data->no_bpjs_kesehatan }}</td>
                  <td>{{ $data->no_bpjs_ketenagakerjaan }}</td>
                  <td>{{ $data->ukuran_baju }}</td>
                  <td>{{ $data->ukuran_celana }}</td>
                  <td>{{ $data->ukuran_sepatu }}</td>
                  <td>{{ $data->ukuran_topi }}</td>
                  <td>
                  <!-- <button class="btn btn-primary">Detail</button> -->
                  <form action="{{ route('datasatpam.delete', $data->id) }}" method="post">@csrf
                  <a href="{{ route('datasatpam.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                  <button class="btn btn-danger">Delete</button>
                  </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection