<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('UserModel');
		$this->load->model('PictureModel');
		$this->load->model('HealthModel');
	}
	
	public function test(){
		echo "X";
	}
	
	public function testEmail(){
		$this->sendEmailActivation('gumuruh@gmail.com');
		echo "send email...";
	}
	
	public function resetpass(){
		
		$username = "contoh";
		$token = "contoh-token";
		
		$dataArray = array(
			'username' => $username,
			'token' => $token
		);
		
		$emailKonten = $this->load->view('template/_email_reset_password', $dataArray, TRUE);

		$this->sendEmailActivation('fgroupindonesia@gmail', 'Reset Password Akun', $emailKonten);	
		
		echo "reset pass";
		
	}
	
	public function sendEmailActivation($dest, $judul, $htmlkonten){
		
		//valid sampe 
		
		$config = array(
		'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
		'smtp_host' => 'ssl://smtp.elasticemail.com', 
		'smtp_port' => 2525,
		'smtp_user' => 'admin@rumahterapiherbal.web.id',
		'smtp_pass' => '15A849C22480B2E07306C1CCCEE80A3EDA90',
		'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
		'mailtype' => 'html', //plaintext 'text' mails or 'html'
		'smtp_timeout' => '7', //in seconds
		'charset' => 'iso-8859-1',
		'wordwrap' => TRUE
		);

		$this->load->library('email', $config);
		$this->email->from('admin@rumahterapiherbal.web.id', 'RTH - Rumah Terapi Herbal');
		
		$this->email->to($dest);
		$this->email->subject($judul);
		$this->email->message($htmlkonten);
		$this->email->send();
	}
	
	private function generatePass($length){
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
		$pass 			= $this->generatePass(7);
		
		
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
	 
		 $endRespond = $this->UserModel->add($username, $pass, $email, $home_address, $contact, $full_name, $alive, $membership, $gender, $propic);
		 
		 
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
		 }
	 
		
		echo json_encode($endRespond);
		
	}
	
	public function update(){
		
		
		$id 		= $this->input->post('id');
		$username 	= $this->input->post('username');
		$pass 		= $this->input->post('pass');
		$email 		= $this->input->post('email');
		$home_address 	= $this->input->post('home_address');
		$contact 	= $this->input->post('contact');
		$full_name 	= $this->input->post('full_name');
		$gender 	= $this->input->post('gender');
		$member 	= $this->input->post('membership');
		// the null here is used to make the db not updating picture column 
		
		$propic		= null;
		$key 		= 'propic';
		
		$res =	$this->PictureModel->uploadImage($key);
	 
		 if(isset($res)){
			 // if the returned value isnot null
			 // so we use that file naming 
			 $propic = $res;
		 }
		
		$endRespond = $this->UserModel->edit($id, $username, $pass, $email, $home_address, $contact, $full_name, $propic, $member, $gender);
		
		
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
		
		$dataUsed = $this->UserModel->getProfile($id);
		
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
