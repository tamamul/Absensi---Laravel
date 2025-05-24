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
    public function create(Request $request)
    {
        $upts = Upt::all();
        $ultgs = Ultg::all(); // ⬅ Tambahkan baris ini
        $lokasikerjas = Lokasikerja::all(); // ⬅ Tambahkan baris ini

        $satpamList = [];
        if ($request->filled(['lokasi_kerja_id', 'bulan', 'tahun'])) {
            $satpamList = Datasatpam::where('lokasi_kerja_id', $request->lokasi_kerja_id)->get();
        }

        return view('jadwalsatpam.create', [
            'upts' => $upts,
            'ultgs' => $ultgs, // ⬅ Kirim ke view
            'lokasikerjas' => $lokasikerjas, // ⬅ Kirim ke view
            'selectedUpt' => $request->upt_id,
            'selectedUltg' => $request->ultg_id,
            'selectedLokasikerja' => $request->lokasi_kerja_id,
            'selectedBulan' => $request->bulan,
            'selectedTahun' => $request->tahun,
            'satpamList' => $satpamList,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'lokasi_kerja_id' => 'required|exists:lokasi_kerja,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2100',
            'jadwal' => 'required|array',
        ]);

        foreach ($request->jadwal as $satpamId => $tanggalData) {
            foreach ($tanggalData as $tanggal => $shift) {
                Jadwalsatpam::updateOrCreate(
                    [
                        'datasatpam_id' => $satpamId,
                        'lokasi_kerja_id' => $request->lokasi_kerja_id,
                        'bulan' => $request->bulan,
                        'tahun' => $request->tahun,
                        'tanggal' => $tanggal,
                    ],
                    ['shift' => $shift]
                );
            }
        }

        return redirect()->route('jadwalsatpam.create')->with('success', 'Jadwal berhasil disimpan.');
    }


    // AJAX: Ambil ULTG berdasarkan UPT
    public function getUltg($uptId)
    {
        $ultgs = Ultg::where('upt_id', $uptId)->pluck('nama_ultg', 'id');
        return response()->json($ultgs);
    }
    public function getUltgByUpt($upt_id)
    {
        $ultg = Ultg::where('upt_id', $upt_id)->get(); // pastikan di tabel ultg ada kolom upt_id
        return response()->json($ultg);
    }

    // AJAX: Ambil Lokasi Kerja berdasarkan ULTG
    public function getLokasiKerja($ultgId)
    {
        $lokasiKerja = Lokasikerja::where('ultg_id', $ultgId)->pluck('nama_lokasi', 'id');
        return response()->json($lokasiKerja);
    }
}
