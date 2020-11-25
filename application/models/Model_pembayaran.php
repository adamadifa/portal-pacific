<?php

class Model_pembayaran extends CI_Model
{


  public function __construct()
  {
    parent::__construct();
  }

  // Fetch records
  public function getData($rowno, $rowperpage, $search = "")
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang != "pusat") {
      $this->db->where('kode_cabang', $cabang);
    }
    $this->db->select('kode_pelanggan,nama_pelanggan,kode_cabang,sum(totalpiutang) as totalpiutang, sum(totalbayar) as totalbayar,sum(sisabayar) as totalsisabayar ');
    $this->db->from('view_pembayaran');
    $this->db->order_by('nama_pelanggan', 'asc');
    $this->db->group_by(array('kode_pelanggan', 'nama_pelanggan', 'kode_cabang'));
    if ($search != '') {
      $this->db->like('nama_pelanggan', $search);
    }

    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();

    return $query->result_array();
  }

  // Select total records
  public function getrecordCount($search = '')
  {
    $cabang = $this->session->userdata('cabang');

    if ($cabang != "pusat") {

      $this->db->where('kode_cabang', $cabang);
    }
    $this->db->select('count(distinct(kode_pelanggan)) as allcount');
    $this->db->from('view_pembayaran');

    if ($search != '') {
      $this->db->like('nama_pelanggan', $search);
    }
    $query   = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }



  function listfaktur($kodepelanggan)
  {
    $this->db->order_by('tgltransaksi,no_fak_penj', 'desc');
    return $this->db->get_where('view_pembayaran', array('kode_pelanggan' => $kodepelanggan));
  }


  function get_giro($nofaktur)
  {

    $this->db->where('giro.no_fak_penj', $nofaktur);
    $this->db->select('giro.id_giro,tgl_giro,giro.no_fak_penj,no_giro,materai,namabank,bank_penerima,jumlah,tglcair,giro.id_karyawan,nama_karyawan,status,tgl_ditolak,ket,tglbayar');
    $this->db->from('giro');
    $this->db->join('karyawan', 'giro.id_karyawan = karyawan.id_karyawan', 'left');
    $this->db->join('historibayar', 'giro.id_giro = historibayar.id_giro', 'left');
    return $this->db->get();
  }

  function get_transfer($nofaktur)
  {

    $this->db->where('transfer.no_fak_penj', $nofaktur);
    $this->db->select('transfer.id_transfer,tgl_transfer,transfer.no_fak_penj,namabank,bank_penerima,jumlah,tglcair,tgl_ditolak,norek,namapemilikrek,kode_transfer,transfer.id_karyawan,nama_karyawan,transfer.status,ket,tglbayar');
    $this->db->from('transfer');
    $this->db->join('karyawan', 'transfer.id_karyawan = karyawan.id_karyawan', 'left');
    $this->db->join('historibayar', 'transfer.id_transfer = historibayar.id_transfer', 'left');
    return $this->db->get();
  }

  function get_bayar($nofaktur)
  {

    $this->db->where('historibayar.no_fak_penj', $nofaktur);
    $this->db->join('karyawan', 'historibayar.id_karyawan = karyawan.id_karyawan', 'left');
    $this->db->join('giro', 'historibayar.id_giro = giro.id_giro', 'left');
    $this->db->select('nobukti,historibayar.no_fak_penj,tglbayar,jenistransaksi,jenisbayar,status_bayar,bayar,historibayar.id_giro
      id_transfer,girotocash,historibayar.id_karyawan,nama_karyawan,no_giro');
    $this->db->from('historibayar');
    return $this->db->get();
  }

  function inputbayar()
  {

    $nofaktur     = $this->input->post('nofaktur');
    $tglbayar     = $this->input->post('tglbayar');
    $jmlbayar     = $this->input->post('jmlbayar');
    $id_admin     = $this->session->userdata('id_user');
    $jenisbayar   = $this->input->post('jenisbayar');
    $girotocash   = $this->input->post('girotocash');
    if ($girotocash == "1") {
      $id_giro = $this->input->post('nogiro');
    } else {
      $id_giro =  NULL;
    }
    $status_bayar = $this->input->post('voucher');
    $salesman     = $this->input->post('salesman');
    if ($jenisbayar != "lainlain") {
      if ($jenisbayar == "titipan") {
        $jenistrans = "kredit";
      } else {
        $jenistrans = "tunai";
      }
      $hariini    = date('ymd');
      $tahunini   = date('y');
      $cekcabang  = $this->db->query("SELECT kode_cabang FROM penjualan INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan WHERE no_fak_penj = '$nofaktur'")->row_array();
      $cabang       = $cekcabang['kode_cabang'];
      $qbayar       = "SELECT nobukti FROM historibayar WHERE LEFT(nobukti,6) ='$cabang$tahunini-'ORDER BY nobukti DESC LIMIT 1 ";
      $ceknolast    = $this->db->query($qbayar)->row_array();
      $nobuktilast  = $ceknolast['nobukti'];
      $nobukti      = buatkode($nobuktilast, $cabang . $tahunini . "-", 6);
      $data = array(

        'nobukti'         => $nobukti,
        'no_fak_penj'     => $nofaktur,
        'tglbayar'        => $tglbayar,
        'jenistransaksi'  => $jenistrans,
        'jenisbayar'      => $jenisbayar,
        'bayar'           => $jmlbayar,
        'girotocash'      => $girotocash,
        'status_bayar'    => $status_bayar,
        'id_karyawan'      => $salesman,
        'id_giro'         => $id_giro,
        'id_admin'        => $id_admin

      );

      $this->db->insert('historibayar', $data);
    } else {
      $query = "UPDATE penjualan SET potistimewa = potistimewa + $jmlbayar,total=total-$jmlbayar WHERE no_fak_penj = '$nofaktur'";
      $updatepenjualan = $this->db->query($query);

      //$updatepenjualan = $this->db->update('penjualan',$data_update,array('no_fak_penj'=>$nofaktur));
      if ($updatepenjualan) {
        $datapot = array(
          'no_fak_penj'       => $nofaktur,
          'tgl_bayar'          => $tglbayar,
          'jml_pot_lainlain'  => $jmlbayar
        );
        $this->db->insert('potlainlain', $datapot);
      }
    }
  }

  function updatebayar($nobukti)
  {
    $tglbayar     = $this->input->post('tglbayar');
    $jmlbayar     = $this->input->post('jmlbayar');
    $jenisbayar   = $this->input->post('jenisbayar');
    $girotocash   = $this->input->post('girotocash');
    $status_bayar = $this->input->post('status_bayar');
    $salesman   = $this->input->post('salesman');
    if ($girotocash == "1") {
      $id_giro = $this->input->post('nogiro');
    } else {
      $id_giro =  NULL;
    }
    $data = array(
      'tglbayar'        => $tglbayar,
      'bayar'           => $jmlbayar,
      'jenisbayar'      => $jenisbayar,
      'girotocash'      => $girotocash,
      'status_bayar'    => $status_bayar,
      'id_giro'         => $id_giro,
      'id_karyawan'      => $salesman
    );
    $this->db->update('historibayar', $data, array('nobukti' => $nobukti));
  }

  function hapus($nobukti)
  {

    $this->db->delete('historibayar', array('nobukti' => $nobukti));
  }

  function viewbayar($nobukti)
  {
    return $this->db->get_where('historibayar', array('nobukti' => $nobukti));
  }

  function cekbayarlast($nobukti, $nofaktur)
  {

    return $this->db->query("SELECT SUM(bayar) as totalbayar FROM historibayar WHERE NOT nobukti = '$nobukti' AND no_fak_penj ='$nofaktur'");
  }


  function inputgiro()
  {
    $nofaktur   = $this->input->post('nofaktur');
    $tglgiro    = $this->input->post('tglgiro');
    $nogiro     = $this->input->post('nogiro');
    $namabank   = $this->input->post('namabank');
    $materai    = "-";
    $tglcair    = $this->input->post('tglcair');
    $jmlbayar   = $this->input->post('jmlbayar');
    $salesman   = $this->input->post('salesman');
    $data       = array(
      'no_fak_penj' => $nofaktur,
      'tgl_giro'    => $tglgiro,
      'no_giro'     => $nogiro,
      'namabank'    => $namabank,
      'materai'     => $materai,
      'tglcair'     => $tglcair,
      'jumlah'      => $jmlbayar,
      'id_karyawan'  => $salesman,
      'status'      => 0
    );
    $this->db->insert('giro', $data);
  }




  function updategiro($idgiro)
  {

    $nogiro     = $this->input->post('nogiro');
    $tglgiro    = $this->input->post('tglgiro');
    $namabank   = $this->input->post('namabank');
    $materai    = $this->input->post('materai');
    $tglcair    = $this->input->post('tglcair');
    $jmlbayar   = $this->input->post('jmlbayar');
    $salesman   = $this->input->post('salesman');

    $data   = array(

      'tgl_giro'    => $tglgiro,
      'no_giro'     => $nogiro,
      'namabank'    => $namabank,
      'materai'     => $materai,
      'tglcair'     => $tglcair,
      'jumlah'      => $jmlbayar,
      'id_karyawan'  => $salesman


    );

    $data_hb = array(
      'id_karyawan' => $salesman
    );
    $this->db->update('giro', $data, array('id_giro' => $idgiro));
    $this->db->update('historibayar', $data_hb, array('id_giro' => $idgiro));
  }

  function hapusgiro($idgiro)
  {

    $this->db->delete('giro', array('id_giro' => $idgiro));
  }

  function viewgiro($no_giro)
  {
    $this->db->select('no_giro,tgl_giro,penjualan.kode_pelanggan,nama_pelanggan,namabank,SUM(jumlah) as jumlah,tglcair,karyawan.kode_cabang,omset_bulan,omset_tahun');
    $this->db->from('giro');
    $this->db->join('penjualan', 'giro.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('karyawan', 'giro.id_karyawan = karyawan.id_karyawan');
    $this->db->where('no_giro', $no_giro);
    $this->db->group_by('giro.no_giro,tgl_giro,penjualan.kode_pelanggan,nama_pelanggan,namabank,tglcair,karyawan.kode_cabang,omset_bulan,omset_tahun');
    return $this->db->get();
  }

  function viewgirofaktur($id_giro)
  {
    $this->db->select('id_giro,no_giro,tgl_giro,penjualan.kode_pelanggan,nama_pelanggan,namabank,materai,SUM(jumlah) as jumlah,tglcair,giro.id_karyawan');
    $this->db->from('giro');
    $this->db->join('penjualan', 'giro.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->where('id_giro', $id_giro);
    return $this->db->get();
  }


  function inputtransfer()
  {

    $nofaktur     = $this->input->post('nofaktur');
    $tgltransfer  = $this->input->post('tgltransfer');
    $namabank     = $this->input->post('namabank');
    $tglcair      = $this->input->post('tglcair');
    $jmlbayar     = $this->input->post('jmlbayar');
    $kodepel      = $this->input->post('kodepel');
    $salesman     = $this->input->post('salesman');
    $keterangan   = $this->input->post('keterangan');
    $tgl          = explode("-", $tgltransfer);
    $tanggal      = $tgl[2];
    $bulan        = $tgl[1];
    $tahun        = substr($tgl[0], 2, 2);
    $kodetransfer =  $kodepel . $tanggal . $bulan . $tahun . $keterangan;
    $data   = array(
      'tgl_transfer'  => $tgltransfer,
      'no_fak_penj'   => $nofaktur,
      'namabank'      => $namabank,
      'tglcair'       => $tglcair,
      'jumlah'        => $jmlbayar,
      'kode_transfer' => $kodetransfer,
      'id_karyawan'    => $salesman,
      'ket'           => $keterangan,
      'status'        => 0

    );

    $this->db->insert('transfer', $data);
  }


  function hapustransfer($idtransfer)
  {

    $this->db->delete('transfer', array('id_transfer' => $idtransfer));
  }


  function viewtransfer($idtransfer)
  {

    $this->db->select('kode_transfer,tgl_transfer,penjualan.kode_pelanggan,nama_pelanggan,namabank,SUM(jumlah) as jumlah,tglcair,karyawan.kode_cabang,omset_bulan,omset_tahun');
    $this->db->from('transfer');
    $this->db->join('penjualan', 'transfer.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('karyawan', 'transfer.id_karyawan = karyawan.id_karyawan');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->group_by('kode_transfer,tgl_transfer,penjualan.kode_pelanggan,nama_pelanggan,namabank,tglcair,karyawan.kode_cabang,omset_bulan,omset_tahun');
    $this->db->where('kode_transfer', $idtransfer);
    return $this->db->get();
  }

  function viewtransferfaktur($idtransfer)
  {

    $this->db->select('id_transfer,kode_transfer,tgl_transfer,penjualan.kode_pelanggan,nama_pelanggan,namabank,SUM(jumlah) as jumlah,tglcair,transfer.id_karyawan,ket');
    $this->db->from('transfer');
    $this->db->join('penjualan', 'transfer.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->where('id_transfer', $idtransfer);
    return $this->db->get();
  }


  function updatetransfer($idtransfer)
  {

    $tgltransfer = $this->input->post('tgltransfer');
    $kodepel    = $this->input->post('kodepel');
    $namabank   = $this->input->post('namabank');
    $tglcair    = $this->input->post('tglcair');
    $jmlbayar   = $this->input->post('jmlbayar');
    $salesman   = $this->input->post('salesman');
    $keterangan = $this->input->post('keterangan');
    $tgl          = explode("-", $tgltransfer);
    $tanggal      = $tgl[2];
    $bulan        = $tgl[1];
    $tahun        = substr($tgl[0], 2, 2);
    $kodetransfer =  $kodepel . $tanggal . $bulan . $tahun . $keterangan;
    $data   = array(


      'tgl_transfer' => $tgltransfer,
      'namabank'    => $namabank,
      'tglcair'     => $tglcair,
      'jumlah'      => $jmlbayar,
      'id_karyawan' => $salesman,
      'ket'         => $keterangan,
      'kode_transfer' => $kodetransfer


    );

    $datahb = [
      'id_karyawan' => $salesman
    ];

    $this->db->update('transfer', $data, array('id_transfer' => $idtransfer));
    $this->db->update('historibayar', $datahb, array('id_transfer' => $idtransfer));
  }



  public function getdataGiro($rowno, $rowperpage, $namapel = "", $nogiro = "", $status = "", $dari = "", $sampai = "")
  {
    $sess_cab = $this->session->userdata('cabang');
    if ($sess_cab != 'pusat') {
      $this->db->where('karyawan.kode_cabang', $sess_cab);
    }
    $this->db->select('tgl_giro,penjualan.kode_pelanggan,nama_pelanggan,karyawan.kode_cabang,no_giro,namabank,sum(jumlah) as jumlah,tglcair,giro.status,tglbayar,kode_setoranpusat,tgl_setoranpusat,ket');
    $this->db->from('giro');
    $this->db->join('historibayar', 'giro.id_giro = historibayar.id_giro', 'left');
    $this->db->join('penjualan', 'giro.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('karyawan', 'giro.id_karyawan = karyawan.id_karyawan');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('setoran_pusat', 'giro.no_giro = setoran_pusat.no_ref', 'left');
    $this->db->group_by('tgl_giro,penjualan.kode_pelanggan,nama_pelanggan,karyawan.kode_cabang,giro.no_giro,namabank,tglcair,giro.status,tglbayar,kode_setoranpusat,tgl_setoranpusat,ket');
    $this->db->order_by('tglcair,no_giro', 'desc');
    if ($namapel != '') {
      $this->db->like('nama_pelanggan', $namapel, 'after');
    }
    if ($nogiro != '') {
      $this->db->where('giro.no_giro', $nogiro);
    }
    if ($status !== '') {
      $this->db->where('giro.status', $status);
    }

    $this->db->where('tglcair >=', $dari);
    $this->db->where('tglcair <=', $sampai);


    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();

    //echo $sampai;
    return $query->result_array();
  }

  // Select total records
  public function getrecordGiro($namapel = "", $nogiro = "", $status = "", $dari = "", $sampai = "")
  {
    $sess_cab = $this->session->userdata('cabang');
    if ($sess_cab != 'pusat') {
      $this->db->where('karyawan.kode_cabang', $sess_cab);
    }
    $this->db->select('tgl_giro,penjualan.kode_pelanggan,nama_pelanggan,karyawan.kode_cabang,no_giro,namabank,sum(jumlah) as jumlah,tglcair,giro.status,tglbayar,kode_setoranpusat');
    $this->db->from('giro');
    $this->db->join('historibayar', 'giro.id_giro = historibayar.id_giro', 'left');
    $this->db->join('penjualan', 'giro.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('karyawan', 'giro.id_karyawan = karyawan.id_karyawan');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('setoran_pusat', 'giro.no_giro = setoran_pusat.no_ref', 'left');
    $this->db->group_by('tgl_giro,penjualan.kode_pelanggan,nama_pelanggan,karyawan.kode_cabang,giro.no_giro,namabank,tglcair,giro.status,tglbayar,kode_setoranpusat');
    if ($namapel != '') {
      $this->db->like('nama_pelanggan', $namapel, 'after');
    }
    if ($nogiro != '') {
      $this->db->where('giro.no_giro', $nogiro);
    }
    if ($status !== '') {
      $this->db->where('giro.status', $status);
    }

    $this->db->where('tglcair >=', $dari);
    $this->db->where('tglcair <=', $sampai);

    $query = $this->db->get();

    //echo $sampai;
    return $query->num_rows();
  }



  // Fetch records
  // Fetch records
  public function getdataTransfer($rowno, $rowperpage, $namapel = "", $dari = "", $sampai = "", $status = "")
  {
    $sess_cab = $this->session->userdata('cabang');
    if ($sess_cab != 'pusat') {
      $this->db->where('karyawan.kode_cabang', $sess_cab);
    }
    $this->db->select('tgl_transfer,penjualan.kode_pelanggan,nama_pelanggan,karyawan.kode_cabang,kode_transfer,namabank,sum(jumlah) as jumlah,tglcair,transfer.status,tglbayar,kode_setoranpusat,tgl_setoranpusat,transfer.ket');
    $this->db->from('transfer');
    $this->db->join('historibayar', 'transfer.id_transfer = historibayar.id_transfer', 'left');
    $this->db->join('penjualan', 'transfer.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('karyawan', 'transfer.id_karyawan = karyawan.id_karyawan');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('setoran_pusat', 'transfer.kode_transfer = setoran_pusat.no_ref', 'left');
    $this->db->group_by('tgl_transfer,penjualan.kode_pelanggan,nama_pelanggan,karyawan.kode_cabang,transfer.kode_transfer,namabank,tglcair,transfer.status,tglbayar,kode_setoranpusat,tgl_setoranpusat,transfer.ket');
    $this->db->order_by('tglcair,nama_pelanggan', 'desc');
    if ($namapel != '') {
      $this->db->like('nama_pelanggan', $namapel, 'after');
    }

    if ($status !== '') {
      $this->db->where('transfer.status', $status);
    }

    $this->db->where('tglcair >=', $dari);


    $this->db->where('tglcair <=', $sampai);


    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();

    //echo $sampai;
    return $query->result_array();
  }

  // Select total records
  public function getrecordTransfer($namapel = "", $dari = "", $sampai = "", $status = "")
  {
    $sess_cab = $this->session->userdata('cabang');
    if ($sess_cab != 'pusat') {
      $this->db->where('karyawan.kode_cabang', $sess_cab);
    }
    $this->db->select('tgl_transfer,penjualan.kode_pelanggan,nama_pelanggan,karyawan.kode_cabang,kode_transfer,namabank,sum(jumlah) as jumlah,tglcair,transfer.status,tglbayar,kode_setoranpusat,transfer.ket');
    $this->db->from('transfer');
    $this->db->join('historibayar', 'transfer.id_transfer = historibayar.id_transfer', 'left');
    $this->db->join('penjualan', 'transfer.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('karyawan', 'transfer.id_karyawan = karyawan.id_karyawan');
    $this->db->join('pelanggan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('setoran_pusat', 'transfer.kode_transfer = setoran_pusat.no_ref', 'left');
    $this->db->group_by('tgl_transfer,penjualan.kode_pelanggan,nama_pelanggan,karyawan.kode_cabang,transfer.kode_transfer,namabank,tglcair,transfer.status,tglbayar,kode_setoranpusat,transfer.ket');
    $this->db->order_by('tglcair', 'desc');
    if ($namapel != '') {
      $this->db->like('nama_pelanggan', $namapel, 'after');
    }

    if ($status !== '') {
      $this->db->where('transfer.status', $status);
    }

    $this->db->where('tglcair >=', $dari);


    $this->db->where('tglcair <=', $sampai);



    $query = $this->db->get();

    //echo $sampai;
    return $query->num_rows();
  }


  function updatebayargiro()
  {

    $no_giro    = $this->input->post('no_giro');
    $status     = $this->input->post('status');
    $tgl_giro   = $this->input->post('tgl_giro');
    $pelanggan  = $this->input->post('pelanggan');
    $bulan        = $this->input->post('bulan');
    $tahunomset   = $this->input->post('tahun');
    if ($status == 1) {
      $tglcair    = $this->input->post('tglcair');
    } else if ($status == 2) {
      $tglcair    = $this->input->post('tglditolak');
    } else {
      $tglcair = "";
    }
    $tgltolak   = $this->input->post('tglditolak');
    $nofaktur   = $this->input->post('nofaktur');
    $jmlbayar   = $this->input->post('jmlbayar');

    $id_admin   = $this->session->userdata('id_user');
    $hariini    = date('ymd');

    $cekcabang  = $this->db->query("SELECT
      pelanggan.kode_cabang,
      pelanggan.nama_pelanggan,
      jenistransaksi
    FROM
      giro
      INNER JOIN penjualan ON giro.no_fak_penj = penjualan.no_fak_penj
      INNER JOIN pelanggan ON penjualan.kode_pelanggan= pelanggan.kode_pelanggan
    WHERE
      no_giro = '$no_giro'
    GROUP BY no_giro,pelanggan.kode_cabang,pelanggan.nama_pelanggan,jenistransaksi")->row_array();

    $tahunini       = date('y');
    $cabang         = $cekcabang['kode_cabang'];
    $jenistransaksi = $cekcabang['jenistransaksi'];
    $datagiro       = $this->db->get_where('giro', array('no_giro' => $no_giro))->result();
    $tahunini       = date("y");
    $bankpenerima   = $this->input->post('bank_penerima');
    // $cek_setorgiro  = $this->db->get_where('setoran_pusat',array('no_giro'=>$no_giro))->num_rows();

    $qsb                 = "SELECT kode_setoranpusat FROM setoran_pusat
                          WHERE LEFT(kode_setoranpusat,4) = 'SB$tahunini' ORDER BY kode_setoranpusat DESC LIMIT 1";
    $sb                  = $this->db->query($qsb)->row_array();
    $nomor_terakhir     = $sb['kode_setoranpusat'];
    $kode_setoranpusat   = buatkode($nomor_terakhir, 'SB' . $tahunini, 5);


    //Nobukti Ledger
    $tanggal        = explode("-", $tglcair);
    $tahun          = substr($tanggal[0], 2, 2);
    $qledger        = "SELECT no_bukti FROM ledger_bank WHERE LEFT(no_bukti,7) ='LR$cabang$tahun'ORDER BY no_bukti DESC LIMIT 1 ";
    $ceknolast      = $this->db->query($qledger)->row_array();
    $nobuktilast    = $ceknolast['no_bukti'];
    $no_bukti       = buatkode($nobuktilast, 'LR' . $cabang . $tahun, 4);

    //getGiro
    $getgiro        = $this->db->get_where('giro', array('no_giro' => $no_giro))->result();
    $listnofaktur   = '';
    // echo $cabang;
    // die;
    foreach ($getgiro as $g) {
      $listnofaktur = $listnofaktur .= $g->no_fak_penj . ",";
    }
    if ($cabang == 'TSM') {
      $akun = "1-1468";
    } else if ($cabang == 'BDG') {
      $akun = "1-1402";
    } else if ($cabang == 'BGR') {
      $akun = "1-1403";
    } else if ($cabang == 'PWT') {
      $akun = "1-1404";
    } else if ($cabang == 'TGL') {
      $akun = "1-1405";
    } else if ($cabang == "SKB") {
      $akun = "1-1407";
    } else if ($cabang == "GRT") {
      $akun = "1-1468";
    } else if ($cabang == "SMR") {
      $akun = "1-1488";
    } else if ($cabang == "SBY") {
      $akun = "1-1486";
    } else if ($cabang == "PST") {
      $akun = "1-1401";
    }
    // $data = array(
    //   'kode_setoranpusat' => $kode_setoranpusat,
    //   'tgl_setoranpusat'	=> $tglcair,
    //   'kode_cabang'				=> $cabang,
    //   'bank'							=> $bankpenerima,
    //   'no_giro'				    => $no_giro,
    //   'giro'				      => $jmlbayar,
    //   'keterangan'				=> "SETOR GIRO PELANGGAN ".$cekcabang['nama_pelanggan'],
    //   'status'						=> '1'

    // );


    $data = array(
      'tgl_diterimapusat'  => $tglcair,
      'bank'              => $bankpenerima,
      'status'            => '1',
      'omset_bulan'       => $bulan,
      'omset_tahun'       => $tahunomset
    );

    $dataditolak = array(
      'tgl_diterimapusat'  => $tglcair,
      'bank'              => $bankpenerima,
      'status'            => '2',
      'omset_bulan'       => 0,
      'omset_tahun'       => ''
    );

    $datapending = array(
      'tgl_diterimapusat'  => NULL,
      'bank'              => $bankpenerima,
      'status'            => '0',
      'omset_bulan'       => 0,
      'omset_tahun'       => ''
    );

    $dataledger = array(
      'no_bukti'        => $no_bukti,
      'no_ref'          => $no_giro,
      'bank'            => $bankpenerima,
      'tgl_ledger'      => $tglcair,
      'tgl_penerimaan'  => $tgl_giro,
      'pelanggan'       => $pelanggan,
      'keterangan'      => "INV " . $listnofaktur,
      'kode_akun'       => $akun,
      'jumlah'          => $jmlbayar,
      'status_dk'       => 'K',
      'status_validasi' => 1,
      'kategori'        => 'PNJ'
    );


    if ($status == 1) {
      // $delete       = $this->db->delete('setoran_pusat',array('no_giro'=>$no_giro));
      // $insert       = $this->db->insert('setoran_pusat',$data);
      $update          = $this->db->update('setoran_pusat', $data, array('no_ref' => $no_giro));
      $deleteledger = $this->db->delete('ledger_bank', array('no_ref' => $no_giro));
      $insertledger = $this->db->insert('ledger_bank', $dataledger);
    } else if ($status == 2) {
      //$delete       = $this->db->delete('setoran_pusat',array('no_giro'=>$no_giro));
      $deleteledger = $this->db->delete('ledger_bank', array('no_ref' => $no_giro));
      $update          = $this->db->update('setoran_pusat', $dataditolak, array('no_ref' => $no_giro));
      if (!$update) {
        // $qsb 				      	= "SELECT kode_setoranpusat FROM setoran_pusat
        //                       WHERE LEFT(kode_setoranpusat,4) = 'SB$tahunini' ORDER BY kode_setoranpusat DESC LIMIT 1";
        // $sb							    = $this->db->query($qsb)->row_array();
        // $nomor_terakhir 		= $sb['kode_setoranpusat'];
        // $kode_setoranpusat 	= buatkode($nomor_terakhir,'SB'.$tahunini,5);
        // $dataditolak = array(
        //   'kode_setoranpusat' => $kode_setoranpusat,
        //   'tgl_setoranpusat'	=> $tglcair,
        //   'kode_cabang'				=> $cabang,
        //   'bank'							=> $bankpenerima,
        //   'no_giro'				    => $no_giro,
        //   'giro'				      => '-'.$jmlbayar,
        //   'keterangan'				=> "SETOR GIRO PELANGGAN ".$cekcabang['nama_pelanggan'],
        //   'status'						=> '2'
        // );
        // $insert_ditolak  = $this->db->insert('setoran_pusat',$dataditolak);
      }
    } else {
      //echo "TEST";
      $deleteledger = $this->db->delete('ledger_bank', array('no_ref' => $no_giro));
      //$delete       = $this->db->delete('setoran_pusat',array('no_giro'=>$no_giro));
      $update          = $this->db->update('setoran_pusat', $datapending, array('no_ref' => $no_giro));
    }

    foreach ($datagiro as $giro) {
      if ($status == 1) {
        $datagiro = array(
          'status'          => $status,
          'bank_penerima'   => $bankpenerima,
          'jumlah'          => $giro->jumlah,
          'omset_bulan'       => $bulan,
          'omset_tahun'       => $tahunomset
        );
        $cekbayar = $this->db->get_where('historibayar', array('id_giro' => $giro->id_giro))->num_rows();
        $this->db->update('giro', $datagiro, array('id_giro' => $giro->id_giro));
        if ($cekbayar == 0) {
          //No Otomatis Byar
          $qbayar         = "SELECT nobukti FROM historibayar WHERE LEFT(nobukti,6) ='$cabang$tahunini-'ORDER BY nobukti DESC LIMIT 1 ";
          $ceknolast      = $this->db->query($qbayar)->row_array();
          $nobuktilast    = $ceknolast['nobukti'];
          $nobukti        = buatkode($nobuktilast, $cabang . $tahunini . "-", 6);
          $databayar = array(
            'nobukti'       => $nobukti,
            'no_fak_penj'   => $giro->no_fak_penj,
            'tglbayar'      => $tglcair,
            'jenistransaksi' => $jenistransaksi,
            'jenisbayar'    => 'giro',
            'bayar'         => $giro->jumlah,
            'id_giro'       => $giro->id_giro,
            'id_karyawan'   => $giro->id_karyawan,
            'id_admin'      => $id_admin
          );
          $this->db->insert('historibayar', $databayar);
        } else {
          $databayar = array(
            'tglbayar'      => $tglcair,
            'bayar'         => $giro->jumlah
          );
          $this->db->update('historibayar', $databayar, array('id_giro' => $giro->id_giro));
        }
      } else {
        if ($status == "2") {
          $datagiro = array(
            'tgl_ditolak'     => $tgltolak,
            'bank_penerima'   => $bankpenerima,
            'status'          => $status,
            'omset_bulan'     => 0,
            'omset_tahun'     => ''
          );
        } else {
          $datagiro = array(
            'tgl_ditolak'   => '',
            'bank_penerima' => '',
            'status'        => $status,
            'omset_bulan'   => 0,
            'omset_tahun'   => ''
          );
        }
        $this->db->update('giro', $datagiro, array('id_giro' => $giro->id_giro));
        $this->db->delete('historibayar', array('id_giro' => $giro->id_giro));
      }
    }
  }


  function updatebayartransfer()
  {

    $id_transfer  = $this->input->post('id_transfer');
    $status       = $this->input->post('status');
    $tgl_transfer = $this->input->post('tgl_transfer');
    $pelanggan    = $this->input->post('pelanggan');
    $bulan        = $this->input->post('bulan');
    $tahunomset   = $this->input->post('tahun');

    // echo $tahun;
    // die;
    if ($status == 1) {
      $tglcair    = $this->input->post('tglcair');
    } else if ($status == 2) {
      $tglcair    = $this->input->post('tglditolak');
    } else {
      $tglcair = "";
    }

    $tgltolak     = $this->input->post('tglditolak');
    $jmlbayar     = $this->input->post('jmlbayar');
    $norek        = $this->input->post('norek');
    $namapemilik  = $this->input->post('namapemilik');
    $id_admin     = $this->session->userdata('id_user');
    $hariini      = date('ymd');
    $cekcabang    = $this->db->query("SELECT
                      pelanggan.kode_cabang,
                      pelanggan.nama_pelanggan,
                      jenistransaksi
                    FROM
                      transfer
                      INNER JOIN penjualan ON transfer.no_fak_penj = penjualan.no_fak_penj
                      INNER JOIN pelanggan ON penjualan.kode_pelanggan= pelanggan.kode_pelanggan
                    WHERE
                      kode_transfer = '$id_transfer'

                    GROUP BY kode_transfer,pelanggan.kode_cabang,pelanggan.nama_pelanggan,jenistransaksi")->row_array();
    $cabang         = $cekcabang['kode_cabang'];
    // echo $cabang;
    // die;
    $tahunini       = date('y');
    $jenistransaksi = $cekcabang['jenistransaksi'];
    $datatransfer   = $this->db->get_where('transfer', array('kode_transfer' => $id_transfer))->result();
    $bankpenerima   = $this->input->post('bank_penerima');


    $qsb                 = "SELECT kode_setoranpusat FROM setoran_pusat
                            WHERE LEFT(kode_setoranpusat,4) = 'SB$tahunini' ORDER BY kode_setoranpusat DESC LIMIT 1";
    $sb                  = $this->db->query($qsb)->row_array();
    $nomor_terakhir     = $sb['kode_setoranpusat'];
    $kode_setoranpusat   = buatkode($nomor_terakhir, 'SB' . $tahunini, 5);


    //Nobukti Ledger
    $tanggal        = explode("-", $tglcair);
    $tahun          = substr($tanggal[0], 2, 2);
    $qledger        = "SELECT no_bukti FROM ledger_bank WHERE LEFT(no_bukti,7) ='LR$cabang$tahun'ORDER BY no_bukti DESC LIMIT 1 ";
    $ceknolast      = $this->db->query($qledger)->row_array();
    $nobuktilast    = $ceknolast['no_bukti'];
    $no_bukti       = buatkode($nobuktilast, 'LR' . $cabang . $tahun, 4);

    //getTransfer
    $gettransfer        = $this->db->get_where('transfer', array('kode_transfer' => $id_transfer))->result();
    $listnofaktur   = '';
    foreach ($gettransfer as $t) {
      $listnofaktur = $listnofaktur .= $t->no_fak_penj . ",";
    }
    if ($cabang == 'TSM') {
      $akun = "1-1468";
    } else if ($cabang == 'BDG') {
      $akun = "1-1402";
    } else if ($cabang == 'BGR') {
      $akun = "1-1403";
    } else if ($cabang == 'PWT') {
      $akun = "1-1404";
    } else if ($cabang == 'TGL') {
      $akun = "1-1405";
    } else if ($cabang == "SKB") {
      $akun = "1-1407";
    } else if ($cabang == "GRT") {
      $akun = "1-1468";
    } else if ($cabang == "SMR") {
      $akun = "1-1488";
    } else if ($cabang == "SBY") {
      $akun = "1-1486";
    } else if ($cabang == "PST") {
      $akun = "1-1401";
    }

    // $data = array(
    //   'kode_setoranpusat' => $kode_setoranpusat,
    //   'tgl_setoranpusat'	=> $tglcair,
    //   'kode_cabang'				=> $cabang,
    //   'bank'							=> $bankpenerima,
    //   'no_giro'				    => $id_transfer,
    //   'transfer'					=> $jmlbayar,
    //   'keterangan'				=> "TRANSFER PELANGGAN ".$cekcabang['nama_pelanggan'],
    //   'status'						=> '1'

    // );

    $data = array(
      'tgl_diterimapusat'  => $tglcair,
      'bank'              => $bankpenerima,
      'status'            => '1',
      'omset_bulan'       => $bulan,
      'omset_tahun'       => $tahunomset
    );

    $dataditolak = array(
      'tgl_diterimapusat'  => $tglcair,
      'bank'              => $bankpenerima,
      'status'            => '2',
      'omset_bulan'       => 0,
      'omset_tahun'       => ''
    );

    $datapending = array(
      'tgl_diterimapusat'  => NULL,
      'bank'              => $bankpenerima,
      'status'            => '0',
      'omset_bulan'       => 0,
      'omset_tahun'       => ''
    );
    $dataledger = array(
      'no_bukti'        => $no_bukti,
      'no_ref'          => $id_transfer,
      'bank'            => $bankpenerima,
      'tgl_ledger'      => $tglcair,
      'tgl_penerimaan'  => $tgl_transfer,
      'pelanggan'       => $pelanggan,
      'keterangan'      => "INV " . $listnofaktur,
      'kode_akun'       => $akun,
      'jumlah'          => $jmlbayar,
      'status_dk'       => 'K',
      'status_validasi' => 1,
      'kategori'        => 'PNJ'
    );
    if ($status == 1) {
      //$delete = $this->db->delete('setoran_pusat',array('no_giro'=>$id_transfer));
      //$insert = $this->db->insert('setoran_pusat',$data);
      $update       = $this->db->update('setoran_pusat', $data, array('no_ref' => $id_transfer));
      $deleteledger = $this->db->delete('ledger_bank', array('no_ref' => $id_transfer));
      $insertledger = $this->db->insert('ledger_bank', $dataledger);
    } else if ($status == 2) {
      //$delete = $this->db->delete('setoran_pusat',array('no_ref'=>$id_transfer));
      $deleteledger = $this->db->delete('ledger_bank', array('no_ref' => $id_transfer));
      $update       = $this->db->update('setoran_pusat', $dataditolak, array('no_ref' => $id_transfer));
      if ($update) {
        // $qsb 				      	= "SELECT kode_setoranpusat FROM setoran_pusat
        //                       WHERE LEFT(kode_setoranpusat,4) = 'SB$tahunini' ORDER BY kode_setoranpusat DESC LIMIT 1";
        // $sb							    = $this->db->query($qsb)->row_array();
        // $nomor_terakhir 		= $sb['kode_setoranpusat'];
        // $kode_setoranpusat 	= buatkode($nomor_terakhir,'SB'.$tahunini,5);
        // $dataditolak = array(
        //   'kode_setoranpusat' => $kode_setoranpusat,
        //   'tgl_setoranpusat'	=> $tglcair,
        //   'kode_cabang'				=> $cabang,
        //   'bank'							=> $bankpenerima,
        //   'no_ref'				    => $id_transfer,
        //   'transfer'					=> '-'.$jmlbayar,
        //   'keterangan'				=> "TRANSFER PELANGGAN ".$cekcabang['nama_pelanggan']." DI TOLAK",
        //   'status'						=> '2'

        // );

        // $insert_ditolak  = $this->db->insert('setoran_pusat',$dataditolak);
      }
    } else {
      //echo "TEST";
      $deleteledger = $this->db->delete('ledger_bank', array('no_ref' => $id_transfer));
      //$delete = $this->db->delete('setoran_pusat',array('no_giro'=>$id_transfer));
      $update       = $this->db->update('setoran_pusat', $datapending, array('no_ref' => $id_transfer));
    }


    foreach ($datatransfer as $t) {
      if ($status == 1) {
        $datatransfer = array(
          'status'            => $status,
          'norek'             => $t->norek,
          'namapemilikrek'    => $t->namapemilikrek,
          'jumlah'            => $t->jumlah,
          'omset_bulan'       => $bulan,
          'omset_tahun'       => $tahunomset
        );

        $cekbayar = $this->db->get_where('historibayar', array('id_transfer' => $t->id_transfer))->num_rows();

        $this->db->update('transfer', $datatransfer, array('id_transfer' => $t->id_transfer));
        if ($cekbayar == 0) {

          $qbayar       = "SELECT nobukti FROM historibayar WHERE LEFT(nobukti,6) ='$cabang$tahunini-'ORDER BY nobukti DESC LIMIT 1 ";
          $ceknolast    = $this->db->query($qbayar)->row_array();
          $nobuktilast  = $ceknolast['nobukti'];
          $nobukti      = buatkode($nobuktilast, $cabang . $tahunini . "-", 6);

          $databayar = array(
            'nobukti'       => $nobukti,
            'no_fak_penj'   => $t->no_fak_penj,
            'tglbayar'      => $tglcair,
            'jenistransaksi' => $jenistransaksi,
            'jenisbayar'    => 'transfer',
            'bayar'         => $t->jumlah,
            'id_transfer'   => $t->id_transfer,
            'id_karyawan'    => $t->id_karyawan,
            'id_admin'      => $id_admin


          );
          $this->db->insert('historibayar', $databayar);
        } else {
          $databayar = array(
            'tglbayar'      => $tglcair,
            'bayar'         => $t->jumlah

          );
          $this->db->update('historibayar', $databayar, array('id_transfer' => $t->id_transfer));
        }
      } else {


        if ($status == "2") {
          $datatransfer = array(
            'tgl_ditolak'     => $tgltolak,
            'bank_penerima'   => $bankpenerima,
            'norek'           => $norek,
            'namapemilikrek'  => $namapemilik,
            'status'          => $status,
            'omset_bulan'       => 0,
            'omset_tahun'       => ''
          );
        } else {
          $datatransfer = array(
            'tgl_ditolak'   => '',
            'bank_penerima' => '',
            'norek'         => $norek,
            'namapemilikrek' => $namapemilik,
            'status'        => $status,
            'omset_bulan'   => 0,
            'omset_tahun'   => ''
          );
        }


        $this->db->update('transfer', $datatransfer, array('id_transfer' => $t->id_transfer));
        $this->db->delete('historibayar', array('id_transfer' => $t->id_transfer));
      }
    }
  }


  function updategirotolak()
  {

    $id_giro    = $this->input->post('id_giro');
    $nofaktur   = $this->input->post('nofaktur');
    $nogiro     = $this->input->post('nogiro');
    $namabank   = $this->input->post('namabank');
    $materai    = $this->input->post('materai');
    $jumlah     = $this->input->post('jumlah');
    $tglcair    = $this->input->post('tglcair');
    $ket        = "Giro Mundur " . $tglcair;

    $data = array(

      'no_fak_penj' => $nofaktur,
      'no_giro'     => $nogiro,
      'namabank'    => $namabank,
      'materai'     => $materai,
      'jumlah'      => $jumlah,
      'tglcair'     => $tglcair,
      'status'      => 0




    );

    $updateket = array(

      'ket' => $ket

    );

    $giromundur = $this->db->insert('giro', $data);
    if ($giromundur) {

      $this->db->update('giro', $updateket, array('id_giro' => $id_giro));
    }
  }

  function updatetransfertolak()
  {

    $id_transfer  = $this->input->post('id_transfer');
    $nofaktur     = $this->input->post('nofaktur');
    $namabank     = $this->input->post('namabank');
    $jumlah       = $this->input->post('jumlah');
    $tglcair      = $this->input->post('tglcair');
    $ket          = "Transfer Mundur " . $tglcair;

    $data = array(

      'no_fak_penj' => $nofaktur,
      'namabank'    => $namabank,
      'jumlah'      => $jumlah,
      'tglcair'     => $tglcair,
      'status'      => 0




    );

    $updateket = array(

      'ket' => $ket

    );

    $giromundur = $this->db->insert('transfer', $data);
    if ($giromundur) {

      $this->db->update('transfer', $updateket, array('id_transfer' => $id_transfer));
    }
  }


  public function getDataBayar($rowno, $rowperpage, $nofaktur = "", $namapel = "", $dari = "", $sampai = "")
  {

    $cabang = $this->session->userdata('cabang');
    if ($cabang != "pusat") {
      $cabang = "AND cabangbarunew = '" . $cabang . "'";
    } else {
      $cabang = "";
    }
    if ($nofaktur != '') {
      $nofaktur = "AND penjualan.no_fak_penj = '" . $nofaktur . "'";
    }
    if ($namapel != '') {
      $namapel = "AND nama_pelanggan like '%" . $namapel . "%'";
    }
    if ($dari !=  '') {
      $dari = "AND tgltransaksi >= '" . $dari . "'";
    }
    if ($sampai !=  '') {
      $sampai = "AND tgltransaksi <= '" . $sampai . "'";
    }

    $query = "SELECT
    penjualan.no_fak_penj,
    penjualan.tgltransaksi,
    penjualan.kode_pelanggan,
    pelanggan.nama_pelanggan,
    penjualan.id_karyawan,
    penjualan.jenistransaksi,
    cabangbarunew as kode_cabang,
    salesbarunew,
    nama_sales as nama_karyawan,
    ifnull( penjualan.total, 0 ) AS total,
    ifnull( view_retur.totalgb, 0 ) AS totalgb,
    ifnull( view_retur.totalpf, 0 ) AS totalpf,
    (ifnull( view_retur.totalpf, 0 ) - ifnull( view_retur.totalgb, 0 )) AS totalretur,
    (ifnull( penjualan.total, 0 ) - (ifnull( view_retur.totalpf, 0 ) - ifnull( view_retur.totalgb,0 ))) AS totalpiutang,
    ifnull( view_historibayar.totalbayar, 0 ) AS totalbayar,
    ((ifnull( penjualan.total, 0 ) - (ifnull( view_retur.totalpf, 0 ) - ifnull( view_retur.totalgb, 0 ))) - ifnull( view_historibayar.totalbayar, 0 )) AS sisabayar 
  FROM
    penjualan
    LEFT JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
    LEFT JOIN (
          SELECT pj.no_fak_penj,
          IF(salesbaru IS NULL,pj.id_karyawan,salesbaru) as salesbarunew, karyawan.nama_karyawan as nama_sales,
          IF(cabangbaru IS NULL,karyawan.kode_cabang,cabangbaru) as cabangbarunew
          FROM penjualan pj
          INNER JOIN karyawan ON pj.id_karyawan = karyawan.id_karyawan
          LEFT JOIN (
            SELECT MAX(id_move) as id_move,no_fak_penj,move_faktur.id_karyawan as salesbaru,karyawan.kode_cabang as cabangbaru
            FROM move_faktur
            INNER JOIN karyawan ON move_faktur.id_karyawan = karyawan.id_karyawan
            GROUP BY no_fak_penj,move_faktur.id_karyawan,karyawan.kode_cabang
          ) move_fak ON (pj.no_fak_penj = move_fak.no_fak_penj)
          
      ) pjmove ON (penjualan.no_fak_penj = pjmove.no_fak_penj)
      
    LEFT JOIN view_retur ON penjualan.no_fak_penj = view_retur.no_fak_penj
    LEFT JOIN view_historibayar ON penjualan.no_fak_penj = view_historibayar.no_fak_penj 
  WHERE
    penjualan.no_fak_penj != ''"
      . $cabang
      . $nofaktur
      . $namapel
      . $dari
      . $sampai
      . " 
  ORDER BY
    tgltransaksi DESC 
  LIMIT $rowno,$rowperpage
  ";
    $query = $this->db->query($query);
    return $query;
  }

  public function getDataBayarCount($nofaktur = "", $namapel = "", $dari = "", $sampai = "")
  {

    $cabang = $this->session->userdata('cabang');
    if ($cabang != "pusat") {
      $cabang = "AND cabangbarunew = '" . $cabang . "'";
    } else {
      $cabang = "";
    }
    if ($nofaktur != '') {
      $nofaktur = "AND penjualan.no_fak_penj = '" . $nofaktur . "'";
    }
    if ($namapel != '') {
      $namapel = "AND nama_pelanggan like '%" . $namapel . "%'";
    }
    if ($dari !=  '') {
      $dari = "AND tgltransaksi >= '" . $dari . "'";
    }
    if ($sampai !=  '') {
      $sampai = "AND tgltransaksi <= '" . $sampai . "'";
    }

    $query = "SELECT
    penjualan.no_fak_penj,
    penjualan.tgltransaksi,
    penjualan.kode_pelanggan,
    pelanggan.nama_pelanggan,
    penjualan.id_karyawan,
    penjualan.jenistransaksi,
    cabangbarunew as kode_cabang,
    salesbarunew,
    nama_sales as nama_karyawan,
    ifnull( penjualan.total, 0 ) AS total,
    ifnull( view_retur.totalgb, 0 ) AS totalgb,
    ifnull( view_retur.totalpf, 0 ) AS totalpf,
    (ifnull( view_retur.totalpf, 0 ) - ifnull( view_retur.totalgb, 0 )) AS totalretur,
    (ifnull( penjualan.total, 0 ) - (ifnull( view_retur.totalpf, 0 ) - ifnull( view_retur.totalgb,0 ))) AS totalpiutang,
    ifnull( view_historibayar.totalbayar, 0 ) AS totalbayar,
    ((ifnull( penjualan.total, 0 ) - (ifnull( view_retur.totalpf, 0 ) - ifnull( view_retur.totalgb, 0 ))) - ifnull( view_historibayar.totalbayar, 0 )) AS sisabayar 
  FROM
    penjualan
    LEFT JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
    LEFT JOIN (
          SELECT pj.no_fak_penj,
          IF(salesbaru IS NULL,pj.id_karyawan,salesbaru) as salesbarunew, karyawan.nama_karyawan as nama_sales,
          IF(cabangbaru IS NULL,karyawan.kode_cabang,cabangbaru) as cabangbarunew
          FROM penjualan pj
          INNER JOIN karyawan ON pj.id_karyawan = karyawan.id_karyawan
          LEFT JOIN (
            SELECT MAX(id_move) as id_move,no_fak_penj,move_faktur.id_karyawan as salesbaru,karyawan.kode_cabang as cabangbaru
            FROM move_faktur
            INNER JOIN karyawan ON move_faktur.id_karyawan = karyawan.id_karyawan
            GROUP BY no_fak_penj,move_faktur.id_karyawan,karyawan.kode_cabang
          ) move_fak ON (pj.no_fak_penj = move_fak.no_fak_penj)
          
      ) pjmove ON (penjualan.no_fak_penj = pjmove.no_fak_penj)
      
    LEFT JOIN view_retur ON penjualan.no_fak_penj = view_retur.no_fak_penj
    LEFT JOIN view_historibayar ON penjualan.no_fak_penj = view_historibayar.no_fak_penj 
  WHERE
    penjualan.no_fak_penj != ''"
      . $cabang
      . $nofaktur
      . $namapel
      . $dari
      . $sampai
      . " 
  ";
    $query = $this->db->query($query);
    return $query;
  }



  function listbank()
  {
    return $this->db->get('master_bank');
  }

  function detailpotlainlain($nofaktur)
  {
    return $this->db->get_where('potlainlain', array('no_fak_penj' => $nofaktur));
  }

  function hapuspotlainlain($id, $nofaktur)
  {
    $cekpot     =  $this->db->get_where('potlainlain', array('id' => $id))->row_array();
    $jmlbayar   = $cekpot['jml_pot_lainlain'];
    $hapus       = $this->db->delete('potlainlain', array('id' => $id));
    if ($hapus) {
      $query  = "UPDATE penjualan SET potistimewa = potistimewa - $jmlbayar, total = total+$jmlbayar WHERE no_fak_penj = '$nofaktur'";
      $update = $this->db->query($query);
      if ($update) {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green alert-dismissible" role="alert">
			              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
			          </div>'
        );
        redirect('penjualan/detailfaktur/' . $nofaktur);
      }
    }
  }

  function getdetailgiro($nogiro)
  {
    $this->db->select('giro.id_giro,tgl_giro,giro.no_fak_penj,namabank,jumlah,giro.date_created as tgl_input,historibayar.date_created as tgl_aksi');
    $this->db->from('giro');
    $this->db->join('penjualan', 'giro.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('historibayar', 'giro.id_giro = historibayar.id_giro AND giro.no_fak_penj = historibayar.no_fak_penj', 'left');
    $this->db->where('no_giro', $nogiro);
    return $this->db->get();
  }

  function getdetailtransfer($kode_transfer)
  {
    $this->db->select('transfer.id_transfer,tgl_transfer,transfer.no_fak_penj,namabank,jumlah,transfer.date_created as tgl_input,historibayar.date_created as tgl_aksi');
    $this->db->from('transfer');
    $this->db->join('penjualan', 'transfer.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('historibayar', 'transfer.id_transfer = historibayar.id_transfer AND transfer.no_fak_penj = historibayar.no_fak_penj', 'left');
    $this->db->where('transfer.kode_transfer', $kode_transfer);
    return $this->db->get();
  }

  function getdetailsetoranpusat($kode_setoran)
  {
    $this->db->select('setoran_pusat.kode_setoranpusat,tgl_setoranpusat,setoran_pusat.date_created as tgl_input,ledger_bank.date_created as tgl_aksi');
    $this->db->from('setoran_pusat');
    $this->db->join('ledger_bank', 'setoran_pusat.kode_setoranpusat = ledger_bank.no_ref', 'left');
    $this->db->where('setoran_pusat.kode_setoranpusat', $kode_setoran);
    return $this->db->get();
  }

  function getGiroditolak($nofaktur)
  {
    $query = "SELECT giro.id_giro,no_giro FROM giro
                LEFT JOIN ( SELECT id_giro,girotocash FROM historibayar WHERE no_fak_penj ='$nofaktur') as hb
                ON (giro.id_giro = hb.id_giro)
                WHERE giro.status ='2' AND giro.no_fak_penj ='$nofaktur'
							";
    return $this->db->query($query);
  }
}
