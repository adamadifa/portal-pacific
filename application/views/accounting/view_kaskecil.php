 <?php
  $no                = 1;
  $totalpenerimaan   = 0;
  $totalpengeluaran  = 0;
  foreach ($kaskecil as $k) {
    if ($k->status_dk == 'K') {
      $penerimaan   = $k->jumlah;
      $s             = $penerimaan;
      $pengeluaran  = "0";
    } else {
      $penerimaan   = "0";
      $pengeluaran  = $k->jumlah;
      $s             = -$pengeluaran;
    }

    $totalpenerimaan  = $totalpenerimaan + $penerimaan;
    $totalpengeluaran = $totalpengeluaran + $pengeluaran;
    if (empty($k->ceknobukti)) {
      $color = "";
      $textcolor = "";
    } else {
      if ($penerimaan != $k->debet or $pengeluaran != $k->kredit) {
        $color = "#d93333c9";
        $textcolor = "white";
      } else {
        $color = "#8fdcaac4";
        $textcolor = "";
      }
    }

  ?>
   <tr style="font-size:12;background-color: <?php echo $color; ?>;">
     <td><?php echo $no; ?></td>
     <td><?php echo DateToIndo2($k->tgl_kaskecil); ?></td>
     <td><?php echo $k->nobukti; ?></td>
     <td><?php echo $k->keterangan; ?></td>
     <td><?php echo "<font color=white>'</font>" . $kode_akun; ?></td>
     <!-- <td><?php echo $k->nama_akun; ?></td> -->
     <td align="right"><?php if (!empty($penerimaan)) {
                          echo number_format($penerimaan, '0', '', '.');
                        } ?></td>
     <td align="right"><?php if (!empty($pengeluaran)) {
                          echo number_format($pengeluaran, '0', '', '.');
                        } ?></td>
     <td>
       <?php if (empty($k->ceknobukti)) { ?>
         <a href="#" class="btn btn-success btn-sm tambah" data-nobukti="<?php echo $k->ceknobukti; ?>" data-noref="<?php echo $k->id; ?>"><i class="fa fa-plus"></i></a>
       <?php } else { ?>
         <a href="#" class="btn btn-danger btn-sm hapus" data-nobukti="<?php echo $k->ceknobukti; ?>"><i class="fa fa-close"></i></a>
         <?php
          if ($penerimaan != $k->debet or $pengeluaran != $k->kredit) {
          ?>
           <a href="#" class="btn btn-primary btn-sm refresh" data-nobukti="<?php echo $k->ceknobukti; ?>" data-noref="<?php echo $k->id; ?>"><i class=" fa fa-refresh"></i></a>
         <?php
          }
          ?>


       <?php } ?>
     </td>
   </tr>
 <?php
    $no++;
  }
  ?>
 <tr class="thead-dark">
   <th colspan="5">TOTAL</th>
   <th style="text-align:right"><?php if (!empty($totalpenerimaan)) {
                                  echo number_format($totalpenerimaan, '0', '', '.');
                                } ?></th>
   <th style="text-align:right"><?php if (!empty($totalpengeluaran)) {
                                  echo number_format($totalpengeluaran, '0', '', '.');
                                } ?></th>
   <th></th>
 </tr>

 <script>
   $(function() {
     function loadkaskecil() {
       var bulan = $('#bulan').val();
       var tahun = $('#tahun').val();
       var kode_akun = $('#kode_akun').val();
       $.ajax({
         type: 'POST',
         url: '<?php echo base_url(); ?>accounting/view_kaskecil',
         data: {
           kode_akun: kode_akun,
           tahun: tahun,
           bulan: bulan
         },
         cache: false,
         success: function(respond) {
           $("#loadkaskecil").html(respond);
         }
       });
     }

     $(".hapus").click(function(e) {
       e.preventDefault();
       var nobukti = $(this).attr("data-nobukti");

       //alert(nobukti);
       $.ajax({
         type: "POST",
         url: "<?php echo base_url(); ?>accounting/hapusbukubesar",
         cache: false,
         data: {
           nobukti: nobukti


         },
         success: function(respond) {
           if (respond == 1) {
             loadkaskecil();
           } else {
             loadkaskecil();
           }
         }
       });
     });

     $(".tambah").click(function(e) {
       e.preventDefault();
       var bulan = $('#bulan').val();
       var tahun = $('#tahun').val();
       var nobukti = $(this).attr("data-nobukti");
       var sumber = "Kas Kecil";
       var noref = $(this).attr("data-noref");
       var kode_akun = $('#kode_akun').val();
       $.ajax({
         type: "POST",
         url: "<?php echo base_url(); ?>accounting/tambahbukubesar",
         cache: false,
         data: {
           nobukti: nobukti,
           sumber: sumber,
           noref: noref,
           bulan: bulan,
           tahun: tahun,
           kode_akun: kode_akun
         },
         success: function(respond) {
           console.log(respond);
           if (respond == 1) {

             //swal("Success", "Data Berhasil Disimpan !", "success");
             loadkaskecil();
           } else {
             loadkaskecil();
           }
         }
       });
     });

     $(".refresh").click(function(e) {
       e.preventDefault();
       var nobukti = $(this).attr("data-nobukti");
       var sumber = "Kas Kecil";
       var noref = $(this).attr("data-noref");
       $.ajax({
         type: "POST",
         url: "<?php echo base_url(); ?>accounting/updatebukubesar",
         cache: false,
         data: {
           nobukti: nobukti,
           sumber: sumber,
           noref: noref
         },
         success: function(respond) {
           console.log(respond);
           if (respond == 1) {
             swal("Success", "Data Berhasil Di Update !", "success");
             loadkaskecil();
           } else {
             loadkaskecil();
           }
         }
       });
     });
   });
 </script>