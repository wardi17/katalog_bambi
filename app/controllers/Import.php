<?php

class Import extends Controller{

	private $userid;
	public function __construct()
	{	
		$this->userid ="wardi";
		// if($_SESSION['login_user'] == '') {
		// 	Flasher::setMessage('Login','Tidak ditemukan.','danger');
		// 	header('location: '. base_urllogin);
		// 	exit;
		// }else{
		// 	$this->userid = $_SESSION['login_user'];
		// }

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