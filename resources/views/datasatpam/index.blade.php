@extends('layouts.master')
@section('title', 'Data Satpam')
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
                    <a href="#">Data Satpam</a>
                </li>
            </ul>
        </div>

        <!-- @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @if (Auth::check() && Auth::user()->role == 'Admin')
                            <a href="{{ route('datasatpam.create') }}" class="btn btn-success">
                                <i class="fa fa-plus-circle"></i>
                                <span>Tambah Data</span>
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Kode</th>
                                        <th>NIP</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Jabatan</th>
                                        <th>Lokasi Kerja</th>
                                        <th>No HP</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataDatasatpam as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @php
                                                    $displayIconInsteadOfImage = false;
                                                    if ($data->foto && !\Illuminate\Support\Str::startsWith((string)$data->foto, 'foto_satpam/')) {
                                                        $displayIconInsteadOfImage = true;
                                                    }
                                                @endphp
                                                @if ($displayIconInsteadOfImage)
                                                    <i class="fas fa-user fa-3x"></i>
                                                @elseif ($data->foto_url)
                                                    <img src="{{ $data->foto_url }}" alt="Foto Satpam"
                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                                @else
                                                    <i class="fas fa-user fa-3x"></i>
                                                @endif
                                            </td>

                                            <td>{{ $data->kode_satpam }}</td>
                                            <td>{{ $data->nip }}</td>
                                            <td>{{ $data->nik }}</td>
                                            <td>{{ $data->nama }}</td>
                                            <td>{{ $data->status }}</td>
                                            <td>{{ $data->jabatan }}</td>
                                            <td>{{ optional($data->lokasikerja)->nama_lokasikerja ?? '-' }}</td>
                                            <td>{{ $data->no_hp }}</td>
                                            @if (Auth::check() && Auth::user()->role == 'Admin')
                                            <td>
                                                <form action="{{ route('datasatpam.delete', $data->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('datasatpam.edit', $data->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                            @endif
                                            @if (Auth::check() && Auth::user()->role == 'Pimpinan')
                                            <td>
                                                <a href="{{ route('datasatpam.detail', $data->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fa fa-eye"></i> Detail
                                                </a>
                                            </td>
                                            @endif
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
