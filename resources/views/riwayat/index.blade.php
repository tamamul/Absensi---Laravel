@extends('layouts.master')
@section('title', 'Riwayat Absensi')
@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Riwayat Absensi Satpam</h4>
    </div>
    <div class="card">
        <div class="card-header">
            <form method="GET" action="">
                <div class="row">
                    <div class="col-md-3">
                        <label for="nama_upt">Nama UPT</label>
                        <select class="form-control" id="nama_upt" name="upt_id">
                            <option value="">Pilih Nama UPT</option>
                            @foreach ($allUptNames as $item)
                                <option value="{{ $item->id }}" {{ old('upt_id', $upt_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_upt }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="nama_ultg">Nama ULTG</label>
                        <select class="form-control" id="nama_ultg" name="ultg_id">
                            <option value="">Pilih Nama ULTG</option>
                            @foreach ($ultgs as $ultg)
                                <option value="{{ $ultg->id }}" {{ old('ultg_id', $ultg_id) == $ultg->id ? 'selected' : '' }}>
                                    {{ $ultg->nama_ultg }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="nama_lokasikerja">Nama Lokasi Kerja</label>
                        <select class="form-control" id="nama_lokasikerja" name="lokasikerja_id">
                            <option value="">Pilih Nama Lokasi Kerja</option>
                            @foreach ($lokasikerjas as $lokasi)
                                <option value="{{ $lokasi->id }}" {{ old('lokasikerja_id', $lokasikerja_id) == $lokasi->id ? 'selected' : '' }}>
                                    {{ $lokasi->nama_lokasikerja }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="satpam_id">Pilih Satpam</label>
                        <select name="satpam_id" id="satpam_id" class="form-control" required>
                            <option value="">-- Pilih Satpam --</option>
                            @foreach($satpams as $satpam)
                                <option value="{{ $satpam->id }}" {{ request('satpam_id', $selectedSatpam) == $satpam->id ? 'selected' : '' }}>
                                    {{ $satpam->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" id="bulan" class="form-control" required>
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}" {{ request('bulan', $bulan) == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control" required>
                            @for($y = date('Y')-2; $y <= date('Y')+1; $y++)
                                <option value="{{ $y }}" {{ request('tahun', $tahun) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if($selectedSatpam)
            <div class="table-responsive">
                <table class="table table-bordered text-center" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $hari)
                                <th>{{ $hari }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $start = Carbon\Carbon::create($tahun, $bulan, 1);
                            $end = $start->copy()->endOfMonth();
                            $firstDayOfWeek = $start->dayOfWeek; // 0=Min, 1=Sen, dst
                            $daysInMonth = $start->daysInMonth;
                            $day = 1;
                        @endphp
                        <tr>
                        @for($i=0; $i<$firstDayOfWeek; $i++)
                            <td></td>
                        @endfor
                        @for($i=$firstDayOfWeek; $i<7; $i++)
                            <td>
                                <div><strong>{{ $day }}</strong></div>
                                <div>
                                    {{ $absensi[$start->copy()->day($day)->toDateString()] ?? '-' }}
                                </div>
                            </td>
                            @php $day++; @endphp
                        @endfor
                        </tr>
                        @while($day <= $daysInMonth)
                            <tr>
                                @for($i=0; $i<7; $i++)
                                    @if($day > $daysInMonth)
                                        <td></td>
                                    @else
                                        <td>
                                            <div><strong>{{ $day }}</strong></div>
                                            <div>
                                                {{ $absensi[$start->copy()->day($day)->toDateString()] ?? '-' }}
                                            </div>
                                        </td>
                                        @php $day++; @endphp
                                    @endif
                                @endfor
                            </tr>
                        @endwhile
                    </tbody>
                </table>
            </div>
            @else
                <div class="alert alert-info">Silakan pilih satpam dan periode untuk melihat riwayat absensi.</div>
            @endif
        </div>
    </div>
</div>

{{-- AJAX Script --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // UPT -> ULTG
    $('#nama_upt').on('change', function() {
        var uptID = $(this).val();
        $('#nama_ultg').html('<option value="">Pilih Nama ULTG</option>');
        $('#nama_lokasikerja').html('<option value="">Pilih Nama Lokasi Kerja</option>');
        $('#satpam_id').html('<option value="">-- Pilih Satpam --</option>');
        if (uptID) {
            $.get('/get-ultg/' + uptID, function(data) {
                $.each(data, function(id, nama) {
                    $('#nama_ultg').append('<option value="' + id + '">' + nama + '</option>');
                });
            });
        }
    });

    // ULTG -> Lokasi Kerja
    $('#nama_ultg').on('change', function() {
        var ultgID = $(this).val();
        $('#nama_lokasikerja').html('<option value="">Pilih Nama Lokasi Kerja</option>');
        $('#satpam_id').html('<option value="">-- Pilih Satpam --</option>');
        if (ultgID) {
            $.get('/get-lokasi/' + ultgID, function(data) {
                $.each(data, function(index, item) {
                    $('#nama_lokasikerja').append('<option value="' + index + '">' + item + '</option>');
                });
            });
        }
    });

    // Lokasi Kerja -> Satpam
    $('#nama_lokasikerja').on('change', function() {
        var lokasiID = $(this).val();
        $('#satpam_id').html('<option value="">-- Pilih Satpam --</option>');
        if (lokasiID) {
            $.get('/get-satpam/' + lokasiID, function(data) {
                $.each(data, function(id, nama) {
                    $('#satpam_id').append('<option value="' + id + '">' + nama + '</option>');
                });
            });
        }
    });

    // Saat reload, jika sudah ada upt/ultg terpilih, isi ulang select option via AJAX
    $(document).ready(function() {
        var uptID = $('#nama_upt').val();
        var ultgID = "{{ old('ultg_id', $ultg_id) }}";
        var lokasiID = "{{ old('lokasikerja_id', $lokasikerja_id) }}";

        if (uptID && $('#nama_ultg option').length <= 1) {
            $.get('/get-ultg/' + uptID, function(data) {
                $.each(data, function(id, nama) {
                    var selected = (id == ultgID) ? 'selected' : '';
                    $('#nama_ultg').append('<option value="' + id + '" ' + selected + '>' + nama + '</option>');
                });
                if (ultgID) {
                    // Isi lokasi kerja jika ultg sudah terpilih
                    $.get('/get-lokasi/' + ultgID, function(data) {
                        $.each(data, function(index, item) {
                            var selected = (index == lokasiID) ? 'selected' : '';
                            $('#nama_lokasikerja').append('<option value="' + index + '" ' + selected + '>' + item + '</option>');
                        });
                        if (lokasiID) {
                            // Isi satpam jika lokasi kerja sudah terpilih
                            $.get('/get-satpam/' + lokasiID, function(data) {
                                $.each(data, function(id, nama) {
                                    var selected = (id == "{{ $selectedSatpam }}") ? 'selected' : '';
                                    $('#satpam_id').append('<option value="' + id + '" ' + selected + '>' + nama + '</option>');
                                });
                            });
                        }
                    });
                }
            });
        }
    });
</script>
@endsection