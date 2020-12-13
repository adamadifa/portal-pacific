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
}
