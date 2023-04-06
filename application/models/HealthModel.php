<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HealthModel extends CI_Model {

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
	
	public function add_common($keluhan, $smoking, $rawat_inap,
			 $obat_bius, $tbc, $kanker, $jantung, $stroke, $anjurandok, $username){
		
		$stat = 'invalid';
		
		$data = array(
			'keluhan' 		=> $keluhan,
			'smoking' 		=> $smoking,
			'rawat_inap' 	=> $rawat_inap,
			'obat_bius' 	=> $obat_bius,
			'tbc' 			=> $tbc,
			'kanker'		=> $kanker,
			'jantung'		=> $jantung,
			'stroke' 		=> $stroke,
			'anjuran_dokter_terapis' => $anjurandok,
			'username' 		=> $username
		);
		
		$foundInDB = $this->checkDuplicates('rth_health_common',$username);
		
		if($foundInDB != true){
			$this->db->insert('rth_health_common', $data);
			$stat = 'valid';
		}
		
		
		return $this->generateRespond($stat);
	}
	
	
	public function add_special($ritual, $tenaga, $mimpi,
			 $kunjungan, $ghaib, $username){
		
		$stat = 'invalid';
		
		$data = array(
			'ritual' 		=> $ritual,
			'tenaga' 		=> $tenaga,
			'mimpi' 		=> $mimpi,
			'kunjungan' 	=> $kunjungan,
			'ghaib' 		=> $ghaib,
			'username'		=> $username
		);
		
		$foundInDB = $this->checkDuplicates('rth_health_special',$username);
		
		if($foundInDB != true){
			$this->db->insert('rth_health_special', $data);
			$stat = 'valid';
		}
		
		
		return $this->generateRespond($stat);
	}
	
		
	
	public function checkDuplicates($table, $usernameIn){
		
		$duplicate = false;
		
		$checker = array(
			'username' => $usernameIn
		);
		
		
		$query = $this->db->get_where($table, $checker);
		
		foreach ($query->result() as $row)
		{
			$duplicate = true;
			break;
		}
		
		return $duplicate;
	}
	
	
	public function delete($usernameIn){
		
		// this will eventually deleting from both table
		// rth_health_common and also rth_health_special
		$endResult = $this->generateRespond('invalid');
		
		$whereComp = array(
			'username' => $usernameIn
		);
		
			$a = $this->deleteFrom('rth_health_common', $whereComp);
			$b = $this->deleteFrom('rth_health_special', $whereComp);
		
		if($a['status'] == $b['status']){
				$endResult = $this->generateRespond('valid');
		}
		
		return $endResult;
		
		
	}
	
	public function deleteFrom($table, $whereComp){
		
		// this will eventually deleting from both table
		// rth_health_common and also rth_health_special
		
		$endResult = $this->generateRespond('invalid');
		
		
		$this->db->where($whereComp);
		$this->db->delete($table);
		
		if($this->db->affected_rows() > 0){
				$endResult = $this->generateRespond('valid');
		}
		
		return $endResult;
		
		
	}
	
	
}