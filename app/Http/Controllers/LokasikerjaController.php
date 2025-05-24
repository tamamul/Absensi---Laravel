<?php

namespace App\Http\Controllers;

use App\Models\Upt;
use Illuminate\Http\Request;
use App\Models\Lokasikerja;
use App\Models\Ultg;

class LokasikerjaController extends Controller
{
    public function index()
    {
        $data = Lokasikerja::with('ultg')->get(); // relasi ke ultg
        return view('lokasikerja.index', ['dataLokasikerja' => $data]);
    }

    public function create()
    {
        $allUptNames = Upt::all();    // Ambil semua UPT
        $allUltgNames = Ultg::all();  // Ambil semua ULTG
        $newID = 'LOK' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        return view('lokasikerja.create', compact('allUptNames', 'allUltgNames', 'newID'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'upt_id' => 'required|exists:upt,id',
            'ultg_id' => 'required|exists:ultg,id',
            'nama_lokasikerja' => 'required|string|max:255|unique:upt,nama_upt',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
        ], [
            'upt_id.required' => 'Nama UPT wajib dipilih.',
            'ultg_id.required' => 'Nama ULTG wajib dipilih.',
            'nama_lokasikerja.required' => 'Nama Lokasi Kerja wajib diisi.',
            'nama_lokasikerja.unique' => 'Nama Lokasi Kerja sudah digunakan.',
            'latitude.required' => 'Latitude wajib diisi.',
            'longitude.required' => 'Longitute wajib diisi.',
            'radius.required' => 'Radius wajib diisi.',
        ]);

        $lokasikerja = new Lokasikerja();
        $lokasikerja->id = $request->id;
        $lokasikerja->upt_id = $request->upt_id;
        $lokasikerja->ultg_id = $request->ultg_id;
        $lokasikerja->nama_lokasikerja = $request->nama_lokasikerja;
        $lokasikerja->latitude = $request->latitude;
        $lokasikerja->longitude = $request->longitude;
        $lokasikerja->radius = $request->radius;
        $lokasikerja->save();

        return redirect()->route('lokasikerja.index')->with('success', 'Data lokasi kerja berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $lokasikerja = Lokasikerja::findOrFail($id);
        $allUltgNames = Ultg::all();
        return view('lokasikerja.edit', compact('lokasikerja', 'allUltgNames'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ultg_id' => 'required|exists:ultg,id',
            'nama_lokasikerja' => 'required|string|max:255|unique:upt,nama_upt',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
        ], [
            'upt_id.required' => 'Nama UPT wajib dipilih.',
            'ultg_id.required' => 'Nama ULTG wajib dipilih.',
            'nama_lokasikerja.required' => 'Nama Lokasi Kerja wajib diisi.',
            'nama_lokasikerja.unique' => 'Nama Lokasi Kerja sudah digunakan.',
            'latitude.required' => 'Latitude wajib diisi.',
            'longitude.required' => 'Longitute wajib diisi.',
            'radius.required' => 'Radius wajib diisi.',
        ]); 

        $lokasikerja = Lokasikerja::findOrFail($id);
        $lokasikerja->ultg_id = $request->ultg_id;
        $lokasikerja->nama_lokasikerja = $request->nama_lokasikerja;
        $lokasikerja->latitude = $request->latitude;
        $lokasikerja->longitude = $request->longitude;
        $lokasikerja->radius = $request->radius;
        $lokasikerja->save();

        return redirect()->route('lokasikerja.index')->with('updated', 'Data lokasi kerja berhasil diupdate.');
    }

    public function destroy($id)
    {
        $lokasikerja = Lokasikerja::findOrFail($id);
        $lokasikerja->delete();
        return redirect()->route('lokasikerja.index')->with('deleted', 'Data lokasi kerja berhasil dihapus.');
    }
    public function getUltgByUpt($upt_id)
    {
        $ultg = Ultg::where('upt_id', $upt_id)->get(); // pastikan di tabel ultg ada kolom upt_id
        return response()->json($ultg);
    }
}
