<?php

class Overview extends CI_Controller {
	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index()
	{
        // load view admin/overview.php
        $this->load->view("admin/overview");
	}
}