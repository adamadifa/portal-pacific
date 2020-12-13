<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-6 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Kategori Poin Quantity</h4>
        </div>
        <div class="card-body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>Kode Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Poin</th>
                  </tr>
                </thead>
                <tbody id="loadtarget">
                  <?php foreach ($kategoripoin as $k) { ?>
                    <tr>
                      <td><?php echo $k->kode_kategori; ?></td>
                      <td><?php echo $k->nama_kategori; ?></td>
                      <td><?php echo $k->poin; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4"></div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_marketing_administrator'); ?>
    </div>
  </div>
</div>