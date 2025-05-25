<?php

namespace App\Http\Controllers;

use App\Models\Datasatpam;
use Illuminate\Http\Request;
use App\Models\Upt;
use App\Models\Ultg;
use App\Models\Lokasikerja;
use App\Models\Jadwalsatpam;

class JadwalsatpamController extends Controller
{
    public function index(Request $request)
    {
        $upts = \App\Models\Upt::all();
        $ultgs = \App\Models\Ultg::all();
        $lokasikerjas = \App\Models\Lokasikerja::all();

        $jadwalsatpams = \App\Models\Jadwalsatpam::with(['datasatpam.lokasikerja.ultg.upt']);

        if ($request->filled('upt_id')) {
            $ultgIds = \App\Models\Ultg::where('upt_id', $request->upt_id)->pluck('id');
            $lokasiIds = \App\Models\Lokasikerja::whereIn('ultg_id', $ultgIds)->pluck('id');
            $satpamIds = \App\Models\Datasatpam::whereIn('lokasikerja_id', $lokasiIds)->pluck('id');
            $jadwalsatpams->whereIn('satpam_id', $satpamIds);
        }

        if ($request->filled('ultg_id')) {
            $lokasiIds = \App\Models\Lokasikerja::where('ultg_id', $request->ultg_id)->pluck('id');
            $satpamIds = \App\Models\Datasatpam::whereIn('lokasikerja_id', $lokasiIds)->pluck('id');
            $jadwalsatpams->whereIn('satpam_id', $satpamIds);
        }

        if ($request->filled('lokasikerja_id')) {
            $satpamIds = \App\Models\Datasatpam::where('lokasikerja_id', $request->lokasikerja_id)->pluck('id');
            $jadwalsatpams->whereIn('satpam_id', $satpamIds);
        }

        if ($request->filled('bulan_tahun')) {
            [$tahun, $bulan] = explode('-', $request->bulan_tahun);
            $jadwalsatpams->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan);
        }

        $jadwalsatpams = $jadwalsatpams->orderBy('tanggal', 'desc')->get();

        return view('jadwalsatpam.index', compact(
            'jadwalsatpams',
            'upts',
            'ultgs',
            'lokasikerjas'
        ));
    }
    public function create(Request $request)
    {
        $upts = Upt::all();
        $ultgs = Ultg::all();
        $lokasikerjas = Lokasikerja::all();
        $satpamList = [];

        // List satpam berdasarkan lokasi kerja jika sudah dipilih
        if ($request->filled('lokasikerja_id')) {
            $satpamList = Datasatpam::where('lokasikerja_id', $request->lokasikerja_id)->get();
        }

        // Cek jika filter satpam dipilih, ambil satpam yang dipilih saja
        $selectedSatpam = null;
        if ($request->filled('satpam_id')) {
            $selectedSatpam = Datasatpam::find($request->satpam_id);
        }

        $jadwalData = [];
        if ($request->filled(['satpam_id', 'bulan', 'tahun'])) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;

            // Ambil jadwal hanya untuk satu satpam yang dipilih
            $jadwalRows = Jadwalsatpam::where('satpam_id', $request->satpam_id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();

            // Mapping: [tanggal] = shift
            foreach ($jadwalRows as $jadwal) {
                $jadwalData[$jadwal->tanggal] = $jadwal->shift;
            }
        }

        return view('jadwalsatpam.create', [
            'upts' => $upts,
            'ultgs' => $ultgs,
            'lokasikerjas' => $lokasikerjas,
            'satpamList' => $satpamList,
            'selectedUpt' => $request->upt_id,
            'selectedUltg' => $request->ultg_id,
            'selectedLokasikerja' => $request->lokasikerja_id,
            'selectedSatpam' => $request->satpam_id,
            'selectedBulan' => $request->bulan,
            'selectedTahun' => $request->tahun,
            'jadwalData' => $jadwalData,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lokasikerja_id' => 'required|exists:lokasikerja,id',
            'satpam_id' => 'required|exists:datasatpam,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2100',
            'jadwal' => 'required|array',
        ]);

        foreach ($request->jadwal as $tanggal => $shift) {
            if ($shift) {
                $fullDate = sprintf('%04d-%02d-%02d', $request->tahun, $request->bulan, $tanggal);
                Jadwalsatpam::updateOrCreate(
                    [
                        'satpam_id' => $request->satpam_id,
                        'tanggal' => $fullDate,
                    ],
                    [
                        'shift' => $shift,
                    ]
                );
            }
        }
        return redirect()->route('jadwalsatpam.create')->with('success', 'Jadwal berhasil disimpan.');
    }

    // ULTG berdasarkan UPT
    public function getUltg($uptId)
    {
        // Pluck: key = id, value = nama_ultg
        $ultgs = Ultg::where('upt_id', $uptId)->pluck('nama_ultg', 'id');
        return response()->json($ultgs);
    }

    // Lokasi Kerja berdasarkan ULTG
    public function getLokasiKerja($ultgId)
    {
        // Pluck: key = id, value = nama_lokasikerja
        $lokasikerjas = Lokasikerja::where('ultg_id', $ultgId)->pluck('nama_lokasikerja', 'id');
        return response()->json($lokasikerjas);
    }
}
