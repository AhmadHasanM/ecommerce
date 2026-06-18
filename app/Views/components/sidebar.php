<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == '') ? "" : "collapsed" ?>" href="<?= base_url('/') ?>">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'keranjang') ? "" : "collapsed" ?>" href="<?= base_url('keranjang') ?>">
                <i class="bi bi-cart-check"></i>
                <span>Keranjang</span>
            </a>
        </li>
        <?php
        if (session()->get('role') == 'admin') {
        ?>
        
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'produk') ? "" : "collapsed" ?>" href="<?= base_url('produk') ?>">
                <i class="bi bi-receipt"></i>
                <span>Produk</span>
            </a>
        </li>
        <?php
        }
        ?>

        <?php if (session()->get('role') == 'admin') { ?>
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'penjualan') ? "" : "collapsed" ?>" href="<?= base_url('penjualan') ?>">
                <i class="bi bi-card-list"></i>
                <span>Penjualan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (strpos(uri_string(), 'laporan/pendapatan') === 0) ? '' : 'collapsed' ?>" href="<?= base_url('laporan/pendapatan') ?>">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Laporan Pendapatan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'laporan/produk-terlaris') ? '' : 'collapsed' ?>" href="<?= base_url('laporan/produk-terlaris') ?>">
                <i class="bi bi-trophy"></i>
                <span>Produk Terlaris</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'laporan/piutang') ? '' : 'collapsed' ?>" href="<?= base_url('laporan/piutang') ?>">
                <i class="bi bi-cash-coin"></i>
                <span>Piutang Pelanggan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'laporan/arus-kas') ? '' : 'collapsed' ?>" href="<?= base_url('laporan/arus-kas') ?>">
                <i class="bi bi-arrow-left-right"></i>
                <span>Arus Kas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'laporan/laba-rugi') ? '' : 'collapsed' ?>" href="<?= base_url('laporan/laba-rugi') ?>">
                <i class="bi bi-graph-up-arrow"></i>
                <span>Laba Rugi</span>
            </a>
        </li>
        <?php } ?>

        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'profile') ? "" : "collapsed" ?>" href="<?= base_url('profile') ?>">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>

    </ul>

</aside>