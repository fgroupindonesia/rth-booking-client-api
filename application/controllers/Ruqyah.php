<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruqyah extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('RuqyahModel');
	
		$this->nocache();
		
	}
	
	private function nocache(){
		header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
	}
	
	public function test(){
		echo "X-ruqyah";
	}
	
	public function add(){
		
		// status 1 enabled
		// status 0 disable
		
		$date_chosen 		= $this->input->post('date_chosen');
		$status 			= $this->input->post('status');
		$gender_therapist 	= $this->input->post('gender_therapist');
		
		$endRespond = $this->RuqyahModel->add($date_chosen, $status, $gender_therapist);
		
		echo json_encode($endRespond);
		//echo var_dump($date_chosen);

	}
	
	
	// get the ruqyah status for specific date based on 'gender_therapist'
	public function check(){
		
		// gender_therapist is either one of these
		// 1 : male
		// 2 : female
		
		$date_chosen 		= $this->input->post('date_chosen');
		$gender_therapist 	= $this->input->post('gender_therapist');
		
		$endRespond = $this->RuqyahModel->get($date_chosen, $gender_therapist);
		
		echo json_encode($endRespond);
			
	}
	
	public function all(){
		
		// m Year is actually 
		// 'february 2022' format	
	$mYear = $this->input->post('month_year');
	$genderNa = $this->input->post('gender_therapist');
		
	$endRespond 	=	$this->RuqyahModel->getAll($mYear, $genderNa);
	echo json_encode($endRespond);
		
	}
	
}
