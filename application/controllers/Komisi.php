<?php
class Komisi extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->Model(array('Model_cabang', 'Model_komisi', 'Model_sales'));
  }

  function targetqty()
  {
  }
}
