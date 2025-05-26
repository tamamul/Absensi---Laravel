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
                    <div class="col-md-4">
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
                    <div class="col-md-2">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" id="bulan" class="form-control" required>
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}" {{ request('bulan', $bulan) == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control" required>
                            @for($y = date('Y')-2; $y <= date('Y')+1; $y++)
                                <option value="{{ $y }}" {{ request('tahun', $tahun) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 align-self-end">
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
@endsection