<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upt;
use App\Models\Ultg;
use App\Models\Lokasikerja;
use App\Models\Datasatpam;
use App\Models\Absensi;
use PDF;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $allUptNames = Upt::all();
        $ultgs = [];
        $lokasikerjas = [];
        $laporan = [];
        $upt_id = $request->upt_id;
        $ultg_id = $request->ultg_id;
        $lokasikerja_id = $request->lokasikerja_id;
        $tanggal = $request->tanggal;

        if ($upt_id) {
            $ultgs = Ultg::where('upt_id', $upt_id)->get();
        }
        if ($ultg_id) {
            $lokasikerjas = Lokasikerja::where('ultg_id', $ultg_id)->get();
        }

        if ($upt_id && $ultg_id && $lokasikerja_id && $tanggal) {
            [$tahun, $bulan] = explode('-', $tanggal);

            $laporan = Absensi::whereHas('satpam', function ($q) use ($lokasikerja_id) {
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

    public function getUltg($upt_id)
    {
        $ultgs = Ultg::where('upt_id', $upt_id)->pluck('nama_ultg', 'id');
        return response()->json($ultgs);
    }

    public function getLokasiKerja($ultg_id)
    {
        $lokasi = Lokasikerja::where('ultg_id', $ultg_id)->get();
        return response()->json($lokasi);
    }

    // Jika ingin hasil laporan di halaman terpisah
    public function view(Request $request)
    {
        $request->validate([
            'ultg_id' => 'required',
            'lokasi_id' => 'required',
            'bulan' => 'required',
        ]);

        $laporan = Absensi::whereHas('satpam', function ($q) use ($request) {
            $q->where('lokasikerja_id', $request->lokasi_id)
                ->where('ultg_id', $request->ultg_id);
        })
            ->whereMonth('tanggal', '=', date('m', strtotime($request->bulan)))
            ->whereYear('tanggal', '=', date('Y', strtotime($request->bulan)))
            ->get();

        return view('laporan.hasil', [
            'laporan' => $laporan,
            'bulan' => $request->bulan,
        ]);
    }

    public function exportPDF(Request $request)
    {
        $upt_id = $request->upt_id;
        $ultg_id = $request->ultg_id;
        $lokasikerja_id = $request->lokasikerja_id;
        $tanggal = $request->tanggal;

        $allUptNames = Upt::all();
        $ultgs = $ultg_id ? Ultg::where('upt_id', $upt_id)->get() : [];
        $lokasikerjas = $lokasikerja_id ? Lokasikerja::where('ultg_id', $ultg_id)->get() : [];
        $laporan = [];

        if ($upt_id && $ultg_id && $lokasikerja_id && $tanggal) {
            [$tahun, $bulan] = explode('-', $tanggal);

            $laporan = Absensi::whereHas('satpam', function ($q) use ($lokasikerja_id) {
                $q->where('lokasikerja_id', $lokasikerja_id);
            })
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->get();
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.export', [
            'laporan' => $laporan,
            'allUptNames' => $allUptNames,
            'ultgs' => $ultgs,
            'lokasikerjas' => $lokasikerjas,
            'upt_id' => $upt_id,
            'ultg_id' => $ultg_id,
            'lokasikerja_id' => $lokasikerja_id,
            'tanggal' => $tanggal,
        ]);

        return $pdf->download('laporan-absensi.pdf');
    }
}
