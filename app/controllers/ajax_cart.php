<?php 
    class Ajax_Cart extends Controller
    {
        public function index() {
          
        }
        public function delete_item($data = "") {
            $obj = json_decode($data);

            $pId = esc($obj->pId);
            if (isset($_SESSION["CART"])) {
                foreach ($_SESSION["CART"] as $key => $item) {
                   if ($item["pId"] == $pId) {
                    unset($_SESSION["CART"][$key]);
                    $_SESSION["CART"] = array_values($_SESSION["CART"]);
                    break;
                   }
                }
            }

            $obj->data_type = "delete_item";
            echo json_encode($obj);
        }
        public function edit_quantity($data = "") {
            $obj = json_decode($data);

            $quantity = esc($obj->quantity);
            $pId      = esc($obj->pId);

            if (isset($_SESSION["CART"])) {
                foreach ($_SESSION["CART"] as $key => $item) {
                   if ($item["pId"] == $pId) {
                    $_SESSION["CART"][$key]["qty"] = (int)$quantity;
                    break;
                   }
                }
            }

            $obj->data_type = "edit_quantity";
            echo json_encode($obj);
        }

        
    }   
    
?>