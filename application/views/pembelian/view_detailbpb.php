<?php $no = 1; foreach($detail as $d){ ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo number_format($d->jumlah,'0','','.'); ?></td>
    <td><?php echo $d->keterangan; ?></td>
    <td align="right"><a href="#" data-kodebarang="<?php echo $d->kode_barang; ?>" data-nobpb="<?php echo $d->no_bpb; ?>" class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a></td>
  </tr>
<?php $no++; }  ?>


<script type="text/javascript">

  $(function(){
    function loadpermintaanbarang()
    {
      var no_bpb = $("#nobpb").val();
      var nobpb  = no_bpb.replace(/\//g, '.');
      //alert(nobpb);
      $("#loadpermintaanbarang").load('<?php echo base_url(); ?>pembelian/view_detailbpb/'+nobpb);
    }

    $(".hapus").click(function(e){
			var kodebarang  = $(this).attr("data-kodebarang");
			var nobpb  	    = $(this).attr("data-nobpb");

			e.preventDefault();
			$.ajax({
				type		: 'POST',
				url 		: '<?php echo base_url(); ?>pembelian/hapus_detailbpb',
				data 		: {kodebarang:kodebarang,nobpb:nobpb},
				cache		: false,
				success 	: function(respond){
          loadpermintaanbarang();
				}
			});
    });
  });
</script>
