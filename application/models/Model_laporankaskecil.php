<?php

class Model_laporankaskecil extends CI_Model{

  function kaskecil($cabang,$dari,$sampai){
    $this->db->where('kode_cabang',$cabang);
    $this->db->where('tgl_kaskecil >=',$dari);
    $this->db->where('tgl_kaskecil <=',$sampai);
    $this->db->join('coa','kaskecil_detail.kode_akun = coa.kode_akun');
    $this->db->order_by('tgl_kaskecil,order,nobukti','asc');
    return $this->db->get('kaskecil_detail');
  }

  function mutasibank($cabang,$dari,$sampai){
    $this->db->where('kode_cabang',$cabang);
    $this->db->where('tgl_mutasi >=',$dari);
    $this->db->where('tgl_mutasi <=',$sampai);
    $this->db->join('coa','mutasibank.kode_akun = coa.kode_akun');
    return $this->db->get('mutasibank');
  }

  function rekapkaskecil($cabang,$dari,$sampai){
    $query = "SELECT k.kode_akun,nama_akun,penerimaan,pengeluaran,kode_cabang
      FROM set_coa_cabang
      INNER JOIN coa ON set_coa_cabang.kode_akun = coa.kode_akun
      LEFT JOIN (
        SELECT kaskecil_detail.kode_akun,
          SUM(IF(status_dk ='K' AND kode_cabang='$cabang',jumlah,0 )) AS penerimaan,
          SUM(IF(status_dk ='D' AND kode_cabang='$cabang',jumlah,0 )) AS Pengeluaran
        FROM kaskecil_detail WHERE tgl_kaskecil BETWEEN '$dari' AND '$sampai'
        GROUP BY kaskecil_detail.kode_akun
      ) k ON set_coa_cabang.kode_akun = k.kode_akun
    WHERE kode_cabang ='$cabang'
    GROUP BY set_coa_cabang.kode_akun,nama_akun,penerimaan,pengeluaran,kode_cabang";
    return $this->db->query($query);
  }

}
