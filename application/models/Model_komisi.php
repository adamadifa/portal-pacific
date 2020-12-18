<?php

class Model_komisi extends CI_Model
{
  function settarget($data)
  {
    $cek = $this->db->get_where('komisi_target', array('kode_target' => $data['kode_target']))->num_rows();
    if (!empty($cek)) {
      return 1;
    } else {
      $simpan = $this->db->insert('komisi_target', $data);
      if ($simpan) {
        return 2;
      } else {
        return 0;
      }
    }
  }

  function loadtarget($bulan, $tahun)
  {
    return $this->db->get_where('komisi_target', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function simpantarget($data)
  {
    $cek = $this->db->get_where('komisi_target_qty_detail', array('kode_target' => $data['kode_target'], 'id_karyawan' => $data['id_karyawan'], 'kode_produk' => $data['kode_produk']));
    if ($cek->num_rows() > 0) {
      $this->db->update('komisi_target_qty_detail', $data, array('kode_target' => $data['kode_target'], 'id_karyawan' => $data['id_karyawan'], 'kode_produk' => $data['kode_produk']));
    } else {
      $this->db->insert('komisi_target_qty_detail', $data);
    }
  }

  function simpantargetcashin($data)
  {
    $cek = $this->db->get_where('komisi_target_cashin_detail', array('kode_target' => $data['kode_target'], 'id_karyawan' => $data['id_karyawan']));
    if ($cek->num_rows() > 0) {
      $this->db->update('komisi_target_cashin_detail', $data, array('kode_target' => $data['kode_target'], 'id_karyawan' => $data['id_karyawan']));
    } else {
      $this->db->insert('komisi_target_cashin_detail', $data);
    }
  }

  function getKategoripoin()
  {
    return $this->db->get('komisi_kategoripoinqty');
  }

  function cetak_komisi($cabang, $bulan, $tahun)
  {
    $dari = $tahun . "-" . $bulan . "-01";
    $sampai = $tahun . "-" . $bulan . "-31";
    $query = "SELECT karyawan.id_karyawan,nama_karyawan,
    targetkategoriA,realisasitargetA,
    targetkategoriB,realisasitargetB,
    targetproductfocus,realisasitargetproductfocus,
    jumlah_target_cashin,jml_cashin
    FROM karyawan
    LEFT JOIN (
    SELECT  id_karyawan,
    SUM(IF(kategori_komisi='KKQ01',jumlah_target,0)) as targetkategoriA,
    SUM(IF(kategori_komisi='KKQ02',jumlah_target,0)) as targetkategoriB,
    SUM(IF(kategori_komisi='KKQ03',jumlah_target,0)) as targetproductfocus
    FROM
    komisi_target_qty_detail k_detail
    INNER JOIN komisi_target ON k_detail.kode_target = komisi_target.kode_target
    INNER JOIN master_barang ON k_detail.kode_produk = master_barang.kode_produk
    WHERE bulan ='$bulan' AND tahun='$tahun'
    GROUP BY id_karyawan) komisi ON (karyawan.id_karyawan = komisi.id_karyawan)

    LEFT JOIN
    (
    SELECT penjualan.id_karyawan, 
    SUM(IF(kategori_komisi='KKQ01',ROUND((jumlah/barang.isipcsdus),2),0)) as realisasitargetA,
    SUM(IF(kategori_komisi='KKQ02',ROUND((jumlah/barang.isipcsdus),2),0)) as realisasitargetB,
    SUM(IF(kategori_komisi='KKQ03',ROUND((jumlah/barang.isipcsdus),2),0)) as realisasitargetproductfocus
    FROM detailpenjualan
    INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
    INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
    INNER JOIN master_barang ON barang.kode_produk = master_barang.kode_produk
    WHERE tgltransaksi BETWEEN '$dari' AND '$sampai'
    GROUP BY penjualan.id_karyawan
    ) realisasi ON (karyawan.id_karyawan = realisasi.id_karyawan)

    LEFT JOIN (
    SELECT
      id_karyawan,jumlah_target_cashin
    FROM
      komisi_target_cashin_detail k_cashin
      INNER JOIN komisi_target ON k_cashin.kode_target = komisi_target.kode_target
    WHERE
      bulan = '$bulan' AND tahun = '$tahun' 
    GROUP BY
      id_karyawan 
    ) komisicashin ON ( karyawan.id_karyawan = komisicashin.id_karyawan )
    
    LEFT JOIN (
    SELECT
      id_karyawan,SUM(bayar) as jml_cashin
    FROM
      historibayar
    WHERE
      tglbayar BETWEEN '$dari' 
      AND '$sampai' 
    GROUP BY
      id_karyawan 
    ) hb ON ( karyawan.id_karyawan = hb.id_karyawan )
    WHERE kode_cabang ='$cabang' AND nama_karyawan !='-'";

    return $this->db->query($query);
  }
}
