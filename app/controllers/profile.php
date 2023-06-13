<?php 
    class Profile extends Controller
    {
        public function index($url_address = null) {
            $user = $this->load_model("User");
            $order = $this->load_model("Order");
            $user_data = $user->check_login(true);

            if ($url_address) {
                $profile_data = $user->get_user($url_address);
            }else{
                $profile_data = $user_data;
            }


            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            if (is_array($profile_data)) {
               
                $orders = $order->get_all_orders_by_user($profile_data->url_address);
            }else{
                $orders = false;
            }

            if (is_array($orders)) {

                foreach ($orders as $key => $order_row) {

                    $details = $order->get_all_orders_details($order_row->orderId);
                    $orders[$key]->details = $details;
                }
                
            }

            $data["profile_data"] = $profile_data;
            $data["page_title"] = "Profile";
            $data["orders"] = $orders;
            
            $this ->view("profile", $data);
        }
    }
    
?>