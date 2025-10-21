<?php

class Home extends Controller{

	private $userid;
	private $model;
	public function __construct()
	{	
		$this->model = $this->model('ImportExcelKatalogModel');
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
			$data["categories"]= $this->model->getkategori();
			$data["page"] ="home";
			$data["userid"] =$this->userid;
			$this->view('templates/header');
			$this->view('templates/navbar', $data);
			$this->view('home/index',$data);
			$this->view('templates/footer');
		}


	


 
}