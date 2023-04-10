<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FamilyUserModel extends CI_Model {

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
	
	private function getGenderByFullname($byFullname){
		
		// default is female 0
		$hasil = 0;
		
		$multiParam = array(
			'full_name' => $byFullname
		);
		
		$this->db->where($multiParam);		
		$query = $this->db->get('rth_users');
		
		foreach ($query->result() as $row)
		{
			$hasil = $row->gender;
		}
		
		return $hasil;
	}
	
	public function getAll($byUsername){
		
		$endResult = $this->generateRespond('invalid');
		
		$multiParam = array(
			'username_incharge' => $byUsername
		);
		
		$this->db->where($multiParam);		
		$query = $this->db->get('rth_family_users');
		
		foreach ($query->result() as $row)
		{
			$endResult['status'] = 'valid';
			
			$genderNa = $this->getGenderByFullname($row->full_name);
			
			$data = array(
				'id' 				=> $row->id,
				'full_name' 		=> $row->full_name,
				'gender'			=> $genderNa,
				'username_incharge' => $row->username_incharge,
				'rel_connection' 	=> $row->rel_connection,
				'created_date' 		=> $row->created_date
			);
			
			
			$endResult['multi_data'][] = $data;
		}
		
		if($endResult['status'] == 'invalid'){
			unset($endResult['multi_data']);
		}
		
		return $endResult;
		
	}
	
	
	public function delete($idNa){
		
		$endResult = $this->generateRespond('invalid');
		
		$whereComp = array(
			'id' => $idNa
		);
		
		$this->db->where($whereComp);
		$this->db->delete('rth_family_users');
		
		if($this->db->affected_rows() > 0){
				$endResult = $this->generateRespond('valid');
		}
		
		return $endResult;
	}
	
	public function add($fullname, $username, $relation){
		
		$stat = 'invalid';
		
		$data = array(
			'full_name' 		=> $fullname,
			'username_incharge' => $username,
			'rel_connection' 	=> $relation
		);
		
		$foundInDB = $this->checkDuplicates('rth_family_users','full_name', $fullname);
		
		if($foundInDB != true){
			$this->db->insert('rth_family_users', $data);
			$stat = 'valid';
		}
		
		
		return $this->generateRespond($stat);
	}
	
	
	public function checkDuplicates($table, $col, $val){
		
		$duplicate = false;
		
		$checker = array(
			$col => $val
		);
		
		
		$query = $this->db->get_where($table, $checker);
		
		foreach ($query->result() as $row)
		{
			$duplicate = true;
			break;
		}
		
		return $duplicate;
	}
	
	
	
	
	
}