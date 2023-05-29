<?php 
    class Ajax_checkout extends Controller
    {
        public function index($data_type, $countryId = "") {
           // print_r($countryId);

            $countryId = json_decode($countryId);
            $countries = $this->load_model("Countries");
            $data = $countries->get_states($countryId->countryId);

            $info = (object)[];
            $info->data = $data;
            $info->data_type = "get_states";
            
            echo json_encode($info);
        }
    }
    
?>