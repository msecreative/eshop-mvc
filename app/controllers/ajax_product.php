<?php 
    class Ajax_Product extends Controller
    {
        public function index() {
           $data = file_get_contents("php://input");
            $data = json_decode($data);

            show($_POST);
            show($_FILES);

            if (is_object($data) && isset($data->data_type)) {

                $db = Database::getInstance();
                $product = $this->load_model("Product");
                // Add new product
                if ($data->data_type == "add_product") {
                    $check = $product->create($data);

                    if ($_SESSION["error"] != "") {
                        
                        $arr["message"] = $_SESSION["error"];
                        $_SESSION['error'] = "";
                        $arr["message_type"] = "error";
                        $arr["data"] = "";
                        $arr["data_type"] = "add_new";

                        echo json_encode($arr);
                    }else{
                        $arr["message"] = "Product added successfully";
                        $arr["message_type"] = "info";
                        $allProduct = $product->getAllProduct();
                        $arr["data"] = $product->make_table($allProduct);
                        $arr["data_type"] = "add_new";
                        
                        echo json_encode($arr);
                    }
                }elseif ($data->data_type == "disable_row") {

                        $disabled = ($data->current_state == "Enabled") ? "0" : "1";
                        $pId = $data->pId;

                        $sql = "UPDATE products SET `disabled` = '$disabled' WHERE pId = '$pId' LIMIT 1";
                        $db->write($sql);

                        $arr["message"] = "";
                        $_SESSION['error'] = "";
                        $arr["message_type"] = "info";

                        $allProduct = $product->getAllProduct();
                        $arr["data"] = $product->make_table($allProduct);
                       
                        $arr["data_type"] = "disable_row";

                        echo json_encode($arr);
                
                }elseif ($data->data_type == "edit_product") {

                        $product->edit($data->pId, $data->product);
                        $arr["message"] = "Your product was successfully edited";
                        $_SESSION['error'] = "";
                        $arr["message_type"] = "info";

                        $allProduct = $product->getAllProduct();
                        $arr["data"] = $product->make_table($allProduct);

                        $arr["data_type"] = "edit_product";

                        echo json_encode($arr);

                }elseif ($data->data_type == "delete_row") {

                        $product->delete($data->pId);
                        $arr["message"] = "Your product was successfully deleted";
                        $_SESSION['error'] = "";
                        $arr["message_type"] = "info";

                        $allProduct = $product->getAllProduct();
                        $arr["data"] = $product->make_table($allProduct);

                        $arr["data_type"] = "delete_row";

                        echo json_encode($arr);
                }
            }
        }
    }
    
?>