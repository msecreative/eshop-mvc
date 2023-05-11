<?php 
    class Ajax extends Controller
    {
        public function index() {
           $data = file_get_contents("php://input");
            $data = json_decode($data);

            if (is_object($data) && isset($data->data_type)) {

                $db = Database::getInstance();
                $category = $this->load_model("Category");

                if ($data->data_type == "add_category") {
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
                }elseif ($data->data_type == "disable_row") {

                        $disabled = ($data->current_state == "Enabled") ? "0" : "1";
                        $catId = $data->catId;

                        $sql = "UPDATE categories SET `disabled` = '$disabled' WHERE catId = '$catId' LIMIT 1";
                        $db->write($sql);

                        $arr["message"] = "";
                        $_SESSION['error'] = "";
                        $arr["message_type"] = "info";

                        $allCategory = $category->getAllCategory();
                        $arr["data"] = $category->make_table($allCategory);
                       
                        $arr["data_type"] = "disable_row";

                        echo json_encode($arr);
                
                }elseif ($data->data_type == "edit_category") {

                        $category->edit($data->catId, $data->category);
                        $arr["message"] = "Your category was successfully edited";
                        $_SESSION['error'] = "";
                        $arr["message_type"] = "info";

                        $allCategory = $category->getAllCategory();
                        $arr["data"] = $category->make_table($allCategory);

                        $arr["data_type"] = "edit_category";

                        echo json_encode($arr);

                }elseif ($data->data_type == "delete_row") {

                        $category->delete($data->catId);
                        $arr["message"] = "Your category was successfully deleted";
                        $_SESSION['error'] = "";
                        $arr["message_type"] = "info";

                        $allCategory = $category->getAllCategory();
                        $arr["data"] = $category->make_table($allCategory);

                        $arr["data_type"] = "delete_row";

                        echo json_encode($arr);
                }
            }
        }
    }
    
?>