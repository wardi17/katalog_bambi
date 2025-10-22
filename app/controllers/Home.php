<?php

class Home extends Controller{


	private $model;
    private $modelmenu;
	public function __construct()
	{	
		$this->model = $this->model('ImportExcelKatalogModel');
        $this->modelmenu = $this->model('MenuModel');
	} 




	public function index()
		{
			$data["page"]="home";
			$data["categories"]= $this->model->getkategori();
			$data["menukategori"]= $this->modelmenu->TampilMenu();
			$this->view('templates/header');
			$this->view('templates/navbar', $data);
			$this->view('home/index',$data);
			$this->view('templates/footer');
		}


	





	
}