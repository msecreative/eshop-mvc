<?php 
    class Ajax_checkout extends Controller
    {
        public function index($data_type, $country = "") {
            $info = file_get_contents("php://input");
            $info = json_decode($info);
            

            $country = $info->data->country;
            $countries = $this->load_model("Countries");
            $data = $countries->get_states($country);

            $info = (object)[];
            $info->data = $data;
            $info->data_type = "get_states";
            
            echo json_encode($info);
        }
    }
    
?>