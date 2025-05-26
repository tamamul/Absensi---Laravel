<div class="sidebar sidebar-style-2" style="background-color: #2F3192;">			
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
    <ul class="nav nav-primary ">

<li class="nav-section">
    <span class="sidebar-mini-icon">
        <i class="fa fa-ellipsis-h"></i>
    </span>
    <h4 class="text-section">Dashboard</h4>
</li>

<!-- Hanya tampilkan menu jika role pengguna adalah Admin -->
@if(Auth::check() && Auth::user()->role == 'Admin')
    <li class="nav-item {{ \Route::is('dashboard') ? 'active' : '' }}">
        <a href="/admin/dashboard">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="/tampil-datasatpam">
            <i class="fas fa-th-list"></i>
            <p>Data Satpam</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="/upt">
            <i class="fas fa-th-list"></i>
            <p>Data UPT</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="/ultg">
            <i class="fas fa-th-list"></i>
            <p>Data ULTG</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="/lokasikerja">
            <i class="fas fa-th-list"></i>
            <p>Data Lokasi Kerja</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="/jadwalsatpam">
            <i class="fas fa-th-list"></i>
            <p>Jadwal Satpam</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('riwayat.index') }}">
            <i class="fas fa-th-list"></i>
            <p>Riwayat Absensi Satpam</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="/laporan">
            <i class="fas fa-th-list"></i>
            <p>Laporan</p>
        </a>
    </li>

    <!-- <li class="nav-item {{ \Route::is('tabel') ? 'active' : '' }}">
        <a href="/tabel">
            <i class="fas fa-th-list"></i>
            <p>Tabel</p>
        </a>
    </li> -->
@endif

<!-- Hanya tampilkan menu jika role pengguna adalah Admin -->
@if(Auth::check() && Auth::user()->role == 'Pimpinan')
    <li class="nav-item {{ \Route::is('dashboard') ? 'active' : '' }}">
        <a href="/admin/dashboard">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="/tampil-datasatpam">
            <i class="fas fa-th-list"></i>
            <p>Data Satpam</p>
        </a>
    </li>

    <!-- <li class="nav-item">
        <a href="/upt">
            <i class="fas fa-th-list"></i>
            <p>Data UPT</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="/ultg">
            <i class="fas fa-th-list"></i>
            <p>Data ULTG</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="/lokasikerja">
            <i class="fas fa-th-list"></i>
            <p>Data Lokasi Kerja</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="/jadwalsatpam">
            <i class="fas fa-th-list"></i>
            <p>Jadwal Satpam</p>
        </a>
    </li> -->
    <li class="nav-item">
        <a href="/riwayat">
            <i class="fas fa-th-list"></i>
            <p>Riwayat Absensi Satpam</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="/laporan">
            <i class="fas fa-th-list"></i>
            <p>Laporan</p>
        </a>
    </li>

    <!-- <li class="nav-item {{ \Route::is('tabel') ? 'active' : '' }}">
        <a href="/tabel">
            <i class="fas fa-th-list"></i>
            <p>Tabel</p>
        </a>
    </li> -->
@endif

</ul>

    </div>
  </div>
</div>
