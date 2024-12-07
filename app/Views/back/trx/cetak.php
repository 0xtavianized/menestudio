<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <link href="<?= base_url(); ?>assets/img/favicon.png" rel="icon">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .total {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Laporan Transaksi Mene Photo Studio</h1>
    <table>
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">ID Transaksi</th>
                <th class="text-center">Waktu Transaksi</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Paket</th>
                <th class="text-center">Tanggal Foto</th>
                <th class="text-center">Jam Foto</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Waktu Bayar</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalPendapatan = 0;
            if (!empty($transaksi)): ?>
                <?php foreach ($transaksi as $index => $trx):
                    if ($trx['transaction_status'] === 'settlement') {
                        $totalPendapatan += (int) $trx['harga'];
                    }
                    ?>
                    <tr>
                        <td class="text-center"><?= $index + 1; ?></td>
                        <td><?= $trx['id_transaksi']; ?></td>
                        <td class="text-center"><?= date('d-m-Y / H:i', strtotime($trx['waktu_transaksi'])); ?></td>
                        <td><?= $trx['nama_lengkap']; ?></td>
                        <td><?= $trx['paket']; ?></td>
                        <td class="text-center">
                            <?= $trx['tanggal_foto'] !== '0000-00-00' ? date("d-m-Y", strtotime($trx['tanggal_foto'])) : '-'; ?>
                        </td>
                        <td class="text-center">
                            <?= $trx['jam_foto'] === '00:00:00' ? '-' : date("H:i", strtotime($trx['jam_foto'])); ?>
                        </td>
                        <td class="text-center">Rp <?= number_format($trx['harga'], 0, ',', '.'); ?></td>
                        <td class="text-center">
                            <?= $trx['waktu_bayar'] === null ? '-' : date('d-m-Y / H:i:s', strtotime($trx['waktu_bayar'])); ?>
                        </td>
                        <td><?= $trx['transaction_status'] === 'settlement' ? 'Berhasil' : $trx['transaction_status']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="total">
        Total Pendapatan: Rp <?= number_format($totalPendapatan, 0, ',', '.'); ?>
    </div>
</body>

</html>