<?php 
    class Ajax_Cart extends Controller
    {
        public function index() {
          
        }
        public function edit_quantity($data = "") {
            $obj = json_decode($data);
            $obj->data_type = "edit_quantity";
          print_r(json_encode($obj));
        }

        
    }   
    
?>