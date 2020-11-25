  <?php
    foreach ($detail_pl as $d){
?>
    <tr>
        <td><?php echo DateToIndo2($d->tgl_mutasi_gudang_cabang);?></td>
        <td>
            <a href="#" data-nomutasi = "<?php echo $d->no_mutasi_gudang_cabang; ?>" class="btn btn-xs bg-red hapus"><i class="material-icons">delete</i></a>
            <a href="#" data-tgl="<?php echo DateToIndo2($d->tgl_mutasi_gudang_cabang); ?>" data-nomutasi = "<?php echo $d->no_mutasi_gudang_cabang; ?>" class="btn btn-xs bg-blue showdetailhistori" ><i class="material-icons">remove_red_eye</i></a>
        </td>
    </tr>
<?php
}
?>

<script>
    $(function(){
        function loadhistoripelunasanhk(){
			  var nofaktur = $("#nofaktur").val();
			  $("#loadhistoripelunasanhk").load("<?php echo base_url();?>penjualan/historipelunasanhk/"+nofaktur);
		}

    function loaddetailhutangkirim(){
			var nofaktur = $("#nofaktur").val();
			$("#detailhk").load("<?php echo base_url();?>penjualan/view_detailhutangkirim/"+nofaktur);
		}
      $(".showdetailhistori").click(function(e){
          var nomutasi = $(this).attr("data-nomutasi");
          var tgl      = $(this).attr("data-tgl");
          e.preventDefault();
          $("#detailhistori").slideUp("slow");
          $("#detailhistori").slideDown("slow");
          $("#loaddetailhistorihk").load("<?php echo base_url();?>penjualan/view_detailhistorihk/"+nomutasi);
         $("#tglhk").text(tgl);
      });

      $(".hapus").click(function(e){
          e.preventDefault();
          var nomutasi = $(this).attr("data-nomutasi");
          $.ajax({

               type       : 'POST',
               url        : '<?php echo base_url();?>penjualan/hapus_plhk',
               data       : {nomutasi:nomutasi},
               cache      : false,
               success    : function(respond){
                  loadhistoripelunasanhk();
                  loaddetailhutangkirim();
               }

          });

      });

    });
</script>
