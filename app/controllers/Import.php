<?php

class Import extends Controller{

	private $userid;
	public function __construct()
	{	
		if($_SESSION['session_login'] != 'sudah_login') {
			Flasher::setMessage('Login','Tidak ditemukan.','danger');
			header('location: '. base_url . '/login');
			exit;
		}else{
			$this->userid = isset($_SESSION['nama']) ? $_SESSION['nama'] : "";
		
		} 

	} 

	public function index()
		{
		
			$data["page"] ="Import";
			$data["userid"] =$this->userid;
			$this->view('templates/header');
			$this->view('templates/navbaradm', $data);
			$this->view('import/index',$data);
			$this->view('templates/footer');
		}


	


 
}