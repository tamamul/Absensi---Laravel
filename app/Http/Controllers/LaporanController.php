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

        // Ambil semua validasi yang sudah divalidasi
        $validasiList = DB::table('validasi_laporan')
            ->where('is_validated', 1)
            ->get();

        // Ambil semua absensi, group by kombinasi upt, ultg, lokasi, periode
        $absensiList = DB::table('absensi')
            ->select(
                'upt.id as upt_id',
                'ultg.id as ultg_id', 
                'lokasikerja.id as lokasikerja_id',
                DB::raw('DATE_FORMAT(tanggal, "%Y-%m-01") as periode'),
                'upt.nama_upt',
                'ultg.nama_ultg',
                'lokasikerja.nama_lokasikerja'
            )
            ->join('datasatpam', 'absensi.satpam_id', '=', 'datasatpam.id')
            ->join('lokasikerja', 'datasatpam.lokasikerja_id', '=', 'lokasikerja.id')
            ->join('ultg', 'lokasikerja.ultg_id', '=', 'ultg.id')
            ->join('upt', 'ultg.upt_id', '=', 'upt.id')
            ->groupBy('upt.id', 'ultg.id', 'lokasikerja.id', DB::raw('DATE_FORMAT(tanggal, "%Y-%m-01")'))
            ->get();

        // Gabungkan validasi dan absensi
        $ringkasan = collect();
        foreach ($absensiList as $absensi) {
            $periode = Carbon::createFromFormat('Y-m-d', $absensi->periode)->format('Y-m-d');
            
            // Cek validasi
            $isValidated = $validasiList->contains(function($validasi) use ($absensi, $periode) {
                return $validasi->upt_id == $absensi->upt_id 
                    && $validasi->ultg_id == $absensi->ultg_id 
                    && $validasi->lokasikerja_id == $absensi->lokasikerja_id 
                    && $validasi->periode == $periode;
            });

            $ringkasan->push((object)[
                'upt_id' => $absensi->upt_id,
                'ultg_id' => $absensi->ultg_id,
                'lokasikerja_id' => $absensi->lokasikerja_id,
                'periode' => $absensi->periode,
                'is_validated' => $isValidated,
                'upt' => (object)['id' => $absensi->upt_id, 'nama_upt' => $absensi->nama_upt],
                'ultg' => (object)['id' => $absensi->ultg_id, 'nama_ultg' => $absensi->nama_ultg],
                'lokasikerja' => (object)['id' => $absensi->lokasikerja_id, 'nama_lokasikerja' => $absensi->nama_lokasikerja],
            ]);
        }

        // Sort by periode terbaru dan pastikan unik
        $ringkasanLaporan = $ringkasan
            ->unique(function($item) {
                return $item->upt_id . '-' . $item->ultg_id . '-' . $item->lokasikerja_id . '-' . $item->periode;
            })
            ->sortByDesc('periode')
            ->values();

        // Ambil detail laporan jika filter lokasi kerja dan tanggal diisi
        if ($lokasikerja_id && $tanggal) {
            [$tahun, $bulan] = explode('-', $tanggal);
            $periode = Carbon::createFromDate($tahun, $bulan, 1)->format('Y-m-d');

            $laporan = \App\Models\Absensi::with('satpam')
                ->whereHas('satpam', function ($q) use ($lokasikerja_id) {
                    $q->where('lokasikerja_id', $lokasikerja_id);
                })
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->get();

            // Cek validasi
            $validasi = DB::table('validasi_laporan')
                ->where('upt_id', $upt_id)
                ->where('ultg_id', $ultg_id)
                ->where('lokasikerja_id', $lokasikerja_id)
                ->where('periode', $periode)
                ->where('is_validated', 1)
                ->exists();

            $isValidated = $validasi;
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
