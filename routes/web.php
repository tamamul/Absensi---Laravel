<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatasatpamController;
use App\Http\Controllers\JadwalsatpamController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LokasikerjaController;
use App\Http\Controllers\UltgController;
use App\Http\Controllers\UptController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Rolemiddleware;
use App\Http\Controllers\PengajuanController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::middleware('auth')->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard')->middleware('role:admin');

//     Route::get('/pimpinan/dashboard', function () {
//         return view('pimpinan.dashboard');
//     })->name('pimpinan.dashboard')->middleware('role:pimpinan');
// });

// Route::get('/', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::get('/', [DashboardController::class, 'index']);
// Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Route::middleware(['auth', 'role:Admin'])->group(function () {
//     Route::get('/admin/dashboard', [DashboardController::class, 'admin']);
// });

// Route::middleware(['auth', 'role:Pimpinan'])->group(function () {
//     Route::get('/pimpinan/dashboard', [DashboardController::class, 'pimpinan']);
// });

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin']);
    Route::get('/pimpinan/dashboard', [DashboardController::class, 'pimpinan']);
});



// Home
// Route::get('/', [AuthController::class, 'home'])->name('home');

// Admin Area
// Route::middleware(['auth', Rolemiddleware::class.':admin'])->group(function () {
//     Route::get('/admin', function () {
//         return view('admin.dashboard');
//     });
// });

// // Pimpinan Area
// Route::middleware(['auth', Rolemiddleware::class.':pimpinan'])->group(function () {
//     Route::get('/pimpinan', function () {
//         return view('pimpinan.dashboard');
//     });
// });

//Data Satpam
Route::get('/datasatpam', [DatasatpamController::class, 'index'])->name('datasatpam.index');
Route::get('/datasatpam/create', [DatasatpamController::class, 'create'])->name('datasatpam.create');
Route::post('/datasatpam', [DatasatpamController::class, 'store'])->name('datasatpam.store');
Route::get('/datasatpam/{id}/edit', [DatasatpamController::class, 'edit'])->name('datasatpam.edit');
Route::get('/datasatpam/{id}/detail', [DatasatpamController::class, 'detail'])->name('datasatpam.detail');
Route::put('/datasatpam/{id}', [DatasatpamController::class, 'update'])->name('datasatpam.update');
Route::delete('/datasatpam/{id}', [DatasatpamController::class, 'destroy'])->name('datasatpam.delete');

// Route untuk dropdown cascade
Route::get('/get-ultg/{upt_id}', [DatasatpamController::class, 'getUltg']);
Route::get('/get-lokasi-kerja/{ultg_id}', [DatasatpamController::class, 'getLokasiKerja']);


//Data UPT
Route::get('upt', [UptController::class, 'index']);
Route::get('tambah-upt', [UptController::class, 'create'])->name('upt.create');
Route::post('upt', [UptController::class, 'store'])->name('upt.store');
Route::put('upt/{id}', [UPTController::class, 'update'])->name('upt.update');
Route::get('upt/{id}/edit', [UPTController::class, 'edit'])->name('upt.edit');
Route::post('/upt/delete/{id}', [UptController::class, 'destroy'])->name('upt.delete');

//Data ULTG
Route::get('ultg', [UltgController::class, 'index']);
Route::get('ultg/create', [UltgController::class, 'create'])->name('ultg.create');
Route::post('ultg', [UltgController::class, 'store'])->name('ultg.store');
Route::get('ultg/{id}/edit', [UltgController::class, 'edit'])->name('ultg.edit'); // EDIT -> GET
Route::put('ultg/{id}', [UltgController::class, 'update'])->name('ultg.update'); // UPDATE -> PUT
Route::post('ultg/delete/{id}', [UltgController::class, 'destroy'])->name('ultg.delete'); // DESTROY -> DELETE

//Data Lokasi Kerja
Route::get('lokasikerja', [LokasikerjaController::class, 'index'])->name('lokasikerja.index');
Route::get('tambah-lokasikerja', [LokasikerjaController::class, 'create'])->name('lokasikerja.create');
Route::post('lokasikerja', [LokasikerjaController::class, 'store'])->name('lokasikerja.store');
Route::get('lokasikerja/{id}/edit', [LokasikerjaController::class, 'edit'])->name('lokasikerja.edit');
Route::put('lokasikerja/{id}', [LokasikerjaController::class, 'update'])->name('lokasikerja.update');
Route::post('lokasikerja/delete/{id}', [LokasikerjaController::class, 'destroy'])->name('lokasikerja.delete');
// Untuk ajax get ultg
Route::get('lokasikerja/get-ultg/{upt_id}', [LokasikerjaController::class, 'getUltgByUpt']);

//Data Jadwal Satpam
// Route::get('jadwalsatpam', [JadwalsatpamController::class, 'index'])->name('jadwalsatpam.index');
// Route::get('tambah-jadwalsatpam', [JadwalsatpamController::class, 'create'])->name('jadwalsatpam.create');
// Route::post('jadwalsatpam', [JadwalsatpamController::class, 'store'])->name('jadwalsatpam.store');
// Route::get('jadwalsatpam/{id}/edit', [JadwalsatpamController::class, 'edit'])->name('jadwalsatpam.edit');
// Route::put('jadwalsatpam/{id}', [JadwalsatpamController::class, 'update'])->name('jadwalsatpam.update');
// Route::post('jadwalsatpam/delete/{id}', [JadwalsatpamController::class, 'destroy'])->name('jadwalsatpam.delete');

// Data Jadwal Satpam
Route::get('/jadwalsatpam', [JadwalsatpamController::class, 'index'])->name('jadwalsatpam.index');
Route::get('/jadwalsatpam/create', [JadwalsatpamController::class, 'create'])->name('jadwalsatpam.create');
Route::post('/jadwalsatpam', [JadwalsatpamController::class, 'store'])->name('jadwalsatpam.store');
Route::get('/jadwalsatpam/edit', [JadwalsatpamController::class, 'edit'])->name('jadwalsatpam.edit');
Route::put('/jadwalsatpam', [JadwalsatpamController::class, 'update'])->name('jadwalsatpam.update');
Route::post('/jadwalsatpam/delete/{id}', [JadwalsatpamController::class, 'destroy'])->name('jadwalsatpam.destroy');
Route::get('/get-ultg/{uptId}', [JadwalsatpamController::class, 'getUltg']);
Route::get('/get-lokasi/{ultgId}', [JadwalsatpamController::class, 'getLokasiKerja']);
Route::get('/get-satpam/{lokasikerja_id}', function($lokasikerja_id) {
    return \App\Models\Datasatpam::where('lokasikerja_id', $lokasikerja_id)->pluck('nama', 'id');
});

// Riwayat
Route::get('/riwayat', [AbsensiController::class, 'index'])->name('riwayat.index');

// Route AJAX untuk filter dinamis
// Route::get('/get-ultg/{uptId}', [JadwalsatpamController::class, 'getUltg']);
// Route::get('/get-lokasi-kerja/{ultgId}', [JadwalsatpamController::class, 'getLokasiKerja']);

//Laporan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::post('/laporan/validasi', [LaporanController::class, 'validasi'])->name('laporan.validasi');
Route::get('/laporan/export', [LaporanController::class, 'exportPDF'])->name('laporan.export');
Route::get('/laporan/lokasi/{ultg_id}', [LaporanController::class, 'getLokasiKerja']);
Route::get('/laporan/view', [LaporanController::class, 'view'])->name('laporan.view');
// Route::get('/get-ultg/{upt_id}', [LaporanController::class, 'getUltg']);
// Route::get('/get-lokasi/{ultg_id}', [LaporanController::class, 'getLokasi']);
// Route::post('/view', [LaporanController::class, 'view'])->name('laporan.view');
// Route::post('/export-pdf', [LaporanController::class, 'exportPDF'])->name('laporan.export');

// Route::get('lokasikerja', [LokasikerjaController::class, 'index']);
// Route::get('tambah-lokasikerja', [LokasikerjaController::class, 'create'])->name('lokasikerja.create');
// Route::get('/lokasikerja/get-ultg/{upt_id}', [LokasikerjaController::class, 'getUltgByUpt']);
// Route::post('lokasikerja', [LokasikerjaController::class, 'store'])->name('lokasikerja.store');
// Route::put('lokasikerja/{id}', [LokasikerjaController::class, 'update'])->name('lokasikerja.update');
// Route::get('lokasikerja/{id}/edit', [LokasikerjaController::class, 'edit'])->name('lokasikerja.edit');
// Route::post('/lokasikerja/delete/{id}', [LokasikerjaController::class, 'destroy'])->name('lokasikerja.delete');

// Route::get('/datasatpam', function () {
//     return view('datasatpam');
// })->name('datasatpam');

// Route::get('/tambahdatasatpam', function () {
//     return view('tambahdatasatpam');
// })->name('tambahdatasatpam');

// Route::get('/dataupt', function () {
//     return view('dataupt');
// })->name('dataupt');

// Route::get('/tambahdataupt', function () {
//     return view('tambahdataupt');
// })->name('tambahdataupt');

// Route::get('/dataultg', function () {
//     return view('dataultg');
// })->name('dataultg');

// Route::get('/tambahdataultg', function () {
//     return view('tambahdataultg');
// })->name('tambahdataultg');

// Route::get('/datalokasi', function () {
//     return view('datalokasi');
// })->name('datalokasi');

// Route::get('/tambahdatalokasi', function () {
//     return view('tambahdatalokasi');
// })->name('tambahdatalokasi');

// Route::get('/jadwalsatpam', function () {
//     return view('jadwalsatpam');
// })->name('jadwalsatpam');

// Route::get('/tambahjadwalsatpam', function () {
//     return view('tambahjadwalsatpam');
// })->name('tambahjadwalsatpam');

// Route::get('/riwayat', function () {
//     return view('riwayat');
// })->name('riwayat');

Route::get('/form', function () {
    return view('form');
})->name('form');

Route::get('/tabel', function () {
    return view('tabel');
})->name('tabel');

Route::post('/jadwalsatpam/import-excel', [App\Http\Controllers\JadwalsatpamController::class, 'importExcel'])->name('jadwalsatpam.importExcel');

Route::get('/sample_jadwal_satpam.xlsx', [App\Http\Controllers\JadwalsatpamController::class, 'downloadSampleExcel']);

// Routes Pengajuan
Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
Route::get('/pengajuan/{id}', [PengajuanController::class, 'show'])->name('pengajuan.show');
Route::put('/pengajuan/{id}/status', [PengajuanController::class, 'updateStatus'])->name('pengajuan.updateStatus');
Route::delete('/pengajuan/{id}', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');
Route::get('/pengajuan-filter', [PengajuanController::class, 'filter'])->name('pengajuan.filter');
Route::get('/pengajuan-export', [PengajuanController::class, 'export'])->name('pengajuan.export');