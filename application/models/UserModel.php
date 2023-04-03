<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

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
	
	public function add($username, $pass, $email, $home_address, $contact, $full_name, $alive, $membership, $gender, $propicIn){
		
		$stat = 'invalid';
		
		$data = array(
			'username' 	=> $username,
			'home_address' 		=> $home_address,
			'contact' 	=> $contact,
			'email' 	=> $email,
			'pass' 	=> $pass,
			'full_name'	=> $full_name,
			'propic'	=> $propicIn,
			'alive' => $alive,
			'gender' => $gender,
			'membership' => $membership
		);
		
		$foundInDB = $this->checkDuplicates($email, $username);
		
		if($foundInDB != true){
			$this->db->insert('rth_users', $data);
			$stat = 'valid';
		}
		
		if($propicIn != 'default.png' && $foundInDB == true){
			// when we found duplicate entry in DB
			// but then we want to cancel the uploaded picture earlier
			// thus we delete 'em first
			
			$this->deletePropicIfExist($propicIn);
			
		}
		
		return $this->generateRespond($stat);
	}
	
	public function edit($id, $username, $pass, $email, $home_address, $contact, $full_name, $propic, $membership, $gender){
		
		$stat = 'invalid';
		
		$data = array(
			'username' 	=> $username,
			'pass' 		=> $pass,
			'email' 	=> $email,
			'home_address' 	=> $home_address,
			'contact' 	=> $contact,
			'membership' 	=> $membership,
			'gender' 	=> $gender,
			'full_name'	=> $full_name
		);
		
		if(isset($propicIn)){
			// if the propic has a name
			// then we use that one otherwise we will not touch this part
			$data['propic']	= $propic;
		}
		
		
		$this->db->where('id', $id);
		$this->db->update('rth_users', $data);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
		
	
	public function checkDuplicates($emailIn, $usernameIn){
		
		$duplicate = false;
		
		$checker = array(
			'email' => $emailIn
		);
		
		
		$query = $this->db->get_where('rth_users', $checker);
		
		foreach ($query->result() as $row)
		{
			$duplicate = true;
			break;
		}
		
		// if the email isnot duplicate
		// we checked once more on username
		if(!$duplicate){
		
		$checker = array(
			'username' => $usernameIn
		);
		
		$query = $this->db->get_where('rth_users', $checker);
		
		foreach ($query->result() as $row)
		{
			$duplicate = true;
		}
		
		}
		
		return $duplicate;
	}
	
	public function deletePropicIfExist($filename){
		
		// we just delete the item if want to cancel
		// due to the duplication entries
		$path = $_SERVER['DOCUMENT_ROOT'].'/images/propic/' . $filename;
		
		unlink($path);
		
	}
	
	private function getData($row){
		$data = array(
				'id' 			=> $row->id,
				'username' 		=> $row->username,
				'pass' 			=> $row->pass,
				'email' 		=> $row->email,
				'home_address' 		=> $row->home_address,
				'propic' 		=> $row->propic,
				'contact' 		=> $row->contact,				
				'membership' 		=> $row->membership,
				'full_name' 		=> $row->full_name,
				'gender' 	=> $row->gender
			);
		
		return $data;
	}
	
	public function emailExist($email){
		
		$endResult = $this->generateRespond('invalid');
		
		$multiParam1 = array(
			'email' => $email
		);
		
			$this->db->where($multiParam1);		
			$query = $this->db->get('rth_users');
			
			foreach ($query->result() as $row)
			{
				$endResult['status'] = 'valid';
			}
		
		return $endResult;
		
	}
	
	public function verify($username, $pass, $cp){
		
		$endResult = $this->generateRespond('invalid');
		
		$multiParam1 = array(
			'username' => $username,
			'pass' => $pass
		);
		
		$multiParam2 = array(
			'contact' => $cp,
			'pass' => $pass
		);
		
		$checkDone = false;
		
		$this->db->where($multiParam1);		
		$query = $this->db->get('rth_users');
		
		foreach ($query->result() as $row)
		{
			$endResult['status'] = 'valid';
			$endResult['multi_data'] = $this->getData($row);
			$checkDone = true;
		}
		
		if(!$checkDone){
			// if checking needs to be done once more
			$this->db->where($multiParam2);		
			$query = $this->db->get('rth_users');
			
			foreach ($query->result() as $row)
			{
				$endResult['status'] = 'valid';
				$endResult['multi_data'] = $this->getData($row);
				$checkDone = true;
			}
		}
		
		return $endResult;
		
	}
	
	public function verifyAsAdmin($username, $pass, $cp){
		
		$endResult = $this->generateRespond('invalid');
		
		$multiParam1 = array(
			'username' => $username,
			'pass' => $pass,
			'membership' => 2
		);
		
		// Membership of 2 is ADMIN
		
		$multiParam2 = array(
			'contact' => $cp,
			'pass' => $pass,
			'membership' => 2
		);
		
		$checkDone = false;
		
		$this->db->where($multiParam1);		
		$query = $this->db->get('rth_users');
		
		foreach ($query->result() as $row)
		{
			$endResult['status'] = 'valid';
			$endResult['multi_data'] = $this->getData($row);
			$checkDone = true;
		}
		
		if(!$checkDone){
			// if checking needs to be done once more
			$this->db->where($multiParam2);		
			$query = $this->db->get('rth_users');
			
			foreach ($query->result() as $row)
			{
				$endResult['status'] = 'valid';
				$endResult['multi_data'] = $this->getData($row);
				$checkDone = true;
			}
		}
		
		return $endResult;
		
	}
	
	public function getAll(){
		
		$endResult = $this->generateRespond('invalid');
		
		$query = $this->db->get('rth_users');
		
		foreach ($query->result() as $row)
		{
			$endResult['status'] = 'valid';
			
			$data = array(
				'id' 			=> $row->id,
				'username' 		=> $row->username,
				'pass' 			=> $row->pass,
				'email' 		=> $row->email,
				'home_address' 		=> $row->home_address,
				'propic' 		=> $row->propic,
				'contact' 		=> $row->contact,
				'membership' 		=> $row->membership,
				'full_name' 		=> $row->full_name,
				'gender' 	=> $row->gender
			);
			
			// grab all data except for admin
			if($row->username != 'admin')
			$endResult['multi_data'][] = $data;
		}
		
		if($endResult['status'] == 'invalid'){
			unset($endResult['multi_data']);
		}
		
		return $endResult;
		
	}
	
	public function delete($usernameIn){
		
		$endResult = $this->generateRespond('invalid');
		
		$whereComp = array(
			'username' => $usernameIn
		);
		
		$this->db->where($whereComp);
		$this->db->delete('data_user');
		
		if($this->db->affected_rows() > 0){
				$endResult = $this->generateRespond('valid');
		}
		
		return $endResult;
	}
	
	public function deletePicture($idIn){
		
		$stat = 'invalid';
		
		$whereComp = array(
			'id' => $idIn
		);
		
		$this->db->where($whereComp);		
		$query = $this->db->get('data_user');
		
		foreach ($query->result() as $row)
		{
			
			$filename =	$row->propic;
		
		}
		// delete the real file on server side
		
		unlink('images/propic/'.$filename);
		
		$newData = array(
			'propic' => 'default.png'
		);
		
		$this->db->where($whereComp);
		$this->db->update('data_user', $newData);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
	}	
	
	public function getProfile($idIn){
		
		$endResult = $this->generateRespond('invalid');
		
		$multiParam = array(
			'id' => $idIn
		);
		
		$this->db->where($multiParam);		
	
		$query = $this->db->get('rth_users');
		
		foreach ($query->result() as $row)
		{
			$endResult['status'] = 'valid';
			
				$data = array(
				'id' 			=> $row->id,
				'username' 		=> $row->username,
				'pass' 			=> $row->pass,
				'email' 		=> $row->email,
				'home_address' 		=> $row->home_address,
				'propic' 		=> $row->propic,
				'contact' 		=> $row->contact,
				'membership' 		=> $row->membership,
				'full_name' 		=> $row->full_name,
				'gender' 	=> $row->gender
			);
			
			$endResult['multi_data'] = $data;
		}
		
		
		
		if($endResult['status'] == 'invalid'){
			unset($endResult['multi_data']);
		}
		
		return $endResult;
		
	}
	
}