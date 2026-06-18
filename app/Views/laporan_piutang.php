<?php helper('number'); ?>
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show">
  <?= session()->getFlashdata('success') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card shadow-sm">
  <div class="card-header bg-warning text-dark d-flex align-items-center gap-2">
    <i class="bi bi-cash-coin"></i>
    <h5 class="mb-0">Laporan Piutang Pelanggan</h5>
  </div>
  <div class="card-body">
    <?php if (empty($piutang)): ?>
    <div class="text-center py-5 text-muted">
      <i class="bi bi-check-circle fs-1 text-success"></i>
      <p class="mt-2">Tidak ada piutang — semua transaksi sudah dibayar!</p>
    </div>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-warning">
          <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Invoice</th>
            <th>Total Tagihan</th>
            <th>Sudah Dibayar</th>
            <th>Sisa Piutang</th>
            <th>Tanggal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $totalSisa = 0; foreach ($piutang as $i => $item): $totalSisa += $item['sisa']; ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= esc($item['pelanggan']) ?></td>
            <td><?= esc($item['invoice']) ?></td>
            <td><?= number_to_currency($item['total'], 'IDR') ?></td>
            <td><?= number_to_currency($item['sudah_dibayar'], 'IDR') ?></td>
            <td><?= number_to_currency($item['sisa'], 'IDR') ?></td>
            <td><?= $item['tanggal'] ?></td>
            <td>
              <?php if ($item['sisa'] > 0): ?>
                <span class="badge bg-danger">Belum Lunas</span>
              <?php else: ?>
                <span class="badge bg-success">Lunas</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
          <tr class="table-danger fw-bold">
            <td colspan="5">Total Sisa Piutang</td>
            <td colspan="3"><?= number_to_currency($totalSisa, 'IDR') ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection() ?>
