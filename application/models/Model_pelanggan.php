<?php

class Model_pelanggan extends CI_Model
{


  function list_detailpelanggan($cabang, $sales)
  {


    if ($cabang != "") {

      $cabang = "WHERE pelanggan.kode_cabang = '" . $cabang . "' ";
    }

    if ($sales != "") {

      $sales = "AND pelanggan.id_sales = '" . $sales . "' ";
    }

    $query = "
    SELECT pelanggan.kode_pelanggan,nama_pelanggan,alamat_pelanggan,pelanggan.no_hp,pasar,hari,nama_cabang,nama_karyawan,latitude,longitude,jumlah,no_pengajuan FROM pelanggan

    INNER JOIN cabang ON cabang.kode_cabang = pelanggan.kode_cabang
    INNER JOIN karyawan ON  karyawan.id_karyawan = pelanggan.id_sales
    INNER JOIN pengajuan_limitkredit ON  pengajuan_limitkredit.kode_pelanggan = pelanggan.kode_pelanggan

    "
      . $cabang
      . $sales
      . "
    GROUP BY pelanggan.kode_pelanggan,nama_pelanggan,alamat_pelanggan,pelanggan.no_hp,pasar,hari,nama_cabang,nama_karyawan,latitude,longitude,jumlah,no_pengajuan
    ORDER BY 
    pelanggan.id_sales,
    no_pengajuan
    DESC
    ";
    return $this->db->query($query);
  }

  function json()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang != "pusat") {
      $this->datatables->where('pelanggan.kode_cabang', $cabang);
    }
    $this->datatables->select('kode_pelanggan,nama_pelanggan,alamat_pelanggan,pelanggan.no_hp,pasar,hari,nama_cabang,nama_karyawan,latitude,longitude');
    $this->datatables->from('pelanggan');
    $this->datatables->join('cabang', 'pelanggan.kode_cabang = cabang.kode_cabang');
    $this->datatables->join('karyawan', 'pelanggan.id_sales = karyawan.id_karyawan');
    $this->datatables->where('nama_pelanggan !=', 'BATAL');
    $this->datatables->add_column('view', '<a href="edit_pelanggan/$1" " class="btn bg-green btn-xs waves-effect ">Edit</a> <a href="#" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="hapus/$1" class="btn bg-red btn-xs waves-effect">Hapus</a>
      <a href="https://www.google.com/maps/place/$2,$3" target="_blank" class="btn bg-blue btn-xs waves-effect ">Maps</a>', 'kode_pelanggan,latitude,longitude');
    return $this->datatables->generate();
  }

  public function getrecordPelanggan($cabang = "", $salesman = "", $namapel = "", $dari = "", $sampai = "", $kodepel = "")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('pelanggan');
    $this->db->join('cabang', 'pelanggan.kode_cabang = cabang.kode_cabang');
    $this->db->join('karyawan', 'pelanggan.id_sales = karyawan.id_karyawan');
    $this->db->where('nama_pelanggan !=', 'BATAL');

    if ($cabang != "") {
      $this->db->where('pelanggan.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('pelanggan.id_sales', $salesman);
    }
    if ($kodepel != '') {
      $this->db->like('pelanggan.kode_pelanggan', $kodepel);
    }
    if ($namapel != '') {
      $this->db->like('pelanggan.nama_pelanggan', $namapel);
    }

    if ($dari !=  '') {
      $this->db->where('time_stamps >=', $dari);
    }
    if ($sampai !=  '') {
      $this->db->where('time_stamps <=', $sampai);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getdataPelanggan($rowno, $rowperpage, $cabang = "", $salesman = "", $namapel = "", $dari = "", $sampai = "", $kodepel = "")
  {
    $this->db->select('kode_pelanggan,limitpel,nama_pelanggan,alamat_pelanggan,pelanggan.no_hp,pasar,hari,nama_cabang,nama_karyawan,latitude,longitude,time_stamps,jatuhtempo,foto');
    $this->db->from('pelanggan');
    $this->db->join('cabang', 'pelanggan.kode_cabang = cabang.kode_cabang');
    $this->db->join('karyawan', 'pelanggan.id_sales = karyawan.id_karyawan');
    $this->db->where('nama_pelanggan !=', 'BATAL');
    $this->db->order_by('kode_pelanggan', 'desc');
    if ($cabang != "") {
      $this->db->where('pelanggan.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('pelanggan.id_sales', $salesman);
    }

    if ($kodepel != '') {
      $this->db->like('pelanggan.kode_pelanggan', $kodepel);
    }
    if ($namapel != '') {
      $this->db->like('pelanggan.nama_pelanggan', $namapel);
    }

    if ($dari !=  '') {
      $this->db->where('time_stamps >=', $dari);
    }
    if ($sampai !=  '') {
      $this->db->where('time_stamps <=', $sampai);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }


  function get_pelanggan($id_pelanggan)
  {
    $this->db->where('kode_pelanggan', $id_pelanggan);
    return $this->db->get('pelanggan');
  }

  function get_salespel($kode_cabang)
  {
    $this->db->where('kode_cabang', $kode_cabang);
    return $this->db->get('karyawan');
  }


  function insert_pelanggan($foto)
  {

    $kode_pelanggan   = $this->input->post('kode_pelanggan');
    $nik              = $this->input->post('nik');
    $nokk             = $this->input->post('nokk');
    $nama_pelanggan   = $this->input->post('nama_pelanggan');
    $tgllahir         = $this->input->post('tgllahir');
    $alamat           = $this->input->post('alamat');
    $nohp             = $this->input->post('nohp');
    $pasar            = $this->input->post('pasar');
    $hari             = $this->input->post('hari');
    $cabang           = $this->input->post('cabang2');
    $salesman         = $this->input->post('salesman2');
    $limitpel         = $this->input->post('limitpel');
    $kecamatan        = $this->input->post('kecamatan');
    $kelurahan        = $this->input->post('kelurahan');
    $kepemilikan        = $this->input->post('kepemilikan');
    $lama_berjualan        = $this->input->post('lama_berjualan');
    $latitude         = $this->input->post('latitude');
    $longitude        = $this->input->post('longitude');
    $data             = array(
      'kode_pelanggan'    => $kode_pelanggan,
      'nik'               => $nik,
      'no_kk'             => $nokk,
      'nama_pelanggan'    => $nama_pelanggan,
      'tgl_lahir'         => $tgllahir,
      'alamat_pelanggan'  => $alamat,
      'no_hp'             => $nohp,
      'pasar'             => $pasar,
      'hari'              => $hari,
      'kode_cabang'       => $cabang,
      'id_sales'          => $salesman,
      'limitpel'          => $limitpel,
      'kepemilikan'       => $kepemilikan,
      'lama_berjualan'    => $lama_berjualan,
      'kecamatan'         => $kecamatan,
      'kelurahan'         => $kelurahan,
      'jatuhtempo'        => "14",
      'latitude'          => $latitude,
      'longitude'         => $longitude,
      'foto'              => $foto
    );
    $this->db->insert('pelanggan', $data);
  }



  function update_pelanggan($foto)
  {
    $kode_pelanggan = $this->input->post('kode_pelanggan');
    $nik             = $this->input->post('nik');
    $nokk            = $this->input->post('nokk');
    $nama_pelanggan = $this->input->post('nama_pelanggan');
    $tgllahir       = $this->input->post('tgllahir');
    $alamat         = $this->input->post('alamat');
    $nohp           = $this->input->post('nohp');
    $pasar           = $this->input->post('pasar');
    $hari           = $this->input->post('hari');
    $cabang         = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $limitpel       = $this->input->post('limitpel');
    $kecamatan       = $this->input->post('kecamatan');
    $kelurahan       = $this->input->post('kelurahan');
    $kepemilikan        = $this->input->post('kepemilikan');
    $lama_berjualan        = $this->input->post('lama_berjualan');
    $latitude       = $this->input->post('latitude');
    $longitude       = $this->input->post('longitude');

    $data = array(
      'kode_pelanggan'     => $kode_pelanggan,
      'nik'                => $nik,
      'no_kk'               => $nokk,
      'nama_pelanggan'    => $nama_pelanggan,
      'tgl_lahir'         => $tgllahir,
      'alamat_pelanggan'  => $alamat,
      'no_hp'               => $nohp,
      'pasar'             => $pasar,
      'hari'                => $hari,
      'kode_cabang'        => $cabang,
      'id_sales'            => $salesman,
      // 'limitpel' 					=> $limitpel,
      'kepemilikan'         => $kepemilikan,
      'lama_berjualan'         => $lama_berjualan,
      'kecamatan'          => $kecamatan,
      'kelurahan'          => $kelurahan,
      'latitude'          => $latitude,
      'longitude'          => $longitude,
      'foto'              => $foto
    );
    $this->db->update('pelanggan', $data, array('kode_pelanggan' => $kode_pelanggan));
  }

  function hapus($id_pelanggan)
  {
    $pelanggan = $this->db->get_where('pelanggan', array('kode_pelanggan' => $id_pelanggan))->row_array();
    $foto = $pelanggan['foto'];
    $hapus = $this->db->delete('pelanggan', array('kode_pelanggan' => $id_pelanggan));
    if ($hapus) {
      unlink("gambar/" . $_id->image);
    }
  }

  public function getDataLimitPelanggan($rowno, $rowperpage, $cabang = "", $salesman = "", $pelanggan = "")
  {

    $this->db->select('kode_pelanggan,nama_pelanggan,pelanggan.kode_cabang,nama_karyawan,limitpel');
    $this->db->from('pelanggan');
    $this->db->join('karyawan', 'pelanggan.id_sales = karyawan.id_karyawan');
    $this->db->order_by('nama_pelanggan,pelanggan.kode_cabang', 'ASC');
    $this->db->where('limitpel !=0');
    if ($pelanggan != '') {
      $this->db->like('pelanggan.nama_pelanggan', $cabang);
    }
    if ($cabang != '') {
      $this->db->where('pelanggan.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('pelanggan.id_sales', $salesman);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordLimitPelangganCount($cabang = "", $salesman = "", $pelanggan = "")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('pelanggan');
    $this->db->join('karyawan', 'pelanggan.id_sales = karyawan.id_karyawan');
    $this->db->order_by('nama_pelanggan,pelanggan.kode_cabang', 'ASC');
    $this->db->where('limitpel !=0');
    if ($pelanggan != '') {
      $this->db->like('pelanggan.nama_pelanggan', $cabang);
    }
    if ($cabang != '') {
      $this->db->where('pelanggan.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('pelanggan.id_sales', $salesman);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


  function ExportPelanggan($cabang = "", $salesman = "", $pelanggan = "", $dari = "", $sampai = "")
  {
    if ($cabang != "") {
      $this->db->where('pelanggan.kode_cabang', $cabang);
    }

    if ($salesman != "") {
      $this->db->where('id_sales', $salesman);
    }

    if ($pelanggan != "") {
      $this->db->like('nama_pelanggan', $pelanggan);
    }

    if ($dari !=  '') {
      $this->db->where('time_stamps >=', $dari);
    }
    if ($sampai !=  '') {
      $this->db->where('time_stamps <=', $sampai);
    }
    $this->db->join('karyawan', 'pelanggan.id_sales = karyawan.id_karyawan');
    $this->db->select('kode_pelanggan,nik,no_kk,nama_pelanggan,tgl_lahir,kecamatan,kelurahan,alamat_pelanggan,pelanggan.no_hp,pasar,hari,pelanggan.kode_cabang,nama_karyawan,
    latitude,longitude,limitpel,foto,jatuhtempo,time_stamps,limitpel');
    $this->db->from('pelanggan');
    return $this->db->get();
  }


  public function getrecordPelangganJT($cabang = "", $salesman = "", $namapel = "")
  {
    if ($cabang != "") {
      $cabang = "AND pelanggan.kode_cabang = '" . $cabang . "' ";
    } else {
      $cabang = "";
    }
    if ($salesman != '') {
      $salesman = "AND pelanggan.id_sales = '" . $salesman . "' ";
    } else {
      $salesman = "";
    }

    if ($namapel != '') {
      $namapel = "AND nama_pelanggan = '%" . $namapel . "%' ";
    } else {
      $namapel = "";
    }


    $query = "SELECT penjualan.kode_pelanggan,nama_pelanggan,alamat_pelanggan,pelanggan.no_hp,pasar,hari,pelanggan.kode_cabang,nama_karyawan,latitude,longitude,
    COUNT(penjualan.no_fak_penj) as jmlfaktur FROM penjualan 
    LEFT JOIN (SELECT no_fak_penj, IFNULL(SUM(bayar),0) as jmlbayar FROM historibayar GROUP BY no_fak_penj) as hb ON (penjualan.no_fak_penj = hb.no_fak_penj)
    INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
    INNER JOIN karyawan ON pelanggan.id_sales = karyawan.id_karyawan
    WHERE  jmlbayar IS NULL AND DATE_ADD(tgltransaksi, INTERVAL 15 DAY) < CURRENT_DATE()"
      . $cabang
      . $salesman
      . $namapel
      . "
    GROUP BY kode_pelanggan
    ";
    $query  = $this->db->query($query);
    $result = $query->num_rows();
    return $result;
  }

  public function getdataPelangganJT($rowno, $rowperpage, $cabang = "", $salesman = "", $namapel = "")
  {
    if ($cabang != "") {
      $cabang = "AND pelanggan.kode_cabang = '" . $cabang . "' ";
    } else {
      $cabang = "";
    }
    if ($salesman != '') {
      $salesman = "AND pelanggan.id_sales = '" . $salesman . "' ";
    } else {
      $salesman = "";
    }

    if ($namapel != '') {
      $namapel = "AND nama_pelanggan = '%" . $namapel . "%' ";
    } else {
      $namapel = "";
    }


    $query = "SELECT penjualan.kode_pelanggan,nama_pelanggan,alamat_pelanggan,pelanggan.no_hp,pasar,hari,pelanggan.kode_cabang,nama_karyawan,latitude,longitude,
    COUNT(penjualan.no_fak_penj) as jmlfaktur FROM penjualan 
    LEFT JOIN (SELECT no_fak_penj, IFNULL(SUM(bayar),0) as jmlbayar FROM historibayar GROUP BY no_fak_penj) as hb ON (penjualan.no_fak_penj = hb.no_fak_penj)
    INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
    INNER JOIN karyawan ON pelanggan.id_sales = karyawan.id_karyawan
    WHERE  jmlbayar IS NULL AND DATE_ADD(tgltransaksi, INTERVAL 15 DAY) < CURRENT_DATE()"
      . $cabang
      . $salesman
      . $namapel
      . "
    GROUP BY kode_pelanggan ORDER BY penjualan.kode_pelanggan,pelanggan.kode_cabang DESC LIMIT $rowno,$rowperpage
    ";
    //$this->db->limit($rowperpage, $rowno);
    $query = $this->db->query($query);
    return $query->result_array();
  }


  function getdetailfakturjatuhtempo($kodepelanggan)
  {
    $query = "SELECT penjualan.no_fak_penj,tgltransaksi,DATE_ADD(tgltransaksi, INTERVAL 15 DAY) as jt,total FROM penjualan 
    LEFT JOIN (SELECT no_fak_penj, IFNULL(SUM(bayar),0) as jmlbayar FROM historibayar GROUP BY no_fak_penj) as hb ON (penjualan.no_fak_penj = hb.no_fak_penj)
    WHERE  jmlbayar IS NULL AND DATE_ADD(tgltransaksi, INTERVAL 15 DAY) < CURRENT_DATE() AND penjualan.kode_pelanggan ='$kodepelanggan'";
    return $this->db->query($query);
  }
}
