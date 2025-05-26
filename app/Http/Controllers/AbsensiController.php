<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datasatpam;
use App\Models\Absensi; // Pastikan model Absensi sudah ada
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $satpams = Datasatpam::all();
        $selectedSatpam = $request->satpam_id;
        $bulan = $request->bulan ?? date('n');
        $tahun = $request->tahun ?? date('Y');
        $absensi = [];

        if ($selectedSatpam) {
            $rows = Absensi::where('satpam_id', $selectedSatpam)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();

            foreach ($rows as $row) {
                $absensi[date('Y-m-d', strtotime($row->tanggal))] = $row->status;
            }
        }

        return view('riwayat.index', compact(
            'satpams',
            'selectedSatpam',
            'bulan',
            'tahun',
            'absensi'
        ));
    }

    public function laporan(Request $request)
    {
        // Ambil semua UPT untuk select option
        $allUptNames = \App\Models\Upt::all();

        // Data awal kosong
        $laporan = [];

        // Ambil filter dari request
        $upt_id = $request->upt_id;
        $ultg_id = $request->ultg_id;
        $lokasikerja_id = $request->lokasikerja_id;
        $tanggal = $request->tanggal; // format: YYYY-MM

        // Query ULTG dan Lokasi Kerja dinamis untuk select option (AJAX lebih baik, tapi bisa juga di sini)
        $ultgs = $upt_id ? \App\Models\Ultg::where('upt_id', $upt_id)->get() : [];
        $lokasikerjas = $ultg_id ? \App\Models\Lokasikerja::where('ultg_id', $ultg_id)->get() : [];

        // Jika semua filter terisi, ambil data laporan absensi
        if ($upt_id && $ultg_id && $lokasikerja_id && $tanggal) {
            [$tahun, $bulan] = explode('-', $tanggal);

            $laporan = \App\Models\Absensi::whereHas('satpam', function($q) use ($lokasikerja_id) {
                    $q->where('lokasikerja_id', $lokasikerja_id);
                })
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->get();
        }

        return view('laporan.index', compact(
            'allUptNames',
            'ultgs',
            'lokasikerjas',
            'laporan',
            'upt_id',
            'ultg_id',
            'lokasikerja_id',
            'tanggal'
        ));
    }
}
