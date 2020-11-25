<?php
$no=1;
$grandtotal = 0;
foreach($data->result() as $d){
  $total        = $d->harga * $d->qty;
  $grandtotal   = $grandtotal + $total;
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->kode_barang; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo $d->keterangan; ?></td>
    <td><?php echo $d->qty; ?></td>
    <td align="right"><?php echo number_format($d->harga,'2',',','.'); ?></td>
    <td align="right"><?php echo number_format($total,'2',',','.'); ?></td>
    <td align="center"><a href="#"  data-kodebarang="<?php echo $d->kode_barang; ?>" data-idadmin="<?php echo $d->id_admin; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a></td>
  </tr>
  <?php $no++;} ?>
  <tr>
    <td colspan="6"><b>TOTAL</b></td>
    <td align="right">
      <b><?php echo number_format($grandtotal,'2',',','.'); ?></b>
      <input type="hidden" id="grandtot" name="grandtot" value="<?php echo number_format($grandtotal,'2',',','.'); ?>">
    </td>
    <td></td>
  </tr>
  <script type="text/javascript">

    $(function(){

      function loadgrandtotal(){

        var grandtot = $("#grandtot").val();
        $("#grandtotal").text(grandtot);
        $("#cekdata").val(grandtot);

      }

      loadgrandtotal();

      function tampiltemp(){

        $.ajax({
          type    : 'POST',
          url     : '<?php echo base_url();?>gudanglogistik/view_detailpemasukan_temp',
          data    : '',
          cache   : false,
          success : function(html){

            $("#loadpemasukanbarang").html(html);

            $('#barang').val("");
            $('#kodeakun').val("");
            $('#kodebarang').val("");
            $('#namaakun').val("");
            $('#jumlah').val("");
            $('#harga').val("");
            $('#keterangan').val("");
            $('#jenisbarang').val("");

          }

        });
      }

      $(".hapus").click(function(e){
        var kodebarang  = $(this).attr("data-kodebarang");
        var id_admin  	= $(this).attr("data-idadmin");
        e.preventDefault();
        $.ajax({
          type		: 'POST',
          url 		: '<?php echo base_url(); ?>gudanglogistik/hapus_detailpemasukan_temp',
          data 		: {
            kodebarang  : kodebarang,
            idadmin     : id_admin
          },
          cache		: false,
          success 	: function(respond){

            tampiltemp();

          }
        });
      });

    });
  </script>
