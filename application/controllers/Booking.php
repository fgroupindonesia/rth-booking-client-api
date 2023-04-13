<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('BookingRequestModel');
		$this->load->model('ScheduleModel');
		$this->load->model('SettingsModel');
		$this->load->model('EmailModel');
		$this->load->model('UserModel');
		
		// turn this TRUE if the site is in text output 
		$this->EmailModel->setDebugMode(false);
		
		// turn this TRUE if the site can SEND EMAIL
		$this->EmailModel->setEmailMode(false);
		
	}
	
	public function index()
	{
		$this->load->view('booking');
	}
	
	// this is Administrator Access
	public function admin(){
		$this->load->view('booking-admin-ui');
	}
	
	private function escapedString($val){
		
		$db = get_instance()->db->conn_id;
		$val = mysqli_real_escape_string($db, $val);
		return $val;
	}
	
	public function add(){
		
		$usernameIn 	= $this->input->post('username');
		$code 			= $this->input->post('code');
		$treatment		= $this->input->post('treatment');
		$gender			= $this->input->post('gender');

		// make it as string
		$treatment = json_encode($treatment);
		
		// and make it applicable for non-injection SQL attack
		$treatment = $this->escapedString($treatment);
		
		// the standard format in schedule is:
		// 2023-04-11 20:00:00
		$sdate 			= $this->input->post('schedule_date');
		
		$status			= "pending";
		
		
		// treatment is json data
		// ------------------------------
		// {tindakan_umum: 1, bekam: 0, elektrik : 1, lintah : 0,
		// fashdu : 0, pijat : 1, ruqyah : 1}
		
		// overall there are 5 status:
		// a. pending
		// b. completed
		// c. cancelled
		// d. changed
		// e. approved
		
		if($this->isAutoAccept()){
			$status			= "approved";
		}
		
		$endRespond 	=	$this->BookingRequestModel->add($code, $treatment, $sdate, $usernameIn, $status, $gender);
		
		// once added as booking data so we shall update the schedule
		if($this->isAutoAccept()){
			$statusGiven 	= 1;
			
			$date_chosen = explode(' ', $sdate)[0];
			$hour_chosen = explode(' ', $sdate)[1];
			$hour_chosen = substr($hour_chosen, 0, 5);
			
			// change the schedule accordingly
			$this->ScheduleModel->updateIfAny($code, $date_chosen, $hour_chosen, $statusGiven, $gender);
		}
		
		echo json_encode($endRespond);
		
	}
	
	private function sendEmailTo($anggotaNames, $modeKeberangkatan, $approval, $tindakterapi, $jadwalbooking, $kodebooking){
		
		$anggota = $this->prepareDataFromArray($anggotaNames);
		
		for($i=0; $i<count($anggotaNames); $i++){
			
			$dataUser = $this->UserModel->getProfileBy('full_name', $anggotaNames[$i]);
			
			$fullname = $dataUser['multi_data']['full_name'];
			$emailDest = $dataUser['multi_data']['email'];
			
			if(!empty($emailDest)){
			
			if($modeKeberangkatan == 'anggota-saja' && $approval == 'pending'){
				$this->EmailModel->email_resi_booking_anggota_only_menunggu($emailDest, $tindakterapi, $jadwalbooking, $kodebooking, $fullname);
			}else if($modeKeberangkatan == 'anggota-saja' && $approval == 'approved'){
				$this->EmailModel->email_resi_booking_anggota_only_success($emailDest, $tindakterapi, $jadwalbooking, $kodebooking, $fullname);
			} else if($modeKeberangkatan == 'saya-bersama-anggota' && $approval == 'pending'){
				$this->EmailModel->email_resi_booking_multiple_menunggu($emailDest, $tindakterapi, $jadwalbooking, $kodebooking, $anggota, $fullname);
			} else if($modeKeberangkatan == 'saya-bersama-anggota' && $approval == 'approved'){
				$this->EmailModel->email_resi_booking_multiple_success($emailDest, $tindakterapi, $jadwalbooking, $kodebooking, $anggota, $fullname);
			}
			
			
			
			}
			
			
		}
		
		
	}
	
	private function sendEmailToSelf($fullname, $modeKeberangkatan, $approval, $tindakterapi, $jadwalbooking, $kodebooking){
		
			$dataUser = $this->UserModel->getProfileBy('full_name', $fullname);
			$emailDest = $dataUser['multi_data']['email'];
			
			if($approval == 'pending'){
			$this->EmailModel->email_resi_booking_sendiri_menunggu($emailDest, $tindakterapi, $jadwalbooking, $kodebooking, $fullname);
			
			} else {
				$this->EmailModel->email_resi_booking_sendiri_success($emailDest, $tindakterapi, $jadwalbooking, $kodebooking, $fullname);
			}
			
			
	}
	
	private function prepareDataFromArray($data){
		
		$hasil = "";
		
		for($i=0; $i<count($data); $i++){
			
			if($hasil == ""){
				$hasil = $data[$i];
			}else{
				$hasil .= ", " + $data[$i];
			}
			
		}
		
		return $hasil;
		
	}
	
	public function sendNotification(){
		
		$username 	= $this->input->post('username');
		
		$fullname 	= $this->input->post('fullname');
		$approval 	= $this->input->post('approval');
		$modeKeberangkatan 	= $this->input->post('booking_mode');
		// modeOrangBerangkat can be :
		// 1. saya-sendiri
		// 2. anggota-saja
		// 3. saya-bersama-anggota	
		
		// namelist are stored here if any
		$anggota	= $this->input->post('anggota');
		$anggotaNames = explode(',', $anggota);
		$anggotaHumanNames = $this->prepareDataFromArray($anggotaNames);
		
		$human_date = $this->input->post('human_date');
		$treatment	= $this->input->post('treatment');
		
		$treatmentJSON = json_encode($treatment);
		
		$code 		= $this->input->post('code');
		
		$kodebooking = $code;
		$jadwalbooking = $human_date; //$this->konversiAsIndoDate($sdate);
		$tindakterapi = $this->konversiAsIndoTerapi($treatmentJSON);
		
		if($modeKeberangkatan == 'saya-sendiri' && $approval == 'pending'){
			
			$this->sendEmailToSelf($fullname, $modeKeberangkatan, $approval, $tindakterapi, $jadwalbooking, $kodebooking);
			
			$this->EmailModel->email_resi_booking_sendiri_admin($tindakterapi, $jadwalbooking, $kodebooking, $fullname);
			
		}else if($modeKeberangkatan == 'saya-sendiri' && $approval == 'approved'){
			
			$this->sendEmailToSelf($fullname, $modeKeberangkatan, $approval, $tindakterapi, $jadwalbooking, $kodebooking);
			
			$this->EmailModel->email_resi_booking_sendiri_admin_success($tindakterapi, $jadwalbooking, $kodebooking, $fullname);
			
		}else if($modeKeberangkatan == 'anggota-saja' && $approval == 'pending'){
			
			$this->sendEmailTo($anggotaNames, $modeKeberangkatan, $approval, $tindakterapi, $jadwalbooking, $kodebooking);
			
			$this->EmailModel->email_resi_booking_anggota_only_admin($tindakterapi, $jadwalbooking, $kodebooking, $anggotaHumanNames);
			
		}else if($modeKeberangkatan == 'anggota-saja' && $approval == 'approved'){
			
			$this->sendEmailTo($anggotaNames, $modeKeberangkatan, $approval, $tindakterapi, $jadwalbooking, $kodebooking);
			
			$this->EmailModel->email_resi_booking_anggota_only_admin_success($tindakterapi, $jadwalbooking, $kodebooking, $anggotaHumanNames);
			
		}else if($modeKeberangkatan == 'saya-bersama-anggota' && $approval == 'pending'){
			
			$this->sendEmailTo($anggotaNames, $modeKeberangkatan, $approval, $tindakterapi, $jadwalbooking, $kodebooking);
			
			$this->EmailModel->email_resi_booking_multiple_admin($tindakterapi, $jadwalbooking, $kodebooking, $anggotaHumanNames, $fullname);
			
		}else if($modeKeberangkatan == 'saya-bersama-anggota' && $approval == 'approved'){
			
			$this->sendEmailTo($anggotaNames, $modeKeberangkatan, $approval, $tindakterapi, $jadwalbooking, $kodebooking);
			
			$this->EmailModel->email_resi_booking_multiple_admin_success($tindakterapi, $jadwalbooking, $kodebooking, $anggotaHumanNames, $fullname);
			
		}
		
	
	}
	
	
	private function konversiAsIndoTerapi($terapiJSON){
		
		$hasil = "";
		
		$json = json_decode($terapiJSON, true);
		if($json['tindakan_umum'] == 1){
			$hasil .= "- tindakan umum\n";
		}

		if($json['bekam'] == 1){
			$hasil .= "- bekam (hijamah kering/basah/api)\n";
		}

		if($json['elektrik'] == 1){
			$hasil .= "- therapy elektrik\n";
		}

		if($json['fashdu'] == 1){
			$hasil .= "- fashdu\n";
		}

		if($json['lintah'] == 1){
			$hasil .= "- lintah\n";
		}

		if($json['pijat'] == 1){
			$hasil .= "- pijat fullbody\n";
		}
		
		return $hasil;
		
	}
	
	private function konversiAsIndoDate($scheduleDate){
		
		// format comes is 2023-04-10 08:00:00
		$hasil = '';
		$data = explode(' ', $scheduleDate);
		$dataTanggal = $data[0];
		$dataJam = $data[1];
		
		$split = explode('-', $dataTanggal);
		
		
		
		$hari = array ( 1 =>    'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu',
			'Minggu'
		);
		
		$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
			
	$hasil = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	$num = date('N', strtotime($dataTanggal)); 	
	$hariNa = $hari[$num]; 
	
	$hasil = $hariNa . ", " . $hasil;
	
		return $hasil;
		
	}
	
	private function isAutoAccept(){
		
		$hasil = true;
		
		$endResult = $this->SettingsModel->getAll();
		if($endResult['status'] == 'invalid'){
			$hasil = false;
		}else if($endResult['status'] == 'valid'){
			
			$holiday = $endResult['multi_data']['holiday'];
			$autoAccept = $endResult['multi_data']['auto_accept'];
			
			if($autoAccept != 1){
				$hasil = false;
			}
			
		}
		
		return $hasil;
	}
	
	// this is by Client call_user_func
	public function checkAcceptance(){
		
		$nilai = 'invalid';
		
		if($this->isAutoAccept()){
			$nilai = 'valid';
		}
		
		$endResult = array(
			'status' => $nilai
		);
		
			echo json_encode($endResult);
		
	}
	
	// this is for ADMIN & CLIENT
	public function all(){
		
		
	$username 			= $this->input->post('username');
	$includeFamily = $this->input->post('family');
	
	if(!isset($includeFamily)){
		$includeFamily = false;
	}
	
	
	// either for CLIENT 
	if(isset($username)){
		$endRespond 	=	$this->BookingRequestModel->getAllSpecific($username, $includeFamily);	
	
	// or for ADMIN
	}else {	
	
		$endRespond 	=	$this->BookingRequestModel->getAll();
	
	}
	
	echo json_encode($endRespond);
		
	}
	
	public function detail(){
		
		$code 			= $this->input->post('id');
		
		$endResult = $this->BookingRequestModel->getSpecific($code);
		
		echo json_encode($endResult);
		
	}
	
	public function edit(){
		
		$code 			= $this->input->post('code');
		$id 			= $this->input->post('id');
		$status			= $this->input->post('status');
		
		$gender			= $this->input->post('gender');
		
		if(!isset($gender)){
				$dataDB = $this->BookingRequestModel->getSpecificBy('code', $code);
				$gender = $dataDB['multi_data']['gender'];
		}
		
		$date			= $this->input->post('date');
		$hour			= $this->input->post('hour');
		
		// previously we choose to update by code
		// but now we choose only by id
		$endRespond 	=	$this->BookingRequestModel->update($id, $status);
		
		if($endRespond['status']='valid'){
			
			$statAvailable = 0;
			
			if($status == 'approved'){
				$statAvailable = 1;
			}
			
			$endRespond = $this->ScheduleModel->updateIfAny($code, $date, $hour, $statAvailable, $gender);
		}
		
		echo json_encode($endRespond);
		
	}
	
	public function delete(){
		
		$code 			= $this->input->post('code');
		
		$endRespond 	=	$this->BookingRequestModel->delete($code);
		echo json_encode($endRespond);
		
	}
	
}
