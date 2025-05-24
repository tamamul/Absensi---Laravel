@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Tambah Jadwal Satpam</h4>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Jadwal Satpam</div>
        </div>
        <div class="card-body"></div>
        <form action="{{ route('jadwalsatpam.create') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="upt_id">UPT</label>
                <select name="upt_id" id="upt_id" class="form-control" required>
                    <option value="">Pilih UPT</option>
                    @foreach ($upts as $upt)
                        <option value="{{ $upt->id }}" {{ request('upt_id') == $upt->id ? 'selected' : '' }}>{{ $upt->nama_upt }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="ultg_id">ULTG</label>
                <select name="ultg_id" id="ultg_id" class="form-control" required>
                    <option value="">Pilih ULTG</option>
                    @foreach ($ultgs as $ultg)
                        @if ($ultg->upt_id == request('upt_id'))
                            <option value="{{ $ultg->id }}" {{ request('ultg_id') == $ultg->id ? 'selected' : '' }}>{{ $ultg->nama_ultg }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="lokasi_kerja_id">Lokasi Kerja</label>
                <select name="lokasi_kerja_id" id="lokasi_kerja_id" class="form-control" required>
                    <option value="">Pilih Lokasi</option>
                    @foreach ($lokasikerjas as $lokasi)
                        @if ($lokasi->ultg_id == request('ultg_id'))
                            <option value="{{ $lokasi->id }}" {{ request('lokasi_kerja_id') == $lokasi->id ? 'selected' : '' }}>{{ $lokasi->nama_lokasi }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="bulan">Bulan</label>
                <select name="bulan" id="bulan" class="form-control" required>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-1">
                <label for="tahun">Tahun</label>
                <input type="number" name="tahun" id="tahun" class="form-control" value="{{ request('tahun', date('Y')) }}" required>
            </div>
            <div class="col-md-12 mt-2">
                <button type="submit" class="btn btn-primary">Tampilkan Jadwal</button>
            </div>
        </div>
    </form>

    @if (isset($satpams) && count($satpams) > 0)
        <form action="{{ route('jadwalsatpam.store') }}" method="POST">
            @csrf
            <input type="hidden" name="bulan" value="{{ $bulan }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <input type="hidden" name="lokasi_kerja_id" value="{{ $lokasiKerja->id }}">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Satpam</th>
                        @for ($i = 1; $i <= $jumlahHari; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach ($satpams as $satpam)
                        <tr>
                            <td>{{ $satpam->nama }}</td>
                            @for ($i = 1; $i <= $jumlahHari; $i++)
                                <td>
                                    <select name="jadwal[{{ $satpam->id }}][{{ $i }}]" class="form-control">
                                        <option value="">-</option>
                                        <option value="P">P</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                    </select>
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-success">Simpan Jadwal</button>
        </form>
    @endif
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
                url: '/get-ultg/' + uptID,
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
</script>
<!-- 
        $('#ultg_id').on('change', function () {
            let ultgId = $(this).val();
            $('#lokasi_kerja_id').html('<option value="">Loading...</option>');
            if (ultgId) {
                $.get('/get-lokasi/' + ultgId, function (data) {
                    let options = '<option value="">Pilih Lokasi</option>';
                    data.forEach(function (lokasi) {
                        options += `<option value="${lokasi.id}">${lokasi.nama_lokasi}</option>`;
                    });
                    $('#lokasi_kerja_id').html(options);
                });
            }
        });
    });
</script> -->


@endsection