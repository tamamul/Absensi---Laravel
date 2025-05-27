<div class="sidebar sidebar-style-2" style="background-color: #2F3192;">			
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-primary ">

        
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section ">Dashboard</h4>
        </li>
        <li class="nav-item {{ \Route::is('dashboard') ? 'active' : '' }}">
          <a href="/">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <!-- <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Menu</h4>
        </li> -->
        <li class="nav-item">
          <a href="/datasatpam">
            <i class="fas fa-th-list"></i>
            <p>Data Satpam</p>
          </a>
        </li>

        <!-- <li class="nav-item {{ \Route::is('/upt') ? 'active' : '' }} submenu">
          <a data-toggle="collapse" href="/upt">
            <i class="fas fa-pen-square"></i>
            <p>Data Master</p>
            <span class="caret"></span>
          </a>
          <div class="collapse {{ \Route::is('/upt') ? 'show' : '' }}">
            <ul class="nav nav-collapse">
              <li class="{{ \Route::is('/upt') ? 'active' : '' }}">
                <a href="/upt">
                  <span class="sub-item">Data UPT</span>
                </a>
              </li>
              <li class="{{ \Route::is('/ultg') ? 'active' : '' }}">
                <a href="/ultg">
                  <span class="sub-item">Data ULTG</span>
                </a>
              </li>
            </ul>
          </div>
          
        </li> -->

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
            
        <li class="nav-item {{ \Route::is('tabel') ? 'active' : '' }}">
          <a href="/tabel">
            <i class="fas fa-th-list"></i>
            <p>Tabel</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
