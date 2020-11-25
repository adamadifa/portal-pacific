<?php
error_reporting(0);
class Model_repackreject extends CI_Model
{

  public function getDataRepack($rowno, $rowperpage, $nomutasi = "", $tglmutasi = "")
  {
    $this->db->where('jenis_mutasi', 'REPACK');
    $this->db->select('*');
    $this->db->from('mutasi_gudang_jadi');
    $this->db->order_by('tgl_mutasi_gudang,time_stamp', 'desc');
    if ($nomutasi != '') {
      $this->db->where('no_mutasi_gudang', $nomutasi);
    }
    if ($tglmutasi != '') {
      $this->db->where('tgl_mutasi_gudang', $tglmutasi);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordRepackCount($nomutasi = "", $tglmutasi = "")
  {
    $this->db->where('jenis_mutasi', 'REPACK');
    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_jadi');
    if ($nomutasi != '') {
      $this->db->where('no_mutasi_gudang', $nomutasi);
    }
    if ($tglmutasi != '') {
      $this->db->where('tgl_mutasi_gudang', $tglmutasi);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


  function insert_detailrepacktemp()
  {
    $kode_produk  = $this->input->post('kode_produk');
    $jumlah        = $this->input->post('jumlah');
    $data = array(
      'kode_produk' => $kode_produk,
      'jumlah'    => $jumlah
    );
    $this->db->insert('detail_repack_temp', $data);
  }

  function cek_detailrepacktemp()
  {
    $kode_produk = $this->input->post('kode_produk');
    $this->db->where('kode_produk', $kode_produk);
    return $this->db->get('detail_repack_temp');
  }

  function view_detail_repack_temp()
  {
    $this->db->join('master_barang', 'detail_repack_temp.kode_produk = master_barang.kode_produk');
    return $this->db->get('detail_repack_temp');
  }

  function hapus_detail_repack_temp($kode_produk)
  {
    $hapus = $this->db->delete('detail_repack_temp', array('kode_produk' => $kode_produk));
  }

  function getNoRepackLast($tgl_repack)
  {
    $query = "SELECT LEFT(no_mutasi_gudang,4) as no_repack
              FROM mutasi_gudang_jadi
              WHERE tgl_mutasi_gudang = '$tgl_repack' AND jenis_mutasi='REPACK' ORDER by LEFT(no_mutasi_gudang,4) DESC";
    return $this->db->query($query);
  }

  function insert_repack()
  {
    $no_repack  = $this->input->post('no_repack');
    $tgl_repack = $this->input->post('tgl_repack');
    $inout      = 'IN';
    $id_admin    = $this->session->userdata('id_user');
    $data = array(
      'no_mutasi_gudang'    => $no_repack,
      'tgl_mutasi_gudang'   => $tgl_repack,
      'inout'               => $inout,
      'id_admin'            => $id_admin,
      'jenis_mutasi'        => 'REPACK'
    );
    $cek = $this->db->get_where('mutasi_gudang_jadi', array('no_mutasi_gudang' => $no_repack))->num_rows();
    if ($cek != 0) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-info"></i> No Repack Sudah Digunakan !
      </div>'
      );
      redirect('repackreject/repack');
    } else {
      $repack = $this->db->insert('mutasi_gudang_jadi', $data);
      if ($repack) {
        $detail = $this->db->get('detail_repack_temp')->result();
        foreach ($detail as $d) {
          $data_detail = array(
            'no_mutasi_gudang' => $no_repack,
            'kode_produk'      => $d->kode_produk,
            'jumlah'           => $d->jumlah
          );
          $this->db->insert('detail_mutasi_gudang', $data_detail);
        }
        $this->db->truncate('detail_repack_temp');
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <i class="fa fa-check"></i> Data Berhasil Disimpan !
	      </div>'
        );
        redirect('repackreject/repack');
      }
    }
  }

  function detail_mutasi($nomutasi)
  {
    $this->db->where('no_mutasi_gudang', $nomutasi);
    $this->db->join('master_barang', 'detail_mutasi_gudang.kode_produk=master_barang.kode_produk');
    return $this->db->get('detail_mutasi_gudang');
  }


  function getMutasi($nomutasi)
  {
    $this->db->where('no_mutasi_gudang', $nomutasi);
    return $this->db->get('mutasi_gudang_jadi');
  }



  public function getDataReject($rowno, $rowperpage, $nomutasi = "", $tglmutasi = "")
  {
    $this->db->where('jenis_mutasi', 'REJECT');
    $this->db->select('*');
    $this->db->from('mutasi_gudang_jadi');
    $this->db->order_by('tgl_mutasi_gudang,time_stamp', 'desc');
    if ($nomutasi != '') {
      $this->db->where('mutasi_gudang_jadi', $nomutasi);
    }
    if ($tglmutasi != '') {
      $this->db->where('tgl_mutasi_gudang', $tglmutasi);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordRejectCount($nomutasi = "", $tglmutasi = "")
  {
    $this->db->where('jenis_mutasi', 'REJECT');
    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_jadi');
    if ($nomutasi != '') {
      $this->db->where('mutasi_gudang_jadi', $nomutasi);
    }

    if ($tglmutasi != '') {
      $this->db->where('tgl_mutasi_gudang', $tglmutasi);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataLainlain($rowno, $rowperpage, $nomutasi = "", $tglmutasi = "")
  {
    $this->db->where('jenis_mutasi', 'LAINLAIN');
    $this->db->select('*');
    $this->db->from('mutasi_gudang_jadi');
    $this->db->order_by('tgl_mutasi_gudang,time_stamp', 'desc');
    if ($nomutasi != '') {
      $this->db->where('mutasi_gudang_jadi', $nomutasi);
    }
    if ($tglmutasi != '') {
      $this->db->where('tgl_mutasi_gudang', $tglmutasi);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordLainlainCount($nomutasi = "", $tglmutasi = "")
  {
    $this->db->where('jenis_mutasi', 'LAINLAIN');
    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_jadi');
    if ($nomutasi != '') {
      $this->db->where('mutasi_gudang_jadi', $nomutasi);
    }

    if ($tglmutasi != '') {
      $this->db->where('tgl_mutasi_gudang', $tglmutasi);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function view_detail_reject_temp()
  {
    $this->db->join('master_barang', 'detail_reject_temp.kode_produk = master_barang.kode_produk');
    return $this->db->get('detail_reject_temp');
  }

  function view_detail_lainlain_temp()
  {
    $this->db->join('master_barang', 'detail_lainlain_temp.kode_produk = master_barang.kode_produk');
    return $this->db->get('detail_lainlain_temp');
  }

  function cek_detailrejecttemp()
  {
    $kode_produk = $this->input->post('kode_produk');
    $this->db->where('kode_produk', $kode_produk);
    return $this->db->get('detail_reject_temp');
  }

  function cek_detaillainlaintemp()
  {
    $kode_produk = $this->input->post('kode_produk');
    $this->db->where('kode_produk', $kode_produk);
    return $this->db->get('detail_lainlain_temp');
  }


  function insert_detailrejecttemp()
  {
    $kode_produk  = $this->input->post('kode_produk');
    $jumlah        = $this->input->post('jumlah');
    $data  = array(
      'kode_produk' => $kode_produk,
      'jumlah'    => $jumlah
    );
    $this->db->insert('detail_reject_temp', $data);
  }

  function insert_detaillainlaintemp()
  {
    $kode_produk  = $this->input->post('kode_produk');
    $jumlah        = $this->input->post('jumlah');
    $data  = array(
      'kode_produk' => $kode_produk,
      'jumlah'    => $jumlah
    );
    $this->db->insert('detail_lainlain_temp', $data);
  }

  function hapus_detail_reject_temp($kode_produk)
  {
    $hapus = $this->db->delete('detail_reject_temp', array('kode_produk' => $kode_produk));
  }

  function hapus_detail_lainlain_temp($kode_produk)
  {
    $hapus = $this->db->delete('detail_lainlain_temp', array('kode_produk' => $kode_produk));
  }


  function getNoRejectLast($tgl_reject)
  {
    $query = "SELECT LEFT(no_mutasi_gudang,4) as no_reject
	            FROM mutasi_gudang_jadi
	            WHERE tgl_mutasi_gudang = '$tgl_reject' AND jenis_mutasi='REJECT' ORDER by LEFT(no_mutasi_gudang,4) DESC";
    return $this->db->query($query);
  }

  function getNoLainlainLast($tgl_mutasi_lainlain)
  {
    $query = "SELECT LEFT(no_mutasi_gudang,4) as no_lainlain
	            FROM mutasi_gudang_jadi
	            WHERE tgl_mutasi_gudang = '$tgl_mutasi_lainlain' AND jenis_mutasi='LAINLAIN' ORDER by LEFT(no_mutasi_gudang,4) DESC";
    return $this->db->query($query);
  }

  function insert_reject()
  {
    $no_reject  = $this->input->post('no_reject');
    $tgl_reject = $this->input->post('tgl_reject');
    $inout      = 'OUT';
    $id_admin    = $this->session->userdata('id_user');
    $data = array(
      'no_mutasi_gudang'    => $no_reject,
      'tgl_mutasi_gudang'   => $tgl_reject,
      'inout'               => $inout,
      'id_admin'            => $id_admin,
      'jenis_mutasi'        => 'REJECT'
    );
    $cek = $this->db->get_where('mutasi_gudang_jadi', array('no_mutasi_gudang' => $no_reject))->num_rows();
    if ($cek != 0) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-info"></i> No Repack Sudah Digunakan !
      </div>'
      );
      redirect('repackreject/reject');
    } else {
      $reject = $this->db->insert('mutasi_gudang_jadi', $data);
      if ($reject) {
        $detail = $this->db->get('detail_reject_temp')->result();
        foreach ($detail as $d) {
          $data_detail = array(
            'no_mutasi_gudang' => $no_reject,
            'kode_produk'      => $d->kode_produk,
            'jumlah'           => $d->jumlah
          );
          $this->db->insert('detail_mutasi_gudang', $data_detail);
        }
        $this->db->truncate('detail_reject_temp');
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Disimpan !
        </div>'
        );
        redirect('repackreject/reject');
      }
    }
  }

  function insert_lainlain()
  {
    $no_lainlain  = $this->input->post('no_lainlain');
    $tgl_lainlain = $this->input->post('tgl_mutasi_lainlain');
    $inout      = $this->input->post('inout');
    $id_admin    = $this->session->userdata('id_user');
    $keterangan = $this->input->post('keterangan');
    $data = array(
      'no_mutasi_gudang'    => $no_lainlain,
      'tgl_mutasi_gudang'   => $tgl_lainlain,
      'inout'               => $inout,
      'id_admin'            => $id_admin,
      'jenis_mutasi'        => 'LAINLAIN',
      'keterangan'          => $keterangan
    );
    $cek = $this->db->get_where('mutasi_gudang_jadi', array('no_mutasi_gudang' => $no_lainlain))->num_rows();
    if ($cek != 0) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-info"></i> No Mutasi Sudah Digunakan !
      </div>'
      );
      redirect('repackreject/lainlain');
    } else {
      $lainlain = $this->db->insert('mutasi_gudang_jadi', $data);
      if ($lainlain) {
        $detail = $this->db->get('detail_lainlain_temp')->result();
        foreach ($detail as $d) {
          $data_detail = array(
            'no_mutasi_gudang' => $no_lainlain,
            'kode_produk'      => $d->kode_produk,
            'jumlah'           => $d->jumlah
          );
          $this->db->insert('detail_mutasi_gudang', $data_detail);
        }
        $this->db->truncate('detail_lainlain_temp');
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Disimpan !
        </div>'
        );
        redirect('repackreject/lainlain');
      }
    }
  }


  function hapus_detailbrg($kode_produk, $kode_cabang)
  {
    //$query    = "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kodebarang'";
    $id_admin   = $this->session->userdata('id_user');
    //$this->db->query($query);
    $this->db->delete('detailrepackcab_temp', array('kode_produk' => $kode_produk, 'id_admin' => $id_admin, 'kode_cabang' => $kode_cabang));
  }

  function hapusrepack($no_repack)
  {
    $delete = $this->db->delete('mutasi_gudang_jadi', array('no_mutasi_gudang' => $no_repack));
    if ($delete) {
      $this->db->delete('detail_mutasi_gudang', array('no_mutasi_gudang' => $no_repack));
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil Di Hapus !
      </div>'
      );
      redirect('repackreject/repack');
    }
  }

  function getMutasiCab($nomutasi)
  {
    $this->db->where('no_mutasi_gudang_cabang', $nomutasi);
    return $this->db->get('mutasi_gudang_cabang');
  }

  function detail_mutasiCab($nomutasi)
  {
    $this->db->where('no_mutasi_gudang_cabang', $nomutasi);
    $this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
    return $this->db->get('detail_mutasi_gudang_cabang');
  }

  function view_detailrejectgudangtmp()
  {
    $id_admin = $this->session->userdata('id_user');
    $cabang   = $this->uri->segment(3);
    $this->db->select('detailrejectgudang_temp.kode_produk,nama_barang,isipcsdus,detailrejectgudang_temp.harga_dus,isipack,detailrejectgudang_temp.harga_pack,isipcs,jumlah,detailrejectgudang_temp.harga_pcs,kode_cabang');
    $this->db->from('detailrejectgudang_temp');
    $this->db->join('master_barang', 'detailrejectgudang_temp.kode_produk = master_barang.kode_produk');
    $this->db->where('id_admin', $id_admin);
    $this->db->where('kode_cabang', $cabang);
    return $this->db->get();
  }


  function insert_detailrejectgudangtmp()
  {
    $kode_produk  = $this->input->post('kode_produk');
    $jmldus       = $this->input->post('jmldus');
    $jmlpack      = $this->input->post('jmlpack');
    $jmlpcs       = $this->input->post('jmlpcs');
    $hargadus     = $this->input->post('hargadus');
    $hargapack    = $this->input->post('hargapack');
    $hargapcs     = $this->input->post('hargapcs');
    $cabang       = $this->input->post('cabang');
    $isipcsdus    = $this->input->post('isipcsdus');
    $isipcspack   = $this->input->post('isipcspack');
    $id_admin     = $this->session->userdata('id_user');
    $jumlah       = ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs;
    $brgtmp       = $this->db->get_where('detailrejectgudang_temp', array('kode_produk' => $kode_produk, 'id_admin' => $id_admin, 'kode_cabang' => $cabang));
    $cektmp       = $brgtmp->num_rows();
    if ($cektmp != 0) {
      echo "1";
    } else {
      $data = array(
        'kode_produk' => $kode_produk,
        'jumlah'      => $jumlah,
        'harga_dus'   => $hargadus,
        'harga_pack'  => $hargapack,
        'harga_pcs'   => $hargapcs,
        'id_admin'    => $id_admin,
        'kode_cabang' => $cabang
      );
      $this->db->insert('detailrejectgudang_temp', $data);
    }
  }

  function hapus_detailbrgrejectgudang($kode_produk, $kode_cabang)
  {
    //$query    = "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kodebarang'";
    $id_admin   = $this->session->userdata('id_user');
    //$this->db->query($query);
    $this->db->delete('detailrejectgudang_temp', array('kode_produk' => $kode_produk, 'id_admin' => $id_admin, 'kode_cabang' => $kode_cabang));
  }



  function insert_rejectgudang()
  {
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $no_sj             = $this->input->post('no_sj');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "BAD";
    $inout_good       = "OUT";
    $inout_bad        = "IN";
    $jenis_mutasi     = "REJECT GUDANG";
    $order            = 3;
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $tgl              = explode("-", $tanggal);
    $bulan            = $tgl[1];
    $tahun            = $tgl[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $data = array(
        'no_mutasi_gudang_cabang'  => $no_mutasi,
        'tgl_mutasi_gudang_cabang' => $tanggal,
        'no_suratjalan'            => $no_sj,
        'kode_cabang'              => $cabang,
        'kondisi'                  => $kondisi,
        'inout_good'               => $inout_good,
        'inout_bad'                 => $inout_bad,
        'jenis_mutasi'             => $jenis_mutasi,
        'order'                    => $order,
        'id_admin'                 => $id_admin
      );
      $cek  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      if (empty($cek) && empty($cekdpb)) {
        $simpanmutasi   = $this->db->insert('mutasi_gudang_cabang', $data);
        if ($simpanmutasi) {
          for ($i = 1; $i <= $jumproduk; $i++) {
            $kode_produk     = $this->input->post('kode_produk' . $i);
            $jmldus          = $this->input->post('jmldus' . $i);
            $jmlpack         = $this->input->post('jmlpack' . $i);
            $jmlpcs          = $this->input->post('jmlpcs' . $i);

            $isipcsdus       = $this->input->post('isipcsdus' . $i);
            $isipack         = $this->input->post('isipcspack' . $i);
            $isipcs          = $this->input->post('isipcs' . $i);

            $jumlah          = ($jmldus * $isipcsdus) + ($jmlpack * $isipcs) + $jmlpcs;

            $detail_mutasi   = array(
              'no_mutasi_gudang_cabang' => $no_mutasi,
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            if (!empty($jumlah)) {
              $simpandetailmutasi = $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
            }
          }
          $this->session->set_flashdata(
            'msg',
            '<div class="alert bg-green text-white alert-dismissible" role="alert">
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	            <i class="fa fa-check"></i> Data Berhasil Disimpan !
	          </div>'
          );
          redirect('repackreject/reject_gudang');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-info"></i> Data Sudah Ada !
	        </div>'
        );
        redirect('repackreject/inputrejectgudang');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/inputrejectgudang');
    }
  }

  public function getDataPNY($rowno, $rowperpage, $tanggal = "", $cabang = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.kode_cabang,keterangan,inout_good,inout_bad');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'PENYESUAIAN');
    if ($tanggal != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tanggal);
    }
    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordPNYCount($tanggal = "", $cabang = "")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->where('jenis_mutasi', 'PENYESUAIAN');

    if ($tanggal != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tanggal);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }
  function insert_penyesuaian()
  {
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $keterangan       = $this->input->post('keterangan');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "GOOD";
    $inout_good       = $this->input->post('inout');
    $jenis_mutasi     = "PENYESUAIAN";
    if ($inout_good == "IN") {
      $order            = 13;
    } else {
      $order            = 14;
    }

    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $tgl              = explode("-", $tanggal);
    $bulan            = $tgl[1];
    $tahun            = $tgl[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $data = array(
      'no_mutasi_gudang_cabang'  => $no_mutasi,
      'tgl_mutasi_gudang_cabang' => $tanggal,
      'keterangan'               => $keterangan,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      if (empty($cek) && empty($cekdpb)) {
        $simpanmutasi   = $this->db->insert('mutasi_gudang_cabang', $data);
        if ($simpanmutasi) {
          for ($i = 1; $i <= $jumproduk; $i++) {
            $kode_produk     = $this->input->post('kode_produk' . $i);
            $jmldus          = $this->input->post('jmldus' . $i);
            $jmlpack         = $this->input->post('jmlpack' . $i);
            $jmlpcs          = $this->input->post('jmlpcs' . $i);

            $isipcsdus       = $this->input->post('isipcsdus' . $i);
            $isipack         = $this->input->post('isipcspack' . $i);
            $isipcs          = $this->input->post('isipcs' . $i);

            $jumlah          = ($jmldus * $isipcsdus) + ($jmlpack * $isipcs) + $jmlpcs;

            $detail_mutasi   = array(
              'no_mutasi_gudang_cabang' => $no_mutasi,
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            if (!empty($jumlah)) {
              $simpandetailmutasi = $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
            }
          }
          $this->session->set_flashdata(
            'msg',
            '<div class="alert bg-green text-white alert-dismissible" role="alert">
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	            <i class="fa fa-check"></i> Data Berhasil Disimpan !
	          </div>'
          );
          redirect('repackreject/penyesuaian');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Sudah Ada !
	        </div>'
        );
        redirect('repackreject/inputpenyesuaian');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/inputpenyesuaian');
    }
  }

  function update_penyesuaian()
  {
    $no_mutasi        = $this->input->post('no_mutasi');
    $tanggal           = $this->input->post('tanggal');
    $cabang           = $this->input->post('cabang');
    $keterangan       = $this->input->post('keterangan');
    $inout_good       = $this->input->post('inout');
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    if ($inout_good == "IN") {
      $order            = 13;
    } else {
      $order            = 14;
    }
    $tgl              = explode("-", $tanggal);
    $bulan            = $tgl[1];
    $tahun            = $tgl[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $data = array(
      'tgl_mutasi_gudang_cabang' => $tanggal,
      'keterangan'               => $keterangan,
      'inout_good'               => $inout_good,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $updatepenjualan  = $this->db->update('mutasi_gudang_cabang', $data, array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($updatepenjualan) {
        for ($i = 1; $i <= $jumproduk; $i++) {
          $kode_produk     = $this->input->post('kode_produk' . $i);
          $jmldus          = $this->input->post('jmldus' . $i);
          $jmlpack         = $this->input->post('jmlpack' . $i);
          $jmlpcs          = $this->input->post('jmlpcs' . $i);

          $isipcsdus       = $this->input->post('isipcsdus' . $i);
          $isipack         = $this->input->post('isipcspack' . $i);
          $isipcs          = $this->input->post('isipcs' . $i);

          $jumlah          = ($jmldus * $isipcsdus) + ($jmlpack * $isipcs) + $jmlpcs;
          $cek_detail      = $this->db->get_where('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk))->num_rows();


          if (empty($cek_detail) && !empty($jumlah)) {
            $proses = "A";
            $detail_mutasi   = array(
              'no_mutasi_gudang_cabang' => $no_mutasi,
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
          } else if (!empty($cek_detail) && empty($jumlah)) {
            $proses = "B";
            $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
          } else if (!empty($cek_detail) && !empty($jumlah)) {
            $proses = "C";
            $detail_mutasi   = array(
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            $this->db->update('detail_mutasi_gudang_cabang', $detail_mutasi, array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
          } else {
            $proses = "";
          }
          echo $kode_produk . "-" . $cek_detail . "-" . $proses . "<br>";
        }
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Berhasil Disimpan !
	        </div>'
        );
        redirect('repackreject/penyesuaian');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/penyesuaian');
    }
  }

  function hapuspenyesuaian($no_penyesuaian, $cabang)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_penyesuaian))->row_array();
    $hariini     = $gettanggal['tgl_mutasi_gudang_cabang'];
    $tanggal     = explode("-", $hariini);
    $bulan       = $tanggal[1];
    $tahun       = $tanggal[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $delete = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_penyesuaian));
      if ($delete) {
        $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_penyesuaian));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Berhasil Di Hapus !
	        </div>'
        );
        redirect('repackreject/penyesuaian/');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
				</div>'
      );
      redirect('repackreject/penyesuaian');
    }
  }

  function update_penyesuaianbad()
  {
    $no_mutasi        = $this->input->post('no_mutasi');
    $tanggal           = $this->input->post('tanggal');
    $cabang           = $this->input->post('cabang');
    $keterangan       = $this->input->post('keterangan');
    //$inout_good       = $this->input->post('inout');
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $inout             = $this->input->post('inout');

    $jenis_mutasi     = "PENYESUAIAN BAD";
    if ($inout == "OUT") {
      $inout_good       = 'IN';
      $order            = 15;
    } else {
      $order            = 16;
      $inout_good       = '';
    }
    $tgl              = explode("-", $tanggal);
    $bulan            = $tgl[1];
    $tahun            = $tgl[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $data = array(
      'tgl_mutasi_gudang_cabang' => $tanggal,
      'keterangan'               => $keterangan,
      'inout_good'               => $inout_good,
      'inout_bad'                 => $inout,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $updatepenjualan  = $this->db->update('mutasi_gudang_cabang', $data, array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($updatepenjualan) {
        for ($i = 1; $i <= $jumproduk; $i++) {
          $kode_produk     = $this->input->post('kode_produk' . $i);
          $jmldus          = $this->input->post('jmldus' . $i);
          $jmlpack         = $this->input->post('jmlpack' . $i);
          $jmlpcs          = $this->input->post('jmlpcs' . $i);

          $isipcsdus       = $this->input->post('isipcsdus' . $i);
          $isipack         = $this->input->post('isipcspack' . $i);
          $isipcs          = $this->input->post('isipcs' . $i);

          $jumlah          = ($jmldus * $isipcsdus) + ($jmlpack * $isipcs) + $jmlpcs;
          $cek_detail      = $this->db->get_where('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk))->num_rows();


          if (empty($cek_detail) && !empty($jumlah)) {
            $proses = "A";
            $detail_mutasi   = array(
              'no_mutasi_gudang_cabang' => $no_mutasi,
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
          } else if (!empty($cek_detail) && empty($jumlah)) {
            $proses = "B";
            $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
          } else if (!empty($cek_detail) && !empty($jumlah)) {
            $proses = "C";
            $detail_mutasi   = array(
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            $this->db->update('detail_mutasi_gudang_cabang', $detail_mutasi, array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
          } else {
            $proses = "";
          }
          echo $kode_produk . "-" . $cek_detail . "-" . $proses . "<br>";
        }
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Berhasil Disimpan !
	        </div>'
        );
        redirect('repackreject/penyesuaianbad');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/penyesuaianbad');
    }
  }

  function hapusrejectgudang($no_rejectgudang, $cabang, $hal)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_rejectgudang))->row_array();
    $hariini     = $gettanggal['tgl_mutasi_gudang_cabang'];
    $tanggal     = explode("-", $hariini);
    $bulan       = $tanggal[1];
    $tahun       = $tanggal[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $delete = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_rejectgudang));
      if ($delete) {
        $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_rejectgudang));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Berhasil Di Hapus !
	        </div>'
        );
        redirect('repackreject/reject_gudang/' . $hal);
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/reject_gudang/' . $hal);
    }
  }


  function insert_detailpenyesuaianbadtemp()
  {
    $kode_produk  = $this->input->post('kode_produk');
    $jmldus       = $this->input->post('jmldus');
    $jmlpack      = $this->input->post('jmlpack');
    $jmlpcs       = $this->input->post('jmlpcs');
    $hargadus     = $this->input->post('hargadus');
    $hargapack    = $this->input->post('hargapack');
    $hargapcs     = $this->input->post('hargapcs');
    $salesman     = $this->input->post('salesman');
    $isipcsdus    = $this->input->post('isipcsdus');
    $isipcspack   = $this->input->post('isipcspack');
    $id_admin     = $this->session->userdata('id_user');
    $jumlah       = ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs;
    $brgtmp       = $this->db->get_where('detailpenyesuaianbad_temp', array('kode_produk' => $kode_produk, 'id_admin' => $id_admin, 'id_karyawan' => $salesman));
    $cektmp       = $brgtmp->num_rows();
    if ($cektmp != 0) {
      echo "1";
    } else {
      $data   = array(
        'kode_produk' => $kode_produk,
        'jumlah'      => $jumlah,
        'harga_dus'   => $hargadus,
        'harga_pack'  => $hargapack,
        'harga_pcs'   => $hargapcs,
        'id_admin'    => $id_admin,
        'id_karyawan' => $salesman
      );
      $this->db->insert('detailpenyesuaianbad_temp', $data);
    }
  }

  function view_detailpenyesuaianbadtemp()
  {
    $id_admin = $this->session->userdata('id_user');
    $salesman = $this->uri->segment(3);
    $this->db->select('detailpenyesuaianbad_temp.kode_produk,nama_barang,isipcsdus,detailpenyesuaianbad_temp.harga_dus,isipack,detailpenyesuaianbad_temp.harga_pack,isipcs,jumlah,detailpenyesuaianbad_temp.harga_pcs,id_karyawan');
    $this->db->from('detailpenyesuaianbad_temp');
    $this->db->join('master_barang', 'detailpenyesuaianbad_temp.kode_produk = master_barang.kode_produk');
    $this->db->where('id_admin', $id_admin);
    $this->db->where('id_karyawan', $salesman);
    return $this->db->get();
  }

  function hapus_detailbrgpenyesuaianbad($kode_produk, $salesman)
  {
    //$query    = "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kodebarang'";
    $id_admin   = $this->session->userdata('id_user');
    //$this->db->query($query);
    $this->db->delete('detailpenyesuaianbad_temp', array('kode_produk' => $kode_produk, 'id_admin' => $id_admin, 'id_karyawan' => $salesman));
  }


  function hapuspenyesuaianbad($no_penyesuaian, $cabang)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_penyesuaian))->row_array();
    $hariini     = $gettanggal['tgl_mutasi_gudang_cabang'];
    $tanggal     = explode("-", $hariini);
    $bulan       = $tanggal[1];
    $tahun       = $tanggal[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $delete = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_penyesuaian));
      if ($delete) {
        $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_penyesuaian));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Berhasil Di Hapus !
	        </div>'
        );
        redirect('repackreject/penyesuaianbad');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/penyesuaianbad');
    }
  }

  function getProduk($produk)
  {
    return $this->db->get_where('master_barang', array('kode_produk' => $produk));
  }


  public function getDataRJG($rowno, $rowperpage, $tanggal = "", $cabang = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.kode_cabang,no_suratjalan');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'REJECT GUDANG');
    if ($tanggal != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tanggal);
    }
    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordRJGCount($tanggal = "", $cabang = "")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->where('jenis_mutasi', 'REJECT GUDANG');

    if ($tanggal != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tanggal);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function jsonsj()
  {
    $url     = base_url();
    $cabang = $this->session->userdata('cabang');
    if ($cabang != "pusat") {
      $this->datatables->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    $this->datatables->where('jenis_mutasi', 'SURAT JALAN');
    $this->datatables->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,kode_cabang');
    $this->datatables->from('mutasi_gudang_cabang');
    $this->datatables->add_column('view', '<a href="#" data-nosj="$1"  class="btn btn-red btn-sm pilihpel">Pilih</a>', 'no_mutasi_gudang_cabang');
    return $this->datatables->generate();
  }

  function getMutasiPersediaan($nomutasi)
  {
    return $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $nomutasi));
  }

  function detailMutasiPersediaan($nomutasi)
  {
    $this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk = master_barang.kode_produk');
    return $this->db->get_where('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $nomutasi));
  }

  function update_rejectgudang()
  {
    $no_mutasi        = $this->input->post('no_mutasi');
    $tanggal           = $this->input->post('tanggal');
    $cabang           = $this->input->post('cabang');
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $data = array(
      'tgl_mutasi_gudang_cabang' => $tanggal,
      'id_admin'                 => $id_admin
    );
    $tgl              = explode("-", $tanggal);
    $bulan            = $tgl[1];
    $tahun            = $tgl[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $data = array(
      'tgl_mutasi_gudang_cabang' => $tanggal,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $updatepenjualan  = $this->db->update('mutasi_gudang_cabang', $data, array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($updatepenjualan) {
        for ($i = 1; $i <= $jumproduk; $i++) {
          $kode_produk     = $this->input->post('kode_produk' . $i);
          $jmldus          = $this->input->post('jmldus' . $i);
          $jmlpack         = $this->input->post('jmlpack' . $i);
          $jmlpcs          = $this->input->post('jmlpcs' . $i);

          $isipcsdus       = $this->input->post('isipcsdus' . $i);
          $isipack         = $this->input->post('isipcspack' . $i);
          $isipcs          = $this->input->post('isipcs' . $i);

          $jumlah          = ($jmldus * $isipcsdus) + ($jmlpack * $isipcs) + $jmlpcs;
          $cek_detail      = $this->db->get_where('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk))->num_rows();


          if (empty($cek_detail) && !empty($jumlah)) {
            $proses = "A";
            $detail_mutasi   = array(
              'no_mutasi_gudang_cabang' => $no_mutasi,
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
          } else if (!empty($cek_detail) && empty($jumlah)) {
            $proses = "B";
            $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
          } else if (!empty($cek_detail) && !empty($jumlah)) {
            $proses = "C";
            $detail_mutasi   = array(
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            $this->db->update('detail_mutasi_gudang_cabang', $detail_mutasi, array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
          } else {
            $proses = "";
          }
          echo $kode_produk . "-" . $cek_detail . "-" . $proses . "<br>";
        }
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Berhasil Disimpan !
	        </div>'
        );
        redirect('repackreject/reject_gudang');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/reject_gudang');
    }
  }

  public function getDataPYB($rowno, $rowperpage, $tanggal = "", $cabang = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.kode_cabang,keterangan,inout_good,inout_bad');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'PENYESUAIAN BAD');
    if ($tanggal != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tanggal);
    }
    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordPYBCount($tanggal = "", $cabang = "")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->where('jenis_mutasi', 'PENYESUAIAN BAD');

    if ($tanggal != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tanggal);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


  function insert_penyesuaianbad()
  {
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $keterangan       = $this->input->post('keterangan');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "BAD";
    $inout             = $this->input->post('inout');

    $jenis_mutasi     = "PENYESUAIAN BAD";
    if ($inout == "OUT") {
      $inout_good       = 'IN';
      $order            = 15;
    } else {
      $order            = 16;
      $inout_good       = '';
    }

    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $tgl              = explode("-", $tanggal);
    $bulan            = $tgl[1];
    $tahun            = $tgl[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $data = array(
      'no_mutasi_gudang_cabang'  => $no_mutasi,
      'tgl_mutasi_gudang_cabang' => $tanggal,
      'keterangan'               => $keterangan,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'inout_bad'                 => $inout,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      if (empty($cek) && empty($cekdpb)) {
        $simpanmutasi   = $this->db->insert('mutasi_gudang_cabang', $data);
        if ($simpanmutasi) {
          for ($i = 1; $i <= $jumproduk; $i++) {
            $kode_produk     = $this->input->post('kode_produk' . $i);
            $jmldus          = $this->input->post('jmldus' . $i);
            $jmlpack         = $this->input->post('jmlpack' . $i);
            $jmlpcs          = $this->input->post('jmlpcs' . $i);

            $isipcsdus       = $this->input->post('isipcsdus' . $i);
            $isipack         = $this->input->post('isipcspack' . $i);
            $isipcs          = $this->input->post('isipcs' . $i);

            $jumlah          = ($jmldus * $isipcsdus) + ($jmlpack * $isipcs) + $jmlpcs;

            $detail_mutasi   = array(
              'no_mutasi_gudang_cabang' => $no_mutasi,
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            if (!empty($jumlah)) {
              $simpandetailmutasi = $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
            }
          }
          $this->session->set_flashdata(
            'msg',
            '<div class="alert bg-green text-white alert-dismissible" role="alert">
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	            <i class="fa fa-check"></i> Data Berhasil Disimpan !
	          </div>'
          );
          redirect('repackreject/penyesuaianbad');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Sudah Ada !
	        </div>'
        );
        redirect('repackreject/inputpenyesuaianbad');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/inputpenyesuaianbad');
    }
  }

  public function getDataRepackcab($rowno, $rowperpage, $tanggal = "", $cabang = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.kode_cabang,keterangan,inout_good,inout_bad');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'REPACK');
    if ($tanggal != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tanggal);
    }
    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordRepackcabCount($tanggal = "", $cabang = "")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->where('jenis_mutasi', 'REPACK');

    if ($tanggal != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tanggal);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


  function insert_repackcab()
  {
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "BAD";
    $inout_good       = "IN";
    $inout_bad        = "OUT";
    $jenis_mutasi     = "REPACK";
    $order            = 17;
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $tgl              = explode("-", $tanggal);
    $bulan            = $tgl[1];
    $tahun            = $tgl[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $data = array(
      'no_mutasi_gudang_cabang'  => $no_mutasi,
      'tgl_mutasi_gudang_cabang' => $tanggal,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'inout_bad'                 => $inout_bad,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      if (empty($cek) && empty($cekdpb)) {
        $simpanmutasi   = $this->db->insert('mutasi_gudang_cabang', $data);
        if ($simpanmutasi) {
          for ($i = 1; $i <= $jumproduk; $i++) {
            $kode_produk     = $this->input->post('kode_produk' . $i);
            $jmldus          = $this->input->post('jmldus' . $i);
            $jmlpack         = $this->input->post('jmlpack' . $i);
            $jmlpcs          = $this->input->post('jmlpcs' . $i);

            $isipcsdus       = $this->input->post('isipcsdus' . $i);
            $isipack         = $this->input->post('isipcspack' . $i);
            $isipcs          = $this->input->post('isipcs' . $i);

            $jumlah          = ($jmldus * $isipcsdus) + ($jmlpack * $isipcs) + $jmlpcs;

            $detail_mutasi   = array(
              'no_mutasi_gudang_cabang' => $no_mutasi,
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            if (!empty($jumlah)) {
              $simpandetailmutasi = $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
            }
          }
          $this->session->set_flashdata(
            'msg',
            '<div class="alert bg-green text-white alert-dismissible" role="alert">
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	            <i class="fa fa-check"></i> Data Berhasil Disimpan !
	          </div>'
          );
          redirect('repackreject/repackcab');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Sudah Ada !
	        </div>'
        );
        redirect('repackreject/inputrepackcab');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/inputrepackcab');
    }
  }

  function update_repackcab()
  {
    $no_mutasi        = $this->input->post('no_mutasi');
    $tanggal           = $this->input->post('tanggal');
    $cabang           = $this->input->post('cabang');
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $tgl              = explode("-", $tanggal);
    $bulan            = $tgl[1];
    $tahun            = $tgl[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $data = array(
      'tgl_mutasi_gudang_cabang' => $tanggal,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $updatepenjualan  = $this->db->update('mutasi_gudang_cabang', $data, array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($updatepenjualan) {
        for ($i = 1; $i <= $jumproduk; $i++) {
          $kode_produk     = $this->input->post('kode_produk' . $i);
          $jmldus          = $this->input->post('jmldus' . $i);
          $jmlpack         = $this->input->post('jmlpack' . $i);
          $jmlpcs          = $this->input->post('jmlpcs' . $i);
          $isipcsdus       = $this->input->post('isipcsdus' . $i);
          $isipack         = $this->input->post('isipcspack' . $i);
          $isipcs          = $this->input->post('isipcs' . $i);
          $jumlah          = ($jmldus * $isipcsdus) + ($jmlpack * $isipcs) + $jmlpcs;
          $cek_detail      = $this->db->get_where('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk))->num_rows();
          if (empty($cek_detail) && !empty($jumlah)) {
            $proses = "A";
            $detail_mutasi   = array(
              'no_mutasi_gudang_cabang' => $no_mutasi,
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
          } else if (!empty($cek_detail) && empty($jumlah)) {
            $proses = "B";
            $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
          } else if (!empty($cek_detail) && !empty($jumlah)) {
            $proses = "C";
            $detail_mutasi   = array(
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            $this->db->update('detail_mutasi_gudang_cabang', $detail_mutasi, array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
          } else {
            $proses = "";
          }
          echo $kode_produk . "-" . $cek_detail . "-" . $proses . "<br>";
        }
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Berhasil Disimpan !
	        </div>'
        );
        redirect('repackreject/repackcab');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/repackcab');
    }
  }

  function hapusrepackcab($norepack, $cabang, $hal)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $norepack))->row_array();
    $hariini     = $gettanggal['tgl_mutasi_gudang_cabang'];
    $tanggal     = explode("-", $hariini);
    $bulan       = $tanggal[1];
    $tahun       = $tanggal[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $delete = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $norepack));
      if ($delete) {
        $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $norepack));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Berhasil Di Hapus !
	        </div>'
        );
        redirect('repackreject/repackcab/' . $hal);
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/repackcab');
    }
  }

  public function getDataKirimPusat($rowno, $rowperpage, $tanggal = "", $cabang = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.kode_cabang,keterangan,inout_good,inout_bad');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'KIRIM PUSAT');
    if ($tanggal != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tanggal);
    }
    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordKirimPusatCount($tanggal = "", $cabang = "")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->where('jenis_mutasi', 'KIRIM PUSAT');

    if ($tanggal != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tanggal);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }

    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function insert_kirimpusat()
  {
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "BAD";
    $inout_bad        = "OUT";
    $jenis_mutasi     = "KIRIM PUSAT";
    $order            = 19;
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $tgl              = explode("-", $tanggal);
    $bulan            = $tgl[1];
    $tahun            = $tgl[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $data = array(
      'no_mutasi_gudang_cabang'  => $no_mutasi,
      'tgl_mutasi_gudang_cabang' => $tanggal,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_bad'                 => $inout_bad,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      if (empty($cek) && empty($cekdpb)) {
        $simpanmutasi   = $this->db->insert('mutasi_gudang_cabang', $data);
        if ($simpanmutasi) {
          for ($i = 1; $i <= $jumproduk; $i++) {
            $kode_produk     = $this->input->post('kode_produk' . $i);
            $jmldus          = $this->input->post('jmldus' . $i);
            $jmlpack         = $this->input->post('jmlpack' . $i);
            $jmlpcs          = $this->input->post('jmlpcs' . $i);

            $isipcsdus       = $this->input->post('isipcsdus' . $i);
            $isipack         = $this->input->post('isipcspack' . $i);
            $isipcs          = $this->input->post('isipcs' . $i);

            $jumlah          = ($jmldus * $isipcsdus) + ($jmlpack * $isipcs) + $jmlpcs;

            $detail_mutasi   = array(
              'no_mutasi_gudang_cabang' => $no_mutasi,
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            if (!empty($jumlah)) {
              $simpandetailmutasi = $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
            }
          }
          $this->session->set_flashdata(
            'msg',
            '<div class="alert bg-green text-white alert-dismissible" role="alert">
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	            <i class="fa fa-check"></i> Data Berhasil Disimpan !
	          </div>'
          );
          redirect('repackreject/kirimpusat');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Sudah Ada !
	        </div>'
        );
        redirect('repackreject/inputkirimpusat');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/inputkirimpusat');
    }
  }

  function update_kirimpusat()
  {
    $no_mutasi        = $this->input->post('no_mutasi');
    $tanggal           = $this->input->post('tanggal');
    $cabang           = $this->input->post('cabang');
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $data = array(
      'tgl_mutasi_gudang_cabang' => $tanggal,
      'id_admin'                 => $id_admin
    );
    $tgl              = explode("-", $tanggal);
    $bulan            = $tgl[1];
    $tahun            = $tgl[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $updatepenjualan  = $this->db->update('mutasi_gudang_cabang', $data, array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($updatepenjualan) {
        for ($i = 1; $i <= $jumproduk; $i++) {
          $kode_produk     = $this->input->post('kode_produk' . $i);
          $jmldus          = $this->input->post('jmldus' . $i);
          $jmlpack         = $this->input->post('jmlpack' . $i);
          $jmlpcs          = $this->input->post('jmlpcs' . $i);

          $isipcsdus       = $this->input->post('isipcsdus' . $i);
          $isipack         = $this->input->post('isipcspack' . $i);
          $isipcs          = $this->input->post('isipcs' . $i);

          $jumlah          = ($jmldus * $isipcsdus) + ($jmlpack * $isipcs) + $jmlpcs;
          $cek_detail      = $this->db->get_where('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk))->num_rows();


          if (empty($cek_detail) && !empty($jumlah)) {
            $proses = "A";
            $detail_mutasi   = array(
              'no_mutasi_gudang_cabang' => $no_mutasi,
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
          } else if (!empty($cek_detail) && empty($jumlah)) {
            $proses = "B";
            $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
          } else if (!empty($cek_detail) && !empty($jumlah)) {
            $proses = "C";
            $detail_mutasi   = array(
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );
            $this->db->update('detail_mutasi_gudang_cabang', $detail_mutasi, array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
          } else {
            $proses = "";
          }
          echo $kode_produk . "-" . $cek_detail . "-" . $proses . "<br>";
        }
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Berhasil Disimpan !
	        </div>'
        );
        redirect('repackreject/kirimpusat');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
				</div>'
      );
      redirect('repackreject/kirimpusat');
    }
  }

  function hapuskirimpusat($nokirimpusat, $cabang, $hal)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $nokirimpusat))->row_array();
    $hariini     = $gettanggal['tgl_mutasi_gudang_cabang'];
    $tanggal     = explode("-", $hariini);
    $bulan       = $tanggal[1];
    $tahun       = $tanggal[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $delete = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $nokirimpusat));
      if ($delete) {
        $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $nokirimpusat));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <i class="fa fa-check"></i> Data Berhasil Di Hapus !
	        </div>'
        );
        redirect('repackreject/kirimpusat/' . $hal);
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('repackreject/kirimpusat/' . $hal);
    }
  }
}
