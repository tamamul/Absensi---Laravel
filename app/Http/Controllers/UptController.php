<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upt;

class UptController extends Controller
{
    //
    public function index(){
        $data = Upt::all();
        return view('upt.index', ['dataUpt' => $data]);
    }
    public function create(){
        $newID = 'UPT' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT); // contoh pembuatan ID baru
        return view('upt.create', compact('newID'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_upt' => 'required|string|max:255|unique:upt,nama_upt',
        ], [
            'nama_upt.required' => 'Nama UPT wajib diisi.',
            'nama_upt.unique' => 'Nama UPT sudah digunakan.',
        ]);

    
        $data = new Upt();
        $data->kode_upt = $request->kode_upt;
        $data->nama_upt = $request->nama_upt;
        $data->save();
        
        return redirect('/upt')->with('success', 'Data UPT berhasil ditambahkan.');

    }
    public function edit($id){
        $upt = UPT::findOrFail($id);
        return view('upt.edit', compact('upt'));
        
    }
    public function update(Request $request, $id){
        $request->validate([
            'nama_upt' => 'required|string|max:255|unique:upt,nama_upt',
        ], [
            'nama_upt.required' => 'Nama UPT wajib diisi.',
            'nama_upt.unique' => 'Nama UPT sudah digunakan.',
        ]);

        $data = Upt::find($id);
        $data->nama_upt = $request->nama_upt;
        $data->update();
        return redirect('/upt')->with('updated', 'Data UPT berhasil diubah.');
    }
    public function destroy($id){
        $data = Upt::find($id);
        $data->delete();
        return redirect('/upt')->with('deleted', 'Data UPT berhasil dihapus.');
    }
}
