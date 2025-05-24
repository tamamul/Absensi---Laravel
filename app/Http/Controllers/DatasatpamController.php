<?php

namespace App\Http\Controllers;

use App\Models\Lokasikerja;
use App\Models\Ultg;
use App\Models\Upt;
use Illuminate\Http\Request;
use App\Models\Datasatpam;

class DatasatpamController extends Controller
{
    //
    public function index(){
        $data = Datasatpam::all();
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
    public function store(Request $request){

        $request->validate([
        'nip' => 'required',
        'nik' => 'required',
        'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'nama' => 'required|string|max:255',
        'status' => 'required|in:PKWT,PKWTT',
        'no_kontrak' => 'required',
        'kontrak' => 'required',
        'tmt' => 'required|date',
        'jabatan' => 'required',
        'upt_id' => 'required|exists:upt,id',
        'ultg_id' => 'required|exists:ultg,id',
        'lokasi_kerja_id' => 'required|exists:lokasi_kerja,id',
        'wilayah_kerja' => 'required',
        'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|date',
        'usia' => 'required|numeric|min:17',
        'warga_negara' => 'required|in:WNI,WNA',
        'agama' => 'required',
        'no_hp' => 'required',
        'email' => 'nullable|email',
        'alamat' => 'required',
        'kelurahan' => 'required',
        'kecamatan' => 'required',
        'kabupaten' => 'required',
        'provinsi' => 'required',
        'negara' => 'required',
        'nama_ibu' => 'required',
        'no_kontak_darurat' => 'required',
        'nama_kontak_darurat' => 'required',
        'nama_ahli_waris' => 'required',
        'tempat_lahir_ahli_waris' => 'required',
        'tanggal_lahir_ahli_waris' => 'required|date',
        'hub_ahli_waris' => 'required',
        'status_nikah' => 'required',
        'jumlah_anak' => 'required|numeric|min:0',
        'npwp' => 'required',
        'nama_bank' => 'required',
        'no_rek' => 'required',
        'nama_pemilik_rek' => 'required',
        'no_dplk' => 'required',
        'pend_terakhir' => 'required',
        'sertifikasi_satpam' => 'required',
        'no_reg_kta' => 'required',
        'no_kta' => 'required',
        'polda' => 'required',
        'polres' => 'required',
        'no_bpjs_kesehatan' => 'required',
        'no_bpjs_ketenagakerjaan' => 'required',
        'ukuran_baju' => 'required',
        'ukuran_celana' => 'required',
        'ukuran_sepatu' => 'required',
        'ukuran_topi' => 'required',
    ], [
        'nip.required' => 'NIP wajib diisi.',
        'nik.required' => 'NIK wajib diisi.',
        'foto.required' => 'Foto wajib diunggah.',
        'foto.image' => 'File foto harus berupa gambar.',
        'nama.required' => 'Nama lengkap wajib diisi.',
        'status.required' => 'Status wajib dipilih.',
        'no_kontrak.required' => 'No kontrak wajib diisi.',
        'tmt.required' => 'Tanggal mulai tugas wajib diisi.',
        'upt_id.required' => 'Nama UPT wajib dipilih.',
        'ultg_id.required' => 'Nama ULTG wajib dipilih.',
        'lokasi_kerja_id.required' => 'Lokasi kerja wajib dipilih.',
        'wilayah_kerja.required' => 'Wilayah kerja wajib diisi.',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
        'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
        'usia.required' => 'Usia wajib diisi.',
        'warga_negara.required' => 'Warga negara wajib dipilih.',
        'agama.required' => 'Agama wajib dipilih.',
        'no_hp.required' => 'Nomor HP wajib diisi.',
        'email.nullable' => 'Email wajib diisi',
        'alamat.required' => 'Alamat wajib diisi.',
        'kelurahan.required' => 'Kelurahan wajib diisi.',
        'kecamatan.required' => 'Kecamatan wajib diisi.',
        'kabupaten.required' => 'Kabupaten/Kota wajib diisi.',
        'provinsi.required' => 'Provinsi wajib diisi.',
        'negara.required' => 'Negara wajib diisi.',
        'nama_ibu.required' => 'Nama ibu wajib diisi.',
        'no_kontak_darurat.required' => 'Nomor kontak darurat wajib diisi.',
        'nama_kontak_darurat.required' => 'Nama kontak darurat wajib diisi.',
        'nama_ahli_waris.required' => 'Nama ahli waris wajib diisi.',
        'tempat_lahir_ahli_waris.required' => 'Tempat lahir ahli waris wajib diisi.',
        'tanggal_lahir_ahli_waris.required' => 'Tanggal lahir ahli waris wajib diisi.',
        'hub_ahli_waris.required' => 'Hubungan ahli waris wajib diisi.',
        'status_nikah.required' => 'Status nikah wajib diisi.',
        'jumlah_anak.required' => 'Jumlah anak wajib diisi.',
        'npwp.required' => 'NPWP wajib diisi',
        'nama_bank.required' => 'Nama bank wajib diisi.',
        'no_rek.required' => 'No rekening wajib diisi.',
        'nama_pemilik_rek.required' => 'Nama pemilik rekening wajib diisi.',
        'no_dplk.required' => 'No. DPLK wajib diisi',
        'pend_terakhir.required' => 'Pendidikan terakhir wajib dipilih.',
        'sertifikasi_satpam.required' => 'Sertifikasi wajib dipilih.',
        'no_reg_kta.required' => 'Nomor registrasi KTA wajib diisi.',
        'no_kta.required' => 'Nomor KTA wajib diisi.',
        'polda.required' => 'Polda wajib diisi.',
        'polres.required' => 'Polres wajib diisi.',
        'no_bpjs_kesehatan.required' => 'Nomor BPJS Kesehatan wajib diisi.',
        'no_bpjs_ketenagakerjaan.required' => 'Nomor BPJS Ketenagakerjaan wajib diisi.',
        'ukuran_baju.required' => 'Ukuran baju wajib dipilih.',
        'ukuran_celana.required' => 'Ukuran celana wajib diisi.',
        'ukuran_sepatu.required' => 'Ukuran sepatu wajib diisi.',
        'ukuran_topi.required' => 'Ukuran topi wajib diisi.',
    ]);
            

        // $request->validate([
        //     'upt_id' => 'required|exists:upt,id',
        //     'ultg_id' => 'required|exists:ultg,id',
        //     'lokasikerja_id' => 'required|string|max:255|unique:upt,nama_upt',
        //     'latitude' => 'required|numeric',
        //     'longitude' => 'required|numeric',
        //     'radius' => 'required|numeric',
        // ], [
        //     'upt_id.required' => 'Nama UPT wajib dipilih.',
        //     'ultg_id.required' => 'Nama ULTG wajib dipilih.',
        //     'lokasikerja_id.required' => 'Nama Lokasi Kerja wajib dipilih.',
        //     'nip.required' => 'NIP wajib diisi.',
        //     'nik.required' => 'NIK wajib diisi.',
        //     'foto.required' => 'Foto wajib diisi.',
        //     'nama.required' => 'Nama Lengkap wajib diisi.',
              
        // ]);

        $satpam = new Datasatpam();
        $satpam->id = $request->id;
        $satpam->nip = $request->nip;
        $satpam->nik = $request->nik;
        $satpam->foto = $request->file('foto') ? $request->file('foto')->store('foto') : null;
        $satpam->nama = $request->nama;
        $satpam->pekerjaan = $request->pekerjaan;
        $satpam->status = $request->status;
        $satpam->no_kontrak = $request->no_kontrak;
        $satpam->kontrak = $request->kontrak;
        $satpam->tmt = $request->tmt;
        $satpam->jabatan = $request->jabatan;
        $satpam->upt_id = $request->upt_id;
        $satpam->ultg_id = $request->ultg_id;
        $satpam->lokasi_kerja_id = $request->lokasi_kerja_id;
        $satpam->wilayah_kerja = $request->wilayah_kerja;
        $satpam->jenis_kelamin = $request->jenis_kelamin;
        $satpam->tempat_lahir = $request->tempat_lahir;
        $satpam->tanggal_lahir = $request->tanggal_lahir;
        $satpam->usia = $request->usia;
        $satpam->warga_negara = $request->warga_negara;
        $satpam->agama = $request->agama;
        $satpam->no_hp = $request->no_hp;
        $satpam->email = $request->email;
        $satpam->alamat = $request->alamat;
        $satpam->kelurahan = $request->kelurahan;
        $satpam->kecamatan = $request->kecamatan;
        $satpam->kabupaten = $request->kabupaten;
        $satpam->provinsi = $request->provinsi;
        $satpam->negara = $request->negara;
        $satpam->nama_ibu = $request->nama_ibu;
        $satpam->kontak_darurat = $request->kontak_darurat;
        $satpam->nama_kontak_darurat = $request->nama_kontak_darurat;
        $satpam->ahli_waris = $request->ahli_waris;
        $satpam->tempat_lahir_ahli_waris = $request->tempat_lahir_ahli_waris;
        $satpam->tanggal_lahir_ahli_waris = $request->tanggal_lahir_ahli_waris;
        $satpam->hub_ahli_waris = $request->hub_ahli_waris;
        $satpam->status_nikah = $request->status_nikah;
        $satpam->jumlah_anak = $request->jumlah_anak;
        $satpam->npwp = $request->npwp;
        $satpam->nama_bank = $request->nama_bank;
        $satpam->no_rek = $request->no_rek;
        $satpam->nama_pemilik_rek = $request->nama_pemilik_rek;
        $satpam->no_dplk = $request->no_dplk;
        $satpam->pend_terakhir = $request->pend_terakhir;
        $satpam->sertifikasi_satpam = $request->sertifikasi_satpam;
        $satpam->no_reg_kta = $request->no_reg_kta;
        $satpam->no_kta = $request->no_kta;
        $satpam->polda = $request->polda;
        $satpam->polres = $request->polres;
        $satpam->no_bpjs_kesehatan = $request->no_bpjs_kesehatan;
        $satpam->no_bpjs_ketenagakerjaan = $request->no_bpjs_ketenagakerjaan;
        $satpam->ukuran_baju = $request->ukuran_baju;
        $satpam->ukuran_celana = $request->ukuran_celana;
        $satpam->ukuran_sepatu = $request->ukuran_sepatu;
        $satpam->ukuran_topi = $request->ukuran_topi;

        $satpam->save();

        return redirect()->route('datasatpam.index')->with('success', 'Data Satpam berhasil ditambahkan');
        
        // $data->save();
        // return redirect('/tampil-datasatpam');
    }
    public function edit($id){
        $data = Datasatpam::find($id);
        return view('datasatpam.edit', compact('data'));
    }
    public function update(Request $request, $id){
        $data = Datasatpam::find($id);
        $data->nip = $request->nip;
        $data->update();
        return redirect('/tampil-datasatpam');
    }

    public function destroy($id){
        $data = Datasatpam::find($id);
        $data->delete();
        return redirect('/tampil-datasatpam');
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
