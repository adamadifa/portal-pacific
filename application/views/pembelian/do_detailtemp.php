<?php
$no=1;
foreach($do as $d){
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->no_bpb; ?></td>
    <td><?php echo $d->tgl_permintaan; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo $d->qty; ?></td>
    <td><?php echo $d->keterangan; ?></td>
    <td align="right"><a href="#" data-nobpb="<?php echo $d->no_bpb; ?>" data-kodebarang="<?php echo $d->kode_barang; ?>" data-idadmin="<?php echo $d->id_admin; ?>" class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a></td>
  </tr>
<?php $no++;} ?>
<script type="text/javascript">

  $(function(){
    function loaddotoko()
    {
      var departemen = $("#departemen").val();
      $("#loaddotoko").load('<?php echo base_url(); ?>pembelian/dodetailtemp/'+departemen);
    }

    $(".hapus").click(function(e){

      var nobpb       = $(this).attr("data-nobpb");
			var kodebarang  = $(this).attr("data-kodebarang");
			var id_admin  	= $(this).attr("data-idadmin");
      //alert(id_admin);
			e.preventDefault();
			$.ajax({
				type		: 'POST',
				url 		: '<?php echo base_url(); ?>pembelian/hapus_detaildo_temp',
				data 		: {nobpb:nobpb,kodebarang:kodebarang,idadmin:id_admin},
				cache		: false,
				success 	: function(respond){
          loaddotoko();
				}
			});
    });
  });
</script>
