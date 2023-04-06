<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('UserModel');
		$this->load->model('PictureModel');
		$this->load->model('HealthModel');
		$this->load->model('EmailModel');
		
		// turn this off if the site is ALIVE 
		$this->EmailModel->setDebugMode(true);
	}
	
	public function test(){
		$n = date('l, d-F-Y H:i:s');
		echo "X " . $n;
	}
	
	private function generateToken($length){
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}
	
	private function getEmail($string){
		$explode = explode("@",$string);
		array_pop($explode);
		$newstring = join('@', $explode);
		return $newstring;
	}
	
	private function isValidEmail($email) {
	   $find1 = strpos($email, '@');
	   $find2 = strpos($email, '.');
	   return ($find1 !== false && $find2 !== false && $find2 > $find1);
	}
	
	public function register(){
		
		$email 			= $this->input->post('peserta_baru_email');
		
		// user name dan pass dari sistem saja
		$username 		= $this->getEmail($email);
		$pass 			= $this->generateToken(7);
		
		// we also generate 25 digit of token
		// for activation later
		$token 			= $this->generateToken(25);
		
		
		$home_address 	= $this->input->post('peserta_baru_alamat');
		$contact 		= $this->input->post('peserta_baru_nomorhp');
		$full_name 		= $this->input->post('peserta_baru_nama');
		$alive 			= 0; 
		// ALIVE 0 is OFFLINE, ALIVE 1 is ONLINE
		$membership 	= 0; 
		// MEMBERSHIP 0 is patient, MEMBERSHIP 1 is VIP, 
		// MEMBERSHIP 2 is admin
		$gender			=  $this->input->post('peserta_baru_kelamin');
		
		$propic			= 'default.png';
		
		$key 			= 'propic';
		
		$res =	$this->PictureModel->uploadImage($key);
	 
	 if(isset($res)){
		 // if the returned value isnot null
		 // so we use that file naming 
		 $propic = $res;
	 }
	 
		 $endRespond = $this->UserModel->add($username, $pass, $email, $home_address, $contact, $full_name, $alive, $membership, $gender, $propic, $token);
		 
		 
		 if($endRespond['status'] = 'valid'){
			 $keluhan 		= $this->input->post('kesehatan_umum_keluhan');
			 $smoking 		= $this->input->post('kesehatan_umum_merokok');
			 $rawat_inap 	= $this->input->post('kesehatan_umum_pernahinap');
			 $obat_bius 	= $this->input->post('kesehatan_umum_pernahbius');
			 $tbc 			= $this->input->post('kesehatan_umum_pernahdivonistbc');
			 $kanker 		= $this->input->post('kesehatan_umum_pernahdivoniskanker');
			 $jantung 		= $this->input->post('kesehatan_umum_pernahdivonisjantung');
			 $stroke 		= $this->input->post('kesehatan_umum_pernahdivonisstroke');
			 $anjurandok 	= $this->input->post('kesehatan_umum_pernahanjuran');
			
			 $this->HealthModel->add_common($keluhan, $smoking, $rawat_inap,
			 $obat_bius, $tbc, $kanker, $jantung, $stroke, $anjurandok, $username);
			 
			 $ritual 		= $this->input->post('kesehatan_khusus_pernahritual');
			 $tenaga 		= $this->input->post('kesehatan_khusus_pernahtd');
			 $mimpi 		= $this->input->post('kesehatan_khusus_pernahmimpi');
			 $kunjungan 	= $this->input->post('kesehatan_khusus_pernahkunjungan');
			 $ghaib 		= $this->input->post('kesehatan_khusus_pernahghaib');
			 
			 $this->HealthModel->add_special($ritual, $tenaga, $mimpi,
			 $kunjungan, $ghaib, $username);
			 
			 // sending Email Notification
			$this->EmailModel->email_register_success($email, $full_name, $username, $contact, $pass, $token);
			
			// we dont check any further here
			
		 }
	 
		
		echo json_encode($endRespond);
		
	}
	
	// this is for CLIENT Reset Password Step-2 : clicking GET URL
	public function aktifasi(){
		
		 $token 		= $this->input->get('token');
		 $email 		= $this->input->get('email');
		
		$endRespond = $this->UserModel->activateUser($email, $token);
			
		echo json_encode($endRespond);
	}
	
	// this is for CLIENT Reset Password Step-1 : posting form
	public function resetPass(){
		
		$email	=	$this->input->post('reset_email');
		
		$dataDB = $this->UserModel->getProfile($email);
		
		// if fails then store it for later usage if it is invalid
		$endRespond = $dataDB;
		if($dataDB['status'] == 'valid'){
				
			$dataUser = $dataDB['multi_data'];
			$username = $dataUser['username'];
			
			// this for locking purposes
			// this 24 digit for URL Resetting Password
			$token    = $this->generateToken(25);
			$endRespond = $this->UserModel->lockUser($email, $token);
			
			$this->EmailModel->email_reset_pass($email, $username, $token);
		}
		
		echo json_encode($endRespond);
		
	}
	
	// this is for CLIENT Reset Password Step-3 : submit form
	public function updatePass(){
		
		$pass	=	$this->input->post('pass');
		$token	=	$this->input->post('token');
		
		$dataUser = $this->UserModel->getProfileBy('token', $token);
		
		$emailna = $dataUser['multi_data']['email'];
		$phone =  $dataUser['multi_data']['contact'];
		
		// update the password, and the status to be active inside
		// given by its token 
		$endRespond = $this->UserModel->updatePassword($pass, $token);
		
		// send the email notification too
		$this->EmailModel->email_updated_pass($emailna, $phone, $pass);	
			
		echo json_encode($endRespond);
		
	}
	
	public function update(){
		
		// this is coming from mobile 
		$id 		= $this->input->post('id');
		$status 	= $this->input->post('status');
		$username 	= $this->input->post('username');
		$pass 		= $this->input->post('pass');
		$email 		= $this->input->post('email');
		$home_address 	= $this->input->post('home_address');
		$contact 	= $this->input->post('contact');
		$full_name 	= $this->input->post('full_name');
		$gender 	= $this->input->post('gender');
		$member 	= $this->input->post('membership');
		
		// this is coming from Web
		if(!isset($email)){
			$id 		= $this->input->post('profil_id');
			$status 	= $this->input->post('profil_status');
			$username 	= $this->input->post('profil_username');
			$pass 		= $this->input->post('profil_pass');
			$email 		= $this->input->post('profil_email');
			$home_address 	= $this->input->post('profil_home_address');
			$contact 	= $this->input->post('profil_contact');
			$full_name 	= $this->input->post('profil_full_name');
			$gender 	= $this->input->post('profil_gender');
			$member 	= $this->input->post('profil_membership');
			
		}
		
		if(!isset($status)){
			// given for default
			$status = 'active';
		}
		
		
		// the null here is used to make the db not updating picture column 
		
		$propic		= null;
		$key 		= 'propic';
		
		$res =	$this->PictureModel->uploadImage($key);
	 
		 if(isset($res)){
			 // if the returned value isnot null
			 // so we use that file naming 
			 $propic = $res;
		 }
		
		$endRespond = $this->UserModel->edit($id, $username, $pass, $email, $home_address, $contact, $full_name, $propic, $member, $gender, $status);
		
		
		echo json_encode($endRespond);
		
		
	}
	
	// this is for ADMIN
	public function all(){
		
	$endRespond 	=	$this->UserModel->getAll();
	echo json_encode($endRespond);
		
	}
	
	// this is for ADMIN
	public function delete(){
		
		$usernameIn 	= $this->input->post('username');
		$endRespond 	=	$this->UserModel->delete($usernameIn);
		echo json_encode($endRespond);
		
	}
	
	// user/picture
	public function picture(){
		// we dont use token for accessing picture
		// because it's for public usage
		
		//$file 	= $this->input->post('propic');
		//$file = 'logo.png';
		$file 	= $this->input->get('propic');
		
		$targetFile = 'images/propic/' . $file;
		
		force_download($targetFile,NULL);
		
	}
	
	public function profile(){
		
		$id 	= $this->input->post('id');
		$us 	= $this->input->post('username');
		
		$dataUsed = $this->UserModel->getProfile($id);
		
		// try once more
		if($dataUsed['status'] == 'invalid' && isset($us)){
			$dataUsed = $this->UserModel->getProfileBy('username', $us);
		}
		
		echo json_encode($dataUsed);
		
	}
	
	public function login(){
		
		// we dont use token verification here
		// instead we generate the token here once they have a valid login cridentials
		
		$username 	= $this->input->post('username');
		$cp 		= $this->input->post('contact');
		$asWho 		= $this->input->post('as');
		
		// check apakah ada '@mail.com' diusername?
		if($this->isValidEmail($username)){
			// if so check dulu ini email terdaftar bukan?
			$dataExist = $this->UserModel->emailExist($username);
			
			if($dataExist['status'] == 'valid'){
				// if so ambil hanya nama emailnya saja
				$username = $this->getEmail($username);
			}

		}
		
		if(!isset($cp)){
			// bisa jadi contact nomor hp dari username
			$cp = $username;
		}
		
		$pass 		= $this->input->post('pass');
		
		if(!isset($asWho)){
			$dataUsed = $this->UserModel->verify($username, $pass, $cp);
		}else {
			$dataUsed = $this->UserModel->verifyAsAdmin($username, $pass, $cp);
		}
		
		
		echo json_encode($dataUsed);
		
	}
	
	
	
}
