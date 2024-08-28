<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img src="/assets/img/logo/logo3.png">
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Manajamen Surat
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master Data</h6>
                <!-- <a class="collapse-item" href="/admin/surat/arsip">Arsip Surat</a> -->
                <a class="collapse-item" href="/admin/surat/masuk/disposisi">Disposisi</a>
                <a class="collapse-item" href="/admin/kategori">Kategori Surat</a>
                <!--<a class="collapse-item" href="profil.php">Profil</a>-->
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/surat/masuk">
            <i class="fas fa-envelope"></i>
            <span>Surat Masuk</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/surat/keluar">
            <i class="fas fa-envelope-open"></i>
            <span>Surat Keluar</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/pengguna">
            <i class="fas fa-users"></i>
            <span>Pengguna</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Lainnya
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true" aria-controls="collapsePage">
            <i class="fas fa-file-pdf"></i>
            <span>Laporan</span>
        </a>
        <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Laporan Surat</h6>
                <a class="collapse-item" href="/admin/laporan/laporan_masuk">Laporan Surat Masuk</a>
                <a class="collapse-item" href="/admin/laporan/laporan_keluar">Laporan Surat Keluar</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/logout">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </li>
</ul>