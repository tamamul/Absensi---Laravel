@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

<div class="page-inner">
    <div class="page-header">
    <h4 class="page-title">Jadwal Satpam</h4>
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
          <a href="/tambahjadwalsatpam" class="btn btn-success" >
            <div class="fa fa-plus-circle"></div>
        <span class="d-none d-lg-block" style="float: right;  margin-left:3px;"> Tambah Data</span>
        </a>
        </div>
                <div class="card-header">
                    <div class="container">
    <div class="card">
        <div class="card-header bg-light">
            <strong>Select Data</strong>
        </div>
        <div class="card-body">
            <form method="GET" action="">
                <div class="row">
                    <div class="col-md-4">
                        <label for="nama_upt">Nama UPT</label>
                        <select id="nama_upt" name="nama_upt" class="form-control">
                            <option value="">Choose...</option>
                            <!-- Tambahkan opsi dari database -->
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="nama_ultg">Nama ULTG</label>
                        <select id="nama_ultg" name="nama_ultg" class="form-control">
                            <option value="">Choose...</option>
                            <!-- Tambahkan opsi dari database -->
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal">Bulan - Tahun</label>
                        <input type="month" class="form-control" id="tanggal" name="tanggal">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">View</button>
                </div>
            </form>
        </div>
    </div>
    
</div>
<div class="card-body">
          <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Id Jadwal</th>
                  <th>Nama Lokasi Kerja</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              {{-- <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Age</th>
                  <th>Start date</th>
                  <th>Salary</th>
                </tr>
              </tfoot> --}}
              <tbody>
                <tr>
                  <td>1</td>
                  <td>2309.244.001</td>
                  <td>GI Manisrejo 170KV</td>
                  <td>
                  <button class="btn btn-warning">Edit</button>
                  <button class="btn btn-danger">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>                
</div>
            </div>
        </div>
    </div>
    

@endsection