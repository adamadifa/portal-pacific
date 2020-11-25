<table class="table table-bordered table-hover">
  <thead class="thead-dark">
    <tr>
      <th colspan="3"><p id="cb"></p></th>
    </tr>
    <tr>
      <th>Kode Akun</th>
      <th>Nama Akun</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <?php
        foreach($setcoa as $s){
      ?>
        <tr>
          <td><?php echo $s->kode_akun; ?></td>
          <td><?php echo $s->nama_akun; ?></td>
          <td><a href="#" class="btn btn-danger hapus" data-id ="<?php echo $s->id_setakuncabang; ?>"><i class="fa fa-trash"></i></a></td>
        </tr>
    <?php } ?>
    </tr>
  </tbody>
</table>
<script type="text/javascript">
  $(function(){
    function loadhead(){
			var cabang = $("#cabang").val();
      if(cabang == 'PST'){
        $("#cb").text(cabang);
      }else{
        $("#cb").text("Cabang "+cabang);
      }
		}
    function loadsetcoa(){
      var cabang 		= $("#cabang").val();
      var kategori	= $("#kategori").val();
      $.ajax({
        type    : 'POST',
        url     : '<?php echo base_url();?>coa/loadsetcoa',
        data    : {cabang:cabang,kategori:kategori},
        cache   : false,
        success : function(respond){
          $("#loadsetcoa").html(respond);
        }
      });

    }
    $(".hapus").click(function(e){
      e.preventDefault();
      var id = $(this).attr("data-id");
      $.ajax({
        type    : 'POST',
        url     : '<?php echo base_url(); ?>coa/hapus_setcoa',
        data    : {id:id},
        cache   : false,
        success : function(respond){
          loadsetcoa();
        }

      });
    })
    loadhead();
  });
</script>
