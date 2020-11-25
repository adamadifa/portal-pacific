<?php $no=1; foreach($bpbtemp as $d){ ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo $d->satuan; ?></td>
    <td><?php echo $d->jumlah; ?></td>
    <td><?php echo $d->keterangan; ?></td>
    <td align="right"><a href="#" data-kodebarang="<?php echo $d->kode_barang; ?>" data-idadmin="<?php echo $d->id_admin; ?>" class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a></td>
  </tr>
<?php $no++;} ?>

<script type="text/javascript">

  $(function(){
    function cekdata()
    {
      $.ajax({
        type : 'POST',
        url  : '<?php echo base_url(); ?>pembelian/cekdatabpb',
        cache: false,
        success:function(respond)
        {
          $("#cekdatabpb").val(respond);
        }
      });
      //$("#cekdatabpb").load("<?php echo base_url(); ?>pembelian/cekdatabpb");
    }
    function loadpermintaanbarang()
    {
      $("#loadpermintaanbarang").load('<?php echo base_url(); ?>pembelian/view_detailbpb_temp');
    }

    $(".hapus").click(function(e){
			var kodebarang  = $(this).attr("data-kodebarang");
			var id_admin  	= $(this).attr("data-idadmin");
			e.preventDefault();
			$.ajax({
				type		: 'POST',
				url 		: '<?php echo base_url(); ?>pembelian/hapus_detailbpb_temp',
				data 		: {kodebarang:kodebarang,idadmin:id_admin},
				cache		: false,
				success 	: function(respond){
          loadpermintaanbarang();
          cekdata();
				}
			});
    });
  });
</script>
