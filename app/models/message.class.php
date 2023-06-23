<?php
    class Message {

        protected $error = array();

        public function create($DATA){

            $this->error = array();

            $db = Database::newInstance();
            $arr['name']      = ucwords($DATA["name"]);
            $arr['email']     = $DATA["email"];
            $arr['subject']   = ucwords($DATA["subject"]);
            $arr['message']   = ucwords($DATA["message"]);
            $arr['date']      = date("Y-m-d H:i:s");

            if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['name']))) {
                $this->error[] = "Only letter and spacess are allowed";
            }
            if (empty($arr['email']) || !filter_var($arr['email'], FILTER_VALIDATE_EMAIL)) {
                $this->error[] = "Please enter a valid emails";
            }
            if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['subject']))) {
                $this->error[] = "Please enter a valid subject";
            }
            if (empty($arr['message'])) {
                $this->error[] = "Please enter a valid message";
            }

            if (count($this->error) == 0) {
            
                $sql = "INSERT INTO contact_us (`name`,`email`,`subject`,`message`,`date`) VALUES (:name,:email,:subject,:message,:date)";
                
                $check = $db->write($sql, $arr);
                if ($check) {
                    return true;
                }
            }

            return $this->error;
        } 

        public function delete($catId){

            $db = Database::newInstance();
            $catId = (int)$catId;
            $sql = "DELETE FROM categories WHERE catId = '$catId' LIMIT 1";
            $db->write($sql);

        } 
        // Get All Category
        public function getAllCategory(){
            $db = Database::newInstance();
            return $db->read("SELECT * FROM categories ORDER BY catId DESC");



        }
        // Get single category
        public function getSingleCategory($catId){
            $catId = (int)$catId;
            $db = Database::newInstance();
            $data =  $db->read("SELECT category FROM categories WHERE catId = '$catId' LIMIT 1 ");
            return $data[0];


        }
        // Get single category by name
        public function get_one_by_name($name){
            $name = str_replace("-"," ",$name);
            $name = addslashes($name);
            $db = Database::newInstance();
            $data =  $db->read("SELECT * FROM categories WHERE category LIKE :name LIMIT 1", ["name"=>$name]);
            return $data[0];
        }

        public function make_table($allCategory){
            $result = "";
            if (is_array($allCategory)) {
                $i = 1;
                foreach ($allCategory as $catRow) {
                    $catRow->disabled = $catRow->disabled ? "Enabled" : "Disabled";
                    $status_color = $catRow->disabled == "Enabled" ? "info" : "danger";

                    $args = $catRow->catId.",'".$catRow->disabled."'";
                    $editArgs = $catRow->catId.",'".$catRow->category."',".$catRow->parent;

                    $parent = "";
                    foreach ($allCategory as $catRow2) {
                        if ($catRow->parent == $catRow2->catId) {
                           $parent = $catRow2->category;
                        }
                    }
                    $result .= "<tr>";
                        $result .= '
                            <td>'.$i.'</td>
                            <td class="hidden-phone"><a href="'.$catRow->catId.'">'.$catRow->category.'</a></td>
                            <td class="hidden-phone"><a href="'.$catRow->parent.'">'.$parent.'</a></td>
                            <td><span onclick="disable_row('.$args.')" class="label label-'.$status_color.' label-mini" style="cursor:pointer">'.$catRow->disabled.'</span></td>
                            <td>
                                <!--<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>-->
                                <button onclick="show_edit_category('.$editArgs.')" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
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

