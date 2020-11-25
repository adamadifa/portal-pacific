<?php
error_reporting(0);
$jmldus     = floor($getbrg['stok'] / $getbrg['isipcsdus']);
$sisadus    = $getbrg['stok'] % $getbrg['isipcsdus'];

if ($getbrg['isipack'] == 0) {
    $jmlpack    = 0;
    $sisapack   = $sisadus;
} else {

    $jmlpack    = floor($sisadus / $getbrg['isipcs']);
    $sisapack   = $sisadus % $getbrg['isipcs'];
}

$jmlpcs = $sisapack;
?>
<table class="table table-bordered table-hover table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Detail Barang</th>
        </tr>
    </thead>
</table>
<table class="table table-bordered table-hover table-striped">
    <thead class="thead-dark">
        <tr>
            <td><b>Kode Barang</b></td>
            <td>:</td>
            <td><?php echo $getbrg['kode_barang']; ?></td>
        </tr>
        <tr>
            <td><b>Nama Barang</b></td>
            <td>:</td>
            <td><?php echo $getbrg['nama_barang']; ?></td>
        </tr>
        <tr>
            <td><b>Kategori</b></td>
            <td>:</td>
            <td><?php echo $getbrg['kategori']; ?></td>
        </tr>
        <tr>
            <td><b>Satuan</b></td>
            <td>:</td>
            <td><?php echo $getbrg['satuan']; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Pcs / Dus</b></td>
            <td>:</td>
            <td><?php echo $getbrg['isipcsdus']; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Pack / Dus</b></td>
            <td>:</td>
            <td><?php echo $getbrg['isipack']; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Pcs / Pack</b></td>
            <td>:</td>
            <td><?php echo $getbrg['isipcs']; ?></td>
        </tr>
        <tr>
            <td><b>Harga / Dus</b></td>
            <td>:</td>
            <td><?php echo number_format($getbrg['harga_dus'], '0', '', '.'); ?></td>
        </tr>
        <tr>
            <td><b>Harga / Pack</b></td>
            <td>:</td>
            <td><?php echo number_format($getbrg['harga_pack'], '0', '', '.'); ?></td>
        </tr>
        <tr>
            <td><b>Harga / Pcs</b></td>
            <td>:</td>
            <td><?php echo number_format($getbrg['harga_pcs'], '0', '', '.'); ?></td>
        </tr>
        <tr>
            <td><b>Harga Retur / Dus</b></td>
            <td>:</td>
            <td><?php echo number_format($getbrg['harga_returdus'], '0', '', '.'); ?></td>
        </tr>
        <tr>
            <td><b>Harga Retur / Pack</b></td>
            <td>:</td>
            <td><?php echo number_format($getbrg['harga_returpack'], '0', '', '.'); ?></td>
        </tr>
        <tr>
            <td><b>Harga Retur / Pcs</b></td>
            <td>:</td>
            <td><?php echo number_format($getbrg['harga_returpcs'], '0', '', '.'); ?></td>
        </tr>
        <tr>
            <td><b>Stok Dus</b></td>
            <td>:</td>
            <td><?php echo $jmldus; ?></td>
        </tr>
        <tr>
            <td><b>Stok Pack</b></td>
            <td>:</td>
            <td><?php echo $jmlpack; ?></td>
        </tr>
        <tr>
            <td><b>Stok Pcs</b></td>
            <td>:</td>
            <td><?php echo $jmlpcs; ?></td>
        </tr>
    </thead>
</table>