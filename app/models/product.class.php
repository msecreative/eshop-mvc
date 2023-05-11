<?php 
    class Product{
        
        public function create($DATA){

            $db = Database::newInstance();
            $arr['description'] = ucwords($DATA->data);

            if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['description']))) {
                $_SESSION['error'] = "Please enter a valid product name";
            }

            if (isset($_SESSION['error']) || $_SESSION['error'] == "") {
            
                $sql = "INSERT INTO products (`description`) VALUES (:description)";
                
                $check = $db->write($sql, $arr);
                if ($check) {
                    return true;
                }
            }

            return false;
        } 

        public function edit($pId,$description){

            $db = Database::newInstance();
            $arr['pId'] = $pId;
            $arr['description'] = $description;
            $sql = "UPDATE products SET `description` = :description  WHERE pId = :pId LIMIT 1";
            $db->write($sql,$arr);

        } 

        public function delete($pId){

            $db = Database::newInstance();
            $pId = (int)$pId;
            $sql = "DELETE FROM products WHERE pId = '$pId' LIMIT 1";
            $db->write($sql);

        } 
        public function getAllproduct(){
            $db = Database::newInstance();
            return $db->read("SELECT * FROM products ORDER BY pId DESC");


        }

        public function make_table($allproduct){
            $result = "";
            if (is_array($allproduct)) {
                $i = 1;
                foreach ($allproduct as $productRow) {
                    $productRow->disabled = $productRow->disabled ? "Enabled" : "Disabled";
                    $status_color = $productRow->disabled == "Enabled" ? "info" : "danger";

                    $args = $productRow->pId.",'".$productRow->disabled."'";
                    $editArgs = $productRow->pId.",'".$productRow->product."'";
                    $result .= "<tr>";
                        $result .= '
                            <td>'.$i.'</td>
                            <td class="hidden-phone"><a href="'.$productRow->pId.'">'.$productRow->product.'</a></td>
                            <td><span onclick="disable_row('.$args.')" class="label label-'.$status_color.' label-mini" style="cursor:pointer">'.$productRow->disabled.'</span></td>
                            <td>
                                <!--<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>-->
                                <button onclick="show_edit_product('.$editArgs.')" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                <button onclick="delete_row('.$productRow->pId.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                            </td>
                        ';
                    $result .= "</tr>";
                    $i++;
                }
            }

            return $result;

        } 
    }
?>