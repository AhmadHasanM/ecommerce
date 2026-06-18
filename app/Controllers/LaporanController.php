<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\BebanModel;

class LaporanController extends BaseController
{
    public function pendapatan()
    {
        $model         = new TransactionModel();
        $tanggal_awal  = $this->request->getGet('tanggal_awal');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $laporan = [];

        if ($tanggal_awal && $tanggal_akhir) {
            $laporan = $model
                ->where('status >=', 1)
                ->where('created_at >=', $tanggal_awal . ' 00:00:00')
                ->where('created_at <=', $tanggal_akhir . ' 23:59:59')
                ->findAll();
        }

        return view('laporan_pendapatan', [
            'laporan'       => $laporan,
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ]);
    }

    public function exportPdf()
    {
        $tanggal_awal  = $this->request->getGet('tanggal_awal');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $model  = new \App\Models\TransactionModel();
        $laporan = $model
            ->where('status >=', 1)
            ->where('created_at >=', $tanggal_awal . ' 00:00:00')
            ->where('created_at <=', $tanggal_akhir . ' 23:59:59')
            ->findAll();

        $dompdf = new \Dompdf\Dompdf();
        $html   = view('laporan_pdf', [
            'laporan'       => $laporan,
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ]);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream("laporan-pendapatan.pdf");
    }

    public function produkTerlaris()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaction_detail td');
        $produk = $builder
            ->select('p.nama, SUM(td.jumlah) as total_terjual, SUM(td.subtotal_harga) as total_omzet')
            ->join('product p', 'td.product_id = p.id')
            ->join('transaction t', 'td.transaction_id = t.id')
            ->where('t.status >=', 1)
            ->groupBy('td.product_id')
            ->orderBy('total_terjual', 'DESC')
            ->get()
            ->getResultArray();

        return view('laporan_produk_terlaris', ['produk' => $produk]);
    }

    public function piutang()
    {
        $model = new TransactionModel();
        $piutang = $model->where('status', 0)->findAll();

        $data = [];
        foreach ($piutang as $item) {
            $data[] = [
                'id'           => $item['id'],
                'pelanggan'    => $item['username'],
                'invoice'      => 'INV-' . str_pad($item['id'], 5, '0', STR_PAD_LEFT),
                'total'        => $item['total_harga'],
                'sudah_dibayar'=> !empty($item['bukti_pembayaran']) ? $item['total_harga'] : 0,
                'sisa'         => !empty($item['bukti_pembayaran']) ? 0 : $item['total_harga'],
                'tanggal'      => $item['created_at'],
            ];
        }

        return view('laporan_piutang', ['piutang' => $data]);
    }

    public function bayarPiutang($id)
    {
        $model = new TransactionModel();
        $model->update($id, ['status' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
        return redirect()->to('laporan/piutang')->with('success', 'Piutang berhasil dibayar.');
    }

    public function arusKas()
    {
        $transactionModel = new TransactionModel();
        $bebanModel       = new BebanModel();

        $penjualan  = $transactionModel->where('status >=', 1)->findAll();
        $kasMasuk   = array_sum(array_column($penjualan, 'total_harga'));

        $beban      = $bebanModel->orderBy('tanggal', 'DESC')->findAll();
        $kasKeluar  = array_sum(array_column($beban, 'nominal'));

        $saldoAkhir = $kasMasuk - $kasKeluar;

        return view('laporan_arus_kas', [
            'penjualan'  => $penjualan,
            'beban'      => $beban,
            'kasMasuk'   => $kasMasuk,
            'kasKeluar'  => $kasKeluar,
            'saldoAkhir' => $saldoAkhir,
        ]);
    }

    public function tambahBeban()
    {
        $bebanModel = new BebanModel();
        $bebanModel->insert([
            'tanggal'    => $this->request->getPost('tanggal'),
            'nama_beban' => $this->request->getPost('nama_beban'),
            'nominal'    => $this->request->getPost('nominal'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('laporan/arus-kas')->with('success', 'Beban berhasil ditambahkan.');
    }

    public function hapusBeban($id)
    {
        $bebanModel = new BebanModel();
        $bebanModel->delete($id);
        return redirect()->to('laporan/arus-kas')->with('success', 'Beban berhasil dihapus.');
    }

    public function labaRugi()
    {
        $transactionModel = new TransactionModel();
        $bebanModel       = new BebanModel();

        $penjualan   = $transactionModel->where('status >=', 1)->findAll();
        $totalPenjualan = array_sum(array_column($penjualan, 'total_harga'));

        $hpp = $totalPenjualan * 0.6;

        $labaKotor = $totalPenjualan - $hpp;

        $beban       = $bebanModel->findAll();
        $totalBeban  = array_sum(array_column($beban, 'nominal'));

        $labaBersih = $labaKotor - $totalBeban;

        return view('laporan_laba_rugi', [
            'totalPenjualan' => $totalPenjualan,
            'hpp'            => $hpp,
            'labaKotor'      => $labaKotor,
            'beban'          => $beban,
            'totalBeban'     => $totalBeban,
            'labaBersih'     => $labaBersih,
        ]);
    }

    public function exportExcel()
    {
        $tanggal_awal  = $this->request->getGet('tanggal_awal');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $model  = new \App\Models\TransactionModel();
        $laporan = $model
            ->where('status >=', 1)
            ->where('created_at >=', $tanggal_awal . ' 00:00:00')
            ->where('created_at <=', $tanggal_akhir . ' 23:59:59')
            ->findAll();

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=laporan-pendapatan.xls");
        echo view('laporan_excel', ['laporan' => $laporan]);
    }
}
