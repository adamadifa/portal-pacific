<?php
class Kaskecil extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_coa', 'Model_kaskecil', 'Model_cabang', 'Model_keuangan'));
  }

  function index($rowno = 0)
  {
    // Search text
    $dari       = "";
    $sampai     = "";
    $nobukti    = "";
    $kodeakun   = "";
    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $nobukti  = $this->input->post('nobukti');
      $kodeakun = $this->input->post('kodeakun');
      $data     = array(

        'dari'         => $dari,
        'sampai'       => $sampai,
        'nobukti'     => $nobukti,
        'kodeakun'    => $kodeakun

      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }

      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }

      if ($this->session->userdata('nobukti') != NULL) {
        $nobukti = $this->session->userdata('nobukti');
      }

      if ($this->session->userdata('kodeakun') != NULL) {
        $kodeakun = $this->session->userdata('kodeakun');
      }
    }

    // Row per page
    $rowperpage = 700;

    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_kaskecil->getrecordCount($dari, $sampai, $nobukti, $kodeakun);
    // Get records
    $users_record = $this->Model_kaskecil->getData($rowno, $rowperpage, $dari, $sampai, $nobukti, $kodeakun);




    // Pagination Configuration
    $config['base_url']         = base_url() . 'pembayaran/index';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows']       = $allcount;
    $config['per_page']         = $rowperpage;

    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    // Initialize
    $this->pagination->initialize($config);

    $data['pagination']        = $this->pagination->create_links();
    $data['result']            = $users_record;
    $data['row']                = $rowno;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['nobukti']           = $nobukti;
    $data['saldoawal']         = $this->Model_kaskecil->getSaldoAwal($dari, $sampai)->row_array();
    $data['ceksaldoawal']      = $this->Model_kaskecil->cekSaldoAwal()->num_rows();
    $kategori                  = "Kas Kecil";
    $data['kodeakun']          = $kodeakun;
    $cabang                    = $this->session->userdata('cabang');
    if ($cabang == 'pusat') {
      $cb = 'PST';
    } else {
      $cb = $cabang;
    }
    //echo $cabang;
    $data['coa']   = $this->Model_coa->view_set_coa_cabang($cb, $kategori)->result();
    // Load view
    $this->template->load('template/template', 'kaskecil/kaskecil', $data);
  }

  function inputkaskecil()
  {
    $kategori      = "Kas Kecil";
    $cabang        = $this->session->userdata('cabang');
    if ($cabang == 'pusat') {
      $cb = 'PST';
    } else {
      $cb = $cabang;
    }
    //echo $cabang;
    $data['coa']   = $this->Model_coa->view_set_coa_cabang($cb, $kategori)->result();
    $this->load->view('kaskecil/inputkaskecil2', $data);
  }

  function inputmutasibank()
  {
    $kategori      = "Mutasi Bank";
    $cabang        = $this->session->userdata('cabang');
    if ($cabang == 'pusat') {
      $cb = 'PST';
    } else {
      $cb = $cabang;
    }
    //echo $cabang;
    $data['lbank']     = $this->Model_keuangan->getBank($cabang)->result();
    $data['coa']       = $this->Model_coa->view_set_coa_cabang($cb, $kategori)->result();
    $this->load->view('kaskecil/inputmutasibank', $data);
  }


  function insert_kaskecil()
  {
    $this->Model_kaskecil->insert_kaskecil();
  }
  function insert_kaskecil2()
  {
    $this->Model_kaskecil->insert_kaskecil2();
  }

  function insert_mutasibank()
  {
    $this->Model_kaskecil->insert_mutasibank();
  }
  function insert_detailkaskeciltemp()
  {
    $this->Model_kaskecil->insert_detailkaskeciltemp();
  }

  function view_detailkaskeciltemp()
  {
    $data['detailtemp'] = $this->Model_kaskecil->view_detailkaskeciltemp()->result();
    $this->load->view('kaskecil/view_detailkaskeciltemp', $data);
  }

  function hapus_detailkaskeciltemp()
  {
    $id = $this->input->post('id');
    $this->Model_kaskecil->hapus_detailkaskeciltemp($id);
  }

  function cek_detailtmp()
  {
    $admin = $this->session->userdata('id_user');
    $cek   = $this->db->get_where('kaskecil_detailtemp', array('id_admin' => $admin));
    echo $cek->num_rows();
  }

  function inputsaldoawal()
  {
    $this->load->view('kaskecil/inputsaldoawal');
  }

  function inputsaldoawalmb()
  {
    $this->load->view('kaskecil/inputsaldoawalmb');
  }

  function editsaldoawalmb()
  {
    $data['saldoawal'] = $this->Model_kaskecil->getSaldoAwalMutasiBank()->row_array();
    $this->load->view('kaskecil/editsaldoawalmb', $data);
  }

  function update_saldoawalmb()
  {
    $this->Model_kaskecil->update_saldoawalmb();
  }

  function insert_saldoawal()
  {
    $this->Model_kaskecil->insert_saldoawal();
  }

  function insert_saldoawalmb()
  {
    $this->Model_kaskecil->insert_saldoawalmb();
  }

  function editkaskecil()
  {

    $kategori      = "Kas Kecil";
    $cabang        = $this->session->userdata('cabang');
    if ($cabang == 'pusat') {
      $cb = 'PST';
    } else {
      $cb = $cabang;
    }

    $status = $this->input->post('status');
    if ($status == 0) {
      $data['readonly'] = "";
      $data['disabled'] = "";
    } else {
      $data['readonly'] = "readonly";
      $data['disabled'] = "disabled";
    }
    $data['status'] = $status;
    //echo $cabang;
    $data['coa']      = $this->Model_coa->view_set_coa_cabang($cb, $kategori)->result();
    $id               = $this->input->post('id');
    $data['kodecr']   = $this->input->post('kodecr');
    $data['kaskecil'] = $this->Model_kaskecil->getKaskecil($id)->row_array();
    $this->load->view('kaskecil/editkaskecil2', $data);
  }

  function editmutasibank()
  {

    $kategori      = "Mutasi Bank";
    $cabang        = $this->session->userdata('cabang');
    if ($cabang == 'pusat') {
      $cb = 'PST';
    } else {
      $cb = $cabang;
    }
    //echo $cabang;
    $data['lbank']      = $this->Model_keuangan->getBank($cabang)->result();
    $data['coa']        = $this->Model_coa->view_set_coa_cabang($cb, $kategori)->result();
    $id                 = $this->input->post('id');
    $data['mutasibank'] = $this->Model_keuangan->getLedger($id)->row_array();
    $this->load->view('kaskecil/editmutasibank', $data);
  }

  function view_detailkaskecil()
  {
    $nobukti  = $this->uri->segment(3);
    $data['detail'] = $this->Model_kaskecil->view_detailkaskecil($nobukti)->result();
    $this->load->view('kaskecil/view_detailkaskecil', $data);
  }

  function hapus_detailkaskecil()
  {
    $id       = $this->input->post('id');
    $nobukti  = $this->input->post('nobukti');
    $this->Model_kaskecil->hapus_detailkaskecil($id, $nobukti);
  }

  function update_kaskecil()
  {
    $status = $this->input->post('status');
    if ($status == 0) {

      $this->Model_kaskecil->update_kaskecil();
    } else {
      $this->Model_kaskecil->update_kaskecilakun();
    }
  }

  function update_mutasibank()
  {
    $this->Model_kaskecil->update_mutasibank();
  }

  function hapus_kaskkecil()
  {
    $id =  $this->uri->segment(3);
    $kodecr = $this->uri->segment(4);
    $this->Model_kaskecil->hapus_kaskkecil($id, $kodecr);
  }

  function hapus_mutasibank()
  {
    $id =  $this->uri->segment(3);
    $this->Model_kaskecil->hapus_mutasibank($id);
  }

  function klaim()
  {
    // Search text
    $dari       = "";
    $sampai     = "";

    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');

      $data   = array(

        'dari'         => $dari,
        'sampai'       => $sampai


      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }

      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }


    $users_record = $this->Model_kaskecil->getDataKlaim($dari, $sampai);

    $data['result']            = $users_record;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    // Load view
    $this->template->load('template/template', 'kaskecil/klaim', $data);
  }

  function klaimcabang()
  {
    // Search text
    $dari       = "";
    $sampai     = "";
    $cbg        = "";
    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $cbg      = $this->input->post('cabang');
      $data   = array(

        'dari'         => $dari,
        'sampai'       => $sampai,
        'cbg'         => $cbg


      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }

      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }

      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
    }

    // Get records
    $users_record = $this->Model_kaskecil->getDataKlaimcabang($dari, $sampai, $cbg);
    $data['result']            = $users_record;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['cbg']               = $cbg;
    $data['cabang']            = $this->Model_cabang->view_cabang()->result();
    // Load view
    $this->template->load('template/template', 'kaskecil/klaimcabang', $data);
  }

  function mutasibank()
  {
    // Search text
    $dari       = "";
    $sampai     = "";
    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');

      $data   = array(

        'dari'         => $dari,
        'sampai'       => $sampai,


      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }

      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }


    $users_record = $this->Model_kaskecil->getDataMB($dari, $sampai);

    $data['result']            = $users_record;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    // Load view
    $this->template->load('template/template', 'kaskecil/mutasibank', $data);
  }


  function buatklaim($rowno = 0)
  {
    // Search text
    $dari       = "";
    $sampai     = "";
    $nobukti    = "";
    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $nobukti  = $this->input->post('nobukti');
      $data   = array(

        'dari'         => $dari,
        'sampai'       => $sampai,
        'nobukti'     => $nobukti

      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }

      if ($this->session->userdata('nobukti') != NULL) {
        $nobukti = $this->session->userdata('nobukti');
      }
    }
    // Row per page
    $rowperpage = 800;
    //Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_kaskecil->getrecordCount($dari, $sampai, $nobukti);
    // Get records
    $users_record = $this->Model_kaskecil->getData($rowno, $rowperpage, $dari, $sampai, $nobukti);

    // Pagination Configuration
    $config['base_url']         = base_url() . 'pembayaran/index';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows']       = $allcount;
    $config['per_page']         = $rowperpage;
    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    // Initialize
    $this->pagination->initialize($config);

    $data['pagination']        = $this->pagination->create_links();
    $data['result']            = $users_record;
    $data['row']                = $rowno;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['nobukti']           = $nobukti;
    $data['saldoawal']         = $this->Model_kaskecil->getSaldoAwal($dari, $sampai)->row_array();
    $data['ceksaldoawal']      = $this->Model_kaskecil->cekSaldoAwal()->num_rows();
    // Load view
    $this->template->load('template/template', 'kaskecil/buatklaim', $data);
  }

  function insert_klaim()
  {
    $this->Model_kaskecil->insert_klaim();
  }

  function hapus_klaim()
  {
    $kode_klaim = $this->uri->segment(3);
    $this->Model_kaskecil->hapus_klaim($kode_klaim);
  }

  function detailklaim()
  {
    $kode_klaim         = $this->input->post('kode_klaim');
    $tgl_klaim          = $this->input->post('tgl_klaim');
    $kode_cabang        = $this->input->post('cabang');
    $cek_klaim          = $this->Model_kaskecil->cekklaim($tgl_klaim, $kode_cabang)->num_rows();
    //echo $cek_klaim;
    //$data['saldoawal']  = $this->Model_kaskecil->getSaldoAwalKlaim();
    //die;
    if (empty($cek_klaim)) {
      $saldoawal         = $this->Model_kaskecil->getSaldoAwalKlaim1($kode_cabang)->row_array();
      $data['saldoawal'] = $saldoawal['jumlah'];
    } else {
      $lastklaim         = $this->Model_kaskecil->getLastklaim($kode_klaim, $kode_cabang)->row_array();
      $data['saldoawal'] = $lastklaim['saldo_akhir'];
    }
    $data['klaim']      = $this->Model_kaskecil->getKlaim($kode_klaim)->row_array();
    $data['detail']     = $this->Model_kaskecil->detailklaim($kode_klaim)->result();
    $this->load->view('kaskecil/detailklaim', $data);
  }

  function cetakklaim()
  {
    $kode_klaim         = $this->input->post('kode_klaim');
    $tgl_klaim          = $this->input->post('tgl_klaim');
    $kode_cabang        = $this->input->post('cabang');
    $cek_klaim          = $this->Model_kaskecil->cekklaim($tgl_klaim, $kode_cabang)->num_rows();
    //echo $cek_klaim;
    //$data['saldoawal']  = $this->Model_kaskecil->getSaldoAwalKlaim();
    //die;
    if (empty($cek_klaim)) {
      $saldoawal         = $this->Model_kaskecil->getSaldoAwalKlaim1($kode_cabang)->row_array();
      $data['saldoawal'] = $saldoawal['jumlah'];
    } else {
      $lastklaim         = $this->Model_kaskecil->getLastklaim($kode_klaim, $kode_cabang)->row_array();
      $data['saldoawal'] = $lastklaim['saldo_akhir'];
    }
    $data['klaim']      = $this->Model_kaskecil->getKlaim($kode_klaim)->row_array();
    $data['detail']     = $this->Model_kaskecil->detailklaim($kode_klaim)->result();
    if (isset($_POST['export'])) {
      header("Content-type: application/vnd-ms-excel");

      header("Content-Disposition: attachment; filename=Klaim " . $tgl_klaim . ".xls");
    }
    $this->load->view('kaskecil/cetakklaim', $data);
  }

  function prosesklaim()
  {
    $kode_klaim         = $this->input->post('kode_klaim');
    $tgl_klaim          = $this->input->post('tgl_klaim');
    $kode_cabang        = $this->input->post('cabang');
    $cek_klaim          = $this->Model_kaskecil->cekklaim($tgl_klaim, $kode_cabang)->num_rows();
    //echo $cek_klaim;
    //$data['saldoawal']  = $this->Model_kaskecil->getSaldoAwalKlaim();
    //die;
    if (empty($cek_klaim)) {
      $saldoawal         = $this->Model_kaskecil->getSaldoAwalKlaim1($kode_cabang)->row_array();
      $data['saldoawal'] = $saldoawal['jumlah'];
    } else {
      $lastklaim         = $this->Model_kaskecil->getLastklaim($kode_klaim, $kode_cabang)->row_array();
      $data['saldoawal'] = $lastklaim['saldo_akhir'];
    }
    $data['bank']       = $this->Model_kaskecil->getBank()->result();
    $data['klaim']      = $this->Model_kaskecil->getKlaim($kode_klaim)->row_array();
    $data['detail']     = $this->Model_kaskecil->detailklaim($kode_klaim)->result();
    $this->load->view('kaskecil/prosesklaim', $data);
  }

  function insert_ledger()
  {
    $this->Model_kaskecil->insert_ledger();
  }

  function batal_klaim()
  {
    $kode_klaim = $this->uri->segment(3);
    $this->Model_kaskecil->batal_klaim($kode_klaim);
  }

  function cekprosesklaim()
  {
    $cabang         = $this->session->userdata('cabang');
    if ($cabang  == "pusat") {
      $cabang   = 'PST';
    } else {
      $cabang = $cabang;
    }
    $cekprosesklaim = $this->db->get_where('klaim', array('status' => '0', 'kode_cabang' => $cabang))->num_rows();
    echo $cekprosesklaim;
  }

  function cekvalidasi()
  {
    $cabang         = $this->session->userdata('cabang');
    if ($cabang  == "pusat") {
      $cabang   = 'PST';
    } else {
      $cabang = $cabang;
    }
    $query = "SELECT status_validasi FROM ledger_bank
              INNER JOIN klaim ON ledger_bank.kode_klaim = klaim.kode_klaim
              WHERE status_validasi='0' AND klaim.kode_cabang='$cabang'
              ";
    $cekvalidasi = $this->db->query($query)->num_rows();
    echo $cekvalidasi;
  }

  function penerimaankaskecil($rowno = 0)
  {
    // Search text
    $dari       = "";
    $sampai     = "";

    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');

      $data   = array(

        'dari'         => $dari,
        'sampai'       => $sampai



      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }

      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }

    // Row per page
    $rowperpage = 250;

    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_kaskecil->getrecordPenerimaankaskecil($dari, $sampai);
    // Get records
    $users_record = $this->Model_kaskecil->getDataPenerimaankaskecil($rowno, $rowperpage, $dari, $sampai);




    // Pagination Configuration
    $config['base_url']         = base_url() . 'pembayaran/index';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows']       = $allcount;
    $config['per_page']         = $rowperpage;

    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    // Initialize
    $this->pagination->initialize($config);

    $data['pagination']        = $this->pagination->create_links();
    $data['result']            = $users_record;
    $data['row']                = $rowno;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['cabang']            = $this->Model_cabang->view_cabang()->result();
    // Load view
    $this->template->load('template/template', 'kaskecil/penerimaankaskecil', $data);
  }

  function terimakaskecil()
  {
    $cabang         = $this->session->userdata('cabang');
    if ($cabang  == "pusat") {
      $cabang   = 'PST';
    } else {
      $cabang = $cabang;
    }
    $no_bukti    = $this->uri->segment(3);
    $getledger   = $this->Model_kaskecil->getledger($no_bukti)->row_array();
    $getkodeakun = $this->Model_kaskecil->getAkun($cabang)->row_array();
    $tgl_ledger  = $getledger['tgl_ledger'];
    $keterangan  = "Penerimaan Kas Kecil";
    $kode_akun   = $getkodeakun['kode_akun'];
    $jumlah      = $getledger['jumlah'];
    $tgl = explode("-", $tgl_ledger);
    $tahun = $tgl[0];
    $bulan = $tgl[1];

    $cektutuplaporan = $this->db->get_where('tutup_laporan', array('tahun' => $tahun, 'bulan' => $bulan, 'status' => 1, 'jenis_laporan' => 'kaskecil'))->num_rows();
    if ($cektutuplaporan > 0) {
      $this->session->set_flashdata(
        'msg',

        '<div class="alert bg-yellow text-white alert-dismissible" role="alert">

                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                   <i class="fa fa-info"></i> Laporan Suda Di Tutu Untuk Bulan Tersebut !

            </div>'
      );

      redirect('kaskecil/penerimaankaskecil');
    } else {
      $data = array(
        'nobukti'         => $no_bukti,
        'tgl_kaskecil'    => $tgl_ledger,
        'keterangan'      => $keterangan,
        'jumlah'          => $jumlah,
        'status_dk'       => 'K',
        'kode_akun'       => $kode_akun,
        'kode_cabang'     => $cabang,
        'order'           => 1
      );
      $cek = $this->db->get_where('kaskecil_detail', array('nobukti' => $no_bukti))->num_rows();
      if (empty($cek)) {
        $simpan = $this->db->insert('kaskecil_detail', $data);
        if ($simpan) {
          $data_klaim = array('status_validasi' => 1);
          $update = $this->db->update('ledger_bank', $data_klaim, array('no_bukti' => $no_bukti));
          $this->session->set_flashdata(
            'msg',

            '<div class="alert bg-green text-white alert-dismissible" role="alert">

                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <i class="fa fa-check"></i> Data Berhasil di Simpan !

              </div>'
          );

          redirect('kaskecil/penerimaankaskecil');
        }
      }
    }
  }

  function batalkan_validasi()
  {
    $no_bukti  = $this->uri->segment(3);
    $this->Model_kaskecil->batalkan_validasi($no_bukti);
  }

  function insert_kaskecil_temp()
  {
    $this->Model_kaskecil->insert_kaskecil_temp();
  }

  function tampilkaskeciltemp()
  {
    $nobukti = $this->input->post('nobukti');
    $data['temp'] = $this->Model_kaskecil->tampilkaskeciltemp($nobukti)->result();
    $this->load->view('kaskecil/kaskecil_detail_temp', $data);
  }

  function hapuskaskeciltemp()
  {
    $id = $this->input->post('id');
    $this->Model_kaskecil->hapuskaskeciltemp($id);
  }

  function cekkaskeciltemp()
  {
    $nobukti = $this->input->post('nobukti');
    $cek = $this->Model_kaskecil->tampilkaskeciltemp($nobukti)->num_rows();
    echo $cek;
  }
}
