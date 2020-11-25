<?php 

class Telegram extends CI_Controller{


	function index(){

		$this->template->load('template/template','telegram/telegram');
	}


}