<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ultg;
use App\Models\Upt;

class UltgController extends Controller
{
    //
    public function index(){
        $data = Ultg::all();
        return view('ultg.index', ['dataUltg' => $data]);
    }
    public function create(){
        $allUptNames = Upt::all();
        $newID = 'ULTG' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT); // contoh pembuatan ID baru
        return view('ultg.create', compact('allUptNames', 'newID'));
    }
    public function store(Request $request){
            // Validasi form
    $request->validate([
        'nama_upt' => 'required|exists:upt,id',
        'nama_ultg' => 'required|string|max:255|unique:ultg,nama_ultg',
    ], [
        'nama_upt.required' => 'Nama UPT wajib dipilih.',
        'nama_ultg.required' => 'Nama ULTG wajib diisi.',
        'nama_ultg.unique' => 'Nama ULTG sudah digunakan.',
    ]);

    // Cek jika nama_ultg sudah ada (meskipun upt-nya beda)
    $exists = Ultg::where('nama_ultg', $request->nama_ultg)->exists();

    if ($exists) {
        return back()->withErrors(['Nama ULTG sudah digunakan.'])->withInput();
    }

        $data = new Ultg();
        $data->kode_ultg = $request->kode_ultg;
        $data->nama_ultg = $request->nama_ultg;
        $data->upt_id = $request->nama_upt;
        $data->save();
        return redirect('/ultg')->with('success', 'Data ULTG berhasil ditambahkan.');
    }
    public function edit($id){
        $ultg = Ultg::findOrFail($id); // <- ambil data berdasarkan ID
        $allUptNames = Upt::all();
        return view('ultg.edit', compact('ultg', 'allUptNames')); // <- kirim ke view
    }
    public function update(Request $request, $id){
        $data = Ultg::findOrFail($id);
        // if ($request->nama_ultg === $data->nama_ultg && $request->nama_upt == $data->upt_id) {
        //     return back()->withErrors(['update_error' => 'Tidak ada perubahan data.'])->withInput();
        // }

        $request->validate([
            'nama_upt' => 'required|exists:upt,id',
            'nama_ultg' => 'required|string|max:255|unique:ultg,nama_ultg,' . $id . ',id',
            ],
         [
            'nama_upt.required' => 'UPT harus dipilih.',
            'nama_ultg.required' => 'Nama ULTG wajib diisi.',
            'nama_ultg.unique' => 'Nama ULTG sudah digunakan.',
        ]);
        
        
        // $request->validate([
        //     'nama_upt' => 'required|string|max:255',
        //     'nama_ultg' => 'required|string|max:255|unique:ultg,nama_ultg,' . $id.',id',
        // ], [
        //     'nama_upt.required' => 'UPT harus dipilih.',
        //     'nama_ultg.required' => 'Nama ULTG wajib diisi.',
        //     'nama_ultg.unique' => 'Nama ULTG sudah digunakan.',
        // ]);
    
        // $data = Ultg::findOrFail($id);
        $data->upt_id = $request->nama_upt;
        $data->nama_ultg = $request->nama_ultg;
        $data->save();
    
        return redirect('/ultg')->with('updated', 'Data ULTG berhasil diubah.');
    }
    
    public function destroy($id)
    {
        $data = Ultg::find($id);
        $data->delete();
        return redirect('/ultg')->with('deleted', 'Data ULTG berhasil dihapus.');
    }
}

