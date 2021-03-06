<?php

class Transaksi extends CI_Controller {
	function __construct(){
		parent::__construct();
	
		$this->load->model('m_pembayaran');
		$this->load->model('m_user');
		$this->load->model('m_mahasiswa');
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
	
	public function listTransaksi()
	{
		// load view admin/mahasiswa.php
		$this->load->view("admin/transaksi/list");
	}
	public function add()
	{
		// load view admin/mahasiswa.php
		$data=Array('judul'=>'Tambah Data Mahasiswa');
		$this->load->view("admin/mahasiswa/add",$data);
	}
	public function save()
	{
		$user=$this->m_user->getSingleUserFromUsername($this->session->userdata('nama'));
		$data=$_POST;
		$query=Array(
			'mhs_id'=>$_POST['mahasiswa'],
			'user_id'=>$user->user_id,
			'pmb_jenis'=>$_POST['jenis'],
			'pmb_semester'=>$_POST['semester'],
			'pmb_keterangan'=>$_POST['keterangan'],
			'pmb_nominal'=>$_POST['nominal'],
			'pmb_waktu'=>$_POST['waktu'],
			'pmb_tahun'=>'2019',
		);
		
		$viewData = Array(
			"arrJenis"=>$this->m_pembayaran->getJenis()
		);
		if($id=$this->m_pembayaran->savePembayaran($query)){
			$mahasiswa=$this->m_mahasiswa->getSingleMahasiswa($_POST['mahasiswa']);
			$additionalViewData=Array(
				'status'=>'ok',
				'message'=>'Pembayaran '.$_POST['jenis'].' '.$mahasiswa->mhs_nama.'  senilai '.number_format($_POST['nominal'],0,",",".").' berhasil disimpan',
			);
		}else{
			$additionalViewData=Array(
				'status'=>'fail',
				'message'=>'Gagal menyimpan data',
			);
		}
		$viewData=array_merge($viewData,$additionalViewData);
		$this->load->view("admin/transaksi/add",$viewData);
		
	}

	public function mahasiswa_select(){
		$list = $this->m_mahasiswa->getMahasiswa($_GET['search'],$_GET['page']);
		$results=Array();
		foreach($list as $item){
			array_push($results,Array('id'=>$item->mhs_id,'text'=>$item->mhs_nim." - ".$item->mhs_nama));
		}
		$final=Array();
		$final['results']=$results;
		$final['pagination']=Array("more"=>"true");
		echo json_encode($final);
	}
	public function list_pembayaran()
	{
		$list = $this->m_pembayaran->get_datatables();
		$returnData=Array();
		$returnData['draw']=$_POST['draw'];
		$returnData['recordsTotal']=$this->m_pembayaran->count_all();
		$returnData['recordsFiltered']=$this->m_pembayaran->count_filtered();
		$returnData['data']=Array();
		$no=1;
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = date("Y-m-d",strtotime($field->pmb_waktu));
            $row[] = $field->mhs_nim;
            $row[] = $field->mhs_nama;
            $row[] = $field->pmb_jenis;
            $row[] = $field->pmb_semester;
            $row[] = number_format($field->pmb_nominal,0,",",".");
 
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

	public function ajaxTanggungan(){
		$mhs_id=$_GET['mahasiswa'];
		$jenis=$_GET['jenis'];
		$semester=$_GET['semester'];
		$result=Array();
		$tanggungan=$this->m_pembayaran->getTanggungan($mhs_id,$jenis,$semester);
		$terbayar=$this->m_pembayaran->getTerbayar($mhs_id,$jenis,$semester);
		if($tanggungan){
			$result['textBiaya']=number_format($tanggungan,0,',','.');
			$result['textTanggungan']=number_format(($tanggungan-$terbayar),0,',','.');"";
			$result['biaya']=$tanggungan;
			$result['tanggungan']=$tanggungan-$terbayar;
		}else{
			$result['textBiaya']="Tanggungan biaya belum ditentukan";
			$result['textTanggungan']="Tanggungan biaya belum ditentukan";
			$result['biaya']=0;
			$result['tanggungan']=0;
		}
		$result['textTerbayar']=number_format($terbayar,0,',','.');
		echo json_encode($result);
	}
}