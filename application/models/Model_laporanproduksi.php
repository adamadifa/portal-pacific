<?php

class Model_laporanproduksi extends CI_Model{


	function listproduk(){

		return $this->db->get('master_barang');
	}

	function get_produk($produk=null){

		$this->db->where('kode_produk',$produk);
		return $this->db->get('master_barang');

	}

	function mutasi($dari,$sampai,$produk){

		$this->db->order_by('tgl_mutasi_produksi,inout,shift','ASC');
		$this->db->where('tgl_mutasi_produksi >=',$dari);
		$this->db->where('tgl_mutasi_produksi <=',$sampai);
		$this->db->where('detail_mutasi_produksi.kode_produk',$produk);
		$this->db->join('mutasi_produksi','detail_mutasi_produksi.no_mutasi_produksi=mutasi_produksi.no_mutasi_produksi');
		$this->db->join('master_barang','detail_mutasi_produksi.kode_produk=master_barang.kode_produk');
		return $this->db->get('detail_mutasi_produksi');
	}

	function getSaldoAwalMutasi($dari,$sampai,$produk){
		$this->db->where('tgl_mutasi_produksi <',$dari);
		$this->db->where('detail_mutasi_produksi.kode_produk',$produk);
		$this->db->join('mutasi_produksi','detail_mutasi_produksi.no_mutasi_produksi=mutasi_produksi.no_mutasi_produksi');
		$this->db->select(
			"SUM(IF( `inout` = 'IN', jumlah, 0)) AS jml_in,
			SUM(IF( `inout` = 'OUT', jumlah, 0)) AS jml_out,
			SUM(IF( `inout` = 'IN', jumlah, 0)) -SUM(IF( `inout` = 'OUT', jumlah, 0)) as saldo_awal"
		);
		$this->db->from('detail_mutasi_produksi');
		return $this->db->get();
	}


	function rekapmutasi($dari,$sampai){

    $query = "SELECT
    m.kode_produk,
    nama_barang,
    (
    SELECT
    IFNULL(
    SUM( IF ( `inout` = 'IN', jumlah, 0 ) ) - SUM( IF ( `inout` = 'OUT', jumlah, 0 ) ),
    0 
    ) 
    FROM
    detail_mutasi_produksi d
    INNER JOIN mutasi_produksi ON d.no_mutasi_produksi = mutasi_produksi.no_mutasi_produksi 
    WHERE
    d.kode_produk = m.kode_produk 
    AND tgl_mutasi_produksi < '$dari' 
    ) AS saldoawal,
    (
    SELECT
    SUM(
    IF
    ( jenis_mutasi = 'BPBJ', jumlah, 0 )) 
    FROM
    detail_mutasi_produksi d
    INNER JOIN mutasi_produksi ON d.no_mutasi_produksi = mutasi_produksi.no_mutasi_produksi 
    WHERE
    d.kode_produk = m.kode_produk 
    AND tgl_mutasi_produksi BETWEEN '$dari' 
    AND '$sampai' 
    ) AS jmlbpbj,
    (
    SELECT
    SUM(
    IF
    ( jenis_mutasi = 'FSTHP', jumlah, 0 )) 
    FROM
    detail_mutasi_produksi d
    INNER JOIN mutasi_produksi ON d.no_mutasi_produksi = mutasi_produksi.no_mutasi_produksi 
    WHERE
    d.kode_produk = m.kode_produk 
    AND tgl_mutasi_produksi BETWEEN '$dari' 
    AND '$sampai' 
    ) AS jmlfsthp,
    (
    SELECT
    SUM(
    IF
    ( jenis_mutasi = 'LAIN-LAIN' AND `inout` = 'IN', jumlah, 0 )) 
    FROM
    detail_mutasi_produksi d
    INNER JOIN mutasi_produksi ON d.no_mutasi_produksi = mutasi_produksi.no_mutasi_produksi 
    WHERE
    d.kode_produk = m.kode_produk 
    AND tgl_mutasi_produksi BETWEEN '$dari' 
    AND '$sampai' 
    ) AS mutasi_in,
    (
    SELECT
    SUM(
    IF
    ( jenis_mutasi = 'LAIN-LAIN' AND `inout` = 'OUT', jumlah, 0 )) 
    FROM
    detail_mutasi_produksi d
    INNER JOIN mutasi_produksi ON d.no_mutasi_produksi = mutasi_produksi.no_mutasi_produksi 
    WHERE
    d.kode_produk = m.kode_produk 
    AND tgl_mutasi_produksi BETWEEN '$dari' 
    AND '$sampai' 
    ) AS mutasi_out 
    FROM
    master_barang m";

    return $this->db->query($query);


  }


  function getDepartemen(){

    $query = "
    SELECT * FROM departemen 
    ";
    return $this->db->query($query);
  }

  function getKategori(){

    $query = "
    SELECT * FROM kategori_barang_pembelian 
    ";
    return $this->db->query($query);
  }


  function getbarang(){

    $query = "
    SELECT * FROM master_barang_produksi ORDER BY nama_barang
    ";
    return $this->db->query($query);
  }

  function list_detailPersediaan($bulan,$tahun,$kode_kategori=""){

    if ($kode_kategori != "") {

      $kode_kategori = "AND master_barang_produksi.kode_kategori = '".$kode_kategori."' ";

    } 

    $query = "SELECT 
    master_barang_produksi.kode_barang,
    master_barang_produksi.nama_barang,
    master_barang_produksi.satuan,
    master_barang_produksi.kode_kategori,
    sa.saldoawal,
    op.opname,
    gm.gudang,
    gm.seasoning,
    gm.trial,
    gk.pemakaian,
    gk.retur,
    gk.lainnya

    FROM master_barang_produksi

    LEFT JOIN (SELECT saldoawal_gp_detail.kode_barang,SUM( qty ) AS saldoawal FROM saldoawal_gp_detail 
    INNER JOIN saldoawal_gp ON saldoawal_gp.kode_saldoawal=saldoawal_gp_detail.kode_saldoawal
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY saldoawal_gp_detail.kode_barang ) sa ON (master_barang_produksi.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT opname_gp_detail.kode_barang,SUM( qty ) AS opname FROM opname_gp_detail 
    INNER JOIN opname_gp ON opname_gp.kode_opname=opname_gp_detail.kode_opname
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY opname_gp_detail.kode_barang ) op ON (master_barang_produksi.kode_barang = op.kode_barang)

    LEFT JOIN (SELECT 
    detail_pemasukan_gp.kode_barang,
    SUM( IF( kode_dept = 'Gudang' , qty ,0 )) AS gudang,
    SUM( IF( kode_dept = 'Seasoning' , qty ,0 )) AS seasoning,
    SUM( IF( kode_dept = 'Trial' , qty ,0 )) AS trial
    FROM 
    detail_pemasukan_gp 
    INNER JOIN pemasukan_gp ON detail_pemasukan_gp.nobukti_pemasukan = pemasukan_gp.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY detail_pemasukan_gp.kode_barang) gm ON (master_barang_produksi.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT 
    detail_pengeluaran_gp.kode_barang,
    SUM( IF( kode_dept = 'Pemakaian' , qty ,0 )) AS pemakaian,
    SUM( IF( kode_dept = 'Retur Out' , qty ,0 )) AS retur,
    SUM( IF( kode_dept = 'Lainnya' , qty ,0 )) AS lainnya
    FROM detail_pengeluaran_gp 
    INNER JOIN pengeluaran_gp ON detail_pengeluaran_gp.nobukti_pengeluaran = pengeluaran_gp.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun' 
    GROUP BY detail_pengeluaran_gp.kode_barang) gk ON (master_barang_produksi.kode_barang = gk.kode_barang)

    ORDER BY kode_kategori,nama_barang ASC
    ";
    return $this->db->query($query);
  }

  function list_detailPemasukan($dari,$sampai,$kode_barang){

    if ($kode_barang != "") {

      $kode_barang = "AND detail_pemasukan_gp.kode_barang = '".$kode_barang."' ";

    } 
    $query = "
    SELECT *,pemasukan_gp.kode_dept FROM detail_pemasukan_gp

    INNER JOIN pemasukan_gp ON 
    pemasukan_gp.nobukti_pemasukan = detail_pemasukan_gp.nobukti_pemasukan
    INNER JOIN master_barang_produksi ON 
    master_barang_produksi.kode_barang = detail_pemasukan_gp.kode_barang

    WHERE pemasukan_gp.tgl_pemasukan BETWEEN '$dari' AND '$sampai' "
    .$kode_barang
    ."
    ORDER BY 
    pemasukan_gp.tgl_pemasukan,
    detail_pemasukan_gp.kode_barang,
    pemasukan_gp.nobukti_pemasukan 
    ASC
    ";
    return $this->db->query($query);
  }

  function list_detailPengeluaran($dari,$sampai,$kode_dept="",$kode_barang=""){

    if ($kode_dept != "") {

      $kode_dept = "AND pengeluaran_gp.kode_dept = '".$kode_dept."' ";

    } 

    if ($kode_barang != "") {

      $kode_barang = "AND detail_pengeluaran_gp.kode_barang = '".$kode_barang."' ";

    } 

    $query = "
    SELECT *,pengeluaran_gp.kode_dept AS kode_dept FROM detail_pengeluaran_gp

    INNER JOIN pengeluaran_gp ON 
    pengeluaran_gp.nobukti_pengeluaran = detail_pengeluaran_gp.nobukti_pengeluaran
    INNER JOIN master_barang_produksi ON 
    master_barang_produksi.kode_barang = detail_pengeluaran_gp.kode_barang

    WHERE pengeluaran_gp.tgl_pengeluaran BETWEEN '$dari' AND '$sampai'"
    .$kode_dept
    .$kode_barang
    ."
    ORDER BY 
    pengeluaran_gp.tgl_pengeluaran,
    pengeluaran_gp.nobukti_pengeluaran 
    ASC
    ";
    return $this->db->query($query);
  }


}
