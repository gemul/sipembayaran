<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <li class="nav-item <?php echo $this->uri->segment(2) == '' ? 'active': '' ?>">
        <a class="nav-link" href="<?php echo site_url('admin') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Overview</span>
        </a>
    </li>
    <li class="nav-item  <?php echo $this->uri->segment(2) == 'tanggungan' ? 'active': '' ?>">
        <a class="nav-link" href="<?php echo site_url('admin/tanggungan') ?>">
            <i class="fas fa-fw fa-clipboard"></i>
            <span>Biaya Mahasiswa</span></a>
    </li>
    <li class="nav-item  <?php echo $this->uri->segment(2) == 'transaksi' ? 'active': '' ?>">
        <a class="nav-link" href="<?php echo site_url('admin/transaksi') ?>">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Transaksi</span></a>
    </li>
    <li class="nav-item  <?php echo $this->uri->segment(2) == 'transaksi' ? 'active': '' ?>">
        <a class="nav-link" href="<?php echo site_url('admin/transaksi/listTransaksi') ?>">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>List Transaksi</span></a>
    </li>
    <li class="nav-item  <?php echo $this->uri->segment(2) == 'mahasiswa' ? 'active': '' ?>">
        <a class="nav-link" href="<?php echo site_url('admin/mahasiswa') ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Mahasiswa</span></a>
    </li>
    <li class="nav-item  <?php echo $this->uri->segment(2) == 'products' ? 'active': '' ?>">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-user"></i>
            <span>Users</span></a>
    </li>
    <li class="nav-item dropdown <?php echo $this->uri->segment(2) == 'products' ? 'active': '' ?>">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Laporan</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" title="Tampilkan Tanggungan" target="_blank" href="<?php echo site_url('admin/tanggungan/report_all') ?>">
                <i class="fas fa-fw fa-file"></i>
                <span>Tanggungan</span></a>
            <a class="dropdown-item" title="Unduh Tanggungan" target="_blank" href="<?php echo site_url('admin/tanggungan/report_all_csv') ?>">
                <i class="fas fa-fw fa-download"></i>
                <span>Tanggungan</span></a>
        </div>
    </li>
</ul>