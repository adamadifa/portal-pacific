<?php

class Model_gudanglogistik extends CI_Model
{

  function hapuspengeluaran()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $this->db->query("DELETE FROM pengeluaran WHERE nobukti_pengeluaran = '$nobukti' ");
    $this->db->query("DELETE FROM detail_pengeluaran WHERE nobukti_pengeluaran = '$nobukti' ");
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

  function geteditpengeluaran()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $query = "
    SELECT * FROM pengeluaran WHERE nobukti_pengeluaran = '$nobukti'
    ";
    return $this->db->query($query);
  }

  function listproduk()
  {

    return $this->db->get('master_barang_pembelian');
  }

  function ceksaldo($bulan, $tahun, $kategori)
  {

    if ($bulan == 1) {
      $bulan    = 12;
      $tahun    = $tahun - 1;
      $kategori = $kategori;
    } else {
      $bulan    = $bulan - 1;
      $tahun    = $tahun;
      $kategori = $kategori;
    }

    return $this->db->get_where('saldoawal_gl', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_kategori' => $kategori));
  }

  function ceksaldoall()
  {

    return $this->db->get('saldoawal_gl');
  }

  function ceksaldoSkrg($bulan, $tahun, $kategori)
  {

    return $this->db->get_where('saldoawal_gl', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_kategori' => $kategori));
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

    return $this->db->get_where('opname_gl', array('bulan' => $bulan, 'tahun' => $tahun,));
  }

  function cekopnameall()
  {

    return $this->db->get('opname_gl');
  }
  function cekopnameSkrg($bulan, $tahun)
  {

    return $this->db->get_where('opname_gl', array('bulan' => $bulan, 'tahun' => $tahun));
  }

  function getDetailopname($bulan, $tahun, $kode_opname_gl, $kode_kategori, $kode_barang)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    if ($kode_kategori != "K001" or  $kode_kategori != "K002" and $kode_opname_gl != "") {

      $kode_opname_gl = "WHERE opname_gl_detail.kode_opname_gl = '" . $kode_opname_gl . "' ";
    }

    $query = "SELECT 
    master_barang_pembelian.kode_barang,
    master_barang_pembelian.nama_barang,
    kategori_barang_pembelian.kode_kategori,
    kategori_barang_pembelian.kategori,
    SUM(opname_gl_detail.qty) AS qtyopname,
    opname_gl_detail.kode_opname_gl,
    gm.qtypemasukan,
    sa.qtysaldoawal,
    gk.qtypengeluaran,
    gm.totalhargapemasukan

    FROM opname_gl
    INNER JOIN opname_gl_detail ON 
    opname_gl_detail.kode_opname_gl = opname_gl.kode_opname_gl
    INNER JOIN master_barang_pembelian ON 
    master_barang_pembelian.kode_barang = opname_gl_detail.kode_barang
    INNER JOIN kategori_barang_pembelian ON 
    master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori

    LEFT JOIN (SELECT saldoawal_gl_detail.kode_barang,SUM( qty ) AS qtysaldoawal FROM saldoawal_gl_detail 
    INNER JOIN saldoawal_gl ON saldoawal_gl.kode_saldoawal_gl=saldoawal_gl_detail.kode_saldoawal_gl
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY saldoawal_gl_detail.kode_barang ) sa ON (master_barang_pembelian.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT detail_pemasukan.kode_barang,SUM( qty ) AS qtypemasukan,SUM(detail_pemasukan.harga * qty) AS totalhargapemasukan FROM 
    detail_pemasukan 
    INNER JOIN pemasukan ON detail_pemasukan.nobukti_pemasukan = pemasukan.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY detail_pemasukan.kode_barang) gm ON (master_barang_pembelian.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT detail_pengeluaran.kode_barang,SUM( qty ) AS qtypengeluaran FROM detail_pengeluaran 
    INNER JOIN pengeluaran ON detail_pengeluaran.nobukti_pengeluaran = pengeluaran.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun' 
    GROUP BY detail_pengeluaran.kode_barang) gk ON (master_barang_pembelian.kode_barang = gk.kode_barang)
    "
      . $kode_opname_gl
      . "
    GROUP BY 
    master_barang_pembelian.kode_barang,
    master_barang_pembelian.nama_barang,
    kategori_barang_pembelian.kode_kategori,
    kategori_barang_pembelian.kategori,
    opname_gl_detail.kode_opname_gl,
    sa.qtysaldoawal,
    gm.qtypemasukan,
    gk.qtypengeluaran,
    gm.totalhargapemasukan
    ";
    return $this->db->query($query);
  }

  function getdetailsaldo($bulan, $tahun, $kode_saldoawal_gl, $kode_kategori)
  {

    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    if ($kode_kategori != "K001" or  $kode_kategori != "K002" and $kode_saldoawal_gl != "") {

      $kode_saldoawal_gl = "WHERE saldoawal_gl_detail.kode_saldoawal_gl = '" . $kode_saldoawal_gl . "' ";
    }
    $query = "SELECT 
    master_barang_pembelian.kode_barang,
    master_barang_pembelian.nama_barang,
    kategori_barang_pembelian.kode_kategori,
    kategori_barang_pembelian.kategori,
    SUM(saldoawal_gl_detail.qty) AS qtysaldoawal,
    saldoawal_gl_detail.harga,
    saldoawal_gl_detail.kode_saldoawal_gl,
    gm.qtypemasukan,
    gk.qtypengeluaran,
    gm.totalhargapemasukan

    FROM saldoawal_gl
    INNER JOIN saldoawal_gl_detail ON 
    saldoawal_gl_detail.kode_saldoawal_gl = saldoawal_gl.kode_saldoawal_gl
    INNER JOIN master_barang_pembelian ON 
    master_barang_pembelian.kode_barang = saldoawal_gl_detail.kode_barang
    INNER JOIN kategori_barang_pembelian ON 
    master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori

    LEFT JOIN (SELECT detail_pemasukan.kode_barang,SUM( qty ) AS qtypemasukan,SUM(detail_pemasukan.harga * qty) AS totalhargapemasukan FROM 
    detail_pemasukan 
    INNER JOIN pemasukan ON detail_pemasukan.nobukti_pemasukan = pemasukan.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY detail_pemasukan.kode_barang) gm ON (master_barang_pembelian.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT detail_pengeluaran.kode_barang,SUM( qty ) AS qtypengeluaran FROM detail_pengeluaran 
    INNER JOIN pengeluaran ON detail_pengeluaran.nobukti_pengeluaran = pengeluaran.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun' 
    GROUP BY detail_pengeluaran.kode_barang) gk ON (master_barang_pembelian.kode_barang = gk.kode_barang)
    "
      . $kode_saldoawal_gl
      . "
    GROUP BY 
    master_barang_pembelian.kode_barang,
    master_barang_pembelian.nama_barang,
    kategori_barang_pembelian.kode_kategori,
    kategori_barang_pembelian.kategori,
    saldoawal_gl_detail.kode_saldoawal_gl,
    saldoawal_gl_detail.harga,
    gm.qtypemasukan,
    gk.qtypengeluaran,
    gm.totalhargapemasukan
    ";
    return $this->db->query($query);
  }


  function gethasildetailopname($bulan, $tahun, $kode_kategori, $kode_barang)
  {

    if ($bulan == 1) {
      $bulan            = 12;
      $tahun            = $tahun - 1;
      $kode_kategori    = $kode_kategori;
      $kode_barang      = $kode_barang;
    } else {
      $bulan            = $bulan - 1;
      $tahun            = $tahun;
      $kode_kategori    = $kode_kategori;
      $kode_barang      = $kode_barang;
    }

    $query = "SELECT 
    sa.qtyopname,
    gm.qtypemasukan,
    gk.qtypengeluaran,
    gm.totalhargapemasukan

    FROM master_barang_pembelian
    INNER JOIN kategori_barang_pembelian ON 
    master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori

    LEFT JOIN (SELECT opname_gl_detail.kode_barang,SUM( qty ) AS qtyopname FROM opname_gl_detail 
    INNER JOIN opname_gl ON opname_gl.kode_opname_gl=opname_gl_detail.kode_opname_gl
    WHERE bulan = '$bulan' AND tahun = '$tahun' GROUP BY opname_gl_detail.kode_barang ) sa ON (master_barang_pembelian.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT detail_pemasukan.kode_barang,SUM( qty ) AS qtypemasukan,SUM(detail_pemasukan.harga * qty) AS totalhargapemasukan FROM 
    detail_pemasukan 
    INNER JOIN pemasukan ON detail_pemasukan.nobukti_pemasukan = pemasukan.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY detail_pemasukan.kode_barang) gm ON (master_barang_pembelian.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT detail_pengeluaran.kode_barang,SUM( qty ) AS qtypengeluaran FROM detail_pengeluaran 
    INNER JOIN pengeluaran ON detail_pengeluaran.nobukti_pengeluaran = pengeluaran.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun' 
    GROUP BY detail_pengeluaran.kode_barang) gk ON (master_barang_pembelian.kode_barang = gk.kode_barang)

    WHERE master_barang_pembelian.kode_dept = 'GDL'  AND master_barang_pembelian.kode_kategori = '$kode_kategori' AND master_barang_pembelian.kode_barang = '$kode_barang'
    ";
    return $this->db->query($query);
  }

  function gethasildetailsaldo($bulan, $tahun, $kode_kategori, $kode_barang)
  {

    if ($bulan == 1) {
      $bulan            = 12;
      $tahun            = $tahun - 1;
      $kode_kategori    = $kode_kategori;
      $kode_barang      = $kode_barang;
    } else {
      $bulan            = $bulan - 1;
      $tahun            = $tahun;
      $kode_kategori    = $kode_kategori;
      $kode_barang      = $kode_barang;
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

    LEFT JOIN (SELECT detail_pemasukan.kode_barang,SUM( qty ) AS qtypemasukan,SUM( harga ) AS hargapemasukan,SUM(detail_pemasukan.harga * qty) AS totalpemasukan FROM 
    detail_pemasukan 
    INNER JOIN pemasukan ON detail_pemasukan.nobukti_pemasukan = pemasukan.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY detail_pemasukan.kode_barang) gm ON (master_barang_pembelian.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT detail_pengeluaran.kode_barang,SUM( qty ) AS qtypengeluaran FROM detail_pengeluaran 
    INNER JOIN pengeluaran ON detail_pengeluaran.nobukti_pengeluaran = pengeluaran.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun' 
    GROUP BY detail_pengeluaran.kode_barang) gk ON (master_barang_pembelian.kode_barang = gk.kode_barang)
    

    WHERE master_barang_pembelian.kode_dept = 'GDL' AND master_barang_pembelian.kode_kategori = '$kode_kategori' AND master_barang_pembelian.kode_barang = '$kode_barang'
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


  function getinputopnamedetail()
  {

    $kode     = str_replace(".", "/", $this->uri->segment(3));
    $query    = "SELECT * FROM opname_gl
    INNER JOIN kategori_barang_pembelian ON kategori_barang_pembelian.kode_kategori=opname_gl.kode_kategori
    WHERE kode_opname_gl = '$kode' 
    ";
    return $this->db->query($query);
  }

  function getinputsaldoawaldetail()
  {

    $kode     = str_replace(".", "/", $this->uri->segment(3));
    $query    = "SELECT * FROM saldoawal_gl
    INNER JOIN kategori_barang_pembelian ON kategori_barang_pembelian.kode_kategori=saldoawal_gl.kode_kategori
    WHERE kode_saldoawal_gl = '$kode' 
    ";
    return $this->db->query($query);
  }

  function insert_opname()
  {

    $kode_opname_gl   = $this->input->post('kode_opname');
    $tanggal          = $this->input->post('tanggal');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $jumproduk        = $this->input->post('jumlahproduk');
    $kategori         = $this->input->post('kode_kategori');

    $data = array(
      'kode_opname_gl'    => $kode_opname_gl,
      'tanggal'           => $tanggal,
      'bulan'             => $bulan,
      'tahun'             => $tahun,
      'kode_kategori'     => $kategori
    );
    $simpansaldo   = $this->db->insert('opname_gl', $data);
    if ($simpansaldo) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
        </div>'
      );
      redirect('gudanglogistik/opname');
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Sudah Ada !
        </div>'
      );
      redirect('gudanglogistik/inputopname');
    }
  }

  function insert_detail_opname()
  {

    $kode_opname_gl   = $this->input->post('kode_opname_gl');
    $kode_barang      = $this->input->post('kode_barang');
    $qty              = $this->input->post('qty');
    $kode_edit        = $this->input->post('kode_edit');

    $data = array(
      'kode_opname_gl'    => $kode_opname_gl,
      'kode_barang'       => $kode_barang,
      'qty'               => $qty
    );

    if ($kode_edit == '1') {
      $this->db->update('opname_gl_detail', $data, array('kode_opname_gl' => $kode_opname_gl, 'kode_barang' => $kode_barang));
    } else {
      $this->db->insert('opname_gl_detail', $data);
    }
  }

  function insert_prosessaldoawal()
  {

    $kode_saldoawal_gl   = $this->input->post('kode_saldoawal_gl');
    $kode_barang      = $this->input->post('kode_barang');
    $qty              = $this->input->post('qty');
    $harga            = $this->input->post('harga');

    $data = array(
      'kode_saldoawal_gl'    => $kode_saldoawal_gl,
      'kode_barang'       => $kode_barang,
      'qty'               => $qty,
      'harga'             => $harga
    );

    $this->db->insert('saldoawal_gl_detail', $data);
  }

  function insert_prosesopname()
  {

    $kode_opname_gl   = $this->input->post('kode_opname_gl');
    $kode_barang      = $this->input->post('kode_barang');
    $qty              = $this->input->post('qty');

    $data = array(
      'kode_opname_gl'    => $kode_opname_gl,
      'kode_barang'       => $kode_barang,
      'qty'               => $qty
    );

    $this->db->insert('opname_gl_detail', $data);
  }



  function insert_detail_saldoawal()
  {

    $kode_saldoawal_gl    = $this->input->post('kode_saldoawal_gl');
    $kode_barang          = $this->input->post('kode_barang');
    $qty                  = $this->input->post('qty');
    $kode_edit            = $this->input->post('kode_edit');
    $harga                = $this->input->post('harga');

    $data = array(
      'kode_saldoawal_gl'    => $kode_saldoawal_gl,
      'kode_barang'          => $kode_barang,
      'qty'                  => $qty,
      'harga'                => $harga
    );

    if ($kode_edit == '1') {
      $this->db->update('saldoawal_gl_detail', $data, array('kode_saldoawal_gl' => $kode_saldoawal_gl, 'kode_barang' => $kode_barang));
    } else {
      $this->db->insert('saldoawal_gl_detail', $data);
    }
  }


  function insert_saldoawal()
  {

    $kode_saldoawal_gl = $this->input->post('kode_saldoawal');
    $kategori         = $this->input->post('kode_kategori');
    $tanggal          = $this->input->post('tanggal');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $jumproduk        = $this->input->post('jumlahproduk');

    $data = array(
      'kode_saldoawal_gl' => $kode_saldoawal_gl,
      'tanggal'           => $tanggal,
      'bulan'             => $bulan,
      'tahun'             => $tahun,
      'kode_kategori'     => $kategori,
    );

    $cek            = $this->db->get_where('saldoawal_gl', array('kode_saldoawal_gl' => $kode_saldoawal_gl))->num_rows();
    $cekbulan       = $this->db->get_where('saldoawal_gl', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_kategori' => $kategori))->num_rows();
    if (empty($cek) && empty($cekbulan)) {

      $simpansaldo   = $this->db->insert('saldoawal_gl', $data);
      if ($simpansaldo) {

        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
          </div>'
        );
        redirect('gudanglogistik/saldoawal');
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Sudah Ada !
          </div>'
        );
        redirect('gudanglogistik/inputsaldoawal');
      }
    }
  }

  function hapuspemasukan()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $this->db->query("DELETE FROM pemasukan WHERE nobukti_pemasukan = '$nobukti' ");
    $this->db->query("DELETE FROM detail_pemasukan WHERE nobukti_pemasukan = '$nobukti' ");
  }


  function hapussaldoawal()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $this->db->query("DELETE FROM saldoawal_gl WHERE kode_saldoawal_gl = '$nobukti' ");
    $this->db->query("DELETE FROM saldoawal_gl_detail WHERE kode_saldoawal_gl = '$nobukti' ");
  }

  function hapusopname()
  {

    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $this->db->query("DELETE FROM opname_gl WHERE kode_opname_gl = '$nobukti' ");
    $this->db->query("DELETE FROM opname_gl_detail WHERE kode_opname_gl = '$nobukti' ");
  }

  function getDetailPemasukan()
  {

    $nobukti            = $this->input->post('nobukti');
    $this->db->join('coa', 'detail_pemasukan.kode_akun = coa.kode_akun');
    $this->db->join('master_barang_pembelian', 'detail_pemasukan.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detail_pemasukan', array('detail_pemasukan.nobukti_pemasukan' => $nobukti));
  }

  function getDetailsaldoawal()
  {

    $kode_saldoawal_gl            = $this->input->post('kode_saldoawal_gl');
    $this->db->join('master_barang_pembelian', 'saldoawal_gl_detail.kode_barang = master_barang_pembelian.kode_barang');
    $this->db->join('kategori_barang_pembelian', 'kategori_barang_pembelian.kode_kategori = master_barang_pembelian.kode_kategori');
    return $this->db->get_where('saldoawal_gl_detail', array('saldoawal_gl_detail.kode_saldoawal_gl' => $kode_saldoawal_gl));
  }

  function getopnamestok($bulan, $tahun, $kode_kategori, $kode_opname_gl)
  {

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

    LEFT JOIN (SELECT detail_pemasukan.kode_barang,SUM( qty ) AS qtypemasukan,SUM( harga ) AS hargapemasukan,SUM(detail_pemasukan.harga * qty) AS totalpemasukan FROM 
    detail_pemasukan 
    INNER JOIN pemasukan ON detail_pemasukan.nobukti_pemasukan = pemasukan.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY detail_pemasukan.kode_barang) gm ON (master_barang_pembelian.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT detail_pengeluaran.kode_barang,SUM( qty ) AS qtypengeluaran FROM detail_pengeluaran 
    INNER JOIN pengeluaran ON detail_pengeluaran.nobukti_pengeluaran = pengeluaran.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun'
    GROUP BY detail_pengeluaran.kode_barang) gk ON (master_barang_pembelian.kode_barang = gk.kode_barang)
    
    WHERE master_barang_pembelian.kode_dept = 'GDL' 
    AND master_barang_pembelian.status = 'Aktif' 
    AND master_barang_pembelian.kode_kategori = '$kode_kategori'
    AND master_barang_pembelian.kode_barang NOT IN (SELECT kode_barang FROM opname_gl_detail WHERE kode_opname_gl = '$kode_opname_gl')
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

  function getsaldo($bulan, $tahun, $kode_kategori, $kode_saldoawal_gl)
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

    LEFT JOIN (SELECT detail_pemasukan.kode_barang,SUM( qty ) AS qtypemasukan,SUM( harga ) AS hargapemasukan,SUM(detail_pemasukan.harga * qty) AS totalpemasukan FROM 
    detail_pemasukan 
    INNER JOIN pemasukan ON detail_pemasukan.nobukti_pemasukan = pemasukan.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' 
    GROUP BY detail_pemasukan.kode_barang) gm ON (master_barang_pembelian.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT detail_pengeluaran.kode_barang,SUM( qty ) AS qtypengeluaran FROM detail_pengeluaran 
    INNER JOIN pengeluaran ON detail_pengeluaran.nobukti_pengeluaran = pengeluaran.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun'
    GROUP BY detail_pengeluaran.kode_barang) gk ON (master_barang_pembelian.kode_barang = gk.kode_barang)
    
    WHERE master_barang_pembelian.kode_dept = 'GDL' 
    AND master_barang_pembelian.status = 'Aktif' 
    AND master_barang_pembelian.kode_kategori = '$kode_kategori'
    AND master_barang_pembelian.kode_barang NOT IN (SELECT kode_barang FROM saldoawal_gl_detail WHERE kode_saldoawal_gl = '$kode_saldoawal_gl')
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

  function hargaPengeluaran($bulan, $tahun, $kode_barang)
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

    FROM master_barang_pembelian
    INNER JOIN kategori_barang_pembelian ON 
    master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori


    LEFT JOIN (SELECT saldoawal_gl_detail.kode_barang,SUM(saldoawal_gl_detail.harga) AS hargasaldoawal,SUM( qty ) AS qtysaldoawal,SUM(saldoawal_gl_detail.harga*qty) AS 
    totalsa FROM saldoawal_gl_detail 
    INNER JOIN saldoawal_gl ON saldoawal_gl.kode_saldoawal_gl=saldoawal_gl_detail.kode_saldoawal_gl
    WHERE bulan = '$bulan' AND tahun = '$tahun' AND saldoawal_gl_detail.kode_barang = '$kode_barang'
    GROUP BY saldoawal_gl_detail.kode_barang ) sa ON (master_barang_pembelian.kode_barang = sa.kode_barang)

    LEFT JOIN (SELECT opname_gl_detail.kode_barang,SUM( qty ) AS qtyopname FROM opname_gl_detail 
    INNER JOIN opname_gl ON opname_gl.kode_opname_gl=opname_gl_detail.kode_opname_gl
    WHERE bulan = '$bulan' AND tahun = '$tahun' AND opname_gl_detail.kode_barang = '$kode_barang'
    GROUP BY opname_gl_detail.kode_barang ) op ON (master_barang_pembelian.kode_barang = op.kode_barang)

    LEFT JOIN (SELECT detail_pemasukan.kode_barang,SUM( qty ) AS qtypemasukan,SUM( harga ) AS hargapemasukan,SUM(detail_pemasukan.harga * qty) AS totalpemasukan FROM 
    detail_pemasukan 
    INNER JOIN pemasukan ON detail_pemasukan.nobukti_pemasukan = pemasukan.nobukti_pemasukan 
    WHERE MONTH(tgl_pemasukan) = '$bulan' AND YEAR(tgl_pemasukan) = '$tahun' AND detail_pemasukan.kode_barang = '$kode_barang'
    GROUP BY detail_pemasukan.kode_barang) gm ON (master_barang_pembelian.kode_barang = gm.kode_barang)

    LEFT JOIN (SELECT detail_pengeluaran.kode_barang,SUM( qty ) AS qtypengeluaran FROM detail_pengeluaran 
    INNER JOIN pengeluaran ON detail_pengeluaran.nobukti_pengeluaran = pengeluaran.nobukti_pengeluaran 
    WHERE MONTH(tgl_pengeluaran) = '$bulan' AND YEAR(tgl_pengeluaran) = '$tahun' AND detail_pengeluaran.kode_barang = '$kode_barang'
    GROUP BY detail_pengeluaran.kode_barang) gk ON (master_barang_pembelian.kode_barang = gk.kode_barang)
    

    WHERE master_barang_pembelian.kode_dept = 'GDL' AND master_barang_pembelian.status = 'Aktif' AND master_barang_pembelian.kode_barang = '$kode_barang'
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

  function getDetailopnamestok()
  {

    $kode_opname_gl            = $this->input->post('kode_opname_gl');
    $this->db->join('master_barang_pembelian', 'opname_gl_detail.kode_barang = master_barang_pembelian.kode_barang');
    $this->db->join('kategori_barang_pembelian', 'kategori_barang_pembelian.kode_kategori = master_barang_pembelian.kode_kategori');
    return $this->db->get_where('opname_gl_detail', array('opname_gl_detail.kode_opname_gl' => $kode_opname_gl));
  }

  function getDept()
  {

    return $this->db->get_where('departemen');
  }

  function getSaldoawal()
  {

    $kode_saldoawal_gl            = $this->input->post('kode_saldoawal_gl');
    return $this->db->get_where('saldoawal_gl', array('kode_saldoawal_gl' => $kode_saldoawal_gl));
  }

  function getOpname()
  {

    $kode_opname_gl            = $this->input->post('kode_opname_gl');
    return $this->db->get_where('opname_gl', array('kode_opname_gl' => $kode_opname_gl));
  }

  function getPemasukan()
  {

    $nobukti            = $this->input->post('nobukti');
    return $this->db->get_where('pemasukan', array('nobukti_pemasukan' => $nobukti));
  }

  function getDetailPengeluaran()
  {

    $nobukti            = $this->input->post('nobukti');
    $this->db->join('master_barang_pembelian', 'detail_pengeluaran.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detail_pengeluaran', array('detail_pengeluaran.nobukti_pengeluaran' => $nobukti));
  }

  function getPengeluaran()
  {

    $nobukti            = $this->input->post('nobukti');
    $this->db->join('departemen', 'pengeluaran.kode_dept = departemen.kode_dept');
    return $this->db->get_where('pengeluaran', array('nobukti_pengeluaran' => $nobukti));
  }

  public function getrecordPembelianCount($nobukti = "", $tgl_pembelian = "", $departemen = "", $ppn = "", $ln = "", $supplier = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('pembelian');
    $this->db->join('departemen', 'pembelian.kode_dept = departemen.kode_dept');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->where('pembelian.kode_dept', 'GDL');
    $this->db->where('nobukti_pembelian NOT IN (SELECT nobukti_pemasukan FROM pemasukan)');
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
    $this->db->where('pembelian.kode_dept', 'GDL');
    $this->db->where('nobukti_pembelian NOT IN (SELECT nobukti_pemasukan FROM pemasukan)');
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

    $this->db->join('departemen', 'pembelian.kode_dept = departemen.kode_dept');
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
    return $this->db->get_where('detail_pembelian', array('detail_pembelian.nobukti_pembelian' => $nobukti, 'detail_pembelian.status' => 'PMB'));
  }


  public function getDataopname($rowno, $rowperpage, $kode_opname_gl = "", $tanggal = "")
  {

    $this->db->select('kode_opname_gl,kategori,opname_gl.tanggal,bulan,tahun');
    $this->db->from('opname_gl');
    $this->db->join('kategori_barang_pembelian', 'kategori_barang_pembelian.kode_kategori = opname_gl.kode_kategori');
    $this->db->order_by('opname_gl.tanggal', 'DESC');

    if ($kode_opname_gl != '') {
      $this->db->like('kode_opname_gl', $kode_opname_gl);
    }

    if ($tanggal != '') {
      $this->db->where('opname_gl.tanggal', $tanggal);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordopnameCount($kode_opname_gl = "", $tanggal = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('opname_gl');
    $this->db->join('kategori_barang_pembelian', 'kategori_barang_pembelian.kode_kategori = opname_gl.kode_kategori');
    $this->db->order_by('opname_gl.tanggal', 'DESC');

    if ($kode_opname_gl != '') {
      $this->db->like('kode_opname_gl', $kode_opname_gl);
    }

    if ($tanggal != '') {
      $this->db->where('opname_gl.tanggal', $tanggal);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataSaldoawal($rowno, $rowperpage, $kode_saldoawal_gl = "", $tanggal = "", $kode_kategori = "")
  {

    $this->db->select('*,saldoawal_gl.tanggal AS tgl');
    $this->db->from('saldoawal_gl');
    $this->db->join('kategori_barang_pembelian', 'kategori_barang_pembelian.kode_kategori = saldoawal_gl.kode_kategori');
    $this->db->order_by('saldoawal_gl.tanggal', 'DESC');

    if ($kode_saldoawal_gl != '') {
      $this->db->like('kode_saldoawal_gl', $kode_saldoawal_gl);
    }

    if ($tanggal != '') {
      $this->db->where('saldoawal_gl.tanggal', $tanggal);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordSaldoawalnCount($kode_saldoawal_gl = "", $tanggal = "", $kode_kategori = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('saldoawal_gl');
    $this->db->join('kategori_barang_pembelian', 'kategori_barang_pembelian.kode_kategori = saldoawal_gl.kode_kategori');
    $this->db->order_by('saldoawal_gl.tanggal', 'DESC');

    if ($kode_saldoawal_gl != '') {
      $this->db->like('kode_saldoawal_gl', $kode_saldoawal_gl);
    }

    if ($tanggal != '') {
      $this->db->where('saldoawal_gl.tanggal', $tanggal);
    }

    if ($kode_kategori != '') {
      $this->db->where('saldoawal_gl.kode_kategori', $kode_kategori);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataPemasukan($rowno, $rowperpage, $nobukti = "", $tgl_pemasukan = "")
  {

    $this->db->select('*');
    $this->db->from('pemasukan');
    $this->db->where('gdb', '0');
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
    $this->db->from('pemasukan');
    $this->db->where('gdb', '0');
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

  public function getDataPengeluaran($rowno, $rowperpage, $nobukti = "", $tgl_pengeluaran = "", $kode_dept = "")
  {

    $this->db->select('*');
    $this->db->from('pengeluaran');
    $this->db->join('departemen', 'pengeluaran.kode_dept = departemen.kode_dept');
    $this->db->where('gdb', '0');
    $this->db->order_by('tgl_pengeluaran,nobukti_pengeluaran', 'DESC');

    if ($nobukti != '') {
      $this->db->like('nobukti_pengeluaran', $nobukti);
    }

    if ($tgl_pengeluaran != '') {
      $this->db->where('tgl_pengeluaran', $tgl_pengeluaran);
    }

    if ($kode_dept != '') {
      $this->db->where('pengeluaran.kode_dept', $kode_dept);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getrecordPengeluaranCount($nobukti = "", $tgl_pengeluaran = "", $kode_dept = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('pengeluaran');
    $this->db->join('departemen', 'pengeluaran.kode_dept = departemen.kode_dept');
    $this->db->where('gdb', '0');
    $this->db->order_by('tgl_pengeluaran', 'desc');

    if ($nobukti != '') {
      $this->db->like('nobukti_pengeluaran', $nobukti);
    }

    if ($tgl_pengeluaran != '') {
      $this->db->where('tgl_pengeluaran', $tgl_pengeluaran);
    }

    if ($kode_dept != '') {
      $this->db->where('pengeluaran.kode_dept', $kode_dept);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function insertpemasukan_temp()
  {

    $kode_barang    = $this->input->post('kodebarang');
    $qty            = str_replace(",", "", $this->input->post('jumlah'));
    $harga          = str_replace(",", "", $this->input->post('harga'));
    $kode_akun      = $this->input->post('kodeakun');
    $keterangan     = $this->input->post('keterangan');
    $id_admin       = $this->session->userdata('id_user');

    $data           = array(

      'kode_barang'  => $kode_barang,
      'qty'           => $qty,
      'harga'         => $harga,
      'keterangan'   => $keterangan,
      'id_admin'     => $id_admin

    );

    $this->db->insert('detailpemasukan_temp', $data);
  }

  function insert_pembelian()
  {

    $nobukti           = $this->input->post('nobukti');
    $tgl_pemasukan     = $this->input->post('tgl_pemasukan');

    $data = $this->db->query("SELECT * FROM pembelian WHERE nobukti_pembelian = '$nobukti' ");
    foreach ($data->result() as $d) {

      $data = array(

        'nobukti_pemasukan' => $nobukti,
        'tgl_pemasukan'      => $tgl_pemasukan,
        'tgl_pembelian'      => $d->tgl_pembelian,

      );
      $this->db->insert('pemasukan', $data);
    }


    $data = $this->db->query("SELECT * FROM detail_pembelian WHERE nobukti_pembelian = '$nobukti' ");
    foreach ($data->result() as $d) {

      $data = array(

        'nobukti_pemasukan' => $nobukti,
        'kode_barang'       => $d->kode_barang,
        'qty'                => $d->qty,
        'harga'              => $d->harga,
        'penyesuaian'        => $d->penyesuaian,
        'kode_akun'          => $d->kode_akun,
        'keterangan'        => $d->keterangan

      );
      $this->db->insert('detail_pemasukan', $data);
    }
  }

  function insert_pemasukan()
  {

    $nobukti           = $this->input->post('nobukti');
    $tgl_pemasukan    = $this->input->post('tgl_pemasukan');
    $id_admin         = $this->session->userdata('id_user');

    $data = array(

      'nobukti_pemasukan'  => $nobukti,
      'tgl_pemasukan'      => $tgl_pemasukan,

    );

    $this->db->insert('pemasukan', $data);

    $data = $this->db->query("SELECT * FROM detailpemasukan_temp WHERE id_admin = '$id_admin' ");

    foreach ($data->result() as $d) {

      $data = array(

        'nobukti_pemasukan' => $nobukti,
        'kode_barang'       => $d->kode_barang,
        'qty'                => $d->qty,
        'harga'              => $d->harga,
        'keterangan'        => $d->keterangan

      );
      $this->db->insert('detail_pemasukan', $data);
    }

    $this->db->query("DELETE FROM detailpemasukan_temp WHERE id_admin = '$id_admin' ");
    redirect('gudanglogistik/input_pemasukan');
  }

  function getPemasukantemp()
  {

    $id_user = $this->session->userdata('id_user');
    $this->db->join('master_barang_pembelian', 'detailpemasukan_temp.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detailpemasukan_temp', array('id_admin' => $id_user));
  }

  function hapus_detailpemasukan_temp()
  {

    $kodebarang  = $this->input->post('kodebarang');
    $idadmin     = $this->input->post('idadmin');
    $this->db->delete('detailpemasukan_temp', array('kode_barang' => $kodebarang, 'id_admin' => $idadmin));
  }

  function insertpengeluaran_temp()
  {

    $kode_barang   = $this->input->post('kodebarang');
    $qty           = str_replace(",", "", $this->input->post('jumlah'));
    $keterangan   = $this->input->post('keterangan');
    $id_admin     = $this->session->userdata('id_user');

    $data = array(

      'kode_barang' => $kode_barang,
      'qty'          => $qty,
      'keterangan'  => $keterangan,
      'id_admin'    => $id_admin

    );

    $this->db->insert('detailpengeluaran_temp', $data);
  }

  function updatedetailpengeluaran()
  {

    $kode_barang  = $this->input->post('kodebarang');
    $nobukti      = $this->input->post('nobukti');
    $qty          = str_replace(",", "", $this->input->post('jumlah'));
    $keterangan   = $this->input->post('keterangan');
    $kode_edit    = $this->input->post('kode_edit');
    $id_admin     = $this->session->userdata('id_user');

    $data = array(

      'nobukti_pengeluaran' => $nobukti,
      'kode_barang'         => $kode_barang,
      'qty'                 => $qty,
      'keterangan'          => $keterangan

    );

    if ($kode_edit == "1") {
      $this->db->update('detail_pengeluaran', $data, array('nobukti_pengeluaran' => $nobukti, 'kode_barang' => $kode_barang));
    } else {
      $this->db->insert('detail_pengeluaran', $data);
    }
  }

  function update_pengeluaran()
  {

    $nobukti             = $this->input->post('nobukti');
    $tgl_pengeluaran    = $this->input->post('tgl_pengeluaran');
    $kode_dept          = $this->input->post('departemen');
    $id_admin           = $this->session->userdata('id_user');

    $data = array(

      'nobukti_pengeluaran'   => $nobukti,
      'tgl_pengeluaran'        => $tgl_pengeluaran,
      'kode_dept'              => $kode_dept

    );

    $this->db->update('pengeluaran', $data, array('nobukti_pengeluaran' => $nobukti));
    redirect('gudanglogistik/pengeluaran');
  }

  function insert_pengeluaran()
  {

    $nobukti            = $this->input->post('nobukti');
    $tgl_pengeluaran    = $this->input->post('tgl_pengeluaran');
    $kode_dept          = $this->input->post('departemen');
    $id_admin           = $this->session->userdata('id_user');

    $data = array(

      'nobukti_pengeluaran'   => $nobukti,
      'tgl_pengeluaran'       => $tgl_pengeluaran,
      'kode_dept'             => $kode_dept

    );

    $this->db->insert('pengeluaran', $data);

    $data = $this->db->query("SELECT * FROM detailpengeluaran_temp WHERE id_admin = '$id_admin' ")->result();

    foreach ($data as $d) {


      $data = array(

        'nobukti_pengeluaran'    => $nobukti,
        'kode_barang'            => $d->kode_barang,
        'qty'                    => $d->qty,
        'keterangan'             => $d->keterangan

      );
      $this->db->insert('detail_pengeluaran', $data);
    }

    $this->db->query("DELETE FROM detailpengeluaran_temp WHERE id_admin = '$id_admin' ");
    redirect('gudanglogistik/input_pengeluaran');
  }

  function getPengeluarantemp()
  {

    $id_user = $this->session->userdata('id_user');
    $this->db->join('master_barang_pembelian', 'detailpengeluaran_temp.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detailpengeluaran_temp', array('id_admin' => $id_user));
  }

  function getdetaileditPengeluaran()
  {

    $nobukti  = $this->input->post('nobukti');
    $this->db->join('master_barang_pembelian', 'detail_pengeluaran.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detail_pengeluaran', array('nobukti_pengeluaran' => $nobukti));
  }

  function hapus_detailpengeluaran_temp()
  {

    $kodebarang  = $this->input->post('kodebarang');
    $idadmin     = $this->input->post('idadmin');
    $this->db->delete('detailpengeluaran_temp', array('kode_barang' => $kodebarang, 'id_admin' => $idadmin));
  }

  function hapus_detaileditpengeluaran()
  {

    $kodebarang   = $this->input->post('kodebarang');
    $nobukti      = $this->input->post('nobukti');
    $ket          = $this->input->post('ket');
    $this->db->delete('detail_pengeluaran', array('kode_barang' => $kodebarang, 'nobukti_pengeluaran' => $nobukti));
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

    $this->datatables->select('kode_barang,nama_barang,satuan,master_barang_pembelian.kode_dept,nama_dept,jenis_barang,kode_kategori');
    $this->datatables->from('master_barang_pembelian');
    $this->datatables->join('departemen', 'master_barang_pembelian.kode_dept = departemen.kode_dept');
    $this->datatables->where('master_barang_pembelian.kode_dept', 'GDL');
    $this->datatables->where('master_barang_pembelian.status', 'Aktif');
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2"  data-jenis="$3"  data-kategori="$4" class="btn btn-danger btn-sm waves-effect pilih">Pilih</a>', 'kode_barang,nama_barang,jenis_barang,kode_kategori');
    return $this->datatables->generate();
  }

  function jsonPilihBarangOpname()
  {

    $kode_kategori    = $this->uri->segment(3);
    $tahun            = $this->uri->segment(4);
    $bulan            = $this->uri->segment(5);

    $opname = $this->db->query("SELECT kode_barang FROM opname_gl_detail 
      INNER JOIN opname_gl ON opname_gl_detail.kode_opname_gl = opname_gl.kode_opname_gl
      WHERE tahun = '$tahun' AND bulan = '$bulan' AND kode_kategori = '$kode_kategori'
      ")->result();

    foreach ($opname as $op) {

      $kode[] = $op->kode_barang;
    }

    $this->datatables->select('kode_barang,nama_barang,satuan,master_barang_pembelian.kode_dept,nama_dept,jenis_barang,kategori');
    $this->datatables->from('master_barang_pembelian');
    $this->datatables->join('departemen', 'master_barang_pembelian.kode_dept = departemen.kode_dept');
    $this->datatables->join('kategori_barang_pembelian', 'master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori');
    $this->datatables->where('master_barang_pembelian.status', 'Aktif');
    $this->datatables->where('master_barang_pembelian.kode_dept', 'GDL');
    $this->datatables->where('master_barang_pembelian.kode_kategori', $kode_kategori);
    if (!empty($kode)) {
      $this->db->where_not_in('kode_barang', $kode);
    }
    $this->db->order_by('master_barang_pembelian.nama_barang', 'ASC');
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2"  data-jenis="$3"   data-kategori="$3" class="btn btn-danger btn-sm waves-effect pilih">Pilih</a>', 'kode_barang,nama_barang,jenis_barang');
    return $this->datatables->generate();
  }

  function jsonPilihBarangSaldoawal()
  {

    $kode_kategori    = $this->uri->segment(3);
    $tahun            = $this->uri->segment(4);
    $bulan            = $this->uri->segment(5);

    $opname = $this->db->query("SELECT kode_barang FROM saldoawal_gl_detail 
      INNER JOIN saldoawal_gl ON saldoawal_gl_detail.kode_saldoawal_gl = saldoawal_gl.kode_saldoawal_gl
      WHERE tahun = '$tahun' AND bulan = '$bulan' AND kode_kategori = '$kode_kategori'
      ")->result();

    foreach ($opname as $op) {

      $kode[] = $op->kode_barang;
    }

    //die;

    $this->datatables->select('kode_barang,nama_barang,satuan,master_barang_pembelian.kode_dept,nama_dept,jenis_barang,kategori');
    $this->datatables->from('master_barang_pembelian');
    $this->datatables->join('departemen', 'master_barang_pembelian.kode_dept = departemen.kode_dept');
    $this->datatables->join('kategori_barang_pembelian', 'master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori');
    $this->datatables->where('master_barang_pembelian.kode_dept', 'GDL');
    $this->datatables->where('master_barang_pembelian.status', 'Aktif');
    $this->datatables->where('master_barang_pembelian.kode_kategori', $kode_kategori);
    if (!empty($kode)) {
      $this->db->where_not_in('kode_barang', $kode);
    }
    $this->db->order_by('master_barang_pembelian.nama_barang', 'ASC');
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2"  data-jenis="$3"   data-kategori="$4" class="btn btn-danger btn-sm waves-effect pilih">Pilih</a>', 'kode_barang,nama_barang,jenis_barang');
    return $this->datatables->generate();
  }
}
