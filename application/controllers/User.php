<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('UserModel');
		$this->load->model('PictureModel');
		$this->load->model('HealthModel');
		$this->load->model('EmailModel');
		$this->load->model('FamilyUserModel');
		
		// turn this TRUE if the site is in text output 
		$this->EmailModel->setDebugMode(false);
		
		// turn this TRUE if the site can SEND EMAIL
		$this->EmailModel->setEmailMode(false);
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
		
		
		$email 			= $this->input->post('email');
		$full_name 		= $this->input->post('full_name');
		
		if(isset($email) && !empty($email) ){
		// user name dan pass dari sistem saja
			$username 		= $this->getEmail($email);
		} elseif(isset($full_name)){
			// untuk yg non username non email
			// kita generate dari namanya
			
			$username = str_replace(" ","",$full_name);
			$username = strtolower($username);
		}
		
		$pass 			= $this->generateToken(7);
		
		// we also generate 25 digit of token
		// for activation later
		$token 			= $this->generateToken(25);
		
		$married 		= $this->input->post('married');
		// MARRIED 0 is single,
		// MARRIED 1 is married,
		// MARRIED 2 is divorced,
		// MARRIED 3 is dead
		
		$home_address 	= $this->input->post('home_address');
		$contact 		= $this->input->post('contact');
		
		$alive 			= 0; 
		// ALIVE 0 is OFFLINE, ALIVE 1 is ONLINE
		$membership 	= 0; 
		// MEMBERSHIP 0 is patient, MEMBERSHIP 1 is VIP, 
		// MEMBERSHIP 2 is admin
		$gender			=  $this->input->post('gender');
		// GENDER 0 is female, 1 is male
		
		$propic			= 'default.png';
		
		$key 			= 'propic';
		
		$res =	$this->PictureModel->uploadImage($key);
	 
	 if(isset($res)){
		 // if the returned value isnot null
		 // so we use that file naming 
		 $propic = $res;
	 }
	 
		 $endRespond = $this->UserModel->add($username, $pass, $email, $home_address, $contact, $full_name, $alive, $membership, $gender, $propic, $token, $married);
		 
		 $rel_conn = $this->input->post('rel_connection');
		 $username_incharge = $this->input->post('username_incharge');
		 
		 // if this date is coming from family members
		 // so add to the specific table accordingly
		 if(isset($rel_conn)){
			 $endRespond = $this->FamilyUserModel->add($full_name, $username_incharge, $rel_conn);
		 }
		 
		 if($endRespond['status'] = 'valid'){
			 $keluhan 		= $this->input->post('keluhan');
			 $smoking 		= $this->input->post('merokok');
			 $rawat_inap 	= $this->input->post('pernahinap');
			 $obat_bius 	= $this->input->post('pernahbius');
			 $tbc 			= $this->input->post('pernahdivonistbc');
			 $kanker 		= $this->input->post('pernahdivoniskanker');
			 $jantung 		= $this->input->post('pernahdivonisjantung');
			 $stroke 		= $this->input->post('pernahdivonisstroke');
			 $anjurandok 	= $this->input->post('pernahanjuran');
			
			 $this->HealthModel->add_common($keluhan, $smoking, $rawat_inap,
			 $obat_bius, $tbc, $kanker, $jantung, $stroke, $anjurandok, $username);
			 
			 $ritual 		= $this->input->post('pernahritual');
			 $tenaga 		= $this->input->post('pernahtd');
			 $mimpi 		= $this->input->post('pernahmimpi');
			 $kunjungan 	= $this->input->post('pernahkunjungan');
			 $ghaib 		= $this->input->post('pernahghaib');
			 
			 $this->HealthModel->add_special($ritual, $tenaga, $mimpi,
			 $kunjungan, $ghaib, $username);
			 
			 // sending Email Notification
			$this->EmailModel->email_register_success($email, $full_name, $username, $contact, $pass, $token);
			
			// we dont check any further here except tell the admin
			$gender_indo = 'wanita';
			$married_indo = 'single';
			
			if($gender == 1){
			$gender_indo = 'lelaki';
			} 
			
			if($married == 1){
				$married_indo = 'bersuami-istri';
			}else if($married == 2){
				$married_indo = 'bercerai';
			}else if($married == 3){
				$married_indo = 'ditinggal wafat';
			}
			
			$dataUmum = array(
				'merokok' 	=> $this->yesNoValue($smoking),
				'inap'		=> $this->yesNoValue($rawat_inap),
				'bius'		=> $this->yesNoValue($obat_bius),
				'tbc'		=> $this->yesNoValue($tbc),
				'kanker'	=> $this->yesNoValue($kanker),
				'jantung'	=> $this->yesNoValue($jantung),
				'stroke'	=> $this->yesNoValue($stroke),
				'anjuran'	=> $this->yesNoValue($anjurandok)
			);
			
			$dataKhusus = array(
				'ritual'	=> $this->yesNoValue($ritual),
				'td'		=> $this->yesNoValue($tenaga),
				'mimpi'		=> $this->yesNoValue($mimpi),
				'paranormal'=> $this->yesNoValue($kunjungan),
				'ghaib'		=> $this->yesNoValue($ghaib)
			);
			
			
			$createdDate = date('Y-m-d H:i:s');
			
			 // sending Email Notification for admin
			$this->EmailModel->email_register_success_notif_admin($createdDate,
			$full_name, $gender_indo, $married_indo, $contact, $home_address, $keluhan,
			$dataUmum, $dataKhusus);
			
			
		 }
	 
		
		echo json_encode($endRespond);
		
	}
	
	private function yesNoValue($val){
		$hasil = "tidak";
		
		if($val == 1){
			$hasil = "ya";
		}
		
		return $hasil;
	}
	
	// this is for CLIENT Reset Password Step-2 : clicking GET URL
	public function aktifasi(){
		
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: GET, OPTIONS");
		
		 $token 		= $this->input->get('token');
		 
		 $dataUser = $this->UserModel->getProfileBy('token', $token);
		 
		 $endRespond = $this->UserModel->activateUserNoEmail($token);	
		
		if($endRespond['status']=='valid'){
			$email = $dataUser['multi_data']['email'];
			
			if(!empty($email)){
			$this->EmailModel->email_activated_success($email, $dataUser['multi_data']);
			}
		}
		
		echo json_encode($endRespond);
	}
	
	public function directaktifasi(){
		
		$email = $this->input->post('email');
		
		$endRespond = $this->UserModel->activateUserDirectly($email);
		
		if($endRespond['status']='valid'){
			$dataUser = $this->UserModel->getProfileBy('email', $email);
			
			$this->EmailModel->email_activated_success($email, $dataUser['multi_data']);
		}
		
		echo json_encode($endRespond);
		
	}
	
	public function directnonaktifasi(){
		
		$id = $this->input->post('id');
		
		// without the token given
		$endRespond = $this->UserModel->lockUserById($id);
		
		
		echo json_encode($endRespond);
		
	}
	
	public function resetPassDirect(){
		
		// direct reset itu berarti sending token by whatsapp (json to client);
		// link inside the whatsapp
		$id	=	$this->input->post('id');
		
		$dataDB = $this->UserModel->getProfileBy('id',$id);
		
		// if fails then store it for later usage if it is invalid
		$endRespond = $dataDB;
		if($dataDB['status'] == 'valid'){
				
			$dataUser = $dataDB['multi_data'];
			$username = $dataUser['username'];
			
			// this for locking purposes
			// this 24 digit for URL Resetting Password
			$token    = $this->generateToken(25);
			$endRespond = $this->UserModel->lockUserByIdWithToken($id, $token);
			// the token is given to the json as the output
		}
		
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
	
	public function renderResetForm(){
		
		$token = $this->input->get('token');
		
		$data = array(
			'token' => $token
		);
		
		if(isset($token)){
		$this->load->view('renew-pass', $data);
		}else{
			echo "token error!";
		}
		
	}
	
	// this is for CLIENT Reset Password Step-3 : submit form
	public function updatePass(){
		
		$pass	=	$this->input->post('pass');
		$token	=	$this->input->post('token');
		
		$dataUser = $this->UserModel->getProfileBy('token', $token);
		
		if(isset($dataUser['multi_data'])){
		
		$emailna = $dataUser['multi_data']['email'];
		$phone =  $dataUser['multi_data']['contact'];
		
		// update the password, and the status to be active inside
		// given by its token 
		// so the token will be cleared
		$endRespond = $this->UserModel->updatePassword($pass, $token);
		
		if(isset($emailna) && !empty($emailna)){
		// send the email notification too
		$this->EmailModel->email_updated_pass($emailna, $phone, $pass);	
		}		
		
		echo json_encode($endRespond);
		
		}else{
			// once the token is invalid
			// we say it loud to the client
			echo json_encode($dataUser);
		}
		
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
		
		$dataUsed = null;
		
		if(isset($id)){
		$dataUsed = $this->UserModel->getProfile($id);
		}
		// try once more
		if($dataUsed['status'] == 'invalid' || isset($us)){
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
