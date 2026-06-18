<?php helper('number'); ?>
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
  <div class="card-header bg-primary text-white d-flex align-items-center gap-2">
    <i class="bi bi-trophy-fill"></i>
    <h5 class="mb-0">Laporan Produk Terlaris</h5>
  </div>
  <div class="card-body">
    <?php if (empty($produk)): ?>
    <div class="text-center py-5 text-muted">
      <i class="bi bi-inbox fs-1"></i>
      <p class="mt-2">Belum ada data penjualan</p>
    </div>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-primary">
          <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Jumlah Terjual (pcs)</th>
            <th>Total Omzet</th>
          </tr>
        </thead>
        <tbody>
          <?php $totalOmzet = 0; ?>
          <?php foreach ($produk as $i => $item): $totalOmzet += $item['total_omzet']; ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= esc($item['nama']) ?></td>
            <td><?= $item['total_terjual'] ?></td>
            <td><?= number_to_currency($item['total_omzet'], 'IDR') ?></td>
          </tr>
          <?php endforeach; ?>
          <tr class="table-warning fw-bold">
            <td colspan="2">Total</td>
            <td></td>
            <td><?= number_to_currency($totalOmzet, 'IDR') ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection() ?>
