<?php
error_reporting(0);
$no = 1;
foreach ($detail as $b) {
  $qtysaldoawal      = $b->qtysaldoawal;
  $qtypemasukan      = $b->qtypemasukan;
  $qtypengeluaran    = $b->qtypengeluaran;
  $hasilqty          = $qtysaldoawal + $qtypemasukan - $qtypengeluaran;

  $qtyrata          = $b->qtysaldoawal + $b->qtypemasukan;
  if ($qtyrata != "") {
    $qtyrata        = $b->qtysaldoawal + $b->qtypemasukan;
  } else {
    $qtyrata        = 1;
  }

  if ($b->hargaopname == "" and $b->hargaopname == "0") {
    $hasilharga      = $b->hargapemasukan;
  } elseif ($b->hargapemasukan == "" and $b->hargapemasukan == "0") {
    $hasilharga      = $b->hargapemasukan;
  } else {
    $hasilharga      = (($b->totalsa * 1) + ($b->totalpemasukan * 1)) / $qtyrata;
  }

  if ($hasilqty > 0) {
?>
    <tr>
      <td style="width:10px"><?php echo $no; ?></td>
      <td><?php echo $b->kode_barang; ?></td>
      <td><?php echo $b->nama_barang; ?></td>
      <td><?php echo number_format($hasilqty, 2); ?></td>
      <td>
        <a href="#" data-qty="<?php echo $hasilqty; ?>" data-id="<?php echo $b->kode_barang; ?>" class="btn btn-sm btn-info proses">Proses</a>
      </td>
    </tr>
<?php
    $no++;
    $jumproduk = $no - 1;
  }
}
?>
<script type="text/javascript">
  $(function() {

    function loaddetailopname() {
      var kode_kategori = $("#kode_kategori").val();
      var kode_opname_gl = $("#kode_opname").val();
      var tahun = $("#tahun").val();
      var bulan = $("#bulan").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudanglogistik/getopnamestok',
        data: {
          kode_opname_gl: kode_opname_gl,
          kode_kategori: kode_kategori,
          bulan: bulan,
          tahun: tahun
        },
        cache: false,
        success: function(respond) {
          $("#loaddetailopname").html(respond);
        }
      });
    }

    $(".proses").click(function(e) {
      e.preventDefault();
      var kode_opname_gl = $("#kode_opname").val();
      var kode_barang = $(this).attr("data-id");
      var qty = $(this).attr("data-qty");
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>gudanglogistik/prosesopname',
        data: {
          kode_opname_gl: kode_opname_gl,
          kode_barang: kode_barang,
          qty: qty
        },
        cache: false,
        success: function(respond) {
          loaddetailopname();
        }
      });
    });

    function formatAngka(angka) {
      if (typeof(angka) != 'string') angka = angka.toString();
      var reg = new RegExp('([0-9]+)([0-9]{3})');
      while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
      return angka;
    }

  });
</script>