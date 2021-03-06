<?php 

class M_pembayaran extends CI_Model{	
    private $table="pembayaran";
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
        return $this->db->insert($this->table,$data);
    }

    function savePembayaran($data_pembayaran){
        $this->db->insert($this->table, $data_pembayaran);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
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