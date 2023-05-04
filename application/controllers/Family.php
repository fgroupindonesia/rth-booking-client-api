<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Family extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('FamilyUserModel');
		$this->load->model('HealthModel');
		
		$this->nocache();
		
	}
	
	private function nocache(){
		header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
	}
	
	public function index()
	{
		echo "none";
	}
	
	private function escapedString($val){
		
		$db = get_instance()->db->conn_id;
		$val = mysqli_real_escape_string($db, $val);
		return $val;
	}
	
	// this is for ADMIN & CLIENT
	public function all(){
		
	$username 			= $this->input->post('username_incharge');
	
	$endRespond 	=	$this->FamilyUserModel->getAll($username);
	
	echo json_encode($endRespond);
		
	}
	
	public function delete(){
		
		$id 			= $this->input->post('id');
		
		// special for this Family table we use full_name as the 
		// contenated string as username in the other DB tables
		$username 		= $this->input->post('full_name');
		$username = str_replace(" ","",$username);
		$username = strtolower($username);
		
		$endRespond 	=	$this->FamilyUserModel->delete($id);
		
		
		echo json_encode($endRespond);
		
	}
	
}
