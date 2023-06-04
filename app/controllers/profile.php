<?php 
    class Profile extends Controller
    {
        public function index() {
            $user = $this->load_model("User");
            $order = $this->load_model("Order");
            $user_data = $user->check_login(true);

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $orders = $order->get_all_orders_by_user($user_data->url_address);

            if (is_array($orders)) {

                foreach ($orders as $key => $order_row) {

                    $details = $order->get_all_orders_details($order_row->orderId);
                    $orders[$key]->details = $details;
                }
                
            }

            $data["page_title"] = "Profile";
            $data["orders"] = $orders;
            
            $this ->view("profile", $data);
        }
    }
    
?>