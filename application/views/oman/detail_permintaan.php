<div class="table-responsive">
    <?php

    function uang($nilai)
    {

        return number_format($nilai, '0', '', '.');
    }

    $bulan  = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Novemer", "Desember");
    ?>
    <table class="table  table-striped table-hover" style="width:50%">
        <tr>
            <td><b>No Permintaan</b></td>
            <td>:</td>
            <td><?php echo $permintaan['no_permintaan']; ?></td>
        </tr>
        <tr>
            <td><b>Tanggal Permintaan</b></td>
            <td>:</td>
            <td><?php echo DateToIndo2($permintaan['tgl_permintaan']); ?></td>
        </tr>
        <tr>
            <td><b>No Order</b></td>
            <td>:</td>
            <td><?php echo $oman['no_order']; ?></td>
        </tr>
        <tr>
            <td><b>Bulan</b></td>
            <td>:</td>
            <td><?php echo $bulan[$oman['bulan']]; ?></td>
        </tr>
        <tr>
            <td><b>Tahun</b></td>
            <td>:</td>
            <td><?php echo $oman['tahun']; ?></td>
        </tr>
    </table>
    <table class="table table-bordered table-striped table-hover" id="mytable">
        <thead class="thead-dark">
            <tr>
                <th width="10px" style="vertical-align: middle;">No</th>
                <th style="vertical-align: middle; text-align: center;">Produk</th>
                <th style="text-align: center">OMAN MKT</th>
                <th style="text-align: center">STOK GUDANG</th>
                <th style="text-align: center">BUFFER STOK</th>
                <th style="text-align:center;vertical-align: middle;">Total Permintaan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($detail as $d) {
            ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $d->nama_barang; ?></td>
                    <td align="right"><?php echo uang($d->oman_mkt); ?></td>
                    <td align="right"><?php echo uang($d->stok_gudang); ?></td>
                    <td align="right"><?php echo uang($d->buffer_stok); ?></td>
                    <td align="right"><?php echo uang($d->oman_mkt - $d->stok_gudang + $d->buffer_stok); ?></td>
                </tr>
            <?php
                $no++;
            }
            ?>
        </tbody>
    </table>

</div>