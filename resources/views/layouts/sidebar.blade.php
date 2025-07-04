<div class="sidebar sidebar-style-2"
    style="background: linear-gradient(135deg, #2F3192 60%, #1B1B4D 100%); min-height: 100vh;">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">

                <li class="nav-section mt-3 mb-2">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section text-white">Menu</h4>
                </li>

                <!-- Hanya tampilkan menu jika role pengguna adalah Admin -->
                @if (Auth::check() && Auth::user()->role == 'Admin')
                    <li class="nav-item {{ \Route::is('dashboard') ? 'active' : '' }}">
                        <a href="/admin/dashboard">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/datasatpam">
                            <i class="fas fa-user-shield"></i>
                            <span>Data Satpam</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/upt">
                            <i class="fas fa-building"></i>
                            <span>Data UPT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/ultg">
                            <i class="fas fa-server"></i>
                            <span>Data ULTG</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/lokasikerja">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Data Lokasi Kerja</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/jadwalsatpam">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Jadwal Satpam</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('riwayat.index') }}">
                            <i class="fas fa-history"></i>
                            <span>Riwayat Absensi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pengajuan.index') }}">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Pengajuan</span>
                            @php
                                $pendingCount = \App\Models\Pengajuan::where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge badge-warning ml-auto">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/laporan">
                            <i class="fas fa-file-alt"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                @endif

                <!-- Hanya tampilkan menu jika role pengguna adalah Admin -->
                @if (Auth::check() && Auth::user()->role == 'Pimpinan')
                    <li class="nav-item {{ \Route::is('dashboard') ? 'active' : '' }}">
                        <a href="/pimpinan/dashboard">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/datasatpam">
                            <i class="fas fa-user-shield"></i>
                            <span>Data Satpam</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/riwayat">
                            <i class="fas fa-history"></i>
                            <span>Riwayat Absensi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/laporan">
                            <i class="fas fa-file-alt"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                @endif

            </ul>

        </div>
    </div>
</div>

<style>
    .sidebar {
        color: #ffffff !important;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    .sidebar .nav-item {
        margin-bottom: 8px;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .sidebar .nav-item a {
        color: #ffffff;
        display: flex;
        align-items: center;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 15px;
        transition: background 0.2s, color 0.2s;
    }

    .sidebar .nav-item a i {
        margin-right: 12px;
        font-size: 18px;
        min-width: 22px;
        text-align: center;
    }

    .sidebar .nav-item.active>a,
    .sidebar .nav-item a:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #FFD600;
        text-decoration: none;
    }

    .sidebar .nav-section h4 {
        font-size: 13px;
        letter-spacing: 1px;
        margin: 0;
        color: #FFD600;
        font-weight: 600;
    }

    .sidebar .nav-section {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding-bottom: 8px;
        margin-bottom: 10px;
    }

    .sidebar .nav-item span {
        font-weight: 500;
        color: #ffffff
    }
</style>
