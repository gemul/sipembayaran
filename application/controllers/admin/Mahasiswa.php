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
		asdfsdaf
	}
	public function add()
	{
		// load view admin/mahasiswa.php
		$data=Array('judul'=>'Tambah Data Mahasiswa');
		$this->load->view("admin/mahasiswa/add",$data);
	}
	public function batchEntry()
	{

		$this->load->helper('file');
		if (($handle = fopen("storage/mahasiswa.csv", "r")) !== FALSE) {
			$row=0;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			echo "<p> $num fields in line $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $num; $c++) {
				echo $data[$c] . "<br />\n";
			}
		}
		fclose($handle);
		}
		// var_dump(read_file("storage/mahasiswa.csv"));
	}
}