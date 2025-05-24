@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

<div class="panel-header">
  <div class="page-inner py-5">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
      <div>
        <h1 class="text-black pb-2 fw-bold">Dashboard</h1>
        {{-- <h5 class="text-white op-7 mb-2">Free Bootstrap 4 Admin Dashboard</h5> --}}
        
      </div>
    </div>
  </div>
  
</div>
<div class="page-inner mt--5">
  <div class="row">
    <div class="col-sm-6 col-md-3">
      <div class="card card-stats card-round">
        <div class="card-body ">
          <div class="row align-items-center">
            <div class="col-icon">
              <div class="icon-big text-center icon-primary bubble-shadow-small">
                <i class="flaticon-users"></i>
              </div>
            </div>
            <div class="col col-stats ml-3 ml-sm-0">
              <div class="numbers">
                <p class="card-category">TOTAL SATPAM</p>
                <h4 class="card-title">{{ $totalDatasatpam }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="card card-stats card-round">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-icon">
              <div class="icon-big text-center icon-info bubble-shadow-small">
                <i class="flaticon-interface-6"></i>
              </div>
            </div>
            <div class="col col-stats ml-3 ml-sm-0">
              <div class="numbers">
                <p class="card-category">TOTAL LOKASI KERJA</p>
                <h4 class="card-title">{{ $totalLokasikerja }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="card card-stats card-round">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-icon">
              <div class="icon-big text-center icon-success bubble-shadow-small">
                <i class="flaticon-graph"></i>
              </div>
            </div>
            <div class="col col-stats ml-3 ml-sm-0">
              <div class="numbers">
                <p class="card-category">TOTAL JADWAL SATPAM</p>
                <h4 class="card-title">{{ $totalJadwalsatpam }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- <div class="col-sm-6 col-md-3">
      <div class="card card-stats card-round">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-icon">
              <div class="icon-big text-center icon-secondary bubble-shadow-small"> -->
                <!-- <i class="flaticon-success"></i>
              </div>
            </div>
            <div class="col col-stats ml-3 ml-sm-0">
              <div class="numbers">
                <p class="card-category">Order</p>
                <h4 class="card-title">576</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <!-- <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Our Location</div>
        </div>
        <div class="card-body">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126486.00307160348!2d111.93549476919391!3d-7.822852935109783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78570dfd6e0647%3A0xb6187ba9ae7d9cbd!2sKota%20Kediri%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1731247289793!5m2!1sid!2sid"
            width="600"
            height="450"
            style="border: 0; width: 100%"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      </div>
    </div>
  </div> -->
</div>

@endsection