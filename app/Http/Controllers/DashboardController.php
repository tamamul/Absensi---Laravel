<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datasatpam;
use App\Models\Lokasikerja;
use App\Models\Jadwalsatpam;
use App\Models\Upt;
use App\Models\Ultg;

class DashboardController extends Controller
{
    //

    public function admin()
    {
        $totalSatpam = Datasatpam::count();
        $totalUpt = Upt::count();
        $totalUltg = Ultg::count();
        $totalLoker = Lokasikerja::count();

        return view('admin.dashboard', compact('totalSatpam', 'totalUpt', 'totalUltg', 'totalLoker'));
    }

    public function pimpinan()
    {
        $totalSatpam = Datasatpam::count();
        $totalUpt = Upt::count();
        $totalUltg = Ultg::count();
        $totalLoker = Lokasikerja::count();

        return view('pimpinan.dashboard', compact('totalSatpam', 'totalUpt', 'totalUltg', 'totalLoker'));
    }

    public function index()
    {
        $totalDatasatpam = Datasatpam::count();
        $totalLokasikerja = Lokasikerja::count();
        $totalJadwalsatpam = Jadwalsatpam::count();

        return view('dashboard', compact('totalDatasatpam', 'totalLokasikerja', 'totalJadwalsatpam'));
    }
}
