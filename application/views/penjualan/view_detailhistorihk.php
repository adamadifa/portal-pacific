<?php
    foreach ($detail_historihk as $d){

        $jmldus     = floor($d->jumlah / $d->isipcsdus);
        $sisadus    = $d->jumlah % $d->isipcsdus;

        if($d->isipack == 0){
            $jmlpack    = 0;
            $sisapack   = $sisadus;
        }else{

            $jmlpack    = floor($sisadus / $d->isipcs);
            $sisapack   = $sisadus % $d->isipcs;
        }

        $jmlpcs = $sisapack;
?>
    <tr>
        <td><?php echo $d->kode_produk;?></td>
        <td><?php echo $d->nama_barang;?></td>
        <td align="right"><?php if(!empty($jmldus)){echo number_format($jmldus,'0','','.');}?></td>
        <td align="right"><?php if(!empty($jmlpack)){echo number_format($jmlpack,'0','','.');}?></td>
        <td align="right"><?php if(!empty($jmlpcs)){echo number_format($jmlpcs,'0','','.');}?></td>
    </tr>

<?php  } ?>
