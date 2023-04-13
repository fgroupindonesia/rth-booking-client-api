<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingsModel extends CI_Model {

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
	
	public function add($auto, $holiday){
		
	
		$data = array(
			'auto_accept' 	=> $auto,
			'holiday'	=> $holiday
		);
		
		$this->db->insert('rth_settings', $data);
		
		$stat = 'valid';
		
		return $this->generateRespond($stat);
	}
	
	public function edit($auto, $holiday){
		
		$stat = 'invalid';
		
		$data = array(
			'auto_accept' 	=> $auto,
			'holiday'	=> $holiday
		);
		
		$this->db->update('rth_settings', $data);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
	
	
	public function getAll(){
		
		//$endResult['status'] = "a";
		$endResult = $this->generateRespond('invalid');
		
		$query = $this->db->get('rth_settings');
		
		foreach ($query->result() as $row)
		{
			$endResult['status'] = 'valid';
			
			$data = array(
				'auto_accept' 		=> $row->auto_accept,
				'holiday'			=> $row->holiday
			);
			
			$endResult['multi_data'] = $data;
		}
		
		if($endResult['status'] == 'invalid'){
			unset($endResult['multi_data']);
		}
		
		return $endResult;
		
	}
	
	public function default(){
		
		$endResult = $this->generateRespond('invalid');
		
		$data = array(
			'auto_accept' 	=> 0,
			'holiday'	=> 0
		);
		
		$this->db->update('rth_settings', $data);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
	
	
}