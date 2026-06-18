<?php helper('number'); ?>
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
  <div class="card-header bg-dark text-white d-flex align-items-center gap-2">
    <i class="bi bi-graph-up-arrow"></i>
    <h5 class="mb-0">Laporan Laba Rugi Sederhana</h5>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr><th>Keterangan</th><th class="text-end">Nominal</th></tr>
      </thead>
      <tbody>
        <tr class="table-success">
          <td><strong>Pendapatan Penjualan</strong></td>
          <td class="text-end"><strong><?= number_to_currency($totalPenjualan, 'IDR') ?></strong></td>
        </tr>
        <tr>
          <td>Harga Pokok Penjualan (HPP)</td>
          <td class="text-end text-danger">(<?= number_to_currency($hpp, 'IDR') ?>)</td>
        </tr>
        <tr class="table-info">
          <td><strong>Laba Kotor</strong></td>
          <td class="text-end"><strong><?= number_to_currency($labaKotor, 'IDR') ?></strong></td>
        </tr>
        <tr><td colspan="2" class="table-secondary"><strong>Beban-Beban:</strong></td></tr>
        <?php foreach ($beban as $item): ?>
        <tr>
          <td class="ps-4"><?= esc($item['nama_beban']) ?></td>
          <td class="text-end text-danger">(<?= number_to_currency($item['nominal'], 'IDR') ?>)</td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <td><strong>Total Beban</strong></td>
          <td class="text-end text-danger"><strong>(<?= number_to_currency($totalBeban, 'IDR') ?>)</strong></td>
        </tr>
        <tr class="<?= $labaBersih >= 0 ? 'table-success' : 'table-danger' ?>">
          <td><strong>Laba Bersih</strong></td>
          <td class="text-end">
            <strong><?= number_to_currency($labaBersih, 'IDR') ?></strong>
            <?php if ($labaBersih < 0): ?>
              <span class="badge bg-danger ms-2">RUGI</span>
            <?php else: ?>
              <span class="badge bg-success ms-2">LABA</span>
            <?php endif; ?>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4 p-3 bg-light rounded">
      <h6>Ringkasan:</h6>
      <ul class="mb-0">
        <li>Total Penjualan: <strong><?= number_to_currency($totalPenjualan, 'IDR') ?></strong></li>
        <li>HPP (60%): <strong><?= number_to_currency($hpp, 'IDR') ?></strong></li>
        <li>Total Beban: <strong><?= number_to_currency($totalBeban, 'IDR') ?></strong></li>
        <li>Laba Bersih: <strong class="<?= $labaBersih >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_to_currency($labaBersih, 'IDR') ?></strong></li>
      </ul>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
