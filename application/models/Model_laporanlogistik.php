<?php

class Model_laporanlogistik extends CI_Model
{


  function getDepartemen()
  {

    $query = "
    SELECT * FROM departemen WHERE status_pengajuan != '2'
    ";
    return $this->db->query($query);
  }

  function getbarang()
  {

    $query = "
    SELECT * FROM master_barang_pembelian WHERE kode_dept = 'GDL' AND status = 'Aktif' ORDER BY nama_barang
    ";
    return $this->db->query($query);
  }

  function getKategori()
  {

    $kodedept = $this->session->userdata('dept');
    if ($kodedept != "") {

      $kodedept = "WHERE kategori_barang_pembelian.kode_dept = '" . $kodedept . "' ";
    }
    $query = "
    SELECT * FROM kategori_barang_pembelian "
      . $kodedept
      . "
    ";
    return $this->db->query($query);
  }

  function list_detailPersediaan($bulan, $tahun, $kode_kategori)
  {

    if ($kode_kategori != "") {

      $kode_kategori = "AND master_barang_pembelian.kode_kategori = '" . $kode_kategori . "' ";
    }

    $query = "SELECT 
    master_barang_pembelian.kode_barang,
    master_barang_pembelian.nama_barang,
    kategori_barang_pembelian.kode_kategori,
    kategori_barang_pembelian.kategori,
    master_barang_pembelian.satuan,
    sa.qtysaldoawal,
    sa.totalsa,
    sa.hargasaldoawal,
    gm.totalpemasukan,
    gm.penyesuaian,
    gm.qtypemasukan,
    gm.hargapemasukan,
    op.qtyopname,
    gk.qtypengeluaran

    FROM master_barang_pembelian
    INNER JOIN kategori_barang_pembelian ON 
    master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori


    LEFT JOIN (SELECT saldoawal_gl_detail.kode_barang,SUM(saldoawal_gl_detail.harga) AS hargasaldoawal,SUM( qty ) AS qtysaldoawal,SUM(saldoawal_gl_detail.harga*qty) AS 
    totalsa FROM saldoawal_gl_detail 
    INNER JOIN saldoawal_gl ON saldoawal_gl.kode_saldoawal_gl=saldoawal_gl_detail.kode_saldoawal_gl
    WHERE bulan = '$bulan' AND tahun = '$tahun'
    GROUP BY saldoawal_gl_detail.kode_barang ) sa ON (master_barang_pembelian.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT opname_gl_detail.kode_barang,SUM( qty ) AS qtyopname FROM opname_gl_detail 
    INNER JOIN opname_gl ON opname_gl.kode_opname_gl=opname_gl_detail.kode_opname_gl
    WHERE bulan = '$bulan' AND tahun = '$tahun'
    GROUP BY opname_gl_detail.kode_barang ) op ON (master_barang_pembelian.kode_barang = op.kode_barang)

    LEFT JOIN (SELECT detail_pemasukan.kode_barang,SUM( penyesuaian ) AS penyesuaian,SUM( qty ) AS qtypemasukan,SUM( harga ) AS hargapemasukan,SUM(detail_pemasukan.harga * qty) AS totalpemasukan FROM 
    detail_pemasukan 
    INNER JOIN pemasukan ON detail_pemasukan.nobukti_pemasukan = pemasukan.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun'
    GROUP BY detail_pemasukan.kode_barang) gm ON (master_barang_pembelian.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT detail_pengeluaran.kode_barang,SUM( qty ) AS qtypengeluaran FROM detail_pengeluaran 
    INNER JOIN pengeluaran ON detail_pengeluaran.nobukti_pengeluaran = pengeluaran.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun'
    GROUP BY detail_pengeluaran.kode_barang) gk ON (master_barang_pembelian.kode_barang = gk.kode_barang)
    

    WHERE master_barang_pembelian.kode_dept = 'GDL' AND master_barang_pembelian.status = 'Aktif' "
      . $kode_kategori
      . "
    GROUP BY
    master_barang_pembelian.kode_barang,
    master_barang_pembelian.nama_barang,
    kategori_barang_pembelian.kode_kategori,
    kategori_barang_pembelian.kategori,
    master_barang_pembelian.satuan,
    sa.qtysaldoawal,
    sa.totalsa,
    sa.hargasaldoawal,
    gm.totalpemasukan,
    gm.qtypemasukan,
    gm.hargapemasukan,
    op.qtyopname,
    gk.qtypengeluaran
    ORDER BY master_barang_pembelian.nama_barang ASC
    ";
    return $this->db->query($query);
  }


  function list_detailPersediaanopname($bulan, $tahun, $kode_kategori)
  {


    if ($kode_kategori != "") {

      $kode_kategori = "AND master_barang_pembelian.kode_kategori = '" . $kode_kategori . "' ";
    }

    $query = "SELECT 
    master_barang_pembelian.kode_barang,
    master_barang_pembelian.nama_barang,
    kategori_barang_pembelian.kode_kategori,
    kategori_barang_pembelian.kategori,
    master_barang_pembelian.satuan,
    sa.qtysaldoawal,
    sa.hargasaldoawal,
    gm.qtypemasukan,
    gm.harga AS hargapemasukan,
    op.qtyopname,
    gk.qtypengeluaran

    FROM master_barang_pembelian
    LEFT JOIN kategori_barang_pembelian ON 
    master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori


    LEFT JOIN (SELECT saldoawal_gl_detail.kode_barang,SUM(saldoawal_gl_detail.harga) AS hargasaldoawal,SUM( qty ) AS qtysaldoawal,SUM(saldoawal_gl_detail.harga*qty) AS 
    totalsa FROM saldoawal_gl_detail 
    INNER JOIN saldoawal_gl ON saldoawal_gl.kode_saldoawal_gl=saldoawal_gl_detail.kode_saldoawal_gl
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY kode_barang,saldoawal_gl_detail.harga ) sa ON (master_barang_pembelian.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT opname_gl_detail.kode_barang,SUM( qty ) AS qtyopname FROM opname_gl_detail 
    INNER JOIN opname_gl ON opname_gl.kode_opname_gl=opname_gl_detail.kode_opname_gl
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY kode_barang ) op ON (master_barang_pembelian.kode_barang = op.kode_barang)

    LEFT JOIN (SELECT detail_pemasukan.kode_barang,detail_pemasukan.harga,SUM( qty ) AS qtypemasukan,SUM(detail_pemasukan.harga * qty) AS totalhargapemasukan FROM 
    detail_pemasukan 
    INNER JOIN pemasukan ON detail_pemasukan.nobukti_pemasukan = pemasukan.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY kode_barang,detail_pemasukan.harga) gm ON (master_barang_pembelian.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT detail_pengeluaran.kode_barang,SUM( qty ) AS qtypengeluaran FROM detail_pengeluaran 
    INNER JOIN pengeluaran ON detail_pengeluaran.nobukti_pengeluaran = pengeluaran.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun' 
    GROUP BY kode_barang) gk ON (master_barang_pembelian.kode_barang = gk.kode_barang)
    

    WHERE master_barang_pembelian.kode_dept = 'GDL' AND master_barang_pembelian.status = 'Aktif' "
      . $kode_kategori
      . "
    ORDER BY master_barang_pembelian.nama_barang ASC
    ";
    return $this->db->query($query);
  }

  function list_detailPemasukan($dari, $sampai, $kode_kategori, $kode_barang)
  {


    if ($kode_kategori != "") {

      $kode_kategori = "AND master_barang_pembelian.kode_kategori = '" . $kode_kategori . "' ";
    }

    if ($kode_barang != "") {

      $kode_barang = "AND detail_pemasukan.kode_barang = '" . $kode_barang . "' ";
    }

    $query = "
    SELECT gk.nama_supplier,detail_pemasukan.penyesuaian,pemasukan.tgl_pemasukan,master_barang_pembelian.kode_barang,satuan,keterangan,nama_barang,kategori,nama_akun,coa.kode_akun,harga,qty,pemasukan.nobukti_pemasukan FROM detail_pemasukan

    INNER JOIN pemasukan ON 
    pemasukan.nobukti_pemasukan = detail_pemasukan.nobukti_pemasukan
    INNER JOIN master_barang_pembelian ON 
    master_barang_pembelian.kode_barang = detail_pemasukan.kode_barang
    INNER JOIN kategori_barang_pembelian ON 
    master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori
    INNER JOIN coa ON 
    detail_pemasukan.kode_akun = coa.kode_akun

    LEFT JOIN (SELECT pembelian.nobukti_pembelian,tgl_pemasukan,nama_supplier FROM pembelian 
    INNER JOIN pemasukan ON pemasukan.nobukti_pemasukan = pembelian.nobukti_pembelian 
    INNER JOIN supplier ON pembelian.kode_supplier = supplier.kode_supplier
    GROUP BY nobukti_pembelian) gk ON (pemasukan.nobukti_pemasukan = gk.nobukti_pembelian)

    WHERE pemasukan.tgl_pemasukan BETWEEN '$dari' AND '$sampai' AND master_barang_pembelian.status = 'Aktif' AND master_barang_pembelian.kode_dept = 'GDL'"
      . $kode_kategori
      . $kode_barang
      . "
    ORDER BY 
    pemasukan.tgl_pemasukan,
    detail_pemasukan.kode_barang,
    pemasukan.nobukti_pemasukan 
    ASC
    ";
    return $this->db->query($query);
  }

  function list_detailPengeluaran($dari, $sampai, $kode_dept, $kode_kategori, $kode_barang, $kode_cabang)
  {

    if ($kode_dept != "") {

      $kode_dept = "AND pengeluaran.kode_dept = '" . $kode_dept . "' AND detail_pengeluaran.kode_cabang = '' ";
    }

    if ($kode_kategori != "") {

      $kode_kategori = "AND master_barang_pembelian.kode_kategori = '" . $kode_kategori . "' ";
    }

    if ($kode_barang != "") {

      $kode_barang = "AND detail_pengeluaran.kode_barang = '" . $kode_barang . "' ";
    }

    if ($kode_cabang != "") {

      $kode_cabang = "AND detail_pengeluaran.kode_cabang = '" . $kode_cabang . "' ";
    }

    $query = "
    SELECT * FROM detail_pengeluaran

    INNER JOIN pengeluaran ON 
    pengeluaran.nobukti_pengeluaran = detail_pengeluaran.nobukti_pengeluaran
    LEFt JOIN cabang ON 
    detail_pengeluaran.kode_cabang = cabang.kode_cabang
    INNER JOIN departemen ON 
    departemen.kode_dept = pengeluaran.kode_dept
    INNER JOIN master_barang_pembelian ON 
    master_barang_pembelian.kode_barang = detail_pengeluaran.kode_barang
    INNER JOIN kategori_barang_pembelian ON 
    master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori

    WHERE pengeluaran.tgl_pengeluaran BETWEEN '$dari' AND '$sampai' AND master_barang_pembelian.status = 'Aktif' AND  master_barang_pembelian.kode_dept = 'GDL'"
      . $kode_dept
      . $kode_barang
      . $kode_kategori
      . $kode_cabang
      . "
    ORDER BY 
    pengeluaran.tgl_pengeluaran,
    pengeluaran.nobukti_pengeluaran 
    ASC
    ";
    return $this->db->query($query);
  }
}
