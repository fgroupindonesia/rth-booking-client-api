<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	
	function __construct() {
		parent::__construct();
		$this->load->model('SettingsModel');
		
	}
	
	public function update(){
		
		$auto 		= $this->input->post('auto_accept');
		$holiday 	= $this->input->post('holiday');
		
		$endResult = $this->SettingsModel->edit($auto, $holiday);
		
		echo json_encode($endResult);
		
	}
	
	
	
	public function all(){
		
		$endResult = $this->SettingsModel->getAll();
		//echo "A";
		echo json_encode($endResult);
		
	}
	
}
