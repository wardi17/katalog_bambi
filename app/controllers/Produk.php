<?php

class Produk extends Controller{

    private $userid;
    private $model;
    private $model_color;
    private $category;
    public function __construct()
    {	
        $this->category= isset($_GET['category']) ? $_GET['category'] : '';
    
        $this->model = $this->model('ImportExcelKatalogModel');
        $this->model_color = $this->model('MsWarnaModel');
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
            $data["mswarna"]= $this->model_color->getwarna($this->category);

           // $this->consol_war($data["mswarna"]);
            $data["page"] ="poduk";
            $data["userid"] =$this->userid;
            $data["category"] =$this->category;
            $this->view('templates/header');
            $this->view('templates/navbar', $data);
            $this->view('produk/index',$data);
            $this->view('templates/footer');
        }


        public function listdata(){
            try {
        // Retrieve data from the model
            $data = $this->model->listdata(); // Assuming this method exists in your model
            // Check if data is empty
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }

        // Send the data as a JSON response
        $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in InventarisController::listdata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }

    }