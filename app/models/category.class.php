<?php
    class Category {

        public function create($DATA){
            $db = Database::getInstance();
            $arr['category'] = ucwords($DATA->data);

            if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['category']))) {
                $_SESSION['error'] = "Please enter a valid category name";
            }

            if (isset($_SESSION['error']) || $_SESSION['error'] == "") {
            
                $sql = "INSERT INTO categories (category) VALUES (:category)";
                
                $check = $db->write($sql, $arr);
                if ($check) {
                    return true;
                }
            }

            return false;
        } 

        public function edit(){

        } 

        public function delete($catId){

            $db = Database::newInstance();
            $catId = (int)$catId;
            $sql = "DELETE FROM categories WHERE catId = '$catId' LIMIT 1";
            $db->write($sql);

        } 
        public function getAllCategory(){
            $db = Database::newInstance();
            return $db->read("SELECT * FROM categories ORDER BY catId DESC");


        }

        public function make_table($allCategory){
            $result = "";
            if (is_array($allCategory)) {
                $i = 1;
                foreach ($allCategory as $catRow) {
                    $catRow->disabled = $catRow->disabled ? "Enabled" : "Disabled";
                    $status_color = $catRow->disabled == "Enabled" ? "info" : "danger";
                    $args = $catRow->catId.",'".$catRow->disabled."'";
                    $result .= "<tr>";
                        $result .= '
                            <td>'.$i.'</td>
                            <td class="hidden-phone"><a href="'.$catRow->catId.'">'.$catRow->category.'</a></td>
                            <td><span onclick="disable_row('.$args.')" class="label label-'.$status_color.' label-mini" style="cursor:pointer">'.$catRow->disabled.'</span></td>
                            <td>
                                <!--<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>-->
                                <button onclick="edit_row('.$catRow->catId.')" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                <button onclick="delete_row('.$catRow->catId.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                            </td>
                        ';
                    $result .= "</tr>";
                    $i++;
                }
            }

            return $result;

        } 

    }