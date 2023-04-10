<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ScheduleModel extends CI_Model {

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
	
	public function add($date_chosen, $specific_hour, $status, $desc, $gender_therapist){
		
		$stat = 'invalid';
		
		$data = array(
				'date_chosen' 		=> $date_chosen,
				'specific_hour' 	=> $specific_hour,
				'status' 			=> $status,
				'description' 		=> $desc,
				'gender_therapist' 	=> $gender_therapist
		);
		
		$dobel = $this->isDuplicate($date_chosen, $specific_hour, $gender_therapist);
		if(!$dobel){
		
			$this->db->insert('rth_schedules', $data);
			$stat = 'valid';
			
			// grab the id returned
			$insert_id = $this->db->insert_id();
			$data['id'] = $insert_id;
			
			// we returned the data back to client 
			// with a complete same data along with its new id
			$endResult['multi_data'] = $data;
	
		}	
		
		$endResult['status'] = $stat;
			
			
		return $endResult;
	}
	
	public function isDuplicate($date_chosen, $specific_hour, $gender_therapist){
		
		$stat = 'invalid';
		
		$data = array(
				'date_chosen' 		=> $date_chosen,
				'specific_hour' 	=> $specific_hour,
				'gender_therapist' 	=> $gender_therapist
		);
	
		$duplikat = false;
		$this->db->where($data);
		$query = $this->db->get('rth_schedules');
		
		foreach ($query->result() as $row)
		{
			$duplikat = true;
			break;	
		}
		
		
		return $duplikat;
		
	}
	
	public function edit($id, $date_chosen, $specific_hour, $status, $desc, $gender_therapist){
		
		$stat = 'invalid';
		
		$data = array(
				'date_chosen' 		=> $date_chosen,
				'specific_hour' 	=> $specific_hour,
				'status' 			=> $status,
				'description' 		=> $desc,
				'gender_therapist' 	=> $gender_therapist
		);
	
		
		$this->db->where('id', $id);
		$this->db->update('rth_schedules', $data);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
	
	private function getFullname($codeBooking){
		
		$hasil = "";
		
		$this->db->where('code', $codeBooking);
		$query = $this->db->get('rth_booking_request');
		
		$username = "";
		foreach ($query->result() as $row)
		{
		
			$username = $row->username;
		
		}
		
		if(!empty($username)){
		
			$this->db->where('username', $username);
			$query = $this->db->get('rth_users');
			
			$username = "";
			foreach ($query->result() as $row)
			{
				$hasil = $row->full_name;
			}
		
		}
		
		return $hasil;
		
	}
	
	public function updateIfAny($codeBooking, $date_chosen, $specific_hour, $status, $gender_therapist){
		
		$stat = 'invalid';
		
		$namaOrang = $this->getFullname($codeBooking);
		
		$data = array(
				'status' 			=> $status,
				'description' 		=> $namaOrang
		);
		
		$multiParam = array(
			'date_chosen' => $date_chosen,
			'specific_hour' => $specific_hour,
			'gender_therapist' 	=> $gender_therapist
		);
	
		
		$this->db->where($multiParam);
		$this->db->update('rth_schedules', $data);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}else{
			 $this->add($date_chosen, $specific_hour, $status, $namaOrang, $gender_therapist);
		}
		
		return $this->generateRespond($stat);
		
	}
		
	public function monthIntoNumber($mYear){
		
		// m Year is actually 
		// 'february 2022' format
		return date('m', strtotime($mYear));
		
	}
	
	public function getAll($mYear, $gender){
		
		$endResult = $this->generateRespond('invalid');
		
		$this->db->where('gender_therapist', $gender);
		$query = $this->db->get('rth_schedules');
		
		//echo $mYear; is actually 'february 2002' format
		
		$mNumber = $this->monthIntoNumber($mYear);
		$yNumber = (int) explode(' ', $mYear)[1];
		$genderKetemu = false;
		
		foreach ($query->result() as $row)
		{
		
		$genderKetemu = true;
			
			$data = array(
				'id' 				=> $row->id,
				'date_chosen' 		=> $row->date_chosen,
				'specific_hour' 	=> $row->specific_hour,
				'status' 			=> $row->status,
				'gender_therapist' 	=> $row->gender_therapist,
				'description' 		=> $row->description,
				'date_created' 		=> $row->date_created
			);
			
			// date_chosen is actually yyyy-mm-dd format
			// but then we split the numeric only
			$bulan = (int) explode('-', $data['date_chosen'])[1];
			$tahun = (int) explode('-', $data['date_chosen'])[0];
			
			if(($bulan==$mNumber) && ($genderKetemu) && ($tahun==$yNumber) ){
			
			$endResult['multi_data'][] = $data;
			$endResult['status'] = 'valid';
			
			}
		}
		
		
		return $endResult;
		
	}
	
	// get 5 data from specific date & gender
	// because from 08", 10", 13", 16", and 20:00
	public function get($date_chosen, $gender_therapist){
		
		$endResult = $this->generateRespond('invalid');
		
		$filterData = array(
			'date_chosen' 		=> $date_chosen,
			'gender_therapist' 	=> $gender_therapist
		);
		
		$this->db->where($filterData);
		$query = $this->db->get('rth_schedules');
		
		foreach ($query->result() as $row)
		{
			$endResult['status'] = 'valid';
			
			$data = array(
				'id' 				=> $row->id,
				'date_chosen' 		=> $row->date_chosen,
				'specific_hour' 	=> $row->specific_hour,
				'status' 			=> $row->status,
				'gender_therapist' 	=> $row->gender_therapist,
				'description' 		=> $row->description,
				'date_created' 		=> $row->date_created
			);
			
			
			$endResult['multi_data'][] = $data;
		}
		
		
		return $endResult;
		
	}
	
}