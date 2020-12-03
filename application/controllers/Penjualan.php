<?php

class Penjualan extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_barang', 'Model_penjualan', 'Model_pembayaran', 'Model_pelanggan', 'Model_cabang', 'Model_laporanpenjualan', 'Model_setting'));
  }

  function input_penjualan()
  {
    if (isset($_POST['submit'])) {
      $this->Model_penjualan->insert_penjualan();
    } else {
      $data['barang'] = $this->Model_barang->view_barang()->result();
      $this->template->load('template/template', 'penjualan/input_penjualan', $data);
    }
  }


  function cekbarangpenjualan()
  {
    $id_admin = $this->session->userdata('id_user');
    $cek      = $this->db->get_where('detailpenjualan_temp', array('id_admin' => $id_admin))->num_rows();
    echo $cek;
  }

  function cekbaranghk()
  {
    $id_admin       = $this->session->userdata('id_user');
    $kodebaranggb   = $this->input->post('kodebaranggb');
    $cek            = $this->db->get_where('detailpenjualan_temp', array('id_admin' => $id_admin, 'kode_barang' => $kodebaranggb))->num_rows();
    echo $cek;
  }


  function get_barang()
  {
    $kodebarang = $this->input->post('kodebarang');
    $brg         = $this->Model_barang->get_barang($kodebarang)->row_array();
    //echo $kodebarang;
    echo $brg['satuan'] . "|" . $brg['harga_dus'] . "|" . $brg['harga_pack'] . "|" . $brg['harga_pcs'];
  }

  function insert_detailtmp()
  {
    $this->Model_penjualan->insert_detailtmp();
  }

  function insert_detailhutangkirimttr()
  {
    $this->Model_penjualan->insert_detailhutangkirimttr();
  }

  function view_detailtmp()
  {
    $data['detail'] = $this->Model_penjualan->view_detailtmp()->result();
    $this->load->view('penjualan/view_detailpenjualantmp', $data);
  }

  function view_detailgbtmp()
  {
    $kodepelanggan  = $this->uri->segment(3);
    $data['detail'] = $this->Model_penjualan->view_detailgbtmp($kodepelanggan)->result();
    $this->load->view('penjualan/view_detailpenjualangbtmp', $data);
  }

  function view_datahutangkirim()
  {
    $data['detail'] = $this->Model_penjualan->view_datahutangkirim()->result();
    $this->load->view('penjualan/view_detailpenjualangbtmp', $data);
  }

  function hapus_detailbrg()
  {
    $jumlah     = $this->input->post('jumlah');
    $kodebarang = $this->input->post('kodebarang');
    $promo       = $this->input->post('promo');
    $this->Model_penjualan->hapus_detailbrg($kodebarang, $jumlah, $promo);
  }

  function hapus_detailbrggb()
  {
    $kodebarang     = $this->input->post('kodebarang');
    $jenis_mutasi   = $this->input->post('jenis_mutasi');
    $this->Model_penjualan->hapus_detailbrggb($kodebarang, $jenis_mutasi);
  }

  function jsonPelanggan()
  {
    header('Content-Type: application/json');
    echo $this->Model_penjualan->json();
  }


  function hitungstok()
  {
    $kodebarang     = $this->uri->segment(3);
    $data['getbrg'] = $this->Model_barang->get_barang($kodebarang)->row_array();
  }


  function jenistransaksi()
  {
    $data['jt'] = $this->input->post('jt');
    $this->load->view('penjualan/jenistransaksi', $data);
  }

  function hitungjatuhtempo()
  {
    $tgltransaksi     = $this->input->post('tgltransaksi');
    $jatuhtempo       = date('Y-m-d', strtotime("+1 month", strtotime(date($tgltransaksi))));
    echo $jatuhtempo;
  }

  function hapus()
  {
    $nofaktur       = $this->uri->segment(3);
    $kodepelanggan  = $this->uri->segment(4);
    $cekpenjualan = $this->db->get_where('penjualan', array('no_fak_penj' => $nofaktur))->row_array();
    $tanggal = $cekpenjualan['tgltransaksi'];
    $jenis = "penjualan";
    $cek = $this->Model_setting->cektutuplaporan($tanggal, $jenis)->num_rows();
    if ($cek > 0) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal dihapus Karena Periode Laporan Sudah Ditutup !
          </div>'
      );
      redirect('pembayaran/listfaktur/' . $kodepelanggan);
    } else {
      $this->Model_penjualan->hapus($nofaktur);
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
            </div>'
      );
      redirect('pembayaran/listfaktur/' . $kodepelanggan);
    }
  }

  function batal()
  {
    $nofaktur         = $this->uri->segment(3);
    $kodepelanggan    = $this->uri->segment(4);
    $this->Model_penjualan->batal($nofaktur);
    $this->session->set_flashdata(
      'msg',
      '<div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Batalkan !
          </div>'
    );
    redirect('pembayaran/listfaktur/' . $kodepelanggan);
  }



  function detailfaktur()
  {
    $nofaktur         = $this->uri->segment(3);
    $data['lainlain'] = $this->Model_pembayaran->detailpotlainlain($nofaktur)->result();
    $data['faktur']   = $this->Model_penjualan->get_faktur($nofaktur)->row_array();
    $data['barang']   = $this->Model_penjualan->get_detailpenjualan($nofaktur)->result();
    $data['giro']     = $this->Model_pembayaran->get_giro($nofaktur)->result();
    $data['transfer']  = $this->Model_pembayaran->get_transfer($nofaktur)->result();
    $data['bayar']    = $this->Model_pembayaran->get_bayar($nofaktur)->result();
    $data['returpf']  = $this->Model_penjualan->view_detailreturpf($nofaktur)->result();
    $data['returgb']  = $this->Model_penjualan->view_detailreturgb($nofaktur)->result();

    $this->template->load('template/template', 'penjualan/detail_faktur', $data);
  }



  function retur_penjualan()
  {
    if (isset($_POST['simpan'])) {
      $this->Model_penjualan->retur_penjualan();
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
        </div>'
      );
      redirect('penjualan/retur_penjualan');
    } else {
      $this->template->load('template/template', 'penjualan/retur_penjualan2');
    }
  }

  function get_autocomplete()
  {
    if (isset($_GET['term'])) {
      $result = $this->Model_penjualan->search_faktur($_GET['term']);
      if (count($result) > 0) {
        foreach ($result as $row)
          $arr_result[] = $row->no_fak_penj;
        echo json_encode($arr_result);
      }
    }
  }

  function getfaktur()
  {
    $nofaktur = $this->input->post('nofaktur');
    $faktur   = $this->Model_penjualan->get_faktur($nofaktur)->row_array();
    echo $faktur['kode_pelanggan'] . "|" . $faktur['nama_pelanggan'] . "|" . $faktur['id_karyawan'] . "|" . $faktur['nama_karyawan'] . "|" . $faktur['tgltransaksi'] . "|" . $faktur['jenistransaksi'];
  }

  function view_barangfaktur()
  {
    $kodecabang             = $this->input->post('kodecabang');
    $data['jenisretur']     = $this->input->post('jenisretur');
    $data['barang']         = $this->Model_penjualan->view_detailpenjualan2($kodecabang)->result();
    $this->load->view('penjualan/view_barangfaktur2', $data);
  }


  function view_detailreturtmp()
  {
    $kodepelanggan     = $this->uri->segment(3);
    $data['detail']   = $this->Model_penjualan->view_detailreturtmp($kodepelanggan)->result();
    $this->load->view('penjualan/view_detailreturtmp', $data);
  }


  function insert_detailreturtmp()
  {
    $this->Model_penjualan->insert_detailreturtmp2();
  }

  function insert_detailreturgbtmp()
  {
    $this->Model_penjualan->insert_detailreturgbtmp();
  }


  function hapus_detailreturbrg()
  {
    $kodebarang   = $this->input->post('kodebarang');
    $kodepelanggan   = $this->input->post('kodepelanggan');
    $this->Model_penjualan->hapus_detailreturbrg($kodebarang, $kodepelanggan);
  }


  function hapus_detailreturgbbrg()
  {
    $kodebarang       = $this->input->post('kodebarang');
    $kodepelanggan     = $this->input->post('kodepelanggan');
    $jumlah           = $this->input->post('jumlah');
    $this->Model_penjualan->hapus_detailreturgbbrg($kodebarang, $kodepelanggan, $jumlah);
  }


  function view_detailreturgbtmp()
  {
    $kodepelanggan   = $this->uri->segment(3);
    $data['detail'] = $this->Model_penjualan->view_detailreturgbtmp($kodepelanggan)->result();
    $this->load->view('penjualan/view_detailreturgbtmp', $data);
  }


  function view_barangfakturgb()
  {
    $kodecabang             = $this->input->post('kodecabang');
    $data['jenisretur']     = $this->input->post('jenisretur');
    $data['barang']         = $this->Model_penjualan->view_detailpenjualan2($kodecabang)->result();
    $this->load->view('penjualan/view_barangfakturgb2', $data);
  }


  function retur_penjualangb()
  {
    if (isset($_POST['simpan'])) {
      $this->Model_penjualan->retur_penjualan();
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Gagal DIhapus, Periode Laporan Suda Ditutup !
        </div>'
      );
      redirect('penjualan/retur_penjualangb');
    } else {
      $this->template->load('template/template', 'penjualan/retur_penjualangb2');
    }
  }

  function cekbarangretur()
  {
    $kodepelanggan   = $this->input->post('kodepelanggan');
    $cekretur       = $this->Model_penjualan->cekretur($kodepelanggan)->num_rows();
    $cekreturgb      = $this->Model_penjualan->cekreturgb($kodepelanggan)->num_rows();
    echo $cekretur . "|" . $cekreturgb;
  }



  function view_detailretur()
  {
    $kodepelanggan   = $this->uri->segment(3);
    $data['detail'] = $this->Model_penjualan->view_detailretur($kodepelanggan)->result();
    $this->load->view('penjualan/view_detailretur', $data);
  }

  function view_detailretur2()
  {
    $kodepelanggan  = $this->uri->segment(3);
    $kodebarang     = $this->uri->segment(4);
    $data['detail'] = $this->Model_penjualan->view_detailretur2($kodepelanggan, $kodebarang)->result();
    $this->load->view('penjualan/view_detailretur2', $data);
  }

  function view_detailpenjualan()
  {
    $kodepelanggan   = $this->uri->segment(3);
    $data['detail'] = $this->Model_penjualan->view_detailpenjualan($kodepelanggan)->result();
    $this->load->view('penjualan/view_detailpenjualan', $data);
  }


  function ceknofaktur()
  {
    $nofaktur = $this->input->post('nofaktur');
    $cek        = $this->Model_penjualan->ceknofaktur($nofaktur)->num_rows();
    echo $cek;
  }

  function retur($rowno = 0)
  {

    $search_text = "";
    $nofaktur    = "";
    if ($this->input->post('submit') != NULL) {
      $search_text = $this->input->post('search');
      $nofaktur    = $this->input->post('nofaktur');
      $this->session->set_userdata(array("search" => $search_text));
      $this->session->set_userdata(array("nofaktur" => $nofaktur));
    } else {
      if ($this->session->userdata('search') != NULL) {
        $search_text = $this->session->userdata('search');
        $nofaktur    = $this->session->userdata('nofaktur');
      }
    }
    $rowperpage = 10;
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_penjualan->getrecordreturCount($search_text, $nofaktur);
    // Get records
    $users_record = $this->Model_penjualan->getreturData($rowno, $rowperpage, $search_text, $nofaktur);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'penjualan/retur';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['search']               = $search_text;
    $data['nofaktur']             = $nofaktur;
    $this->template->load('template/template', 'penjualan/listretur', $data);
  }

  function hapusretur()
  {

    $no_retur = $this->uri->segment(3);
    $cekretur = $this->db->get_where('retur', array('no_retur_penj' => $no_retur))->row_array();
    $tanggal = $cekretur['tglretur'];
    $jenis = "penjualan";
    $cek = $this->Model_setting->cektutuplaporan($tanggal, $jenis)->num_rows();
    if ($cek > 0) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-red text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Gagal DIhapus, Periode Laporan Suda Ditutup !
        </div>'
      );
      redirect('penjualan/retur');
    } else {
      $this->Model_penjualan->hapusretur($no_retur);
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
        </div>'
      );
      redirect('penjualan/retur');
    }
  }


  function batalretur()
  {
    $no_retur     = $this->uri->segment(3);
    $this->Model_penjualan->batalretur($no_retur);
    $this->session->set_flashdata(
      'msg',
      '<div class="alert bg-green alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
          </div>'
    );
    redirect('penjualan/retur');
  }


  function detailretur()
  {
    $no_retur         = $this->uri->segment(3);
    $nofaktur         = $this->uri->segment(4);
    $data['faktur']   = $this->Model_penjualan->get_faktur($nofaktur)->row_array();
    $data['retur']     = $this->Model_penjualan->get_retur($no_retur)->row_array();
    $data['barang']   = $this->Model_penjualan->get_detailpenjualan($nofaktur)->result();
    $data['returpf']  = $this->Model_penjualan->view_detailretur_r($no_retur)->result();
    $data['returgb']  = $this->Model_penjualan->view_detailreturgb_r($no_retur)->result();
    $this->template->load('template/template', 'penjualan/detail_retur', $data);
  }

  function hitungdiskon()
  {
    error_reporting(0);
    //$nofaktur 		= $this->input->post('nofaktur');
    $id_admin        = $this->session->userdata('id_user');
    $kategori_swan  = 'SWAN';
    $kategori_aida   = 'AIDA';
    $swan           =  $this->Model_penjualan->hitungkatproduk($kategori_swan, $id_admin)->result();
    $aida           =  $this->Model_penjualan->hitungkatproduk($kategori_aida, $id_admin)->result();
    $jmldusaida     = 0;
    foreach ($aida as $a) {
      $jmlaida      = floor($a->jumlah / $a->isipcsdus);
      $jmldusaida   = $jmldusaida + $jmlaida;
    }
    $jmldusswan     = 0;
    foreach ($swan as $s) {
      $jmlswan      = floor($s->jumlah / $s->isipcsdus);
      $jmldusswan   = $jmldusswan + $jmlswan;
    }

    $diskonswan     = $this->Model_penjualan->hitungdiskon($kategori_swan, $jmldusswan)->row_array();
    $diskonaida     = $this->Model_penjualan->hitungdiskon($kategori_aida, $jmldusaida)->row_array();
    echo number_format(($diskonswan['diskon'] * $jmldusswan), '0', '', '.') . "|" . number_format(($diskonaida['diskon'] * $jmldusaida), '0', '', '.');
  }

  function loadfaktur()
  {
    $bulan          = date('m');
    $kodepelanggan = $this->input->post('kodepelanggan');
    $faktur          = $this->db->query("SELECT no_fak_penj FROM penjualan WHERE kode_pelanggan = '$kodepelanggan'");
    echo "<option value=''>-- Pilih Faktur --</option>";
    foreach ($faktur->result() as $f) {
      echo "<option value='$f->no_fak_penj'>$f->no_fak_penj</option>";
    }
  }


  function editfaktur()
  {
    if (isset($_POST['submit'])) {
      $nofaktur = $this->input->post('nofaktur');
      $this->Model_penjualan->editfaktur($nofaktur);
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
      </div>'
      );
      redirect('penjualan/koreksifaktur/');
    } else {
      $nofaktur          = $this->uri->segment(3);
      $faktur            = $this->Model_penjualan->get_faktur($nofaktur)->row_array();
      $data['getfaktur'] = $faktur;
      $data['sales']     = $this->Model_pelanggan->get_salespel($faktur['kode_cabang'])->result();
      $this->template->load('template/template', 'penjualan/editfaktur', $data);
    }
  }


  function cetak_faktur()
  {
    $nofaktur            = $this->uri->segment(3);
    $data['faktur']      = $this->Model_penjualan->get_faktur($nofaktur)->row_array();
    $data['barang']      = $this->Model_penjualan->get_detailpenjualan($nofaktur)->result();
    $this->load->view('penjualan/cetak_kwitansi', $data);
  }

  function update_histori()
  {
    $query = "SELECT * FROM view_aup";
    $h     = $this->db->query($query);
    foreach ($h->result() as $d) {
      $u = "UPDATE historibayar SET jenistransaksi = 'kredit', jenisbayar='titipan' WHERE no_fak_penj = '$d->no_fak_penj'";
      $this->db->query($u);
    }
  }


  function hutangkirim($rowno = 0)
  {
    // Search text
    $no_faktur    = "";
    $tgl_mutasi   = "";
    if ($this->input->post('submit') != NULL) {
      $no_faktur     = $this->input->post('no_faktur');
      $tgl_mutasi    = $this->input->post('tgl_mutasi');
      $data          = array(
        'no_faktur'      => $no_faktur,
        'tgl_mutasi'     => $tgl_mutasi
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_faktur') != NULL) {
        $no_faktur = $this->session->userdata('no_faktur');
      }
      if ($this->session->userdata('tgl_mutasi') != NULL) {
        $tgl_mutasi = $this->session->userdata('tgl_mutasi');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_penjualan->getrecordHutangkirimCount($no_faktur, $tgl_mutasi);
    // Get records
    $users_record = $this->Model_penjualan->getDataHutangkirim($rowno, $rowperpage, $no_faktur, $tgl_mutasi);
    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/hutangkirim';
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
    $data['pagination']         = $this->pagination->create_links();
    $data['result']              = $users_record;
    $data['row']                = $rowno;
    $data['no_faktur']          = $no_faktur;
    $data['tgl_mutasi']         = $tgl_mutasi;
    // Load view
    $this->template->load('template/template', 'penjualan/hutangkirim', $data);
  }


  function inputpelunasanhk()
  {
    if (isset($_POST['submit'])) {
      $this->Model_penjualan->insert_pelunasanhk();
    } else {
      $nomutasi               = $this->input->post('nomutasi');
      $nofaktur               = $this->input->post('nofaktur');
      $data['jenis_mutasi']   = $this->input->post('jenis_mutasi');
      $data['mutasi']         = $this->Model_penjualan->getMutasiCab($nomutasi)->row_array();
      $data['detail']         = $this->Model_penjualan->detail_mutasiCab($nofaktur)->result();
      //echo $data['mutasi']['no_fak_penj'];
      $this->load->view('penjualan/inputpelunasanhk', $data);
    }
  }

  function view_detailhutangkirim()
  {
    $nofaktur           = $this->uri->segment(3);
    $data['detail']     = $this->Model_penjualan->detail_mutasiCab($nofaktur)->result();
    $this->load->view('penjualan/view_detailhutangkirim', $data);
  }


  function historipelunasanhk()
  {
    $nofaktur               = $this->uri->segment(3);
    $data['detail_pl']      = $this->Model_penjualan->detail_pl($nofaktur)->result();
    $this->load->view('penjualan/view_detailhistoripelunasanhk', $data);
  }


  function view_detailhistorihk()
  {
    $nomutasi                      = $this->uri->segment(3);
    $data['detail_historihk']      = $this->Model_penjualan->detail_historihk($nomutasi)->result();
    $this->load->view('penjualan/view_detailhistorihk', $data);
  }


  function hapus_plhk()
  {
    $no_hutangkirim = $this->input->post('nomutasi');
    if (empty($no_hutangkirim)) {
      $no_hutangkirim = $this->uri->segment(3);
    } else {
      $no_hutangkirim = $no_hutangkirim;
    }
    $this->Model_penjualan->hapus_plhk($no_hutangkirim);
  }



  function ttr($rowno = 0)
  {
    // Search text
    $namapel     = "";
    $tgl_mutasi  = "";
    if ($this->input->post('submit') != NULL) {
      $namapel      = $this->input->post('nama_pelanggan');
      $tgl_mutasi   = $this->input->post('tgl_mutasi');
      $data         = array(
        'namapel'       => $namapel,
        'tgl_mutasi'    => $tgl_mutasi
      );

      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('namapel') != NULL) {
        $namapel = $this->session->userdata('namapel');
      }
      if ($this->session->userdata('tgl_mutasi') != NULL) {
        $tgl_mutasi = $this->session->userdata('tgl_mutasi');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_penjualan->getrecordTTRCount($namapel, $tgl_mutasi);
    // Get records
    $users_record = $this->Model_penjualan->getDataTTR($rowno, $rowperpage, $namapel, $tgl_mutasi);
    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/ttr';
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
    $data['pagination']         = $this->pagination->create_links();
    $data['result']            = $users_record;
    $data['row']               = $rowno;
    $data['namapel']           = $namapel;
    $data['tgl_mutasi']        = $tgl_mutasi;
    // Load view
    $this->template->load('template/template', 'penjualan/ttr', $data);
  }



  function view_detailttrtemp()
  {
    $data['detail'] = $this->Model_penjualan->view_detailttrtemp()->result();
    $this->load->view('penjualan/view_detailttrtemp', $data);
  }


  function cekdetailttrtemp()
  {
    $pelanggan     = $this->input->post('kodepelanggan');
    $id_admin   = $this->session->userdata('id_user');
    $cek        = $this->db->get_where('detailttr_temp', array('id_admin' => $id_admin))->num_rows();
    if ($cek != 0) {
      echo "1";
    }
  }

  function insert_detailttrtemp()
  {
    $this->Model_penjualan->insert_detailttrtemp();
  }

  function hapus_detailbrgttr()
  {
    $kode_produk = $this->input->post('kode_produk');
    $this->Model_penjualan->hapus_detailbrgttr($kode_produk);
  }


  function input_ttr()
  {
    $this->Model_penjualan->insert_ttr();
  }

  function hapusttr()
  {
    $no_ttr = $this->uri->segment(3);
    $this->Model_penjualan->hapusttr($no_ttr);
  }



  function cek_ttr()
  {
    $pelanggan          = $this->input->post('pelanggan');
    //echo $pelanggan;
    $data['cek_ttr']    = $this->Model_penjualan->cek_ttr($pelanggan)->result();
    $this->load->view('penjualan/cek_ttr', $data);
  }

  function cek_ttrpelanggan()
  {
    $pelanggan          = $this->input->post('pelanggan');
    $ttrpelanggan       = $this->Model_penjualan->cek_ttr($pelanggan)->num_rows();
    echo $ttrpelanggan;
  }


  function insert_detailttrtemp2()
  {
    $id_ttr = $this->input->post('id_ttr');
    $this->Model_penjualan->insert_detailttrtemp2($id_ttr);
  }

  function cetak_suratjalan()
  {
    $nofaktur            = $this->uri->segment(3);
    $data['faktur']      = $this->Model_penjualan->get_faktur($nofaktur)->row_array();
    $data['barang']      = $this->Model_penjualan->get_detailpenjualan($nofaktur)->result();
    $this->load->view('penjualan/cetak_suratjalan', $data);
  }

  function listgiro($rowno = 0)
  {
    // Search text
    $namapel    = "";
    $nofaktur   = "";
    $nogiro     = "";
    $dari       = "";
    $sampai     = "";
    $status     = "";
    if ($this->input->post('submit') != NULL) {
      $namapel  = $this->input->post('namapel');
      $nofaktur = $this->input->post('nofaktur');
      $nogiro   = $this->input->post('nogiro');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $data     = array(

        'namapel'    => $namapel,
        'nofaktur'   => $nofaktur,
        'nogiro'     => $nogiro,
        'dari'       => $dari,
        'sampai'     => $sampai

      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('namapel') != NULL) {
        $namapel = $this->session->userdata('namapel');
      }
      if ($this->session->userdata('nofaktur') != NULL) {
        $nofaktur = $this->session->userdata('nofaktur');
      }
      if ($this->session->userdata('nogiro') != NULL) {
        $nogiro = $this->session->userdata('nogiro');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    if (empty($nofaktur) && empty($namapel) && empty($dari) && empty($sampai) && empty($nogiro)) {
      $allcount = 0;
      $users_record = 0;
    } else {
      // All records count
      $allcount     = $this->Model_penjualan->getrecordGiro($namapel, $nofaktur, $nogiro, $status, $dari, $sampai);
      // Get records
      $users_record = $this->Model_penjualan->getdataGiro($rowno, $rowperpage, $namapel, $nofaktur, $nogiro, $status, $dari, $sampai);
    }
    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/listgiro';
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

    $data['pagination']         = $this->pagination->create_links();
    $data['result']              = $users_record;
    $data['row']                = $rowno;
    $data['namapel']            = $namapel;
    $data['dari']                = $dari;
    $data['sampai']             = $sampai;
    $data['nofaktur']           = $nofaktur;
    $data['nogiro']             = $nogiro;
    $this->template->load('template/template', 'penjualan/list_giro', $data);
  }



  function setoranpenjualan()
  {
    // Search text
    $sess_cab   = $this->session->userdata('cabang');
    if ($sess_cab == 'pusat') {
      $cbg   = "";
    } else {
      $cbg   = $sess_cab;
    }

    $salesman           = "";
    $dari               = "";
    $sampai             = "";
    if ($this->input->post('submit') != NULL) {
      $cbg      = $this->input->post('cabang');
      $salesman = $this->input->post('salesman');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $data     = array(
        'cbg'        => $cbg,
        'salesman'   => $salesman,
        'dari'       => $dari,
        'sampai'     => $sampai
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }
    // Get records
    $users_record = $this->Model_penjualan->getdatasetoranPenjualan($cbg, $salesman, $dari, $sampai)->result_array();
    $jmldata = $this->Model_penjualan->getdatasetoranPenjualan($cbg, $salesman, $dari, $sampai)->num_rows();
    $data['result']             = $users_record;
    $data['cbg']                = $cbg;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['salesman']           = $salesman;
    $data['cabang']             = $this->Model_cabang->view_cabang()->result();
    $data['sess_cab']           = $this->session->userdata('cabang');
    $data['jmldata']            = $jmldata;
    $this->template->load('template/template', 'penjualan/setoranpenjualan', $data);
  }

  function inputsetoranpenjualan()
  {
    if (isset($_POST['simpan'])) {
      $this->Model_penjualan->inputsetoranpenjualan();
    } else {
      $data['cabang']      = $this->Model_cabang->view_cabang()->result();
      $data['sess_cab']    = $this->session->userdata('cabang');
      $this->load->view('penjualan/inputsetoranpenjualan', $data);
    }
  }

  function get_setoran()
  {
    $tanggallhp         = $this->input->post('tanggallhp');
    $salesman           = $this->input->post('salesman');
    $setorantunai       = $this->Model_penjualan->get_setoran($tanggallhp, $salesman, 'tunai')->row_array();
    $setorantagihan     = $this->Model_penjualan->get_setoran($tanggallhp, $salesman, 'kredit')->row_array();
    $girotocashtunai    = $this->Model_penjualan->get_girotocash($tanggallhp, $salesman, 'tunai')->row_array();
    $girotocashkredit   = $this->Model_penjualan->get_girotocash($tanggallhp, $salesman, 'kredit')->row_array();
    $girotocash         = $girotocashtunai['totalsetoran'] + $girotocashkredit['totalsetoran'];
    $setorangiro        = $this->Model_penjualan->get_setorangiro($tanggallhp, $salesman)->row_array();
    $setorantransfer    = $this->Model_penjualan->get_setorantransfer($tanggallhp, $salesman)->row_array();
    $totalsetoran       = ($setorangiro['totalsetorangiro'] + 0) + ($setorantransfer['totalsetorantransfer'] + 0);
    $totalsetorantunai  = $setorantunai['totalsetoran'] + 0;
    //echo $setorantunai['totalsetoran']."|".$setorantagihan['totalsetoran'];
    $setoranalltagihan  = $setorantagihan['totalsetoran'] + $setorangiro['totalsetorangiro'] + $setorantransfer['totalsetorantransfer'];
    echo $totalsetorantunai . "|" . $setoranalltagihan . "|" . ($setorangiro['totalsetorangiro'] + 0) . "|" . $girotocash . "|" . ($setorantransfer['totalsetorantransfer'] + 0) . "|" . ($totalsetoran + 0);
  }


  function terbilang()
  {
    error_reporting(0);
    $angka = $this->input->post('angka');
    echo "<b>" . ucwords(number_format($angka, '0', '', '.')) . "</b>";
  }

  function detailtunai()
  {
    $this->load->view('penjualan/detailtunai');
  }

  function ceksetoran()
  {
    $tgllhp     = $this->input->post('tgllhp');
    $salesman   = $this->input->post('salesman');
    $ceksetoran = $this->db->get_where('setoran_penjualan', array('tgl_lhp' => $tgllhp, 'id_karyawan' => $salesman))->num_rows();
    echo $ceksetoran;
  }

  function synclhp()
  {
    $kode_setoran = $this->uri->segment(3);
    $gettanggal = $this->db->get_where('setoran_penjualan', array('kode_setoran' => $kode_setoran))->row_array();
    $tanggal = $gettanggal['tgl_lhp'];
    $tgl   = explode("-", $tanggal);
    $bulan = $tgl[1];
    $tahun = $tgl[0];
    if ($bulan == 12) {
      $bulan = 1;
      $tahun = $tahun + 1;
    } else {
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
    $cabang = $gettanggal['kode_cabang'];
    $ceksa = $this->db->get_where('saldoawal_kasbesar', array('bulan' => $bulan, 'tahun' => $tahun, 'kode_cabang' => $cabang))->num_rows();
    if (empty($ceksa)) {
      $setoran            = $this->Model_penjualan->get_setoranpenjualan($kode_setoran)->row_array();
      $salesman           = $setoran['id_karyawan'];
      $tanggallhp         = $setoran['tgl_lhp'];
      $setorantunai       = $this->Model_penjualan->get_setoran($tanggallhp, $salesman, 'tunai')->row_array();
      $setorantagihan     = $this->Model_penjualan->get_setoran($tanggallhp, $salesman, 'kredit')->row_array();
      $girotocashtunai    = $this->Model_penjualan->get_girotocash($tanggallhp, $salesman, 'tunai')->row_array();
      $girotocashkredit   = $this->Model_penjualan->get_girotocash($tanggallhp, $salesman, 'kredit')->row_array();
      $girotocash         = $girotocashtunai['totalsetoran'] + $girotocashkredit['totalsetoran'];
      $setorangiro        = $this->Model_penjualan->get_setorangiro($tanggallhp, $salesman)->row_array();
      $setorantransfer    = $this->Model_penjualan->get_setorantransfer($tanggallhp, $salesman)->row_array();
      //echo $setorantunai['totalsetoran']."|".$setorantagihan['totalsetoran'];
      $setoranalltagihan  = $setorantagihan['totalsetoran'] + $setorangiro['totalsetorangiro'] + $setorantransfer['totalsetorantransfer'];
      $data = array(

        'lhp_tunai'     => $setorantunai['totalsetoran'],
        'lhp_tagihan'   => $setoranalltagihan,
        'girotocash'    => $girotocash,
        'setoran_bg'    => $setorangiro['totalsetorangiro'],
        'setoran_transfer' => $setorantransfer['totalsetorantransfer']
      );
      $this->db->where('kode_setoran', $kode_setoran);
      $update = $this->db->update('setoran_penjualan', $data);
      if ($update) {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-green text-white alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Diupdate !
          </div>'
        );
        redirect('penjualan/setoranpenjualan');
      } else {
        $this->session->set_flashdata(
          'msg',
          '<div class="alert bg-red text-white alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Gagal Update !
          </div>'
        );
        redirect('penjualan/setoranpenjualan');
      }
    } else {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-warning text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Periode Ini Sudah Ditutup !
        </div>'
      );
      redirect('penjualan/setoranpenjualan');
    }
  }

  function editsetoranpenjualan()
  {
    if (isset($_POST['simpan'])) {
      $this->Model_penjualan->updatesetoranpenjualan();
    } else {
      $kodesetoran     = $this->uri->segment(3);
      $data['cabang']  = $this->Model_cabang->view_cabang()->result();
      $data['setoran'] = $this->Model_penjualan->get_setoranpenjualan($kodesetoran)->row_array();
      $this->load->view('penjualan/editsetoranpenjualan', $data);
    }
  }

  function hapus_setoran()
  {
    $kode_setoran = $this->uri->segment(3);
    $this->Model_penjualan->hapus_setoran($kode_setoran);
  }

  function logamtokertas()
  {
    // Search text
    $sess_cab  = $this->session->userdata('cabang');
    if ($sess_cab == 'pusat') {
      $cbg    = "";
    } else {
      $cbg    = $sess_cab;
    }
    $dari       = "";
    $sampai     = "";
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
    $users_record = $this->Model_penjualan->getdatalogamtokertas($cbg, $dari, $sampai)->result_array();

    $data['result']             = $users_record;
    $data['cbg']                = $cbg;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['cabang']             = $this->Model_cabang->view_cabang()->result();
    $data['sess_cab']           = $this->session->userdata('cabang');
    $this->template->load('template/template', 'penjualan/logamtokertas', $data);
  }

  function inputlogamtokertas()
  {
    if (isset($_POST['simpan'])) {
      $this->Model_penjualan->inputlogamtokertas();
    } else {
      $data['sess_cab']   = $this->session->userdata('cabang');
      $data['cabang']     = $this->Model_cabang->view_cabang()->result();
      $data['cbg']        = "";
      $this->load->view('penjualan/inputlogamtokertas', $data);
    }
  }

  function hapus_logamtokertas()
  {
    $cabang             = $this->uri->segment(4);
    $kode_logamtokertas = $this->uri->segment(3);
    $this->Model_penjualan->hapus_logamtokertas($kode_logamtokertas, $cabang);
  }

  function editlogamtokertas()
  {
    if (isset($_POST['submit'])) {
      $this->Model_penjualan->updatelogamtokertas();
    } else {
      $kodelogamtokertas       = $this->uri->segment(3);
      $data['sess_cab']        = $this->session->userdata('cabang');
      $data['cabang']          = $this->Model_cabang->view_cabang()->result();
      $data['lg']              = $this->Model_penjualan->get_logamtokertas($kodelogamtokertas)->row_array();
      $this->load->view('penjualan/editlogamtokertas', $data);
    }
  }

  function kuranglebihsetor()
  {
    $sess_cab  = $this->session->userdata('cabang');
    if ($sess_cab == 'pusat') {
      $cbg    = "";
    } else {
      $cbg    = $sess_cab;
    }
    $salesman   = "";
    $dari       = "";
    $sampai     = "";
    if ($this->input->post('submit') != NULL) {
      $cbg      = $this->input->post('cabang');
      $salesman = $this->input->post('salesman');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $data     = array(
        'cbg'        => $cbg,
        'salesman'   => $salesman,
        'dari'       => $dari,
        'sampai'     => $sampai
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }


    $users_record = $this->Model_penjualan->getdatakuranglebihsetor($cbg, $salesman, $dari, $sampai);
    $data['result']             = $users_record;
    $data['cbg']                = $cbg;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['salesman']           = $salesman;
    $data['rekap']              = $this->Model_penjualan->rekapkuranglebihsetor()->result();
    $data['sess_cab']           = $this->session->userdata('cabang');
    $data['cabang']             = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/kuranglebihsetor', $data);
  }

  function inputkuranglebihsetor()
  {
    if (isset($_POST['submit'])) {
      $this->Model_penjualan->inputkuranglebihsetor();
    } else {
      $data['sess_cab']   = $this->session->userdata('cabang');
      $data['cbg']        = "";
      $data['cabang']     = $this->Model_cabang->view_cabang()->result();
      $this->load->view('penjualan/inputkuranglebihsetor', $data);
    }
  }

  function hapus_kuranglebihsetor()
  {
    $kode_kl = $this->uri->segment(3);
    $this->Model_penjualan->hapus_kuranglebihsetor($kode_kl);
  }

  function editkuranglebihsetor()
  {
    if (isset($_POST['submit'])) {
      $this->Model_penjualan->updatekuranglebihsetor();
    } else {
      $kodekl             = $this->uri->segment(3);
      $data['kl']         = $this->Model_penjualan->get_kuranglebihsetor($kodekl)->row_array();
      $data['sess_cab']   = $this->session->userdata('cabang');
      $data['cabang']     = $this->Model_cabang->view_cabang()->result();
      $this->load->view('penjualan/editkuranglebihsetor', $data);
    }
  }

  function setoranpusat()
  {
    // Search text
    $sess_cab  = $this->session->userdata('cabang');
    if ($sess_cab == 'pusat') {
      $cbg    = "";
    } else {
      $cbg    = $sess_cab;
    }
    $bank       = "";
    $dari       = "";
    $sampai     = "";


    if ($this->input->post('submit') != NULL) {
      $cbg      = $this->input->post('cabang');
      $bank     = $this->input->post('bank');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $data     = array(
        'cbg'        => $cbg,
        'bank'       => $bank,
        'dari'       => $dari,
        'sampai'     => $sampai

      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('bank') != NULL) {
        $bank = $this->session->userdata('bank');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }


    // Get records
    $users_record = $this->Model_penjualan->getdatasetoranpusat($cbg, $bank, $dari, $sampai)->result_array();
    $jmldata = $this->Model_penjualan->getdatasetoranpusat($cbg, $bank, $dari, $sampai)->num_rows();
    $data['result']             = $users_record;
    $data['cbg']                = $cbg;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['bank']               = $bank;
    $data['jmldata']            = $jmldata;
    $data['cabang']             = $this->Model_cabang->view_cabang()->result();
    $data['sess_cab']           = $this->session->userdata('cabang');
    $this->template->load('template/template', 'penjualan/setoranpusat', $data);
  }

  function inputsetoranpusat()
  {
    if (isset($_POST['simpan'])) {
      $this->Model_penjualan->inputsetoranpusat();
    } else {
      $data['sess_cab']   = $this->session->userdata('cabang');
      $data['cabang']     = $this->Model_cabang->view_cabang()->result();
      $this->load->view('penjualan/inputsetoranpusat', $data);
    }
  }

  function editsetoranpusat()
  {
    if (isset($_POST['simpan'])) {
      $this->Model_penjualan->updatesetoranpusat();
    } else {
      $kodesetoranpusat     = $this->uri->segment(3);
      $data['status'] = $this->uri->segment(4);
      $data['sess_cab']     = $this->session->userdata('cabang');
      $data['cabang']       = $this->Model_cabang->view_cabang()->result();
      $data['setoranpusat'] = $this->Model_penjualan->get_setoranpusat($kodesetoranpusat)->row_array();
      $this->load->view('penjualan/editsetoranpusat', $data);
    }
  }

  function hapus_setoranpusat()
  {
    $kode_setoranpusat = $this->uri->segment(3);
    $this->Model_penjualan->hapus_setoranpusat($kode_setoranpusat);
  }

  function get_saldoawallogam()
  {
    $dari             = $this->input->post('tanggal');
    $cabang           = $this->input->post('cabang');
    $saldo             = $this->Model_laporanpenjualan->getSaldoAwalKasBesar($cabang, $dari)->row_array();
    $setoranpenjualan  = $this->Model_laporanpenjualan->getSetoranPenjualan($cabang, $dari)->row_array();
    $setoranpusat      = $this->Model_laporanpenjualan->getSetoranPusatLogam($cabang, $dari)->row_array();
    $ksetorpenjualan   = $this->Model_laporanpenjualan->getKLSetorpenjualan($cabang, $dari, $pembayaran = 1)->row_array();
    $lsetoranpenjualan = $this->Model_laporanpenjualan->getKLSetorpenjualan($cabang, $dari, $pembayaran = 2)->row_array();
    $gantilogam       = $this->Model_laporanpenjualan->getGantiLogam($cabang, $dari)->row_array();
    $saldologam        = $saldo['uang_logam'];
    $setoranpenjlogam = $setoranpenjualan['uanglogam'];
    $klogam            = $ksetorpenjualan['uanglogam'];
    $llogam            = $lsetoranpenjualan['uanglogam'];
    $gantikertas       = $gantilogam['gantikertas'];
    $setoranpuslogam   = $setoranpusat['uanglogam'];
    $saldoawal        = $saldologam + $setoranpenjlogam + $klogam - $llogam - $gantikertas - $setoranpuslogam;
    echo $saldoawal . "|" . number_format($saldoawal, '0', '', '.');
  }

  function ceksetoranpusat()
  {
    // Search text
    $sess_cab  = $this->session->userdata('cabang');
    if ($sess_cab == 'pusat') {
      $cbg    = "";
    } else {
      $cbg    = $sess_cab;
    }
    $bank       = "";
    $dari       = "";
    $sampai     = "";


    if ($this->input->post('submit') != NULL) {
      $cbg      = $this->input->post('cabang');
      $bank     = $this->input->post('bank');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $data     = array(
        'cbg'        => $cbg,
        'bank'       => $bank,
        'dari'       => $dari,
        'sampai'     => $sampai

      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('bank') != NULL) {
        $bank = $this->session->userdata('bank');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }


    // Get records
    $users_record = $this->Model_penjualan->getdatasetoranpusat($cbg, $bank, $dari, $sampai)->result_array();
    $jmldata = $this->Model_penjualan->getdatasetoranpusat($cbg, $bank, $dari, $sampai)->num_rows();
    $data['result']             = $users_record;
    $data['cbg']                = $cbg;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['bank']               = $bank;
    $data['jmldata']            = $jmldata;
    $data['cabang']             = $this->Model_cabang->view_cabang()->result();
    $data['sess_cab']           = $this->session->userdata('cabang');
    $this->template->load('template/template', 'penjualan/ceksetoranpusat', $data);
  }


  function terimasetoran()
  {
    $kode_setoranpusat = $this->input->post('kode_setoranpusat');
    $this->Model_penjualan->terimasetoran($kode_setoranpusat);
  }

  function batalterimasetoran()
  {
    $kode_setoranpusat = $this->uri->segment(3);
    $this->Model_penjualan->batalterimasetoran($kode_setoranpusat);
  }

  function cek_setoranpenjualan()
  {
    $salesman   = $this->input->post('salesman');
    $tgl        = $this->input->post('tgl');
    $cek         = $this->db->get_where('setoran_penjualan', array('tgl_lhp' => $tgl, 'id_karyawan' => $salesman))->num_rows();
    echo $cek;
  }

  function insert_detailpelunasanhktemp()
  {
    $this->Model_penjualan->insert_detailpelunasanhktemp();
  }

  function view_detailpelunasanhktemp()
  {
    $data['detail'] = $this->Model_penjualan->view_detailpelunasanhktemp()->result();
    $this->load->view('penjualan/view_detailpelunasanhktemp', $data);
  }

  function hapus_detailpelunasanhktemp()
  {
    $nofaktur    = $this->input->post('nofaktur');
    $kode_produk = $this->input->post('kode_produk');
    $this->Model_penjualan->hapus_detailpelunasanhktemp($kode_produk, $nofaktur);
  }

  function cekdetailpelunasanhk()
  {
    $nofaktur   = $this->input->post('nofaktur');
    $id_admin  = $this->session->userdata('id_user');
    $cek     = $this->db->get_where('detailplhutangkirim_temp', array('no_fak_penj' => $nofaktur, 'id_admin' => $id_admin))->num_rows();
    if ($cek != 0) {
      echo "1";
    }
  }

  function cek_jml_ttr()
  {
    $id_admin       = $this->session->userdata('id_user');
    $kodepelanggan   = $this->input->post('kodepelanggan');
    $query            = "SELECT
												detailhutangkirimttr_temp.kode_barang,
												jumlah as jmlttr,
												jmlhutangkirim,
												jmlpenjualan
											FROM
												detailhutangkirimttr_temp
												INNER JOIN mutasi_gudang_cabang ON detailhutangkirimttr_temp.no_ttr = mutasi_gudang_cabang.no_mutasi_gudang_cabang
												LEFT JOIN ( SELECT kode_barang, jumlah AS jmlpenjualan FROM detailpenjualan_temp WHERE id_admin = '1' ) dp ON ( detailhutangkirimttr_temp.kode_barang = dp.kode_barang )
												LEFT JOIN ( SELECT kode_barang, jumlah AS jmlhutangkirim FROM detailhutangkirimttr_temp WHERE id_admin = '1' AND jenis_mutasi ='HUTANG KIRIM' ) hk ON ( detailhutangkirimttr_temp.kode_barang = hk.kode_barang )
											WHERE
												kode_pelanggan = '$kodepelanggan'
												AND (IFNULL(jumlah,0)+IFNULL(jmlhutangkirim,0)) > jmlpenjualan
												AND detailhutangkirimttr_temp.jenis_mutasi ='TTR'";
    $cek = $this->db->query($query)->num_rows();
    echo $cek;
  }

  function koreksipenjualan($rowno = 0)
  {
    $nofaktur     = "";
    $cb           = "";
    $salesman     = "";
    $dari         = "";
    $sampai       = "";
    if ($this->input->post('submit') != NULL) {
      $nofaktur   = $this->input->post('nofaktur');
      $cb         = $this->input->post('cabang');
      $salesman   = $this->input->post('salesman');
      $dari       = $this->input->post('dari');
      $sampai     = $this->input->post('sampai');
      $data       = array(

        'nofaktur'     => $nofaktur,
        'cb'           => $cb,
        'salesman'    => $salesman,
        'dari'         => $dari,
        'sampai'       => $sampai

      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('nofaktur') != NULL) {
        $nofaktur = $this->session->userdata('nofaktur');
      }
      if ($this->session->userdata('cb') != NULL) {
        $cb = $this->session->userdata('cb');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    //All records count
    $allcount     = $this->Model_penjualan->getrecordPenjualanCount($nofaktur, $cb, $salesman, $dari, $sampai);
    //Get records
    $users_record = $this->Model_penjualan->getDataPenjualan($rowno, $rowperpage, $nofaktur, $cb, $salesman, $dari, $sampai);
    //Pagination Configuration
    $config['base_url']         = base_url() . 'pembayaran/listbayar';
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
    $data['pagination']         = $this->pagination->create_links();
    $data['result']             = $users_record;
    $data['row']                 = $rowno;
    $data['dari']                = $dari;
    $data['sampai']              = $sampai;
    $data['cb']                  = $cb;
    $data['salesman']           = $salesman;
    $data['nofaktur']            = $nofaktur;
    $data['cabang']             = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/koreksi_penjualan', $data);
  }

  function inputkoreksipenjualan()
  {
    if (isset($_POST['submit'])) {
      $this->Model_penjualan->inputkoreksipenjualan();
    } else {
      $nofaktur         = $this->uri->segment(3);
      $data['faktur']   = $this->Model_penjualan->get_faktur($nofaktur)->row_array();
      $data['barang']   = $this->Model_penjualan->get_detailpenjualan($nofaktur)->result();
      $data['returpf']  = $this->Model_penjualan->view_detailreturpf($nofaktur)->result();
      $data['returgb']  = $this->Model_penjualan->view_detailreturgb($nofaktur)->result();
      $this->load->view('penjualan/inputkoreksipenjualan', $data);
    }
  }

  function cekplhk()
  {
    $cek       = $this->Model_penjualan->cekplhk()->row_array();
    $cekjml   = $this->Model_penjualan->cekjmlhk()->row_array();
    echo $cek['jumlah'] . "|" . $cekjml['jumlah'];
  }

  function cekttrjml()
  {
    $kodepelanggan = $this->input->post('kodepelanggan');
    $admin         = $this->session->userdata('id_user');
    $query = "SELECT detailhutangkirimttr_temp.no_ttr,kode_pelanggan,detailhutangkirimttr_temp.kode_barang,
						  jumlah,IFNULL( jmlpenjualan, 0 ) AS jmlpenjualan
							FROM
							detailhutangkirimttr_temp
							INNER JOIN
							mutasi_gudang_cabang ON detailhutangkirimttr_temp.no_ttr =
							mutasi_gudang_cabang.no_mutasi_gudang_cabang
							LEFT JOIN ( SELECT kode_barang, jumlah AS jmlpenjualan
												 FROM detailpenjualan_temp WHERE id_admin = '$admin' ) dp
												 ON ( detailhutangkirimttr_temp.kode_barang = dp.kode_barang )
							WHERE
							detailhutangkirimttr_temp.jenis_mutasi = 'TTR'
							AND kode_pelanggan = '$kodepelanggan' AND IFNULL( jmlpenjualan, 0 ) < jumlah";
    echo $this->db->query($query)->num_rows();
  }

  function saldoawalkb()
  {
    // Search text
    $tanggal  = "";
    $cab      = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $bulan            = "";
    $tahun            = "";
    if ($this->input->post('submit') != NULL) {
      $tanggal   = $this->input->post('tanggal');
      $cabang    = $this->input->post('cabang');
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $data   = array(
        'tanggal'  => $tanggal,
        'cbg'     => $cabang,
        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }

    // Get records
    $users_record = $this->Model_penjualan->getDataSaldoawal($tanggal, $cabang, $bulan, $tahun);

    $data['result']               = $users_record;

    $data['tanggal']              = $tanggal;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['tahun']                = date("Y");
    $data['bulan']                = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']                  = $bulan;
    $data['thn']                  = $tahun;
    $this->template->load('template/template', 'penjualan/saldoawalkb', $data);
  }


  function inputsaldoawalkb()
  {
    $data['cabang']    = $this->Model_cabang->view_cabang()->result();
    $data['cb']        = $this->session->userdata('cabang');
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->load->view('penjualan/inputsaldoawalkb', $data);
  }

  function insertsaldoawalkb()
  {
    $this->Model_penjualan->insertsaldoawalkb();
  }

  function getdetailsaldo()
  {
    $bulan    = $this->input->post('bulan');
    $tahun    = $this->input->post('tahun');
    $cabang   = $this->input->post('cabang');
    if ($bulan == 1) {
      $bln = 12;
      $thn = $tahun - 1;
    } else {
      $bln = $bulan - 1;
      $thn = $tahun;
    }
    $dari             = $thn . "-" . $bln . "-" . "01";

    $ceksaldo = $this->Model_penjualan->ceksaldo($bulan, $tahun, $cabang)->num_rows();
    $cekall   = $this->Model_penjualan->ceksaldoall($cabang)->num_rows();
    $ceknow   = $this->Model_penjualan->ceksaldoSkrg($bulan, $tahun, $cabang)->num_rows();
    $ceknextbulan = $this->Model_laporanpenjualan->cekNextBulan($cabang, $bln, $thn)->row_array();
    $tglnextbulan = $ceknextbulan['tgl_diterimapusat'];
    if (empty($tglnextbulan)) {
      $data['sampai'] = date("Y-m-t", strtotime($dari));
    } else {
      $data['sampai'] = $ceknextbulan['tgl_diterimapusat'];
    }
    if (empty($ceksaldo) && !empty($cekall) || !empty($ceknow)) {
      echo "1";
    } else {
      $saldo             = $this->Model_penjualan->getdetailsaldo($bulan, $tahun, $cabang)->row_array();
      $setoranpenjualan  = $this->Model_penjualan->getsetoranpenjualan($bulan, $tahun, $cabang)->row_array();
      $setoranpusat      = $this->Model_penjualan->getsetoranpusat($dari, $data['sampai'], $cabang, $bulan, $tahun)->row_array();
      $ksetorpenjualan   = $this->Model_penjualan->getKLSetorpenjualan($bulan, $tahun, $cabang, $pembayaran = 1)->row_array();
      $lsetoranpenjualan = $this->Model_penjualan->getKLSetorpenjualan($bulan, $tahun, $cabang, $pembayaran = 2)->row_array();
      $gantilogam       = $this->Model_penjualan->getGantiLogam($bulan, $tahun, $cabang)->row_array();

      $saldokertas     = $saldo['uang_kertas'];
      $saldologam      = $saldo['uang_logam'];
      $saldogiro        = $saldo['giro'];
      $saldotransfer  = $saldo['transfer'];

      $setoranpenjkertas     = $setoranpenjualan['uangkertas'];
      $setoranpenjlogam      = $setoranpenjualan['uanglogam'];
      $setoranpenjgiro        = $setoranpenjualan['giro'];
      $setoranpenjtransfer  = $setoranpenjualan['transfer'];
      $girotocash            = $setoranpenjualan['girotocash'];

      $kkertas = $ksetorpenjualan['uangkertas'];
      $klogam  = $ksetorpenjualan['uanglogam'];

      $lkertas = $lsetoranpenjualan['uangkertas'];
      $llogam  = $lsetoranpenjualan['uanglogam'];

      $gantikertas           = $gantilogam['gantikertas'];
      $setoranpuskertas     = $setoranpusat['uangkertas'];
      $setoranpuslogam       = $setoranpusat['uanglogam'];
      $setoranpusgiro       = $setoranpusat['giro'];
      $setoranpustransfer   = $setoranpusat['transfer'];

      $kertas   = $saldokertas + $setoranpenjkertas + $kkertas - $lkertas + $gantikertas + $girotocash - $setoranpuskertas;
      $logam    = $saldologam + $setoranpenjlogam + $klogam - $llogam - $gantikertas - $setoranpuslogam;
      $giro     = $saldogiro + $setoranpenjgiro - $setoranpusgiro - $girotocash;
      $transfer = $saldotransfer + $setoranpenjtransfer - $setoranpustransfer;
      echo number_format($kertas, '0', '', '.') . "|" . number_format($logam, '0', '', '.') . "|" . number_format($giro, '0', '', '.') . "|" . number_format($transfer, '0', '', '.');
    }
  }

  function hapussaldoawal()
  {
    $id = $this->uri->segment(3);
    $this->Model_penjualan->hapussaldoawalkb($id);
  }

  function cekpiutangpelanggan()
  {
    $pelanggan = $this->input->post('pelanggan');
    $cekpiutangpel = $this->Model_penjualan->cekpiutangpelanggan($pelanggan)->row_array();
    $piutang = $cekpiutangpel['totalpiutang'] - $cekpiutangpel['jmlbayar'];
    echo $piutang;
  }


  function pindahpelanggan()
  {
    $pelanggan = $this->db->get('pel_temp');
    foreach ($pelanggan->result() as $p) {
      echo $p->kode_cabang;
      $query = "UPDATE pelanggan SET kode_cabang='$p->kode_cabang', id_sales='$p->id_sales' WHERE kode_pelanggan='$p->kode_pelanggan'";
      $this->db->query($query);
    }
  }

  function limitkredit($rowno = 0)
  {
    // Search text
    $dari           = "";
    $sampai         = "";
    $salesman       = "";
    $pelanggan      = "";
    $approval       = "";
    $cbg            = "";
    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $salesman = $this->input->post('salesman');
      $pelanggan = $this->input->post('pelanggan');
      $approval = $this->input->post('approval');
      $cbg      = $this->input->post('cabang');

      $data   = array(
        'dari'         => $dari,
        'sampai'       => $sampai,
        'salesman'    => $salesman,
        'pelanggan'   => $pelanggan,
        'approval'    => $approval,
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

      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }

      if ($this->session->userdata('pelanggan') != NULL) {
        $pelanggan = $this->session->userdata('pelanggan');
      }

      if ($this->session->userdata('approval') != NULL) {
        $approval = $this->session->userdata('approval');
      }

      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
    }

    // Row per page
    $rowperpage = 20;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_penjualan->getrecordLimitkreditadminCount($cbg, $dari, $sampai, $salesman, $pelanggan, $approval);
    // Get records
    $users_record = $this->Model_penjualan->getDataLimitKreditadmin($rowno, $rowperpage, $cbg, $dari, $sampai, $salesman, $pelanggan, $approval);




    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/limitkredit';
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
    $data['salesman']          = $salesman;
    $data['pelanggan']         = $pelanggan;
    $data['approval']          = $approval;
    $data['cb']                 = $this->session->userdata('cabang');
    $data['cbg']               = $cbg;
    $data['cabang']            = $this->Model_cabang->view_cabang()->result();
    $data['sess_cab']           = $this->session->userdata('cabang');
    $this->template->load('template/template', 'penjualan/limitkredit', $data);
  }


  function limitkreditv2($rowno = 0)
  {
    // Search text
    $dari           = "";
    $sampai         = "";
    $salesman       = "";
    $pelanggan      = "";
    $approval       = "";
    $cbg            = "";
    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $salesman = $this->input->post('salesman');
      $pelanggan = $this->input->post('pelanggan');
      $approval = $this->input->post('approval');
      $cbg      = $this->input->post('cabang');

      $data   = array(
        'dari'         => $dari,
        'sampai'       => $sampai,
        'salesman'    => $salesman,
        'pelanggan'   => $pelanggan,
        'approval'    => $approval,
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

      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }

      if ($this->session->userdata('pelanggan') != NULL) {
        $pelanggan = $this->session->userdata('pelanggan');
      }

      if ($this->session->userdata('approval') != NULL) {
        $approval = $this->session->userdata('approval');
      }

      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
    }

    // Row per page
    $rowperpage = 20;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_penjualan->getrecordLimitkreditadminv2Count($cbg, $dari, $sampai, $salesman, $pelanggan, $approval);
    // Get records
    $users_record = $this->Model_penjualan->getDataLimitKreditadminv2($rowno, $rowperpage, $cbg, $dari, $sampai, $salesman, $pelanggan, $approval);




    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/limitkreditv2';
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
    $data['salesman']          = $salesman;
    $data['pelanggan']         = $pelanggan;
    $data['approval']          = $approval;
    $data['cb']                 = $this->session->userdata('cabang');
    $data['cbg']               = $cbg;
    $data['cabang']            = $this->Model_cabang->view_cabang()->result();
    $data['sess_cab']           = $this->session->userdata('cabang');
    $this->template->load('template/template', 'penjualan/limitkreditv2', $data);
  }
  function input_pengajuanlimit()
  {
    $data['cb']      = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->load->view('penjualan/input_pengajuanlimit', $data);
  }
  function input_pengajuanlimitv2()
  {
    $data['cb']      = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->load->view('penjualan/input_pengajuanlimitv2', $data);
  }

  function edit_pengajuanlimit()
  {
    $nopengajuan        = $this->input->post('id');
    $data['pengajuan']  = $this->Model_penjualan->getPengajuanLimitkredit($nopengajuan)->row_array();
    $data['cb']          = $this->session->userdata('cabang');
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $this->load->view('penjualan/edit_pengajuanlimit', $data);
  }

  function edit_pengajuanlimitv2()
  {
    $nopengajuan        = $this->input->post('id');
    $data['pengajuan']  = $this->Model_penjualan->getPengajuanLimitkreditv2($nopengajuan)->row_array();
    $data['cb']          = $this->session->userdata('cabang');
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $this->load->view('penjualan/edit_pengajuanlimitv2', $data);
  }

  function insertpengajuanlimit()
  {
    $this->Model_penjualan->insertpengajuanlimit();
  }
  function insertpengajuanlimitv2()
  {
    $this->Model_penjualan->insertpengajuanlimitv2();
  }
  function updatepengajuanlimit()
  {
    $this->Model_penjualan->updatepengajuanlimit();
  }

  function updatepengajuanlimitv2()
  {
    $this->Model_penjualan->updatepengajuanlimitv2();
  }
  function hapuspengajuanlimit()
  {
    $id = $this->uri->segment(3);
    $this->Model_penjualan->hapuspengajuanlimit($id);
  }

  function hapuspengajuanlimitv2()
  {
    $id = $this->uri->segment(3);
    $this->Model_penjualan->hapuspengajuanlimitv2($id);
  }


  function approvallimit($rowno = 0)
  {
    // Search text
    $dari           = "";
    $sampai         = "";
    $salesman       = "";
    $pelanggan      = "";
    $approval       = "";
    $cbg            = "";
    $status         = "";
    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $salesman = $this->input->post('salesman');
      $pelanggan = $this->input->post('pelanggan');
      $approval = $this->input->post('approval');
      $cbg      = $this->input->post('cabang');
      $status   = $this->input->post('status');
      $data   = array(
        'dari'         => $dari,
        'sampai'       => $sampai,
        'salesman'    => $salesman,
        'pelanggan'   => $pelanggan,
        'approval'    => $approval,
        'cbg'         => $cbg,
        'status'      => $status
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }

      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }

      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }

      if ($this->session->userdata('pelanggan') != NULL) {
        $pelanggan = $this->session->userdata('pelanggan');
      }

      if ($this->session->userdata('approval') != NULL) {
        $approval = $this->session->userdata('approval');
      }

      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }

      if ($this->session->userdata('status') != NULL) {
        $status = $this->session->userdata('status');
      }
    }

    // Row per page
    $rowperpage = 20;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_penjualan->getrecordLimitkreditCount($cbg, $dari, $sampai, $salesman, $pelanggan, $approval, $status);
    // Get records
    $users_record = $this->Model_penjualan->getDataLimitKredit($rowno, $rowperpage, $cbg, $dari, $sampai, $salesman, $pelanggan, $approval, $status);




    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/approvallimit';
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
    $data['salesman']          = $salesman;
    $data['pelanggan']         = $pelanggan;
    $data['approval']          = $approval;
    $data['cb']                 = $this->session->userdata('cabang');
    $data['cbg']               = $cbg;
    $data['status']            = $status;
    $data['cabang']            = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/approval_limit', $data);
  }

  function approvallimitv2($rowno = 0)
  {
    // Search text
    $dari           = "";
    $sampai         = "";
    $salesman       = "";
    $pelanggan      = "";
    $approval       = "";
    $cbg            = "";
    $status         = "";
    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $salesman = $this->input->post('salesman');
      $pelanggan = $this->input->post('pelanggan');
      $approval = $this->input->post('approval');
      $cbg      = $this->input->post('cabang');
      $status   = $this->input->post('status');
      $data   = array(
        'dari'         => $dari,
        'sampai'       => $sampai,
        'salesman'    => $salesman,
        'pelanggan'   => $pelanggan,
        'approval'    => $approval,
        'cbg'         => $cbg,
        'status'      => $status
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }

      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }

      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }

      if ($this->session->userdata('pelanggan') != NULL) {
        $pelanggan = $this->session->userdata('pelanggan');
      }

      if ($this->session->userdata('approval') != NULL) {
        $approval = $this->session->userdata('approval');
      }

      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }

      if ($this->session->userdata('status') != NULL) {
        $status = $this->session->userdata('status');
      }
    }

    // Row per page
    $rowperpage = 20;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_penjualan->getrecordLimitkreditv2Count($cbg, $dari, $sampai, $salesman, $pelanggan, $approval, $status);
    // Get records
    $users_record = $this->Model_penjualan->getDataLimitKreditv2($rowno, $rowperpage, $cbg, $dari, $sampai, $salesman, $pelanggan, $approval, $status);




    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/approvallimitv2';
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
    $data['salesman']          = $salesman;
    $data['pelanggan']         = $pelanggan;
    $data['approval']          = $approval;
    $data['cb']                 = $this->session->userdata('cabang');
    $data['cbg']               = $cbg;
    $data['status']            = $status;
    $data['cabang']            = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/approval_limitv2', $data);
  }

  function approvelimitproses()
  {
    $id = $this->uri->segment(3);
    $this->Model_penjualan->approvelimitproses($id);
  }

  function approvelimitproses2()
  {
    $id = $this->uri->segment(3);
    $this->Model_penjualan->approvelimitproses2($id);
  }

  function declinelimitproses()
  {
    $id = $this->uri->segment(3);
    $this->Model_penjualan->declinelimitproses($id);
  }

  function declinelimitproses2()
  {
    $id = $this->uri->segment(3);
    $this->Model_penjualan->declinelimitproses2($id);
  }
  function penjualanpend($rowno = 0)
  {
    // Search text
    // Search text
    $sess_cab   = $this->session->userdata('cabang');
    if ($sess_cab == 'pusat') {
      $cbg   = "";
    } else {
      $cbg   = $sess_cab;
    }
    $salesman = "";
    $dari     = "";
    $sampai   = "";
    $status   = "";
    if ($this->input->post('submit') != NULL) {
      $cbg      = $this->input->post('cabang');
      $salesman = $this->input->post('salesman');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $status   = $this->input->post('status');

      $data     = array(
        'cbg'        => $cbg,
        'salesman'   => $salesman,
        'dari'       => $dari,
        'sampai'     => $sampai,
        'status'     => $status
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }

      if ($this->session->userdata('status') != NULL) {
        $status = $this->session->userdata('status');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_penjualan->getrecordPenjualanpendCount($cbg, $salesman, $dari, $sampai, $status);
    // Get records
    $users_record = $this->Model_penjualan->getDataPenjualanpend($rowno, $rowperpage, $cbg, $salesman, $dari, $sampai, $status);

    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/penjualanpend';
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
    $data['pagination'] = $this->pagination->create_links();
    $data['result']     = $users_record;
    $data['row']         = $rowno;
    $data['cbg']        = $cbg;
    $data['salesman']   = $salesman;
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['sess_cab']   = $this->session->userdata('cabang');
    $data['dari']       = $dari;
    $data['sampai']     = $sampai;
    $data['status']     = $status;
    // Load view
    $this->template->load('template/template', 'penjualan/penjualanpending', $data);
  }

  function detailpenjualanpending()
  {
    $nofaktur = $this->input->post('nofakpenj');
    $data['faktur'] = $this->Model_penjualan->getPenjualanpending($nofaktur)->row_array();
    $data['detail'] = $this->Model_penjualan->getDetailpenjualanpending($nofaktur)->result();
    $this->load->view('penjualan/penjualanpending_detail', $data);
  }

  function hapuspenjualanpending()
  {
    $nofaktur = $this->uri->segment(3);
    $this->Model_penjualan->hapuspenjualanpending($nofaktur);
  }

  function updatepenjualanpending()
  {
    $kodepelanggan = $this->uri->segment(3);
    $nofaktur = $this->uri->segment(4);
    $this->Model_penjualan->updatepenjualanpending($kodepelanggan, $nofaktur);
  }

  function setorangiro($rowno = 0)
  {
    // Search text
    $namapel     = "";
    $nogiro     = "";
    $dari       = "";
    $sampai     = "";
    $status     = "";

    if ($this->input->post('submit') != NULL) {
      $namapel   = $this->input->post('namapel');
      $nogiro   = $this->input->post('nogiro');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $status   = $this->input->post('status2');
      $data   = array(

        'namapel'   => $namapel,
        'nogiro'   => $nogiro,
        'dari'     => $dari,
        'sampai'   => $sampai,
        'status'   => $status
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('namapel') != NULL) {
        $namapel = $this->session->userdata('namapel');
      }

      if ($this->session->userdata('nogiro') != NULL) {
        $nogiro = $this->session->userdata('nogiro');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
      if ($this->session->userdata('status') != NULL) {
        $status = $this->session->userdata('status');
      }
    }

    // Row per page
    $rowperpage = 10;

    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_pembayaran->getrecordGiro($namapel, $nogiro, $status, $dari, $sampai);

    // Get records
    $users_record = $this->Model_pembayaran->getdataGiro($rowno, $rowperpage, $namapel, $nogiro, $status, $dari, $sampai);



    //echo $allcount;

    //die;
    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/setorangiro';
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

    $data['pagination'] = $this->pagination->create_links();
    $data['result']     = $users_record;
    $data['row']         = $rowno;
    $data['namapel']     = $namapel;
    $data['dari']        = $dari;
    $data['sampai']      = $sampai;
    $data['nogiro']      = $nogiro;
    $data['jmldata']     = $allcount;
    $data['status']      = $status;
    $this->template->load('template/template', 'penjualan/setoran_giro', $data);
  }

  function setorgiro()
  {

    if (isset($_POST['simpan'])) {
      $page       = $this->input->post('page');
      $this->Model_penjualan->inputsetorangiro();
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <i class="fa fa-check"></i> Data Berhasil Di Update !
        </div>'
      );
      redirect('penjualan/' . $page);
    } else {
      $no_giro           = $this->input->post('no_giro');
      $data['status']    = $this->input->post('status');
      $data['tglbayar'] = $this->input->post('tglbayar');
      $data['giro']      = $this->Model_pembayaran->viewgiro($no_giro)->row_array();
      $data['bank']      = $this->Model_pembayaran->listbank()->result();
      $data['page']      = $this->input->post('page');
      $this->load->view('penjualan/setor_giro', $data);
    }
  }

  function batalkansetorangiro()
  {
    $noref = $this->uri->segment(3);
    $noref = str_replace("%20", " ", $noref);
    echo $noref;
    //die;
    $hapussetoran = $this->Model_penjualan->hapussetorangirotransfer($noref);
  }


  function setortransfer()
  {

    if (isset($_POST['simpan'])) {
      $page       = $this->input->post('page');
      $this->Model_penjualan->inputsetorantransfer();
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Update !
        </div>'
      );
      redirect('penjualan/' . $page);
    } else {
      $idtransfer       = $this->input->post('idtransfer');
      $data['status']    = $this->input->post('status');
      $data['tglbayar'] = $this->input->post('tglbayar');
      $data['transfer']  = $this->Model_pembayaran->viewtransfer($idtransfer)->row_array();
      $data['bank']      = $this->Model_pembayaran->listbank()->result();
      $data['page']      = $this->input->post('page');
      $this->load->view('penjualan/setor_transfer', $data);
    }
  }
  function inputterimasetoran()
  {
    $kodesetoranpusat = $this->input->post('kode_setoran');
    $data['setoranpusat'] = $this->Model_penjualan->get_setoranpusat($kodesetoranpusat)->row_array();
    $data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    $data['lbank'] = $this->Model_pembayaran->listbank()->result();
    $this->load->view('penjualan/inputterimasetoran', $data);
  }


  function listtransfer($rowno = 0)
  {
    // Search text
    $namapel    = "";
    $nofaktur   = "";
    $dari       = "";
    $sampai     = "";
    if ($this->input->post('submit') != NULL) {
      $namapel  = $this->input->post('namapel');
      $nofaktur = $this->input->post('nofaktur');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $data     = array(

        'namapel'    => $namapel,
        'nofaktur'   => $nofaktur,
        'dari'       => $dari,
        'sampai'     => $sampai

      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('namapel') != NULL) {
        $namapel = $this->session->userdata('namapel');
      }
      if ($this->session->userdata('nofaktur') != NULL) {
        $nofaktur = $this->session->userdata('nofaktur');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }

    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_penjualan->getrecordTransfer($namapel, $nofaktur, $dari, $sampai);
    // Get records
    $users_record = $this->Model_penjualan->getdataTransfer($rowno, $rowperpage, $namapel, $nofaktur, $dari, $sampai);
    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/listtransfer';
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
    $data['pagination']         = $this->pagination->create_links();
    $data['result']             = $users_record;
    $data['row']                = $rowno;
    $data['namapel']            = $namapel;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['nofaktur']           = $nofaktur;
    $this->template->load('template/template', 'penjualan/list_transfer', $data);
  }

  function setorantransfer($rowno = 0)
  {
    //	error_reporting(0);
    // Search text
    $namapel     = "";
    $dari       = "";
    $sampai     = "";
    $status     = "";


    if ($this->input->post('submit') != NULL) {
      $namapel   = $this->input->post('namapel');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $status   = $this->input->post('status2');

      $data   = array(

        'namapel'   => $namapel,
        'dari'     => $dari,
        'sampai'   => $sampai,
        'status'   => $status


      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('namapel') != NULL) {
        $namapel = $this->session->userdata('namapel');
      }

      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
      if ($this->session->userdata('status') != NULL) {
        $status = $this->session->userdata('status');
      }
    }

    // Row per page
    $rowperpage = 10;

    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_pembayaran->getrecordTransfer($namapel, $dari, $sampai, $status);

    // Get records
    $users_record = $this->Model_pembayaran->getdataTransfer($rowno, $rowperpage, $namapel, $dari, $sampai, $status);



    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/setorantransfer';
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

    $data['pagination'] = $this->pagination->create_links();
    $data['jmldata']    = $allcount;
    $data['result']     = $users_record;
    $data['row']         = $rowno;
    $data['status']     = $status;
    $data['namapel']     = $namapel;
    $data['dari']        = $dari;
    $data['sampai']      = $sampai;

    $this->template->load('template/template', 'penjualan/setoran_transfer', $data);
  }

  function batalkansetorantrf()
  {
    $noref = $this->uri->segment(3);
    $hapussetoran = $this->Model_penjualan->hapussetorantrf($noref);
  }

  function saldokurlebsetor($rowno = 0)
  {
    // Search text
    $tanggal  = "";
    $cab      = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $bulan            = "";
    $tahun            = "";
    if ($this->input->post('submit') != NULL) {
      $tanggal   = $this->input->post('tanggal');
      $cabang    = $this->input->post('cabang');
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $data   = array(
        'tanggal'  => $tanggal,
        'cbg'     => $cabang,
        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_penjualan->getrecordSaldoawalkurlebCount($tanggal, $cabang, $bulan, $tahun);
    // Get records
    $users_record = $this->Model_penjualan->getDataSaldoawalkurleb($rowno, $rowperpage, $tanggal, $cabang, $bulan, $tahun);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'penjualan/saldoawalkb';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['tanggal']              = $tanggal;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['tahun']                = date("Y");
    $data['bulan']                = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']                  = $bulan;
    $data['thn']                  = $tahun;
    $this->template->load('template/template', 'penjualan/saldokurlebsetor', $data);
  }

  function inputsaldoawalkurleb()
  {
    $data['cabang']    = $this->Model_cabang->view_cabang()->result();
    $data['cb']        = $this->session->userdata('cabang');
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->load->view('penjualan/inputsaldoawalkurleb', $data);
  }

  function getsaldosalestemp()
  {
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $cabang = $this->input->post('cabang');
    $data['saldosalestemp'] = $this->Model_penjualan->getsaldosalestemp($bulan, $tahun, $cabang)->result();
    $this->load->view('penjualan/saldo_kurleb_temp', $data);
  }

  function getdetailsaldosaleskurleb()
  {
    $id = $this->uri->segment(3);
    $data['saldokurleb'] = $this->Model_penjualan->getsaldokurleb($id)->row_array();
    $data['detailsaldokurleb'] = $this->Model_penjualan->getdetailsaldosaleskurleb($id)->result();
    $this->load->view('penjualan/saldo_kurleb_detail', $data);
  }

  function getdetailsaldokurleb()
  {
    $bulan    = $this->input->post('bulan');
    $tahun    = $this->input->post('tahun');
    $cabang   = $this->input->post('cabang');
    $salesman = $this->input->post('salesman');
    $ceksaldo = $this->Model_penjualan->ceksaldokurleb($bulan, $tahun, $cabang)->num_rows();
    $cekall   = $this->Model_penjualan->ceksaldoallkurleb($cabang)->num_rows();
    $ceknow   = $this->Model_penjualan->ceksaldoSkrgkurleb($bulan, $tahun, $cabang)->num_rows();
    if (empty($ceksaldo) && !empty($cekall) || !empty($ceknow)) {
      echo "1";
    } else {
      $saldo = $this->Model_penjualan->getdetailsaldokurleb($bulan, $tahun, $cabang, $salesman)->row_array();
      $setoranpenjualan  = $this->Model_penjualan->getsetoranpenjualankurleb($bulan, $tahun, $cabang, $salesman)->row_array();
      $ksetorpenjualan   = $this->Model_penjualan->getKLSetorpenjualankurleb($bulan, $tahun, $cabang, $pembayaran = 1, $salesman)->row_array();
      $lsetoranpenjualan = $this->Model_penjualan->getKLSetorpenjualankurleb($bulan, $tahun, $cabang, $pembayaran = 2, $salesman)->row_array();
      $saldo = $saldo['jumlah'];

      $setoranpenjkertas     = $setoranpenjualan['uangkertas'];
      $setoranpenjlogam      = $setoranpenjualan['uanglogam'];
      $setoranpenjgiro        = $setoranpenjualan['giro'];
      $setoranpenjtransfer  = $setoranpenjualan['transfer'];
      $girotocash            = $setoranpenjualan['girotocash'];

      $kurangsetor = $ksetorpenjualan['uangkertas'] +  $ksetorpenjualan['uanglogam'];
      $lebihsetor = $lsetoranpenjualan['uangkertas'] + $lsetoranpenjualan['uanglogam'];



      $totalsetoran = $setoranpenjkertas + $setoranpenjlogam + $setoranpenjgiro + $setoranpenjtransfer;
      $totallhp = $setoranpenjualan['terimatunai'] + $setoranpenjualan['terimatagihan'];

      $saldoakhir = $saldo + ($totalsetoran - $totallhp) + $kurangsetor - $lebihsetor;
      echo number_format($saldoakhir, '0', '', '.') . "|";
    }
  }

  function hapussaldosalestemp()
  {
    $id = $this->input->post('id');
    $this->Model_penjualan->hapussaldosalestemp($id);
  }

  function simpansaldosalestemp()
  {
    $simpan = $this->Model_penjualan->simpansaldosalestemp();
    echo $simpan;
  }

  function insertsaldoawalkurleb()
  {
    $this->Model_penjualan->insertsaldoawalkurleb();
  }

  function belumsetor()
  {
    // Search text
    $tanggal  = "";
    $cab      = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $bulan            = "";
    $tahun            = "";
    if ($this->input->post('submit') != NULL) {
      $tanggal   = $this->input->post('tanggal');
      $cabang    = $this->input->post('cabang');
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $data   = array(
        'tanggal'  => $tanggal,
        'cbg'     => $cabang,
        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }
    $users_record = $this->Model_penjualan->getDataBelumsetor($tanggal, $cabang, $bulan, $tahun);
    $data['result']               = $users_record;
    $data['tanggal']              = $tanggal;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['tahun']                = date("Y");
    $data['bulan']                = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']                  = $bulan;
    $data['thn']                  = $tahun;
    $this->template->load('template/template', 'penjualan/belumsetor', $data);
  }

  function inputbelumsetorsales()
  {
    $data['cabang']    = $this->Model_cabang->view_cabang()->result();
    $data['cb']        = $this->session->userdata('cabang');
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->load->view('penjualan/inputbelumsetorsales', $data);
  }

  function getbelumsetortemp()
  {
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $cabang = $this->input->post('cabang');
    $data['belumsetortemp'] = $this->Model_penjualan->getbelumsetortemp($bulan, $tahun, $cabang)->result();
    $this->load->view('penjualan/belumsetor_temp', $data);
  }

  function simpanbelumsetortemp()
  {
    $simpan = $this->Model_penjualan->simpanbelumsetortemp();
    echo $simpan;
  }

  function hapusbelumsetortemp()
  {
    $id = $this->input->post('id');
    $this->Model_penjualan->hapusbelumsetortemp($id);
  }

  function insertbelumsetorsales()
  {
    $this->Model_penjualan->insertbelumsetorsales();
  }

  function getdetailbelumsetorsales()
  {
    $id = $this->uri->segment(3);
    $data['belumsetor'] = $this->Model_penjualan->getSaldobelumsetor($id)->row_array();
    $data['detailbelumsetor'] = $this->Model_penjualan->getdetailbelumsetor($id)->result();
    $this->load->view('penjualan/belumsetor_detail', $data);
  }

  function hapussaldoawalkurleb()
  {
    $id = $this->uri->segment(3);
    echo $id;
    //die;;
    $this->Model_penjualan->hapussaldoawalkurleb($id);
  }

  function hapusbelumsetorsales()
  {
    $id = $this->uri->segment(3);
    echo $id;
    //die;;
    $this->Model_penjualan->hapusbelumsetorsales($id);
  }

  function loadfoto()
  {
    $kodepelanggan = $this->input->post('kodepelanggan');
    $data['pelanggan'] = $this->Model_pelanggan->get_pelanggan($kodepelanggan)->row_array();
    $this->load->view('penjualan/loadfoto', $data);
  }

  function loaddatapelanggan()
  {
    $kodepelanggan = $this->input->post('kodepelanggan');
    $data['pelanggan'] = $this->Model_pelanggan->get_pelanggan($kodepelanggan)->row_array();
    $this->load->view('penjualan/loaddatapelanggan', $data);
  }

  function jatuhtempo($rowno = 0)
  {
    // Search text
    $dari           = "";
    $sampai         = "";
    $salesman       = "";
    $pelanggan      = "";
    $approval       = "";
    $cbg            = "";
    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $salesman = $this->input->post('salesman');
      $pelanggan = $this->input->post('pelanggan');
      $approval = $this->input->post('approval');
      $cbg      = $this->input->post('cabang');

      $data   = array(
        'dari'         => $dari,
        'sampai'       => $sampai,
        'salesman'    => $salesman,
        'pelanggan'   => $pelanggan,
        'approval'    => $approval,
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

      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }

      if ($this->session->userdata('pelanggan') != NULL) {
        $pelanggan = $this->session->userdata('pelanggan');
      }

      if ($this->session->userdata('approval') != NULL) {
        $approval = $this->session->userdata('approval');
      }

      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
    }

    // Row per page
    $rowperpage = 20;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_penjualan->getrecordJatuhTempoCount($cbg, $dari, $sampai, $salesman, $pelanggan, $approval);
    // Get records
    $users_record = $this->Model_penjualan->getDataJatuhTempo($rowno, $rowperpage, $cbg, $dari, $sampai, $salesman, $pelanggan, $approval);




    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/jatuhtempo';
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
    $data['salesman']          = $salesman;
    $data['pelanggan']         = $pelanggan;
    $data['approval']          = $approval;
    $data['cb']                 = $this->session->userdata('cabang');
    $data['cbg']               = $cbg;
    $data['sess_cab']           = $this->session->userdata('cabang');
    $data['cabang']            = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/jatuhtempo', $data);
  }

  function input_jatuhtempo()
  {
    $data['cb']      = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->load->view('penjualan/input_jatuhtempo', $data);
  }

  function insertpengajuanjatuhtempo()
  {
    $this->Model_penjualan->insertpengajuanjatuhtempo();
  }

  function approvejatuhtempo($rowno = 0)
  {
    // Search text
    $dari           = "";
    $sampai         = "";
    $salesman       = "";
    $pelanggan      = "";
    $status         = "";
    $cbg            = "";
    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $salesman = $this->input->post('salesman');
      $pelanggan = $this->input->post('pelanggan');
      $status   = $this->input->post('status');
      $cbg      = $this->input->post('cabang');

      $data   = array(
        'dari'         => $dari,
        'sampai'       => $sampai,
        'salesman'    => $salesman,
        'pelanggan'   => $pelanggan,
        'status'      => $status,
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

      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }

      if ($this->session->userdata('pelanggan') != NULL) {
        $pelanggan = $this->session->userdata('pelanggan');
      }



      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }

      if ($this->session->userdata('status') != NULL) {
        $status = $this->session->userdata('status');
      }
    }

    // Row per page
    $rowperpage = 20;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_penjualan->getrecordJatuhTempoCount($cbg, $dari, $sampai, $salesman, $pelanggan, $status);
    // Get records
    $users_record = $this->Model_penjualan->getDataJatuhTempo($rowno, $rowperpage, $cbg, $dari, $sampai, $salesman, $pelanggan, $status);




    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/jatuhtempo';
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
    $data['salesman']          = $salesman;
    $data['pelanggan']         = $pelanggan;

    $data['cb']                 = $this->session->userdata('cabang');
    $data['cbg']               = $cbg;
    $data['status']            = $status;
    $data['cabang']            = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/approvejatuhtempo', $data);
  }

  function approvejatuhtempoproses()
  {
    $id = $this->uri->segment(3);
    $this->Model_penjualan->approvejatuhtempoproses($id);
  }

  function declinejatuhtempoproses()
  {
    $id = $this->uri->segment(3);
    $this->Model_penjualan->declinejatuhtempoproses($id);
  }

  function hapuspengajuanjatuhtempo()
  {
    $id = $this->uri->segment(3);
    $this->Model_penjualan->hapuspengajuanjatuhtempo($id);
  }

  function suratjalan($rowno = 0)
  {
    // Search text
    $nofaktur = "";
    $namapel  = "";
    $dari = "";
    $sampai = "";

    if ($this->input->post('submit') != NULL) {
      $namapel   = $this->input->post('namapel');
      $nofaktur = $this->input->post('nofaktur');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $data = array(
        'namapel'    => $namapel,
        'nofaktur'   => $nofaktur,
        'dari' => $dari,
        'sampai' => $sampai
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('namapel') != NULL) {
        $namapel = $this->session->userdata('namapel');
      }
      if ($this->session->userdata('nofaktur') != NULL) {
        $nofaktur = $this->session->userdata('nofaktur');
      }

      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    if (empty($nofaktur) && empty($namapel) && empty($dari) && empty($sampai)) {
      $allcount = 0;
      $users_record = 0;
    } else {
      // All records count
      $allcount     = $this->Model_pembayaran->getDataBayar($rowno, $rowperpage, $nofaktur, $namapel, $dari, $sampai)->num_rows();
      // Get records
      $users_record = $this->Model_pembayaran->getDataBayar($rowno, $rowperpage, $nofaktur, $namapel, $dari, $sampai)->result_array();
    }


    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/suratjalan';
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
    $data['pagination'] = $this->pagination->create_links();
    $data['result'] = $users_record;
    $data['row'] = $rowno;
    $data['nofaktur'] = $nofaktur;
    $data['dari']  = $dari;
    $data['sampai'] = $sampai;
    $data['namapel'] = $namapel;
    // Load view
    $this->template->load('template/template', 'penjualan/suratjalan', $data);
  }


  function koreksifaktur($rowno = 0)
  {
    // Search text
    $nofaktur = "";
    $namapel  = "";
    $dari = "";
    $sampai = "";

    if ($this->input->post('submit') != NULL) {
      $namapel   = $this->input->post('namapel');
      $nofaktur = $this->input->post('nofaktur');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $data = array(
        'namapel'    => $namapel,
        'nofaktur'   => $nofaktur,
        'dari' => $dari,
        'sampai' => $sampai
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('namapel') != NULL) {
        $namapel = $this->session->userdata('namapel');
      }
      if ($this->session->userdata('nofaktur') != NULL) {
        $nofaktur = $this->session->userdata('nofaktur');
      }

      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    if (empty($nofaktur) && empty($namapel) && empty($dari) && empty($sampai)) {
      $allcount = 0;
      $users_record = 0;
    } else {
      $allcount     = $this->Model_pembayaran->getDataBayar($rowno, $rowperpage, $nofaktur, $namapel, $dari, $sampai)->num_rows();
      // Get records
      $users_record = $this->Model_pembayaran->getDataBayar($rowno, $rowperpage, $nofaktur, $namapel, $dari, $sampai)->result_array();
    }


    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/koreksifaktur';
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
    $data['pagination'] = $this->pagination->create_links();
    $data['result'] = $users_record;
    $data['row'] = $rowno;
    $data['nofaktur'] = $nofaktur;
    $data['dari']  = $dari;
    $data['sampai'] = $sampai;
    $data['namapel'] = $namapel;
    // Load view
    $this->template->load('template/template', 'penjualan/koreksifaktur', $data);
  }

  function movesales($rowno = 0)
  {
    // Search text
    $nofaktur = "";
    $namapel  = "";
    $tanggalpindah = "";
    //$sampai = "";

    if ($this->input->post('submit') != NULL) {
      $namapel   = $this->input->post('namapel');
      $nofaktur = $this->input->post('nofaktur');
      $tanggalpindah     = $this->input->post('tanggalpindah');
      //$sampai   = $this->input->post('sampai');
      $data = array(
        'namapel'    => $namapel,
        'nofaktur'   => $nofaktur,
        'tanggalpindah' => $tanggalpindah
        //'sampai' => $sampai
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('namapel') != NULL) {
        $namapel = $this->session->userdata('namapel');
      }
      if ($this->session->userdata('nofaktur') != NULL) {
        $nofaktur = $this->session->userdata('nofaktur');
      }

      if ($this->session->userdata('tanggalpindah') != NULL) {
        $tanggalpindah = $this->session->userdata('tanggalpindah');
      }
      // if ($this->session->userdata('sampai') != NULL) {
      //   $sampai = $this->session->userdata('sampai');
      // }
    }

    //echo $tanggalpindah;
    //die;
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    if (empty($nofaktur) && empty($namapel) && empty($tanggalpindah)) {
      $allcount = 0;
      $users_record = 0;
    } else {
      // All records count
      $allcount     = $this->Model_penjualan->getrecordMoveFaktur($nofaktur, $namapel, $tanggalpindah);
      // Get records
      $users_record = $this->Model_penjualan->getDataMoveFaktur($rowno, $rowperpage, $nofaktur, $namapel, $tanggalpindah);
    }


    // Pagination Configuration
    $config['base_url']         = base_url() . 'penjualan/movesales';
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
    $data['pagination'] = $this->pagination->create_links();
    $data['result'] = $users_record;
    $data['row'] = $rowno;
    $data['nofaktur'] = $nofaktur;
    $data['tanggalpindah']  = $tanggalpindah;
    //$data['sampai'] = $sampai;
    $data['namapel'] = $namapel;
    // Load view
    $this->template->load('template/template', 'penjualan/movesales', $data);
  }
}
