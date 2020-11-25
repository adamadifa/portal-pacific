
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
        <div class="col-md-4">
            <div class="info-box bg-teal hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">PENJUALAN TAHUN LALU</div>
                    <div class="number"><?php echo number_format($penjualanL['totalpenjualan'],'0','','.'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">PENJUALAN TAHUN INI</div>
                    <div class="number"><?php echo number_format($penjualanN['totalpenjualan'],'0','','.'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-red hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="content">
                    <div class="text">JUMLAH PIUTANG</div>
                    <div class="number"><?php echo number_format($piutang['totalpiutang'],'0','','.'); ?></div>
                </div>
            </div>
        </div>

    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
             <div class="card">
                <div class="header">
                    <h2>
                       Grafik Penjualan Tahun <?php echo date('Y'); ?> <small></small>
                    </h2>
                </div>
                <div class="body">
                    <div class="chart">
                      <div id="chartPeminjaman"></div>
                    </div>
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
                    <?php foreach ($rekap as $r){

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
        <?php foreach ($cabang as $c){

            $rekapcabang = $this->Model_dashboard->rekapbjcabang($c->kode_cabang)->result();
         ?>
            <div class="col-md-6">
               <div class="card">
                  <div class="header bg-cyan" >
                      <h2>
                          DATA PERSEDIAAN GUDANG <?php echo strtoupper($c->nama_cabang); ?>
                          <small>Data Persediaan Gudang</small>
                      </h2>
                  </div>
                  <div class="body">
                      <?php foreach ($rekapcabang as $rc){

                          if($rc->saldoakhir <= 0){

                            $color = "bg-red";
                          }else{

                            $color = "bg-green";
                          }

                       ?>
                          <li class="list-group-item"><b><?php echo $rc->nama_barang; ?></b> <span class="badge <?php echo $color; ?>"><?php echo number_format($rc->saldoakhir/$rc->isipcsdus,'2',',','.'); ?></span></li>
                      <?php } ?>
                  </div>
              </div>
          </div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    
    $(function(){

       Highcharts.chart('chartPeminjaman', {
          chart: {
            type: 'column'
          },
          title: {
            text: ''
          },
          subtitle: {
            text: ''
          },
          xAxis: {
            categories: [
              'Jan',
              'Feb',
              'Mar',
              'Apr',
              'May',
              'Jun',
              'Jul',
              'Aug',
              'Sep',
              'Oct',
              'Nov',
              'Dec'
            ],
            crosshair: true
          },
          yAxis: {
            min: 0,
            title: {
              text: 'Total Penjualan (Rupiah)'
            }
          },
          tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
              '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
          },
          plotOptions: {
            column: {
              pointPadding: 0.2,
              borderWidth: 0
            }
          },
          series: [
          {
            name: '<?php echo date('Y'); ?>',
            data: [

                <?php

                  foreach($penjualanNow->result() as $pn){

                      echo $pn->totalpenjualan.",";
                  }

               ?> 
            ]

          }, 
          {
            name: '<?php echo date('Y')-1; ?>',
            data: [

              <?php

                  foreach($penjualanLast->result() as $pn){

                      echo $pn->totalpenjualan.",";
                  }

               ?>


            ]

          }, 
          ]
        });




    });

</script>