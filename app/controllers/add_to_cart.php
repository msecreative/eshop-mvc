<?php 
    class Add_to_cart extends Controller
    {
        public function index($pId = "") {

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
            show($_SESSION);
            //unset($_SESSION["CART"]);
            //header("Location: " . ROOT . "shop");die;
        }
    }
    
?>