<?php 

class M_tanggungan extends CI_Model{	
    private $table="tanggungan";
    var $column_order = array('pmb_waktu','mhs_nim','mhs_nama','pmb_jenis','pmb_semester','pmb_nominal'); //field yang ada di table user
    var $column_search = array('mhs_nama','pmb_jenis','mhs_nim'); //field yang diizin untuk pencarian 
    var $order = array('pmb_waktu' => 'desc'); // default order 
	function add($data){
		return $this->db->insert($this->table,$data);
    }
    
    function getJenis(){
        return $this->db->get("jenis")->result();
    }

    function getData(){
        return $this->db->get($this->table,$data);
    }

    function saveTanggungan($data_tanggungan){
        $this->db->insert($this->table, $data_tanggungan);
        $insert_id = $this->db->insert_id();
    
        return  $insert_id;
    }
    function updateTanggungan($id,$data_tanggungan){
        $this->db->where('tgg_id',$id);
        $this->db->update($this->table, $data_tanggungan);
        return  $id;
    }

    public function getTanggunganCek($mhs_id,$jenis,$semester){
        $this->db->from('tanggungan');
        $this->db->where('mhs_id',$mhs_id);
        $this->db->where('tgg_jenis',$jenis);
        $this->db->where('tgg_semester',$semester);
        $query=$this->db->get();
        if($query->num_rows()>=1){
            //tanggungan sudah ditentukan
            return $query->row();
        }else{
            //tanggungan belum ditentukan
            return false;
        }
    }
    public function getTanggunganFull(){
        $mahasiswa=$this->db->from('mahasiswa')->where('mhs_deleted',0)->get()->result();
        $data=Array();
        $cols=Array(
            "SPP_1", "SPP_2", "SPP_3", "SPP_4", "SPP_5", "SPP_6", "SPP_7", "SPP_8", "SPP_9", "SPP_10", 
            "UAS_1", "UAS_2", "UAS_3", "UAS_4", "UAS_5", "UAS_6", "UAS_7", "UAS_8", "UAS_9", "UAS_10", 
            "UTS_1", "UTS_2", "UTS_3", "UTS_4", "UTS_5", "UTS_6", "UTS_7", "UTS_8", "UTS_9", "UTS_10", 
            "HER_1", "HER_2", "HER_3", "HER_4", "HER_5", "HER_6", "HER_7", "HER_8", "HER_9", "HER_10", 
            "HER", "OPSPEK", "UG", "KKN", "SKRIPSI", "WISUDA"
        );
        foreach($mahasiswa as $mhs){
            $pmb=$this->db->from('pembayaran')
                    ->select(Array('sum(pmb_nominal) as pmb_nominal', 'max(mhs_id) as mhs_id','pmb_jenis','pmb_semester'))
                    ->group_by(Array('pmb_semester','pmb_jenis'))
                    ->where('mhs_id',$mhs->mhs_id)
                    ->where('pmb_deleted',0)
                    ->get()->result_array();
            $tgg=$this->db->from('tanggungan')
                    ->select(Array('tgg_nominal', 'mhs_id','tgg_jenis','tgg_semester'))
                    // ->group_by(Array('pmb_semester','pmb_jenis'))
                    ->where('mhs_id',$mhs->mhs_id)
                    ->where('tgg_deleted',0)
                    ->get()->result_array();
            $data[$mhs->mhs_id]=Array(
                'mhs_id'=>$mhs->mhs_id,
                'mhs_nim'=>$mhs->mhs_nim,
                'mhs_nama'=>$mhs->mhs_nama,
                'pembayaran'=>$pmb,
                'tanggungan'=>$tgg
            );
        }
        return $data;
        $this->db->select('mhs_id','tgg_semester','');
        $this->db->from('tanggungan');
        $this->db->join('pembayaran');

        $this->db->where('mhs_id',$mhs_id);
        $this->db->where('tgg_jenis',$jenis);
        $this->db->where('tgg_semester',$semester);
        $query=$this->db->get();
        if($query->num_rows()>=1){
            //tanggungan sudah ditentukan
            return $query->row();
        }else{
            //tanggungan belum ditentukan
            return false;
        }
    }

    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
        $this->db->join('mahasiswa','mhs_id');
        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getTanggungan($mhs_id,$jenis,$semester){
        $this->db->from('tanggungan');
        $this->db->where('mhs_id',$mhs_id);
        $this->db->where('tgg_jenis',$jenis);
        $this->db->where('tgg_semester',$semester);
        $query=$this->db->get();
        if($query->num_rows()>=1){
            //tanggungan sudah ditentukan
            return $query->row()->tgg_nominal;
        }else{
            //tanggungan belum ditentukan
            return false;
        }
    }
    public function getTanggunganMahasiswa($mhs_id){
        $this->db->from('tanggungan');
        $this->db->where('mhs_id',$mhs_id);
        $this->db->where('tgg_deleted',0);
        $query=$this->db->get();
        if($query->num_rows()>=1){
            //tanggungan sudah ditentukan
            return $query->result_array();
        }else{
            //tanggungan belum ditentukan
            return false;
        }
    }
    public function getTerbayar($mhs_id,$jenis,$semester){
        $this->db->from('pembayaran');
        $this->db->select('sum(pmb_nominal) as total_terbayar');
        $this->db->where('mhs_id',$mhs_id);
        $this->db->where('pmb_jenis',$jenis);
        $this->db->where('pmb_semester',$semester);
        $query=$this->db->get();
        if($query->num_rows()>=1){
            //tanggungan sudah ditentukan
            return $query->row()->total_terbayar;
        }else{
            //tanggungan belum ditentukan
            return false;
        }
    }
}