<?php

class Pelanggan extends CI_Controller{

	function __construct(){
		parent::__construct();
		 check_login();
		$this->load->model(array('Model_pelanggan','Model_cabang','Model_sales'));
	}

	// function view_pelanggan(){
	// 	$this->template->load('template/template','pelanggan/view_pelanggan');
	// }

  function view_pelanggan($rowno=0){
      // Search text
    $sess_cab   = $this->session->userdata('cabang');
    if($sess_cab == 'pusat'){
      $cbg   = "";
    }else{
      $cbg   = $sess_cab;
    }

    $salesman = "";
    $namapel = "";
    $dari = "";
    $sampai = "";
    if($this->input->post('submit') != NULL ){
      $cbg      = $this->input->post('cabang');
      $salesman = $this->input->post('salesman');
      $namapel = $this->input->post('namapel');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      
      $data     = array(
                  'cbg'        => $cbg,
                  'salesman'   => $salesman,
                  'namapel'   => $namapel,
                  'dari'       => $dari,
		              'sampai'     => $sampai
                );
      $this->session->set_userdata($data);
    }else{
      if($this->session->userdata('cbg') != NULL){
        $cbg = $this->session->userdata('cbg');
      }
      if($this->session->userdata('salesman') != NULL){
        $salesman = $this->session->userdata('salesman');
      }

      if($this->session->userdata('namapel') != NULL){
        $namapel = $this->session->userdata('namapel');
      }

      if($this->session->userdata('dari') != NULL){
        $dari = $this->session->userdata('dari');
      }
      if($this->session->userdata('sampai') != NULL){
        $sampai = $this->session->userdata('sampai');
      }
      
    }

    if(isset($_POST['export'])){
      header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Data Pelanggan.xls");
      $data['pelanggan'] = $this->Model_pelanggan->Exportpelanggan($cbg,$salesman,$namapel,$dari,$sampai)->result();
      $this->load->view('pelanggan/pelanggan_export',$data);
    }else{
    // Row per page
    $rowperpage = 10;
    // Row position
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_pelanggan->getrecordPelanggan($cbg,$salesman,$namapel,$dari,$sampai);
    // Get records
    $users_record = $this->Model_pelanggan->getdataPelanggan($rowno,$rowperpage,$cbg,$salesman,$namapel,$dari,$sampai);
    // Pagination Configuration
    $config['base_url']         = base_url().'pelanggan/view_pelanggan';
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
    $data['allcount']           = $allcount;
    $data['row']                = $rowno;
    $data['cbg']                = $cbg;
    $data['salesman']           = $salesman;
    $data['namapel']            = $namapel;
    $data['dari']       				= $dari;
    $data['sampai']     				= $sampai;
    $data['cabang']             = $this->Model_cabang->view_cabang()->result();
    $data['sess_cab']           = $this->session->userdata('cabang');
      $this->template->load('template/template','pelanggan/view_pelanggan',$data);
    }
  }

 function tes()
 {
   echo $_POST['simpan'];
 }


	function input_pelanggan(){

		if(isset($_POST['simpan'])){
      $config['upload_path']          = './upload/toko';
      $config['allowed_types']        = 'gif|jpg|png';
      $config['max_size']             = 0;
      $config['max_width']            = 0;
      $config['max_height']           = 0;
      $config['file_name']            = $this->input->post('kode_pelanggan');
      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('foto')){
        $error = array('error' => $this->upload->display_errors());
        $this->load->view('pelanggan', $error);
      }else{
        $_data = array('upload_data' => $this->upload->data());
        $foto  = $_data['upload_data']['file_name'];
        $this->Model_pelanggan->insert_pelanggan($foto);
        $this->session->set_flashdata('msg',
            '<div class="alert bg-green alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
              </div>');
          redirect('pelanggan/view_pelanggan');
      }
		}else{
			$kode_cabang  = $this->session->userdata('cabang');
			$kodeterakhir = $this->db->query("SELECT kode_pelanggan FROM pelanggan WHERE kode_cabang='$kode_cabang' AND LEFT(kode_pelanggan,3)='$kode_cabang'  ORDER BY kode_pelanggan DESC LIMIT 1")->row_array();
			$cabang 	= $this->session->userdata('cabang');
			$data['kode_pelanggan'] = buatkode($kodeterakhir['kode_pelanggan'],$cabang.'-',5);
			$data['cabang'] 		= $this->Model_cabang->view_cabang()->result();


			$this->load->view('pelanggan/input_pelanggan',$data);
		}
	}

	function edit_pelanggan(){
    // echo $_FILES["foto"]["name"];
    // die;
		if(isset($_POST['submit'])){
      if (!empty($_FILES["foto"]["name"])) {
        $config['upload_path']          = './upload/toko';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 0;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $config['overwrite']			      = true;
        $config['file_name']            = $this->input->post('kode_pelanggan');
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('foto')){
          $error = array('error' => $this->upload->display_errors());
          $this->load->view('pelanggan', $error);
         
        }else{
          $_data = array('upload_data' => $this->upload->data());
          $foto  = $_data['upload_data']['file_name'];
          $this->Model_pelanggan->update_pelanggan($foto);
          $this->session->set_flashdata('msg',
              '<div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Update !
                </div>');
            redirect('pelanggan/view_pelanggan');
            //echo "B";
        }
      } else {
          $foto = $this->input->post('old_foto');
          $this->Model_pelanggan->update_pelanggan($foto);
          $this->session->set_flashdata('msg',
	        '<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Update !
	          </div>');
         redirect('pelanggan/view_pelanggan');
       
      }
			
			
		}else{
			$id_pelanggan 	= $this->uri->segment(3);
			$data['cabang'] = $this->Model_cabang->view_cabang()->result();
			$pel			= $this->Model_pelanggan->get_pelanggan($id_pelanggan)->row_array();
			$data['pel'] 	= $pel;
			$data['sales'] 	= $this->Model_sales->get_salescab($pel['kode_cabang'])->result();
			$this->template->load('template/template','pelanggan/edit_pelanggan',$data);
		}
	}

	function hapus(){

		$id_pelanggan = $this->uri->segment(3);
		$this->Model_pelanggan->hapus($id_pelanggan);
		$this->session->set_flashdata('msg',
      '<div class="alert bg-green alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
      </div>');
   redirect('pelanggan/view_pelanggan');
	}

	function json() {
    header('Content-Type: application/json');
    echo $this->Model_pelanggan->json();
  }


  function get_salespel(){
  	$kode_cabang 	= $this->input->post('kode_cabang');
  	$listsales		= $this->Model_pelanggan->get_salespel($kode_cabang);
  	echo "<option>-- Plih Salesman -- </option>";
		foreach ($listsales->result() as $s){
			echo "<option value=$s->id_karyawan>$s->nama_karyawan</option>";
		}
	}

	function limitpelanggan($rowno=0)
  {
    // Search text
    $cab  = $this->session->userdata('cabang');
    if($cab !='pusat')
    {
      $cabang = $cab;
    }else{
      $cabang = "";
    }
    // Search text
    $salesman   = "";
		$pelanggan  = "";
    if($this->input->post('submit') != NULL ){
      $cabang      = $this->input->post('cabang');
      $salesman    = $this->input->post('salesman');
			$pelanggan 	 = $this->input->post('pelanggan');
      $data 	= array(
        'cbg'       => $cabang,
        'salesman'  => $salesman,
				'pelanggan' => $pelanggan
      );
      $this->session->set_userdata($data);
    }else{
      if($this->session->userdata('cbg') != NULL){
        $cabang = $this->session->userdata('cbg');
      }
      if($this->session->userdata('salesman') != NULL){
        $salesman = $this->session->userdata('salesman');
      }
			if($this->session->userdata('pelanggan') != NULL){
        $pelanggan = $this->session->userdata('pelanggan');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }
    // All records count
    $allcount 	  = $this->Model_pelanggan->getrecordLimitPelangganCount($cabang,$salesman,$pelanggan);
    // Get records
    $users_record = $this->Model_pelanggan->getDataLimitPelanggan($rowno,$rowperpage,$cabang,$salesman,$pelanggan);
    // Pagination Configuration
    $config['base_url'] 					= base_url().'pelanggan/limitpelanggan';
    $config['use_page_numbers'] 	= TRUE;
    $config['total_rows'] 				= $allcount;
    $config['per_page'] 					= $rowperpage;
    $config['first_link']       	= 'First';
    $config['last_link']        	= 'Last';
    $config['next_link']        	= 'Next';
    $config['prev_link']        	= 'Prev';
    $config['full_tag_open']    	= '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   	= '</ul></nav></div>';
    $config['num_tag_open']     	= '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    	= '</span></li>';
    $config['cur_tag_open']     	= '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    	= '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    	= '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  	= '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    	= '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  	= '</span>Next</li>';
    $config['first_tag_open']   	= '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] 	= '</span></li>';
    $config['last_tag_open']    	= '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  	= '</span></li>';
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result'] 		          = $users_record;
    $data['row'] 			          	= $rowno;
		$data['pelanggan']						= $pelanggan;
    $data['salesman']	            = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang'] 		          = $this->Model_cabang->view_cabang()->result();
    $data['cb'] 				          = $this->session->userdata('cabang');

    //echo $data['cb'];
    $this->template->load('template/template','pelanggan/limitpelanggan',$data);
  }


  function pelanggan(){

    $kode_cabang            = $this->input->post('cabang');
    $data['cabang']         = $this->Model_cabang->view_cabang()->result();
    $data['sales']          = $this->Model_pelanggan->get_salespel($kode_cabang)->result();
    $this->template->load('template/template','pelanggan/pelanggan.php',$data);
  }

  function cetak_pelanggan(){

    $cabang                 = $this->input->post('cabang');
    $sales                  = $this->input->post('salesman');
    $data['cabang']         = $cabang;
    $data['sales']          = $sales;
    $data['data']           = $this->Model_pelanggan->list_detailpelanggan($cabang,$sales)->result();
    if(isset($_POST['export'])){
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Pelanggan.xls");
    }
    $this->load->view('pelanggan/cetak_pelanggan',$data);
  }


}
