<?php

namespace App\Http\Controllers;

use App\Models\Regu;
use App\Models\Datasatpam;
use Illuminate\Http\Request;

class ReguController extends Controller
{
    public function index(Request $request)
    {
        $upts = \App\Models\Upt::all();
        $ultgs = collect();
        $lokasikerjas = collect();

        $lokasiIds = [];
        if ($request->filled('upt_id')) {
            $ultgs = \App\Models\Ultg::where('upt_id', $request->upt_id)->get();
            $lokasiIds = \App\Models\Lokasikerja::whereIn('ultg_id', $ultgs->pluck('id'))->pluck('id')->toArray();
        }
        if ($request->filled('ultg_id')) {
            $lokasikerjas = \App\Models\Lokasikerja::where('ultg_id', $request->ultg_id)->get();
            $lokasiIds = $lokasikerjas->pluck('id')->toArray();
        }
        if ($request->filled('lokasikerja_id')) {
            $lokasiIds = [$request->lokasikerja_id];
        }

        $regus = \App\Models\Regu::with(['satpams' => function($q) use ($lokasiIds) {
            if (count($lokasiIds) > 0) {
                $q->whereIn('lokasikerja_id', $lokasiIds);
            }
        }])->paginate(10);

        // Tambahkan properti nama_regu_full untuk setiap regu
        foreach ($regus as $regu) {
            $nama_upt = $nama_ultg = $nama_lokasi = '-';
            if ($regu->satpams->count() > 0) {
                $lokasi = $regu->satpams[0]->lokasikerja;
                $nama_lokasi = $lokasi->nama_lokasikerja ?? '-';
                $nama_ultg = optional($lokasi->ultg)->nama_ultg ?? '-';
                $nama_upt = optional($lokasi->ultg->upt ?? null)->nama_upt ?? '-';
            }
            $regu->nama_regu_full = $regu->nama_regu . ' - ' . $nama_upt . ' - ' . $nama_ultg . ' - ' . $nama_lokasi;
        }

        return view('regu.index', compact('regus', 'upts', 'ultgs', 'lokasikerjas'));
    }

    public function create()
    {
        $upts = \App\Models\Upt::all();
        return view('regu.create', compact('upts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_regu' => 'required|string|unique:regu,nama_regu',
            'satpam_id' => 'array',
        ]);
        $regu = Regu::create(['nama_regu' => $request->nama_regu]);
        if ($request->satpam_id) {
            $regu->satpams()->sync($request->satpam_id);
        }
        return redirect()->route('regu.index')->with('success', 'Regu berhasil dibuat');
    }

    public function edit($id)
    {
        $regu = Regu::with('satpams')->findOrFail($id);
        $upts = \App\Models\Upt::all();
        // Ambil lokasi kerja, ultg, upt dari salah satu anggota regu (jika ada)
        $lokasikerja_id = null;
        $ultg_id = null;
        $upt_id = null;
        if ($regu->satpams->count() > 0) {
            $lokasikerja_id = $regu->satpams[0]->lokasikerja_id;
            $ultg_id = optional($regu->satpams[0]->lokasikerja)->ultg_id;
            $upt_id = optional($regu->satpams[0]->lokasikerja->ultg ?? null)->upt_id;
        }
        return view('regu.edit', compact('regu', 'upts', 'lokasikerja_id', 'ultg_id', 'upt_id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_regu' => 'required|string|unique:regu,nama_regu,' . $id,
            'satpam_id' => 'array',
        ]);
        $regu = Regu::findOrFail($id);
        $regu->update(['nama_regu' => $request->nama_regu]);
        $regu->satpams()->sync($request->satpam_id ?? []);
        return redirect()->route('regu.index')->with('success', 'Regu berhasil diupdate');
    }

    public function destroy($id)
    {
        $regu = Regu::findOrFail($id);
        $regu->satpams()->detach();
        $regu->delete();
        return redirect()->route('regu.index')->with('success', 'Regu berhasil dihapus');
    }

    // Form penjadwalan regu
    public function penjadwalanReguForm()
    {
        $upts = \App\Models\Upt::all();
        $jadwalRegu = \App\Models\Jadwalsatpam::with('datasatpam', 'regu.satpams')
            ->whereNotNull('regu_id')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal . '-' . $item->regu_id . '-' . $item->shift;
            })->map(function($group) {
                $first = $group->first();
                $first->regu = \App\Models\Regu::with('satpams')->find($first->regu_id);
                return $first;
            });
        return view('regu.penjadwalan', compact('upts', 'jadwalRegu'));
    }

    // Proses penjadwalan regu
    public function penjadwalanReguStore(Request $request)
    {
        $request->validate([
            'regu_id' => 'required|exists:regu,id',
            'tanggal' => 'required|array',
            'tanggal.*' => 'required|date',
            'shift' => 'required|string',
        ]);
        $regu = Regu::with('satpams')->findOrFail($request->regu_id);

        if ($request->filled('jadwal_id')) {
            $jadwalLama = \App\Models\Jadwalsatpam::findOrFail($request->jadwal_id);
            \App\Models\Jadwalsatpam::where('regu_id', $jadwalLama->regu_id)
                ->where('tanggal', $jadwalLama->tanggal)
                ->where('shift', $jadwalLama->shift)
                ->where('created_at', $jadwalLama->created_at)
                ->delete();
        }

        foreach ($request->tanggal as $tanggal) {
            foreach ($regu->satpams as $satpam) {
                \App\Models\Jadwalsatpam::updateOrCreate([
                    'satpam_id' => $satpam->id,
                    'tanggal' => $tanggal,
                    'shift' => $request->shift,
                ], [
                    'regu_id' => $regu->id
                ]);
            }
        }
        return redirect()->route('regu.penjadwalan.form')->with('success', 'Jadwal regu berhasil disimpan');
    }

    public function editPenjadwalanRegu($id)
    {
        $jadwal = \App\Models\Jadwalsatpam::with('regu', 'regu.satpams')->findOrFail($id);
        $upts = \App\Models\Upt::all();
        return view('regu.edit_penjadwalan', compact('jadwal', 'upts'));
    }

    public function deletePenjadwalanRegu($id)
    {
        $jadwal = \App\Models\Jadwalsatpam::findOrFail($id);
        \App\Models\Jadwalsatpam::where('regu_id', $jadwal->regu_id)
            ->where('tanggal', $jadwal->tanggal)
            ->where('shift', $jadwal->shift)
            ->where('created_at', $jadwal->created_at)
            ->delete();
        return redirect()->route('regu.penjadwalan.form')->with('success', 'Semua jadwal regu pada tanggal & shift ini berhasil dihapus');
    }

    // Endpoint AJAX untuk get satpam by lokasi kerja
    public function getSatpam($lokasikerja_id)
    {
        $satpams = \App\Models\Datasatpam::where('lokasikerja_id', $lokasikerja_id)->pluck('nama', 'id');
        return response()->json($satpams);
    }

    // Endpoint AJAX untuk get regu by lokasi kerja
    public function getReguByLokasi($lokasikerja_id)
    {
        $regus = \App\Models\Regu::whereHas('satpams', function($q) use ($lokasikerja_id) {
            $q->where('lokasikerja_id', $lokasikerja_id);
        })->pluck('nama_regu', 'id');
        return response()->json($regus);
    }
} 