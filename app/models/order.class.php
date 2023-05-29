<?php 
    class Order{
        
        public function save_order($post,$product_rows,$user_url,$sessionid){
            show($user_url);
            $total = 0;
            foreach ($product_rows as $row) {
                $total = $row->cart_qty * $row->price;
            }
            $db = Database::newInstance();

            if ($product_rows) {
            
            $data = array();
            //$data["orderDetailId"] = $orderDetailId;
            $data["user_url"]         = $user_url;
            $data["sessionId"]        = $sessionid;
            $data["delevery_address"] = $post["address1"] ." " .$post["address2"];
            $data["total"]            = $total;
            $data["country"]          = $post["country"];
            $data["state"]            = $post["state"];
            $data["zip"]              = $post["postcode"];
            $data["tax"]              = 0;
            $data["shipping"]         = 0;
            $data["phone"]            = $post["phone"];
            $data["mobilePhone"]      = $post["mobilePhone"];
            $data["date"]             = date("Y-m-d H:i:s");
            

            //show($product_rows);
            $sql = "INSERT INTO orders(user_url,delevery_address,total,country,`state`,zip,tax,shipping,sessionId,phone,mobilePhone,`date`) VALUES(:user_url,:delevery_address,:total,:country,:state,:zip,:tax,:shipping,:sessionId,:phone,:mobilePhone,:date)";
            $result = $db->write($sql, $data);

            }

        }
    }
?>
