<?php

class Tanggungan extends CI_Controller {
	function __construct(){
		parent::__construct();
	
		$this->load->model('m_tanggungan');
		$this->load->model('m_pembayaran');
		$this->load->model('m_user');
		$this->load->model('m_mahasiswa');
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index()
	{
		$data = Array(
			"arrJenis"=>$this->m_pembayaran->getJenis()
		);
		$this->load->view("admin/tanggungan/add",$data);
	}

	public function lihat_tanggungan()
	{
		$data = Array(
			// "arrJenis"=>$this->m_pembayaran->getJenis()
		);
		$this->load->view("admin/tanggungan/lihat",$data);
	}
	
	public function report_all()
	{
		// load view admin/mahasiswa.php
		$data=['dataTagihan'=>$this->m_tanggungan->getTanggunganFull()];
		$this->load->view("admin/tanggungan/report-all",$data);
	}
	public function report_all_csv()
	{
		// load view admin/mahasiswa.php
		$data=['dataTagihan'=>$this->m_tanggungan->getTanggunganFull()];
		$this->load->view("admin/tanggungan/report-all-csv",$data);
	}
	public function add()
	{
		// load view admin/mahasiswa.php
		$data=Array('judul'=>'Tambah Data Mahasiswa');
		$this->load->view("admin/mahasiswa/add",$data);
	}
	public function save()
	{
		$data=$_POST;
		
		if($data['pin']!=$this->config->item('pin_master')){
			echo json_encode(['status'=>'salah','message'=>'Pin anda salah.']);
			return false;
		}else{
			$mahasiswa=$data['mahasiswa'];
			$savedTanggungan=Array();
			foreach($data as $namainput=>$inputan){
				$arrinput=explode("_",$namainput);
				if(count($arrinput)>=2){
					$jenis=$arrinput[1];
					$smt=(isset($arrinput[2]))?$arrinput[2]:1;
					$val=$inputan;
					$query=Array(
						'mhs_id'=>$mahasiswa,
						'tgg_semester'=>$smt,
						'tgg_jenis'=>$jenis,
						'tgg_nominal'=>$val,
						'tgg_tahun'=>'2019',
					);
					if($val!=''){
						if($cek=$this->m_tanggungan->getTanggunganCek($mahasiswa,$jenis,$smt)){
							//kalau sudah ada
							if($id=$this->m_tanggungan->updateTanggungan($cek->tgg_id,$query)){
								$query['asu']=$id;
								$savedTanggungan[$id]=$query;
							}
						}else{
							//kalau belum ada
							if($id=$this->m_tanggungan->saveTanggungan($query)){
								$savedTanggungan[$id]=$query;
							}
						}
					}

				}
			}
			echo json_encode(['status'=>'ok','message'=>'Tanggungan disimpan.','data'=>$savedTanggungan]);
			return false;
		}

		return false;
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
	public function ajaxBiayaTanggungan(){
		$mhs_id=$_GET['mahasiswa'];
		$result=Array();
		if($tanggungan=$this->m_tanggungan->getTanggunganMahasiswa($mhs_id)){
			foreach($tanggungan as $name=>$value){
				if(in_array($value['tgg_jenis'],['SPP','UTS','UAS','HER'])){
					$result["tanggungan_".$value['tgg_jenis']."_".$value['tgg_semester'].""]=$value['tgg_nominal'];
				}else{
					$result["tanggungan_".$value['tgg_jenis'].""]=$value['tgg_nominal'];
				}
			}
			$result['status']=1;
		}else{
			$result['status']=0;
		}
		echo json_encode($result);
	}
	public function ajaxLihatTanggungan(){
		$mhs_id=$_GET['mahasiswa'];
		$result=Array();
		$ajenis=Array("SPP","UTS","UAS","HER", "OPSPEK", "UG", "KKN", "SKRIPSI", "WISUDA");
		foreach($ajenis as $jenis){
			if(in_array($jenis,['SPP','UTS','UAS','HER'])){
				for($semester=1;$semester<=10;$semester++){
					$nbayar=$this->m_pembayaran->getTerbayar($mhs_id,$jenis,$semester);
					$nbiaya=$this->m_tanggungan->getTanggungan($mhs_id,$jenis,$semester);
					$tbiaya=($nbiaya!=false)?number_format($nbiaya,0,",","."):"Belum Ditentukan";
					$tbayar=($nbayar!=false)?number_format($nbayar,0,",","."):"Belum Ditentukan";
					$tsisa=number_format($nbayar-$nbiaya,0,",",".");
					if(($nbayar-$nbiaya)==0 && $nbiaya!=0){
						$tsisa="<span style='color:green;font-weight:bold;'>LUNAS</span>";
					}
					$teks="<div class='tsp_sisa'>".$tsisa."</div><div class='tsp_tanggungan'>Biaya : ".$tbiaya."</div><div class='tsp_terbayar'>Terbayar : ".$tbayar."</div>";
					$result["tanggungan_".$jenis."_".$semester.""]=$teks;
				}
			}else{
				//pembayaran sekali
				$nbayar=$this->m_pembayaran->getTerbayar($mhs_id,$jenis,1);
				$nbiaya=$this->m_tanggungan->getTanggungan($mhs_id,$jenis,1);
				$tbiaya=number_format($nbiaya,0,",",".");
				$tbayar=number_format($nbayar,0,",",".");
				$tsisa=number_format($nbayar-$nbiaya,0,",",".");
				$teks="<div class='tsp_sisa'>".$tsisa."</div><div class='tsp_tanggungan'>Biaya : ".$tbiaya."</div><div class='tsp_terbayar'>Terbayar : ".$tbayar."</div>";
				$result["tanggungan_".$jenis.""]=$teks;
			}
		}
		$result['status']=1;
		echo json_encode($result);
	}
}