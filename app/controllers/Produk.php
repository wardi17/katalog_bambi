<?php

class Produk extends Controller{

    private $userid;
    private $model;
    private $model_color;
    private $model_menu;
    private $category;
    public function __construct()
    {	
        $this->category= isset($_GET['category']) ? $_GET['category'] : '';
    
        $this->model = $this->model('ImportExcelKatalogModel');
        $this->model_color = $this->model('MsWarnaModel');
        $this->model_menu = $this->model('MenuModel');


    } 

    public function index()
        {
            $data["categories"]= $this->model->getkategori();
            $data["mswarna"]= $this->model_color->getwarna($this->category);
            $data["labeltitle"]= $this->model_menu->getlabeltitle($this->category);
            $data["category"]= $this->category;
           // $this->consol_war($data["mswarna"]);
            $data["page"] ="poduk";
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