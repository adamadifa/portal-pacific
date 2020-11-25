
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