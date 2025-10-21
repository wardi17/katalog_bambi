<?php

class Home extends Controller{


	private $model;
	public function __construct()
	{	
		$this->model = $this->model('ImportExcelKatalogModel');

	} 

	public function index()
		{
			$data["categories"]= $this->model->getkategori();
			$this->view('templates/header');
			$this->view('templates/navbar', $data);
			$this->view('home/index',$data);
			$this->view('templates/footer');
		}


	


 
}