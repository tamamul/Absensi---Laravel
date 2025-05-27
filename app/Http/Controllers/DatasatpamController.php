<?php

namespace App\Http\Controllers;

use App\Models\Lokasikerja;
use App\Models\Ultg;
use App\Models\Upt;
use Illuminate\Http\Request;
use App\Models\Datasatpam;
use Illuminate\Support\Facades\Storage;

class DatasatpamController extends Controller
{
    //
    public function index(){
        $data = Datasatpam::with(['lokasikerja.ultg.upt'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) {
                // Transform foto path
                if($item->foto) {
                    $item->foto_url = asset('storage/' . $item->foto);
                }
                return $item;
            });
        return view('datasatpam.index', ['dataDatasatpam'=> $data]);
    }
    public function create()
    {
        $allUptNames = Upt::all();    // Ambil semua UPT
        $allUltgNames = Ultg::all();  // Ambil semua ULTG
        $allLokasikerjaNames = Lokasikerja::all(); // Ambil semua Lokasi Kerja
        $newID = 'SAT' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        return view('datasatpam.create', compact('allUptNames', 'allUltgNames', 'allLokasikerjaNames', 'newID'));
    }
    public function store(Request $request)
    {
        $request->validate([
        'nip' => 'required',
        'nik' => 'required',
        'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required',
            'status' => 'required',
        'jabatan' => 'required',
            'lokasikerja_id' => 'required',
        'no_hp' => 'required',
        'email' => 'nullable|email',
            'alamat' => 'required'
        ]);

        $data = new Datasatpam();
        $data->kode_satpam = $request->kode_satpam;
        $data->nip = $request->nip;
        $data->nik = $request->nik;
        
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $data->kode_satpam . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/foto', $filename);
            $data->foto = 'foto/' . $filename;
        }

        $data->nama = $request->nama;
        $data->pekerjaan = 'Satpam';
        $data->status = $request->status;
        $data->no_pkwt_pkwtt = $request->no_pkwt_pkwtt;
        $data->kontrak = $request->kontrak;
        $data->terhitung_mulai_tugas = $request->terhitung_mulai_tugas;
        $data->jabatan = $request->jabatan;
        $data->lokasikerja_id = $request->lokasikerja_id;
        $data->wilayah_kerja = $request->wilayah_kerja;
        $data['jenis_kelamin'] = $request->jenis_kelamin;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir;
        $data->usia = $request->usia;
        $data['warga negara'] = $request->warga_negara;
        $data->agama = $request->agama;
        $data->no_hp = $request->no_hp;
        $data->email = $request->email;
        $data->alamat = $request->alamat;
        $data->kelurahan = $request->kelurahan;
        $data->kecamatan = $request->kecamatan;
        $data->kabupaten = $request->kabupaten;
        $data->provinsi = $request->provinsi;
        $data->negara = $request->negara;
        $data->nama_ibu = $request->nama_ibu;
        $data->no_kontak_darurat = $request->no_kontak_darurat;
        $data->nama_kontak_darurat = $request->nama_kontak_darurat;
        $data->nama_ahli_waris = $request->nama_ahli_waris;
        $data->tempat_lahir_ahli_waris = $request->tempat_lahir_ahli_waris;
        $data->tanggal_lahir_ahli_waris = $request->tanggal_lahir_ahli_waris;
        $data->hub_ahli_waris = $request->hub_ahli_waris;
        $data->status_nikah = $request->status_nikah;
        $data->jumlah_anak = $request->jumlah_anak;
        $data->npwp = $request->npwp;
        $data->nama_bank = $request->nama_bank;
        $data->no_rek = $request->no_rek;
        $data->nama_pemilik_rek = $request->nama_pemilik_rek;
        $data->no_dplk = $request->no_dplk;
        $data->pend_terakhir = $request->pend_terakhir;
        $data->sertifikasi_satpam = $request->sertifikasi_satpam;
        $data->no_reg_kta = $request->no_reg_kta;
        $data->no_kta = $request->no_kta;
        $data->polda = $request->polda;
        $data->polres = $request->polres;
        $data->no_bpjs_kesehatan = $request->no_bpjs_kesehatan;
        $data->no_bpjs_ketenagakerjaan = $request->no_bpjs_ketenagakerjaan;
        $data->ukuran_baju = $request->ukuran_baju;
        $data->ukuran_celana = $request->ukuran_celana;
        $data['ukuran sepatu'] = $request->ukuran_sepatu;
        $data->ukuran_topi = $request->ukuran_topi;

        $data->save();

        return redirect()->route('datasatpam.index')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id){
        $data = Datasatpam::with(['lokasikerja.ultg.upt'])->findOrFail($id);
        $allUptNames = Upt::all();
        $allUltgNames = Ultg::where('upt_id', $data->lokasikerja->ultg->upt->id)->get();
        $allLokasikerjaNames = Lokasikerja::where('ultg_id', $data->lokasikerja->ultg->id)->get();
        
        return view('datasatpam.edit', compact('data', 'allUptNames', 'allUltgNames', 'allLokasikerjaNames'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required',
            'nik' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required',
            'status' => 'required',
            'jabatan' => 'required',
            'lokasikerja_id' => 'required',
            'no_hp' => 'required',
            'email' => 'nullable|email',
            'alamat' => 'required'
        ]);

        $data = Datasatpam::findOrFail($id);
        
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($data->foto) {
                Storage::delete('public/' . $data->foto);
            }
            
            $foto = $request->file('foto');
            $filename = time() . '_' . $data->kode_satpam . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/foto', $filename);
            $data->foto = 'foto/' . $filename;
        }

        $data->nip = $request->nip;
        $data->nik = $request->nik;
        $data->nama = $request->nama;
        $data->pekerjaan = 'Satpam';
        $data->status = $request->status;
        $data->no_pkwt_pkwtt = $request->no_pkwt_pkwtt;
        $data->kontrak = $request->kontrak;
        $data->terhitung_mulai_tugas = $request->terhitung_mulai_tugas;
        $data->jabatan = $request->jabatan;
        $data->lokasikerja_id = $request->lokasikerja_id;
        $data->wilayah_kerja = $request->wilayah_kerja;
        $data['jenis_kelamin'] = $request->jenis_kelamin;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir;
        $data->usia = $request->usia;
        $data['warga negara'] = $request->warga_negara;
        $data->agama = $request->agama;
        $data->no_hp = $request->no_hp;
        $data->email = $request->email;
        $data->alamat = $request->alamat;
        $data->kelurahan = $request->kelurahan;
        $data->kecamatan = $request->kecamatan;
        $data->kabupaten = $request->kabupaten;
        $data->provinsi = $request->provinsi;
        $data->negara = $request->negara;
        $data->nama_ibu = $request->nama_ibu;
        $data->no_kontak_darurat = $request->no_kontak_darurat;
        $data->nama_kontak_darurat = $request->nama_kontak_darurat;
        $data->nama_ahli_waris = $request->nama_ahli_waris;
        $data->tempat_lahir_ahli_waris = $request->tempat_lahir_ahli_waris;
        $data->tanggal_lahir_ahli_waris = $request->tanggal_lahir_ahli_waris;
        $data->hub_ahli_waris = $request->hub_ahli_waris;
        $data->status_nikah = $request->status_nikah;
        $data->jumlah_anak = $request->jumlah_anak;
        $data->npwp = $request->npwp;
        $data->nama_bank = $request->nama_bank;
        $data->no_rek = $request->no_rek;
        $data->nama_pemilik_rek = $request->nama_pemilik_rek;
        $data->no_dplk = $request->no_dplk;
        $data->pend_terakhir = $request->pend_terakhir;
        $data->sertifikasi_satpam = $request->sertifikasi_satpam;
        $data->no_reg_kta = $request->no_reg_kta;
        $data->no_kta = $request->no_kta;
        $data->polda = $request->polda;
        $data->polres = $request->polres;
        $data->no_bpjs_kesehatan = $request->no_bpjs_kesehatan;
        $data->no_bpjs_ketenagakerjaan = $request->no_bpjs_ketenagakerjaan;
        $data->ukuran_baju = $request->ukuran_baju;
        $data->ukuran_celana = $request->ukuran_celana;
        $data['ukuran sepatu'] = $request->ukuran_sepatu;
        $data->ukuran_topi = $request->ukuran_topi;
        
        $data->save();
        
        return redirect()->route('datasatpam.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id){
        $data = Datasatpam::findOrFail($id);
        if ($data->foto) {
            Storage::delete('public/' . $data->foto);
        }
        $data->delete();
        return redirect()->route('datasatpam.index')->with('success', 'Data berhasil dihapus');
    }
    public function getUltg($upt_id)
    {
        $ultgs = Ultg::where('upt_id', $upt_id)->pluck('nama_ultg', 'id');
        return response()->json($ultgs);
    }

    public function getLokasiKerja($ultg_id)
    {
        $lokasiKerjas = Lokasikerja::where('ultg_id', $ultg_id)->pluck('nama_lokasi', 'id');
        return response()->json($lokasiKerjas);
    }

}
