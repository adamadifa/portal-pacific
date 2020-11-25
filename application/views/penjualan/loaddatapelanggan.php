<table class="table table-striped" style="font-size:11px">
  <tr>
    <th>Alamat</th>
    <th>:</th>
    <td><?php echo $pelanggan['alamat_pelanggan']; ?></td>
  </tr>
  <tr>
    <th>No HP</th>
    <th>:</th>
    <td><?php echo $pelanggan['no_hp']; ?></td>
  </tr>
  <tr>
    <th>PASAR</th>
    <th>:</th>
    <td><?php echo $pelanggan['pasar']; ?></td>
  </tr>
  <tr>
    <th>KEL/KEC</th>
    <th>:</th>
    <td><?php echo $pelanggan['kelurahan']."/".$pelanggan['kecamatan']; ?></td>
  </tr>
  <tr>
    <th>KOORDINAT</th>
    <th>:</th>
    <td><?php echo $pelanggan['latitude'].",".$pelanggan['longitude']; ?></td>
  </tr>
</table>