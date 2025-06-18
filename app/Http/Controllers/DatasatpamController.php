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
    public function index()
    {
        $data = Datasatpam::with(['lokasikerja.ultg.upt'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                if ($item->foto && Storage::disk('public')->exists($item->foto)) {
                    $item->foto_url = asset('storage/' . $item->foto);
                } else {
                    $item->foto_url = asset('storage/foto_satpam/default_avatar.jpg.avif');
                }
                return $item;
            });
        return view('datasatpam.index', ['dataDatasatpam' => $data]);
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
        $validated = $request->validate([
            'kode_satpam' => 'required|unique:datasatpam,kode_satpam',
            'nip' => 'required|string|max:50',
            'nik' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'status' => 'required|string',
            'no_pkwt_pkwtt' => 'required|string|max:100',
            'kontrak' => 'nullable|string|max:100',
            'terhitung_mulai_tugas' => 'required|date',
            'jabatan' => 'required|string|max:100',
            // 'upt_id' => 'required|exists:upt,id',
            // 'ultg_id' => 'required|exists:ultg,id',
            'lokasikerja_id' => 'required|exists:lokasikerja,id',
            'wilayah_kerja' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'usia' => 'nullable|integer',
            'warga_negara' => 'required|string|in:WNI,WNA',
            'agama' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'negara' => 'nullable|string|max:100',
            'nama_ibu' => 'nullable|string|max:100',
            'no_kontak_darurat' => 'nullable|string|max:20',
            'nama_kontak_darurat' => 'nullable|string|max:100',
            'nama_ahli_waris' => 'nullable|string|max:100',
            'tempat_lahir_ahli_waris' => 'nullable|string|max:100',
            'tanggal_lahir_ahli_waris' => 'nullable|date',
            'hub_ahli_waris' => 'nullable|string|max:100',
            'status_nikah' => 'nullable|string|max:10',
            'jumlah_anak' => 'nullable|integer',
            'npwp' => 'nullable|string|max:30',
            'nama_bank' => 'nullable|string|max:100',
            'no_rek' => 'nullable|string|max:50',
            'nama_pemilik_rek' => 'nullable|string|max:100',
            'no_dplk' => 'nullable|string|max:50',
            'pend_terakhir' => 'nullable|string|max:100',
            'sertifikasi_satpam' => 'nullable|string|max:50',
            'no_reg_kta' => 'nullable|string|max:50',
            'no_kta' => 'nullable|string|max:50',
            'polda' => 'nullable|string|max:100',
            'polres' => 'nullable|string|max:100',
            'no_bpjs_kesehatan' => 'nullable|string|max:50',
            'no_bpjs_ketenagakerjaan' => 'nullable|string|max:50',
            'ukuran_baju' => 'nullable|string|max:10',
            'ukuran_celana' => 'nullable|integer',
            'ukuran_sepatu' => 'nullable|integer',
            'ukuran_topi' => 'nullable|integer',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = new \App\Models\Datasatpam($validated);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();

            // Simpan ke storage/app/public/foto_satpam
            $path = $foto->storeAs('foto_satpam', $filename, 'public');

            // Simpan hanya path relatif di database: 'foto_satpam/filename.jpg'
            $data->foto = $path;
        }

        $data->save();

        return redirect()->route('datasatpam.index')->with('success', 'Data Satpam berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $data = Datasatpam::with(['lokasikerja.ultg.upt'])->findOrFail($id);
        $allUptNames = Upt::all();

        // Ambil ULTG berdasarkan UPT yang terkait dengan lokasi kerja
        $allUltgNames = collect();
        if ($data->lokasikerja && $data->lokasikerja->ultg && $data->lokasikerja->ultg->upt) {
            $allUltgNames = Ultg::where('upt_id', $data->lokasikerja->ultg->upt->id)->get();
        }

        // Ambil lokasi kerja berdasarkan ULTG yang terkait
        $allLokasikerjaNames = collect();
        if ($data->lokasikerja && $data->lokasikerja->ultg) {
            $allLokasikerjaNames = Lokasikerja::where('ultg_id', $data->lokasikerja->ultg->id)->get();
        }
        // dd($allLokasikerjaNames);

        return view('datasatpam.edit', compact('data', 'allUptNames', 'allUltgNames', 'allLokasikerjaNames'));
    }

    public function detail($id)
    {
        $datasatpam = Datasatpam::findOrFail($id);
        return view('datasatpam.detail', compact('datasatpam'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|string|max:50',
            'nik' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required|string|max:255',
            'status' => 'required|string',
            'no_pkwt_pkwtt' => 'nullable|string|max:100',
            'kontrak' => 'nullable|string|max:100',
            'terhitung_mulai_tugas' => 'nullable|date',
            'jabatan' => 'required|string|max:100',
            'lokasikerja_id' => 'required|exists:lokasikerja,id',
            'wilayah_kerja' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'usia' => 'nullable|integer',
            'warga_negara' => 'required|string|in:WNI,WNA',
            'agama' => 'nullable|string',
            'no_hp' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'alamat' => 'required|string',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'negara' => 'nullable|string|max:100',
            'nama_ibu' => 'nullable|string|max:100',
            'no_kontak_darurat' => 'nullable|string|max:20',
            'nama_kontak_darurat' => 'nullable|string|max:100',
            'nama_ahli_waris' => 'nullable|string|max:100',
            'tempat_lahir_ahli_waris' => 'nullable|string|max:100',
            'tanggal_lahir_ahli_waris' => 'nullable|date',
            'hub_ahli_waris' => 'nullable|string|max:100',
            'status_nikah' => 'nullable|string|max:10',
            'jumlah_anak' => 'nullable|integer',
            'npwp' => 'nullable|string|max:30',
            'nama_bank' => 'nullable|string|max:100',
            'no_rek' => 'nullable|string|max:50',
            'nama_pemilik_rek' => 'nullable|string|max:100',
            'no_dplk' => 'nullable|string|max:50',
            'pend_terakhir' => 'nullable|string|max:100',
            'sertifikasi_satpam' => 'nullable|string|max:50',
            'no_reg_kta' => 'nullable|string|max:50',
            'no_kta' => 'nullable|string|max:50',
            'polda' => 'nullable|string|max:100',
            'polres' => 'nullable|string|max:100',
            'no_bpjs_kesehatan' => 'nullable|string|max:50',
            'no_bpjs_ketenagakerjaan' => 'nullable|string|max:50',
            'ukuran_baju' => 'nullable|string|max:10',
            'ukuran_celana' => 'nullable|integer',
            'ukuran_sepatu' => 'nullable|integer',
            'ukuran_topi' => 'nullable|integer',
        ]);

        $data = Datasatpam::findOrFail($id);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($data->foto && Storage::disk('public')->exists($data->foto)) {
                Storage::disk('public')->delete($data->foto);
            }
            
            $foto = $request->file('foto');
            $filename = time() . '_' . $data->kode_satpam . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('foto_satpam', $filename, 'public');
            $data->foto = $path;
        }

        // Update semua field
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
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir;
        $data->usia = $request->usia;
        $data->warga_negara = $request->warga_negara;
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
        $data->ukuran_sepatu = $request->ukuran_sepatu;
        $data->ukuran_topi = $request->ukuran_topi;

        $data->save();

        return redirect()->route('datasatpam.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
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
