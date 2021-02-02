<?php

class Model_kaskecil extends CI_Model
{

  public function getData($rowno, $rowperpage, $dari = "", $sampai = "", $nobukti = "", $kodeakun = "")
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }

    if ($cabang != "") {
      $this->db->where('kaskecil_detail.kode_cabang', $cabang);
    }

    if ($nobukti != "") {
      $this->db->where('nobukti', $nobukti);
    }

    if ($kodeakun != "") {
      $this->db->where('kaskecil_detail.kode_akun', $kodeakun);
    }
    $this->db->select('id,nobukti,tgl_kaskecil,kaskecil_detail.keterangan,kaskecil_detail.jumlah,kaskecil_detail.kode_akun,status_dk,nama_akun,kaskecil_detail.kode_klaim,klaim.keterangan as ket_klaim,no_ref,
    costratio_biaya.kode_cr,peruntukan');
    $this->db->from('kaskecil_detail');
    $this->db->join('coa', 'kaskecil_detail.kode_akun=coa.kode_akun');
    $this->db->join('klaim', 'kaskecil_detail.kode_klaim=klaim.kode_klaim', 'left');
    $this->db->join('costratio_biaya', 'kaskecil_detail.kode_cr=costratio_biaya.kode_cr', 'left');
    $this->db->where('tgl_kaskecil >=', $dari);
    $this->db->where('tgl_kaskecil <=', $sampai);
    $this->db->order_by('tgl_kaskecil,order,nobukti', 'ASC');
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }


  // Select total records
  public function getrecordCount($dari = "", $sampai = "", $nobukti = "", $kodeakun = "")
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    if ($cabang != "") {
      $this->db->where('kaskecil_detail.kode_cabang', $cabang);
    }
    if ($nobukti != "") {
      $this->db->where('nobukti', $nobukti);
    }

    if ($kodeakun != "") {
      $this->db->where('kaskecil_detail.kode_akun', $kodeakun);
    }
    $this->db->select('count(*) as allcount');
    $this->db->from('kaskecil_detail');
    $this->db->join('coa', 'kaskecil_detail.kode_akun=coa.kode_akun');
    $this->db->join('klaim', 'kaskecil_detail.kode_klaim=klaim.kode_klaim', 'left');
    $this->db->where('tgl_kaskecil >=', $dari);
    $this->db->where('tgl_kaskecil <=', $sampai);
    $query   = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataKlaim($dari = "", $sampai = "")
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    if ($cabang != "") {
      $this->db->where('kode_cabang', $cabang);
    }

    $this->db->select('kode_klaim,tgl_klaim,keterangan,kode_cabang,status');
    $this->db->from('klaim');

    $this->db->where('tgl_klaim >=', $dari);
    $this->db->where('tgl_klaim <=', $sampai);

    $this->db->order_by('tgl_klaim', 'ASC');
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordKlaim($dari = "", $sampai = "")
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    if ($cabang != "") {
      $this->db->where('kode_cabang', $cabang);
    }
    $this->db->select('count(*) as allcount');
    $this->db->from('klaim');
    if ($dari != "" and $sampai != "") {
      $this->db->where('tgl_klaim >=', $dari);
      $this->db->where('tgl_klaim <=', $sampai);
    }
    $query   = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataKlaimcabang($dari = "", $sampai = "", $cabang = "")
  {
    if ($cabang != "") {
      $this->db->where('kode_cabang', $cabang);
    }
    $this->db->select('klaim.kode_klaim,tgl_klaim,klaim.keterangan,kode_cabang,status,no_bukti,tgl_ledger,status_validasi');
    $this->db->from('klaim');
    $this->db->join('ledger_bank', 'klaim.kode_klaim = ledger_bank.kode_klaim', 'left');

    $this->db->where('tgl_klaim >=', $dari);
    $this->db->where('tgl_klaim <=', $sampai);

    $this->db->order_by('tgl_klaim', 'ASC');

    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordKlaimcabang($dari = "", $sampai = "", $cabang = "")
  {
    if ($cabang != "") {
      $this->db->where('kode_cabang', $cabang);
    }
    $this->db->select('count(*) as allcount');
    $this->db->from('klaim');
    if ($dari != "" and $sampai != "") {
      $this->db->where('tgl_klaim >=', $dari);
      $this->db->where('tgl_klaim <=', $sampai);
    }
    $query   = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getDataMB($dari = "", $sampai = "")
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    if ($cabang != "") {
      $this->db->where('kode_cabang', $cabang);
    }


    $this->db->select('*');
    $this->db->from('ledger_bank');
    $this->db->join('coa', 'ledger_bank.kode_akun = coa.kode_akun');
    $this->db->join('master_bank', 'ledger_bank.bank = master_bank.kode_bank');
    $this->db->order_by('tgl_ledger,pelanggan', 'ASC');

    // $this->db->where('left(kontrabon.no_kontrabon,1) !=','T')
    $this->db->where('tgl_ledger >=', $dari);
    $this->db->where('tgl_ledger <=', $sampai);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordMBCount($dari = "", $sampai = "")
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    if ($cabang != "") {
      $this->db->where('kode_cabang', $cabang);
    }

    $this->db->select('count(*) as allcount');
    $this->db->from('ledger_bank');
    $this->db->join('coa', 'ledger_bank.kode_akun = coa.kode_akun');
    $this->db->join('master_bank', 'ledger_bank.bank = master_bank.kode_bank');
    $this->db->order_by('tgl_ledger,pelanggan', 'DESC');
    // $this->db->where('left(kontrabon.no_kontrabon,1) !=','T');
    if ($dari !=  '') {
      $this->db->where('tgl_ledger >=', $dari);
    }
    if ($sampai !=  '') {
      $this->db->where('tgl_ledger <=', $sampai);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function insert_detailkaskeciltemp()
  {
    $keterangan = $this->input->post('keterangan');
    $jumlah     = str_replace(".", "", $this->input->post('jumlah'));
    $kodeakun   = $this->input->post('kodeakun');
    $debetkredit = $this->input->post('debetkredit');
    $admin      = $this->session->userdata('id_user');
    $data = array(
      'keterangan'  => $keterangan,
      'jumlah'      => $jumlah,
      'kode_akun'   => $kodeakun,
      'status_dk'   => $debetkredit,
      'id_admin'    => $admin
    );
    $this->db->insert('kaskecil_detailtemp', $data);
  }

  function view_detailkaskeciltemp()
  {
    $admin = $this->session->userdata('id_user');
    $this->db->select('id_detailkaskeciltemp,keterangan,jumlah,kaskecil_detailtemp.kode_akun,nama_akun,status_dk');
    $this->db->from('kaskecil_detailtemp');
    $this->db->join('coa', 'kaskecil_detailtemp.kode_akun=coa.kode_akun');
    $this->db->where('id_admin', $admin);
    return $this->db->get();
  }

  function hapus_detailkaskeciltemp($id)
  {
    $this->db->delete('kaskecil_detailtemp', array('id_detailkaskeciltemp' => $id));
  }



  function insert_kaskecil2()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    $status_dk = $this->input->post('inout');
    // if($cabang == 'PST'){
    //   $status_dk = $this->input->post('inout');
    // }else{
    //   $status_dk = 'D';
    // }
    $tanggal    = $this->input->post('tanggal');
    $nobukti    = $this->input->post('nobukti');
    // $keterangan = $this->input->post('keterangan');
    // $jumlah     = str_replace(".","",$this->input->post('jumlah'));
    // $akun       = $this->input->post('kodeakun');

    $temp = $this->db->get_where('kaskecil_detail_temp', array('nobukti' => $nobukti))->result();
    foreach ($temp as $t) {
      $cekakun = substr($t->kode_akun, 0, 3);
      if ($t->status_dk == 'D' and $cekakun == '6-1' or $t->status_dk == 'D' and $cekakun == '6-2') {

        $tgltransaksi = explode("-", $tanggal);
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
        $data = array(
          'tgl_kaskecil' => $tanggal,
          'nobukti'      => $nobukti,
          'keterangan'   => $t->keterangan,
          'jumlah'       => $t->jumlah,
          'kode_akun'    => $t->kode_akun,
          'kode_cabang'  => $t->kode_cabang,
          'status_dk'    => $t->status_dk,
          'order'        => 2,
          'peruntukan'   => $t->peruntukan,
          'kode_cr'      => $kodecr
        );

        $datacr = [
          'kode_cr' => $kodecr,
          'tgl_transaksi' => $tanggal,
          'kode_akun'    => $t->kode_akun,
          'keterangan'   => $t->keterangan,
          'kode_cabang'  => $t->kode_cabang,
          'id_sumber_costratio' => 1,
          'jumlah' => $t->jumlah
        ];
        $simpandebet = $this->db->insert('kaskecil_detail', $data);
        //Simpan Cost Ratio
        if ($simpandebet) {
          if ($t->peruntukan != "MP") {
            $this->db->insert('costratio_biaya', $datacr);
          }
        }
      } else {
        $data = array(
          'tgl_kaskecil' => $tanggal,
          'nobukti'      => $nobukti,
          'keterangan'   => $t->keterangan,
          'jumlah'       => $t->jumlah,
          'kode_akun'    => $t->kode_akun,
          'kode_cabang'  => $t->kode_cabang,
          'status_dk'    => $t->status_dk,
          'peruntukan'   => $t->peruntukan,
          'order'        => 2,
        );
        $simpankredit = $this->db->insert('kaskecil_detail', $data);
      }
    }

    $hapus = $this->db->delete('kaskecil_detail_temp', array('nobukti' => $nobukti));
    if ($hapus) {
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Berhasil Disimpan !

      </div>'
      );

      redirect('kaskecil');
    }
  }

  function insert_kaskecil_temp()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    $status_dk = $this->input->post('inout');
    // if($cabang == 'PST'){
    //   $status_dk = $this->input->post('inout');
    // }else{
    //   $status_dk = 'D';
    // }
    $tanggal    = $this->input->post('tanggal');
    $nobukti    = $this->input->post('nobukti');
    $keterangan = $this->input->post('keterangan');
    $jumlah     = str_replace(".", "", $this->input->post('jumlah'));
    $akun       = $this->input->post('kodeakun');
    $peruntukan = $this->input->post('peruntukan');

    $data = array(
      'tgl_kaskecil' => $tanggal,
      'nobukti'      => $nobukti,
      'keterangan'   => $keterangan,
      'jumlah'       => $jumlah,
      'kode_akun'    => $akun,
      'kode_cabang'  => $cabang,
      'status_dk'    => $status_dk,
      'peruntukan'   => $peruntukan
    );

    $simpan = $this->db->insert('kaskecil_detail_temp', $data);
  }
  function getSaldoAwal($dari = "", $sampai = "", $cabang = "")
  {
    if (empty($cabang)) {
      $cabang = $this->session->userdata('cabang');
    } else {
      $cabang = $cabang;
    }

    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    // /echo $cabang;

    if ($cabang != "") {
      $this->db->where('kode_cabang', $cabang);
    }
    $this->db->select("SUM(IF( `status_dk` = 'K', jumlah, 0)) -SUM(IF( `status_dk` = 'D', jumlah, 0)) as saldo_awal");
    $this->db->from('kaskecil_detail');
    $this->db->where('tgl_kaskecil <', $dari);
    return $this->db->get();
  }

  function getSaldoAwalMB($dari = "", $sampai = "", $cabang = "")
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    if ($cabang != "") {
      $this->db->where('kode_cabang', $cabang);
    }
    $this->db->select("SUM(IF( `status_dk` = 'K', jumlah, 0)) -SUM(IF( `status_dk` = 'D', jumlah, 0)) as saldo_awal");
    $this->db->from('mutasibank');
    $this->db->where('tgl_mutasi <', $dari);
    return $this->db->get();
  }

  function getSaldoAwalMutasiBank()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    $keterangan = "SALDO AWAL " . $cabang;
    return $this->db->get_where('mutasibank', array('keterangan' => $keterangan));
  }

  function insert_saldoawal()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }

    $nobukti = "SA" . $cabang;
    $tanggal = $this->input->post('tanggal');
    $jumlah  = str_replace(".", "", $this->input->post('jumlah'));

    $data_detail = array(
      'nobukti'     => $nobukti,
      'tgl_kaskecil' => $tanggal,
      'keterangan'  => 'SALDO AWAL',
      'jumlah'      => $jumlah,
      'kode_cabang' => $cabang,
      'status_dk'   => 'K'
    );

    $simpan = $this->db->insert('kaskecil_detail', $data_detail);
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-green text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Berhasil Disimpan !

      </div>'
      );

      redirect('kaskecil');
    }
  }

  function insert_saldoawalmb()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang  == "pusat") {
      $cabang   = 'PST';
    } else {
      $cabang = $cabang;
    }

    $keterangan = 'SALDO AWAL ' . $cabang;
    $tanggal    = $this->input->post('tanggal');
    $jumlah     = str_replace(".", "", $this->input->post('jumlah'));

    $data_detail = array(
      'tgl_mutasi'  => $tanggal,
      'keterangan'  => $keterangan,
      'jumlah'      => $jumlah,
      'status_dk'   => 'K',
      'kode_cabang' => $cabang
    );

    $simpan = $this->db->insert('mutasibank', $data_detail);
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-green text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Berhasil Disimpan !

      </div>'
      );

      redirect('kaskecil/mutasibank');
    }
  }

  function cekSaldoAwal()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    $nobukti = 'SA' . $cabang;
    return $this->db->get_where('kaskecil_detail', array('nobukti' => $nobukti));
  }

  function cekSaldoAwalMB()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    $keterangan = 'SALDO AWAL ' . $cabang;
    return $this->db->get_where('mutasibank', array('keterangan' => $keterangan));
  }

  function getKaskecil($id)
  {
    return $this->db->get_where('kaskecil_detail', array('id' => $id));
  }

  function getMutasibank($id)
  {
    return $this->db->get_where('mutasibank', array('id' => $id));
  }

  function view_detailkaskecil($nobukti)
  {
    $this->db->select('id,nobukti,keterangan,jumlah,kaskecil_detail.kode_akun,nama_akun,status_dk');
    $this->db->from('kaskecil_detail');
    $this->db->join('coa', 'kaskecil_detail.kode_akun=coa.kode_akun');
    $this->db->where('nobukti', $nobukti);
    return $this->db->get();
  }

  function hapus_detailkaskecil($id, $nobukti)
  {
    $this->db->delete('kaskecil_detail', array('id' => $id));

    $cek = $this->db->get_where('kaskecil_detail', array('nobukti' => $nobukti))->num_rows();
    if ($cek < 1) {
      $this->db->delete('kaskecil', array('nobukti' => $nobukti));
    }
  }

  function update_kaskecil()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    $status_dk = $this->input->post('inout');
    // if($cabang == 'PST'){
    //   $status_dk = $this->input->post('inout');
    // }else{
    //   $status_dk = 'D';
    // }
    $tanggal      = $this->input->post('tanggal');
    $nobukti      = $this->input->post('nobukti');
    $id           = $this->input->post('id');
    $keterangan   = $this->input->post('keterangan');
    $jumlah       = str_replace(".", "", $this->input->post('jumlah'));
    $akun         = $this->input->post('kodeakun');
    $kodecr       = $this->input->post('kodecr');
    $peruntukan   = $this->input->post('peruntukan');

    // echo $peruntukan;
    // die;
    echo $kodecr;
    $cekakun = substr($akun, 0, 3);
    if ($status_dk == 'D' and $peruntukan != "MP" and $cekakun == '6-1' or $status_dk == 'D' and $peruntukan != "MP" and $cekakun == '6-2') {
      if (empty($kodecr)) {
        $tgltransaksi = explode("-", $tanggal);
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

        $datacrnew = [
          'kode_cr' => $kodecrnew,
          'tgl_transaksi' => $tanggal,
          'kode_akun'    => $akun,
          'keterangan'   => $keterangan,
          'kode_cabang'  => $cabang,
          'id_sumber_costratio' => 1,
          'jumlah' => $jumlah
        ];
        $data = array(
          'tgl_kaskecil' => $tanggal,
          'nobukti'      => $nobukti,
          'keterangan'   => $keterangan,
          'jumlah'       => $jumlah,
          'kode_akun'    => $akun,
          'status_dk'    => $status_dk,
          'kode_cr'      => $kodecrnew,
          'peruntukan'   => $peruntukan
        );
      } else {
        $datacr = [
          'tgl_transaksi' => $tanggal,
          'kode_akun'    => $akun,
          'keterangan'   => $keterangan,
          'jumlah' => $jumlah,
        ];

        $data = array(
          'tgl_kaskecil' => $tanggal,
          'nobukti'      => $nobukti,
          'keterangan'   => $keterangan,
          'jumlah'       => $jumlah,
          'kode_akun'    => $akun,
          'status_dk'    => $status_dk,
          'kode_cr'      => $kodecr,
          'peruntukan'   => $peruntukan
        );
      }

      $update = $this->db->update('kaskecil_detail', $data, array('id' => $id));
      if ($update) {
        if (empty($kodecr)) {
          $this->db->insert('costratio_biaya', $datacrnew);
        } else {
          $this->db->update('costratio_biaya', $datacr, array('kode_cr' => $kodecr));
        }
      }
    } else {
      $data = array(
        'tgl_kaskecil' => $tanggal,
        'nobukti'      => $nobukti,
        'keterangan'   => $keterangan,
        'jumlah'       => $jumlah,
        'kode_akun'    => $akun,
        'status_dk'    => $status_dk,
        'kode_cr'      => NULL,
        'peruntukan'   => $peruntukan
      );

      $update = $this->db->update('kaskecil_detail', $data, array('id' => $id));
      if ($update) {
        $this->db->delete('costratio_biaya', array('kode_cr' => $kodecr));
      }
    }
    $this->session->set_flashdata(
      'msg',

      '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Berhasil Disimpan !

      </div>'
    );

    redirect('kaskecil');
  }

  function update_kaskecilakun()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }
    //$status_dk = $this->input->post('inout');
    // if($cabang == 'PST'){
    //   $status_dk = $this->input->post('inout');
    // }else{
    //   $status_dk = 'D';
    // }
    //$tanggal      = $this->input->post('tanggal');
    //$nobukti      = $this->input->post('nobukti');
    $id           = $this->input->post('id');
    //$keterangan   = $this->input->post('keterangan');
    //$jumlah       = str_replace(".", "", $this->input->post('jumlah'));
    $akun         = $this->input->post('kodeakun');
    $kodecr       = $this->input->post('kodecr');
    $peruntukan   = $this->input->post('peruntukan');
    if (empty($kodecr)) {
      $data = array(
        'kode_akun'    => $akun,
        'peruntukan'   => $peruntukan
      );
      $update = $this->db->update('kaskecil_detail', $data, array('id' => $id));
    } else {
      $datacr = [
        'kode_akun' => $akun
      ];
      $data = array(
        'kode_akun'    => $akun,
        'kode_cr'      => $kodecr,
        'peruntukan'   => $peruntukan
      );
      $update = $this->db->update('kaskecil_detail', $data, array('id' => $id));
      $this->db->update('costratio_biaya', $datacr, array('kode_cr' => $kodecr));
    }
    $this->session->set_flashdata(
      'msg',

      '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Berhasil Disimpan !

      </div>'
    );

    redirect('kaskecil');
  }

  function update_mutasibank()
  {
    $tanggal      = $this->input->post('tanggal');
    $id           = $this->input->post('id');
    $keterangan   = $this->input->post('keterangan');
    $jumlah       = str_replace(".", "", $this->input->post('jumlah'));
    $akun         = $this->input->post('kodeakun');
    $debetkredit  = $this->input->post('debetkredit');
    $data = array(
      'tgl_mutasi'   => $tanggal,
      'keterangan'   => $keterangan,
      'jumlah'       => $jumlah,
      'kode_akun'    => $akun,
      'status_dk'    => $debetkredit
    );

    $update = $this->db->update('mutasibank', $data, array('id' => $id));
    if ($update) {
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-green text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Berhasil Disimpan !

      </div>'
      );

      redirect('kaskecil/mutasibank');
    }
  }

  function hapus_kaskkecil($id, $kodecr)
  {
    $hapus = $this->db->delete('kaskecil_detail', array('id' => $id));
    if ($hapus) {
      $hapuscr = $this->db->delete('costratio_biaya', array('kode_cr' => $kodecr));
      if ($hapuscr) {
        $this->session->set_flashdata(
          'msg',

          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
  
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  
        <i class="fa fa-check"></i>Data Berhasil Dihapus !
  
        </div>'
        );

        redirect('kaskecil');
      }
    }
  }

  function insert_mutasibank()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang == "pusat") {
      $cabang = 'PST';
    } else {
      $cabang = $cabang;
    }

    $tanggal    = $this->input->post('tanggal');
    $keterangan = $this->input->post('keterangan');
    $debetkredit = $this->input->post('debetkredit');
    $jumlah     = str_replace(".", "", $this->input->post('jumlah'));
    $akun       = $this->input->post('kodeakun');

    $data = array(
      'tgl_mutasi'   => $tanggal,
      'keterangan'   => $keterangan,
      'jumlah'       => $jumlah,
      'kode_akun'    => $akun,
      'kode_cabang'  => $cabang,
      'status_dk'    => $debetkredit
    );

    $simpan = $this->db->insert('mutasibank', $data);
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-green text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Berhasil Disimpan !

      </div>'
      );

      redirect('kaskecil/mutasibank');
    }
  }

  function hapus_mutasibank($id)
  {
    $hapus = $this->db->delete('ledger_bank', array('no_bukti' => $id));
    if ($hapus) {
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-green text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Berhasil Dihapus !

      </div>'
      );

      redirect('kaskecil/mutasibank');
    }
  }

  function update_saldoawalmb()
  {
    $cabang = $this->session->userdata('cabang');
    if ($cabang  == "pusat") {
      $cabang   = 'PST';
    } else {
      $cabang = $cabang;
    }

    $keterangan = 'SALDO AWAL ' . $cabang;
    $tanggal    = $this->input->post('tanggal');
    $jumlah     = str_replace(".", "", $this->input->post('jumlah'));

    $data_detail = array(
      'tgl_mutasi'  => $tanggal,
      'jumlah'      => $jumlah
    );

    $simpan = $this->db->update('mutasibank', $data_detail, array('keterangan' => $keterangan));
    if ($simpan) {
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-green text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Berhasil Disimpan !

      </div>'
      );

      redirect('kaskecil/mutasibank');
    }
  }

  function insert_klaim()
  {
    $cabang         = $this->session->userdata('cabang');
    if ($cabang  == "pusat") {
      $cabang   = 'PST';
    } else {
      $cabang = $cabang;
    }
    $tgl_klaim      = $this->input->post('tgl_klaim');
    $tanggal        = explode("-", $tgl_klaim);
    $tahun          = substr($tanggal[0], 2, 2);
    $keterangan     = $this->input->post('keterangan');
    $qklaim         = "SELECT kode_klaim FROM klaim WHERE LEFT(kode_klaim,7) ='KL$cabang$tahun'ORDER BY kode_klaim DESC LIMIT 1 ";
    $ceknolast      = $this->db->query($qklaim)->row_array();
    $kodelast       = $ceknolast['kode_klaim'];
    $kode_klaim     = buatkode($kodelast, 'KL' . $cabang . $tahun, 4);

    $data = array(
      'kode_klaim'    => $kode_klaim,
      'tgl_klaim'     => $tgl_klaim,
      'keterangan'    => $keterangan,
      'kode_cabang'   => $cabang
    );

    $cekklaim = $this->db->get_where('klaim', array('kode_cabang' => $cabang, 'status' => 0))->num_rows();
    if (empty($cekklaim)) {
      $simpan = $this->db->insert('klaim', $data);
      if ($simpan) {
        foreach ($_POST['id'] as $id) {
          $data = array('kode_klaim' => $kode_klaim);
          $this->db->update('kaskecil_detail', $data, array('id' => $id));
        }

        $this->session->set_flashdata(
          'msg',

          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Berhasil Disiman !

      </div>'
        );

        redirect('kaskecil/klaim');
      }
    } else {
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Sebelumnya Belum Di Proses !

      </div>'
      );

      redirect('kaskecil/klaim');
    }
  }

  function hapus_klaim($kode_klaim)
  {
    $hapus = $this->db->delete('klaim', array('kode_klaim' => $kode_klaim));
    if ($hapus) {
      $data = array(
        'kode_klaim' => ''
      );
      $update_kaskecil = $this->db->update('kaskecil_detail', $data, array('kode_klaim' => $kode_klaim));
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Berhasil Dihapus !

      </div>'
      );

      redirect('kaskecil/klaim');
    }
  }

  function detailklaim($kode_klaim)
  {
    $this->db->select('id,nobukti,tgl_kaskecil,kaskecil_detail.keterangan,jumlah,kaskecil_detail.kode_akun,status_dk,nama_akun,kaskecil_detail.kode_klaim');
    $this->db->from('kaskecil_detail');
    $this->db->join('coa', 'kaskecil_detail.kode_akun=coa.kode_akun');
    $this->db->where('kaskecil_detail.kode_klaim', $kode_klaim);
    $this->db->order_by('tgl_kaskecil,nobukti', 'asc');
    return $this->db->get();
  }


  function cekklaim($tgl_klaim, $cabang)
  {

    $this->db->where('tgl_klaim <', $tgl_klaim);
    $this->db->where('kode_cabang', $cabang);
    return $this->db->get('klaim');
  }


  function getSaldoAwalKlaim1($cabang)
  {
    return $this->db->get_where('kaskecil_detail', array('keterangan' => 'SALDO AWAL', 'kode_cabang' => $cabang));
  }

  function getLastklaim($kode_klaim, $cabang)
  {
    $this->db->where('kode_klaim <', $kode_klaim);
    $this->db->where('kode_cabang', $cabang);
    $this->db->order_by('kode_klaim', 'desc');
    $this->db->limit(1);
    return $this->db->get('klaim');
  }

  function getKlaim($kode_klaim)
  {
    return $this->db->get_where('klaim', array('kode_klaim' => $kode_klaim));
  }

  function getBank()
  {
    return $this->db->get('master_bank');
  }

  function insert_ledger()
  {
    $cabang         = $this->input->post('kode_cabang');
    $kode_klaim     = $this->input->post('kode_klaim');
    $tgl            = $this->input->post('tanggal');
    $bank           = $this->input->post('bank');
    $jumlah         = str_replace(".", "", $this->input->post('jumlah'));
    $saldoakhir     = $this->input->post('saldoakhir');
    $tanggal        = explode("-", $tgl);
    $tahun          = substr($tanggal[0], 2, 2);
    $keterangan     = $this->input->post('keterangan');
    $qledger        = "SELECT no_bukti FROM ledger_bank WHERE LEFT(no_bukti,7) ='LR$cabang$tahun'ORDER BY no_bukti DESC LIMIT 1 ";
    $ceknolast      = $this->db->query($qledger)->row_array();
    $nobuktilast    = $ceknolast['no_bukti'];
    $no_bukti       = buatkode($nobuktilast, 'LR' . $cabang . $tahun, 4);

    $data = array(
      'no_bukti'        => $no_bukti,
      'tgl_ledger'      => $tgl,
      'bank'            => $bank,
      'pelanggan'       => 'BNI CAB ' . $cabang,
      'keterangan'      => $keterangan,
      'kode_akun'       => '1-1104',
      'jumlah'          => $jumlah,
      'status_dk'       => 'D',
      'kode_klaim'      => $kode_klaim,
      'status_validasi' => '0'
    );
    $cek = $this->db->get_where('ledger_bank', array('kode_klaim' => $kode_klaim))->num_rows();
    if (empty($cek)) {
      $simpan = $this->db->insert('ledger_bank', $data);
      if ($simpan) {
        $data = array('status' => '1', 'saldo_akhir' => $saldoakhir);
        $update_klaim = $this->db->update('klaim', $data, array('kode_klaim' => $kode_klaim));
        $this->session->set_flashdata(
          'msg',

          '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <i class="fa fa-check"></i> Data Berhasil Disimpan !

        </div>'
        );

        redirect('kaskecil/klaimcabang');
      }
    } else {
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-red text-white text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-close"></i> Data Sudah Diinputkan sebelumnya !

      </div>'
      );

      redirect('kaskecil/klaimcabang');
    }
  }

  function batal_klaim($kode_klaim)
  {

    $hapus = $this->db->delete('ledger_bank', array('kode_klaim' => $kode_klaim));
    if ($hapus) {
      $data = array('status' => '0', 'saldo_akhir' => 0);
      $batal = $this->db->update('klaim', $data, array('kode_klaim' => $kode_klaim));
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Klaim Berhasil Dibatalkan !

      </div>'
      );

      redirect('kaskecil/klaimcabang');
    }
  }

  public function getDataPenerimaankaskecil($rowno, $rowperpage, $dari = "", $sampai = "")
  {
    $cabang         = $this->session->userdata('cabang');
    if ($cabang  == "pusat") {
      $cabang   = 'PST';
    } else {
      $cabang = $cabang;
    }
    $this->db->select('no_bukti,klaim.kode_klaim,tgl_klaim,klaim.keterangan,kode_cabang,status,no_bukti,tgl_ledger,status_validasi,jumlah');
    $this->db->from('klaim');
    $this->db->join('ledger_bank', 'klaim.kode_klaim = ledger_bank.kode_klaim', 'left');
    if ($dari != "" and $sampai != "") {
      $this->db->where('tgl_klaim >=', $dari);
      $this->db->where('tgl_klaim <=', $sampai);
    }
    $this->db->where('klaim.kode_cabang', $cabang);
    $this->db->order_by('tgl_klaim', 'ASC');
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

  // Select total records
  public function getrecordPenerimaankaskecil($dari = "", $sampai = "")
  {
    $cabang         = $this->session->userdata('cabang');
    if ($cabang  == "pusat") {
      $cabang   = 'PST';
    } else {
      $cabang = $cabang;
    }
    $this->db->select('count(*) as allcount');
    $this->db->from('klaim');
    if ($dari != "" and $sampai != "") {
      $this->db->where('tgl_klaim >=', $dari);
      $this->db->where('tgl_klaim <=', $sampai);
    }
    $this->db->where('klaim.kode_cabang', $cabang);
    $query   = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function getledger($no_bukti)
  {
    return $this->db->get_where('ledger_bank', array('no_bukti' => $no_bukti));
  }

  function getAkun($cabang)
  {
    $this->db->select('set_coa_cabang.kode_akun,nama_akun');
    $this->db->from('set_coa_cabang');
    $this->db->join('coa', 'set_coa_cabang.kode_akun = coa.kode_akun');
    $this->db->where('kode_cabang', $cabang);
    $this->db->where('kategori', 'Kas Kecil');
    $this->db->like('nama_akun', 'Kas Kecil');
    return $this->db->get();
  }

  function batalkan_validasi($no_bukti)
  {
    $hapus_kaskecil = $this->db->delete('kaskecil_detail', array('nobukti' => $no_bukti));
    if ($hapus_kaskecil) {
      $update_ledger = $this->db->update('ledger_bank', array('status_validasi' => 0), array('no_bukti' => $no_bukti));
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-green text-white text-white alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      <i class="fa fa-check"></i> Data Validasi Berhasil Dibatalkan !

      </div>'
      );

      redirect('kaskecil/penerimaankaskecil');
    }
  }

  function tampilkaskeciltemp($nobukti)
  {
    $this->db->join('coa', 'kaskecil_detail_temp.kode_akun = coa.kode_akun');
    return $this->db->get_where('kaskecil_detail_temp', array('nobukti' => $nobukti));
  }

  function hapuskaskeciltemp($id)
  {
    $this->db->delete('kaskecil_detail_temp', array('id' => $id));
  }
}
