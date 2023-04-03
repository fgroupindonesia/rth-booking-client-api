<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PictureModel extends CI_Model {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		
	}
	
	function uploadImage($key){
		
		$propic  = null;
		
		if(isset($_FILES[$key])) {
			// if there image given'
			// has a real file
			if(!empty($_FILES[$key]['name'])){
			// proceed the uploads...
			//$new_image_name = 'propic_' . str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES[$key]['name']);
			
			$new_image_name = time() . '_' . str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES[$key]['name']);
	
			//echo $_FILES[$key]['name'];
	
		$filename = $new_image_name;
	
		//$config['upload_path'] = 'images/propic/'; 
		// name goes here
		$config['upload_path'] = 'images/' . $key . '/'; 
		$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
		$config['file_name'] = $new_image_name;
		
		$this->load->library('upload', $config);
		$uploadRes = $this->upload->do_upload($key);
		// change the name accordingly
		$propic = $filename;
			
		}
		
		}
		
		return $propic;
		
	}
	
}