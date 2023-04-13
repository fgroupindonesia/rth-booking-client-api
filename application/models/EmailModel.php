<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailModel extends CI_Model {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		
	}
	
	private $debugModeHere = false;
	private $disableEmailHere = false;
	private $emailAdministrator = "rumahterapiherbalbandung@gmail.com";
	
	// DEBUGMODE TRUE is so PRINTOUT the email content but NO SENDING
	// DEBUGMODE FALSE && DisableEmail is FALSE so it will SEND EMAIL
	// DEBUGMODE TRUE && DisableEmail is TRUE so it will PRINTOUT AND NOT SEND EMAIL
	// DEBUGMODE FALSE && DisableEmail is TRUE so it will NOT SEND EMAIL
	
	public function setDebugMode($n){
		$this->debugModeHere = $n;
	}
	
	public function setEmailMode($n){
		$this->disableEmailHere = !$n;
	}
	
	private function isEmailMode(){
		return !$this->disableEmailHere;
	}
	
	private function isDebugMode(){
		return $this->debugModeHere;
	}
	
	private function getEmailAdministrator(){
		return $this->emailAdministrator;
	}
	
	
	// status whether it is 'valid' or 'invalid'
	public function generateRespond($statusIn){
		
		$stat = array(
			'status' => $statusIn
		);
		
		return $stat;
	}
	
	private function printOrSendEmail($email, $title, $emailKonten){
		if($this->isDebugMode()){
			
			echo $emailKonten;
		
		} 
		
		if($this->isEmailMode()){
			$this->sendEmailActivation($email, $title, $emailKonten);	
		}
		
	}
	
	public function email_resi_booking_notif_admin($tindakterapi, $jadwalbooking, $kodebooking, $fullname){
	
		$title = "Booking Jadwal Order";
	
		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'fullname' => $fullname
		);
		
		$emailAdmin = $this->getEmailAdministrator();
		
		$emailKonten = $this->load->view('template/_email_resi_booking_menunggu', $dataArray, TRUE);
		
		$this->printOrSendEmail($emailAdmin, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_register_success_notif_admin($tanggal, $fullname, $gender, $married, $nohp, $address, $keluhan, $dataUmum, $dataKhusus){

		$title = "Barusan Pasien Baru Terdaftar!";

		$dataArray = array(
			'tanggal' => $tanggal,
			'fullname' => $fullname,
			'gender' => $gender,
			'married' => $married,
			'nohp' => $nohp,
			'address' => $address,
			'keluhan' => $keluhan,
			'stat_merokok' => $dataUmum['merokok'],
			'stat_inap' => $dataUmum['inap'],
			'stat_bius' => $dataUmum['bius'],
			'stat_tbc' => $dataUmum['tbc'],
			'stat_kanker' => $dataUmum['kanker'],
			'stat_jantung' => $dataUmum['jantung'],
			'stat_stroke' => $dataUmum['stroke'],
			'stat_anjuran' => $dataUmum['anjuran'],
			'stat_ritual' => $dataKhusus['ritual'],
			'stat_td' => $dataKhusus['td'],
			'stat_mimpi' => $dataKhusus['mimpi'],
			'stat_paranormal' => $dataKhusus['paranormal'],
			'stat_ghaib' => $dataKhusus['ghaib']
		);
		
		$emailAdmin = $this->getEmailAdministrator();
		
		$emailKonten = $this->load->view('template/_email_registered_success_admin', $dataArray, TRUE);
		
		$this->printOrSendEmail($emailAdmin, $title, $emailKonten);
		
		return true;
	}
	
	public function email_cancel_booking($email, $kodebooking, $fullname, $jadwalbooking, $tindakterapi){

		$title = "Pembatalan Booking Jadwal";

		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'fullname' => $fullname
		);
		
		$emailKonten = $this->load->view('template/_email_pembatalan_booking', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		return true;
	}
	
	public function email_resi_booking_sendiri_menunggu($email, $tindakterapi, $jadwalbooking, $kodebooking, $fullname){
	
		$title = "Booking Jadwal Sedang Diproses";
	
		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'fullname' => $fullname
		);
		
		$emailKonten = $this->load->view('template/_email_resi_booking_sendiri_menunggu', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_resi_booking_sendiri_success($email, $tindakterapi, $jadwalbooking, $kodebooking, $fullname){
	
		$title = "Booking Jadwal Berhasil";
	
		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'fullname' => $fullname
		);
		
		$emailKonten = $this->load->view('template/_email_resi_booking_sendiri_success', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_resi_booking_multiple_menunggu($email, $tindakterapi, $jadwalbooking, $kodebooking, $anggota, $fullname){
	
		$title = "Booking Jadwal Sedang Diproses";
	
		$dataArray = array(
			'fullname'	=> $fullname,
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'anggota' => $anggota
		);
		
		$emailKonten = $this->load->view('template/_email_resi_booking_multiple_menunggu', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_resi_booking_multiple_success($email, $tindakterapi, $jadwalbooking, $kodebooking, $anggota, $fullname){
	
		$title = "Booking Jadwal Berhasil";
	
		$dataArray = array(
			'fullname'	=> $fullname,
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'anggota' => $anggota
		);
		
		$emailKonten = $this->load->view('template/_email_resi_booking_multiple_success', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_resi_booking_anggota_only_menunggu($email, $tindakterapi, $jadwalbooking, $kodebooking, $anggota){
	
		$title = "Booking Jadwal Sedang Diproses";
	
		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'anggota' => $anggota
		);
		
		$emailKonten = $this->load->view('template/_email_resi_booking_anggota_only_menunggu', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_resi_booking_anggota_only_success($email, $tindakterapi, $jadwalbooking, $kodebooking, $anggota){
	
		$title = "Booking Jadwal Berhasil";
	
		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'anggota' => $anggota
		);
		
		$emailKonten = $this->load->view('template/_email_resi_booking_anggota_only_success', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_resi_booking_sendiri_admin($tindakterapi, $jadwalbooking, $kodebooking, $fullname){
	
		$title = "Booking Jadwal Order";
	
		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'fullname' => $fullname
		);
		
		$email = $this->getEmailAdministrator();
		
		$emailKonten = $this->load->view('template/_email_resi_booking_sendiri_admin', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_resi_booking_sendiri_admin_success($tindakterapi, $jadwalbooking, $kodebooking, $fullname){
	
		$title = "Booking Jadwal Order Success";
	
		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'fullname' => $fullname
		);
		
		$email = $this->getEmailAdministrator();
		
		$emailKonten = $this->load->view('template/_email_resi_booking_sendiri_admin_success', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	
	}
	
	public function email_resi_booking_anggota_only_admin($tindakterapi, $jadwalbooking, $kodebooking, $anggota){
	
		$title = "Booking Jadwal Order";
	
		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'anggota' => $anggota
		);
		
		$email = $this->getEmailAdministrator();
		
		$emailKonten = $this->load->view('template/_email_resi_booking_anggota_only_admin', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_resi_booking_anggota_only_admin_success($tindakterapi, $jadwalbooking, $kodebooking, $anggota){
	
		$title = "Booking Jadwal Order Success";
	
		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'anggota' => $anggota
		);
		
		$email = $this->getEmailAdministrator();
		
		$emailKonten = $this->load->view('template/_email_resi_booking_anggota_only_admin_success', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	
	}
	
	public function email_resi_booking_multiple_admin($tindakterapi, $jadwalbooking, $kodebooking, $anggota, $fullname){
	
		$title = "Booking Jadwal Order";
	
		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'anggota' => $anggota,
			'fullname' => $fullname
		);
		
		$email = $this->getEmailAdministrator();
		
		$emailKonten = $this->load->view('template/_email_resi_booking_multiple_admin', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_resi_booking_multiple_admin_success($tindakterapi, $jadwalbooking, $kodebooking, $anggota, $fullname){
	
		$title = "Booking Jadwal Order Success";
	
		$dataArray = array(
			'tindakterapi' => $tindakterapi,
			'jadwalbooking' => $jadwalbooking,
			'kodebooking' => $kodebooking,
			'anggota' => $anggota,
			'fullname'	=> $fullname
		);
		
		$email = $this->getEmailAdministrator();
		
		$emailKonten = $this->load->view('template/_email_resi_booking_multiple_admin_success', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	
	}
	
	
	public function email_register_success($email, $fullname, $username, $nohp, $pass, $token){
		
		$title = "Selamat Akun Terdaftar!";
		
		$dataArray = array(
			'fullname' => $fullname,
			'username' => $username,
			'nohp' => $nohp,
			'pass' => $pass,
			'token' => $token
		);
		
		$emailKonten = $this->load->view('template/_email_registered_success', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_activated_success($email, $dataUser){
		
		$title = "Selamat Akun Sudah Aktif!";
		
		$dataArray = array(
			'fullname' => $dataUser['full_name'],
			'username' => $dataUser['username'],
			'nohp' => $dataUser['contact'],
			'pass' => $dataUser['pass']
		);
		
		$emailKonten = $this->load->view('template/_email_activated_success', $dataArray, TRUE);
		
		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	private function konversiHariEnglishToIndonesia($hari){
		
		$harina = $hari;
		
		$bEnglish = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday',
		'Friday', 'Saturday');
		
		$bIndonesia = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis',
		'Jumat','Sabtu');
		
		if(in_array($hari, $bEnglish)){
			$nomer = array_search($hari, $bEnglish);
			$harina = $bIndonesia[$nomer];
		}
		
		return $harina;
		
	}
	
	private function konversiBulanEnglishToIndonesia($bulan){
		
		$bulanna = $bulan;
		
		$bEnglish = array('January', 'February', 'March', 'April','May', 'June',
		'July', 'August', 'September', 'October', 'November','December');
		
		$bIndonesia = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
		'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
		
		if(in_array($bulan, $bEnglish)){
			$nomer = array_search($bulan, $bEnglish);
			$bulanna = $bIndonesia[$nomer];
		}
		
		return $bulanna;
		
	}
	
	private function konversiTanggalEnglishToIndonesia($tgl){
		
		$mon = date('F');
		$day = date('l');
		
		$monIndo = $this->konversiBulanEnglishToIndonesia($mon);
		$dayIndo = $this->konversiHariEnglishToIndonesia($day);
		
		$tglBaru = str_replace($day, $dayIndo, $tgl);
		$tglBaru = str_replace($mon, $monIndo, $tglBaru);
		
		return $tglBaru;
		
	}
	
	public function email_updated_pass($email, $phone, $pass){
		
		$title = "Update Password Terbaru";
		
		$dateNa = $this->konversiTanggalEnglishToIndonesia(date('l, d-F-Y H:i:s'));
		
		$dataArray = array(
			'email' => $email,
			'phone' => $phone,
			'pass' => $pass,
			'date' => $dateNa
		);
		
		$emailKonten = $this->load->view('template/_email_reset_password_success', $dataArray, TRUE);

		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
	}
	
	public function email_reset_pass($email, $username, $token){
		
		$title = "Reset Password Akun";
		
		$dateNa = $this->konversiTanggalEnglishToIndonesia(date('l, d-F-Y H:i:s'));
		
		$dataArray = array(
			'username' => $username,
			'token' => $token,
			'date' => $dateNa
		);
		
		$emailKonten = $this->load->view('template/_email_reset_password', $dataArray, TRUE);

		$this->printOrSendEmail($email, $title, $emailKonten);
		
		
		return true;
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
	
	
}