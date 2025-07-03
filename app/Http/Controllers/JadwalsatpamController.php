<?php

namespace App\Http\Controllers;

use App\Models\Datasatpam;
use Illuminate\Http\Request;
use App\Models\Upt;
use App\Models\Ultg;
use App\Models\Lokasikerja;
use App\Models\Jadwalsatpam;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class JadwalsatpamController extends Controller
{
    public function index(Request $request)
    {
        $upts = \App\Models\Upt::all();
        $ultgs = \App\Models\Ultg::all();
        $lokasikerjas = \App\Models\Lokasikerja::all();

        // Default bulan tahun jika tidak ada filter
        $bulanTahun = $request->get('bulan_tahun');
        $tahun = date('Y'); // Default tahun saat ini
        $bulan = null; // Tidak ada filter bulan secara default

        // Jika ada filter bulan_tahun, parse tahun dan bulan
        if ($bulanTahun) {
            [$tahun, $bulan] = explode('-', $bulanTahun);
        }

        // Query jadwal berdasarkan filter
        $jadwalsatpams = \App\Models\Jadwalsatpam::with(['datasatpam.lokasikerja.ultg.upt'])
            ->whereYear('tanggal', $tahun);

        // Tambahkan filter bulan hanya jika bulan_tahun diisi
        if ($bulan) {
            $jadwalsatpams->whereMonth('tanggal', $bulan);
        }

        // Filter berdasarkan UPT
        if ($request->filled('upt_id')) {
            $ultgIds = \App\Models\Ultg::where('upt_id', $request->upt_id)->pluck('id');
            $lokasiIds = \App\Models\Lokasikerja::whereIn('ultg_id', $ultgIds)->pluck('id');
            $satpamIds = \App\Models\Datasatpam::whereIn('lokasikerja_id', $lokasiIds)->pluck('id');
            $jadwalsatpams->whereIn('satpam_id', $satpamIds);
        }

        // Filter berdasarkan ULTG
        if ($request->filled('ultg_id')) {
            $lokasiIds = \App\Models\Lokasikerja::where('ultg_id', $request->ultg_id)->pluck('id');
            $satpamIds = \App\Models\Datasatpam::whereIn('lokasikerja_id', $lokasiIds)->pluck('id');
            $jadwalsatpams->whereIn('satpam_id', $satpamIds);
        }

        // Filter berdasarkan Lokasi Kerja
        if ($request->filled('lokasikerja_id')) {
            $satpamIds = \App\Models\Datasatpam::where('lokasikerja_id', $request->lokasikerja_id)->pluck('id');
            $jadwalsatpams->whereIn('satpam_id', $satpamIds);
        }

        $jadwalsatpams = $jadwalsatpams->get();

        // Group jadwal berdasarkan lokasi kerja
        $groupedJadwal = [];
        foreach ($jadwalsatpams as $jadwal) {
            $lokasiId = $jadwal->datasatpam->lokasikerja_id;
            if (!isset($groupedJadwal[$lokasiId])) {
                $groupedJadwal[$lokasiId] = [
                    'lokasi' => $jadwal->datasatpam->lokasikerja,
                    'total' => 0
                ];
            }
            $groupedJadwal[$lokasiId]['total']++;
        }

        return view('jadwalsatpam.index', compact(
            'groupedJadwal',
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
        $selectedLokasikerja = null;

        // List satpam berdasarkan lokasi kerja jika sudah dipilih
        if ($request->filled('lokasikerja_id')) {
            $satpamList = Datasatpam::where('lokasikerja_id', $request->lokasikerja_id)->get();
            $selectedLokasikerja = Lokasikerja::find($request->lokasikerja_id);
        }

        $jadwalData = [];
        if ($request->filled(['lokasikerja_id', 'bulan', 'tahun'])) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;

            // Ambil semua jadwal untuk lokasi kerja tersebut pada bulan dan tahun yang dipilih
            $jadwalRows = Jadwalsatpam::with('datasatpam')
                ->whereHas('datasatpam', function ($query) use ($request) {
                    $query->where('lokasikerja_id', $request->lokasikerja_id);
                })
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();

            // Mapping: [tanggal][shift] = satpam_id
            foreach ($jadwalRows as $jadwal) {
                $jadwalData[$jadwal->tanggal][$jadwal->shift] = $jadwal->satpam_id;
            }
        }

        return view('jadwalsatpam.create', [
            'upts' => $upts,
            'ultgs' => $ultgs,
            'lokasikerjas' => $lokasikerjas,
            'satpamList' => $satpamList,
            'selectedLokasikerja' => $selectedLokasikerja,
            'jadwalData' => $jadwalData,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lokasikerja_id' => 'required|exists:lokasikerja,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2100',
            'jadwal' => 'required|array',
        ]);

        // Hapus jadwal lama untuk lokasi kerja ini pada bulan dan tahun yang dipilih
        $satpamIds = Datasatpam::where('lokasikerja_id', $request->lokasikerja_id)->pluck('id');
        Jadwalsatpam::whereIn('satpam_id', $satpamIds)
            ->whereMonth('tanggal', $request->bulan)
            ->whereYear('tanggal', $request->tahun)
            ->delete();

        // Simpan jadwal baru
        foreach ($request->jadwal as $tanggal => $shifts) {
            $fullDate = sprintf('%04d-%02d-%02d', $request->tahun, $request->bulan, $tanggal);

            foreach ($shifts as $shift => $satpamId) {
                if ($satpamId) { // Jika satpam dipilih
                    Jadwalsatpam::create([
                        'satpam_id' => $satpamId,
                        'tanggal' => $fullDate,
                        'shift' => $shift,
                    ]);
                }
            }
        }

        return redirect()->route('jadwalsatpam.create', [
            'lokasikerja_id' => $request->lokasikerja_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'upt_id' => $request->input('upt_id'),
            'ultg_id' => $request->input('ultg_id')
        ])->with('success', 'Jadwal berhasil disimpan.');
    }

    public function edit(Request $request)
    {
        $upts = Upt::all();
        $ultgs = Ultg::all();
        $lokasikerjas = Lokasikerja::all();
        $satpamList = [];
        $selectedLokasikerja = null;

        // List satpam berdasarkan lokasi kerja jika sudah dipilih
        if ($request->filled('lokasikerja_id')) {
            $satpamList = Datasatpam::where('lokasikerja_id', $request->lokasikerja_id)->get();
            $selectedLokasikerja = Lokasikerja::find($request->lokasikerja_id);
        }

        $jadwalData = [];
        if ($request->filled(['lokasikerja_id', 'bulan', 'tahun'])) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;

            // Ambil semua jadwal untuk lokasi kerja tersebut pada bulan dan tahun yang dipilih
            $jadwalRows = Jadwalsatpam::with('datasatpam')
                ->whereHas('datasatpam', function ($query) use ($request) {
                    $query->where('lokasikerja_id', $request->lokasikerja_id);
                })
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();

            // Mapping: [tanggal][shift] = satpam_id
            foreach ($jadwalRows as $jadwal) {
                $jadwalData[$jadwal->tanggal][$jadwal->shift] = $jadwal->satpam_id;
            }
        }

        return view('jadwalsatpam.edit', [
            'upts' => $upts,
            'ultgs' => $ultgs,
            'lokasikerjas' => $lokasikerjas,
            'satpamList' => $satpamList,
            'selectedLokasikerja' => $selectedLokasikerja,
            'jadwalData' => $jadwalData,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'lokasikerja_id' => 'required|exists:lokasikerja,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2100',
            'jadwal' => 'required|array',
        ]);

        // Hapus jadwal lama untuk lokasi kerja ini pada bulan dan tahun yang dipilih
        $satpamIds = Datasatpam::where('lokasikerja_id', $request->lokasikerja_id)->pluck('id');
        Jadwalsatpam::whereIn('satpam_id', $satpamIds)
            ->whereMonth('tanggal', $request->bulan)
            ->whereYear('tanggal', $request->tahun)
            ->delete();

        // Simpan jadwal baru
        foreach ($request->jadwal as $tanggal => $shifts) {
            $fullDate = sprintf('%04d-%02d-%02d', $request->tahun, $request->bulan, $tanggal);

            foreach ($shifts as $shift => $satpamId) {
                if ($satpamId) { // Jika satpam dipilih
                    Jadwalsatpam::create([
                        'satpam_id' => $satpamId,
                        'tanggal' => $fullDate,
                        'shift' => $shift,
                    ]);
                }
            }
        }

        // return redirect()->route('jadwalsatpam.edit', [
        //     'lokasikerja_id' => $request->lokasikerja_id,
        //     'bulan' => $request->bulan,
        //     'tahun' => $request->tahun,
        //     'upt_id' => $request->input('upt_id'),
        //     'ultg_id' => $request->input('ultg_id')
        // ])->with('success', 'Jadwal berhasil diupdate.');
        return redirect()->route('jadwalsatpam.index')->with('success', 'Jadwal berhasil diupdate.');
    }

    public function destroy($id)
    {
        $jadwal = Jadwalsatpam::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwalsatpam.index')->with('success', 'Jadwal berhasil dihapus.');
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

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls',
        ]);
        try {
            $file = $request->file('file_excel');
            $data = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getPathname())
                ->getActiveSheet()
                ->toArray(null, true, true, true);
            $header = array_map('strtolower', $data[1]);
            unset($data[1]);
            DB::beginTransaction();
            foreach ($data as $row) {
                $rowData = array_combine($header, $row);
                // Mapping nama ke id
                $satpam = \App\Models\Datasatpam::where('nama', $rowData['nama_satpam'] ?? '')->first();
                $lokasi = \App\Models\Lokasikerja::where('nama_lokasikerja', $rowData['nama_lokasikerja'] ?? '')->first();
                $upt = \App\Models\Upt::where('nama_upt', $rowData['nama_upt'] ?? '')->first();
                $ultg = \App\Models\Ultg::where('nama_ultg', $rowData['nama_ultg'] ?? '')->first();
                if (!$satpam || !$lokasi || !$upt || !$ultg) continue;
                \App\Models\Jadwalsatpam::updateOrCreate([
                    'satpam_id' => $satpam->id,
                    'tanggal' => $rowData['tanggal'],
                    'shift' => $rowData['shift'],
                ], []);
            }
            DB::commit();
            return redirect()->route('jadwalsatpam.index')->with('success', 'Import Excel berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Import Excel Jadwal Error', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Import Excel gagal: ' . $e->getMessage());
        }
    }

    public function downloadSampleExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray([
            ['tanggal', 'shift', 'nama_satpam', 'nama_lokasikerja', 'nama_upt', 'nama_ultg'],
            // GI 150KV LAWANG
            ['2025-07-10', 'P', 'MISBACHUL HUDA', 'GI 150KV LAWANG', 'malangg', 'malangsa'],
            ['2025-07-10', 'S', 'dsf', 'GI 150KV LAWANG', 'malangg', 'malangsa'],
            ['2025-07-11', 'P', 'MISBACHUL HUDA', 'GI 150KV LAWANG', 'malangg', 'malangsa'],
            ['2025-07-11', 'S', 'dsf', 'GI 150KV LAWANG', 'malangg', 'malangsa'],
            ['2025-07-12', 'P', 'MISBACHUL HUDA', 'GI 150KV LAWANG', 'malangg', 'malangsa'],
            ['2025-07-12', 'S', 'dsf', 'GI 150KV LAWANG', 'malangg', 'malangsa'],
            // GI GULUK-GULUK
            ['2025-07-10', 'P', 'frankie steinlie', 'GI GULUK-GULUK', 'gresikk', 'sampangsa'],
            ['2025-07-10', 'S', 'frankie steinlie', 'GI GULUK-GULUK', 'gresikk', 'sampangsa'],
            ['2025-07-11', 'P', 'frankie steinlie', 'GI GULUK-GULUK', 'gresikk', 'sampangsa'],
            ['2025-07-11', 'S', 'frankie steinlie', 'GI GULUK-GULUK', 'gresikk', 'sampangsa'],
            ['2025-07-12', 'P', 'frankie steinlie', 'GI GULUK-GULUK', 'gresikk', 'sampangsa'],
            ['2025-07-12', 'S', 'frankie steinlie', 'GI GULUK-GULUK', 'gresikk', 'sampangsa'],
        ]);
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'sample_jadwal_satpam.xlsx';
        $tmpFile = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($tmpFile);
        return response()->download($tmpFile, $filename)->deleteFileAfterSend(true);
    }
}
