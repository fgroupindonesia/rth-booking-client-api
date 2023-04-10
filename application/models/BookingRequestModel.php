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
	
	private function getFullname($fromUsername){
		
		
		$multiParam1 = array(
			'username' => $fromUsername
		);
		
		$this->db->where($multiParam1);		
		$query = $this->db->get('rth_users');
		
		$foundData = "";
		
		foreach ($query->result() as $row)
		{
			$foundData =	$row->full_name;
		}
		
		return $foundData;
		
	}
	
	public function getSpecific($idNa){
		
		$endResult = $this->generateRespond('invalid');
		
		$multiParam1 = array(
			'id' => $idNa
		);
		
		
		$this->db->where($multiParam1);		
		$query = $this->db->get('rth_booking_request');
		
		$foundData = false;
		
		foreach ($query->result() as $row)
		{
			
			$foundData = true;
			
			$dataTr = $this->clearStrip( $row->treatment );
			
			$data = array(
				'id' => $row->id,
				'code' => $row->code,
				'treatment' => $dataTr,
				'schedule_date' => $row->schedule_date,
				'username' => $row->username,
				'full_name' => $this->getFullname($row->username),
				'status' => $row->status,
				'created_date' => $row->created_date
			);
			
			$endResult['multi_data'] = $data;
		}
		
		if($foundData){
			$endResult['status'] = 'valid';
		}
		
		return $endResult;
		
	}
	
	public function add($code, $treatment, $schedule_date,
			 $username, $status, $gender){
		
		$endResult = $this->generateRespond('invalid');
		
		$dateNow = date('Y-m-d H:i:s');
		
		$data = array(
			'code' 				=> $code,
			'gender'			=> $gender,
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
	
	public function update($id, $status){
		
		$stat = 'invalid';
		
		$data = array(
			'status' 			=> $status
		);
		
		$this->db->where('id', $id);
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
	
	private function clearStrip($data){
		// we clear everything so it's safer to be consumed by
			// the next generation
			$dt = $this->reverse_mysqli_real_escape_string($data);
			$dt = stripslashes($dt);
			$dt = json_decode($dt);
			
			return $dt;
	}
	
	public function getAll(){
		
		$endResult = $this->generateRespond('invalid');
		
		$query = $this->db->get('rth_booking_request');
		
		foreach ($query->result() as $row)
		{
			$endResult['status'] = 'valid';
			
			$dataTreatment = $this->clearStrip($row->treatment);
			
			
			$data = array(
				'id' 			=> $row->id,
				'code' 			=> $row->code,
				'gender'		=> $row->gender,
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
	
	public function getFamilyUsernames($usernameIncharge){
		
		// query first from the table family
		$checker = array(
			'username_incharge' => $usernameIncharge
		);
		
		
		$query = $this->db->get_where('rth_family_users', $checker);
		
		$fullnamesFound = array();
		$usernameFound = array();
		
		foreach ($query->result() as $row)
		{
			$fullnamesFound [] = $row->full_name;
		}
		
		$i=0;
		for($i=0; $i<count($fullnamesFound); $i++){
			
			// pick from table users
			$checker = array(
				'full_name' => $fullnamesFound[$i]
			);
			
			// pick from table users
			$query = $this->db->get_where('rth_users', $checker);
			
			foreach ($query->result() as $row)
			{
				$usernameFound [] = $row->username;
			}
			
		}
		
		
		// return back to getallspecific
		return $usernameFound;
		
	}
	
	private function getAllBooking($username){
		
		$allData = array();
		
		$checker = array(
			'username' => $username
		);
		
		$query = $this->db->get_where('rth_booking_request', $checker);
		
		foreach ($query->result() as $row)
		{
			
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
				'gender'		=> $row->gender,
				'status' 		=> $row->status,
				'created_date' 	=> $row->created_date,
				'modified_date' 	=> $row->modified_date
			);
			
			$allData [] = $data;
		}
		
		return $allData;
	}
	
	public function getAllSpecific($usernameIn, $includeFamily){
		
		$endResult = $this->generateRespond('invalid');
		
		$hasilPertama = $this->getAllBooking($usernameIn);
		$hasillBerikutnya = array();
		
		if($includeFamily){
			$listFamilyUsername = $this->getFamilyUsernames($usernameIn);
			
			for($i=0; $i<count($listFamilyUsername); $i++){
				$dataObtained = $this->getAllBooking($listFamilyUsername[$i]);
				
				for($x=0; $x<count($dataObtained); $x++){
				$hasillBerikutnya[] = $dataObtained[$x];
				}
			}
			
			// extract to hasilpertama
			for($i=0; $i<count($hasillBerikutnya); $i++){
				$hasilPertama [] = $hasillBerikutnya[$i];
			}
			
		}
		
		if(count($hasilPertama)>0){
			$endResult['status'] = 'valid';
			
			for($i=0; $i<count($hasilPertama); $i++){
				$endResult['multi_data'] [] = $hasilPertama[$i];
			}
		}
		
		if($endResult['status'] == 'invalid'){
			unset($endResult['multi_data']);
		}
		
		return $endResult;
		
	}
	
	
}