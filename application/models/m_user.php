<?php 

class M_user extends CI_Model{	
    private $table="user";
    // var $column_order = array(null, 'mhs_nim','mhs_nama'); //field yang ada di table user
    // var $column_search = array('mhs_nim','mhs_nama'); //field yang diizin untuk pencarian 
    // var $order = array('mhs_nim' => 'asc'); // default order 
	function add($data){
		return $this->db->insert($this->table,$data);
    }
    
    function getSingleUser($id){
        return $this->db->get_where($this->table, array('user_id' => $id), 1, 0);
    }

    function getSingleUserFromUsername($username){
        return $this->db->get_where($this->table, array('user_username' => $username), 1, 0)->row();
    }

}