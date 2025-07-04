<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Datasatpam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with('datasatpam')->latest()->get();
        return view('pengajuan.index', compact('pengajuans'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with('datasatpam')->findOrFail($id);
        return view('pengajuan.show', compact('pengajuan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_admin' => 'required|string|max:255'
        ]);

        $pengajuan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin
        ]);

        // Kirim notifikasi ke satpam (bisa ditambahkan nanti)
        
        return redirect()->route('pengajuan.index')
            ->with('success', 'Status pengajuan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        
        // Hapus file bukti jika ada
        if ($pengajuan->bukti_foto) {
            $path = str_replace(url('/'), '', $pengajuan->bukti_foto);
            if (file_exists(public_path($path))) {
                unlink(public_path($path));
            }
        }

        $pengajuan->delete();

        return redirect()->route('pengajuan.index')
            ->with('success', 'Pengajuan berhasil dihapus');
    }

    public function filter(Request $request)
    {
        $query = Pengajuan::with('datasatpam');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->jenis_pengajuan) {
            $query->where('jenis_pengajuan', $request->jenis_pengajuan);
        }

        if ($request->tanggal_mulai) {
            $query->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai);
        }

        if ($request->tanggal_selesai) {
            $query->whereDate('tanggal_selesai', '<=', $request->tanggal_selesai);
        }

        $pengajuans = $query->latest()->get();
        return view('pengajuan.index', compact('pengajuans'));
    }

    public function export()
    {
        $pengajuans = Pengajuan::with('datasatpam')->get();
        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Satpam');
        $sheet->setCellValue('C1', 'Jenis Pengajuan');
        $sheet->setCellValue('D1', 'Tanggal Mulai');
        $sheet->setCellValue('E1', 'Tanggal Selesai');
        $sheet->setCellValue('F1', 'Status');
        $sheet->setCellValue('G1', 'Catatan Admin');
        
        $row = 2;
        foreach ($pengajuans as $index => $pengajuan) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $pengajuan->datasatpam->nama);
            $sheet->setCellValue('C' . $row, ucfirst($pengajuan->jenis_pengajuan));
            $sheet->setCellValue('D' . $row, $pengajuan->tanggal_mulai);
            $sheet->setCellValue('E' . $row, $pengajuan->tanggal_selesai);
            $sheet->setCellValue('F' . $row, ucfirst($pengajuan->status));
            $sheet->setCellValue('G' . $row, $pengajuan->catatan_admin);
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'laporan_pengajuan_' . date('Y-m-d') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }
} 