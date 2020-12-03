<?php

/**
 *
 */
class Model_pembelian extends CI_Model
{

  function getKategori()
  {
    $kodedept = $this->session->userdata('dept');
    if (!empty($kodedept)) {
      $this->db->where('kode_dept', $kodedept);
    }
    return $this->db->get('kategori_barang_pembelian');
  }

  function getDepts()
  {
    return $this->db->get_where('departemen');
  }

  function getDept()
  {
    return $this->db->get_where('departemen', array('status_pengajuan' => 0));
  }

  function getPemohon()
  {
    return $this->db->get_where('departemen', array('status_pengajuan' => 1));
  }

  function insertdetailbpb_temp()
  {
    $id_user      = $this->session->userdata('id_user');
    $kodebarang   = $this->input->post('kodebarang');
    $jumlah       = $this->input->post('jumlah');
    $keterangan   = $this->input->post('keterangan');
    $data = array('kode_barang' => $kodebarang, 'jumlah' => $jumlah, 'keterangan' => $keterangan, 'id_admin' => $id_user);
    $cek  = $this->db->get_where('detailbpb_temp', array('kode_barang' => $kodebarang, 'id_admin' => $id_user))->num_rows();
    if (!empty($cek)) {
      echo "1";
    } else {
      $this->db->insert('detailbpb_temp', $data);
    }
  }

  function insertdetailpembelian_temp()
  {
    $id_user      = $this->session->userdata('id_user');
    $kodebarang   = $this->input->post('kodebarang');
    $cabang          = $this->input->post('cabang');
    if (!empty($cabang)) {
      $cbg = $this->input->post('cbg');
    } else {
      $cbg = "";
    }
    $kodedept     = $this->input->post('kodedept');
    $keterangan   = $this->input->post('keterangan');
    $harga        = str_replace(".", "", $this->input->post('harga'));
    $harga        = str_replace(",", ".", $harga);
    $penyharga    = str_replace(".", "", $this->input->post('penyharga'));
    $penyharga    = str_replace(",", ".", $penyharga);
    $jumlah       = $this->input->post('jumlah');
    $jumlah       = str_replace(",", ".", $jumlah);
    $kodeakun     = $this->input->post('kodeakun');

    $data = array(

      'kode_barang'   => $kodebarang,
      'keterangan'    => $keterangan,
      'kode_dept'     => $kodedept,
      'harga'         => $harga,
      'penyesuaian'   => $penyharga,
      'qty'           => $jumlah,
      'kode_akun'     => $kodeakun,
      'kode_cabang'   => $cbg,
      'id_admin'      => $id_user
    );
    $this->db->insert('detailpembelian_temp', $data);
    // $cek  = $this->db->get_where('detailpembelian_temp',array('kode_barang'=>$kodebarang,'id_admin'=>$id_user))->num_rows();
    // if(!empty($cek)){
    //   echo "1";
    // }else{

    // }

  }

  function insertdetailkontrabon_temp()
  {
    $id_user      = $this->session->userdata('id_user');
    $nobukti      = $this->input->post('nobukti');
    $supplier     = $this->input->post('supplier');
    $keterangan   = $this->input->post('keterangan');
    $jmlbayar     = str_replace(".", "", $this->input->post('jmlbayar'));
    $jmlbayar     = str_replace(",", ".", $jmlbayar);
    $data = array(
      'nobukti_pembelian' => $nobukti,
      'kode_supplier'    => $supplier,
      'keterangan'       => $keterangan,
      'jmlbayar'         => $jmlbayar,
      'id_admin'         => $id_user
    );
    $cek  = $this->db->get_where('detailkontrabon_temp', array('nobukti_pembelian' => $nobukti, 'id_admin' => $id_user))->num_rows();
    if (!empty($cek)) {
      echo "1";
    } else {
      $this->db->insert('detailkontrabon_temp', $data);
    }
  }
  function insertdetailbpb()
  {
    $nobpb        = $this->input->post('nobpb');
    $kodebarang   = $this->input->post('kodebarang');
    $jumlah       = $this->input->post('jumlah');
    $keterangan   = $this->input->post('keterangan');

    $data = array('no_bpb' => $nobpb, 'kode_barang' => $kodebarang, 'jumlah' => $jumlah, 'keterangan' => $keterangan);
    $cek  = $this->db->get_where('detail_bpb', array('kode_barang' => $kodebarang, 'no_bpb' => $nobpb))->num_rows();
    if (!empty($cek)) {
      echo "1";
    } else {
      $this->db->insert('detail_bpb', $data);
    }
  }

  function getBPBtemp()
  {
    $id_user = $this->session->userdata('id_user');
    $this->db->join('master_barang_pembelian', 'detailbpb_temp.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detailbpb_temp', array('id_admin' => $id_user));
  }

  function getPembeliantemp($departemen)
  {
    $id_user = $this->session->userdata('id_user');
    $this->db->join('master_barang_pembelian', 'detailpembelian_temp.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detailpembelian_temp', array('id_admin' => $id_user, 'detailpembelian_temp.kode_dept' => $departemen));
  }



  function hapus_detailbpb_temp()
  {
    $kodebarang  = $this->input->post('kodebarang');
    $idadmin    = $this->input->post('idadmin');
    $this->db->delete('detailbpb_temp', array('kode_barang' => $kodebarang, 'id_admin' => $idadmin));
  }

  function hapus_detailpembelian_temp()
  {
    $kodebarang  = $this->input->post('kodebarang');
    $idadmin     = $this->input->post('idadmin');
    $this->db->delete('detailpembelian_temp', array('id' => $kodebarang, 'id_admin' => $idadmin));
  }

  function hapus_detailkontrabon_temp()
  {
    $nobukti     = $this->input->post('nobukti');
    $idadmin     = $this->input->post('idadmin');
    $this->db->delete('detailkontrabon_temp', array('nobukti_pembelian' => $nobukti, 'id_admin' => $idadmin));
  }

  function json()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang != "pusat") {
      $this->datatables->where('pelanggan.kode_cabang', $cabang);
    }
    $this->datatables->select('kode_pelanggan,nama_pelanggan,alamat_pelanggan,pelanggan.no_hp,pasar,hari,nama_cabang,nama_karyawan');
    $this->datatables->from('pelanggan');
    $this->datatables->join('cabang', 'pelanggan.kode_cabang = cabang.kode_cabang');
    $this->datatables->join('karyawan', 'pelanggan.id_sales = karyawan.id_karyawan');
    $this->datatables->where('nama_pelanggan !=', 'BATAL');
    $this->datatables->add_column('view', '<a href="edit_pelanggan/$1" " class="btn bg-green btn-xs waves-effect ">Edit</a> <a href="#" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="hapus/$1" class="btn bg-red btn-xs waves-effect">Hapus</a>', 'kode_pelanggan');
    return $this->datatables->generate();
  }

  function jsonBarang()
  {
    $kodedept = $this->session->userdata('dept');
    if (!empty($kodedept)) {
      $this->datatables->where('master_barang_pembelian.kode_dept', $kodedept);
    }
    $this->datatables->select('kode_barang,nama_barang,jenis_barang,nama_dept,satuan,kategori,status');
    $this->datatables->from('master_barang_pembelian');
    $this->datatables->join('departemen', 'master_barang_pembelian.kode_dept = departemen.kode_dept');
    $this->datatables->join('kategori_barang_pembelian', 'master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori', 'left');

    $this->datatables->add_column('view', '<a href="#" data-kode="$1" class="btn btn-primary btn-sm edit">Edit</a> <a href="#"  data-toggle="modal" data-href="hapusbarang/$1" class="btn btn-danger btn-sm hapus">Hapus</a>', 'kode_barang');
    return $this->datatables->generate();
  }

  function jsonPilihBarang()
  {
    $pemohon = $this->uri->segment(3);
    $this->datatables->where('master_barang_pembelian.kode_dept', $pemohon);
    if ($pemohon == 'GAF') {
      $this->datatables->or_where('master_barang_pembelian.kode_dept', 'GDL');
    }
    $this->datatables->select('kode_barang,nama_barang,jenis_barang,nama_dept,satuan');
    $this->datatables->from('master_barang_pembelian');
    $this->datatables->join('departemen', 'master_barang_pembelian.kode_dept = departemen.kode_dept');
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2" data-satuan="$3" class="btn bg-red btn-xs waves-effect pilih">Pilih</a>', 'kode_barang,nama_barang,satuan');
    return $this->datatables->generate();
  }

  function jsonPilihSupplier()
  {
    $this->datatables->select('kode_supplier,nama_supplier,contact_supplier,nohp_supplier,alamat_supplier');
    $this->datatables->from('supplier');
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2" class="btn btn-sm btn-danger pilih">Pilih</a>', 'kode_supplier,nama_supplier');
    return $this->datatables->generate();
  }

  function jsonPilihAkun()
  {
    $this->datatables->select('set_coa_cabang.kode_akun,nama_akun');
    $this->datatables->from('set_coa_cabang');
    $this->datatables->join('coa', 'set_coa_cabang.kode_akun = coa.kode_akun');
    $this->datatables->where('kategori', 'pembelian');
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2" class="btn btn-sm btn-danger pilih">Pilih</a>', 'kode_akun,nama_akun');
    return $this->datatables->generate();
  }

  function getAkunPembelian()
  {
    $this->db->select('set_coa_cabang.kode_akun,nama_akun');
    $this->db->from('set_coa_cabang');
    $this->db->join('coa', 'set_coa_cabang.kode_akun = coa.kode_akun');
    $this->db->where('kategori', 'pembelian');
    return $this->db->get();
  }

  function jsonPilihPembelian($supplier)
  {
    $query =
      "SELECT
      pembelian.nobukti_pembelian,tgl_pembelian,pembelian.kode_supplier,nama_supplier,harga,jmlbayar,pembelian.kode_dept,nama_dept,pembelian.jenistransaksi
    FROM
      pembelian
      INNER JOIN supplier ON pembelian.kode_supplier = supplier.kode_supplier
      INNER JOIN departemen ON pembelian.kode_dept = departemen.kode_dept
      
      LEFT JOIN ( SELECT nobukti_pembelian,
      SUM( IF ( STATUS = 'PMB', ( ( qty * harga ) + penyesuaian ), 0 ) ) - SUM( IF ( STATUS = 'PNJ', ( qty * harga ), 0 ) ) as harga
      FROM detail_pembelian
      GROUP BY nobukti_pembelian) dp ON (pembelian.nobukti_pembelian = dp.nobukti_pembelian) 
      
      LEFT JOIN (SELECT nobukti_pembelian, SUM(jmlbayar) as jmlbayar 
      FROM
      historibayar_pembelian hb
      INNER JOIN detail_kontrabon ON hb.no_kontrabon = detail_kontrabon.no_kontrabon 
      GROUP BY nobukti_pembelian) bayar ON (pembelian.nobukti_pembelian = bayar.nobukti_pembelian)
      
      
      WHERE pembelian.kode_supplier = '$supplier' AND IFNULL( jmlbayar, 0 ) != ( harga )  AND pembelian.jenistransaksi != 'tunai'
      GROUP BY pembelian.nobukti_pembelian
      ORDER BY tgl_pembelian ASC
    ";
    return $this->db->query($query);
  }



  function insert_barang()
  {
    $kodebarang  = $this->input->post('kodebarang');
    $namabarang  = $this->input->post('nama_barang');
    $satuan      = $this->input->post('satuan');
    $jenisbarang = $this->input->post('jenis_barang');
    $kode_kategori = $this->input->post('kode_kategori');
    $departemen  = $this->input->post('departemen');

    $data = array(
      'kode_barang'  => $kodebarang,
      'nama_barang'  => $namabarang,
      'satuan'       => $satuan,
      'jenis_barang' => $jenisbarang,
      'kode_kategori' => $kode_kategori,
      'status'        => 'Aktif',
      'kode_dept'    => $departemen
    );

    $cek = $this->db->get_where('master_barang_pembelian', array('kode_barang' => $kodebarang))->num_rows();
    if (empty($cek)) {
      $simpan = $this->db->insert('master_barang_pembelian', $data);
      if ($simpan) {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil Disimpan !
        </div>'
        );
        redirect('pembelian/barang');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Kode Barang Sudah Ada !
      </div>'
      );
      redirect('pembelian/barang');
    }
  }

  function getBarang($kodebarang)
  {
    $this->db->join('kategori_barang_pembelian', 'master_barang_pembelian.kode_kategori = kategori_barang_pembelian.kode_kategori', 'left');
    return $this->db->get_where('master_barang_pembelian', array('kode_barang' => $kodebarang));
  }

  function update_barang()
  {
    $kodebarang  = $this->input->post('kodebarang');
    $namabarang  = $this->input->post('nama_barang');
    $satuan      = $this->input->post('satuan');
    $jenisbarang = $this->input->post('jenis_barang');
    $departemen  = $this->input->post('departemen');
    $kode_kategori  = $this->input->post('kode_kategori');
    $status       = $this->input->post('status');

    $data = array(
      'nama_barang'  => $namabarang,
      'satuan'       => $satuan,
      'jenis_barang' => $jenisbarang,
      'kode_kategori' => $kode_kategori,
      'status'       => $status,
      'kode_dept'    => $departemen
    );


    $simpan = $this->db->update('master_barang_pembelian', $data, array('kode_barang' => $kodebarang));
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil Disimpan !
      </div>'
      );
      redirect('pembelian/barang');
    }
  }

  function insert_bpb()
  {
    $nobpb            = $this->input->post('nobpb');
    $tgl_permintaan   = $this->input->post('tgl_permintaan');
    $yangmengajukan   = $this->input->post('yangmengajukan');
    $departemen       = $this->input->post('departemen');

    $id_user          = $this->session->userdata('id_user');
    $data = array(
      'no_bpb'            => $nobpb,
      'tgl_permintaan'    => $tgl_permintaan,
      'yangmengajukan'    => $yangmengajukan,
      'kode_dept'         => $departemen,

      'id_admin'          => $id_user
    );

    $simpan = $this->db->insert('bpb', $data);
    if ($simpan) {
      $detail = $this->db->get_where('detailbpb_temp', array('id_admin' => $id_user))->result();
      foreach ($detail as $d) {
        $data = array(
          'no_bpb'        => $nobpb,
          'kode_barang'   => $d->kode_barang,
          'jumlah'        => $d->jumlah,
          'keterangan'    => $d->keterangan,
        );

        $this->db->insert('detail_bpb', $data);
      }
      $this->db->delete('detailbpb_temp', array('id_admin' => $id_user));
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Simpan !
      </div>'
      );
      redirect('pembelian/permintaanbarang');
    }
  }

  public function getDataBpb($rowno, $rowperpage, $no_bpb = "", $tgl_permintaan = "", $departemen = "", $statuspesanan = "")
  {
    if ($no_bpb != '') {
      $no_bpb = "AND no_bpb = '" . $no_bpb . "' ";
    }
    if ($tgl_permintaan != '') {
      $tgl_permintaan = "AND tgl_permintaan = '" . $tgl_permintaan . "' ";
    }
    if ($departemen != '') {
      $departemen = "AND b.kode_dept = '" . $departemen . "' ";
    }

    if ($statuspesanan == '1') {
      $statuspesanan = "AND tgl_pemesanan != ''";
    } else if ($statuspesanan == '0') {
      $statuspesanan = "AND tgl_pemesanan IS NULL";
    }
    $q = "SELECT
  no_bpb,
  tgl_permintaan,
  tgl_pemesanan,
  yangmengajukan,
  b.kode_dept,
  nama_dept,
  ( SELECT COUNT( no_bpb ) FROM detail_bpb d WHERE d.no_bpb = b.no_bpb GROUP BY d.no_bpb ) AS jmlbpb,
  ( SELECT COUNT( no_bpb ) FROM detail_pembelian dp  WHERE dp.no_bpb = b.no_bpb GROUP BY dp.no_bpb) AS jmlpmb
  FROM
  bpb b
  INNER JOIN departemen ON b.kode_dept = departemen.kode_dept
  WHERE no_bpb !=''"
      . $no_bpb
      . $tgl_permintaan
      . $departemen
      . $statuspesanan
      . "
  ORDER BY tgl_permintaan DESC LIMIT $rowno,$rowperpage";

    $query = $this->db->query($q);
    return $query->result_array();
  }

  // Select total records
  public function getrecordBpbCount($no_bpb = "", $tgl_permintaan = "", $departemen = "", $statuspesanan = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('bpb');
    $this->db->join('departemen', 'bpb.kode_dept = departemen.kode_dept');
    $this->db->order_by('tgl_permintaan', 'desc');
    if ($no_bpb != '') {
      $this->db->where('no_bpb', $no_bpb);
    }
    if ($tgl_permintaan != '') {
      $this->db->where('tgl_permintaan', $tgl_permintaan);
    }

    if ($departemen != '') {
      $this->db->where('bpb.kode_dept', $departemen);
    }

    if ($statuspesanan == '1') {
      $statuspesanan = "AND tgl_pemesanan != ''";
    } else if ($statuspesanan == '0') {
      $statuspesanan = "AND tgl_pemesanan IS NULL";
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function getBPB($nobpb)
  {
    $this->db->join('departemen', 'bpb.kode_dept = departemen.kode_dept');
    return $this->db->get_where('bpb', array('no_bpb' => $nobpb));
  }

  function getPembelian($nobukti)
  {
    $this->db->join('departemen', 'pembelian.kode_dept = departemen.kode_dept');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    return $this->db->get_where('pembelian', array('nobukti_pembelian' => $nobukti));
  }

  function getKontrabon($nokontrabon)
  {
    $this->db->join('supplier', 'kontrabon.kode_supplier = supplier.kode_supplier');
    return $this->db->get_where('kontrabon', array('no_kontrabon' => $nokontrabon));
  }

  function getDetailBpb($nobpb)
  {
    $this->db->select('detail_bpb.no_bpb,detail_bpb.kode_barang,nama_barang,satuan,keterangan,jumlah,qty,detail_bpb.nobukti_pembelian');
    $this->db->join('master_barang_pembelian', 'detail_bpb.kode_barang = master_barang_pembelian.kode_barang');
    $this->db->join('detail_pembelian', 'detail_bpb.no_bpb = detail_pembelian.no_bpb AND detail_bpb.kode_barang = detail_pembelian.kode_barang', 'left');
    return $this->db->get_where('detail_bpb', array('detail_bpb.no_bpb' => $nobpb));
  }

  function getDetailPembelian($nobukti)
  {
    $this->db->join('master_barang_pembelian', 'detail_pembelian.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detail_pembelian', array('detail_pembelian.nobukti_pembelian' => $nobukti, 'detail_pembelian.status' => 'PMB'));
  }

  function getTotalPembelian($nobukti)
  {
    $query = "SELECT SUM(harga*qty+penyesuaian) as totalpembelian FROM detail_pembelian WHERE nobukti_pembelian='$nobukti'";
    return $this->db->query($query);
  }

  function getDetailPnjPembelian($nobukti)
  {

    return $this->db->get_where('detail_pembelian', array('detail_pembelian.nobukti_pembelian' => $nobukti, 'status' => 'PNJ'));
  }

  function getDetailKontrabon($nokontrabon)
  {
    $this->db->select('detail_kontrabon.no_kontrabon,detail_kontrabon.nobukti_pembelian,detail_kontrabon.jmlbayar');
    $this->db->from('detail_kontrabon');
    $this->db->order_by('detail_kontrabon.nobukti_pembelian', 'DESC');
    $this->db->where('detail_kontrabon.no_kontrabon', $nokontrabon);
    return $this->db->get();
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

  function hapus_detailbpb()
  {
    $kodebarang  = $this->input->post('kodebarang');
    $nobpb       = $this->input->post('nobpb');
    $this->db->delete('detail_bpb', array('kode_barang' => $kodebarang, 'no_bpb' => $nobpb));
  }

  function update_bpb()
  {
    $nobpb            = $this->input->post('nobpb');
    $tgl_permintaan   = $this->input->post('tgl_permintaan');
    $yangmengajukan   = $this->input->post('yangmengajukan');
    $departemen       = $this->input->post('departemen');

    $id_user          = $this->session->userdata('id_user');
    $data = array(

      'tgl_permintaan'    => $tgl_permintaan,
      'yangmengajukan'    => $yangmengajukan,
      'kode_dept'         => $departemen,

      'id_admin'          => $id_user
    );

    $update = $this->db->update('bpb', $data, array('no_bpb' => $nobpb));
    if ($update) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Update !
      </div>'
      );
      redirect('pembelian/permintaanbarang');
    }
  }

  function hapusbpb()
  {
    $nobpb = str_replace(".", "/", $this->uri->segment(3));
    $hapus = $this->db->delete('bpb', array('no_bpb' => $nobpb));
    if ($hapus) {
      $hapusdetail = $this->db->delete('detail_bpb', array('no_bpb' => $nobpb));
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Hapus !
      </div>'
      );
      redirect('pembelian/permintaanbarang');
    }
  }

  function getKodeSupplier()
  {
    $query = "SELECT kode_supplier FROM supplier ORDER BY kode_supplier DESC LIMIT 1";
    return $this->db->query($query);
  }

  function insert_supplier()
  {
    $kode_supplier  = $this->input->post('kodesupplier');
    $nama_supplier  = $this->input->post('namasupplier');
    $contact_person = $this->input->post('cp');
    $nohp_supplier  = $this->input->post('nohp');
    $alamat_supplier = $this->input->post('alamat');
    $email          = $this->input->post('email');
    $norek          = $this->input->post('norek');

    $data = array(
      'kode_supplier'     => $kode_supplier,
      'nama_supplier'     => $nama_supplier,
      'contact_supplier'  => $contact_person,
      'nohp_supplier'     => $nohp_supplier,
      'alamat_supplier'   => $alamat_supplier,
      'email'             => $email,
      'norekening'        => $norek
    );

    $simpan = $this->db->insert('supplier', $data);
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Simpan !
      </div>'
      );
      redirect('pembelian/supplier');
    }
  }

  function jsonSupplier()
  {
    $this->datatables->select('kode_supplier,nama_supplier,contact_supplier,nohp_supplier,alamat_supplier,email,norekening');
    $this->datatables->from('supplier');
    $this->datatables->add_column('view', '<a href="editsupplier/$1"  class="btn btn-primary btn-sm edit">Edit</a> <a href="#"  data-toggle="modal" data-href="hapussupplier/$1" class="btn btn-danger btn-sm hapus">Hapus</a>', 'kode_supplier');
    return $this->datatables->generate();
  }

  function getSupplier($kode_supplier)
  {
    return $this->db->get_where('supplier', array('kode_supplier' => $kode_supplier));
  }

  function listSupplier()
  {
    return $this->db->get('supplier');
  }

  function update_supplier()
  {
    $kode_supplier  = $this->input->post('kodesupplier');
    $nama_supplier  = $this->input->post('namasupplier');
    $contact_person = $this->input->post('cp');
    $nohp_supplier  = $this->input->post('nohp');
    $alamat_supplier = $this->input->post('alamat');
    $email          = $this->input->post('email');
    $norek          = $this->input->post('norek');

    $data = array(
      'nama_supplier'     => $nama_supplier,
      'contact_supplier'  => $contact_person,
      'nohp_supplier'     => $nohp_supplier,
      'alamat_supplier'   => $alamat_supplier,
      'email'             => $email,
      'norekening'        => $norek
    );

    $simpan = $this->db->update('supplier', $data, array('kode_supplier' => $kode_supplier));
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Update !
      </div>'
      );
      redirect('pembelian/supplier');
    }
  }

  function hapussupplier($kode_supplier)
  {
    $hapus = $this->db->delete('supplier', array('kode_supplier' => $kode_supplier));
    if ($hapus) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Hapus !
      </div>'
      );
      redirect('pembelian/supplier');
    }
  }

  function jsonPilihBarangpembelian()
  {
    $departemen = $this->uri->segment(3);
    $this->datatables->select('kode_barang,nama_barang,satuan,master_barang_pembelian.kode_dept,nama_dept,jenis_barang');
    $this->datatables->from('master_barang_pembelian');
    $this->datatables->join('departemen', 'master_barang_pembelian.kode_dept = departemen.kode_dept');
    $this->datatables->where('master_barang_pembelian.kode_dept', $departemen);
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2"  data-jenis="$3" class="btn btn-sm btn-danger pilih">Pilih</a>', 'kode_barang,nama_barang,jenis_barang');
    return $this->datatables->generate();
  }

  function jsonPIlihBarangDO()
  {
    $departemen = $this->uri->segment(3);
    $this->datatables->select('detail_bpb.no_bpb,tgl_permintaan,detail_bpb.kode_barang,nama_barang,satuan,jumlah,keterangan,jenis_barang,bpb.kode_dept,nama_dept');
    $this->datatables->from('detail_bpb');
    $this->datatables->join('bpb', 'detail_bpb.no_bpb = bpb.no_bpb');
    $this->datatables->join('master_barang_pembelian', 'detail_bpb.kode_barang = master_barang_pembelian.kode_barang');
    $this->datatables->join('departemen', 'bpb.kode_dept = departemen.kode_dept');
    $this->datatables->where('bpb.kode_dept', $departemen);
    $this->datatables->add_column('view', '<a href="#"  data-toggle="modal" data-kode="$1" data-nama="$2" data-ket="$3" data-jenis="$4" data-jml="$5" data-nobpb="$6" class="btn bg-red btn-xs waves-effect pilih">Pilih</a>', 'kode_barang,nama_barang,keterangan,jenis_barang,jumlah,no_bpb');
    return $this->datatables->generate();
  }

  function getNoBukti($bulan)
  {
    $query = "SELECT nobukti_pembelian FROM pembelian
  WHERE MONTH(tgl_pembelian) = '$bulan' ORDER BY nobukti_pembelian DESC LIMIT 1";
    return $this->db->query($query);
  }

  function getNoDO($bulan, $tahun)
  {
    $query = "SELECT no_do FROM do
  WHERE MONTH(tgl_do) = '$bulan' AND YEAR(tgl_do)='$tahun' ORDER BY no_do DESC LIMIT 1";
    return $this->db->query($query);
  }

  function getNoBPB($bulan, $kodedept)
  {
    $query = "SELECT no_bpb FROM bpb
  WHERE MONTH(tgl_permintaan) = '$bulan' AND kode_dept='$kodedept' ORDER BY no_bpb DESC LIMIT 1";
    return $this->db->query($query);
  }

  function getNoKB($bulan, $tahun, $status)
  {
    $query = "SELECT no_kontrabon FROM kontrabon
  WHERE MONTH(tgl_kontrabon) = '$bulan' AND YEAR(tgl_kontrabon)='$tahun' AND kategori ='$status' ORDER BY no_kontrabon DESC LIMIT 1";
    return $this->db->query($query);
  }

  function insert_pembelian()
  {
    $id_user          = $this->session->userdata('id_user');
    $nobukti          = $this->input->post('nobukti');
    $tgl_pembelian    = $this->input->post('tgl_pembelian');
    $supplier         = $this->input->post('kodesupplier');
    $departemen       = $this->input->post('departemen');
    $tgl_jatuhtempo   = $this->input->post('jatuhtempo');
    $jenistransaksi   = $this->input->post('jenistransaksi');
    $t                = explode("-", $tgl_pembelian);
    $tgl              = $t[2] . $t[1] . $t[0];
    $rand             = rand(10, 100);
    $nokontrabon      = "T" . $tgl . $rand;
    if ($departemen != "GDB") {
      $kodeakun     = "2-1300";
    } else {
      $kodeakun     = "2-1200";
    }
    $ppn             = $this->input->post('ppn');
    if (empty($ppn)) {
      $p = 0;
    } else {
      $p = 1;
    }

    if ($jenistransaksi == 'tunai') {
      $ref = $nokontrabon;
    } else {
      $ref = "";
    }

    $data = array(
      'nobukti_pembelian'  => $nobukti,
      'tgl_pembelian'      => $tgl_pembelian,
      'kode_supplier'      => $supplier,
      'kode_dept'          => $departemen,
      'kode_akun'          => $kodeakun,
      'ppn'                => $p,
      'tgl_jatuhtempo'     => $tgl_jatuhtempo,
      'jenistransaksi'     => $jenistransaksi,
      'ref_tunai'          => $ref,
      'id_admin'           => $id_user
    );

    $simpan = $this->db->insert('pembelian', $data);
    if ($simpan) {
      if ($jenistransaksi == 'tunai') {
        $data = array(
          'no_kontrabon'       => $nokontrabon,
          'tgl_kontrabon'      => $tgl_pembelian,
          'kode_supplier'      => $supplier,
          'kategori'           => 'TN',
          'id_admin'           => $id_user,
          'jenisbayar'         => 'tunai'
        );

        $simpankontrabon = $this->db->insert('kontrabon', $data);
        if ($simpankontrabon) {
          $jmlbayar = "SELECT SUM((qty*harga)+penyesuaian) as jmlbayar FROM detailpembelian_temp WHERE id_admin = '$id_user' AND kode_dept='$departemen'";
          $jmbayar  = $this->db->query($jmlbayar)->row_array();
          $datakb = array(
            'no_kontrabon'        => $nokontrabon,
            'nobukti_pembelian'   => $nobukti,
            'jmlbayar'            => $jmbayar['jmlbayar'],
            'keterangan'          => 'tunai'
          );

          // $databayar = array(
          //   'no_kontrabon' => $nokontrabon,
          //   'tglbayar'    => $tgl_pembelian,
          //   'bayar'        => $jmbayar['jmlbayar'],
          //   'id_admin'     => $id_user,
          //   'via'          => 'KAS'
          // );

          $this->db->insert('detail_kontrabon', $datakb);
          // $this->db->insert('historibayar_pembelian',$databayar);
        }
      }
      $qdetailtmp = "SELECT * FROM detailpembelian_temp
    INNER JOIN master_barang_pembelian ON detailpembelian_temp.kode_barang = master_barang_pembelian.kode_barang
    WHERE master_barang_pembelian.kode_dept = '$departemen' AND detailpembelian_temp.id_admin='$id_user' ORDER BY id ASC";
      $detailtmp  =  $this->db->query($qdetailtmp)->result();
      $no = 1;
      foreach ($detailtmp as $d) {
        $tgltransaksi = explode("-", $tgl_pembelian);
        $bulan = $tgltransaksi[1];
        $tahun = $tgltransaksi[0];
        if (strlen($bulan) == 1) {
          $bulan = "0" . $bulan;
        } else {
          $bulan = $bulan;
        }
        $thn = substr($tahun, 2, 2);
        $awal = $tahun . "-" . $bulan . "-01";
        $akhir = $tahun . "-" . $bulan . "-31";
        $qcr = "SELECT kode_cr FROM costratio_biaya WHERE tgl_transaksi BETWEEN '$awal' AND '$akhir' ORDER BY kode_cr DESC LIMIT 1 ";
        $ceknolast = $this->db->query($qcr)->row_array();
        $nobuktilast = $ceknolast['kode_cr'];
        $kodecr = buatkode($nobuktilast, "CR" . $bulan . $thn, 4);

        $datacr = [
          'kode_cr' => $kodecr,
          'tgl_transaksi' => $tgl_pembelian,
          'kode_akun'    => $d->kode_akun,
          'keterangan'   => "Pembelian " . $d->nama_barang . "(" . $d->qty . ")",
          'kode_cabang'  => $d->kode_cabang,
          'id_sumber_costratio' => 4,
          'jumlah' => $d->qty * $d->harga + $d->penyesuaian
        ];
        $datadetail = array(
          'nobukti_pembelian' => $nobukti,
          'kode_barang'       => $d->kode_barang,
          'keterangan'        => $d->keterangan,
          'qty'               => $d->qty,
          'harga'             => $d->harga,
          'penyesuaian'       => $d->penyesuaian,
          'status'            => 'PMB',
          'kode_akun'         => $d->kode_akun,
          'no_urut'           => $no,
          'kode_cabang'       => $d->kode_cabang,
          'kode_cr'           => $kodecr
        );
        $simpandetail = $this->db->insert('detail_pembelian', $datadetail);
        if ($simpandetail) {
          if (substr($d->kode_akun, 0, 3) == "6-1" or substr($d->kode_akun, 0, 3) == "6-2") {
            $this->db->insert('costratio_biaya', $datacr);
          }
        }
        $no++;
      }
      $hapus = "DELETE detailpembelian_temp FROM detailpembelian_temp
    WHERE kode_dept = '$departemen' AND id_admin ='$id_user'";
      $this->db->query($hapus);
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Simpan !
      </div>'
      );
      redirect('pembelian');
    }
  }

  function insert_kontrabon()
  {
    $id_user          = $this->session->userdata('id_user');
    $nokontrabon      = $this->input->post('nokontrabon');
    $tgl_kontrabon    = $this->input->post('tgl_kontrabon');
    $supplier         = $this->input->post('kodesupplier');
    $kategori         = $this->input->post('status');
    $nodokumen        = $this->input->post('nodokumen');
    $jenisbayar       = $this->input->post('jenisbayar');
    $data = array(
      'no_kontrabon'       => $nokontrabon,
      'no_dokumen'         => $nodokumen,
      'tgl_kontrabon'      => $tgl_kontrabon,
      'kode_supplier'      => $supplier,
      'kategori'           => $kategori,
      'jenisbayar'         => $jenisbayar,
      'id_admin'           => $id_user
    );

    $simpan = $this->db->insert('kontrabon', $data);
    if ($simpan) {
      $qdetailtmp = "SELECT * FROM detailkontrabon_temp
    WHERE kode_supplier = '$supplier' AND id_admin='$id_user'";
      $detailtmp  =  $this->db->query($qdetailtmp)->result();
      foreach ($detailtmp as $d) {
        $datadetail = array(
          'no_kontrabon'      => $nokontrabon,
          'nobukti_pembelian' => $d->nobukti_pembelian,
          'jmlbayar'          => $d->jmlbayar,
          'keterangan'        => $d->keterangan
        );

        $this->db->insert('detail_kontrabon', $datadetail);
      }
      $hapus = "DELETE FROM detailkontrabon_temp
    WHERE kode_supplier = '$supplier' AND id_admin='$id_user'";
      $this->db->query($hapus);
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Simpan !
      </div>'
      );
      redirect('pembelian/kontrabon');
    }
  }

  function update_kontrabon()
  {
    $nokontrabon   = $this->input->post('nokontrabon');
    $tglkontrabon  = $this->input->post('tgl_kontrabon');
    $data = array(
      'tgl_kontrabon' => $tglkontrabon
    );
    $update = $this->db->update('kontrabon', $data, array('no_kontrabon' => $nokontrabon));
    if ($update) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Update !
      </div>'
      );
      redirectPreviousPage();
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Gagal di Update !
      </div>'
      );
      redirectPreviousPage();
    }
  }
  public function getDataPembelian($rowno, $rowperpage, $nobukti = "", $tgl_pembelian = "", $departemen = "", $ppn = "", $ln = "", $supplier = "", $tunaikredit = "")
  {

    $this->db->select('nobukti_pembelian,tgl_pembelian,tgl_jatuhtempo,ppn,no_fak_pajak,pembelian.kode_supplier,nama_supplier,pembelian.kode_dept,nama_dept,jenistransaksi,ref_tunai,

    (SELECT SUM( IF ( STATUS = "PMB", ((qty*harga)+penyesuaian), 0 ) ) - SUM( IF ( STATUS = "PNJ",(qty*harga), 0 ) ) FROM detail_pembelian dp WHERE dp.nobukti_pembelian = pembelian.nobukti_pembelian  ) as harga,
    (SELECT COUNT(nobukti_pembelian) FROM detail_kontrabon k WHERE k.nobukti_pembelian = pembelian.nobukti_pembelian) as kontrabon,
    (SELECT (SUM(IF(status_dk="K" AND kode_akun="2-1200" OR status_dk="K" AND kode_akun="2-1300" ,(qty*harga),0))-SUM(IF(status_dk="D" AND kode_akun="2-1200" OR status_dk="D" AND kode_akun="2-1300" ,(qty*harga),0))) FROM jurnal_koreksi j WHERE j.nobukti_pembelian = pembelian.nobukti_pembelian GROUP BY j.nobukti_pembelian) as penyesuaian,
    (SELECT SUM(jmlbayar) FROM historibayar_pembelian hb
    INNER JOIN detail_kontrabon on hb.no_kontrabon = detail_kontrabon.no_kontrabon
    WHERE nobukti_pembelian = pembelian.nobukti_pembelian
    GROUP BY nobukti_pembelian) as jmlbayar');
    $this->db->from('pembelian');
    $this->db->join('departemen', 'pembelian.kode_dept = departemen.kode_dept');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->order_by('tgl_pembelian,nobukti_pembelian', 'DESC');
    if ($nobukti != '') {
      $this->db->where('nobukti_pembelian', $nobukti);
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

    if ($tunaikredit != '') {
      $this->db->where('pembelian.jenistransaksi', $tunaikredit);
    }
    // if($ln !="")
    // {
    //   $this->db->where('ROUND(harga*qty)=jmlbayar');
    // }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordPembelianCount($nobukti = "", $tgl_pembelian = "", $departemen = "", $ppn = "", $ln = "", $supplier = "", $tunaikredit = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('pembelian');
    $this->db->join('departemen', 'pembelian.kode_dept = departemen.kode_dept');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->order_by('tgl_pembelian', 'desc');
    if ($nobukti != '') {
      $this->db->where('nobukti_pembelian', $nobukti);
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

    if ($tunaikredit != '') {
      $this->db->where('pembelian.jenistransaksi', $tunaikredit);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function hapuspembelian($nobukti, $ref_tunai = "")
  {

    $hapus = $this->db->delete('pembelian', array('nobukti_pembelian' => $nobukti));
    if ($hapus) {
      $detail      = $this->db->get_where('detail_pembelian', array('nobukti_pembelian' => $nobukti));
      foreach ($detail->result() as $d) {
        $databpb = array(
          'nobukti_pembelian' => NULL
        );
        $this->db->update('detail_bpb', $databpb, array('no_bpb' => $d->no_bpb, 'nobukti_pembelian' => $nobukti));
      }
      $cekdetailcost = $this->db->get_where('detail_pembelian', array('nobukti_pembelian' => $nobukti))->result();
      foreach ($cekdetailcost as $c) {
        $this->db->delete('costratio_biaya', array('kode_cr' => $c->kode_cr));
      }


      $hapusdetail = $this->db->delete('detail_pembelian', array('nobukti_pembelian' => $nobukti));
      if ($hapusdetail) {
        if ($ref_tunai != "") {
          $hapuskontrabon       = $this->db->delete('kontrabon', array('no_kontrabon' => $ref_tunai));
          $hapusdetailkontrabon = $this->db->delete('detail_kontrabon', array('no_kontrabon' => $ref_tunai));
          $hapusbayar           = $this->db->delete('historibayar_pembelian', array('no_kontrabon' => $ref_tunai));
        }
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil di Hapus !
        </div>'
        );
        redirect('pembelian');
      }
    }
  }

  function hapuskontrabon($nokontrabon)
  {
    $hapus = $this->db->delete('kontrabon', array('no_kontrabon' => $nokontrabon));
    if ($hapus) {

      $hapusdetail = $this->db->delete('detail_kontrabon', array('no_kontrabon' => $nokontrabon));
      if ($hapusdetail) {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil di Hapus !
        </div>'
        );
        redirect('pembelian/kontrabon');
      }
    }
  }

  function getKontrabontemp($supplier)
  {
    $id_user = $this->session->userdata('id_user');
    return $this->db->get_where('detailkontrabon_temp', array('id_admin' => $id_user, 'detailkontrabon_temp.kode_supplier' => $supplier));
  }

  public function getDataKontraBon($rowno, $rowperpage, $nokontrabon = "", $tgl_kontrabon = "", $supplier = "", $status = "", $kategori = "")
  {

    $this->db->select('kontrabon.no_kontrabon,no_dokumen,kontrabon.kode_supplier,nama_supplier,jenisbayar,via,
    (SELECT SUM(jmlbayar) FROM detail_kontrabon d WHERE d.no_kontrabon = kontrabon.no_kontrabon) as totalbayar,
    (SELECT COUNT(no_ref) FROM kaskecil_detail k WHERE k.no_ref = kontrabon.no_kontrabon) as cekkk,
    (SELECT COUNT(p.nobukti_pembelian) FROM detail_pembelian  p
    INNER JOIN detail_kontrabon dk ON p.nobukti_pembelian = dk.nobukti_pembelian
    WHERE no_kontrabon = kontrabon.no_kontrabon) as cekdetail,
    (SELECT COUNT(no_ref) FROM ledger_bank l WHERE l.no_ref = kontrabon.no_kontrabon) as cekledger,
    ,tgl_kontrabon,kategori,tglbayar');
    $this->db->from('kontrabon');
    $this->db->join('supplier', 'kontrabon.kode_supplier = supplier.kode_supplier');
    $this->db->join('historibayar_pembelian', 'historibayar_pembelian.no_kontrabon = kontrabon.no_kontrabon', 'left');
    $this->db->order_by('tgl_kontrabon', 'DESC');
    // $this->db->where('left(kontrabon.no_kontrabon,1) !=','T');
    if ($nokontrabon != '') {
      $this->db->where('kontrabon.no_kontrabon', $nokontrabon);
    }
    if ($tgl_kontrabon != '') {
      $this->db->where('tgl_kontrabon', $tgl_kontrabon);
    }
    if ($supplier != '') {
      $this->db->where('kontrabon.kode_supplier', $supplier);
    }

    if ($kategori != '') {
      $this->db->where('kontrabon.kategori', $kategori);
    }
    if ($status != '') {
      if ($status == 1) {
        $this->db->where('tglbayar IS NULL');
      } else {
        $this->db->where('tglbayar !=""');
      }
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordKontraBonCount($nokontrabon = "", $tgl_kontrabon = "", $supplier = "", $status = "", $kategori = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('kontrabon');
    $this->db->join('supplier', 'kontrabon.kode_supplier = supplier.kode_supplier');
    $this->db->join('historibayar_pembelian', 'historibayar_pembelian.no_kontrabon = kontrabon.no_kontrabon', 'left');
    $this->db->order_by('tgl_kontrabon', 'DESC');
    if ($nokontrabon != '') {
      $this->db->where('kontrabon.no_kontrabon', $nokontrabon);
    }
    if ($tgl_kontrabon != '') {
      $this->db->where('tgl_kontrabon', $tgl_kontrabon);
    }

    if ($supplier != '') {
      $this->db->where('kontrabon.kode_supplier', $supplier);
    }

    if ($kategori != '') {
      $this->db->where('kontrabon.kategori', $kategori);
    }

    if ($status != '') {
      if ($status == 1) {
        $this->db->where('tglbayar IS NULL');
      } else {
        $this->db->where('tglbayar !=""');
      }
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function proses_kontrabon()
  {
    $id_user     = $this->session->userdata('id_user');
    $nokontrabon = $this->input->post('nokontrabon');
    $jmlbayar    = $this->input->post('jmlbayar');
    $tglbayar    = $this->input->post('tglbayar');
    $via         = $this->input->post('via');
    $akun        = $this->input->post('kodeakun');
    $pelanggan   = $this->input->post('supplier');
    $keterangan  = $this->input->post('keterangan');
    $cabang      = "PST";
    //Nobukti Ledger
    $tanggal        = explode("-", $tglbayar);
    $tahun          = substr($tanggal[0], 2, 2);
    $qledger        = "SELECT no_bukti FROM ledger_bank WHERE LEFT(no_bukti,7) ='LR$cabang$tahun'ORDER BY no_bukti DESC LIMIT 1 ";
    $ceknolast      = $this->db->query($qledger)->row_array();
    $nobuktilast    = $ceknolast['no_bukti'];
    $no_bukti       = buatkode($nobuktilast, 'LR' . $cabang . $tahun, 4);
    $nobkk          = $this->input->post('nobkk');


    //Getdetailkontrabon
    $nobuktipembelian = "";
    $detailkontrabon  = $this->db->get_where('detail_kontrabon', array('no_kontrabon' => $nokontrabon))->result();
    foreach ($detailkontrabon as $d) {
      $nobuktipembelian .= $d->nobukti_pembelian . " // ";
      if ($via == 'KAS KECIL') {
        $detailpembelian = $this->db->query("SELECT detail_pembelian.kode_barang,nama_barang,((qty*harga)+penyesuaian) as totalharga FROM detail_pembelian
        INNER JOIN master_barang_pembelian ON detail_pembelian.kode_barang = master_barang_pembelian.kode_barang
        WHERE nobukti_pembelian='$d->nobukti_pembelian'")->result();
        foreach ($detailpembelian as $p) {
          $barang[] = "PEMB " . $p->nama_barang;

          $datakk[] = [
            'nobukti' => $nobkk,
            'tgl_kaskecil' => $tglbayar,
            'keterangan' => "PEMB " . $p->nama_barang,
            'jumlah' => $p->totalharga,
            'status_dk' => "D",
            'kode_akun' => "2-1300"
          ];
        }
      }
    }


    // foreach($datakk as $b)
    // {
    //   echo $b['keterangan']."<br>";
    // }

    // die;
    $data = array(
      'no_kontrabon' => $nokontrabon,
      'bayar'        => $jmlbayar,
      'tglbayar'     => $tglbayar,
      'via'          => $via,
      'id_admin'     => $id_user
    );

    $dataledger = array(
      'no_bukti'              => $no_bukti,
      'no_ref'                 => $nokontrabon,
      'pelanggan'             => $pelanggan,
      'bank'                  => $via,
      'tgl_ledger'            => $tglbayar,
      'keterangan'            => $keterangan . " " . $nobuktipembelian,
      'kode_akun'             => $akun,
      'jumlah'                => $jmlbayar,
      'status_dk'             => 'D',
      'status_validasi'       => 1,
      'kategori'              => 'PMB'
    );

    $datakaskecil = [
      'nobukti' => $nobkk,
      'no_ref' => $nokontrabon,
      'tgl_kaskecil' => $tglbayar,
      'keterangan' => $keterangan . " " . $nobuktipembelian,
      'jumlah' => $jmlbayar,
      'status_dk' => "D",
      'kode_cabang' => 'PST',
      'kode_akun' => "2-1300"
    ];
    $simpan = $this->db->insert('historibayar_pembelian', $data);
    if ($simpan) {
      $insertledger = $this->db->insert('ledger_bank', $dataledger);
      if ($insertledger) {
        $success = 0;
        $error = 0;
        // foreach($datakk as $b)
        // {
        //   $datakaskecil = [
        //     'nobukti' => $b['nobukti'],
        //     'no_ref' => $nokontrabon,
        //     'tgl_kaskecil' => $b['tgl_kaskecil'],
        //     'keterangan' => $b['keterangan'],
        //     'jumlah' => $b['jumlah'],
        //     'status_dk' => "D",
        //     'kode_cabang' => 'PST',
        //     'kode_akun' => "2-1300"
        //   ];

        //   $simpankk = $this->db->insert('kaskecil_detail',$datakaskecil);
        //   if($simpankk)
        //   {
        //     $success = $success + 1;

        //   }else{
        //     $error = $error + 1;
        //   }
        // }

        // echo $success."-".$error;
        // die;
        if ($via == 'KAS KECIL') {
          $simpankk = $this->db->insert('kaskecil_detail', $datakaskecil);
          if ($simpankk) {
            $this->session->set_flashdata(
              'msg',
              '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil di Simpan !
            </div>'
            );
            //redirect('pembelian/kontrabonkeuangan');
            redirectPreviousPage();
          } else {
            $this->session->set_flashdata(
              'msg',
              '<div class="alert bg-orange text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info"></i> Data Berhasil di Simpan !,' . $error . ' Data Kas Kecil
            </div>'
            );
            //redirect('pembelian/kontrabonkeuangan');
            redirectPreviousPage();
          }
        } else {
          $this->session->set_flashdata(
            'msg',
            '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil di Simpan !
          </div>'
          );
          //redirect('pembelian/kontrabonkeuangan');
          redirectPreviousPage();
        }
      }
    }
  }


  function hapusbayar($nokontrabon)
  {
    $hapus = $this->db->delete('historibayar_pembelian', array('no_kontrabon' => $nokontrabon));
    if ($hapus) {
      $deleteledger = $this->db->delete('ledger_bank', array('no_ref' => $nokontrabon));
      if ($deleteledger) {
        $hapuskaskecil = $this->db->delete('kaskecil_detail', array('no_ref' => $nokontrabon));
        if ($hapuskaskecil) {
          $this->session->set_flashdata(
            'msg',
            '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil di Hapus !
          </div>'
          );
          redirectPreviousPage();
        }
      }
    }
  }

  function getBank()
  {
    return $this->db->get('master_bank');
  }

  function cetak_pembelian($dari = "", $sampai = "", $dept = "", $supplier = "", $ppn = "")
  {
    if ($dept != "") {
      $dept = "AND pembelian.kode_dept = '" . $dept . "' ";
    }

    if ($supplier != "") {
      $supplier = "AND pembelian.kode_supplier = '" . $supplier . "' ";
    }

    if ($ppn != "") {
      if ($ppn == '1') {
        $ppn = "AND pembelian.ppn = '" . $ppn . "' ";
      } else if ($ppn == '0') {
        $ppn = "AND pembelian.ppn = '" . $ppn . "' ";
      }
    }
    $query = "SELECT detail_pembelian.nobukti_pembelian,tgl_pembelian,pembelian.kode_supplier,nama_supplier,
detail_pembelian.kode_barang,nama_barang,pembelian.kode_dept,nama_dept,detail_pembelian.keterangan,detail_pembelian.ket_penjualan,
detail_pembelian.kode_akun,nama_akun,ppn,qty,harga,penyesuaian,detail_pembelian.status,
date_format(pembelian.date_created, '%d %M %Y %H:%i:%s') as date_created, 
date_format(pembelian.date_updated, '%d %M %Y %H:%i:%s') as date_updated,
date_format(detail_pembelian.date_created, '%d %M %Y %H:%i:%s') as detaildate_created,
date_format(detail_pembelian.date_updated, '%d %M %Y %H:%i:%s') as detaildate_updated
FROM detail_pembelian
INNER JOIN pembelian ON detail_pembelian.nobukti_pembelian = pembelian.nobukti_pembelian
INNER JOIN supplier ON pembelian.kode_supplier = supplier.kode_supplier
INNER JOIN departemen ON pembelian.kode_dept = departemen.kode_dept
INNER JOIN coa ON detail_pembelian.kode_akun = coa.kode_akun
LEFT JOIN master_barang_pembelian ON detail_pembelian.kode_barang = master_barang_pembelian.kode_barang
WHERE tgl_pembelian BETWEEN '$dari' AND '$sampai'"
      . $dept
      . $supplier
      . $ppn . "ORDER BY tgl_pembelian,detail_pembelian.nobukti_pembelian,detail_pembelian.status,no_urut ASC";
    return $this->db->query($query);
  }

  function cetak_pembayaran($dari = "", $sampai = "", $supplier = "")
  {
    if ($supplier != "") {
      $supplier = "AND pembelian.kode_supplier = '" . $supplier . "' ";
    }
    $query = "SELECT detail_kontrabon.no_kontrabon,detail_kontrabon.nobukti_pembelian,nama_supplier,tglbayar,via,date_format(historibayar_pembelian.log, '%d %M %Y %H:%i:%s') as log, date_format(historibayar_pembelian.date_updated, '%d %M %Y %H:%i:%s') as date_updated,
 SUM(IF( via = 'BCA', jmlbayar, 0)) AS bca,
 SUM(IF( via = 'BCA CV', jmlbayar, 0)) AS bca_cv,
 SUM(IF( via = 'BNI', jmlbayar, 0)) AS bni,
 SUM(IF( via = 'BNI CV', jmlbayar, 0)) AS bni_cv,
 SUM(IF( via = 'KAS', jmlbayar, 0)) AS kasbesar,
 SUM(IF( via = 'KAS KECIL', jmlbayar, 0)) AS kaskecil,
 SUM(IF( via = 'BNI MP VALLAS', jmlbayar, 0)) AS permata,
 SUM(IF( via = 'BNI MP', jmlbayar, 0)) AS bni_mp,
 SUM(IF( via = 'BCA MP', jmlbayar, 0)) AS bca_mp,
 SUM(IF( via = 'CASH', jmlbayar, 0)) AS cash,
 SUM(IF( master_bank.kode_cabang != 'PST', jmlbayar, 0)) AS lainlain,
 IFNULL(SUM(jmlbayar),0) as totalbayar
 FROM detail_kontrabon
 INNER JOIN historibayar_pembelian ON detail_kontrabon.no_kontrabon = historibayar_pembelian.no_kontrabon
 INNER JOIN pembelian ON detail_kontrabon.nobukti_pembelian = pembelian.nobukti_pembelian
 INNER JOIN supplier ON pembelian.kode_supplier = supplier.kode_supplier
 INNER JOIN master_bank ON historibayar_pembelian.via = master_bank.kode_bank
 WHERE tglbayar BETWEEN '$dari' AND '$sampai'"
      . $supplier .
      "GROUP BY detail_kontrabon.no_kontrabon,detail_kontrabon.nobukti_pembelian,tglbayar,nama_supplier";
    return $this->db->query($query);
  }

  function cetak_supplier($dari = "", $sampai = "")
  {
    $this->db->select('pembelian.kode_supplier,nama_supplier,
   (SUM( IF ( STATUS = "PMB", ((qty*harga)+penyesuaian), 0 ) )) as jumlah');
    $this->db->from('detail_pembelian');
    $this->db->join('pembelian', 'detail_pembelian.nobukti_pembelian = pembelian.nobukti_pembelian');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->where('tgl_pembelian >=', $dari);
    $this->db->where('tgl_pembelian <=', $sampai);
    $this->db->group_by('pembelian.kode_supplier,nama_supplier');
    return $this->db->get();
  }

  function cetak_rekappembelian($dari = "", $sampai = "", $jenis = "")
  {

    if ($jenis != "") {
      $jenis = "AND jenis_barang = '" . $jenis . "' ";
    }
    $query = "SELECT detail_pembelian.nobukti_pembelian,tgl_pembelian,pembelian.kode_supplier,nama_supplier,
 detail_pembelian.kode_barang,nama_barang,pembelian.kode_dept,nama_dept,detail_pembelian.keterangan,
 detail_pembelian.kode_akun,nama_akun,ppn,qty,harga,penyesuaian
 FROM detail_pembelian
 INNER JOIN pembelian ON detail_pembelian.nobukti_pembelian = pembelian.nobukti_pembelian
 INNER JOIN supplier ON pembelian.kode_supplier = supplier.kode_supplier
 INNER JOIN departemen ON pembelian.kode_dept = departemen.kode_dept
 INNER JOIN coa ON detail_pembelian.kode_akun = coa.kode_akun
 INNER JOIN master_barang_pembelian ON detail_pembelian.kode_barang = master_barang_pembelian.kode_barang
 WHERE tgl_pembelian BETWEEN '$dari' AND '$sampai'"
      . $jenis . "ORDER BY pembelian.kode_supplier";
    return $this->db->query($query);
  }

  function cetak_rekapperakun($dari = "", $sampai = "")
  {

    $query = "SELECT detail_pembelian.kode_akun AS kode_akun,jk.jurnaldebet,jk.jurnalkredit,coa.nama_akun,status,SUM((qty*harga)+penyesuaian) as total
  FROM detail_pembelian
  INNER JOIN pembelian ON pembelian.nobukti_pembelian=detail_pembelian.nobukti_pembelian
  LEFT JOIN coa ON coa.kode_akun=detail_pembelian.kode_akun
  LEFT JOIN(SELECT kode_akun,
    SUM(IF(status_dk='D',(jurnal_koreksi.qty*jurnal_koreksi.harga),0)) as jurnaldebet,
    SUM(IF(status_dk='K',(jurnal_koreksi.qty*jurnal_koreksi.harga),0)) as jurnalkredit 
    FROM jurnal_koreksi 
    WHERE tgl_jurnalkoreksi BETWEEN '$dari' AND '$sampai'
    GROUP BY kode_akun
    ) jk ON (detail_pembelian.kode_akun = jk.kode_akun)
  WHERE pembelian.tgl_pembelian BETWEEN '$dari' AND '$sampai'
  GROUP BY
  detail_pembelian.kode_akun,jk.jurnaldebet,jk.jurnalkredit,coa.nama_akun,status
  ORDER BY
  detail_pembelian.kode_akun
  ASC
  ";
    return $this->db->query($query);
  }

  function cetak_bahankemasan($dari = "", $sampai = "", $jenis = "")
  {

    if ($jenis == "BAHAN") {
      $jenis = "AND jenis_barang = 'BAHAN BAKU' OR tgl_pembelian BETWEEN '$dari' AND '$sampai' AND jenis_barang ='BAHAN TAMBAHAN'";
    } else if ($jenis == "KEMASAN") {
      $jenis = "AND jenis_barang = 'KEMASAN'";
    } else {
      $jenis = "AND jenis_barang = 'BAHAN BAKU' OR tgl_pembelian BETWEEN '$dari' AND '$sampai' AND jenis_barang ='BAHAN TAMBAHAN' OR tgl_pembelian BETWEEN '$dari' AND '$sampai' AND jenis_barang ='KEMASAN' ";
    }
    $query = "SELECT
detail_pembelian.kode_barang,satuan,nama_barang,jenis_barang,SUM(qty) as totalqty,SUM((qty*harga)+penyesuaian) as totalharga
FROM detail_pembelian
INNER JOIN pembelian ON detail_pembelian.nobukti_pembelian = pembelian.nobukti_pembelian
INNER JOIN supplier ON pembelian.kode_supplier = supplier.kode_supplier
INNER JOIN departemen ON pembelian.kode_dept = departemen.kode_dept
INNER JOIN coa ON detail_pembelian.kode_akun = coa.kode_akun
INNER JOIN master_barang_pembelian ON detail_pembelian.kode_barang = master_barang_pembelian.kode_barang
WHERE tgl_pembelian BETWEEN '$dari' AND '$sampai'"
      . $jenis . "  GROUP BY detail_pembelian.kode_barang,nama_barang,jenis_barang";
    return $this->db->query($query);
  }

  function cetak_kartuhutang($dari = "", $sampai = "", $supplier = "", $jenis = "")
  {
    if ($jenis != "") {
      $jenis = "AND pembelian.kode_akun = '" . $jenis . "' ";
    }

    if ($supplier != "") {
      $supplier = "AND pembelian.kode_supplier = '" . $supplier . "' ";
    }

    $query = "SELECT pembelian.nobukti_pembelian,tgl_pembelian,nama_supplier,pembelian.kode_akun,nama_akun,(IFNULL(IFNULL(totalhutang,0) + IFNULL(penyesuaianbulanlalu,0)+ IFNULL(penyesuaianbulanini,0),0))   as totalhutang,
    (IFNULL(IFNULL(totalhutang,0) + IFNULL(penyesuaianbulanlalu,0) - IFNULL(jmlbayarbulanlalu,0) ,0))   as sisapiutang,
    IFNULL(jmlbayarbulanlalu,0) as jmlbayarbulanlalu, IFNULL(jmlbayarbulanini,0) as jmlbayarbulanini,IFNULL(penyesuaianbulanlalu,0) as penyesuaianbulanlalu,IFNULL(penyesuaianbulanini,0) as penyesuaianbulanini ,pmbbulanini
    FROM pembelian
    INNER JOIN supplier ON pembelian.kode_supplier = supplier.kode_supplier
    INNER JOIN coa ON pembelian.kode_akun = coa.kode_akun
    LEFT JOIN (
      SELECT detail_pembelian.nobukti_pembelian, (SUM( IF ( STATUS = 'PMB', ((qty*harga)+penyesuaian), 0 ) ) - SUM( IF ( STATUS = 'PNJ',(qty*harga), 0 ) ) ) as totalhutang
      ,IF(tgl_pembelian BETWEEN '$dari' AND '$sampai',(SUM( IF ( STATUS = 'PMB', ((qty*harga)+penyesuaian), 0 ) ) - SUM( IF ( STATUS = 'PNJ',(qty*harga), 0 ) ) ),0) as pmbbulanini
      FROM detail_pembelian
      INNER JOIN pembelian ON detail_pembelian.nobukti_pembelian = pembelian.nobukti_pembelian
      GROUP BY nobukti_pembelian
    ) detail_pembelian ON (pembelian.nobukti_pembelian  = detail_pembelian.nobukti_pembelian)

    LEFT JOIN (
      SELECT nobukti_pembelian,SUM(IF(tglbayar<'$dari',jmlbayar,0)) as jmlbayarbulanlalu,
      SUM(IF(tglbayar BETWEEN '$dari' AND '$sampai',jmlbayar,0)) as jmlbayarbulanini
      FROM historibayar_pembelian hb
      INNER JOIN detail_kontrabon on hb.no_kontrabon = detail_kontrabon.no_kontrabon
      GROUP BY nobukti_pembelian
    ) hb ON hb.nobukti_pembelian = pembelian.nobukti_pembelian

    LEFT JOIN (
    SELECT nobukti_pembelian,(SUM(IF(tgl_jurnalkoreksi<'$dari' AND status_dk='K' AND kode_akun='2-1200'
    OR tgl_jurnalkoreksi<'$dari' AND status_dk='K' AND kode_akun='2-1300' ,(qty*harga),0)) - SUM(IF(tgl_jurnalkoreksi<'$dari' AND status_dk='D' AND kode_akun='2-1200'
    OR tgl_jurnalkoreksi<'$dari' AND status_dk='D' AND kode_akun='2-1300' ,(qty*harga),0))) as penyesuaianbulanlalu,
    (SUM(IF(tgl_jurnalkoreksi BETWEEN '$dari' AND '$sampai'  AND status_dk='K' AND kode_akun='2-1200'
    OR tgl_jurnalkoreksi BETWEEN '$dari' AND '$sampai'  AND status_dk='K' AND kode_akun='2-1300'  ,(qty*harga),0))-SUM(IF(tgl_jurnalkoreksi BETWEEN '$dari' AND '$sampai'  AND status_dk='D' AND kode_akun='2-1200'
    OR tgl_jurnalkoreksi BETWEEN '$dari' AND '$sampai'  AND status_dk='D' AND kode_akun='2-1300'  ,(qty*harga),0))) as penyesuaianbulanini
    FROM jurnal_koreksi jk
    GROUP BY nobukti_pembelian
    ) jk ON (jk.nobukti_pembelian = pembelian.nobukti_pembelian)
    WHERE tgl_pembelian <= '$sampai' AND (IFNULL(IFNULL(totalhutang,0) + IFNULL(penyesuaianbulanlalu,0) - IFNULL(jmlbayarbulanlalu,0) ,0))  != 0 "
      . $supplier
      . $jenis
      . "  OR tgl_pembelian <= '$sampai' AND jmlbayarbulanini != 0 "
      . $supplier
      . $jenis
      . "
    ORDER BY tgl_pembelian,pembelian.nobukti_pembelian ASC

    ";
    return $this->db->query($query);
  }

  function cetak_auh($sampai = "")
  {
    $query = "SELECT * FROM
    (SELECT detail_pembelian.nobukti_pembelian,pembelian.kode_supplier,nama_supplier,
    (SUM( IF ( STATUS = 'PMB', ((qty*harga)+penyesuaian), 0 ) ) - SUM( IF ( STATUS = 'PNJ',(qty*harga), 0 ) ) )-IFNULL(jmlbayar,0)+IFNULL(jmlpenyesuaian,0) as sisahutang,
    CASE
    WHEN  datediff('$sampai', tgl_pembelian) < 30  THEN
    (SUM( IF ( STATUS = 'PMB', ((qty*harga)+penyesuaian), 0 ) ) - SUM( IF ( STATUS = 'PNJ',(qty*harga), 0 ) ) )-IFNULL(jmlbayar,0)+IFNULL(jmlpenyesuaian,0) END as bulanberjalan,
    CASE
    WHEN datediff('$sampai', tgl_pembelian) < 60 AND datediff('$sampai', tgl_pembelian) >= 30  THEN
    (SUM( IF ( STATUS = 'PMB', ((qty*harga)+penyesuaian), 0 ) ) - SUM( IF ( STATUS = 'PNJ',(qty*harga), 0 ) ) )-IFNULL(jmlbayar,0)+IFNULL(jmlpenyesuaian,0) END as satubulan,
    CASE
    WHEN datediff('$sampai', tgl_pembelian) < 90 AND datediff('$sampai', tgl_pembelian) >= 60  THEN
    (SUM( IF ( STATUS = 'PMB', ((qty*harga)+penyesuaian), 0 ) ) - SUM( IF ( STATUS = 'PNJ',(qty*harga), 0 ) ) )-IFNULL(jmlbayar,0)+IFNULL(jmlpenyesuaian,0) END as duabulan,
    CASE
    WHEN datediff('$sampai', tgl_pembelian) >= 90  THEN
    (SUM( IF ( STATUS = 'PMB', ((qty*harga)+penyesuaian), 0 ) ) - SUM( IF ( STATUS = 'PNJ',(qty*harga), 0 ) ) )-IFNULL(jmlbayar,0)+IFNULL(jmlpenyesuaian,0) END as lebihtigabulan
    FROM detail_pembelian
    INNER JOIN pembelian ON detail_pembelian.nobukti_pembelian = pembelian.nobukti_pembelian
    INNER JOIN supplier ON pembelian.kode_supplier = supplier.kode_supplier
    LEFT JOIN (
    SELECT nobukti_pembelian,SUM(IF(tglbayar<='$sampai',jmlbayar,0)) as jmlbayar
    FROM historibayar_pembelian hb
    INNER JOIN detail_kontrabon on hb.no_kontrabon = detail_kontrabon.no_kontrabon
    GROUP BY nobukti_pembelian
    ) hb ON hb.nobukti_pembelian = detail_pembelian.nobukti_pembelian
    LEFT JOIN (
    SELECT nobukti_pembelian,(SUM(IF(tgl_jurnalkoreksi<'$sampai' AND status_dk='K' AND kode_akun='2-1200'
    OR tgl_jurnalkoreksi<'$sampai' AND status_dk='K' AND kode_akun='2-1300' ,(qty*harga),0)) - SUM(IF(tgl_jurnalkoreksi<'$sampai' AND status_dk='D' AND kode_akun='2-1200'
    OR tgl_jurnalkoreksi<'$sampai' AND status_dk='D' AND kode_akun='2-1300' ,(qty*harga),0)))  as jmlpenyesuaian
    FROM jurnal_koreksi jk
    GROUP BY nobukti_pembelian
    ) jk ON jk.nobukti_pembelian = detail_pembelian.nobukti_pembelian
    WHERE tgl_pembelian <='$sampai'
    GROUP BY detail_pembelian.nobukti_pembelian
    ORDER BY pembelian.kode_supplier ASC
  ) as kp WHERE sisahutang !=0";

    return $this->db->query($query);
  }

  function getBayarKB($nokontrabon = "", $nobukti = "")
  {
    return $this->db->get_where('detail_kontrabon', array('no_kontrabon' => $nokontrabon, 'nobukti_pembelian' => $nobukti));
  }

  function updatedetailkb()
  {
    $nokontrabon  = $this->input->post('nokontrabon');
    $nobukti      = $this->input->post('nobukti');
    $jmlbayar     = str_replace(".", "", $this->input->post('jmlbayar'));
    $jmlbayar     = str_replace(",", ".", $jmlbayar);
    $no_kontrabon = str_replace("/", ".", $nokontrabon);
    $data = array(
      'jmlbayar'  => $jmlbayar
    );

    $simpan = $this->db->update('detail_kontrabon', $data, array('no_kontrabon' => $nokontrabon, 'nobukti_pembelian' => $nobukti));
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Simpan !
      </div>'
      );
      redirectPreviousPage();
    }
  }

  function update_fakturpajak()
  {
    $nobukti = $this->input->post('nobukti');
    $nopajak = $this->input->post('nopajak');

    $data = array(
      'no_fak_pajak' => $nopajak
    );

    $update = $this->db->update('pembelian', $data, array('nobukti_pembelian' => $nobukti));
    if ($update) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Update !
      </div>'
      );
      redirect('pembelian');
    }
  }

  function update_pembelian()
  {
    $id_user          = $this->session->userdata('id_user');
    $nobukti          = $this->input->post('nobukti');
    $nobuktinew       = $this->input->post('nobuktinew');
    $tgl_pembelian    = $this->input->post('tgl_pembelian');
    $supplier         = $this->input->post('kodesupplier');
    $departemen       = $this->input->post('departemen');
    $tgl_jatuhtempo   = $this->input->post('jatuhtempo');
    $jenistransaksi   = $this->input->post('jenistransaksi');
    $jtold            = $this->input->post('jtold');
    $arr = array(".", ",");
    $grandtotold      = $this->input->post('grandtotold');
    $grandtotnew      = $this->input->post('grandtotnew');
    $totold           = str_replace($arr, "", $grandtotold);
    $totnew           = str_replace($arr, "", $grandtotnew);
    // echo $grandtotold;
    // echo "<br>";
    // echo $grandtotnew;
    // echo "<br>";
    // $arr = array(".", ",");
    // echo str_replace($arr, "", $grandtotold);
    // echo "<br>";
    // echo str_replace($arr, "", $grandtotnew);
    // die;

    //echo $jenistransaksi . " - " . $jtold;
    // die;

    $t                = explode("-", $tgl_pembelian);
    $tgl              = $t[2] . $t[1] . $t[0];
    $rand             = rand(10, 100);
    $nokontrabon      = "T" . $tgl . $rand;
    if ($departemen != "GDB") {
      $kodeakun     = "2-1300";
    } else {
      $kodeakun     = "2-1200";
    }
    $ppn             = $this->input->post('ppn');
    if (empty($ppn)) {
      $p = 0;
    } else {
      $p = 1;
    }

    echo strlen($jtold);
    echo "<br>";
    echo strlen($jenistransaksi);
    echo "<br>";
    if ($jtold == 'kredit' and $jenistransaksi == 'tunai' or $jtold == 'tunai' and $jenistransaksi == 'tunai' and $totold != $totnew) {
      echo "Perintah 1";
      $ref = $nokontrabon;
    } else {
      echo "Perintah 2";
      $ref = "";
    }
    echo "<br>";
    $nokontrabon;

    $data = array(
      'nobukti_pembelian'  => $nobuktinew,
      'tgl_pembelian'      => $tgl_pembelian,
      'kode_supplier'      => $supplier,
      'kode_dept'          => $departemen,
      'kode_akun'          => $kodeakun,
      'ppn'                => $p,
      'tgl_jatuhtempo'     => $tgl_jatuhtempo,
      'jenistransaksi'     => $jenistransaksi,
      'ref_tunai'          => $ref,
      'id_admin'           => $id_user
    );

    $datadetail = array(
      'nobukti_pembelian' => $nobuktinew
    );

    $update = $this->db->update('pembelian', $data, array('nobukti_pembelian' => $nobukti));
    $updatedetail = $this->db->update('detail_pembelian', $datadetail, array('nobukti_pembelian' => $nobukti));
    if ($update) {
      if ($jtold == 'kredit' and $jenistransaksi == 'tunai' or $jtold == "tunai" and $jenistransaksi == "tunai" and $totold != $totnew) {
        echo "Perintah 1";
        $kontrabon = $this->db->query("SELECT * FROM detail_kontrabon WHERE nobukti_pembelian ='$nobukti'")->result();
        foreach ($kontrabon as $k) {
          $nokontrabon = $k->no_kontrabon;
          $hapusdetailkb = $this->db->delete('detail_kontrabon', array('nobukti_pembelian' => $nobukti, 'no_kontrabon' => $nokontrabon));
          $cekdetailkb = $this->db->get_where('detail_kontrabon', array('no_kontrabon' => $nokontrabon))->num_rows();
          if ($hapusdetailkb) {
            if (empty($cekdetailkb)) {
              $hapuskontrabon = $this->db->delete('kontrabon', array('no_kontrabon' => $nokontrabon));
            }
          }
        }
        $data = array(
          'no_kontrabon'       => $ref,
          'tgl_kontrabon'      => $tgl_pembelian,
          'kode_supplier'      => $supplier,
          'kategori'           => 'TN',
          'id_admin'           => $id_user,
          'jenisbayar'         => 'tunai'
        );

        $simpankontrabon = $this->db->insert('kontrabon', $data);
        if ($simpankontrabon) {
          $jmlbayar = "SELECT SUM( IF ( STATUS = 'PMB', ((qty*harga)+penyesuaian), 0 ) ) - SUM( IF ( STATUS = 'PNJ',(qty*harga), 0 ) )  as jmlbayar FROM detail_pembelian WHERE nobukti_pembelian = '$nobukti'";
          $jmbayar  = $this->db->query($jmlbayar)->row_array();
          $datakb = array(
            'no_kontrabon'        => $ref,
            'nobukti_pembelian'   => $nobukti,
            'jmlbayar'            => $jmbayar['jmlbayar'],
            'keterangan'          => 'tunai'
          );

          // $databayar = array(
          //   'no_kontrabon' => $nokontrabon,
          //   'tglbayar'    => $tgl_pembelian,
          //   'bayar'        => $jmbayar['jmlbayar'],
          //   'id_admin'     => $id_user,
          //   'via'          => 'KAS'
          // );

          $this->db->insert('detail_kontrabon', $datakb);
          // $this->db->insert('historibayar_pembelian',$databayar);
        }
      } else if ($jtold == 'tunai' and $jenistransaksi == 'kredit') {
        echo "Perintah 2";
        $kontrabon = $this->db->query("SELECT * FROM detail_kontrabon WHERE nobukti_pembelian ='$nobukti'")->result();
        foreach ($kontrabon as $k) {
          $nokontrabon = $k->no_kontrabon;
          $hapusdetailkb = $this->db->delete('detail_kontrabon', array('nobukti_pembelian' => $nobukti, 'no_kontrabon' => $nokontrabon));
          $cekdetailkb = $this->db->get_where('detail_kontrabon', array('no_kontrabon' => $nokontrabon))->num_rows();
          if ($hapusdetailkb) {
            if (empty($cekdetailkb)) {
              $hapuskontrabon = $this->db->delete('kontrabon', array('no_kontrabon' => $nokontrabon));
            }
          }
        }
      } else {
        echo "Perintah 3";
        $kontrabon = $this->db->query("SELECT * FROM detail_kontrabon WHERE nobukti_pembelian ='$nobukti'")->result();
        foreach ($kontrabon as $k) {
          $nokontrabon = $k->no_kontrabon;
          $updatekb = $this->db->update('detail_kontrabon', $datadetail, array('nobukti_pembelian' => $nobukti, 'no_kontrabon' => $nokontrabon));
        }
      }
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Simpan !
      </div>'
      );

      redirect('pembelian');
    }
  }

  function hapus_detailpembelian()
  {

    $nobukti    = $this->input->post('nobukti');
    $kodebarang = $this->input->post('kodebarang');
    $keterangan = $this->input->post('keterangan');
    $kodecr = $this->input->post('kodecr');
    // return $keterangan;
    // die;
    $data = array(
      'nobukti_pembelian' => NULL
    );
    $hapus = $this->db->delete('detail_pembelian', array('kode_barang' => $kodebarang, 'nobukti_pembelian' => $nobukti, 'keterangan' => $keterangan));
    if ($hapus) {
      $this->db->delete('costratio_biaya', array('kode_cr' => $kodecr));
      $this->db->update('detail_bpb', $data, array('no_bpb' => $nobukti));
    }
  }

  function insertdetailpembelian()
  {

    $kodebarang   = $this->input->post('kodebarang');
    $harga        = str_replace(".", "", $this->input->post('harga'));
    $harga        = str_replace(",", ".", $harga);
    $jumlah       = $this->input->post('jumlah');
    $kodeakun     = $this->input->post('kodeakun');
    $keterangan   = $this->input->post('keterangan');
    $nobukti      = $this->input->post('nobukti');
    $penyharga    = str_replace(".", "", $this->input->post('penyharga'));
    $penyharga    = str_replace(",", ".", $penyharga);
    $data = array(
      'nobukti_pembelian' => $nobukti,
      'kode_barang'       => $kodebarang,
      'harga'             => $harga,
      'qty'               => $jumlah,
      'penyesuaian'       => $penyharga,
      'keterangan'        => $keterangan,
      'status'            => 'PMB',
      'kode_akun'         => $kodeakun,
    );
    $this->db->insert('detail_pembelian', $data);
    // $cek  = $this->db->get_where('detail_pembelian', array('kode_barang' => $kodebarang, 'nobukti_pembelian' => $nobukti))->num_rows();
    // if (!empty($cek)) {
    //   echo "1";
    // } else {
    //   $this->db->insert('detail_pembelian', $data);
    // }
  }

  function update_pemesanan()
  {
    $nobpb = $this->input->post('nobpb');
    $tgl_pemesanan = $this->input->post('tgl_pemesanan');
    if (!empty($tgl_pemesanan)) {
      $tgl = $tgl_pemesanan;
    } else {
      $tgl = NULL;
    }
    $data = array(
      'tgl_pemesanan' => $tgl
    );

    $update = $this->db->update('bpb', $data, array('no_bpb' => $nobpb));
    if ($update) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Update !
      </div>'
      );
      redirect('pembelian/permintaanbarang');
    }
  }

  function listBarang()
  {
    return $this->db->get('master_barang_pembelian');
  }

  function cetak_bankharga($dari, $sampai, $barang)
  {
    $this->db->select('tgl_pembelian,detail_pembelian.kode_barang,nama_barang,nama_supplier,harga');
    $this->db->from('detail_pembelian');
    $this->db->join('master_barang_pembelian', 'detail_pembelian.kode_barang = master_barang_pembelian.kode_barang');
    $this->db->join('pembelian', 'detail_pembelian.nobukti_pembelian = pembelian.nobukti_pembelian');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->where('tgl_pembelian >=', $dari);
    $this->db->where('tgl_pembelian <=', $sampai);
    $this->db->where('detail_pembelian.kode_barang', $barang);
    $this->db->order_by('tgl_pembelian', 'asc');
    return $this->db->get();
  }

  function insert_penjualan()
  {
    $nobukti    = $this->input->post('nobukti');
    $keterangan = $this->input->post('keterangan');
    $qty        = $this->input->post('qty');
    $harga      = str_replace(".", "", $this->input->post('harga'));
    $kodeakun   = $this->input->post('akunpenj');
    $unique     = rand(10, 100);
    $session    = date('ymd') . $unique;
    $jenistransaksi = $this->input->post('jenistransaksi');

    $data = array(
      'nobukti_pembelian' => $nobukti,
      'ket_penjualan'     => $keterangan,
      'qty'               => $qty,
      'harga'             => $harga,
      'kode_akun'         => $kodeakun,
      'kode_barang'       => 'PNJKR',
      'status'            => 'PNJ'
    );

    $simpan = $this->db->insert('detail_pembelian', $data);
    if ($simpan) {
      if ($jenistransaksi == 'TUNAI') {
        $pmb = $this->db->get_where('pembelian', array('nobukti_pembelian' => $nobukti))->row_array();
        $nokontrabon = $pmb['ref_tunai'];
        $detailpmb = $this->db->query("SELECT (SUM( IF ( STATUS = 'PMB', ((qty*harga)+penyesuaian), 0 ) ) - SUM( IF ( STATUS = 'PNJ',(qty*harga), 0 ) )) as totalpembelian FROM detail_pembelian WHERE nobukti_pembelian = '$nobukti'")->row_array();
        $datakontrabon = [
          'jmlbayar' => $detailpmb['totalpembelian']
        ];
        $updatekontrabon = $this->db->update('detail_kontrabon', $datakontrabon, array('no_kontrabon' => $nokontrabon));
      }
    }
  }

  // function loaddatapenjualan($nobukti)
  // {
  //   return $this->db->get_where('detail_penjualan_pmb',array('nobukti_pembelian'=>$nobukti));
  // }

  function loaddatapenjualan($nobukti)
  {
    return $this->db->get_where('detail_pembelian', array('nobukti_pembelian' => $nobukti, 'status' => 'PNJ'));
  }

  // function hapus_detailpenjpmb()
  // {
  //   $nobukti    = $this->input->post('nobukti');
  //   $session    = $this->input->post('session');
  //   $hapus = $this->db->delete('detail_penjualan_pmb',array('nobukti_pembelian'=>$nobukti,'session'=>$session));
  // }

  function hapus_detailpenjpmb()
  {
    $nobukti       = $this->input->post('nobukti');
    $kodebarang    = $this->input->post('kodebarang');
    $hapus = $this->db->delete('detail_pembelian', array('nobukti_pembelian' => $nobukti, 'kode_barang' => $kodebarang));
  }

  public function getDataJatuhtempo($rowno, $rowperpage, $nobukti = "", $dari = "", $sampai = "", $departemen = "")
  {
    $this->db->select('nobukti_pembelian,tgl_pembelian,tgl_jatuhtempo,ppn,no_fak_pajak,pembelian.kode_supplier,nama_supplier,pembelian.kode_dept,nama_dept,
    (SELECT SUM( IF ( STATUS = "PMB", (qty*harga), 0 ) ) - SUM( IF ( STATUS = "PNJ",(qty*harga), 0 ) ) FROM detail_pembelian dp WHERE dp.nobukti_pembelian = pembelian.nobukti_pembelian) as harga,
    (SELECT COUNT(nobukti_pembelian) FROM detail_kontrabon k WHERE k.nobukti_pembelian = pembelian.nobukti_pembelian) as kontrabon,
    (SELECT SUM(jmlbayar) FROM historibayar_pembelian hb
    INNER JOIN detail_kontrabon on hb.no_kontrabon = detail_kontrabon.no_kontrabon
    WHERE nobukti_pembelian = pembelian.nobukti_pembelian
    GROUP BY nobukti_pembelian) as jmlbayar');
    $this->db->from('pembelian');
    $this->db->join('departemen', 'pembelian.kode_dept = departemen.kode_dept');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->order_by('tgl_pembelian', 'DESC');
    if ($nobukti != '') {
      $this->db->where('nobukti_pembelian', $nobukti);
    }
    if ($dari != '') {
      $this->db->where('tgl_jatuhtempo >=', $dari);
    }
    if ($sampai != '') {
      $this->db->where('tgl_jatuhtempo <=', $sampai);
    }

    if ($departemen != '') {
      $this->db->where('pembelian.kode_dept', $departemen);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordJatuhtempoCount($nobukti = "", $dari = "", $sampai = "", $departemen = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('pembelian');
    $this->db->join('departemen', 'pembelian.kode_dept = departemen.kode_dept');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->order_by('tgl_pembelian', 'desc');
    if ($dari != '') {
      $this->db->where('tgl_jatuhtempo >=', $dari);
    }
    if ($sampai != '') {
      $this->db->where('tgl_jatuhtempo <=', $sampai);
    }
    if ($departemen != '') {
      $this->db->where('pembelian.kode_dept', $departemen);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  //   function getPMBKB($nobukti)
  //   {
  //     $query =
  //       "SELECT * FROM (
  //   SELECT nobukti_pembelian,tgl_pembelian,ppn,
  //   (SELECT ROUND(SUM( harga * qty )) FROM detail_pembelian d WHERE d.nobukti_pembelian = pembelian.nobukti_pembelian ) as harga,
  //   pembelian.kode_supplier,nama_supplier,pembelian.kode_dept,nama_dept,
  //   (SELECT SUM(jmlbayar)  FROM historibayar_pembelian hb
  //   INNER JOIN detail_kontrabon on hb.no_kontrabon = detail_kontrabon.no_kontrabon
  //   WHERE nobukti_pembelian = pembelian.nobukti_pembelian
  //   GROUP BY nobukti_pembelian) as jmlbayar
  //   FROM pembelian
  //   INNER JOIN departemen ON pembelian.kode_dept = departemen.kode_dept
  //   INNER JOIN supplier ON pembelian.kode_supplier = supplier.kode_supplier
  // ) as pmb WHERE pmb.nobukti_pembelian = '$nobukti'";
  //     return $this->db->query($query);
  //   }

  function getPMBKB($nobukti)
  {
    return $this->db->get_where('pembelian', array('nobukti_pembelian', $nobukti));
  }
  function getjmldatapmb()
  {
    $id_admin  = $this->session->userdata('id_admin');
    return $this->db->get_where('detailpembelian_temp', array('id_admin'));
  }

  public function getDataDOToko($rowno, $rowperpage, $nodo, $tgl_do, $departemen, $supplier)
  {

    $this->db->select('no_do,tgl_do,do.kode_supplier,nama_supplier,kode_dept,id_admin');
    $this->db->from('do');
    $this->db->join('supplier', 'do.kode_supplier = supplier.kode_supplier');
    if ($nodo != "") {
      $this->db->where('no_do', $nodo);
    }

    if ($tgl_do != "") {
      $this->db->where('tgl_do', $tgl_do);
    }

    if ($departemen != "") {
      $this->db->where('do.kode_dept', $departemen);
    }

    if ($supplier != "") {
      $this->db->where('do.kode_supplier', $supplier);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordDOToko($nodo, $tgl_do, $departemen, $supplier)
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('do');
    $this->db->join('supplier', 'do.kode_supplier = supplier.kode_supplier');
    if ($nodo != "") {
      $this->db->where('no_do', $nodo);
    }

    if ($tgl_do != "") {
      $this->db->where('tgl_do', $tgl_do);
    }

    if ($departemen != "") {
      $this->db->where('do.kode_dept', $departemen);
    }

    if ($supplier != "") {
      $this->db->where('do.kode_supplier', $supplier);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function getDOdetailtemp($departemen)
  {
    $id_user = $this->session->userdata('id_user');
    $this->db->select('do_detailtemp.no_bpb, tgl_permintaan,do_detailtemp.kode_barang,nama_barang,keterangan,qty,do_detailtemp.id_admin');
    $this->db->join('master_barang_pembelian', 'do_detailtemp.kode_barang = master_barang_pembelian.kode_barang');
    $this->db->join('detail_bpb', 'do_detailtemp.no_bpb = detail_bpb.no_bpb AND do_detailtemp.kode_barang = detail_bpb.kode_barang');
    $this->db->join('bpb', 'detail_bpb.no_bpb = bpb.no_bpb');
    return $this->db->get_where('do_detailtemp', array('do_detailtemp.id_admin' => $id_user, 'do_detailtemp.kode_dept' => $departemen));
  }

  function insertdetaildotemp()
  {
    $id_user      = $this->session->userdata('id_user');
    $nobpb        = $this->input->post('nobpb');
    $kodebarang   = $this->input->post('kodebarang');
    $kodedept     = $this->input->post('kodedept');
    $jumlah       = $this->input->post('jumlah');
    $data = array(
      'no_bpb'        => $nobpb,
      'kode_barang'   => $kodebarang,
      'kode_dept'     => $kodedept,
      'qty'           => $jumlah,
      'id_admin'      => $id_user
    );
    $cek  = $this->db->get_where('do_detailtemp', array('no_bpb' => $nobpb, 'kode_barang' => $kodebarang, 'id_admin' => $id_user))->num_rows();
    if (!empty($cek)) {
      echo "1";
    } else {
      $this->db->insert('do_detailtemp', $data);
    }
  }

  function hapus_detaildo_temp()
  {
    $nobpb       = $this->input->post('nobpb');
    $kodebarang  = $this->input->post('kodebarang');
    $idadmin     = $this->input->post('idadmin');
    $this->db->delete('do_detailtemp', array('no_bpb' => $nobpb, 'kode_barang' => $kodebarang, 'id_admin' => $idadmin));
  }


  function insert_dotoko()
  {
    $id_user          = $this->session->userdata('id_user');
    $nodo             = $this->input->post('nodo');
    $tgl_do           = $this->input->post('tgl_do');
    $supplier         = $this->input->post('kodesupplier');
    $departemen       = $this->input->post('departemen');

    $data = array(
      'no_do'              => $nodo,
      'tgl_do'             => $tgl_do,
      'kode_supplier'      => $supplier,
      'kode_dept'          => $departemen,
      'id_admin'           => $id_user
    );

    $simpan = $this->db->insert('do', $data);
    if ($simpan) {

      $qdetailtmp = "SELECT * FROM do_detailtemp
    INNER JOIN bpb ON do_detailtemp.no_bpb = bpb.no_bpb
    WHERE bpb.kode_dept = '$departemen' AND do_detailtemp.id_admin='$id_user'";
      $detailtmp  =  $this->db->query($qdetailtmp)->result();
      foreach ($detailtmp as $d) {
        $datadetail = array(
          'no_do'             => $nodo,
          'no_bpb'            => $d->no_bpb,
          'kode_barang'       => $d->kode_barang,
          'qty'               => $d->qty
        );

        $cek = $this->db->get_where('do_detail', array('no_bpb' => $d->no_bpb, 'kode_barang' => $d->kode_barang))->num_rows();
        if (empty($cek)) {
          $this->db->insert('do_detail', $datadetail);
        }
      }
      $hapus = "DELETE FROM do_detailtemp
    WHERE kode_dept = '$departemen' AND id_admin ='$id_user'";
      $this->db->query($hapus);
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Simpan !
      </div>'
      );
      redirect('pembelian/dotoko');
    }
  }


  function cekdatabpb()
  {
    $id_user = $this->session->userdata('id_user');
    return $this->db->get_where('detailbpb_temp', array('id_admin' => $id_user));
  }

  function getDetailBarang($nobukti, $kode_barang, $keterangan = "")
  {
    $this->db->join('master_barang_pembelian', 'detail_pembelian.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get_where('detail_pembelian', array('nobukti_pembelian' => $nobukti, 'detail_pembelian.kode_barang' => $kode_barang, 'detail_pembelian.keterangan' => $keterangan));
  }

  function getCOA()
  {
    return $this->db->get('coa');
  }

  function update_detailbarang()
  {
    $nobukti        = $this->input->post('nobukti');
    $kodebarang     = $this->input->post('kodebarang');
    $qty            = $this->input->post('qty');
    $harga          = str_replace(".", "", $this->input->post('harga'));
    $harga          = str_replace(",", ".", $harga);
    $penyharga      = str_replace(".", "", $this->input->post('penyharga'));
    $penyharga      = str_replace(",", ".", $penyharga);
    $keterangan     = $this->input->post('keterangan');
    $keteranganold  = $this->input->post('keteranganold');
    $kodeakun       = $this->input->post('kodeakun');
    $tglpembelian   = $this->input->post('tgl_pembelian');
    $namabarang     = $this->input->post('nama_barang');
    $cabang          = $this->input->post('cekcbg');

    //echo $cabang;
    //die;
    if (!empty($cabang)) {
      $cbg = $this->input->post('cbg');
    } else {
      $cbg = "";
    }
    // $cekakun = substr($kodeakun, 0, 3);
    // echo $cekakun . "-" . strlen($cekakun);
    // die;
    $kodecr         = $this->input->post('kodecr');
    //die;
    $bukti          = str_replace("/", ".", $nobukti);
    $data = [
      'qty' => $qty,
      'harga' => $harga,
      'penyesuaian' => $penyharga,
      'keterangan' => $keterangan,
      'kode_akun' => $kodeakun,
      'kode_cabang' => $cbg
    ];

    $update = $this->db->update('detail_pembelian', $data, array('nobukti_pembelian' => $nobukti, 'kode_barang' => $kodebarang, 'keterangan' => $keteranganold));
    if ($update) {
      if (!empty($kodecr) && substr($kodeakun, 0, 3) == "6-1" && !empty($cbg) || !empty($kodecr) && substr($kodeakun, 0, 3) == "6-2" && !empty($cbg)) {
        $datacr = [
          'tgl_transaksi' => $tglpembelian,
          'kode_akun'    => $kodeakun,
          'keterangan'   => "Pembelian " . $namabarang . "(" . $qty . ")",
          'kode_cabang'  => $cbg,
          'id_sumber_costratio' => 4,
          'jumlah' => $qty * $harga

        ];
        $updatecr = $this->db->update('costratio_biaya', $datacr, array('kode_cr' => $kodecr));
        $datadetail = [
          'kode_cr' => $kodecr
        ];
        $updatedetail = $update = $this->db->update('detail_pembelian', $datadetail, array('nobukti_pembelian' => $nobukti, 'kode_barang' => $kodebarang, 'keterangan' => $keteranganold));
      } else {
        $datadetail = [
          'kode_cr' => null
        ];
        $hapuscr = $this->db->delete('costratio_biaya', array('kode_cr' => $kodecr));
        $updatedetail = $update = $this->db->update('detail_pembelian', $datadetail, array('nobukti_pembelian' => $nobukti, 'kode_barang' => $kodebarang, 'keterangan' => $keteranganold));
      }

      if (empty($kodecr) && substr($kodeakun, 0, 3) == "6-1" && !empty($cbg) || empty($kodecr) && substr($kodeakun, 0, 3) == "6-2" && !empty($cbg)) {
        $tgltransaksi = explode("-", $tglpembelian);
        $bulan = $tgltransaksi[1];
        $tahun = $tgltransaksi[0];
        if (strlen($bulan) == 1) {
          $bulan = "0" . $bulan;
        } else {
          $bulan = $bulan;
        }
        $thn = substr($tahun, 2, 2);
        $awal = $tahun . "-" . $bulan . "-01";
        $akhir = $tahun . "-" . $bulan . "-31";
        $qcr = "SELECT kode_cr FROM costratio_biaya WHERE tgl_transaksi BETWEEN '$awal' AND '$akhir' ORDER BY kode_cr DESC LIMIT 1 ";
        $ceknolast = $this->db->query($qcr)->row_array();
        $nobuktilast = $ceknolast['kode_cr'];
        $kodecrnew = buatkode($nobuktilast, "CR" . $bulan . $thn, 4);
        $datacr = [
          'kode_cr' => $kodecrnew,
          'tgl_transaksi' => $tglpembelian,
          'kode_akun'    => $kodeakun,
          'keterangan'   => "Pembelian " . $namabarang . "(" . $qty . ")",
          'kode_cabang'  => $cbg,
          'id_sumber_costratio' => 4,
          'jumlah' => $qty * $harga

        ];
        $simpancr = $this->db->insert('costratio_biaya', $datacr);
        $datadetail = [
          'kode_cr' => $kodecrnew
        ];
        $updatedetail = $update = $this->db->update('detail_pembelian', $datadetail, array('nobukti_pembelian' => $nobukti, 'kode_barang' => $kodebarang, 'keterangan' => $keteranganold));
      }
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Update !
      </div>'
      );
      redirect('pembelian/editpembelian/' . $bukti);
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Gagal di Update !
      </div>'
      );
      redirect('pembelian/editpembelian/' . $bukti);
    }
  }

  function jurnalkoreksi($dari, $sampai)
  {
    $this->db->where('tgl_jurnalkoreksi >=', $dari);
    $this->db->where('tgl_jurnalkoreksi <=', $sampai);
    $this->db->join('pembelian', 'jurnal_koreksi.nobukti_pembelian = pembelian.nobukti_pembelian', 'left');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier', 'left');
    $this->db->join('master_barang_pembelian', 'jurnal_koreksi.kode_barang = master_barang_pembelian.kode_barang', 'left');
    $this->db->join('coa', 'jurnal_koreksi.kode_akun = coa.kode_akun', 'left');
    return $this->db->get('jurnal_koreksi');
  }


  function getBarangpembelian($nobukti)
  {
    $this->db->where('nobukti_pembelian', $nobukti);
    $this->db->join('master_barang_pembelian', 'detail_pembelian.kode_barang = master_barang_pembelian.kode_barang');
    return $this->db->get('detail_pembelian');
  }

  function insertjurnalkoreksi()
  {
    $tgljurnal = $this->input->post('tanggal');
    $supplier = $this->input->post('supplier');
    $nobukti = $this->input->post('nobuktipembelian');
    $barang = $this->input->post('barangpembelian');
    $harga  = str_replace(".", "", $this->input->post('harga'));
    $harga  = str_replace(",", ".", $harga);
    $qty = $this->input->post('qty');
    $qty = str_replace(",", ".", $qty);
    $keterangan = $this->input->post('keterangan');
    $debetkredit = $this->input->post('debetkredit');
    $kodeakun = $this->input->post('kodeakun');
    //Buat Kode
    $tanggal        = explode("-", $tgljurnal);
    $tahun          = substr($tanggal[0], 2, 2);
    $bulan          = $tanggal[1];
    $qjk            = "SELECT kode_jk FROM jurnal_koreksi WHERE LEFT(kode_jk,6) ='JK$tahun$bulan' ORDER BY kode_jk DESC LIMIT 1 ";
    $ceknolast      = $this->db->query($qjk)->row_array();
    $nobuktilast    = $ceknolast['kode_jk'];
    $kode_jk        = buatkode($nobuktilast, 'JK' . $tahun . $bulan, 3);
    $data = [
      'kode_jk' => $kode_jk,
      'tgl_jurnalkoreksi' => $tgljurnal,
      'nobukti_pembelian' => $nobukti,
      'kode_barang' => $barang,
      'harga' => $harga,
      'qty' => $qty,
      'keterangan' => $keterangan,
      'status_dk' => $debetkredit,
      'kode_akun' => $kodeakun
    ];

    $simpan = $this->db->insert('jurnal_koreksi', $data);
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil Disimpan !
      </div>'
      );
      redirect('pembelian/jurnalkoreksi');
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Gagal Disimpan !
      </div>'
      );
      redirect('pembelian/jurnalkoreksi');
    }
  }

  function hapusjurnalkoreksi()
  {
    $kodejk = $this->uri->segment(3);
    $hapus = $this->db->delete('jurnal_koreksi', array('kode_jk' => $kodejk));
    if ($hapus) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Berhasil di Hapus !
      </div>'
      );
      redirect('pembelian/jurnalkoreksi');
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <i class="fa fa-check"></i> Data Gagal di Hapus !
      </div>'
      );
      redirect('pembelian/jurnalkoreksi');
    }
  }

  function cekKB($nobukti)
  {
    $this->db->join('historibayar_pembelian', 'detail_kontrabon.no_kontrabon = historibayar_pembelian.no_kontrabon');
    return $this->db->get_where('detail_kontrabon', array('nobukti_pembelian' => $nobukti, 'tglbayar NOT NULL'));
  }

  function getBarangKategori1()
  {
    $this->db->where('jenis_barang', 'KEMASAN');
    $this->db->or_where('jenis_barang', 'Bahan Tambahan');
    $this->db->or_where('jenis_barang', 'BAHAN BAKU');
    return $this->db->get('master_barang_pembelian');
  }

  function getDetailPMB($dari, $sampai, $barang, $supplier)
  {
    if ($supplier != "") {
      $this->db->where('pembelian.kode_supplier', $supplier);
    }
    $this->db->join('master_barang_pembelian', 'detail_pembelian.kode_barang = master_barang_pembelian.kode_barang');
    $this->db->join('pembelian', 'detail_pembelian.nobukti_pembelian = pembelian.nobukti_pembelian');
    $this->db->join('supplier', 'pembelian.kode_supplier = supplier.kode_supplier');
    $this->db->where('tgl_pembelian >=', $dari);
    $this->db->where('tgl_pembelian <=', $sampai);
    $this->db->where('detail_pembelian.kode_barang', $barang);
    $this->db->order_by('pembelian.kode_supplier', 'ASC');
    return $this->db->get('detail_pembelian');
  }
}
