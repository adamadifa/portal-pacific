<?php 
$level_user = $this->session->userdata('level_user');
if($level_user=="Administrator" || $level_user=="manager marketing" || $level_user=="manager accounting" || $level_user=="general manager" || $level_user=="audit" || $level_user=="koordinator kepala admin" || $level_user=="spv accounting" ){
  ?>

  <div class="row">
    <div class="col-md-12">
      <div class="col-md-12">
       <div class="card">
        <div class="header bg-blue" >

          <h2>
            REKAP PENJUALAN 
            <small>Data Rekap Penjualan / Cabang</small>
          </h2>
        </div>
        <div class="body">

          <div class="form-group" >
            <div class="form-line">
              <select class="form-control" id="bulan" name="bulan">
                <option value="">Bulan</option>
                <?php for($a=1; $a<=12; $a++){ ?>
                  <option <?php if(date("m")==$a){echo "selected";} ?>  value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group" >
            <div class="form-line">
              <select class="form-control" id="tahun" name="tahun">
                <option value="">Tahun</option>
                <?php for($t=2019; $t<=$tahun; $t++){ ?>
                  <option <?php if(date("Y")==$t){echo "selected";} ?>  value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <a href="#" id="tampilkankasbesar" class="btn bg-blue">Tampilkan Rekap Penjualan & Kas Besar</a>
          <a href="#" id="hidekasbesar" class="btn bg-red">Sembunyikan Rekap Penjualan & Kas Besar</a>
          <div class="table-responsive">
            <div id="loadrekappenjualan">
            </div>
          </div>
          <div class="table-responsive">
            <div id="loadrekapkasbesar">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="row">
  <div class="col-md-12">
    <div class="col-md-6">
     <div class="card">
      <div class="header bg-green" >
        <h2>
          DATA PERSEDIAAN GUDANG
          <small>Data Persediaan Gudang</small>
        </h2>
      </div>
      <div class="body">
        <?php
        foreach ($rekap as $r){
          if($r->saldoakhir <= 0){
            $color = "bg-red";
          }else{
            $color = "bg-green";
          }
          ?>
          <li class="list-group-item"><b><?php echo $r->nama_barang; ?></b> <span class="badge <?php echo $color; ?>"><?php echo number_format($r->saldoakhir,'0','','.'); ?></span></li>
        <?php } ?>
      </div>
    </div>
  </div>
  <!-- <div class="col-md-6">
   <div class="card">
    <div class="header bg-blue" >
      <h2>
        DATA PERSEDIAAN GUDANG CABANG
        <small>Data Persediaan Gudang Cabang</small>
      </h2>
    </div>
    <div class="body">
      <?php if($cb == 'pusat'){ ?>
        <div class="form-group" >
          <div class="form-line">
            <select class="form-control" id="cabang" name="cabang">
              <?php foreach($cabang as $c){ ?>
                <option <?php if($cb==$c->kode_cabang){echo "selected"; } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      <?php }else{ ?>
        <input type="hidden" readonly id="cabang" name="cabang" value="<?php echo $cb; ?>" class="form-control" placeholder="Kode Cabang"  />
      <?php } ?>
      <div id="loadsaldo">

      </div>
    </div>
  </div>
</div> -->
</div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="col-md-12">
      <div class="card">
        <div class="header bg-blue" >
          <h2>
           SEDANG PROSES MAINTENANCE ...
            <small>Data Persediaan All Gudang Cabang</small>
          </h2>
        </div>
        <div class="body">
          <div class="table-responsive">
            <div id="loadrekappersediaan">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="col-md-6">
      <div class="card">
        <div class="header bg-blue" >
          <h2>
            DATA PERSEDIAAN GUDANG CABANG
            <small>Data Persediaan Gudang Cabang</small>
          </h2>
        </div>
        <div class="body">
         
          <div class="form-group" >
            <div class="form-line">
              <select class="form-control" id="produk" name="produk">
                <?php foreach($produk as $c){ ?>
                  <option  value="<?php echo $c->kode_produk."|".$c->isipcsdus;?>"  ><?php echo strtoupper($c->nama_barang); ?></option>
                 <?php } ?>
              </select>
            </div>
          </div>
          <div id="loadsaldoproduk">

          </div>
        </div>
      </div>
    </div>
  </div> -->
</div>
<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <img src="<?php echo base_url(); ?>assets/images/loadingemot.gif" / width="200px" height="150px">
        <div clas="loader-txt">
          <p><b>Mohon Ditunggu Gaees.. ! <br> Sedang Proses Menampilkan Data....</b></p>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    
    function loadsaldo()
    {
      var kodecabang = $("#cabang").val();
      var status     = 'GS';
      $.ajax({
        type  : 'POST',
        url   : '<?php echo base_url(); ?>dashboard/loadsaldo',
        data  : {kodecabang:kodecabang,status:status},
        cache : false,
        success: function(respond)
        {
          $("#loadsaldo").html(respond);
        }
      });
    }

    function loadrekappersediaan()
    {
     
      $.ajax({
        type  : 'POST',
        url   : '<?php echo base_url(); ?>dashboard/loadrekappersediaandpb',
        cache : false,
        success: function(respond)
        {
          $("#loadrekappersediaan").html(respond);
        }
      });
    }

      // function loadsaldoproduk()
      // {
      //   var produk = $("#produk").val();
      //   var data = produk.split("|");
      //   var kodeproduk = data[0];
      //   var isipcsdus = data[1];

      //   //alert(isipcsdus);
      //   var status     = 'GS';
      //   $.ajax({
      //     type  : 'POST',
      //     url   : '<?php echo base_url(); ?>dashboard/loadsaldoproduk',
      //     data  : {kodeproduk:kodeproduk,status:status,isipcsdus:isipcsdus},
      //     cache : false,
      //     success: function(respond)
      //     {
      //       $("#loadsaldoproduk").html(respond);
      //     }
      //   });
      // }

      function hidekasbesar()
      {
        $("#loadrekapkasbesar").hide();
        $("#loadrekappenjualan").hide();
      }

      function loadrekappenjualan()
      {
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        $.ajax({
          type  : 'POST',
          url   : '<?php echo base_url(); ?>laporanpenjualan/loadrekappenjualan',
          data  : {bulan:bulan,tahun:tahun},
          cache : false,
          success: function(respond)
          {
            $("#loadrekappenjualan").html(respond);
          }
        });
      }

      function loadrekapkasbesar()
      {
       
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        $.ajax({
          type  : 'POST',
          url   : '<?php echo base_url(); ?>laporanpenjualan/loadrekapkasbesar',
          data  : {bulan:bulan,tahun:tahun},
          cache : false,
          success: function(respond)
          {
            $("#loadrekapkasbesar").html(respond);
          }
        });
      }
      
      $("#tampilkankasbesar").click(function(e){
        e.preventDefault();
        $("#loadrekapkasbesar").show();
        $("#loadrekappenjualan").show();
      });

      $("#hidekasbesar").click(function(e){
        e.preventDefault();
        $("#loadrekapkasbesar").hide();
        $("#loadrekappenjualan").hide();
      });

      $(document).ajaxStart(function(){
        $("#loadMe").modal({
          backdrop: "static", //remove ability to close modal with click
          keyboard: false, //remove option to close with keyboard
          show: true //Display loader!
        });
      });
      $(document).ajaxComplete(function(){
        $("#loadMe").modal("hide");
      });


      loadrekapkasbesar();
      loadrekappenjualan();
      loadsaldo();
      //loadsaldoproduk();
      loadrekappersediaan();
      hidekasbesar();

      $("#cabang").change(function(){
        loadsaldo();
      });

      // $("#produk").change(function(){
      //   loadsaldoproduk();
      // });

      $("#bulan").change(function(e){
        loadrekappenjualan();
        loadrekapkasbesar();
      });

      $("#tahun").change(function(e){
        loadrekappenjualan();
        loadrekapkasbesar();
      });

      


    });
  </script>
