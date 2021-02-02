<?php

class Model_gudangbahan extends CI_Model
{

  function hapuspengeluaran()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $this->db->query("DELETE FROM pengeluaran_gb WHERE nobukti_pengeluaran = '$nobukti' ");
    $this->db->query("DELETE FROM detail_pengeluaran_gb WHERE nobukti_pengeluaran = '$nobukti' ");
  }

  function getKategori()
  {

    return $this->db->get('kategori_barang_pembelian');
  }


  function listproduk()
  {

    return $this->db->get('master_barang_pembelian');
  }

  function ceksaldoretur($bulan, $tahun)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    return $this->db->get_where('saldoawal_gb_retur', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function ceksaldoallretur()
  {

    return $this->db->get('saldoawal_gb_retur');
  }

  function ceksaldoSkrgretur($bulan, $tahun)
  {

    return $this->db->get_where('saldoawal_gb_retur', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function ceksaldo($bulan, $tahun)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    return $this->db->get_where('saldoawal_gb', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function ceksaldoall()
  {

    return $this->db->get('saldoawal_gb');
  }

  function ceksaldoSkrg($bulan, $tahun)
  {

    return $this->db->get_where('saldoawal_gb', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function cekopname($bulan, $tahun)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    return $this->db->get_where('opname_gb', array('bulan' => $bulan, 'tahun' => $tahun,));
  }

  function cekopnameall()
  {

    return $this->db->get('opname_gb');
  }
  function cekopnameSkrg($bulan, $tahun)
  {

    return $this->db->get_where('opname_gb', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  public function getDataPengeluaranR($rowno, $rowperpage, $nobukti = "", $tgl_pengeluaran = "")
  {

    $this->db->select('*');
    $this->db->from('pengeluaran_gp');
    $this->db->order_by('tgl_pengeluaran,nobukti_pengeluaran', 'DESC');
    $this->db->where('kode_dept', 'Retur Out');
    $this->db->where('nobukti_pengeluaran NOT IN (SELECT nobukti_retur FROM retur_gb)');

    if ($nobukti != '') {
      $this->db->like('nobukti_pengeluaran', $nobukti);
    }

    if ($tgl_pengeluaran != '') {
      $this->db->where('tgl_pengeluaran', $tgl_pengeluaran);
    }


    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordPengeluaranCountR($nobukti = "", $tgl_pengeluaran = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('pengeluaran_gp');
    $this->db->order_by('tgl_pengeluaran', 'desc');
    $this->db->where('kode_dept', 'Retur Out');

    if ($nobukti != '') {
      $this->db->like('nobukti_pengeluaran', $nobukti);
    }

    if ($tgl_pengeluaran != '') {
      $this->db->where('tgl_pengeluaran', $tgl_pengeluaran);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


  function getDetailopname($bulan, $tahun)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    $query = "SELECT 
    master_barang_pembelian.kode_barang,
    master_barang_pembelian.nama_barang,
    master_barang_pembelian.satuan,
    op.qtyunitop,
    sa.qtyunitsa,
    sa.qtyberatsa,
    op.qtyberatop,
    gm.qtypemb1,
    gm.qtylainnya1,
    gm.qtypemb2,
    gm.qtylainnya2,
    gk.qtyprod3,
    gk.qtyseas3,
    gk.qtypdqc3,
    gk.qtysus3,
    gk.qtylain3,
    gk.qtyprod4,
    gk.qtyseas4,
    gk.qtypdqc4,
    gk.qtysus4,
    gk.qtylain4

    FROM master_barang_pembelian

    LEFT JOIN (SELECT saldoawal_gb_detail.kode_barang,SUM( qty_unit ) AS qtyunitsa,SUM( qty_berat ) AS qtyberatsa FROM saldoawal_gb_detail 
    INNER JOIN saldoawal_gb ON saldoawal_gb.kode_saldoawal_gb=saldoawal_gb_detail.kode_saldoawal_gb
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY saldoawal_gb_detail.kode_barang ) sa ON (master_barang_pembelian.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT opname_gb_detail.kode_barang,SUM( qty_unit ) AS qtyunitop,SUM( qty_berat ) AS qtyberatop FROM opname_gb_detail 
    INNER JOIN opname_gb ON opname_gb.kode_opname_gb=opname_gb_detail.kode_opname_gb
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY opname_gb_detail.kode_barang ) op ON (master_barang_pembelian.kode_barang = op.kode_barang)

    LEFT JOIN (SELECT 
    detail_pemasukan_gb.kode_barang,
    SUM( IF( departemen = 'Pembelian' , qty_unit ,0 )) AS qtypemb1,
    SUM( IF( departemen = 'Lainnya' , qty_unit ,0 )) AS qtylainnya1,

    SUM( IF( departemen = 'Pembelian' , qty_berat ,0 )) AS qtypemb2,
    SUM( IF( departemen = 'Lainnya' , qty_berat ,0 )) AS qtylainnya2,
    SUM( (IF( departemen = 'Pembelian' , qty_berat ,0 )) + (IF( departemen = 'Lainnya' , qty_berat ,0 ))) AS pemasukanqtyberat
    FROM 
    detail_pemasukan_gb 
    INNER JOIN pemasukan_gb ON detail_pemasukan_gb.nobukti_pemasukan = pemasukan_gb.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY detail_pemasukan_gb.kode_barang) gm ON (master_barang_pembelian.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT 
    detail_pengeluaran_gb.kode_barang,
    SUM( IF( kode_dept = 'Produksi' , qty_unit ,0 )) AS qtyprod3,
    SUM( IF( kode_dept = 'Seasoning' , qty_unit ,0 )) AS qtyseas3,
    SUM( IF( kode_dept = 'PDQC' , qty_unit ,0 )) AS qtypdqc3,
    SUM( IF( kode_dept = 'Susut' , qty_unit ,0 )) AS qtysus3,
    SUM( IF( kode_dept = 'Lainnya' , qty_unit ,0 )) AS qtylain3,

    SUM( IF( kode_dept = 'Produksi' , qty_berat ,0 )) AS qtyprod4,
    SUM( IF( kode_dept = 'Seasoning' , qty_berat ,0 )) AS qtyseas4,
    SUM( IF( kode_dept = 'PDQC' , qty_berat ,0 )) AS qtypdqc4,
    SUM( IF( kode_dept = 'Susut' , qty_berat ,0 )) AS qtysus4,
    SUM( IF( kode_dept = 'Lainnya' , qty_berat ,0 )) AS qtylain4
    FROM detail_pengeluaran_gb 
    INNER JOIN pengeluaran_gb ON detail_pengeluaran_gb.nobukti_pengeluaran = pengeluaran_gb.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun' 
    GROUP BY detail_pengeluaran_gb.kode_barang) gk ON (master_barang_pembelian.kode_barang = gk.kode_barang)

    WHERE kode_dept = 'GDB'  AND master_barang_pembelian.kode_kategori != 'K002' 
    ORDER BY master_barang_pembelian.kode_barang ASC
    ";
    return $this->db->query($query);
  }

  function getdetailsaldo($bulan, $tahun)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    $query = "SELECT 
    master_barang_pembelian.kode_barang,
    master_barang_pembelian.nama_barang,
    master_barang_pembelian.satuan,
    sa.qtyunitsa,
    sa.qtyberatsa,
    gm.qtypemb1,
    gm.qtylainnya1,
    gm.qtyreturpengganti1,
    gm.qtyreturpengganti2,
    gm.qtypemb2,
    gm.qtylainnya2,
    gk.qtyprod3,
    gk.qtyseas3,
    gk.qtypdqc3,
    gk.qtysus3,
    gk.qtylain3,
    gk.qtycabang3,
    gk.qtyprod4,
    gk.qtyseas4,
    gk.qtypdqc4,
    gk.qtysus4,
    gk.qtylain4,
    gk.qtycabang4

    FROM master_barang_pembelian

    LEFT JOIN (SELECT saldoawal_gb_detail.kode_barang,SUM( qty_unit ) AS qtyunitsa,SUM( qty_berat ) AS qtyberatsa FROM saldoawal_gb_detail 
    INNER JOIN saldoawal_gb ON saldoawal_gb.kode_saldoawal_gb=saldoawal_gb_detail.kode_saldoawal_gb
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY saldoawal_gb_detail.kode_barang ) sa ON (master_barang_pembelian.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT 
    detail_pemasukan_gb.kode_barang,
    SUM( IF( departemen = 'Pembelian' , qty_unit ,0 )) AS qtypemb1,
    SUM( IF( departemen = 'Lainnya' , qty_unit ,0 )) AS qtylainnya1,
    SUM( IF( departemen = 'Retur Pengganti' , qty_unit ,0 )) AS qtyreturpengganti1,

    SUM( IF( departemen = 'Pembelian' , qty_berat ,0 )) AS qtypemb2,
    SUM( IF( departemen = 'Lainnya' , qty_berat ,0 )) AS qtylainnya2,
    SUM( IF( departemen = 'Retur Pengganti' , qty_berat ,0 )) AS qtyreturpengganti2,
    SUM( (IF( departemen = 'Pembelian' , qty_berat ,0 )) + (IF( departemen = 'Lainnya' , qty_berat ,0 ))) AS pemasukanqtyberat
    FROM 
    detail_pemasukan_gb 
    INNER JOIN pemasukan_gb ON detail_pemasukan_gb.nobukti_pemasukan = pemasukan_gb.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY detail_pemasukan_gb.kode_barang) gm ON (master_barang_pembelian.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT 
    detail_pengeluaran_gb.kode_barang,
    SUM( IF( kode_dept = 'Produksi' , qty_unit ,0 )) AS qtyprod3,
    SUM( IF( kode_dept = 'Seasoning' , qty_unit ,0 )) AS qtyseas3,
    SUM( IF( kode_dept = 'PDQC' , qty_unit ,0 )) AS qtypdqc3,
    SUM( IF( kode_dept = 'Susut' , qty_unit ,0 )) AS qtysus3,
    SUM( IF( kode_dept = 'Lainnya' , qty_unit ,0 )) AS qtylain3,
    SUM( IF( kode_dept = 'Cabang' , qty_unit ,0 )) AS qtycabang3,

    SUM( IF( kode_dept = 'Produksi' , qty_berat ,0 )) AS qtyprod4,
    SUM( IF( kode_dept = 'Seasoning' , qty_berat ,0 )) AS qtyseas4,
    SUM( IF( kode_dept = 'PDQC' , qty_berat ,0 )) AS qtypdqc4,
    SUM( IF( kode_dept = 'Susut' , qty_berat ,0 )) AS qtysus4,
    SUM( IF( kode_dept = 'Lainnya' , qty_berat ,0 )) AS qtylain4,
    SUM( IF( kode_dept = 'Cabang' , qty_berat ,0 )) AS qtycabang4
    FROM detail_pengeluaran_gb 
    INNER JOIN pengeluaran_gb ON detail_pengeluaran_gb.nobukti_pengeluaran = pengeluaran_gb.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun' 
    GROUP BY detail_pengeluaran_gb.kode_barang) gk ON (master_barang_pembelian.kode_barang = gk.kode_barang)

    WHERE kode_dept = 'GDB' AND master_barang_pembelian.kode_kategori != 'K002' 
    ORDER BY master_barang_pembelian.kode_barang ASC
    ";
    return $this->db->query($query);
  }

  function getdetailsaldoretur($bulan, $tahun)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    $query = "SELECT 
    master_barang_pembelian.kode_barang,
    master_barang_pembelian.nama_barang,
    master_barang_pembelian.satuan,
    sa.qtyberatsa,
    retur.retur_in,
    retur.retur_out,
    retur.sisa_retur

    FROM master_barang_pembelian

    LEFT JOIN (SELECT saldoawal_gb_detail_retur.kode_barang,SUM( qty_berat ) AS qtyberatsa FROM saldoawal_gb_detail_retur 
    INNER JOIN saldoawal_gb_retur ON saldoawal_gb_retur.kode_saldoawal_gb=saldoawal_gb_detail_retur.kode_saldoawal_gb
    WHERE bulan = '$bulan' AND tahun = '$tahun' 
    GROUP BY saldoawal_gb_detail_retur.kode_barang ) sa 
    ON (master_barang_pembelian.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT 
    detail_retur_gb.kode_barang,
    SUM( IF( jenis_retur = 'Retur IN' , qty ,0 )) AS retur_in,
    SUM( IF( jenis_retur = 'Retur OUT' , qty ,0 )) AS retur_out,
    SUM( IF( jenis_retur = 'Retur IN' , qty ,0 ) - IF( jenis_retur = 'Retur OUT' , qty ,0 )) AS sisa_retur
    FROM 
    detail_retur_gb 
    INNER JOIN retur_gb ON detail_retur_gb.nobukti_retur = retur_gb.nobukti_retur 
    INNER JOIN supplier ON supplier.kode_supplier = retur_gb.supplier 
    WHERE MONTH(tgl_retur) = '$bulan' AND YEAR(tgl_retur) = '$tahun' 
    GROUP BY detail_retur_gb.kode_barang) retur ON (master_barang_pembelian.kode_barang = retur.kode_barang)

    WHERE kode_dept = 'GDB' AND master_barang_pembelian.kode_kategori != 'K002' 
    ORDER BY master_barang_pembelian.kode_barang ASC
    ";
    return $this->db->query($query);
  }

  function insert_opname()
  {

    $kode_opname_gb   = $this->input->post('kode_opname_gb');
    $tanggal          = $this->input->post('tanggal');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $jumproduk        = $this->input->post('jumlahproduk');

    $data = array(
      'kode_opname_gb'    => $kode_opname_gb,
      'tanggal'           => $tanggal,
      'bulan'             => $bulan,
      'tahun'             => $tahun,
    );

    $cek            = $this->db->get_where('opname_gb', array('kode_opname_gb' => $kode_opname_gb))->num_rows();
    $cekbulan       = $this->db->get_where('opname_gb', array('bulan' => $bulan, 'tahun' => $tahun))->num_rows();
    if (empty($cek) && empty($cekbulan)) {

      $simpansaldo   = $this->db->insert('opname_gb', $data);
      if ($simpansaldo) {
        for ($i = 1; $i <= $jumproduk; $i++) {
          $kode_barang     = $this->input->post('kode_barang' . $i);
          $qty_berat       = $this->input->post('qty_berat' . $i);
          $qty_unit        = $this->input->post('qty_unit' . $i);

          $detail_saldo   = array(
            'kode_opname_gb'    => $kode_opname_gb,
            'kode_barang'       => $kode_barang,
            'qty_berat'         => $qty_berat,
            'qty_unit'          => $qty_unit
          );
          $this->db->insert('opname_gb_detail', $detail_saldo);
        }
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
          </div>'
        );
        redirect('gudangbahan/opname');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Sudah Ada !
        </div>'
      );
      redirect('gudangbahan/inputopname');
    }
  }


  function insert_saldoawal()
  {

    $kode_saldoawal_gb = $this->input->post('kode_saldoawal');
    $tanggal          = $this->input->post('tanggal');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $jumproduk        = $this->input->post('jumproduk');

    $data = array(
      'kode_saldoawal_gb' => $kode_saldoawal_gb,
      'tanggal'           => $tanggal,
      'bulan'             => $bulan,
      'tahun'             => $tahun,
    );

    $cek            = $this->db->get_where('saldoawal_gb', array('kode_saldoawal_gb' => $kode_saldoawal_gb))->num_rows();
    $cekbulan       = $this->db->get_where('saldoawal_gb', array('bulan' => $bulan, 'tahun' => $tahun))->num_rows();
    if (empty($cek) && empty($cekbulan)) {

      $simpansaldo   = $this->db->insert('saldoawal_gb', $data);
      if ($simpansaldo) {
        for ($i = 1; $i <= $jumproduk; $i++) {
          $kode_barang     = $this->input->post('kode_barang' . $i);
          $qty_berat       = $this->input->post('qty_berat' . $i);
          $qty_unit        = $this->input->post('qty_unit' . $i);

          $detail_saldo   = array(
            'kode_saldoawal_gb' => $kode_saldoawal_gb,
            'kode_barang'       => $kode_barang,
            'qty_berat'         => $qty_berat,
            'qty_unit'          => $qty_unit
          );
          $this->db->insert('saldoawal_gb_detail', $detail_saldo);
        }
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
          </div>'
        );
        redirect('gudangbahan/saldoawal');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Sudah Ada !
        </div>'
      );
      redirect('gudangbahan/inputsaldoawal');
    }
  }

  function insert_saldoawal_retur()
  {

    $kode_saldoawal_gb = $this->input->post('kode_saldoawal');
    $tanggal          = $this->input->post('tanggal');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $jumproduk        = $this->input->post('jumproduk');

    $data = array(
      'kode_saldoawal_gb' => $kode_saldoawal_gb,
      'tanggal'           => $tanggal,
      'bulan'             => $bulan,
      'tahun'             => $tahun,
    );

    $cek            = $this->db->get_where('saldoawal_gb_retur', array('kode_saldoawal_gb' => $kode_saldoawal_gb))->num_rows();
    $cekbulan       = $this->db->get_where('saldoawal_gb_retur', array('bulan' => $bulan, 'tahun' => $tahun))->num_rows();
    if (empty($cek) && empty($cekbulan)) {

      $simpansaldo   = $this->db->insert('saldoawal_gb_retur', $data);
      if ($simpansaldo) {
        for ($i = 1; $i <= $jumproduk; $i++) {
          $kode_barang      = $this->input->post('kode_barang' . $i);
          $qty              = $this->input->post('qty' . $i);

          $detail_saldo   = array(
            'kode_saldoawal_gb' => $kode_saldoawal_gb,
            'kode_barang'       => $kode_barang,
            'qty_berat'         => $qty
          );
          $this->db->insert('saldoawal_gb_detail_retur', $detail_saldo);
        }
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
          </div>'
        );
        redirect('gudangbahan/saldoawal_retur');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Sudah Ada !
        </div>'
      );
      redirect('gudangbahan/inputsaldoawal');
    }
  }

  function hapuspemasukan()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $this->db->query("DELETE FROM pemasukan_gb WHERE nobukti_pemasukan = '$nobukti' ");
    $this->db->query("DELETE FROM detail_pemasukan_gb WHERE nobukti_pemasukan = '$nobukti' ");
  }

  function hapusretur()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $this->db->query("DELETE FROM retur_gb WHERE nobukti_retur = '$nobukti' ");
    $this->db->query("DELETE FROM detail_retur_gb WHERE nobukti_retur = '$nobukti' ");
  }

  function hapussaldoawal()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $this->db->query("DELETE FROM saldoawal_gb WHERE kode_saldoawal_gb = '$nobukti' ");
    $this->db->query("DELETE FROM saldoawal_gb_detail WHERE kode_saldoawal_gb = '$nobukti' ");
  }


  function hapussaldoawal_retur()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $this->db->query("DELETE FROM saldoawal_gb_retur WHERE kode_saldoawal_gb = '$nobukti' ");
    $this->db->query("DELETE FROM saldoawal_gb_detail_retur WHERE kode_saldoawal_gb = '$nobukti' ");
  }

  function hapusopname()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $this->db->query("DELETE FROM opname_gb WHERE kode_opname_gb = '$nobukti' ");
    $this->db->query("DELETE FROM opname_gb_detail WHERE kode_opname_gb = '$nobukti' ");
  }

  function getDetailPemasukan()
  {

    $nobukti            = $this->input->post('nobukti');
    $this->db->join('master_barang_pembelian', 'detail_pemasukan_gb.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detail_pemasukan_gb', array('detail_pemasukan_gb.nobukti_pemasukan' => $nobukti));
  }

  function getDetailRetur()
  {

    $nobukti            = $this->input->post('nobukti');
    $this->db->join('master_barang_pembelian', 'detail_retur_gb.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detail_retur_gb', array('detail_retur_gb.nobukti_retur' => $nobukti));
  }

  function getDetailsaldoawalRetur()
  {

    $kode_saldoawal_gb            = $this->input->post('kode_saldoawal_gb');
    $this->db->join('master_barang_pembelian', 'saldoawal_gb_detail_retur.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('saldoawal_gb_detail_retur', array('saldoawal_gb_detail_retur.kode_saldoawal_gb' => $kode_saldoawal_gb));
  }

  function getDetailsaldoawal()
  {

    $kode_saldoawal_gb            = $this->input->post('kode_saldoawal_gb');
    $this->db->join('master_barang_pembelian', 'saldoawal_gb_detail.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('saldoawal_gb_detail', array('saldoawal_gb_detail.kode_saldoawal_gb' => $kode_saldoawal_gb));
  }

  function geteditpemasukan()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));

    // $this->db->join('detail_pemasukan_gb','pemasukan_gb.nobukti_pemasukan = detail_pemasukan_gb.nobukti_pemasukan');
    return $this->db->get_where('pemasukan_gb', array('pemasukan_gb.nobukti_pemasukan' => $nobukti));
  }


  function geteditpengeluaran()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));

    // $this->db->join('detail_pemasukan_gb','pemasukan_gb.nobukti_pemasukan = detail_pemasukan_gb.nobukti_pemasukan');
    return $this->db->get_where('pengeluaran_gb', array('pengeluaran_gb.nobukti_pengeluaran' => $nobukti));
  }


  function getDetailopnamestok()
  {

    $kode_opname_gb            = $this->input->post('kode_opname_gb');
    $this->db->join('master_barang_pembelian', 'opname_gb_detail.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('opname_gb_detail', array('opname_gb_detail.kode_opname_gb' => $kode_opname_gb));
  }

  function getDept()
  {

    return $this->db->get_where('departemen');
  }

  function getSaldoawal()
  {

    $kode_saldoawal_gb            = $this->input->post('kode_saldoawal_gb');
    return $this->db->get_where('saldoawal_gb', array('kode_saldoawal_gb' => $kode_saldoawal_gb));
  }

  function getSaldoawalRetur()
  {

    $kode_saldoawal_gb            = $this->input->post('kode_saldoawal_gb');
    return $this->db->get_where('saldoawal_gb_retur', array('kode_saldoawal_gb' => $kode_saldoawal_gb));
  }

  function getOpname()
  {

    $kode_opname_gb            = $this->input->post('kode_opname_gb');
    return $this->db->get_where('opname_gb', array('kode_opname_gb' => $kode_opname_gb));
  }

  function getPemasukan()
  {

    $nobukti            = $this->input->post('nobukti');
    return $this->db->get_where('pemasukan_gb', array('nobukti_pemasukan' => $nobukti));
  }

  function getRetur()
  {

    $nobukti            = $this->input->post('nobukti');
    $this->db->join('supplier', 'retur_gb.supplier = supplier.kode_supplier');
    return $this->db->get_where('retur_gb', array('nobukti_retur' => $nobukti));
  }

  function getDetailPengeluaran()
  {

    $nobukti            = $this->input->post('nobukti');
    $this->db->join('master_barang_pembelian', 'detail_pengeluaran_gb.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detail_pengeluaran_gb', array('detail_pengeluaran_gb.nobukti_pengeluaran' => $nobukti));
  }

  function getPengeluaran()
  {

    $nobukti            = $this->input->post('nobukti');
    return $this->db->get_where('pengeluaran_gb', array('nobukti_pengeluaran' => $nobukti));
  }

  public function getrecordPembelianCount($nobukti = "", $tgl_pembelian = "", $departemen = "", $ppn = "", $ln = "", $supplier = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('pembelian');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->where('pembelian.kode_dept', 'GDB');
    $this->db->where('nobukti_pembelian NOT IN (SELECT nobukti_pemasukan FROM pemasukan_gb)');
    $this->db->where('tgl_pembelian>=', '2020-04-01');
    if ($nobukti != '') {
      $this->db->like('nobukti_pembelian', $nobukti);
    }
    if ($tgl_pembelian != '') {
      $this->db->where('tgl_pembelian', $tgl_pembelian);
    }

    if ($departemen != '') {
      $this->db->where('pembelian.kode_dept', $departemen);
    }

    if ($ppn != '') {
      $this->db->where('pembelian.ppn', $ppn);
    }

    if ($supplier != '') {
      $this->db->where('pembelian.kode_supplier', $supplier);
    }
    $this->db->order_by('tgl_pembelian', 'desc');
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataPembelian($rowno, $rowperpage, $nobukti = "", $tgl_pembelian = "", $departemen = "", $ppn = "", $ln = "", $supplier = "")
  {

    $this->db->select('nobukti_pembelian,tgl_pembelian,tgl_jatuhtempo,ppn,no_fak_pajak,pembelian.kode_supplier,nama_supplier,pembelian.kode_dept,nama_dept,jenistransaksi,ref_tunai,

      (SELECT SUM( IF ( STATUS = "PMB", (qty*harga), 0 ) ) - SUM( IF ( STATUS = "PNJ",(qty*harga), 0 ) ) FROM detail_pembelian dp WHERE dp.nobukti_pembelian = pembelian.nobukti_pembelian  ) as harga,
      (SELECT COUNT(nobukti_pembelian) FROM detail_kontrabon k WHERE k.nobukti_pembelian = pembelian.nobukti_pembelian) as kontrabon,
      (SELECT SUM(jmlbayar) FROM historibayar_pembelian hb
      INNER JOIN detail_kontrabon on hb.no_kontrabon = detail_kontrabon.no_kontrabon
      WHERE nobukti_pembelian = pembelian.nobukti_pembelian
      GROUP BY nobukti_pembelian) as jmlbayar');
    $this->db->from('pembelian');
    $this->db->join('departemen', 'pembelian.kode_dept = departemen.kode_dept');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->where('pembelian.kode_dept', 'GDB');
    $this->db->where('nobukti_pembelian NOT IN (SELECT nobukti_pemasukan FROM pemasukan_gb)');
    $this->db->where('tgl_pembelian>=', '2020-04-01');
    if ($nobukti != '') {
      $this->db->like('nobukti_pembelian', $nobukti);
    }
    if ($tgl_pembelian != '') {
      $this->db->where('tgl_pembelian', $tgl_pembelian);
    }
    if ($departemen != '') {
      $this->db->where('pembelian.kode_dept', $departemen);
    }
    if ($ppn != '') {
      $this->db->where('pembelian.ppn', $ppn);
    }

    if ($supplier != '') {
      $this->db->where('pembelian.kode_supplier', $supplier);
    }
    $this->db->order_by('tgl_pembelian,nobukti_pembelian', 'DESC');

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }


  function getPembelian($nobukti)
  {

    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    return $this->db->get_where('pembelian', array('nobukti_pembelian' => $nobukti));
  }


  function getPemohon()
  {

    return $this->db->get_where('departemen', array('status_pengajuan' => 1));
  }

  function listSupplier()
  {

    return $this->db->get('supplier');
  }

  function getPembeliantemp($departemen)
  {

    $id_user = $this->session->userdata('id_user');
    $this->db->join('master_barang_pembelian', 'detailpembelian_temp.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detailpembelian_temp', array('id_admin' => $id_user, 'detailpembelian_temp.kode_dept' => $departemen));
  }

  function listKontraBonPMB($nobukti)
  {

    $this->db->select('detail_kontrabon.no_kontrabon,jmlbayar
     ,tgl_kontrabon,kategori,tglbayar');
    $this->db->from('detail_kontrabon');
    $this->db->join('kontrabon', 'detail_kontrabon.no_kontrabon = kontrabon.no_kontrabon');
    $this->db->join('historibayar_pembelian', 'historibayar_pembelian.no_kontrabon = detail_kontrabon.no_kontrabon', 'left');
    $this->db->where('nobukti_pembelian', $nobukti);
    $this->db->order_by('tgl_kontrabon', 'DESC');
    return $this->db->get();
  }

  function getDetailPnjPembelian($nobukti)
  {

    return $this->db->get_where('detail_pembelian', array('detail_pembelian.nobukti_pembelian' => $nobukti, 'status' => 'PNJ'));
  }

  function getDetailPembelian($nobukti)
  {

    $this->db->join('master_barang_pembelian', 'detail_pembelian.kode_barang = master_barang_pembelian.kode_barang');
    $this->db->join('coa', 'detail_pembelian.kode_akun = coa.kode_akun');
    return $this->db->get_where('detail_pembelian', array('detail_pembelian.nobukti_pembelian' => $nobukti, 'status' => 'PMB'));
  }


  public function getDataopname($rowno, $rowperpage, $kode_opname_gb = "", $tanggal = "")
  {

    $this->db->select('*');
    $this->db->from('opname_gb');
    $this->db->order_by('tanggal', 'DESC');

    if ($kode_opname_gb != '') {
      $this->db->like('kode_opname_gb', $kode_opname_gb);
    }

    if ($tanggal != '') {
      $this->db->where('tanggal', $tanggal);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordopnameCount($kode_opname_gb = "", $tanggal = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('opname_gb');
    $this->db->order_by('tanggal', 'DESC');

    if ($kode_opname_gb != '') {
      $this->db->like('kode_opname_gb', $kode_opname_gb);
    }

    if ($tanggal != '') {
      $this->db->where('tanggal', $tanggal);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataSaldoawal($rowno, $rowperpage, $kode_saldoawal_gb = "", $tanggal = "")
  {

    $this->db->select('*');
    $this->db->from('saldoawal_gb');
    $this->db->order_by('tanggal', 'DESC');

    if ($kode_saldoawal_gb != '') {
      $this->db->like('kode_saldoawal_gb', $kode_saldoawal_gb);
    }

    if ($tanggal != '') {
      $this->db->where('tanggal', $tanggal);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordSaldoawalnCount($kode_saldoawal_gb = "", $tanggal = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('saldoawal_gb');
    $this->db->order_by('tanggal', 'DESC');

    if ($kode_saldoawal_gb != '') {
      $this->db->like('kode_saldoawal_gb', $kode_saldoawal_gb);
    }

    if ($tanggal != '') {
      $this->db->where('tanggal', $tanggal);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataSaldoawalRetur($rowno, $rowperpage, $kode_saldoawal_gb = "", $tanggal = "")
  {

    $this->db->select('*');
    $this->db->from('saldoawal_gb_retur');
    $this->db->order_by('tanggal', 'DESC');

    if ($kode_saldoawal_gb != '') {
      $this->db->like('kode_saldoawal_gb', $kode_saldoawal_gb);
    }

    if ($tanggal != '') {
      $this->db->where('tanggal', $tanggal);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordSaldoawalnCountRetur($kode_saldoawal_gb = "", $tanggal = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('saldoawal_gb_retur');
    $this->db->order_by('tanggal', 'DESC');

    if ($kode_saldoawal_gb != '') {
      $this->db->like('kode_saldoawal_gb', $kode_saldoawal_gb);
    }

    if ($tanggal != '') {
      $this->db->where('tanggal', $tanggal);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataPemasukan($rowno, $rowperpage, $nobukti = "", $tgl_pemasukan = "")
  {

    $this->db->select('*');
    $this->db->from('pemasukan_gb');
    $this->db->order_by('tgl_pemasukan', 'DESC');

    if ($nobukti != '') {
      $this->db->like('nobukti_pemasukan', $nobukti);
    }

    if ($tgl_pemasukan != '') {
      $this->db->where('tgl_pemasukan', $tgl_pemasukan);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordPemasukanCount($nobukti = "", $tgl_pemasukan = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('pemasukan_gb');
    $this->db->order_by('tgl_pemasukan', 'DESC');

    if ($nobukti != '') {
      $this->db->like('nobukti_pemasukan', $nobukti);
    }

    if ($tgl_pemasukan != '') {
      $this->db->where('tgl_pemasukan', $tgl_pemasukan);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataretur($rowno, $rowperpage, $nobukti = "", $tgl_retur = "")
  {

    $this->db->select('*');
    $this->db->from('retur_gb');
    $this->db->join('supplier', 'supplier.kode_supplier=retur_gb.supplier');
    $this->db->order_by('tgl_retur', 'DESC');

    if ($nobukti != '') {
      $this->db->like('nobukti_retur', $nobukti);
    }

    if ($tgl_retur != '') {
      $this->db->where('tgl_retur', $tgl_retur);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordreturCount($nobukti = "", $tgl_retur = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('retur_gb');
    $this->db->join('supplier', 'supplier.kode_supplier=retur_gb.supplier');
    $this->db->order_by('tgl_retur', 'DESC');

    if ($nobukti != '') {
      $this->db->like('nobukti_retur', $nobukti);
    }

    if ($tgl_retur != '') {
      $this->db->where('tgl_retur', $tgl_retur);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataPengeluaran($rowno, $rowperpage, $nobukti = "", $tgl_pengeluaran = "", $kode_dept = "")
  {

    $this->db->select('*');
    $this->db->from('pengeluaran_gb');
    $this->db->order_by('tgl_pengeluaran,nobukti_pengeluaran', 'DESC');

    if ($nobukti != '') {
      $this->db->like('nobukti_pengeluaran', $nobukti);
    }

    if ($tgl_pengeluaran != '') {
      $this->db->where('tgl_pengeluaran', $tgl_pengeluaran);
    }


    if ($kode_dept != '') {
      $this->db->where('kode_dept', $kode_dept);
    }


    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordPengeluaranCount($nobukti = "", $tgl_pengeluaran = "", $kode_dept = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('pengeluaran_gb');
    $this->db->order_by('tgl_pengeluaran', 'desc');

    if ($nobukti != '') {
      $this->db->like('nobukti_pengeluaran', $nobukti);
    }

    if ($tgl_pengeluaran != '') {
      $this->db->where('tgl_pengeluaran', $tgl_pengeluaran);
    }

    if ($kode_dept != '') {
      $this->db->where('kode_dept', $kode_dept);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function insertpemasukan_temp()
  {

    $kode_barang  = $this->input->post('kodebarang');
    $kodeedit     = $this->input->post('kode_edit');
    $unit         = str_replace(",", "", $this->input->post('qty_unit'));
    $berat        = str_replace(",", "", $this->input->post('qty_berat'));
    $lebih        = str_replace(",", "", $this->input->post('qty_lebih'));
    $keterangan   = $this->input->post('keterangan');
    $id_admin     = $this->session->userdata('id_user');

    $data = array(

      'kode_barang'  => $kode_barang,
      'qty_unit'     => $unit,
      'qty_berat'    => $berat,
      'qty_lebih'    => $lebih,
      'keterangan'   => $keterangan,
      'id_admin'     => $id_admin

    );
    if ($kodeedit == "") {
      $this->db->insert('detailpemasukan_temp_gb', $data);
    } else {
      $this->db->where('kode_barang', $kode_barang);
      $this->db->update('detailpemasukan_temp_gb', $data);
    }
  }

  function insert_detail_pengeluaran()
  {

    $kode_barang          = $this->input->post('kodebarang');
    $nobukti_pengeluaran  = $this->input->post('nobukti');
    $kodeedit             = $this->input->post('kode_edit');
    $unit                 = str_replace(",", "", $this->input->post('qty_unit'));
    $berat                = str_replace(",", "", $this->input->post('qty_berat'));
    $lebih                = str_replace(",", "", $this->input->post('qty_lebih'));
    $keterangan           = $this->input->post('keterangan');

    $data = array(

      'nobukti_pengeluaran'   => $nobukti_pengeluaran,
      'kode_barang'           => $kode_barang,
      'qty_unit'              => $unit,
      'qty_berat'             => $berat,
      'qty_lebih'             => $lebih,
      'keterangan'            => $keterangan

    );
    if ($kodeedit == "") {
      $this->db->insert('detail_pengeluaran_gb', $data);
    } else {
      $this->db->where('nobukti_pengeluaran', $nobukti_pengeluaran);
      $this->db->where('kode_barang', $kode_barang);
      $this->db->update('detail_pengeluaran_gb', $data);
    }
  }

  function insertretur_temp()
  {

    $kode_barang  = $this->input->post('kodebarang');
    $kodeedit     = $this->input->post('kode_edit');
    $qty          = str_replace(",", "", $this->input->post('qty'));
    $keterangan   = $this->input->post('keterangan');
    $id_admin     = $this->session->userdata('id_user');

    $data = array(

      'kode_barang'  => $kode_barang,
      'qty'          => $qty,
      'keterangan'   => $keterangan,
      'id_admin'     => $id_admin

    );
    if ($kodeedit == "") {
      $this->db->insert('detailretur_temp_gb', $data);
    } else {
      $this->db->where('kode_barang', $kode_barang);
      $this->db->update('detailretur_temp_gb', $data);
    }
  }

  function editdetailsaldoawal()
  {

    $kodesaldo    = $this->input->post('kodesaldoawal');
    $kode_barang  = $this->input->post('kodebarang');
    $unit         = str_replace(",", "", $this->input->post('qty_unit'));
    $berat        = str_replace(",", "", $this->input->post('qty_berat'));

    $data = array(

      'kode_barang'     => $kode_barang,
      'qty_unit'        => $unit,
      'qty_berat'       => $berat

    );

    $this->db->where('kode_saldoawal_gb', $kodesaldo);
    $this->db->where('kode_barang', $kode_barang);
    $this->db->update('saldoawal_gb_detail', $data);
  }

  function editdetailsaldoawal_retur()
  {

    $kodesaldo    = $this->input->post('kodesaldoawal');
    $kode_barang  = $this->input->post('kodebarang');
    $qty          = str_replace(",", "", $this->input->post('qty'));

    $data = array(

      'kode_barang'     => $kode_barang,
      'qty_berat'       => $qty

    );

    $this->db->where('kode_saldoawal_gb', $kodesaldo);
    $this->db->where('kode_barang', $kode_barang);
    $this->db->update('saldoawal_gb_detail_retur', $data);
  }

  function inputeditpemasukan()
  {

    $kode_barang  = $this->input->post('kodebarang');
    $kodeedit     = $this->input->post('kode_edit');
    $nobukti      = $this->input->post('nobukti');
    $tgl_pemasukan = $this->input->post('tgl_pemasukan');
    $departemen   = $this->input->post('departemen');
    $unit         = str_replace(",", "", $this->input->post('qty_unit'));
    $berat        = str_replace(",", "", $this->input->post('qty_berat'));
    $lebih        = str_replace(",", "", $this->input->post('qty_lebih'));
    $keterangan   = $this->input->post('keterangan');
    $id_admin     = $this->session->userdata('id_user');

    $data2 = array(

      'nobukti_pemasukan'   => $nobukti,
      'kode_barang'         => $kode_barang,
      'qty_unit'            => $unit,
      'qty_berat'           => $berat,
      'qty_lebih'           => $lebih,
      'keterangan'          => $keterangan

    );
    if ($kodeedit == "") {
      $this->db->insert('detail_pemasukan_gb', $data2);
    } else {
      $this->db->where('kode_barang', $kode_barang);
      $this->db->where('nobukti_pemasukan', $nobukti);
      $this->db->update('detail_pemasukan_gb', $data2);
    }
  }

  function inputeditpengeluaran()
  {

    $kode_barang      = $this->input->post('kodebarang');
    $kodeedit         = $this->input->post('kode_edit');
    $nobukti          = $this->input->post('nobukti');
    $tgl_pengeluaran  = $this->input->post('tgl_pengeluaran');
    $departemen       = $this->input->post('departemen');
    $unit             = str_replace(",", "", $this->input->post('qty_unit'));
    $berat            = str_replace(",", "", $this->input->post('qty_berat'));
    $lebih            = str_replace(",", "", $this->input->post('qty_lebih'));
    $keterangan       = $this->input->post('keterangan');
    $id_admin         = $this->session->userdata('id_user');

    $data2 = array(

      'nobukti_pengeluaran'   => $nobukti,
      'kode_barang'           => $kode_barang,
      'qty_unit'              => $unit,
      'qty_berat'             => $berat,
      'qty_lebih'             => $lebih,
      'keterangan'            => $keterangan

    );
    if ($kodeedit == "") {
      $this->db->insert('detail_pengeluaran_gb', $data2);
    } else {
      $this->db->where('kode_barang', $kode_barang);
      $this->db->where('nobukti_pengeluaran', $nobukti);
      $this->db->update('detail_pengeluaran_gb', $data2);
    }
  }

  function update_pemasukan()
  {

    $nobukti      = $this->input->post('nobukti');
    $tgl_pemasukan = $this->input->post('tgl_pemasukan');
    $departemen   = $this->input->post('departemen');

    $data = array(

      'tgl_pemasukan'     => $tgl_pemasukan,
      'departemen'        => $departemen

    );
    $this->db->where('nobukti_pemasukan', $nobukti);
    $this->db->update('pemasukan_gb', $data);
    redirect('gudangbahan/pemasukan', 'refresh');
  }

  function update_pengeluaran()
  {

    $nobukti          = $this->input->post('nobukti');
    $tgl_pengeluaran  = $this->input->post('tgl_pengeluaran');
    $departemen       = $this->input->post('departemen');
    if ($departemen == 'Produksi') {
      $unit             = $this->input->post('unit');
    } else if ($departemen == 'Cabang') {
      $unit             = $this->input->post('cabang');
    } else {
      $unit           = "";
    }

    $data = array(

      'tgl_pengeluaran'     => $tgl_pengeluaran,
      'unit'                => $unit,
      'kode_dept'           => $departemen

    );
    $this->db->where('nobukti_pengeluaran', $nobukti);
    $this->db->update('pengeluaran_gb', $data);
    redirect('gudangbahan/pengeluaran', 'refresh');
  }

  function insert_pembelian()
  {

    $nobukti             = $this->input->post('nobukti_pembelian');
    $kode_barang         = $this->input->post('kode_barang23');
    $keterangan          = $this->input->post('keterangan');
    $qty_unit            = $this->input->post('qty_unit');
    $qty_berat           = $this->input->post('qty_berat');
    $qty_lebih           = $this->input->post('qty_lebih');
    $tgl_pemasukan       = $this->input->post('tgl_pemasukan');

    $data                = $this->db->query("SELECT * FROM pembelian WHERE nobukti_pembelian = '$nobukti' ");
    foreach ($data->result() as $d) {

      $data = array(

        'nobukti_pemasukan' => $nobukti,
        'tgl_pemasukan'     => $tgl_pemasukan,
        'tgl_pembelian'     => $d->tgl_pembelian,
        'gdb'               => 1

      );
      $this->db->insert('pemasukan_gb', $data);
    }

    $data3               = array();
    $index               = 0;
    foreach ($kode_barang as $databarang) {
      array_push($data3, array(
        'nobukti_pemasukan'   => $nobukti,
        'kode_barang'         => $databarang,
        'keterangan'          => $keterangan[$index],
        'qty_unit'            => $qty_unit[$index],
        'qty_berat'           => $qty_berat[$index],
        'qty_lebih'           => $qty_lebih[$index]
      ));
      $index++;
    }
    $this->db->insert_batch('detail_pemasukan_gb', $data3);
    redirect('gudangbahan/pembelian');
  }

  function insert_pemasukan()
  {

    $nobukti              = $this->input->post('nobukti');
    $tgl_pemasukan        = $this->input->post('tgl_pemasukan');
    $departemen           = $this->input->post('departemen');
    $id_admin             = $this->session->userdata('id_user');

    $data = array(

      'nobukti_pemasukan'      => $nobukti,
      'tgl_pemasukan'          => $tgl_pemasukan,
      'departemen'             => $departemen
    );

    $this->db->insert('pemasukan_gb', $data);

    $data = $this->db->query("SELECT * FROM detailpemasukan_temp_gb WHERE id_admin = '$id_admin' ");

    foreach ($data->result() as $d) {

      $data = array(

        'nobukti_pemasukan' => $nobukti,
        'kode_barang'       => $d->kode_barang,
        'qty_unit'          => $d->qty_unit,
        'qty_berat'         => $d->qty_berat,
        'qty_lebih'         => $d->qty_lebih,
        'keterangan'        => $d->keterangan

      );
      $this->db->insert('detail_pemasukan_gb', $data);
    }

    $this->db->query("DELETE FROM detailpemasukan_temp_gb WHERE id_admin = '$id_admin' ");
    redirect('gudangbahan/pemasukan');
  }


  function insert_returproduksi()
  {

    $nobukti              = $this->input->post('nobukti');
    $tgl_retur            = $this->input->post('tgl');
    $tgl_approve          = $this->input->post('tgl_approve');
    $supplier             = $this->input->post('supplier');

    $data = array(

      'nobukti_retur'      => $nobukti,
      'tgl_retur'          => $tgl_retur,
      'tgl_approve'        => $tgl_approve,
      'supplier'           => $supplier,
      'jenis_retur'        => "Retur IN"
    );

    $this->db->insert('retur_gb', $data);

    $data = $this->db->query("SELECT * FROM detail_pengeluaran_gp WHERE nobukti_pengeluaran = '$nobukti' ");

    foreach ($data->result() as $d) {

      $data = array(

        'nobukti_retur'     => $nobukti,
        'kode_barang'       => $d->kode_barang,
        'qty'               => $d->qty,
        'keterangan'        => $d->keterangan

      );
      $this->db->insert('detail_retur_gb', $data);
    }
  }

  function insert_retur()
  {

    $nobukti              = $this->input->post('nobukti');
    $tgl_retur            = $this->input->post('tgl_retur');
    $jenis_retur          = $this->input->post('jenis_retur');
    $supplier             = $this->input->post('supplier');
    $id_admin             = $this->session->userdata('id_user');

    $data = array(

      'nobukti_retur'      => $nobukti,
      'tgl_retur'          => $tgl_retur,
      'tgl_approve'        => $tgl_retur,
      'supplier'           => $supplier,
      'jenis_retur'        => $jenis_retur
    );

    $this->db->insert('retur_gb', $data);

    $data = $this->db->query("SELECT * FROM detailretur_temp_gb WHERE id_admin = '$id_admin' ");

    foreach ($data->result() as $d) {

      $data = array(

        'nobukti_retur'     => $nobukti,
        'kode_barang'       => $d->kode_barang,
        'qty'               => $d->qty,
        'keterangan'        => $d->keterangan

      );
      $this->db->insert('detail_retur_gb', $data);
    }

    $this->db->query("DELETE FROM detailretur_temp_gb WHERE id_admin = '$id_admin' ");
    redirect('gudangbahan/retur');
  }

  function getPemasukantemp()
  {

    $id_user = $this->session->userdata('id_user');
    $this->db->join('master_barang_pembelian', 'detailpemasukan_temp_gb.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detailpemasukan_temp_gb', array('id_admin' => $id_user));
  }

  function getReturemp()
  {

    $id_user = $this->session->userdata('id_user');
    $this->db->join('master_barang_pembelian', 'detailretur_temp_gb.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detailretur_temp_gb', array('id_admin' => $id_user));
  }

  function view_detaileditpemasukan()
  {

    $nobukti  = $this->input->post('nobukti');
    $this->db->join('master_barang_pembelian', 'detail_pemasukan_gb.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detail_pemasukan_gb', array('nobukti_pemasukan' => $nobukti));
  }

  function view_detaileditpengeluaran()
  {

    $nobukti  = $this->input->post('nobukti');
    $this->db->join('master_barang_pembelian', 'detail_pengeluaran_gb.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detail_pengeluaran_gb', array('nobukti_pengeluaran' => $nobukti));
  }

  function hapus_detailpemasukan_temp()
  {

    $kodebarang  = $this->input->post('kodebarang');
    $idadmin     = $this->input->post('idadmin');
    $ket         = $this->input->post('ket');
    $this->db->delete('detailpemasukan_temp_gb', array('kode_barang' => $kodebarang, 'id_admin' => $idadmin, 'keterangan' => $ket));
  }

  function hapus_detailretur_temp()
  {

    $kodebarang  = $this->input->post('kodebarang');
    $idadmin     = $this->input->post('idadmin');
    $ket         = $this->input->post('ket');
    $this->db->delete('detailretur_temp_gb', array('kode_barang' => $kodebarang, 'id_admin' => $idadmin, 'keterangan' => $ket));
  }

  function hapus_detaileditpemasukan()
  {

    $kodebarang   = $this->input->post('kodebarang');
    $nobukti      = $this->input->post('nobukti');
    $ket         = $this->input->post('ket');
    $this->db->delete('detail_pemasukan_gb', array('kode_barang' => $kodebarang, 'nobukti_pemasukan' => $nobukti, 'keterangan' => $ket));
  }


  function hapus_detaileditpengeluaran()
  {

    $kodebarang   = $this->input->post('kodebarang');
    $nobukti      = $this->input->post('nobukti');
    $ket          = $this->input->post('ket');
    $this->db->delete('detail_pengeluaran_gb', array('kode_barang' => $kodebarang, 'nobukti_pengeluaran' => $nobukti, 'keterangan' => $ket));
  }

  function insertpengeluaran_temp()
  {

    $kode_barang  = $this->input->post('kodebarang');
    $kodeedit     = $this->input->post('kode_edit');
    $unit         = str_replace(",", "", $this->input->post('qty_unit'));
    $berat        = str_replace(",", "", $this->input->post('qty_berat'));
    $lebih        = str_replace(",", "", $this->input->post('qty_lebih'));
    $keterangan   = $this->input->post('keterangan');
    $id_admin     = $this->session->userdata('id_user');

    $data = array(

      'kode_barang'         => $kode_barang,
      'qty_unit'            => $unit,
      'qty_berat'           => $berat,
      'qty_lebih'           => $lebih,
      'keterangan'          => $keterangan,
      'id_admin'            => $id_admin

    );

    if ($kodeedit == "") {
      $this->db->insert('detailpengeluaran_temp_gb', $data);
    } else {
      $this->db->where('kode_barang', $kode_barang);
      $this->db->update('detailpengeluaran_temp_gb', $data);
    }
  }

  function insert_pengeluaran()
  {

    $nobukti            = $this->input->post('nobukti');
    $tgl_pengeluaran    = $this->input->post('tgl_pengeluaran');
    $kode_dept          = $this->input->post('departemen');
    $id_admin           = $this->session->userdata('id_user');
    if ($kode_dept == 'Produksi') {
      $unit             = $this->input->post('unit');
    } else if ($kode_dept == 'Cabang') {
      $unit             = $this->input->post('cabang');
    } else {
      $unit           = "";
    }

    $data = array(

      'nobukti_pengeluaran'   => $nobukti,
      'tgl_pengeluaran'       => $tgl_pengeluaran,
      'unit'                  => $unit,
      'kode_dept'             => $kode_dept

    );

    $this->db->insert('pengeluaran_gb', $data);

    $data = $this->db->query("SELECT * FROM detailpengeluaran_temp_gb WHERE id_admin = '$id_admin' ")->result();

    foreach ($data as $d) {


      $data = array(

        'nobukti_pengeluaran' => $nobukti,
        'kode_barang'         => $d->kode_barang,
        'qty_unit'            => $d->qty_unit,
        'qty_berat'           => $d->qty_berat,
        'qty_lebih'           => $d->qty_lebih,
        'keterangan'          => $d->keterangan

      );
      $this->db->insert('detail_pengeluaran_gb', $data);
    }

    $this->db->query("DELETE FROM detailpengeluaran_temp_gb WHERE id_admin = '$id_admin' ");
    redirect('gudangbahan/pengeluaran');
  }

  function getPengeluarantemp()
  {

    $id_user = $this->session->userdata('id_user');
    $this->db->join('master_barang_pembelian', 'detailpengeluaran_temp_gb.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detailpengeluaran_temp_gb', array('id_admin' => $id_user));
  }

  function getPengeluarandetail()
  {

    $nobukti  = $this->input->post('nobukti');
    $this->db->join('master_barang_pembelian', 'detail_pengeluaran_gb.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detail_pengeluaran_gb', array('nobukti_pengeluaran' => $nobukti));
  }

  function hapus_detailpengeluaran_temp()
  {

    $kodebarang  = $this->input->post('kodebarang');
    $idadmin     = $this->input->post('idadmin');
    $ket         = $this->input->post('ket');
    $this->db->delete('detailpengeluaran_temp_gb', array('kode_barang' => $kodebarang, 'id_admin' => $idadmin, 'keterangan' => $ket));
  }

  function hapus_detailpengeluaran_detail()
  {

    $nobukti  = $this->input->post('nobukti');
    $kodebarang  = $this->input->post('kodebarang');
    $ket         = $this->input->post('ket');
    $this->db->delete('detail_pengeluaran_gb', array('kode_barang' => $kodebarang, 'nobukti_pengeluaran' => $nobukti, 'keterangan' => $ket));
  }

  function jsonPilihAkun()
  {

    $this->datatables->select('set_coa_cabang.kode_akun,nama_akun');
    $this->datatables->from('set_coa_cabang');
    $this->datatables->join('coa', 'set_coa_cabang.kode_akun = coa.kode_akun');
    $this->datatables->where('kategori', 'pembelian');
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2" class="btn btn-danger btn-sm waves-effect pilih">Pilih</a>', 'kode_akun,nama_akun');
    return $this->datatables->generate();
  }

  function jsonPilihBarang()
  {

    $this->datatables->select('kode_barang,nama_barang,satuan,master_barang_pembelian.kode_dept,nama_dept,jenis_barang');
    $this->datatables->from('master_barang_pembelian');
    $this->datatables->join('departemen', 'master_barang_pembelian.kode_dept = departemen.kode_dept');
    $this->datatables->where('master_barang_pembelian.kode_dept', 'GDB');
    $this->db->order_by('master_barang_pembelian.kode_barang,master_barang_pembelian.nama_barang', 'ASC');
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2"  data-jenis="$3" class="btn btn-danger btn-sm waves-effect pilih">Pilih</a>', 'kode_barang,nama_barang,jenis_barang');
    return $this->datatables->generate();
  }
}
