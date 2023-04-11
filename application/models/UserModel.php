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
	
	public function add($username, $pass, $email, $home_address, $contact, $full_name, $alive, $membership, $gender, $propicIn, $tokenIn){
		
		
		
		$stat = 'invalid';
		
		$createdDate = date('Y-m-d H:i:s');
		
		// we also have status:
		// 1. pending - waiting activation
		// 2. active - normal
		// 3. disabled - because problem or something else
		
		$statusUserNa = 'pending';
	
		$data = array(
			'username' 	=> $username,
			'status'	=> $statusUserNa,
			'home_address' 		=> $home_address,
			'contact' 	=> $contact,
			'email' 	=> $email,
			'pass' 	=> $pass,
			'full_name'	=> $full_name,
			'propic'	=> $propicIn,
			'alive' => $alive,
			'gender' => $gender,
			'token'	=> $tokenIn,
			'membership' => $membership,
			'created_date' => $createdDate
		);
		
		if(!empty($email)){
			$foundInDB = $this->checkDuplicates($username);
		}else{
			$foundInDB = false;
		}
		
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
	
	public function edit($id, $username, $pass, $email, $home_address, $contact, $full_name, $propic, $membership, $gender, $status){
		
		$stat = 'invalid';
		
		$data = array(
			'username' 	=> $username,
			'pass' 		=> $pass,
			'status'	=> $status,
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
	
	public function updatePassword($pass, $token){
		
		$stat = 'invalid';
		
		$data = array(
			'pass' 		=> $pass,
			'status'	=> 'active',
			'token'		=> ''
		);
		
		$this->db->where('token', $token);
		$this->db->update('rth_users', $data);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
	
	// we lock this user 
	// because of something maybe resetting password
	// or something else
	public function lockUser($email, $token){
		
		$stat = 'invalid';
		
		$data = array(
			'status'	=> 'disabled',
			'token'		=> $token
		);
		
		$this->db->where('email', $email);
		$this->db->update('rth_users', $data);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
	
	public function lockUserByIdWithToken($id, $token){
		
		$stat = 'invalid';
		
		$endResult = $this->generateRespond($stat);
		
		$data = array(
			'status'	=> 'disabled',
			'token'		=> $token
		);
		
		$this->db->where('id', $id);
		$this->db->update('rth_users', $data);
		
		if($this->db->affected_rows() > 0){
				$endResult['status'] = 'valid';
				$endResult['multi_data'] = $token;
		}
		
		return $endResult;
		
	}
	
	public function lockUserById($id){
		
		$stat = 'invalid';
		
		$data = array(
			'status'	=> 'disabled'
		);
		
		$this->db->where('id', $id);
		$this->db->update('rth_users', $data);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
	
	public function activateUser($email, $token){
		
		$stat = 'invalid';
		
		$data = array(
			'email' 	=> $email,
			'token' 	=> $token
		);
		
		$updateData = array (
			'status' => 'active'
		);
		
		$this->db->where($data);
		$this->db->update('rth_users', $updateData);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
	
	public function activateUserNoEmail($token){
		
		$stat = 'invalid';
		
		$data = array(
			'token' 	=> $token
		);
		
		$updateData = array (
			'status' => 'active'
		);
		
		$this->db->where($data);
		$this->db->update('rth_users', $updateData);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
	
	public function activateUserDirectly($email){
		
		$stat = 'invalid';
		
		$data = array(
			'email' 	=> $email
		);
		
		$updateData = array (
			'status' => 'active'
		);
		
		$this->db->where($data);
		$this->db->update('rth_users', $updateData);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
		
	}
	
	
	
	
	public function checkDuplicates($usernameIn){
		
		$duplicate = false;
		
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
				'status' 		=> $row->status,
				'token' 		=> $row->token,				
				'created_date' 		=> $row->created_date,	
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
				'home_address' 	=> $row->home_address,
				'status'		=> $row->status,
				'propic' 		=> $row->propic,
				'contact' 		=> $row->contact,
				'membership' 	=> $row->membership,
				'full_name' 	=> $row->full_name,
				'gender' 		=> $row->gender,
				'alive'			=> $row->alive
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
		$this->db->delete('rth_users');
		
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
		$query = $this->db->get('rth_users');
		
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
		$this->db->update('rth_users', $newData);
		
		if($this->db->affected_rows() > 0){
				$stat = 'valid';
		}
		
		return $this->generateRespond($stat);
	}	
	
	public function getProfileBy($col, $val){
		
		$endResult = $this->generateRespond('invalid');
		
		$multiParam = array(
			$col => $val
		);
		
		$this->db->where($multiParam);		
		$query = $this->db->get('rth_users');
		
		foreach ($query->result() as $row)
		{
			
			$endResult['status'] = 'valid';
			
				$data = array(
				'id' 			=> $row->id,
				'status' 			=> $row->status,
				'username' 		=> $row->username,
				'pass' 			=> $row->pass,
				'email' 		=> $row->email,
				'home_address' 		=> $row->home_address,
				'propic' 		=> $row->propic,
				'contact' 		=> $row->contact,
				'membership' 		=> $row->membership,
				'full_name' 		=> $row->full_name,
				'created_date' 		=> $row->created_date,
				'status' 		=> $row->status,
				'token' 		=> $row->token,
				'gender' 	=> $row->gender
			);
			
			$endResult['multi_data'] = $data;
		}
		
		if($endResult['status'] == 'invalid'){
			unset($endResult['multi_data']);
		}
		
		return $endResult;
		
	}
	
	public function getProfile($idOrEmail){
		
		$endResult = $this->generateRespond('invalid');
		
		$endResult = $this->getProfileBy('id', $idOrEmail);
		
		if($endResult['status'] == 'invalid'){
			$endResult = $this->getProfileBy('email', $idOrEmail);
		}
		
		return $endResult;
		
	}
	
}