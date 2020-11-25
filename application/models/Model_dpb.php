<?php
error_reporting(0);
class Model_dpb extends CI_Model
{
  function insert_dpb()
  {
    $nodpb            = $this->input->post('nodpb');
    $kode_cabang      = $this->input->post('cabang');
    $salesman         = $this->input->post('salesman');
    $tujuan           = $this->input->post('tujuan');
    $nokendaraan      = $this->input->post('nokendaraan');
    $tgl_pengambilan  = $this->input->post('tglambil');
    $tgl_pengembalian = $this->input->post('tglkembali');
    $jumproduk        = $this->input->post('jumproduk');
    $data = array(
      'no_dpb'             => $nodpb,
      'kode_cabang'        => $kode_cabang,
      'id_karyawan'        => $salesman,
      'tujuan'             => $tujuan,
      'no_kendaraan'       => $nokendaraan,
      'tgl_pengambilan'    => $tgl_pengambilan,
    );
    $simpandbp        = $this->db->insert('dpb', $data);
    if ($simpandbp) {
      for ($i = 1; $i <= $jumproduk; $i++) {
        $kode_produk    = $this->input->post('kode_produk' . $i);
        $jmlpengambilan = $this->input->post('jmlpengambilan' . $i);
        $data_detail   = array(
          'no_dpb'             => $nodpb,
          'kode_produk'        => $kode_produk,
          'jml_pengambilan'   => $jmlpengambilan
        );
        if (!empty($jmlpengambilan)) {
          $detail_dpb = $this->db->insert('detail_dpb', $data_detail);
        }
      }
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Simpan !
        </div>'
      );
      redirect('dpb');
    }
  }

  function update_dpb()
  {
    $nodpb            = $this->input->post('nodpb');
    $kode_cabang      = $this->input->post('cabang');
    $salesman         = $this->input->post('salesman');
    $tujuan           = $this->input->post('tujuan');
    $nokendaraan      = $this->input->post('nokendaraan');
    $tgl_pengambilan  = $this->input->post('tglambil');
    $tgl_pengembalian = $this->input->post('tglkembali');
    $jumproduk        = $this->input->post('jumproduk');
    if (empty($tgl_pengambilan)) {
      $data = array(
        'kode_cabang'        => $kode_cabang,
        'id_karyawan'        => $salesman,
        'tujuan'             => $tujuan,
        'no_kendaraan'       => $nokendaraan,
        'tgl_pengambilan'    => $tgl_pengambilan,
      );
    } else {
      $data = array(
        'kode_cabang'        => $kode_cabang,
        'id_karyawan'        => $salesman,
        'tujuan'             => $tujuan,
        'no_kendaraan'       => $nokendaraan,
        'tgl_pengambilan'    => $tgl_pengambilan,
        'tgl_pengembalian'   => $tgl_pengembalian
      );
    }

    $simpandbp        = $this->db->update('dpb', $data, array('no_dpb' => $nodpb));
    if ($simpandbp) {
      for ($i = 1; $i <= $jumproduk; $i++) {
        $kode_produk     = $this->input->post('kode_produk' . $i);
        $jmlpengambilan  = $this->input->post('jmlpengambilan' . $i);
        $jmlpengembalian = $this->input->post('jmlpengembalian' . $i);
        $jmlbrgkeluar    = $this->input->post('jmlbrgkeluar' . $i);
        $cek_detail      = $this->db->get_where('detail_dpb', array('no_dpb' => $nodpb, 'kode_produk' => $kode_produk))->num_rows();
        if (empty($tgl_pengembalian)) {
          if (empty($cek_detail) && !empty($jmlpengambilan)) {
            $proses = "PROSES A";
            $data_detail   = array(
              'no_dpb'             => $nodpb,
              'kode_produk'        => $kode_produk,
              'jml_pengambilan'   => $jmlpengambilan
            );
            $this->db->insert('detail_dpb', $data_detail);
          } else if (!empty($cek_detail) && empty($jmlpengambilan)) {
            $proses = "PROSES B";
            $this->db->delete('detail_dpb', array('no_dpb' => $nodpb, 'kode_produk' => $kode_produk));
          } else if (!empty($cek_detail) && !empty($jmlpengambilan)) {
            $proses = "PROSES C";
            $data_detail   = array(
              'jml_pengambilan'   => $jmlpengambilan
            );
            $this->db->update('detail_dpb', $data_detail, array('no_dpb' => $nodpb, 'kode_produk' => $kode_produk));
          } else {
            $proses = "";
          }
        } else {
          if (empty($cek_detail) && !empty($jmlpengambilan) or empty($cek_detail) && !empty($jmlpengembalian)) {
            $proses = "PROSES A";
            $data_detail   = array(
              'no_dpb'             => $nodpb,
              'kode_produk'        => $kode_produk,
              'jml_pengambilan'   => $jmlpengambilan,
              'jml_pengembalian'  => $jmlpengembalian,
              'jml_penjualan'     => $jmlbrgkeluar
            );


            $this->db->insert('detail_dpb', $data_detail);
          } else if (!empty($cek_detail) && empty($jmlpengambilan)) {
            $proses = "PROSES B";
            $this->db->delete('detail_dpb', array('no_dpb' => $nodpb, 'kode_produk' => $kode_produk));
          } else if (!empty($cek_detail) && !empty($jmlpengambilan) or !empty($cek_detail) && !empty($jmlpengembalian)) {
            $proses = "PROSES C";
            $data_detail   = array(
              'jml_pengambilan'   => $jmlpengambilan,
              'jml_pengembalian'  => $jmlpengembalian,
              'jml_penjualan'     => $jmlbrgkeluar
            );
            $this->db->update('detail_dpb', $data_detail, array('no_dpb' => $nodpb, 'kode_produk' => $kode_produk));
          } else {
            $proses = "";
          }
        }
        echo $kode_produk . " - " . $cek_detail . " " . $proses . "<br>";
      }


      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <i class="fa fa-check"></i> Data Berhasil Di Simpan !
        </div>'
      );
      redirect('dpb');
    }
  }

  function update_penjualan()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $id_karyawan      = $this->input->post('id_karyawan');
    $cabang           = $this->input->post('cabang');
    $tgl_penjualan    = $this->input->post('tgl_penjualan');
    $kondisi          = "GOOD";
    $inout_good       = "OUT";
    $jenis_mutasi     = "PENJUALAN";
    $order            = 4;
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $tgl              = explode("-", $tgl_penjualan);
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
      'tgl_mutasi_gudang_cabang' => $tgl_penjualan,
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'jenis_mutasi'             => $jenis_mutasi,
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
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Disimpan !
          </div>'
        );
        redirect('dpb/penjualan');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/penjualan');
    }
  }
  public function getDataDpb($rowno, $rowperpage, $no_dpb = "", $tgl_pengambilan = "", $cabang = "", $salesman = "")
  {
    $this->db->select('no_dpb,dpb.kode_cabang,dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan,tgl_pengambilan');
    $this->db->from('dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->order_by('tgl_pengambilan', 'desc');
    if ($no_dpb != '') {
      $this->db->where('no_dpb', $no_dpb);
    }
    if ($tgl_pengambilan != '') {
      $this->db->where('tgl_pengambilan', $tgl_pengambilan);
    }

    if ($cabang != '') {
      $this->db->where('dpb.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordDpbCount($no_dpb = "", $tgl_pengambilan = "", $cabang = "", $salesman = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->order_by('tgl_pengambilan', 'desc');
    if ($no_dpb != '') {
      $this->db->where('no_dpb', $no_dpb);
    }
    if ($tgl_pengambilan != '') {
      $this->db->where('tgl_pengambilan', $tgl_pengambilan);
    }

    if ($cabang != '') {
      $this->db->where('dpb.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function getMutasiPenjualan($nomutasi)
  {

    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    return $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $nomutasi));
  }

  function getDpb($no_dpb)
  {
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    return $this->db->get_where('dpb', array('no_dpb' => $no_dpb));
  }

  function detaildpb($no_dpb)
  {
    $this->db->join('master_barang', 'detail_dpb.kode_produk = master_barang.kode_produk');
    return $this->db->get_where('detail_dpb', array('no_dpb' => $no_dpb));
  }

  function detailMutasiPenjualan($nomutasi)
  {
    $this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk = master_barang.kode_produk');
    return $this->db->get_where('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $nomutasi));
  }

  function jsondpb()
  {
    $url     = base_url();
    $cabang = $this->session->userdata('cabang');
    if ($cabang != "pusat") {
      $this->datatables->where('dpb.kode_cabang', $cabang);
    }
    $this->datatables->select('no_dpb,dpb.kode_cabang,tgl_pengambilan,dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan');
    $this->datatables->from('dpb');
    $this->datatables->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->datatables->add_column('view', '<a href="#" data-nodpb="$1" data-idkaryawan="$7" data-tglpengambilan="$3" data-cabang="$2" data-salesman="$4" data-tujuan="$5" data-nokendaraan="$6"   class="btn btn-red btn-sm text-white pilihpel">Pilih</a>', 'no_dpb,kode_cabang,tgl_pengambilan,nama_karyawan,tujuan,no_kendaraan,id_karyawan');
    return $this->datatables->generate();
  }

  function insert_penjualan()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tgl_penjualan    = $this->input->post('tgl_penjualan');
    $kondisi          = "GOOD";
    $inout_good       = "OUT";
    $jenis_mutasi     = "PENJUALAN";
    $order            = 4;
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $tgl              = explode("-", $tgl_penjualan);
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
      'tgl_mutasi_gudang_cabang' => $tgl_penjualan,
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek            = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      $cekdpb         = $this->db->get_where('mutasi_gudang_cabang', array('no_dpb' => $nodpb, 'tgl_mutasi_gudang_cabang' => $tgl_penjualan, 'jenis_mutasi' => 'PENJUALAN'))->num_rows();
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
            '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-check"></i> Data Berhasil Disimpan !
            </div>'
          );
          redirect('dpb/penjualan');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info  "></i> Data Sudah Ada !
          </div>'
        );
        redirect('dpb/inputpenjualan');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check "></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/inputpenjualan');
    }
  }

  public function getDataPenjualanDpb($rowno, $rowperpage, $no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,mutasi_gudang_cabang.kode_cabang,
                      dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'PENJUALAN');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordPenjualanDpbCount($no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->where('jenis_mutasi', 'PENJUALAN');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function hapuspenjualan($no_mutasi, $cabang)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->row_array();
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
      $hapus = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($hapus) {
        $hapus_detail = $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Di Hapus !
          </div>'
        );
        redirect('dpb/penjualan');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/penjualan');
    }
  }

  public function getDataReturDpb($rowno, $rowperpage, $no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,mutasi_gudang_cabang.kode_cabang,
                      dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->where('jenis_mutasi', 'RETUR');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordReturDpbCount($no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->where('jenis_mutasi', 'RETUR');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function insert_retur()
  {

    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    // $no_reject        = str_replace("RTR", "RJP", $no_mutasi);
    $cabang           = $this->input->post('cabang');
    $tgl_retur        = $this->input->post('tgl_retur');
    $tanggal          = explode("-", $tgl_retur);
    $bulan            = $tanggal[1];
    $tahun            = $tanggal[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $kondisi          = "GOOD";
    // $kondisi_reject   = "BAD";
    $inout_good       = "IN";
    // $inout_goodrej    = "OUT";
    // $inout_bad        = "IN";
    $jenis_mutasi     = "RETUR";
    // $jenis_mutasirej  = "REJECT PASAR";
    $order            = 10;
    // $order_rej        = 6;
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    $data = array(
      'no_mutasi_gudang_cabang'  => $no_mutasi,
      'tgl_mutasi_gudang_cabang' => $tgl_retur,
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );

    // $datareject = array(
    //   'no_mutasi_gudang_cabang'  => $no_reject,
    //   'tgl_mutasi_gudang_cabang' => $tgl_retur,
    //   'no_dpb'                   => $nodpb,
    //   'kode_cabang'              => $cabang,
    //   'kondisi'                  => $kondisi_reject,
    //   'inout_good'               => $inout_goodrej,
    //   'jenis_mutasi'             => $jenis_mutasirej,
    //   'order'                    => $order_rej,
    //   'id_admin'                 => $id_admin
    // );
    if (empty($ceksa)) {

      $cek        = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      $cekdpb     = $this->db->get_where('mutasi_gudang_cabang', array('no_dpb' => $nodpb, 'tgl_mutasi_gudang_cabang' => $tgl_retur, 'jenis_mutasi' => 'RETUR'))->num_rows();
      if (empty($cek) && empty($cekdpb)) {
        $simpanmutasi   = $this->db->insert('mutasi_gudang_cabang', $data);
        // $simpanreject   = $this->db->insert('mutasi_gudang_cabang',$datareject);
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

            // $detail_mutasireject   = array (
            //   'no_mutasi_gudang_cabang' => $no_reject,
            //   'kode_produk'             => $kode_produk,
            //   'jumlah'                  => $jumlah
            // );
            if (!empty($jumlah)) {
              $simpandetailmutasi        = $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
              // $simpandetailmutasi_reject = $this->db->insert('detail_mutasi_gudang_cabang',$detail_mutasireject);
            }
          }
          $this->session->set_flashdata(
            'msg',
            '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-check"></i> Data Berhasil Disimpan !
            </div>'
          );
          redirect('dpb/retur');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info"></i> Data Sudah Ada !
          </div>'
        );
        redirect('dpb/inputretur');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/inputretur');
    }
  }


  function update_retur()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    // $no_reject        = str_replace("RTR", "RJP", $no_mutasi);
    $id_karyawan      = $this->input->post('id_karyawan');
    $cabang           = $this->input->post('cabang');
    $tgl_retur        = $this->input->post('tgl_retur');
    $tanggal          = explode("-", $tgl_retur);
    $bulan            = $tanggal[1];
    $tahun            = $tanggal[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $kondisi          = "GOOD";
    $inout_good       = "IN";
    // $inout_goodrej    = "OUT";
    // $inout_bad        = "IN";
    $jenis_mutasi     = "RETUR";
    // $jenis_mutasirej  = "REJECT PASAR";
    $order            = 10;
    // $order_rej        = 6;
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    $data = array(
      'tgl_mutasi_gudang_cabang' => $tgl_retur,
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );

    // $datareject = array(
    //   'tgl_mutasi_gudang_cabang' => $tgl_retur,
    //   'no_dpb'                   => $nodpb,
    //   'kode_cabang'              => $cabang,
    //   'kondisi'                  => $kondisi_reject,
    //   'inout_good'               => $inout_goodrej,
    //   'jenis_mutasi'             => $jenis_mutasirej,
    //   'order'                    => $order_rej,
    //   'id_admin'                 => $id_admin
    // );
    if (empty($ceksa)) {
      $updatepenjualan  = $this->db->update('mutasi_gudang_cabang', $data, array('no_mutasi_gudang_cabang' => $no_mutasi));
      // $updatereject     = $this->db->update('mutasi_gudang_cabang',$datareject,array('no_mutasi_gudang_cabang'=>$no_reject));
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

            // $detail_mutasireject   = array (
            //   'no_mutasi_gudang_cabang' => $no_reject,
            //   'kode_produk'             => $kode_produk,
            //   'jumlah'                  => $jumlah
            // );
            $this->db->insert('detail_mutasi_gudang_cabang', $detail_mutasi);
            // $this->db->insert('detail_mutasi_gudang_cabang',$detail_mutasireject);
          } else if (!empty($cek_detail) && empty($jumlah)) {
            $proses = "B";
            $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
            // $this->db->delete('detail_mutasi_gudang_cabang',array('no_mutasi_gudang_cabang'=>$no_reject,'kode_produk'=>$kode_produk));
          } else if (!empty($cek_detail) && !empty($jumlah)) {
            $proses = "C";
            $detail_mutasi   = array(
              'kode_produk'             => $kode_produk,
              'jumlah'                  => $jumlah
            );

            // $detail_mutasireject   = array (
            //   'kode_produk'             => $kode_produk,
            //   'jumlah'                  => $jumlah
            // );
            $this->db->update('detail_mutasi_gudang_cabang', $detail_mutasi, array('no_mutasi_gudang_cabang' => $no_mutasi, 'kode_produk' => $kode_produk));
            // $this->db->update('detail_mutasi_gudang_cabang',$detail_mutasireject,array('no_mutasi_gudang_cabang'=>$no_reject,'kode_produk'=>$kode_produk));
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
        redirect('dpb/retur');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/retur');
    }
  }

  function hapusretur($no_mutasi, $cabang)
  {
    // $no_reject   = str_replace("RTR","RJP",$no_mutasi);
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->row_array();
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
      $hapus       = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
      // $hapusreject = $this->db->delete('mutasi_gudang_cabang',array('no_mutasi_gudang_cabang'=>$no_reject));
      if ($hapus) {
        $hapus_detail       = $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
        // $hapus_detailreject = $this->db->delete('detail_mutasi_gudang_cabang',array('no_mutasi_gudang_cabang'=>$no_reject));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Di Hapus !
          </div>'
        );
        redirect('dpb/retur');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/retur');
    }
  }

  public function getDataGBDpb($rowno, $rowperpage, $no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,mutasi_gudang_cabang.kode_cabang,
                      dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'GANTI BARANG');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordGBDpbCount($no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->where('jenis_mutasi', 'GANTI BARANG');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function insert_gb()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "GOOD";
    $inout_good       = "OUT";
    $jenis_mutasi     = "GANTI BARANG";
    $order            = 7;
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek            = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      $cekdpb         = $this->db->get_where('mutasi_gudang_cabang', array('no_dpb' => $nodpb, 'tgl_mutasi_gudang_cabang' => $tanggal, 'jenis_mutasi' => 'GANTI BARANG'))->num_rows();
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
            '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-check"></i> Data Berhasil Disimpan !
            </div>'
          );
          redirect('dpb/gantibarang');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info"></i> Data Sudah Ada !
          </div>'
        );
        redirect('dpb/inputgb');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/inputgb');
    }
  }

  function update_gb()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "GOOD";
    $inout_good       = "OUT";
    $jenis_mutasi     = "GANTI BARANG";
    $order            = 7;
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
      $data = array(
        'tgl_mutasi_gudang_cabang' => $tanggal,
        'no_dpb'                   => $nodpb,
        'kode_cabang'              => $cabang,
        'kondisi'                  => $kondisi,
        'inout_good'               => $inout_good,
        'jenis_mutasi'             => $jenis_mutasi,
        'order'                    => $order,
        'id_admin'                 => $id_admin
      );

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
        redirect('dpb/gantibarang');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/gantibarang');
    }
  }


  function hapusgb($no_mutasi, $cabang)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->row_array();
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
      $hapus = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($hapus) {
        $hapus_detail = $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Di Hapus !
          </div>'
        );
        redirect('dpb/gantibarang');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/gantibarang');
    }
  }

  public function getDataRJPDpb($rowno, $rowperpage, $no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,mutasi_gudang_cabang.kode_cabang,
                      dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'REJECT PASAR');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordRJPDpbCount($no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->where('jenis_mutasi', 'REJECT PASAR');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


  function insert_rejectpasar()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "BAD";
    $inout_good       = "OUT";
    $inout_bad        = "IN";
    $jenis_mutasi     = "REJECT PASAR";
    $order            = 11;
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'inout_bad'                => $inout_bad,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek            = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      $cekdpb         = $this->db->get_where('mutasi_gudang_cabang', array('no_dpb' => $nodpb, 'tgl_mutasi_gudang_cabang' => $tanggal, 'jenis_mutasi' => 'REJECT PASAR'))->num_rows();
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
            '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-check"></i> Data Berhasil Disimpan !
            </div>'
          );
          redirect('dpb/rejectpasar');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info"></i> Data Sudah Ada !
          </div>'
        );
        redirect('dpb/inputrejectpasar');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/inputrejectpasar');
    }
  }

  function update_rejectpasar()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
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
        redirect('dpb/rejectpasar');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/rejectpasar');
    }
  }

  function hapusrejectpasar($no_mutasi, $cabang)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->row_array();
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
      $hapus = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($hapus) {
        $hapus_detail = $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Di Hapus !
          </div>'
        );
        redirect('dpb/rejectpasar');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/rejectpasar');
    }
  }

  public function getDataHKDpb($rowno, $rowperpage, $no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,mutasi_gudang_cabang.kode_cabang,
                      dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'HUTANG KIRIM');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordHKDpbCount($no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->where('jenis_mutasi', 'HUTANG KIRIM');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }



  function insert_hutangkirim()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "GOOD";
    $inout_good       = "IN";
    $jenis_mutasi     = "HUTANG KIRIM";
    $order            = 5;
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek            = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      $cekdpb         = $this->db->get_where('mutasi_gudang_cabang', array('no_dpb' => $nodpb, 'tgl_mutasi_gudang_cabang' => $tanggal, 'jenis_mutasi' => 'HUTANG KIRIM'))->num_rows();
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
            '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-chek"></i> Data Berhasil Disimpan !
            </div>'
          );
          redirect('dpb/hutangkirim');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info"></i> Data Sudah Ada !
          </div>'
        );
        redirect('dpb/inputhutangkirim');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/inputhutangkirim');
    }
  }

  function update_hutangkirim()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
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
        redirect('dpb/hutangkirim');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/hutangkirim');
    }
  }

  function hapushutangkirim($no_mutasi, $cabang)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->row_array();
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
      $hapus = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($hapus) {
        $hapus_detail = $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Di Hapus !
          </div>'
        );
        redirect('dpb/hutangkirim');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/hutangkirim');
    }
  }

  public function getDataPLHKDpb($rowno, $rowperpage, $no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,mutasi_gudang_cabang.kode_cabang,
                      dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'PL HUTANG KIRIM');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordPLHKDpbCount($no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->where('jenis_mutasi', 'PL HUTANG KIRIM');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function insert_plhutangkirim()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "GOOD";
    $inout_good       = "OUT";
    $jenis_mutasi     = "PL HUTANG KIRIM";
    $order            = 8;
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek            = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      $cekdpb         = $this->db->get_where('mutasi_gudang_cabang', array('no_dpb' => $nodpb, 'tgl_mutasi_gudang_cabang' => $tanggal, 'jenis_mutasi' => 'PELUNASAN HUTANG KIRIM'))->num_rows();
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
            '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-check"></i> Data Berhasil Disimpan !
            </div>'
          );
          redirect('dpb/plhutangkirim');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info"></i> Data Sudah Ada !
          </div>'
        );
        redirect('dpb/inputplhutangkirim');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/inputplhutangkirim');
    }
  }

  function update_plhutangkirim()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
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
        redirect('dpb/plhutangkirim');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/plhutangkirim');
    }
  }

  function hapusplhutangkirim($no_mutasi, $cabang)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->row_array();
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
      $hapus = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($hapus) {
        $hapus_detail = $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i>  Data Berhasil Di Hapus !
          </div>'
        );
        redirect('dpb/plhutangkirim');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i>  Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/plhutangkirim');
    }
  }

  public function getDataTTRDpb($rowno, $rowperpage, $no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,mutasi_gudang_cabang.kode_cabang,
                      dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'TTR');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordTTRDpbCount($no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->where('jenis_mutasi', 'TTR');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function insert_ttr()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "GOOD";
    $inout_good       = "OUT";
    $jenis_mutasi     = "TTR";
    $order            = 9;
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek            = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      $cekdpb         = $this->db->get_where('mutasi_gudang_cabang', array('no_dpb' => $nodpb, 'tgl_mutasi_gudang_cabang' => $tanggal, 'jenis_mutasi' => 'TTR'))->num_rows();
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
            '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-check"></i> Data Berhasil Disimpan !
            </div>'
          );
          redirect('dpb/ttr');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info"></i> Data Sudah Ada !
          </div>'
        );
        redirect('dpb/inputttr');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/inputttr');
    }
  }

  function update_ttr()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
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
        redirect('dpb/ttr');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/ttr');
    }
  }

  function hapusttr($no_mutasi, $cabang)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->row_array();
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
      $hapus = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($hapus) {
        $hapus_detail = $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white  text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Di Hapus !
          </div>'
        );
        redirect('dpb/ttr');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/ttr');
    }
  }

  public function getDataplTTRDpb($rowno, $rowperpage, $no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,mutasi_gudang_cabang.kode_cabang,
                      dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'PL TTR');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordplTTRDpbCount($no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->where('jenis_mutasi', 'PL TTR');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function insert_plttr()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "GOOD";
    $inout_good       = "IN";
    $jenis_mutasi     = "PL TTR";
    $order            = 6;
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek            = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      $cekdpb         = $this->db->get_where('mutasi_gudang_cabang', array('no_dpb' => $nodpb, 'tgl_mutasi_gudang_cabang' => $tanggal, 'jenis_mutasi' => 'PL TTR'))->num_rows();
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
            '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-check"></i> Data Berhasil Disimpan !
            </div>'
          );
          redirect('dpb/plttr');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info"></i> Data Sudah Ada !
          </div>'
        );
        redirect('dpb/inputplttr');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/inputplttr');
    }
  }

  function update_plttr()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
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
        redirect('dpb/plttr');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/plttr');
    }
  }

  function hapusplttr($no_mutasi, $cabang)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->row_array();
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
      $hapus = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($hapus) {
        $hapus_detail = $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Di Hapus !
          </div>'
        );
        redirect('dpb/plttr');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/plttr');
    }
  }

  public function getDataPromosiDpb($rowno, $rowperpage, $no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {
    $this->db->select('no_mutasi_gudang_cabang,tgl_mutasi_gudang_cabang,mutasi_gudang_cabang.no_dpb,mutasi_gudang_cabang.kode_cabang,
                      dpb.id_karyawan,nama_karyawan,tujuan,no_kendaraan');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->order_by('tgl_mutasi_gudang_cabang', 'desc');
    $this->db->where('jenis_mutasi', 'PROMOSI');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordPromosiDpbCount($no_dpb = "", $tgl_penjualan = "", $cabang = "", $salesman = "")
  {

    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('dpb', 'mutasi_gudang_cabang.no_dpb = dpb.no_dpb');
    $this->db->join('karyawan', 'dpb.id_karyawan = karyawan.id_karyawan');
    $this->db->where('jenis_mutasi', 'PROMOSI');
    if ($no_dpb != '') {
      $this->db->where('mutasi_gudang_cabang.no_dpb', $no_dpb);
    }
    if ($tgl_penjualan != '') {
      $this->db->where('tgl_mutasi_gudang_cabang', $tgl_penjualan);
    }

    if ($cabang != '') {
      $this->db->where('mutasi_gudang_cabang.kode_cabang', $cabang);
    }
    if ($salesman != '') {
      $this->db->where('dpb.id_karyawan', $salesman);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function insert_promosi()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $kondisi          = "GOOD";
    $inout_good       = "OUT";
    $jenis_mutasi     = "PROMOSI";
    $order            = 12;
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
      'kondisi'                  => $kondisi,
      'inout_good'               => $inout_good,
      'jenis_mutasi'             => $jenis_mutasi,
      'order'                    => $order,
      'id_admin'                 => $id_admin
    );
    $ceksa = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $cek            = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->num_rows();
      $cekdpb         = $this->db->get_where('mutasi_gudang_cabang', array('no_dpb' => $nodpb, 'tgl_mutasi_gudang_cabang' => $tanggal, 'jenis_mutasi' => 'PROMOSI'))->num_rows();
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
          redirect('dpb/promosi');
        }
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Sudah Ada !
          </div>'
        );
        redirect('dpb/inputpromosi');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/inputpromosi');
    }
  }

  function update_promosi()
  {
    $nodpb            = $this->input->post('nodpb');
    $no_mutasi        = $this->input->post('no_mutasi');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
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
      'no_dpb'                   => $nodpb,
      'kode_cabang'              => $cabang,
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
        redirect('dpb/promosi');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/promosi');
    }
  }

  function hapuspromosi($no_mutasi, $cabang)
  {
    $gettanggal  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi))->row_array();
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
      $hapus = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
      if ($hapus) {
        $hapus_detail = $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi));
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Di Hapus !
          </div>'
        );
        redirect('dpb/promosi');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Periode Bulan Ini Sudah di Tutup !
        </div>'
      );
      redirect('dpb/promosi');
    }
  }

  public function getDataSaldoawal($rowno, $rowperpage, $tanggal = "", $cabang = "", $status = "", $bulan = "", $tahun = "")
  {
    $this->db->select('kode_saldoawal,tanggal,bulan,tahun,status,kode_cabang');
    $this->db->from('saldoawal_bj');
    $this->db->order_by('tanggal', 'desc');
    if ($tanggal != '') {
      $this->db->where('tanggal', $tanggal);
    }
    if ($cabang != '') {
      $this->db->where('kode_cabang', $cabang);
    }

    if ($status != '') {
      $this->db->where('status', $status);
    }

    if ($bulan != '') {
      $this->db->where('bulan', $bulan);
    }

    if ($tahun != '') {
      $this->db->where('tahun', $tahun);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordSaldoawalCount($tanggal = "", $cabang = "", $status = "", $bulan = "", $tahun = "")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('saldoawal_bj');
    if ($tanggal != '') {
      $this->db->where('tanggal', $tanggal);
    }
    if ($cabang != '') {
      $this->db->where('kode_cabang', $cabang);
    }

    if ($status != '') {
      $this->db->where('status', $status);
    }

    if ($bulan != '') {
      $this->db->where('bulan', $bulan);
    }

    if ($tahun != '') {
      $this->db->where('tahun', $tahun);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function getdetailsaldo($bulan, $tahun, $cabang, $status)
  {
    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }
    if ($status == "GS") {
      $query = "SELECT master_barang.kode_produk,nama_barang,isipcsdus,isipack,isipcs,
                satuan,jumlah as sabulanlalu,sisamutasi,IFNULL(jumlah,0) + IFNULL(sisamutasi,0) as saldoakhir
                FROM master_barang
                LEFT JOIN ( SELECT kode_produk,jumlah FROM saldoawal_bj_detail
                						INNER JOIN saldoawal_bj ON saldoawal_bj_detail.kode_saldoawal = saldoawal_bj.kode_saldoawal
                						WHERE bulan='$bulan' AND tahun='$tahun' AND kode_cabang='$cabang' AND status='$status') sa
                ON (master_barang.kode_produk = sa.kode_produk)
                LEFT JOIN (SELECT kode_produk,
      					 SUM(IF( inout_good = 'IN', jumlah, 0)) - SUM(IF( inout_good = 'OUT', jumlah, 0)) as sisamutasi
      					 FROM detail_mutasi_gudang_cabang
      					 INNER JOIN mutasi_gudang_cabang
      					 ON detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang = mutasi_gudang_cabang.no_mutasi_gudang_cabang
      					 WHERE MONTH(tgl_mutasi_gudang_cabang)='$bulan' AND YEAR(tgl_mutasi_gudang_cabang)='$tahun' AND kode_cabang='$cabang' GROUP BY kode_produk
      					 ) mutasi ON (master_barang.kode_produk = mutasi.kode_produk)";
    } else {
      $query = "SELECT master_barang.kode_produk,nama_barang,isipcsdus,isipack,isipcs,
                satuan,jumlah as sabulanlalu,sisamutasi,IFNULL(jumlah,0) + IFNULL(sisamutasi,0) as saldoakhir
                FROM master_barang
                LEFT JOIN ( SELECT kode_produk,jumlah FROM saldoawal_bj_detail
                						INNER JOIN saldoawal_bj ON saldoawal_bj_detail.kode_saldoawal = saldoawal_bj.kode_saldoawal
                						WHERE bulan='$bulan' AND tahun='$tahun' AND kode_cabang='$cabang' AND status='$status') sa
                ON (master_barang.kode_produk = sa.kode_produk)

                LEFT JOIN (SELECT kode_produk,
                					 SUM(IF( inout_bad = 'IN', jumlah, 0)) - SUM(IF( inout_bad = 'OUT', jumlah, 0)) as sisamutasi
                					 FROM detail_mutasi_gudang_cabang
                					 INNER JOIN mutasi_gudang_cabang
                					 ON detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang = mutasi_gudang_cabang.no_mutasi_gudang_cabang
                					 WHERE MONTH(tgl_mutasi_gudang_cabang)='$bulan' AND YEAR(tgl_mutasi_gudang_cabang)='$tahun' AND kode_cabang='$cabang' AND kondisi='BAD'
                					 GROUP BY kode_produk) mutasi ON (master_barang.kode_produk = mutasi.kode_produk)";
    }
    return $this->db->query($query);
  }



  function ceksaldo($bulan, $tahun, $cabang, $status)
  {
    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    return $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang, 'status' => $status));
  }

  function ceksaldoSkrg($bulan, $tahun, $cabang, $status)
  {
    return $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang, 'status', $status));
  }

  function ceksaldoall($cabang, $status)
  {
    return $this->db->get_where('saldoawal_bj', array('kode_cabang' => $cabang, 'status' => $status));
  }

  function insert_saldoawal()
  {
    $kode_saldoawal   = $this->input->post('kode_saldoawal');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $status           = $this->input->post('status');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');

    $data = array(
      'kode_saldoawal'  => $kode_saldoawal,
      'tanggal'         => $tanggal,
      'bulan'           => $bulan,
      'tahun'           => $tahun,
      'status'          => $status,
      'kode_cabang'     => $cabang,
      'id_admin'        => $id_admin
    );

    $cek            = $this->db->get_where('saldoawal_bj', array('kode_saldoawal' => $kode_saldoawal))->num_rows();
    $cekbulan       = $this->db->get_where('saldoawal_bj', array('bulan' => $bulan, 'tahun' => $tahun, 'status' => $status, 'kode_cabang' => $cabang))->num_rows();
    if (empty($cek) && empty($cekbulan)) {
      $simpansaldo   = $this->db->insert('saldoawal_bj', $data);
      if ($simpansaldo) {
        for ($i = 1; $i <= $jumproduk; $i++) {
          $kode_produk     = $this->input->post('kode_produk' . $i);
          $jmldus          = $this->input->post('jmldus' . $i);
          $jmlpack         = $this->input->post('jmlpack' . $i);
          $jmlpcs          = $this->input->post('jmlpcs' . $i);

          $isipcsdus       = $this->input->post('isipcsdus' . $i);
          $isipack         = $this->input->post('isipcspack' . $i);
          $isipcs          = $this->input->post('isipcs' . $i);

          echo $jmlpack . "x" . $jmlpack;
          $jumlah          = ((int)$jmldus * (int)$isipcsdus) + ((int)$jmlpack * (int)$isipcs) + (int)$jmlpcs;

          $detail_saldo   = array(
            'kode_saldoawal'    => $kode_saldoawal,
            'kode_produk'       => $kode_produk,
            'jumlah'            => $jumlah
          );
          if (!empty($jumlah)) {
            $simpandetail = $this->db->insert('saldoawal_bj_detail', $detail_saldo);
          }
        }
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Disimpan !
          </div>'
        );
        if ($status == "GS") {
          redirect('dpb/saldoawalgs');
        } else {
          redirect('dpb/saldoawalbs');
        }
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Sudah Ada !
        </div>'
      );
      if ($status == "GS") {
        redirect('dpb/inputsaldoawalgs');
      } else {
        redirect('dpb/inputsaldoawalbs');
      }
    }
  }

  function getSaldoBJ($kode)
  {
    return $this->db->get_where('saldoawal_bj', array('kode_saldoawal' => $kode));
  }

  function detailSaldoBJ($kode)
  {
    $this->db->join('master_barang', 'saldoawal_bj_detail.kode_produk = master_barang.kode_produk');
    return $this->db->get_where('saldoawal_bj_detail', array('kode_saldoawal' => $kode));
  }

  function hapussaldoawal($kode, $status)
  {
    $hapus = $this->db->delete('saldoawal_bj', array('kode_saldoawal' => $kode));
    if ($hapus) {
      $hapus_detail = $this->db->delete('saldoawal_bj_detail', array('kode_saldoawal' => $kode));
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Hapus !
        </div>'
      );
      if ($status == "GS") {
        redirect('dpb/saldoawalgs');
      } else {
        redirect('dpb/saldoawalbs');
      }
    }
  }

  function getsaldo($cabang, $status)
  {
    error_reporting(0);
    $gettanggal = $this->db->query("SELECT * FROM saldoawal_bj WHERE kode_cabang ='$cabang'
    AND status='$status' ORDER BY tanggal DESC LIMIT 1")->row_array();
    $tahun = $gettanggal['tahun'];
    $bulan = $gettanggal['bulan'];
    $hari  = "1";
    $tanggal = $tahun . "-" . $bulan . "-" . $hari;
    $query = "SELECT
  	master_barang.kode_produk,
  	nama_barang,
  	isipcsdus,
  	isipack,
  	isipcs,
  	satuan,
  	jumlah AS sabulanlalu,
  	sisamutasi,
    buffer,
    totalpengembalian,totalpengambilan,
  	IFNULL( jumlah, 0 ) + IFNULL( sisamutasi, 0 )  AS saldoakhir
  FROM
  	master_barang
  	LEFT JOIN (
  	SELECT
  		kode_produk,
  		jumlah
  	FROM
  		saldoawal_bj_detail
  		INNER JOIN saldoawal_bj ON saldoawal_bj_detail.kode_saldoawal = saldoawal_bj.kode_saldoawal
  	WHERE
  		status = '$status'
  		AND kode_cabang = '$cabang' AND bulan = '$bulan' AND tahun ='$tahun'
  	) sa ON ( master_barang.kode_produk = sa.kode_produk )
  	LEFT JOIN (
  	SELECT
  		kode_produk,
  		SUM( IF ( inout_good = 'IN', jumlah, 0 ) ) - SUM( IF ( inout_good = 'OUT', jumlah, 0 ) ) AS sisamutasi
  	FROM
  		detail_mutasi_gudang_cabang
  		INNER JOIN mutasi_gudang_cabang ON detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang = mutasi_gudang_cabang.no_mutasi_gudang_cabang

  	WHERE
  		tgl_mutasi_gudang_cabang BETWEEN '$tanggal' AND CURDATE()
  		AND kode_cabang = '$cabang'
      AND `jenis_mutasi` = 'SURAT JALAN' 
      OR tgl_mutasi_gudang_cabang BETWEEN '$tanggal' AND CURDATE()
  		AND kode_cabang = '$cabang'
      AND `jenis_mutasi` = 'TRANSIT IN'
      OR tgl_mutasi_gudang_cabang BETWEEN '$tanggal' AND CURDATE()
  		AND kode_cabang = '$cabang'
      AND `jenis_mutasi` = 'TRANSIT OUT'  
      OR tgl_mutasi_gudang_cabang BETWEEN '$tanggal' AND CURDATE()
  		AND kode_cabang = '$cabang'
      AND `jenis_mutasi` = 'REJECT GUDANG'  
      OR tgl_mutasi_gudang_cabang BETWEEN '$tanggal' AND CURDATE()
  		AND kode_cabang = '$cabang'
      AND `jenis_mutasi` = 'REJECT PASAR'
      OR tgl_mutasi_gudang_cabang BETWEEN '$tanggal' AND CURDATE()
  		AND kode_cabang = '$cabang'
      AND `jenis_mutasi` = 'REPACK'
      OR tgl_mutasi_gudang_cabang BETWEEN '$tanggal' AND CURDATE()
  		AND kode_cabang = '$cabang'
      AND `jenis_mutasi` = 'PENYESUAIAN'      
      GROUP BY detail_mutasi_gudang_cabang.kode_produk
  	) mutasi ON (
  	master_barang.kode_produk = mutasi.kode_produk)
    
    LEFT JOIN(SELECT kode_produk,jumlah as buffer
      FROM detail_bufferstok
      INNER JOIN buffer_stok ON detail_bufferstok.kode_bufferstok = buffer_stok.kode_bufferstok
      WHERE kode_cabang='$cabang'
    ) bf ON (master_barang.kode_produk = bf.kode_produk)
    
    LEFT JOIN (
  	SELECT
  		kode_produk,
  		SUM(jml_pengambilan) as totalpengambilan,
      SUM(jml_pengembalian) as totalpengembalian
  	FROM
  		detail_dpb
  		INNER JOIN dpb ON detail_dpb.no_dpb = dpb.no_dpb
  	WHERE
      tgl_pengambilan BETWEEN '$tanggal' AND CURDATE()
  		AND kode_cabang = '$cabang' GROUP BY kode_produk
  	) dpb ON ( master_barang.kode_produk = dpb.kode_produk )";
    return $this->db->query($query);
  }



  function getsaldoproduk($kodeproduk, $status)
  {
    error_reporting(0);
    $gettanggal = $this->db->query("SELECT * FROM saldoawal_bj_detail 
  INNER JOIN saldoawal_bj ON saldoawal_bj_detail.kode_saldoawal = saldoawal_bj.kode_saldoawal
  WHERE kode_produk ='$kodeproduk'
  AND status='$status' ORDER BY tanggal DESC LIMIT 1")->row_array();


    $tahun = $gettanggal['tahun'];
    $bulan = $gettanggal['bulan'];
    $hari  = "1";
    $tanggal = $tahun . "-" . $bulan . "-" . $hari;
    $query = "SELECT
  	cabang.kode_cabang,
  	nama_cabang,
  	jumlah AS sabulanlalu,
  	sisamutasi,
    buffer,
  	IFNULL( jumlah, 0 ) + IFNULL( sisamutasi, 0 )  AS saldoakhir
  FROM
  	cabang
  	LEFT JOIN (
  	SELECT
  		kode_cabang,
  		jumlah
  	FROM
  		saldoawal_bj_detail
  		INNER JOIN saldoawal_bj ON saldoawal_bj_detail.kode_saldoawal = saldoawal_bj.kode_saldoawal
  	WHERE
  		status = '$status'
  		AND kode_produk = '$kodeproduk' AND bulan = '$bulan' AND tahun ='$tahun'
  	) sa ON ( cabang.kode_cabang = sa.kode_cabang )
  	
    
    LEFT JOIN (
  	SELECT
  		kode_cabang,
  		SUM( IF ( inout_good = 'IN', jumlah, 0 ) ) - SUM( IF ( inout_good = 'OUT', jumlah, 0 ) ) AS sisamutasi
  	FROM
  		detail_mutasi_gudang_cabang
  		INNER JOIN mutasi_gudang_cabang ON detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang = mutasi_gudang_cabang.no_mutasi_gudang_cabang
  	WHERE
  		tgl_mutasi_gudang_cabang BETWEEN '$tanggal' AND CURDATE()
  		AND kode_produk = '$kodeproduk'
      GROUP BY mutasi_gudang_cabang.kode_cabang 
  	) mutasi ON (
  	cabang.kode_cabang = mutasi.kode_cabang)



    LEFT JOIN(SELECT kode_cabang,jumlah as buffer
      FROM detail_bufferstok
      INNER JOIN buffer_stok ON detail_bufferstok.kode_bufferstok = buffer_stok.kode_bufferstok
      WHERE kode_produk='$kodeproduk'
    ) bf ON (cabang.kode_cabang = bf.kode_cabang)";
    return $this->db->query($query);
  }

  function getsaldobs($cabang, $status)
  {
    error_reporting(0);
    $gettanggal = $this->db->query("SELECT * FROM saldoawal_bj WHERE kode_cabang ='$cabang'
  AND status='$status' ORDER BY tanggal DESC LIMIT 1")->row_array();
    $tahun = $gettanggal['tahun'];
    $bulan = $gettanggal['bulan'];
    $hari  = "1";
    $tanggal = $tahun . "-" . $bulan . "-" . $hari;
    $query = "SELECT
  	master_barang.kode_produk,
  	nama_barang,
  	isipcsdus,
  	isipack,
  	isipcs,
  	satuan,
  	jumlah AS sabulanlalu,
  	sisamutasi,
  	IFNULL( jumlah, 0 ) + IFNULL( sisamutasi, 0 ) AS saldoakhir
  FROM
  	master_barang
  	LEFT JOIN (
  	SELECT
  		kode_produk,
  		jumlah
  	FROM
  		saldoawal_bj_detail
  		INNER JOIN saldoawal_bj ON saldoawal_bj_detail.kode_saldoawal = saldoawal_bj.kode_saldoawal
  	WHERE
  		status = '$status'
  		AND kode_cabang = '$cabang' AND bulan = '$bulan' AND tahun ='$tahun'
  	) sa ON ( master_barang.kode_produk = sa.kode_produk )
  	LEFT JOIN (
  	SELECT
  		kode_produk,
  		SUM( IF ( inout_bad = 'IN', jumlah, 0 ) ) - SUM( IF ( inout_bad = 'OUT', jumlah, 0 ) ) AS sisamutasi
  	FROM
  		detail_mutasi_gudang_cabang
  		INNER JOIN mutasi_gudang_cabang ON detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang = mutasi_gudang_cabang.no_mutasi_gudang_cabang
  	WHERE
  		tgl_mutasi_gudang_cabang BETWEEN '$tanggal' AND CURDATE()
  		AND kode_cabang = '$cabang'
      GROUP BY detail_mutasi_gudang_cabang.kode_produk
  	) mutasi ON (
  	master_barang.kode_produk = mutasi.kode_produk)";
    return $this->db->query($query);
  }

  function mutasidpb($no_dpb)
  {
    $query = "SELECT dm.kode_produk,nama_barang,isipcsdus,
    SUM(IF(jenis_mutasi='PENJUALAN',jumlah,0)) as penjualan,
    SUM(IF(jenis_mutasi='HUTANG KIRIM',jumlah,0)) as hutangkirim,
    SUM(IF(jenis_mutasi='PL TTR',jumlah,0)) as pelunasanttr,
    SUM(IF(jenis_mutasi='GANTI BARANG',jumlah,0)) as gantibarang,
    SUM(IF(jenis_mutasi='PL HUTANG KIRIM',jumlah,0)) as plhutangkirim,
    SUM(IF(jenis_mutasi='TTR',jumlah,0)) as ttr,
    SUM(IF(jenis_mutasi='RETUR',jumlah,0)) as retur,
    SUM(IF(jenis_mutasi='REJECT PASAR',jumlah,0)) as rejectpasar,
    SUM(IF(jenis_mutasi='PROMOSI',jumlah,0)) as promosi
    FROM
    detail_mutasi_gudang_cabang dm
    INNER JOIN mutasi_gudang_cabang mc ON dm.no_mutasi_gudang_cabang = mc.no_mutasi_gudang_cabang
    INNER JOIN master_barang mb ON dm.kode_produk = mb.kode_produk
    WHERE mc.no_dpb='$no_dpb'
    GROUP BY dm.kode_produk,nama_barang";
    return $this->db->query($query);
  }

  function hapusdpb($kodedpb)
  {
    $hapusdpb   = $this->db->delete('dpb', array('no_dpb' => $kodedpb));
    if ($hapusdpb) {
      $detaildpb = $this->db->delete('detail_dpb', array('no_dpb' => $kodedpb));
      $mutasi    = $this->db->get_where('mutasi_gudang_cabang', array('no_dpb' => $kodedpb))->result();
      foreach ($mutasi as $m) {
        $hapusdetailmutasi = $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $m->no_mutasi_gudang_cabang));
      }
      $hapusmutasi = $this->db->delete('mutasi_gudang_cabang', array('no_dpb' => $kodedpb));
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil Di Hapus !
      </div>'
      );
      redirect('dpb');
    }
  }


  public function getDataSaldoawalDpb($rowno, $rowperpage, $tanggal = "", $cabang = "", $bulan = "", $tahun = "")
  {
    $this->db->select('kode_saldoawal,tanggal,bulan,tahun,kode_cabang');
    $this->db->from('saldoawal_dpb');
    $this->db->order_by('tanggal', 'desc');
    if ($tanggal != '') {
      $this->db->where('tanggal', $tanggal);
    }
    if ($cabang != '') {
      $this->db->where('kode_cabang', $cabang);
    }

    if ($bulan != '') {
      $this->db->where('bulan', $bulan);
    }

    if ($tahun != '') {
      $this->db->where('tahun', $tahun);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordSaldoawalDpbCount($tanggal = "", $cabang = "", $bulan = "", $tahun = "")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('saldoawal_dpb');
    if ($tanggal != '') {
      $this->db->where('tanggal', $tanggal);
    }
    if ($cabang != '') {
      $this->db->where('kode_cabang', $cabang);
    }

    if ($bulan != '') {
      $this->db->where('bulan', $bulan);
    }

    if ($tahun != '') {
      $this->db->where('tahun', $tahun);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


  function ceksaldodpb($bulan, $tahun, $cabang)
  {
    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    return $this->db->get_where('saldoawal_dpb', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang));
  }

  function ceksaldoSkrgdpb($bulan, $tahun, $cabang)
  {
    return $this->db->get_where('saldoawal_dpb', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang));
  }

  function ceksaldoalldpb($cabang)
  {
    return $this->db->get_where('saldoawal_dpb', array('kode_cabang' => $cabang));
  }

  function getdetailsaldodpb($bulan, $tahun, $cabang)
  {
    if ($bulan == 1) {
      $bulan = 12;
      $tahun = $tahun - 1;
    } else {
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

    $query = "SELECT master_barang.kode_produk,nama_barang,isipcsdus,isipack,isipcs,
              satuan,jumlah as sabulanlalu,jumlah as saldoakhir
              FROM master_barang
              LEFT JOIN ( SELECT kode_produk,jumlah FROM saldoawal_dpb_detail
                          INNER JOIN saldoawal_dpb ON saldoawal_dpb_detail.kode_saldoawal = saldoawal_dpb.kode_saldoawal
                          WHERE bulan='$bulan' AND tahun='$tahun' AND kode_cabang='$cabang') sa
              ON (master_barang.kode_produk = sa.kode_produk)";

    return $this->db->query($query);
  }


  function insert_saldoawaldpb()
  {
    $kode_saldoawal   = $this->input->post('kode_saldoawal');
    $cabang           = $this->input->post('cabang');
    $tanggal          = $this->input->post('tanggal');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $id_admin         = $this->session->userdata('id_user');
    $jumproduk        = $this->input->post('jumproduk');

    $data = array(
      'kode_saldoawal'  => $kode_saldoawal,
      'tanggal'         => $tanggal,
      'bulan'           => $bulan,
      'tahun'           => $tahun,
      'kode_cabang'     => $cabang,
      'id_admin'        => $id_admin
    );

    $cek            = $this->db->get_where('saldoawal_dpb', array('kode_saldoawal' => $kode_saldoawal))->num_rows();
    $cekbulan       = $this->db->get_where('saldoawal_dpb', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($cek) && empty($cekbulan)) {
      $simpansaldo   = $this->db->insert('saldoawal_dpb', $data);
      if ($simpansaldo) {
        for ($i = 1; $i <= $jumproduk; $i++) {
          $kode_produk     = $this->input->post('kode_produk' . $i);
          $jmldus          = $this->input->post('jmldus' . $i);
          $jmlpack         = $this->input->post('jmlpack' . $i);
          $jmlpcs          = $this->input->post('jmlpcs' . $i);

          $isipcsdus       = $this->input->post('isipcsdus' . $i);
          $isipack         = $this->input->post('isipcspack' . $i);
          $isipcs          = $this->input->post('isipcs' . $i);

          echo $jmlpack . "x" . $jmlpack;
          $jumlah          = ((int)$jmldus * (int)$isipcsdus) + ((int)$jmlpack * (int)$isipcs) + (int)$jmlpcs;

          $detail_saldo   = array(
            'kode_saldoawal'    => $kode_saldoawal,
            'kode_produk'       => $kode_produk,
            'jumlah'            => $jumlah
          );
          if (!empty($jumlah)) {
            $simpandetail = $this->db->insert('saldoawal_dpb_detail', $detail_saldo);
          }
        }
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Disimpan !
          </div>'
        );
        redirect('dpb/saldoawaldpb');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Sudah Ada !
        </div>'
      );
      redirect('dpb/saldoawaldpb');
    }
  }

  function hapussaldoawaldpb($kode)
  {
    $hapus = $this->db->delete('saldoawal_dpb', array('kode_saldoawal' => $kode));
    if ($hapus) {
      $hapus_detail = $this->db->delete('saldoawal_dpb_detail', array('kode_saldoawal' => $kode));
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Hapus !
        </div>'
      );
      redirect('dpb/saldoawaldpb');
    }
  }

  function getSaldoDpb($kode)
  {
    return $this->db->get_where('saldoawal_dpb', array('kode_saldoawal' => $kode));
  }

  function detailSaldoDpb($kode)
  {
    $this->db->join('master_barang', 'saldoawal_dpb_detail.kode_produk = master_barang.kode_produk');
    return $this->db->get_where('saldoawal_dpb_detail', array('kode_saldoawal' => $kode));
  }
}
