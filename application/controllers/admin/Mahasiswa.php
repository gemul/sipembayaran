<?php

class Mahasiswa extends CI_Controller {
	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index()
	{
        // load view admin/mahasiswa.php
        $this->load->view("admin/mahasiswa/index");
	}
	public function add()
	{
        // load view admin/mahasiswa.php
        $data=Array('judul'=>'Tambah Data Mahasiswa');
        $this->load->view("admin/mahasiswa/add",$data);
	}
}