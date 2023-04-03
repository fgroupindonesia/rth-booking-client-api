<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RuqyahModel extends CI_Model {

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
	
	public function add($date_chosen, $status, $gender_therapist){
		
		$stat = 'valid';
		
		$data = array(
				'date_chosen' 		=> $date_chosen,
				'status' 			=> $status,
				'gender_therapist' 	=> $gender_therapist
		);
		
		$dobel = $this->isDuplicate($date_chosen, $gender_therapist);
		if(!$dobel){
		
			$this->db->insert('rth_ruqyah', $data);
		
			
			// grab the id returned
			$insert_id = $this->db->insert_id();
			$data['id'] = $insert_id;
			
			// we returned the data back to client 
			// with a complete same data along with its new id
			$endResult['multi_data'] = $data;
	
		}else{
			// because it has the same date & gender
			// so we do updates
			$data1 = $this->get($date_chosen, $gender_therapist);
			$nomerID = $data1['multi_data']['id'];
			$data1['multi_data']['status'] = $status;
			
			// we do updating in db
			$this->edit($nomerID, $date_chosen, $status, $gender_therapist);
			// and we returned back the updated data along with its id
			$endResult['multi_data'] = $data1;
		}	
		
		$endResult['status'] = $stat;
			
			
		return $endResult;
	}
	
	public function isDuplicate($date_chosen, $gender_therapist){
		
		$stat = 'invalid';
		
		$data = array(
				'date_chosen' 		=> $date_chosen,
				'gender_therapist' 	=> $gender_therapist
		);
	
		$duplikat = false;
		$this->db->where($data);
		$query = $this->db->get('rth_ruqyah');
		
		foreach ($query->result() as $row)
		{
			$duplikat = true;
			break;	
		}
		
		
		return $duplikat;
		
	}
	
	public function edit($id, $date_chosen, $status, $gender_therapist){
		
		$stat = 'invalid';
		
		$data = array(
				'date_chosen' 		=> $date_chosen,
				'status' 			=> $status,
				'gender_therapist' 	=> $gender_therapist
		);
	
		
		$this->db->where('id', $id);
		$this->db->update('rth_ruqyah', $data);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
		
	
	// get several data from specific date & gender
	public function get($date_chosen, $gender_therapist){
		
		$endResult = $this->generateRespond('invalid');
		
		$filterData = array(
			'date_chosen' 		=> $date_chosen,
			'gender_therapist' 	=> $gender_therapist
		);
		
		$this->db->where($filterData);
		$query = $this->db->get('rth_ruqyah');
		
		foreach ($query->result() as $row)
		{
			$endResult['status'] = 'valid';
			
			$data = array(
				'id' 				=> $row->id,
				'date_chosen' 		=> $row->date_chosen,
				'status' 			=> $row->status,
				'gender_therapist' 	=> $row->gender_therapist
			);
			
			$endResult['multi_data'] = $data;
		}
		
		
		return $endResult;
		
	}
	
	public function monthIntoNumber($mYear){
		
		// m Year is actually 
		// 'february 2022' format
		return date('m', strtotime($mYear));
		
	}
	
	public function getAll($mYear, $gender){
		
		$endResult = $this->generateRespond('invalid');
		
		$this->db->where('gender_therapist', $gender);
		$query = $this->db->get('rth_ruqyah');
		
		//echo $mYear; is actually 'february 2002' format
		
		$mNumber = $this->monthIntoNumber($mYear);
		$genderKetemu = false;
		
		foreach ($query->result() as $row)
		{
		
		$genderKetemu = true;
			
			$data = array(
				'id' 				=> $row->id,
				'date_chosen' 		=> $row->date_chosen,
				'status' 			=> $row->status,
				'gender_therapist' 	=> $row->gender_therapist
			);
			
			// date_chosen is actually yyyy-mm-dd format
			// but then we split the numeric only
			$bulan = (int) explode('-', $data['date_chosen'])[1];
			
			if(($bulan==$mNumber) && ($genderKetemu)){
			
			$endResult['multi_data'][] = $data;
			$endResult['status'] = 'valid';
			
			}
		}
		
		
		return $endResult;
		
	}
	
}