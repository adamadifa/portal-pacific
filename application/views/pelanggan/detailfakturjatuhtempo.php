<div class="card">
  <div class="header bg-cyan">
    <h2>
      Detail Faktur Jatuh Tempo
      <small>Detail Faktur Jatuh Tempo</small>
    </h2>

  </div>
  <div class="body">
    <div class="row clearfix">
      <div class="col-sm-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>No Faktur</th>
              <th>Tanggal Transaksi</th>
              <th>Jatuh Tempo</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php $total = 0;$no = 1; foreach($faktur as $d){ $total = $total + $d->total; ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $d->no_fak_penj; ?></td>
                <td><?php echo DateToIndo2($d->tgltransaksi); ?></td>
                <td><?php echo DateToIndo2($d->jt); ?></td>
                <td style="text-align:right"><?php echo number_format($d->total,'0','','.'); ?></td>
              </tr>  
            <?php $no++;} ?>

          </tbody>
          
          <tfoot>
            <th colspan="4">Total</th>
            <th style="text-align:right"><?php echo number_format($total,'0','','.'); ?></th>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
