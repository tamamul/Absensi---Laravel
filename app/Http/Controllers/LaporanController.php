<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upt;
use App\Models\Ultg;
use App\Models\Lokasikerja;
use App\Models\Datasatpam;
use App\Models\Absensi;
use App\Models\ValidasiLaporan;
use Carbon\Carbon;
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
        $isValidated = false;

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

            // Cek status validasi
            $validasi = ValidasiLaporan::where([
                'upt_id' => $upt_id,
                'ultg_id' => $ultg_id,
                'lokasikerja_id' => $lokasikerja_id,
                'periode' => Carbon::createFromDate($tahun, $bulan, 1)->format('Y-m-d')
            ])->first();

            $isValidated = $validasi ? $validasi->is_validated : false;
        }

        $userRole = auth()->user()->role;

        return view('laporan.index', compact(
            'allUptNames',
            'ultgs',
            'lokasikerjas',
            'laporan',
            'upt_id',
            'ultg_id',
            'lokasikerja_id',
            'tanggal',
            'isValidated',
            'userRole'
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

    public function validasi(Request $request)
    {
        if (auth()->user()->role !== 'Pimpinan') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk validasi');
        }

        $request->validate([
            'upt_id' => 'required',
            'ultg_id' => 'required',
            'lokasikerja_id' => 'required',
            'tanggal' => 'required'
        ]);

        [$tahun, $bulan] = explode('-', $request->tanggal);
        $periode = Carbon::createFromDate($tahun, $bulan, 1)->format('Y-m-d');

        ValidasiLaporan::updateOrCreate(
            [
                'upt_id' => $request->upt_id,
                'ultg_id' => $request->ultg_id,
                'lokasikerja_id' => $request->lokasikerja_id,
                'periode' => $periode
            ],
            [
                'is_validated' => true,
                'validated_at' => now()
            ]
        );

        return redirect()->back()->with('success', 'Laporan berhasil divalidasi');
    }

    public function exportPDF(Request $request)
    {
        if (auth()->user()->role !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk export PDF');
        }

        $upt_id = $request->upt_id;
        $ultg_id = $request->ultg_id;
        $lokasikerja_id = $request->lokasikerja_id;
        $tanggal = $request->tanggal;

        // Cek validasi
        [$tahun, $bulan] = explode('-', $tanggal);
        $periode = Carbon::createFromDate($tahun, $bulan, 1)->format('Y-m-d');

        $validasi = ValidasiLaporan::where([
            'upt_id' => $upt_id,
            'ultg_id' => $ultg_id,
            'lokasikerja_id' => $lokasikerja_id,
            'periode' => $periode,
            'is_validated' => true
        ])->first();

        if (!$validasi) {
            return redirect()->back()->with('error', 'Laporan belum divalidasi oleh Pimpinan');
        }

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
            'validasi' => $validasi
        ]);

        return $pdf->download('laporan-absensi.pdf');
    }
}
