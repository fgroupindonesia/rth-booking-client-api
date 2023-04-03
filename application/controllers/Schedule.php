<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('ScheduleModel');
	}
	
	public function test(){
		echo "X";
	}
	
	public function add(){
		
		$date_chosen 		= $this->input->post('date_chosen');
		$specific_hour 		= $this->input->post('specific_hour');
		$status 			= $this->input->post('status');
		$desc 			= $this->input->post('description');
		$gender_therapist 	= $this->input->post('gender_therapist');
		
		
		$endRespond = $this->ScheduleModel->add($date_chosen, $specific_hour, $status, $desc, $gender_therapist);
		
			echo json_encode($endRespond);
		//echo var_dump($date_chosen);

	}
	
	public function update(){
		
		$id 			= $this->input->post('id');
		$date_chosen 	= $this->input->post('date_chosen');
		$specific_hour 	= $this->input->post('specific_hour');
		$status 		= $this->input->post('status');
		$desc 			= $this->input->post('description');
		$gender_therapist 	= $this->input->post('gender_therapist');
		
		$endRespond = $this->ScheduleModel->edit($id, $date_chosen, $specific_hour, $status, $desc, $gender_therapist);
		
		echo json_encode($endRespond);
			
	}
	
	// get the schedule for specific date based on 'gender_therapist'
	public function detail(){
		
		// gender_therapist is either one of these
		// 1 : male
		// 2 : female
		
		$date_chosen 	= $this->input->post('date_chosen');
		$gender_therapist 	= $this->input->post('gender_therapist');
		
		$endRespond = $this->ScheduleModel->get($date_chosen, $gender_therapist);
		
		echo json_encode($endRespond);
			
	}
	
	// this is for ADMIN
	// with specific month if necessary
	public function all(){
		
	$mYear = $this->input->post('month_year');
	$genderNa = $this->input->post('gender_therapist');
		
	$endRespond 	=	$this->ScheduleModel->getAll($mYear, $genderNa);
	echo json_encode($endRespond);
		
	}
	
}