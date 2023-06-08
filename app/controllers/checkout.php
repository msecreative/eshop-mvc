<?php 
    class Checkout extends Controller
    {
        public function index() {
            $user = $this->load_model("User");
            $image_class = $this->load_model("Image");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $db = Database::newInstance();
            $product_rows = false;
            $product_ids = array();

            if (isset($_SESSION["CART"])) {
                $product_ids = array_column($_SESSION["CART"], "pId");
                $ids_str = "'" . implode("','", $product_ids) . "'";

                $product_rows = $db->read("SELECT * FROM products WHERE pId in ($ids_str)");
            }
           
            if (is_array($product_rows)) {

                foreach ($product_rows as $key => $product_row) {
                
                    foreach ($_SESSION["CART"] as $item) {

                        if ($product_row->pId == $item["pId"]) {
                            $product_rows[$key]->cart_qty = $item["qty"];
                            break;
                        }
                    }
                    
                }
                
            }
           

            $data["page_title"] = "Checkout";

            $data["sub_total"] = 0;
            if ($product_rows) {
                foreach ($product_rows as $key => $product_row) {
                    $product_rows[$key]->image = $image_class->get_thumb_post($product_rows[$key]->image);
                    $mytotal = $product_row->price * $product_row->cart_qty;
                    $data["sub_total"] += $mytotal;
                }
            }
            
            if (is_array($product_rows)) {
                rsort($product_rows);
            }
            
            $data["product_rows"] = $product_rows;
            // get countries and states
            $countries = $this->load_model("Countries");
            $data["countries"] = $countries->get_countries();

            // Capture the from data
            //check if old post data exists
            if (isset($_SESSION["POST_DATA"])) {
                # code...
                $data["POST_DATA"] = $_SESSION["POST_DATA"];
            }

            if (count($_POST) > 0) {

                $order = $this->load_model("Order");
                $order->validate($_POST);
                $data["errors"] = $order->errors;

                $_SESSION["POST_DATA"] = $_POST;
                $data["POST_DATA"]     = $_POST;

                if (count($order->errors) == 0) {
                    header("Location:" .ROOT. "checkout/summary");
                    die;
                }
            }

            $this ->view("checkout", $data);
        }

        // Checkout summary

        public function summary() {

            $user = $this->load_model("User");
            $image_class = $this->load_model("Image");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $data["page_title"] = "Checkout Summary";

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["POST_DATA"])) {
                // show($_POST);
                // show($product_rows);
                $sessionid = session_id();

                $user_url = "";

                if (isset($_SESSION["user_url"])) {
                    $user_url = $_SESSION["user_url"];
                }
                $order = $this->load_model("Order");
                $order->save_order($_SESSION["POST_DATA"],$product_rows,$user_url,$sessionid);
                $data["errors"] = $order->errors;

                header("Location:" .ROOT. "thank_you");
                die;
            }

            $this ->view("checkout.summary", $data);
        }
    }
    
?>