@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Data Lokasi</h4>
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
                        <a href="{{ route('lokasikerja.create') }}" class="btn btn-success">
                            <div class="fa fa-plus-circle"></div>
                            <span class="d-none d-lg-block" style="float: right;  margin-left:3px;"> Tambah Data</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Lokasi</th>
                                        <th>Nama UPT</th>
                                        <th>Nama ULTG</th>
                                        <th>Nama Lokasi Kerja</th>
                                        <th>Latitude</th>
                                        <th>Longitute</th>
                                        <th>Radius</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataLokasikerja as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->kode_loker }}</td>
                                            <td>{{ $data->ultg->upt->nama_upt }}</td>
                                            <td>{{ $data->ultg->nama_ultg }}</td>
                                            <td>{{ $data->nama_lokasikerja }}</td>
                                            <td>{{ $data->latitude }}</td>
                                            <td>{{ $data->longitude }}</td>
                                            <td>{{ $data->radius }}</td>
                                            <td>
                                                <form action="{{ route('lokasikerja.delete', $data->id) }}" method="post">
                                                    @csrf
                                                    <a href="{{ route('lokasikerja.edit', $data->id) }}"
                                                        class="btn btn-warning">Edit</a>
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
