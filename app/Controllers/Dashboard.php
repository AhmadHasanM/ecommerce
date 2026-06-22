<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $productModel = new \App\Models\ProductModel();
        $totalProduk = $productModel->countAllResults();
        $totalUser      = $db->table('user')->countAllResults();
        $totalTransaksi = $db->table('transaction')->countAllResults();
        $omzet = $db->table('transaction')
                    ->selectSum('total_harga')
                    ->where('status', 3)
                    ->get()->getRow();
        $totalOmzet = $omzet->total_harga ?? 0;

        $penjualan = $db->query("
            SELECT MONTH(created_at) bulan, SUM(total_harga) total
            FROM transaction
            WHERE status = 3
            GROUP BY MONTH(created_at)
            ORDER BY bulan
        ")->getResultArray();

        $bulan = [];
        $totalPenjualan = [];
        foreach ($penjualan as $row) {
            $bulan[]          = date('M', mktime(0, 0, 0, $row['bulan'], 1));
            $totalPenjualan[] = (int) $row['total'];
        }

        $produk = $db->query("
            SELECT p.nama, SUM(td.jumlah) qty
            FROM transaction_detail td
            JOIN product p ON p.id = td.product_id
            GROUP BY p.id
            ORDER BY qty DESC
            LIMIT 10
        ")->getResultArray();

        $namaProduk = [];
        $qtyProduk  = [];
        foreach ($produk as $row) {
            $namaProduk[] = $row['nama'];
            $qtyProduk[]  = (int) $row['qty'];
        }

        $status = $db->query("
            SELECT status, COUNT(*) jumlah
            FROM transaction
            GROUP BY status
        ")->getResultArray();

        $labelStatus  = [];
        $jumlahStatus = [];
        foreach ($status as $row) {
            $map = [
                0 => 'Menunggu Pembayaran',
                1 => 'Sudah Dibayar',
                2 => 'Sedang Dikirim',
                3 => 'Selesai',
                4 => 'Dibatalkan',
            ];
            $labelStatus[]  = $map[$row['status']] ?? 'Lainnya';
            $jumlahStatus[] = (int) $row['jumlah'];
        }

        $transaksiTerbaru = $db->table('transaction')
                              ->orderBy('id', 'DESC')
                              ->limit(5)
                              ->get()->getResultArray();

        return view('dashboard', [
            'totalProduk'      => $totalProduk,
            'totalUser'        => $totalUser,
            'totalTransaksi'   => $totalTransaksi,
            'totalOmzet'       => $totalOmzet,
            'bulan'            => json_encode($bulan),
            'totalPenjualan'   => json_encode($totalPenjualan),
            'namaProduk'       => json_encode($namaProduk),
            'qtyProduk'        => json_encode($qtyProduk),
            'labelStatus'      => json_encode($labelStatus),
            'jumlahStatus'     => json_encode($jumlahStatus),
            'transaksiTerbaru' => $transaksiTerbaru,
        ]);
    }
}
