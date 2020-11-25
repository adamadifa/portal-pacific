<div class="row">
  <div class="col-md-12">
    <div class="col-md-4">
      <div class="info-box hover-zoom-effect">
        <div class="icon bg-blue">
          <i class="material-icons">supervisor_account</i>
        </div>
        <div class="content">
          <div class="text">DATA PELANGGAN</div>
          <div class="number"><?php echo $jmlPelanggan['totalpelanggan']; ?></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="info-box hover-zoom-effect">
        <div class="icon bg-green">
          <i class="material-icons">supervisor_account</i>
        </div>
        <div class="content">
          <div class="text">DATA SALESMAN</div>
          <div class="number"><?php echo $jmlSales['totalsales']; ?></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="info-box hover-zoom-effect">
        <div class="icon bg-red">
          <i class="material-icons">storage</i>
        </div>
        <div class="content">
          <div class="text">DATA BARANG</div>
          <div class="number"><?php echo $jmlBrg['totalbrg']; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
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
    <div class="col-md-6">
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
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="header bg-cyan" >
        <h2>
          GRAFIK PENJUALAN
          <small>Data Grafik Penjualan</small>
        </h2>
      </div>
      <div class="body">
        <?php
          $tahunini   = date("Y");
          $tahunlalu  = $tahunini-1;
          foreach($grap as $g){
            $bulan[]       = $g->bulan;
            $lastyear[]    = $g->lastyear;
            $thisyear[]    = $g->thisyear;
          }

          // echo json_encode($bulan);
        ?>
        <canvas id="barChart"></canvas>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
    "use strict";
    $(document).ready(function(){
      /*Bar chart*/
      var data1 = {
          labels: <?php echo json_encode($bulan); ?>,
          datasets: [{
              label: "<?php echo $tahunlalu; ?>",
              backgroundColor: [
                  'rgba(95, 190, 170, 0.99)',
                  'rgba(95, 190, 170, 0.99)',
                  'rgba(95, 190, 170, 0.99)',
                  'rgba(95, 190, 170, 0.99)',
                  'rgba(95, 190, 170, 0.99)',
                  'rgba(95, 190, 170, 0.99)',
                  'rgba(95, 190, 170, 0.99)',
                  'rgba(95, 190, 170, 0.99)',
                  'rgba(95, 190, 170, 0.99)',
                  'rgba(95, 190, 170, 0.99)',
                  'rgba(95, 190, 170, 0.99)',
                  'rgba(95, 190, 170, 0.99)'
              ],
              hoverBackgroundColor: [
                  'rgba(26, 188, 156, 0.88)',
                  'rgba(26, 188, 156, 0.88)',
                  'rgba(26, 188, 156, 0.88)',
                  'rgba(26, 188, 156, 0.88)',
                  'rgba(26, 188, 156, 0.88)',
                  'rgba(26, 188, 156, 0.88)',
                  'rgba(26, 188, 156, 0.88)',
                  'rgba(26, 188, 156, 0.88)',
                  'rgba(26, 188, 156, 0.88)',
                  'rgba(26, 188, 156, 0.88)',
                  'rgba(26, 188, 156, 0.88)',
                  'rgba(26, 188, 156, 0.88)',
              ],
              data: <?php echo json_encode($lastyear); ?>,
          }, {
              label: "<?php echo $tahunini; ?>",
              backgroundColor: [
                  'rgba(93, 156, 236, 0.93)',
                  'rgba(93, 156, 236, 0.93)',
                  'rgba(93, 156, 236, 0.93)',
                  'rgba(93, 156, 236, 0.93)',
                  'rgba(93, 156, 236, 0.93)',
                  'rgba(93, 156, 236, 0.93)',
                  'rgba(93, 156, 236, 0.93)',
                  'rgba(93, 156, 236, 0.93)',
                  'rgba(93, 156, 236, 0.93)',
                  'rgba(93, 156, 236, 0.93)',
                  'rgba(93, 156, 236, 0.93)',
                  'rgba(93, 156, 236, 0.93)'
              ],
              hoverBackgroundColor: [
                  'rgba(103, 162, 237, 0.82)',
                  'rgba(103, 162, 237, 0.82)',
                  'rgba(103, 162, 237, 0.82)',
                  'rgba(103, 162, 237, 0.82)',
                  'rgba(103, 162, 237, 0.82)',
                  'rgba(103, 162, 237, 0.82)',
                  'rgba(103, 162, 237, 0.82)',
                  'rgba(103, 162, 237, 0.82)',
                  'rgba(103, 162, 237, 0.82)',
                  'rgba(103, 162, 237, 0.82)',
                  'rgba(103, 162, 237, 0.82)',
                  'rgba(103, 162, 237, 0.82)'
              ],
              data: <?php echo json_encode($thisyear); ?>,
          }]
      };

      var bar = document.getElementById("barChart").getContext('2d');
      var myBarChart = new Chart(bar, {
          type: 'bar',
          data: data1,
          options: {
              barValueSpacing: 20
          }
      });

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

      loadsaldo();
      $("#cabang").change(function(){
        loadsaldo();
      });


  });
</script>
