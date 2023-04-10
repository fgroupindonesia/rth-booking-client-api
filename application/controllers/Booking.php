<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('BookingRequestModel');
		$this->load->model('ScheduleModel');
	}
	
	public function index()
	{
		$this->load->view('booking');
	}
	
	// this is Administrator Access
	public function admin(){
		$this->load->view('booking-admin-ui');
	}
	
	private function escapedString($val){
		
		$db = get_instance()->db->conn_id;
		$val = mysqli_real_escape_string($db, $val);
		return $val;
	}
	
	public function add(){
		
		$usernameIn 	= $this->input->post('username');
		$code 			= $this->input->post('code');
		$treatment		= $this->input->post('treatment');
		$gender			= $this->input->post('gender');
		
		// make it as string
		$treatment = json_encode($treatment);
		// and make it applicable for non-injection SQL attack
		$treatment = $this->escapedString($treatment);
		
		$sdate 			= $this->input->post('schedule_date');
		$status			= "pending";
		
		// treatment is json data
		// ------------------------------
		// {tindakan_umum: 1, bekam: 0, elektrik : 1, lintah : 0,
		// fashdu : 0, pijat : 1, ruqyah : 1}
		
		// overall there are 5 status:
		// a. pending
		// b. completed
		// c. cancelled
		// d. changed
		// e. approved
		
		$endRespond 	=	$this->BookingRequestModel->add($code, $treatment, $sdate, $usernameIn, $status, $gender);
		
		echo json_encode($endRespond);
		
	}
	
	// this is for ADMIN & CLIENT
	public function all(){
		
		
	$username 			= $this->input->post('username');
	$includeFamily = $this->input->post('family');
	
	if(!isset($includeFamily)){
		$includeFamily = false;
	}
	
	
	// either for CLIENT 
	if(isset($username)){
		$endRespond 	=	$this->BookingRequestModel->getAllSpecific($username, $includeFamily);	
	
	// or for ADMIN
	}else {	
	
		$endRespond 	=	$this->BookingRequestModel->getAll();
	
	}
	
	echo json_encode($endRespond);
		
	}
	
	public function detail(){
		
		$code 			= $this->input->post('id');
		
		$endResult = $this->BookingRequestModel->getSpecific($code);
		
		echo json_encode($endResult);
		
	}
	
	public function edit(){
		
		$code 			= $this->input->post('code');
		$id 			= $this->input->post('id');
		$status			= $this->input->post('status');
		
		$gender			= $this->input->post('gender');
		
		$date			= $this->input->post('date');
		$hour			= $this->input->post('hour');
		
		$code 			= $this->input->post('code');
		
		// previously we choose to update by code
		// but now we choose only by id
		$endRespond 	=	$this->BookingRequestModel->update($id, $status);
		
		if($endRespond['status']='valid'){
			
			$statAvailable = 0;
			
			if($status == 'approved'){
				$statAvailable = 1;
			}
			
			$endRespond = $this->ScheduleModel->updateIfAny($code, $date, $hour, $statAvailable, $gender);
		}
		
		echo json_encode($endRespond);
		
	}
	
	public function delete(){
		
		$code 			= $this->input->post('code');
		
		$endRespond 	=	$this->BookingRequestModel->delete($code);
		echo json_encode($endRespond);
		
	}
	
}
