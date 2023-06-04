<?php 
    class Order extends Controller{

        public $errors = array();
        
        public function save_order($post,$product_rows,$user_url,$sessionid){
            foreach ($post as $key => $value) {
                
                if ($key == "country") {
                    if ($value == "" || $value == "-- Country --") {
                        $this->errors[] = "Please enter a valid country";
                    }
                }
                if ($key == "state") {
                    if ($value == "" || $value == "-- State / Province / Region --") {
                        $this->errors[] = "Please enter a valid state";
                    }
                }
            }
            // return;
            //show($user_url);
            //show($post);die;
            $total = 0;
            foreach ($product_rows as $row) {
                $total += $row->cart_qty * $row->price;
            }
            $db = Database::newInstance();

            if (is_array($product_rows) && count($this->errors) == 0) {

                $countries = $this->load_model("Countries");
                // $data["countries"] = $countries->get_countries();
                
                $data = array();
                //$data["orderDetailId"] = $orderDetailId;
                $data["user_url"]         = $user_url;
                $data["sessionId"]        = $sessionid;
                $data["delevery_address"] = $post["address1"] ." " .$post["address2"];
                $data["total"]            = $total;
                $country_obj              = $countries->get_country($post["country"]);
                $data["country"]          = $country_obj->country;
                $state_obj                = $countries->get_state($post["state"]);
                $data["state"]            = $state_obj->state;
                $data["zip"]              = $post["postcode"];
                $data["tax"]              = 0;
                $data["shipping"]         = 0;
                $data["phone"]            = $post["phone"];
                $data["mobilePhone"]      = $post["mobilePhone"];
                $data["date"]             = date("Y-m-d H:i:s");
                

                //show($product_rows);
                $sql = "INSERT INTO orders(user_url,delevery_address,total,country,`state`,zip,tax,shipping,sessionId,phone,mobilePhone,`date`) VALUES(:user_url,:delevery_address,:total,:country,:state,:zip,:tax,:shipping,:sessionId,:phone,:mobilePhone,:date)";
                $result = $db->write($sql, $data);
                //Save Details
                
                $orderId = 0;
                
                $sql = "SELECT orderId FROM orders ORDER BY orderId DESC LIMIT 1";
                $result = $db->read($sql);
                
                if (is_array($result)) {
                    $orderId = $result[0]->orderId;
                }
                
                foreach ($product_rows as $row) {

                    $data = array();
                    $data['orderId']     = $orderId;
                    $data['qty']         = $row->cart_qty;
                    $data['description'] = $row->description;
                    $data['amount']      = $row->price;
                    $data['total']       = $row->cart_qty * $row->price;
                    $data['pId']         = $row->pId;

                    $sql = "INSERT INTO order_details (orderId,qty,description,amount,total,pId) VALUES (:orderId,:qty,:description,:amount,:total,:pId)";
                    $result = $db->write($sql, $data);

                }
            }

        }

        public function get_all_orders_by_user(){

            $orders = false;

            $db = Database::newInstance();

            $sql = "SELECT * FROM orders ORDER BY orderId DESC  limit 100";
            $orders = $db->read($sql);
        
            return $orders;
        }
        public function get_all_orders_details($orderId){

            $details = false;
            $data["orderId"] = addslashes($orderId);

            $db = Database::newInstance();

            $sql = "SELECT * FROM order_details WHERE orderId = :orderId ORDER BY orderDetailId DESC";
            $details = $db->read($sql,$data);
        
            return $details;
        }
    }
?>
