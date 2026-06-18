<?php helper('number'); ?>
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show">
  <?= session()->getFlashdata('success') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card border-success shadow-sm">
      <div class="card-body text-center">
        <i class="bi bi-arrow-down-circle-fill text-success fs-2"></i>
        <h6 class="mt-2 text-muted">Total Kas Masuk</h6>
        <h4 class="text-success"><?= number_to_currency($kasMasuk, 'IDR') ?></h4>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-danger shadow-sm">
      <div class="card-body text-center">
        <i class="bi bi-arrow-up-circle-fill text-danger fs-2"></i>
        <h6 class="mt-2 text-muted">Total Kas Keluar</h6>
        <h4 class="text-danger"><?= number_to_currency($kasKeluar, 'IDR') ?></h4>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-primary shadow-sm">
      <div class="card-body text-center">
        <i class="bi bi-wallet-fill text-primary fs-2"></i>
        <h6 class="mt-2 text-muted">Saldo Akhir</h6>
        <h4 class="<?= $saldoAkhir >= 0 ? 'text-primary' : 'text-danger' ?>">
          <?= number_to_currency($saldoAkhir, 'IDR') ?>
        </h4>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header bg-success text-white">
        <i class="bi bi-arrow-down-circle"></i> Kas Masuk (Penjualan)
      </div>
      <div class="card-body p-0">
        <table class="table table-sm mb-0">
          <thead class="table-light">
            <tr><th>Tanggal</th><th>Username</th><th>Nominal</th></tr>
          </thead>
          <tbody>
            <?php foreach ($penjualan as $item): ?>
            <tr>
              <td><?= $item['created_at'] ?></td>
              <td><?= esc($item['username']) ?></td>
              <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
        <span><i class="bi bi-arrow-up-circle"></i> Kas Keluar (Beban)</span>
        <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#tambahBebanModal">
          + Tambah Beban
        </button>
      </div>
      <div class="card-body p-0">
        <table class="table table-sm mb-0">
          <thead class="table-light">
            <tr><th>Tanggal</th><th>Keterangan</th><th>Nominal</th><th></th></tr>
          </thead>
          <tbody>
            <?php foreach ($beban as $item): ?>
            <tr>
              <td><?= $item['tanggal'] ?></td>
              <td><?= esc($item['nama_beban']) ?></td>
              <td><?= number_to_currency($item['nominal'], 'IDR') ?></td>
              <td>
                <a href="<?= base_url('laporan/beban/hapus/' . $item['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="tambahBebanModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('laporan/beban/tambah') ?>" method="post">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title">Tambah Beban / Kas Keluar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Beban</label>
            <input type="text" name="nama_beban" class="form-control" placeholder="Contoh: Biaya Iklan, Gaji, dll" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nominal (Rp)</label>
            <input type="number" name="nominal" class="form-control" placeholder="Contoh: 500000" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
