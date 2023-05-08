<?php 
    class Ajax extends Controller
    {
        public function index() {
           $data = file_get_contents("php://input");
            $data = json_decode($data);

            if (is_object($data) && isset($data->data_type)) {

                if ($data->data_type == "add_category") {
                    $category = $this->load_model("Category");
                    $check = $category->create($data);

                    if ($_SESSION["error"] != "") {
                        
                        $arr["message"] = $_SESSION["error"];
                        $_SESSION['error'] = "";
                        $arr["message_type"] = "error";
                        $arr["data"] = "";
                        $arr["data_type"] = "add_new";

                        echo json_encode($arr);
                    }else{
                        $arr["message"] = "Category added successfully";
                        $arr["message_type"] = "info";
                        $allCategory = $category->getAllCategory();
                        $arr["data"] = $category->make_table($allCategory);
                        $arr["data_type"] = "add_new";
                        
                        echo json_encode($arr);
                    }
                }elseif ($data->data_type == "delete_row") {

                        $arr["message"] = "Your category was successfully deleted";
                        $_SESSION['error'] = "";
                        $arr["message_type"] = "info";
                        $arr["data"] = "";
                        $arr["data_type"] = "delete_row";

                        echo json_encode($arr);
                }
            }
        }
    }
    
?>