<?php
$no = 1;
$totaldebet = 0;
$totalkredit = 0;
$totalledger = 0;
foreach ($ledger as $key => $l) {
  $bank  = @$ledger[$key + 1]->bank;
  $totalledger = $totalledger + $l->jumlah;
  if ($l->status_dk == 'K') {
    $kredit = $l->jumlah;
    $debet  = 0;
    $jumlah = $l->jumlah;
  } else {
    $debet  = $l->jumlah;
    $kredit = 0;
    $jumlah = -$l->jumlah;
  }
  $totaldebet = $totaldebet + $debet;
  $totalkredit = $totalkredit + $kredit;
  if (empty($l->ceknobukti)) {
    $color = "";
    $textcolor = "";
  } else {
    if ($kredit != $l->kredit or $debet != $l->debet) {
      $color = "#d93333c9";
      $textcolor = "white";
    } else {
      $color = "#8fdcaac4";
      $textcolor = "";
    }
  }
?>
  <tr style="background-color: <?php echo $color; ?>; color:<?php echo $textcolor; ?>">
    <td><?php echo $no; ?></td>
    <td><?php echo date_format(date_create($l->tgl_ledger), 'd-M-y'); ?></td>
    <td><?php echo $l->no_bukti; ?></td>
    <td><?php echo $l->no_ref; ?></td>
    <td><?php echo $l->keterangan; ?></td>
    <td><?php echo "'" . $l->kode_akun; ?></td>
    <!-- <td><?php echo $l->nama_akun; ?></td> -->
    <td align="right"><?php if ($debet != 0) {
                        echo number_format($debet, '0', '', '.');
                      } ?></td>
    <td align="right"><?php if ($kredit != 0) {
                        echo number_format($kredit, '0', '', '.');
                      } ?></td>
    <td><?php echo $l->bank; ?></td>
    <td>
      <?php if (empty($l->ceknobukti)) { ?>
        <a href="#" class="btn btn-success btn-sm tambah" data-nobukti="<?php echo $l->ceknobukti; ?>" data-noref="<?php echo $l->no_bukti;  ?>"><i class="fa fa-plus"></i></a>
      <?php } else { ?>
        <a href="#" class="btn btn-danger btn-sm hapus" data-nobukti="<?php echo $l->ceknobukti; ?>"><i class="fa fa-close"></i></a>
        <?php
        if ($kredit != $l->kredit or $debet != $l->debet) {
        ?>
          <a href="#" class="btn btn-primary btn-sm refresh" data-nobukti="<?php echo $l->ceknobukti; ?>" data-noref="<?php echo $l->no_bukti;  ?>"><i class=" fa fa-refresh"></i></a>
        <?php
        }
        ?>


      <?php } ?>
    </td>

  </tr>
  <?php
  if ($bank != $l->bank) {
  ?>
    <tr class="thead-dark">
      <th colspan="6"><?php echo $l->bank; ?></th>
      <th style="text-align:right"><?php echo number_format($totaldebet, '0', '', '.'); ?></th>
      <th style="text-align:right"><?php echo number_format($totalkredit, '0', '', '.'); ?></th>
      <th colspan="3"></th>
    </tr>
  <?php
    $totalledger = 0;
  }
  ?>
<?php
  $no++;
}
?>

<script>
  $(function() {

    function loadledger() {
      var bulan = $('#bulan').val();
      var tahun = $('#tahun').val();
      var kode_akun = $('#kode_akun').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/view_ledger',
        data: {
          kode_akun: kode_akun,
          tahun: tahun,
          bulan: bulan
        },
        cache: false,
        success: function(respond) {
          $("#loadledger").html(respond);
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
            loadledger();
          } else {
            loadledger();
          }
        }
      });
    });

    $(".tambah").click(function(e) {
      e.preventDefault();
      var bulan = $('#bulan').val();
      var tahun = $('#tahun').val();
      var nobukti = $(this).attr("data-nobukti");
      var kode_akun = $('#kode_akun').val();
      var sumber = "Ledger";
      var noref = $(this).attr("data-noref");
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
            loadledger();
          } else {
            loadledger();
          }
        }
      });
    });

    $(".refresh").click(function() {
      var nobukti = $(this).attr("data-nobukti");
      var sumber = "Ledger";
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
            loadledger();
          } else {
            loadledger();
          }
        }
      });
    });
  });
</script>