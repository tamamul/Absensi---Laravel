<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Satpam</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Laporan Absensi Satpam</h3>
    <table>
        <thead>
            <tr>
                <th>Kode Satpam</th>
                <th>Nama Satpam</th>
                <th>Lokasi Kerja</th>
                <th>Total Masuk</th>
                <th>Terlambat</th>
                <th>Ijin</th>
                <th>Sakit</th>
                <th>Alpha</th>
            </tr>
        </thead>
        <tbody>
            @php $grouped = $laporan->groupBy('satpam_id'); @endphp
            @foreach ($grouped as $satpam_id => $absensis)
                @php
                    $satpam = $absensis->first()->satpam ?? null;
                    $lokasi = $satpam->lokasikerja->nama_lokasikerja ?? '-';
                    $total_masuk = $absensis->where('status', 'hadir')->count();
                    $terlambat = $absensis->where('status', 'terlambat')->count();
                    $ijin = $absensis->where('status', 'ijin')->count();
                    $sakit = $absensis->where('status', 'sakit')->count();
                    $alpha = $absensis->where('status', 'alpha')->count();
                @endphp
                <tr>
                    <td>{{ $satpam->kode_satpam }}</td>
                    <td>{{ $satpam->nama ?? '-' }}</td>
                    <td>{{ $lokasi }}</td>
                    <td>{{ $total_masuk }}</td>
                    <td>{{ $terlambat }}</td>
                    <td>{{ $ijin }}</td>
                    <td>{{ $sakit }}</td>
                    <td>{{ $alpha }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>