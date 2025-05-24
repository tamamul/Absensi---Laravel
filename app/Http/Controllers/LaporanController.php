<?php

namespace App\Http\Controllers;

use App\Models\Datasatpam;
use Illuminate\Http\Request;
use App\Models\ULTG;
use App\Models\LokasiKerja;
use App\Models\Satpam;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        $ultgs = ULTG::all();
        return view('laporan.index', compact('ultgs'));
    }

    public function getLokasiKerja($ultg_id)
    {
        $lokasi = LokasiKerja::where('ultg_id', $ultg_id)->get();
        return response()->json($lokasi);
    }

    public function view(Request $request)
    {
        $request->validate([
            'ultg_id' => 'required',
            'lokasi_id' => 'required',
            'bulan' => 'required',
        ]);

        $laporan = Datasatpam::where('ultg_id', $request->ultg_id)
                         ->where('lokasi_id', $request->lokasi_id)
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
        $laporan = Datasatpam::where('ultg_id', $request->ultg_id)
                         ->where('lokasi_id', $request->lokasi_id)
                         ->whereMonth('tanggal', '=', date('m', strtotime($request->bulan)))
                         ->whereYear('tanggal', '=', date('Y', strtotime($request->bulan)))
                         ->get();

        $pdf = PDF::loadView('laporan.pdf', ['laporan' => $laporan, 'bulan' => $request->bulan]);
        return $pdf->download('laporan.pdf');
    }
}
