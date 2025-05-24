<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datasatpam;
use App\Models\Lokasikerja;
use App\Models\Jadwalsatpam;

class DashboardController extends Controller
{
    //

    public function admin()
    {
        return view('admin.dashboard');
    }

    public function pimpinan()
    {
        return view('pimpinan.dashboard');
    }
    public function index()
    {
        $totalDatasatpam = Datasatpam::count();
        $totalLokasikerja = Lokasikerja::count();
        $totalJadwalsatpam = Jadwalsatpam::count();

        return view('dashboard', compact('totalDatasatpam', 'totalLokasikerja', 'totalJadwalsatpam'));
    }
}
