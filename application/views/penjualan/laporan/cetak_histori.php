<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<table class="datatable3">
  <tr>
    <td><b>Kode Pelanggan</b></td>
    <td></td>
    <td><?php echo $pel['kode_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><b>Nama Pelanggan</b></td>
    <td></td>
    <td><?php echo $pel['nama_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><b>Alamat</b></td>
    <td></td>
    <td><?php echo $pel['alamat_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><b>HP</b></td>
    <td></td>
    <td><?php echo $pel['no_hp']; ?></td>
  </tr>
  <tr>
    <td><b>Pasar</b></td>
    <td></td>
    <td><?php echo $pel['pasar']; ?></td>
  </tr>
  <tr>
    <td><b>Hari</b></td>
    <td></td>
    <td><?php echo $pel['hari']; ?></td>
  </tr>
</table>
<br>
<table class="datatable3" id="mytable">
  <thead class="thead-dark">
    <tr>
      <th>No Faktur</th>
      <th>Tanggal</th>
      <th>Piutang</th>
      <th>Jml Bayar</th>
      <th>Sisa Bayar</th>
      <th>Salesman</th>
      <th>Ket</th>
      

    </tr>
  </thead>
  <tbody>
    <?php
    $totalallpiutang    = 0;
    $totalallbayar      = 0;
    $totalallsisabayar  = 0;
    foreach ($pmb as $p) {

      if ($p->sisabayar == 0) {
        $color = "bg-green";
        $ket   = "LUNAS";
      } else {

        $color = "bg-red";
        $ket   = "BELUM LUNAS";
      }

      $totalallpiutang    = $totalallpiutang + $p->totalpiutang;
      $totalallbayar      = $totalallbayar + $p->totalbayar;

      $totalallsisabayar  = $totalallsisabayar + $p->sisabayar;

      $cekretur = $this->db->get_where('retur', array('no_fak_penj' => $p->no_fak_penj));
      $retur    = $cekretur->num_rows();
    ?>
      <tr>
        <td><?php echo $p->no_fak_penj; ?></td>
        <td><?php echo $p->tgltransaksi; ?></td>
        <td align="right"><?php echo  number_format($p->totalpiutang, '0', '', '.'); ?></td>
        <td align="right"><?php echo  number_format($p->totalbayar, '0', '', '.'); ?></td>
        <td align="right"><?php echo  number_format($p->sisabayar, '0', '', '.'); ?></td>

        <td><?php echo ucwords($p->nama_karyawan); ?></td>
        <td><span class="badge <?php echo $color ?>"><?php echo $ket; ?></span></td>
        
      </tr>
    <?php } ?>

  </tbody>
  <tr>
    <td colspan="2"><b>TOTAL</b></td>
    <td align="right" id="totalpiutang"><b><?php echo  number_format($totalallpiutang, '0', '', '.'); ?></b></td>
    <td align="right"><b><?php echo  number_format($totalallbayar, '0', '', '.'); ?></b></td>
    <td align="right"><b><?php echo  number_format($totalallsisabayar, '0', '', '.'); ?></b></td>
  </tr>
</table>