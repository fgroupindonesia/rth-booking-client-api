<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookingRequestModel extends CI_Model {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		
	}
	
	// status whether it is 'valid' or 'invalid'
	public function generateRespond($statusIn){
		
		$stat = array(
			'status' => $statusIn
		);
		
		return $stat;
	}
	
	public function add($code, $treatment, $schedule_date,
			 $username, $status){
		
		$endResult = $this->generateRespond('invalid');
		
		$dateNow = date('Y-m-d H:i:s');
		
		$data = array(
			'code' 				=> $code,
			'treatment' 		=> $treatment,
			'schedule_date' 	=> $schedule_date,
			'username' 			=> $username,
			'status' 			=> $status,
			'created_date'		=> $dateNow
		);
		
		$foundInDB = $this->checkDuplicates('rth_booking_request',$username, $schedule_date);
		
		if($foundInDB != true){
			$this->db->insert('rth_booking_request', $data);
			$endResult['status'] = 'valid';
		}
		
		
		return $endResult;
	}
	
	public function delete($code){
		
		$endResult = $this->generateRespond('invalid');
		
		$whereComp = array(
			'code' => $code
		);
		
		$this->db->where($whereComp);
		$this->db->delete('rth_booking_request');
		
		if($this->db->affected_rows() > 0){
				$endResult['status'] = 'valid';
		}
		
		return $endResult;
	}
	
	public function update($code, $status){
		
		$stat = 'invalid';
		
		$data = array(
			'status' 			=> $status
		);
		
		$this->db->where('code', $code);
		$this->db->update('rth_booking_request', $data);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
		
	
	public function checkDuplicates($table, $usernameIn, $sdate){
		
		$duplicate = false;
		
		$checker = array(
			'username' => $usernameIn,
			'schedule_date' => $sdate
		);
		
		
		$query = $this->db->get_where($table, $checker);
		
		foreach ($query->result() as $row)
		{
			$duplicate = true;
			break;
		}
		
		return $duplicate;
	}
	
	function reverse_mysqli_real_escape_string($str) {
		return strtr($str, [
			'\0'   => "\x00",
			'\n'   => "\n",
			'\r'   => "\r",
			'\\\\' => "\\",
			"\'"   => "'",
			'\"'   => '"',
			'\Z' => "\x1a"
		]);
 }
	
	public function getAll(){
		
		$endResult = $this->generateRespond('invalid');
		
		$query = $this->db->get('rth_booking_request');
		
		foreach ($query->result() as $row)
		{
			$endResult['status'] = 'valid';
			
			// we clear everything so it's safer to be consumed by
			// the next generation
			$dataTreatment = $this->reverse_mysqli_real_escape_string($row->treatment);
			$dataTreatment = stripslashes($dataTreatment);
			$dataTreatment = json_decode($dataTreatment);
			
			
			$data = array(
				'id' 			=> $row->id,
				'code' 			=> $row->code,
				'treatment' 	=> $dataTreatment,
				'schedule_date' => $row->schedule_date,
				'username' 		=> $row->username,
				'status' 		=> $row->status,
				'created_date' 	=> $row->created_date,
				'modified_date' 	=> $row->modified_date
			);
			
			$endResult['multi_data'][] = $data;
		}
		
		if($endResult['status'] == 'invalid'){
			unset($endResult['multi_data']);
		}
		
		return $endResult;
		
	}
	
	
	public function getAllSpecific($usernameIn){
		
		$endResult = $this->generateRespond('invalid');
		
		$checker = array(
			'username' => $usernameIn
		);
		
		$query = $this->db->get_where('rth_booking_request', $checker);
		
		foreach ($query->result() as $row)
		{
			$endResult['status'] = 'valid';
			
			// we clear everything so it's safer to be consumed by
			// the next generation
			$dataTreatment = $this->reverse_mysqli_real_escape_string($row->treatment);
			$dataTreatment = stripslashes($dataTreatment);
			$dataTreatment = json_decode($dataTreatment);
			
			
			$data = array(
				'id' 			=> $row->id,
				'code' 			=> $row->code,
				'treatment' 	=> $dataTreatment,
				'schedule_date' => $row->schedule_date,
				'username' 		=> $row->username,
				'status' 		=> $row->status,
				'created_date' 	=> $row->created_date,
				'modified_date' 	=> $row->modified_date
			);
			
			$endResult['multi_data'][] = $data;
		}
		
		if($endResult['status'] == 'invalid'){
			unset($endResult['multi_data']);
		}
		
		return $endResult;
		
	}
	
	
}