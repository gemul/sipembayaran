<?php

class Transaksi extends CI_Controller {
	function __construct(){
		parent::__construct();
	
		$this->load->model('m_pembayaran');
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index()
	{
		// load view admin/mahasiswa.php
		$data = Array(
			"arrJenis"=>$this->m_pembayaran->getJenis()
		);
		$this->load->view("admin/transaksi/add",$data);
	}
	public function add()
	{
		// load view admin/mahasiswa.php
		$data=Array('judul'=>'Tambah Data Mahasiswa');
		$this->load->view("admin/mahasiswa/add",$data);
	}
	public function list_mahasiswa()
	{
		$list = $this->m_pembayaran->get_datatables();
		$returnData=Array();
		$returnData['draw']=$_POST['draw'];
		$returnData['recordsTotal']=$this->m_mahasiswa->count_all();
		$returnData['recordsFiltered']=$this->m_mahasiswa->count_filtered();
		$returnData['data']=Array();
		$no=1;
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $field->mhs_nim;
            $row[] = $field->mhs_nama;
 
            $returnData['data'][] = $row;
        }


		echo json_encode($returnData);
	}
	public function batchEntry()
	{
		return true;
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
			$this->m_mahasiswa->add(Array(
				'mhs_nim'=>$data[0],
				'mhs_nama'=>$data[1]
			));
		}
		fclose($handle);
		}
		// var_dump(read_file("storage/mahasiswa.csv"));
	}
}