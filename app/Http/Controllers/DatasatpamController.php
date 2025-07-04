<?php

namespace App\Http\Controllers;

use App\Models\Lokasikerja;
use App\Models\Ultg;
use App\Models\Upt;
use Illuminate\Http\Request;
use App\Models\Datasatpam;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
                    $item->foto_url = asset('storage/foto_satpam/default_avatar.jpg');
                }
                return $item;
            });
        return view('datasatpam.index', ['dataDatasatpam' => $data]);
    }

    public function create()
    {
        $allUptNames = Upt::all();
        $allUltgNames = Ultg::all();
        $allLokasikerjaNames = Lokasikerja::all();

        // Generate kode satpam
        $lastData = Datasatpam::orderBy('id', 'desc')->first();
        $lastNumber = $lastData ? intval(substr($lastData->kode_satpam, -3)) : 0;
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $newID = 'STPM' . $newNumber;

        return view('datasatpam.create', compact('allUptNames', 'allUltgNames', 'allLokasikerjaNames', 'newID'));
    }

    public function store(Request $request)
    {
        \Log::info('Proses tambah satpam dimulai', ['input' => $request->all()]);
        \Log::info('Request POST store', $request->all());
        try {
            $request->validate([
            'kode_satpam' => 'required|unique:datasatpam,kode_satpam',
                'nip' => 'required|unique:datasatpam,nip',
                'nik' => 'required|unique:datasatpam,nik',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'nama' => 'required|string',
                'status' => 'required|in:PKWT,PKWTT',
                'no_pkwt_pkwtt' => 'required|unique:datasatpam,no_pkwt_pkwtt',
                'kontrak' => 'nullable|string',
            'terhitung_mulai_tugas' => 'required|date',
                'jabatan' => 'required|in:Komandan Regu,Anggota',
            'lokasikerja_id' => 'required|exists:lokasikerja,id',
                'wilayah_kerja' => 'nullable|string',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
                'warga_negara' => 'required|in:WNI,WNA',
            'agama' => 'required|string',
                'no_hp' => 'required|string',
                'email' => 'nullable|email',
                'alamat' => 'required|string',
                'kelurahan' => 'nullable|string',
                'kecamatan' => 'nullable|string',
                'kabupaten' => 'nullable|string',
                'provinsi' => 'nullable|string',
                'negara' => 'nullable|string',
                'nama_ibu' => 'nullable|string',
                'no_kontak_darurat' => 'nullable|string',
                'nama_kontak_darurat' => 'nullable|string',
                'nama_ahli_waris' => 'nullable|string',
                'tempat_lahir_ahli_waris' => 'nullable|string',
            'tanggal_lahir_ahli_waris' => 'nullable|date',
                'hub_ahli_waris' => 'nullable|string',
                'status_nikah' => 'nullable|in:TK,K,K1,K2,K3,K4',
            'jumlah_anak' => 'nullable|integer',
                'npwp' => 'nullable|string',
                'nama_bank' => 'nullable|string',
                'no_rek' => 'nullable|unique:datasatpam,no_rek',
                'nama_pemilik_rek' => 'nullable|string',
                'no_dplk' => 'nullable|unique:datasatpam,no_dplk',
                'pend_terakhir' => 'nullable|string',
                'sertifikasi_satpam' => 'required|in:Gada Pratama,Gada Madya,Gada Utama',
                'no_reg_kta' => 'nullable|unique:datasatpam,no_reg_kta',
                'no_kta' => 'nullable|unique:datasatpam,no_kta',
                'polda' => 'nullable|string',
                'polres' => 'nullable|string',
                'no_bpjs_kesehatan' => 'nullable|unique:datasatpam,no_bpjs_kesehatan',
                'no_bpjs_ketenagakerjaan' => 'nullable|unique:datasatpam,no_bpjs_ketenagakerjaan',
                'ukuran_baju' => 'nullable|in:S,M,L,XL,XXL',
            'ukuran_celana' => 'nullable|integer',
            'ukuran_sepatu' => 'nullable|integer',
            'ukuran_topi' => 'nullable|integer',
            ]);
            \Log::info('Validasi tambah satpam sukses');
            $data = new Datasatpam($request->all());
            $data->ukuran_sepatu = $request->filled('ukuran_sepatu') ? $request->input('ukuran_sepatu') : 0;
            $data->warga_negara = $request->input('warga_negara');
            
            // Set default pekerjaan
            $data->pekerjaan = 'Satpam';

            // Hitung usia
            if ($request->tanggal_lahir) {
                $data->usia = Carbon::parse($request->tanggal_lahir)->age;
            }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
                $filename = time() . '_' . $request->kode_satpam . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('foto_satpam', $filename, 'public');
            $data->foto = $path;
        }

        $data->save();
            \Log::info('Data satpam berhasil disimpan', ['id' => $data->id]);
            return redirect()->route('datasatpam.index')
                ->with('success', 'Data satpam berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Tambah satpam gagal', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Gagal tambah data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = Datasatpam::with(['lokasikerja.ultg.upt'])->findOrFail($id);
        $allUptNames = Upt::all();
        $allUltgNames = Ultg::all();
        $allLokasikerjaNames = Lokasikerja::all();

        return view('datasatpam.edit', compact('data', 'allUptNames', 'allUltgNames', 'allLokasikerjaNames'));
    }

    public function update(Request $request, $id)
    {
        \Log::info('Proses update satpam dimulai', ['id' => $id, 'input' => $request->all()]);
        \Log::info('Request POST update', $request->all());
        try {
            $datasatpam = Datasatpam::findOrFail($id);
        $request->validate([
                'nip' => 'required|unique:datasatpam,nip,' . $id . ',id',
                'nik' => 'required|unique:datasatpam,nik,' . $id . ',id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'nama' => 'required|string',
                'status' => 'required|in:PKWT,PKWTT',
                'no_pkwt_pkwtt' => 'required|unique:datasatpam,no_pkwt_pkwtt,' . $id . ',id',
                'kontrak' => 'nullable|string',
                'terhitung_mulai_tugas' => 'required|date',
                'jabatan' => 'required|in:Komandan Regu,Anggota',
            'lokasikerja_id' => 'required|exists:lokasikerja,id',
                'wilayah_kerja' => 'nullable|string',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'tempat_lahir' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'warga_negara' => 'required|in:WNI,WNA',
                'agama' => 'required|string',
                'no_hp' => 'required|string',
                'email' => 'nullable|email',
            'alamat' => 'required|string',
                'kelurahan' => 'nullable|string',
                'kecamatan' => 'nullable|string',
                'kabupaten' => 'nullable|string',
                'provinsi' => 'nullable|string',
                'negara' => 'nullable|string',
                'nama_ibu' => 'nullable|string',
                'no_kontak_darurat' => 'nullable|string',
                'nama_kontak_darurat' => 'nullable|string',
                'nama_ahli_waris' => 'nullable|string',
                'tempat_lahir_ahli_waris' => 'nullable|string',
            'tanggal_lahir_ahli_waris' => 'nullable|date',
                'hub_ahli_waris' => 'nullable|string',
                'status_nikah' => 'nullable|in:TK,K,K1,K2,K3,K4',
            'jumlah_anak' => 'nullable|integer',
                'npwp' => 'nullable|string',
                'nama_bank' => 'nullable|string',
                'no_rek' => 'nullable|unique:datasatpam,no_rek,' . $id . ',id',
                'nama_pemilik_rek' => 'nullable|string',
                'no_dplk' => 'nullable|unique:datasatpam,no_dplk,' . $id . ',id',
                'pend_terakhir' => 'nullable|string',
                'sertifikasi_satpam' => 'required|in:Gada Pratama,Gada Madya,Gada Utama',
                'no_reg_kta' => 'nullable|unique:datasatpam,no_reg_kta,' . $id . ',id',
                'no_kta' => 'nullable|unique:datasatpam,no_kta,' . $id . ',id',
                'polda' => 'nullable|string',
                'polres' => 'nullable|string',
                'no_bpjs_kesehatan' => 'nullable|unique:datasatpam,no_bpjs_kesehatan,' . $id . ',id',
                'no_bpjs_ketenagakerjaan' => 'nullable|unique:datasatpam,no_bpjs_ketenagakerjaan,' . $id . ',id',
                'ukuran_baju' => 'nullable|in:S,M,L,XL,XXL',
            'ukuran_celana' => 'nullable|integer',
            'ukuran_sepatu' => 'nullable|integer',
            'ukuran_topi' => 'nullable|integer',
        ]);
            $data = $request->all();
            $data['ukuran_sepatu'] = $request->filled('ukuran_sepatu') ? $request->input('ukuran_sepatu') : 0;
            $data['warga_negara'] = $request->input('warga_negara');
            $data['pekerjaan'] = 'Satpam';
            if ($request->tanggal_lahir) {
                $data['usia'] = Carbon::parse($request->tanggal_lahir)->age;
            }
            if ($request->hasFile('foto')) {
                if ($datasatpam->foto) {
                    Storage::delete('public/' . $datasatpam->foto);
            }
            $foto = $request->file('foto');
                $filename = time() . '_' . $datasatpam->kode_satpam . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('foto_satpam', $filename, 'public');
                $data['foto'] = $path;
        }
            $datasatpam->update($data);
            \Log::info('Update satpam berhasil', ['id' => $id]);
            return redirect()->route('datasatpam.index')
                ->with('success', 'Data satpam berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Update satpam gagal', ['id' => $id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $datasatpam = Datasatpam::findOrFail($id);
        
        // Delete photo if exists
        if ($datasatpam->foto) {
            Storage::delete('public/' . $datasatpam->foto);
        }
        
        $datasatpam->delete();

        return redirect()->route('datasatpam.index')
            ->with('success', 'Data satpam berhasil dihapus');
    }

    public function getUltg($uptId)
    {
        $ultgs = Ultg::where('upt_id', $uptId)->pluck('nama_ultg', 'id');
        return response()->json($ultgs);
    }

    public function getLokasi($ultgId)
    {
        $lokasiKerjas = \App\Models\Lokasikerja::where('ultg_id', $ultgId)->pluck('nama_lokasikerja', 'id');
        return response()->json($lokasiKerjas);
    }
}
