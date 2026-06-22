<?php helper('number'); ?>
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card border-primary shadow-sm">
      <div class="card-body text-center">
        <i class="bi bi-box-seam text-primary fs-2"></i>
        <h6 class="mt-2 text-muted">Total Produk</h6>
        <h4 class="text-primary"><?= $totalProduk ?></h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-success shadow-sm">
      <div class="card-body text-center">
        <i class="bi bi-people text-success fs-2"></i>
        <h6 class="mt-2 text-muted">Total User</h6>
        <h4 class="text-success"><?= $totalUser ?></h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-info shadow-sm">
      <div class="card-body text-center">
        <i class="bi bi-receipt text-info fs-2"></i>
        <h6 class="mt-2 text-muted">Total Transaksi</h6>
        <h4 class="text-info"><?= $totalTransaksi ?></h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-warning shadow-sm">
      <div class="card-body text-center">
        <i class="bi bi-cash-stack text-warning fs-2"></i>
        <h6 class="mt-2 text-muted">Total Omzet</h6>
        <h4 class="text-warning"><?= number_to_currency($totalOmzet, 'IDR') ?></h4>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-header bg-white">
        <h6 class="mb-0">Penjualan Bulanan</h6>
      </div>
      <div class="card-body">
        <canvas id="chartPenjualan"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-header bg-white">
        <h6 class="mb-0">Status Pesanan</h6>
      </div>
      <div class="card-body">
        <canvas id="chartStatus"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-lg-12">
    <div class="card shadow-sm">
      <div class="card-header bg-white">
        <h6 class="mb-0">Produk Terlaris</h6>
      </div>
      <div class="card-body">
        <canvas id="chartProduk"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-header bg-white">
    <h6 class="mb-0">5 Transaksi Terbaru</h6>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Total</th>
          <th>Status</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($transaksiTerbaru as $t): ?>
        <?php
        $statusMap = [
            0 => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-warning text-dark'],
            1 => ['label' => 'Sudah Dibayar',       'class' => 'bg-info'],
            2 => ['label' => 'Sedang Dikirim',      'class' => 'bg-primary'],
            3 => ['label' => 'Selesai',             'class' => 'bg-success'],
            4 => ['label' => 'Dibatalkan',          'class' => 'bg-danger'],
        ];
        $s = $statusMap[$t['status']] ?? ['label' => 'Unknown', 'class' => 'bg-secondary'];
        ?>
        <tr>
          <td><?= $t['id'] ?></td>
          <td><?= esc($t['username']) ?></td>
          <td><?= number_to_currency($t['total_harga'], 'IDR') ?></td>
          <td><span class="badge <?= $s['class'] ?>"><?= $s['label'] ?></span></td>
          <td><?= $t['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const bulan = <?= $bulan ?>;
const totalPenjualan = <?= $totalPenjualan ?>;
const namaProduk = <?= $namaProduk ?>;
const qtyProduk = <?= $qtyProduk ?>;
const labelStatus = <?= $labelStatus ?>;
const jumlahStatus = <?= $jumlahStatus ?>;

new Chart(document.getElementById('chartPenjualan'), {
  type: 'line',
  data: {
    labels: bulan,
    datasets: [{
      label: 'Omzet',
      data: totalPenjualan,
      borderColor: '#0d6efd',
      fill: false,
      tension: 0.3
    }]
  }
});

new Chart(document.getElementById('chartStatus'), {
  type: 'doughnut',
  data: {
    labels: labelStatus,
    datasets: [{
      data: jumlahStatus,
      backgroundColor: ['#ffc107', '#0dcaf0', '#0d6efd', '#198754', '#dc3545']
    }]
  }
});

new Chart(document.getElementById('chartProduk'), {
  type: 'bar',
  data: {
    labels: namaProduk,
    datasets: [{
      label: 'Terjual',
      data: qtyProduk,
      backgroundColor: '#0d6efd'
    }]
  },
  options: {
    indexAxis: 'y',
    responsive: true
  }
});
</script>

<?= $this->endSection() ?>
