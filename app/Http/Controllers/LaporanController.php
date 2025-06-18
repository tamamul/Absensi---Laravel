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
use Illuminate\Support\Facades\DB;

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

        // Ambil semua validasi
        $validasiList = \App\Models\ValidasiLaporan::with(['upt', 'ultg', 'lokasikerja'])->get();

        // Ambil semua absensi, group by kombinasi upt, ultg, lokasi, periode
        $absensiList = \App\Models\Absensi::with(['satpam.lokasikerja.ultg.upt'])
            ->get()
            ->filter(function($item) {
                // Pastikan semua relasi tidak null
                return $item->satpam && $item->satpam->lokasikerja && $item->satpam->lokasikerja->ultg && $item->satpam->lokasikerja->ultg->upt;
            })
            ->groupBy(function($item) {
                $satpam = $item->satpam;
                $lokasi = $satpam->lokasikerja;
                $ultg = $lokasi->ultg;
                $upt = $ultg->upt;
                $periode = \Carbon\Carbon::parse($item->tanggal)->format('Y-m-01');
                return implode('-', [
                    $upt->id,
                    $ultg->id,
                    $lokasi->id,
                    $periode
                ]);
            });

        // Gabungkan validasi dan absensi
        $ringkasan = collect();
        foreach ($absensiList as $key => $absensis) {
            [$upt_id, $ultg_id, $lokasikerja_id, $periode] = explode('-', $key);
            $validasi = $validasiList->first(function($v) use ($upt_id, $ultg_id, $lokasikerja_id, $periode) {
                return $v->upt_id == $upt_id && $v->ultg_id == $ultg_id && $v->lokasikerja_id == $lokasikerja_id && $v->periode == $periode;
            });
            $ringkasan->push((object)[
                'upt_id' => $upt_id,
                'ultg_id' => $ultg_id,
                'lokasikerja_id' => $lokasikerja_id,
                'periode' => $periode,
                'is_validated' => $validasi ? $validasi->is_validated : false,
                'upt' => $absensis->first()->satpam->lokasikerja->ultg->upt ?? null,
                'ultg' => $absensis->first()->satpam->lokasikerja->ultg ?? null,
                'lokasikerja' => $absensis->first()->satpam->lokasikerja ?? null,
            ]);
        }
        // Tambahkan data validasi yang tidak ada absensi
        foreach ($validasiList as $v) {
            $key = implode('-', [$v->upt_id, $v->ultg_id, $v->lokasikerja_id, $v->periode]);
            if (!$ringkasan->first(fn($r) => implode('-', [$r->upt_id, $r->ultg_id, $r->lokasikerja_id, $r->periode]) == $key)) {
                $ringkasan->push((object)[
                    'upt_id' => $v->upt_id,
                    'ultg_id' => $v->ultg_id,
                    'lokasikerja_id' => $v->lokasikerja_id,
                    'periode' => $v->periode,
                    'is_validated' => $v->is_validated,
                    'upt' => $v->upt,
                    'ultg' => $v->ultg,
                    'lokasikerja' => $v->lokasikerja,
                ]);
            }
        }
        // Sort by periode terbaru dan unique berdasarkan kombinasi
        $ringkasanLaporan = $ringkasan
            ->sortBy('periode')
            ->unique(function($item) {
                return $item->upt_id.'-'.$item->ultg_id.'-'.$item->lokasikerja_id.'-'.$item->periode;
            })
            ->sortByDesc('periode')
            ->values();

        // Ambil detail laporan jika semua filter diisi
        if ($upt_id && $ultg_id && $lokasikerja_id && $tanggal) {
            [$tahun, $bulan] = explode('-', $tanggal);
            $laporan = Absensi::with('satpam')
                ->whereHas('satpam', function ($q) use ($lokasikerja_id) {
                    $q->where('lokasikerja_id', $lokasikerja_id);
                })
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->get();
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
            'ringkasanLaporan',
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
