@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

    <div class="page-inner">

        <div class="page-header">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <h4 class="page-title">Data UPT</h4>
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ url('/') }}">H o m e</a> / Data UPT
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <h4 class="card-title">Basic</h4> -->
                        <a href="{{ route('upt.create') }}" class="btn btn-success">
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
                                        <th>Kode UPT</th>
                                        <TH>Nama UPT</TH>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($dataUpt as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->kode_upt }}</td>
                                            <td>{{ $data->nama_upt }}</td>
                                            <td>
                                                <form action="{{ route('upt.delete', $data->id) }}" method="post">@csrf
                                                    <a href="{{ route('upt.edit', $data->id) }}"
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
