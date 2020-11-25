<?php

class Auth extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->Model('Model_auth');
  }

  function login()
  {
    check_log();
    if (isset($_POST['submit'])) {
      $username    = $this->input->post('username');
      $password    = md5($this->input->post('password'));
      $user        = $this->Model_auth->cek_user($username, $password);
      $cek_user    = $user->num_rows();
      $data_user   = $user->row_array();


      if ($cek_user != 0) {

        $data_session = array(

          'id_user'       => $data_user['id_user'],
          'nama_lengkap'  => $data_user['nama_lengkap'],
          'username'      => $data_user['username'],
          'password'      => $data_user['password'],
          'level_user'    => $data_user['level'],
          'cabang'        => $data_user['cabang'],
          'dept'          => $data_user['kode_dept']
        );
        $this->session->set_userdata($data_session);
        $id_user = $data_user['id_user'];
        $waktu = date('Y-m-d h:i:s');
        $this->db->query("UPDATE users SET terakhir_login = '$waktu', aktif = '1'  WHERE id_user = '$id_user' ");
        redirect('dashboard');
       
      } else {
        $this->session->set_flashdata(
          'msg',
          ' <div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">error</i> Oopss! Username atau Password Salah !
        </div>'
        );
        redirect('auth/login');
      }
    } else {

      $this->template->load('template/template_loginv2', 'auth/login');
    }
  }

  function logout()
  {

    $id_user = $this->session->userdata('id_user');
    $this->db->query("UPDATE users SET aktif = '0' WHERE id_user = '$id_user' ");
    $this->session->sess_destroy();
    redirect('auth/login');
  }
}
