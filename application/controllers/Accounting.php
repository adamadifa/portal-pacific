<?php

class Accounting extends CI_Controller
{
  private  $akunbank = array("1-1201");
  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_accounting', 'Model_cabang', 'Model_keuangan'));
  }

  function costratiobiaya()
  {

    $cbg                = "";
    $dari               = "";
    $sampai             = "";
    if ($this->input->post('submit') != NULL) {
      $cbg      = $this->input->post('cabang');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $data     = array(
        'cbg'        => $cbg,
        'dari'       => $dari,
        'sampai'     => $sampai
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }
    // Get records
    $users_record = $this->Model_accounting->getDataCostRatio($cbg, $dari, $sampai)->result_array();
    $jmldata = $this->Model_accounting->getDataCostRatio($cbg, $dari, $sampai)->num_rows();
    $data['result']             = $users_record;
    $data['cbg']                = $cbg;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['cabang']             = $this->Model_cabang->view_cabang()->result();
    $data['jmldata']            = $jmldata;
    $data['cb']                 = $this->session->userdata('cabang');
    $this->template->load('template/template', 'accounting/costratiobiaya', $data);
  }

  function costratiobiayainput()
  {
    $data['sumber'] = $this->Model_accounting->listsumber()->result();
    $data['coa']    = $this->Model_keuangan->coa()->result();
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->load->view('accounting/costratiobiaya_input', $data);
  }

  function input_jurnalpeny()
  {
    $data['kodeakun']    = $this->input->post('kodeakun');
    $this->load->view('accounting/input_jurnalpeny', $data);
  }

  function editpenyesuaian()
  {
    $nobukti = $this->input->post('nobukti');
    $data['peny'] = $this->Model_accounting->getPenyesuaian($nobukti)->row_array();
    $this->load->view('accounting/edit_jurnalpeny', $data);
  }

  function costratiobiayaedit()
  {
    $kodecr = $this->uri->segment(3);
    $data['cr'] = $this->Model_accounting->getCostRatio($kodecr)->row_array();
    $data['sumber'] = $this->Model_accounting->listsumber()->result();
    $data['coa']    = $this->Model_keuangan->coa()->result();
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->load->view('accounting/costratiobiaya_edit', $data);
  }

  function insertcostratiobiaya()
  {
    $this->Model_accounting->insertcostratiobiaya();
  }

  function insert_bukubesar()
  {
    $kode_akun      = $this->input->post('kode_akun');
    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    if ($kode_akun == "1-1114") {
      $cabang = "PWT";
    } else if ($kode_akun == "1-1103") {
      $cabang = "BGR";
    } else if ($kode_akun == "1-1112") {
      $cabang = "TSM";
    } else if ($kode_akun == "1-1111") {
      $cabang = "PST";
    } else if ($kode_akun == "1-1115") {
      $cabang = "TGL";
    } else if ($kode_akun == "1-1102") {
      $cabang = "BDG";
    } else if ($kode_akun == "1-1113") {
      $cabang = "SKB";
    } else if ($kode_akun == "1-1116") {
      $cabang = "SBY";
    } else if ($kode_akun == "1-1117") {
      $cabang = "SMR";
    } else {
      $cabang = "";
    }

    echo $cabang;
    //die;

    $this->Model_accounting->insert_bukubesar($kode_akun, $bulan, $tahun, $cabang);
  }

  function updatecostratiobiaya()
  {
    $this->Model_accounting->updatecostratiobiaya();
  }

  function hapuscostratiobiaya()
  {
    $kodecr = $this->uri->segment(3);
    $this->Model_accounting->hapuscostratiobiaya($kodecr);
  }

  function view_saldoawal($rowno = 0)
  {

    $kode_saldoawal_bb      = "";
    $tanggal                = "";
    $bulan                  = "";
    $tahun                  = "";

    if ($this->input->post('submit') != NULL) {
      $kode_saldoawal_bb       = $this->input->post('kode_saldoawal_bb');
      $tanggal                 = $this->input->post('tanggal');
      $bulan                   = $this->input->post('bulan');
      $tahun                   = $this->input->post('tahun');
      $data   = array(
        'kode_saldoawal_bb'    => $kode_saldoawal_bb,
        'tanggal'              => $tanggal,
        'bulan'                => $bulan,
        'tahun'                => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('kode_saldoawal_bb') != NULL) {
        $kode_saldoawal_bb = $this->session->userdata('kode_saldoawal_bb');
      }

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }

      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }

      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }
    $rowperpage = 10;
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    $allcount                     = $this->Model_accounting->getRecordSaldoAwalnCount($kode_saldoawal_bb, $tanggal, $bulan, $tahun);
    $users_record                 = $this->Model_accounting->getDataSaldoAwal($rowno, $rowperpage, $kode_saldoawal_bb, $tanggal, $bulan, $tahun);
    $config['base_url']           = base_url() . 'accounting/view_saldoawal';
    $config['use_page_numbers']   = TRUE;
    $config['total_rows']         = $allcount;
    $config['per_page']           = $rowperpage;
    $config['first_link']         = 'First';
    $config['last_link']          = 'Last';
    $config['next_link']          = 'Next';
    $config['prev_link']          = 'Prev';
    $config['full_tag_open']      = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']     = '</ul></nav></div>';
    $config['num_tag_open']       = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']      = '</span></li>';
    $config['cur_tag_open']       = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']      = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']    = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']    = '</span>Next</li>';
    $config['first_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close']   = '</span></li>';
    $config['last_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']    = '</span></li>';
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                  = $rowno;
    $data['kode_saldoawal_bb']    = $kode_saldoawal_bb;
    $data['tanggal']              = $tanggal;
    $data['bulan']                = $bulan;
    $data['tahun']                = $tahun;
    $data['tahuns']               = date("Y");
    $data['bulans']               = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->template->load('template/template', 'accounting/view_saldoawal', $data);
  }

  function view_jurnal_umum()
  {
    $kode_akun                = "";
    $dari                     = $this->input->post('dari');
    $sampai                   = $this->input->post('sampai');
    $kode_akun                = $this->input->post('kode_akun');

    $data['dari']       = $dari;
    $data['sampai']     = $sampai;
    $data['kode_akun']  = $kode_akun;
    $data['data']       = $this->Model_accounting->getJurnalUmum($kode_akun, $dari, $sampai)->result();
    $data['coa']        = $this->Model_accounting->coa()->result();
    $this->template->load('template/template', 'accounting/view_jurnal_umum', $data);
  }

  function view_accounting()
  {
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['coa']       = $this->Model_accounting->coa()->result();
    $this->template->load('template/template', 'accounting/view_accounting', $data);
  }

  function input_saldoawal()
  {
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['coa']       = $this->Model_accounting->coa()->result();
    $this->template->load('template/template', 'accounting/input_saldoawal', $data);
  }

  function view_ledger()
  {
    $kode_akun      = $this->input->post('kode_akun');
    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    $data['kode_akun'] = $kode_akun;
    $data['akunbank'] = $this->akunbank;
    $data['ledger'] = $this->Model_accounting->ledger($kode_akun, $bulan, $tahun)->result();
    $this->load->view('accounting/view_ledger', $data);
  }

  function input_jurnal_umum()
  {
    $data['coa']        = $this->Model_accounting->coa()->result();
    $this->template->load('template/template', 'accounting/input_jurnal_umum', $data);
  }
  function view_jurnal_umum_temp()
  {
    $data['detail']      = $this->Model_accounting->getJurnalUmumTemp()->result();
    $this->load->view('accounting/view_jurnal_umum_temp', $data);
  }

  function insert_jurnal_umum_temp()
  {
    $this->Model_accounting->insert_jurnal_umum_temp();
  }


  function view_kaskecil()
  {
    $kode_akun      = $this->input->post('kode_akun');
    if ($kode_akun == "1-1114") {
      $cabang = "PWT";
    } else if ($kode_akun == "1-1103") {
      $cabang = "BGR";
    } else if ($kode_akun == "1-1112") {
      $cabang = "TSM";
    } else if ($kode_akun == "1-1111") {
      $cabang = "PST";
    } else if ($kode_akun == "1-1115") {
      $cabang = "TGL";
    } else if ($kode_akun == "1-1102") {
      $cabang = "BDG";
    } else if ($kode_akun == "1-1113") {
      $cabang = "SKB";
    } else if ($kode_akun == "1-1116") {
      $cabang = "SBY";
    } else if ($kode_akun == "1-1117") {
      $cabang = "SMR";
    } else {
      $cabang = "";
    }
    $data['kode_akun'] = $kode_akun;
    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    $data['kaskecil'] = $this->Model_accounting->kaskecil($kode_akun, $bulan, $tahun, $cabang)->result();
    $this->load->view('accounting/view_kaskecil', $data);
  }

  function view_pembelian()
  {
    $kode_akun      = $this->input->post('kode_akun');
    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    $data['pembelian'] = $this->Model_accounting->pembelian($kode_akun, $bulan, $tahun)->result();
    $this->load->view('accounting/view_pembelian', $data);
  }

  function view_penyesuaian()
  {
    $kode_akun      = $this->input->post('kode_akun');
    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    $data['peny'] = $this->Model_accounting->penyesuaian($kode_akun, $bulan, $tahun)->result();
    $this->load->view('accounting/view_penyesuaian', $data);
  }

  function view_kasbank()
  {
    $kode_akun      = $this->input->post('kode_akun');
    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    $data['pembelian'] = $this->Model_accounting->pembelian($kode_akun, $bulan, $tahun)->result();
    $this->load->view('accounting/view_kasbank', $data);
  }

  function input_detailsaldoawal()
  {
    $data['coa']        = $this->Model_accounting->coa()->result();
    $data['saldo']      = $this->Model_accounting->getSaldoAwal()->row_array();
    $this->template->load('template/template', 'accounting/input_detailsaldoawal', $data);
  }

  function view_detailsaldoawal()
  {
    $data['detail']      = $this->Model_accounting->getDetailSaldoAwal()->result();
    $this->load->view('accounting/view_detailsaldoawal', $data);
  }

  function insert_saldoawal()
  {
    $this->Model_accounting->insert_saldoawal();
  }

  function insert_penyesuaian()
  {
    $this->Model_accounting->insert_penyesuaian();
  }

  function insert_jurnal_umum()
  {
    $this->Model_accounting->insert_jurnal_umum();
  }

  function update_penyesuaian()
  {
    $this->Model_accounting->update_penyesuaian();
  }

  function hapus_penyesuaian()
  {
    $this->Model_accounting->hapus_penyesuaian();
  }


  function hapus_detailsaldoawal()
  {
    $this->Model_accounting->hapus_detailsaldoawal();
  }

  function hapus_jurnal_umum_temp()
  {
    $this->Model_accounting->hapus_jurnal_umum_temp();
  }

  function hapussaldoawal()
  {
    $this->Model_accounting->hapussaldoawal();
  }

  function insert_detailsaldoawal()
  {
    $this->Model_accounting->insert_detailsaldoawal();
  }

  function hapusbukubesar()
  {
    $nobukti = $this->input->post('nobukti');
    $hapus = $this->Model_accounting->hapusbukubesar($nobukti);
    echo $hapus;
  }

  function tambahbukubesar()
  {
    $nobukti = $this->input->post('nobukti');
    $sumber = $this->input->post('sumber');
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $noref = $this->input->post('noref');
    $kodeakun = $this->input->post('kode_akun');
    $simpan =  $this->Model_accounting->tambahbukubesar($nobukti, $sumber, $bulan, $tahun, $noref, $kodeakun);
    echo $simpan;
  }

  function updatebukubesar()
  {
    $nobukti = $this->input->post('nobukti');
    $sumber = $this->input->post('sumber');
    $noref = $this->input->post('noref');
    $kode_akun = $this->input->post('kode_akun');
    $simpan =  $this->Model_accounting->updatebukubesar($nobukti, $sumber, $noref, $kode_akun);
    echo $simpan;
  }
}
