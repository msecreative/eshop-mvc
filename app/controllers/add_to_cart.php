<?php 
    class Add_to_cart extends Controller
    {
        private $redirect_to = "";
        public function index($pId = "") {

            $this->set_redirect();

            $pId = esc($pId);
            $db = Database::newInstance();
    
            $product_rows = $db->read("SELECT * FROM products WHERE pId = :pId LIMIT 1", ["pId"=>$pId]);

            if ($product_rows) {
                $product_row = $product_rows[0];
                if (isset($_SESSION["CART"])) {
                    $pIds = array_column($_SESSION["CART"], "pId");
                    if (in_array($product_row->pId, $pIds)) {
                        $key = array_search($product_row->pId, $pIds);
                        $_SESSION["CART"][$key]["qty"]++;
                    }else{
                        $arr = array();
                        $arr["pId"] = $product_row->pId;
                        $arr["qty"] = 1;
    
                        $_SESSION["CART"][] = $arr;
                    }
                }else{
                    $arr = array();
                    $arr["pId"] = $product_row->pId;
                    $arr["qty"] = 1;

                    $_SESSION["CART"][] = $arr;
                   
                }
                
            }
            header("Location:" . ROOT . "cart");
            die;
        }

        public function add_quantity($pId = "") {

            $this->set_redirect(); 
            $pId = esc($pId);
            if (isset($_SESSION["CART"])) {
                foreach ($_SESSION["CART"] as $key => $item) {
                   if ($item["pId"] == $pId) {
                    $_SESSION["CART"][$key]["qty"]+= 1;
                    break;
                   }
                }
            }
            $this->redirect();
        }
        public function subtract_quantity($pId = "") {

            $this->set_redirect();
            $pId = esc($pId);
            if (isset($_SESSION["CART"])) {
                foreach ($_SESSION["CART"] as $key => $item) {
                   if ($item["pId"] == $pId) {
                    $_SESSION["CART"][$key]["qty"]--;
                    break;
                   }
                }
            } 
            $this->redirect();       

        }
        public function remove($pId = "") {
            $this->set_redirect();
            $pId = esc($pId);
            if (isset($_SESSION["CART"])) {
                foreach ($_SESSION["CART"] as $key => $item) {
                   if ($item["pId"] == $pId) {
                    unset($_SESSION["CART"][$key]);
                    $_SESSION["CART"] = array_values($_SESSION["CART"]);
                    //show($_SESSION["CART"]);
                    break;
                   }
                }
            }
            $this->redirect();
        }

        private function redirect(){
            header("Location:" . $this->redirect_to);
            die;
        }
        private function set_redirect(){

            if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != "") {
               $this->redirect_to = $_SERVER["HTTP_REFERER"];
            }else{
                $this->redirect_to = ROOT ."shop";
            }
            show($_SERVER);
        }
    }
    
?>