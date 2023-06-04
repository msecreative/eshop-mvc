<!-- Header -->
<?php $this->view("admin/header", $data) ?>
<style>
     .order-table>table tbody>tr>td {
        font-size: 10px;
    }
    .order-details {
        background-color: #eee;
        box-shadow: 0px 0px 10px #aaa;
        width: 97%;
        min-height: 100px;
        position:absolute;
        right: 0;
        margin: 20px;
        padding: 20px;
        z-index: 2;
    }

    .hide {
        display: none;
    }
</style>
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
    <!-- sidebar -->
    <?php $this->view("admin/sidebar", $data) ?>
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

          	<div class="row mt">
          		<div class="col-lg-12">
                    <div class="content-panel">
                           
                <?php 
                    if (is_array($orders)) {
   
                ?>
                <div class="order-table">
                    <h4><i class="fa fa-angle-right"></i>Product List</h4>  
                    <hr>
                    <table class="table table-striped table-advance table-hover table-class">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Order No</th>
                                <th>Customer Name</th>
                                <th>Delevery Address</th>
                                <th>Total</th>
                                <th>Order Date</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody onclick="show_details(event)">
                            <?php 
                                $i = 0;
                                foreach ($orders as $order) {
                                $i++;
                            ?>
                            <tr>
                                <td><?=$i ?></td>
                                <td><a href="<?=ROOT?>order_details"><?=$order->orderId ?></a></td>
                                <td><a href="<?=ROOT?>profile/<?=$order->user_name->url_address?>"><?=$order->user_name->name ?></a></td>
                                <td style="font-size: 10px;"><?=$order->delevery_address ?></td>
                                <td>$<?=$order->total ?></td>
                                <td style="font-size: 10px;"><?=date("d-M-Y H:i:a", strtotime($order->date)) ?></td>
                                <td>
                                    <i class="fa fa-arrow-down"></i>
                                    <div class="js-order-details order-details hide">
                                        <div style="display: flex; justify-content:space-between; align-items:center">
                                            <div>
                                                <h3>Order No: <?=$order->orderId ?></h3>
                                                <h4 style="margin-left:0">Customer Name: <?=$order->user_name->name ?></h4>
                                            </div>
                                            <div><button class="btn btn-danger">Close</button></div>
                                        </div>
                                        
                                        <?php 
                                            if (isset($order->details) && is_array($order->details)) { 
                                        ?>
                                        <hr>
                                        <div style="display: flex;">
                                            <table class="table table-striped table-advance table-hover" style="flex:1;margin:5px">
                                                <tr><th>Country</th>:<td><?=$order->country?></td></tr>
                                                <tr><th>State</th><td><?=$order->state?></td></tr>
                                                <tr><th>Delevery Address</th><td><?=$order->delevery_address?></td></tr>
                                            </table>
                                            <table class="table table-striped table-advance table-hover" style="flex:1;margin:5px">
                                                <tr><th>Phone</th><td><?=$order->phone?></td></tr>
                                                <tr><th>Mobile</th><td><?=$order->mobilePhone?></td></tr>
                                                <tr><th>Order Date</th><td><?=$order->date?></td></tr>
                                                
                                            </table>
                                        </div>
                                        <br>
                                        <hr>
                                        <table class="table table-striped table-advance table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Sl</th>
                                                    <th>Product Name</th>
                                                    <th>Amount</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($order->details as $value) {  ?>
                                                <tr>
                                                    <td><?=$i ?></td>
                                                    <td><?=$value->description ?></td>
                                                    <td><?=$value->qty ?></td>
                                                    <td><?=$value->amount ?></td>
                                                    <td><?=$value->total ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <div style="float: right;"><h3>Sub Total: <?=$order->total ?></h3> </div>
                                            
                                        <?php }else{ ?>
                                            <div>No order details found</div>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php }else{ ?>
                    <div>No order found</div>
                    <?php } ?>
                        
                    </div><!-- /content-panel -->
          		</div>
          	</div>
			
            <script>

                function show_details(e){
                    var row = e.target.parentNode;
                    if(row.tagName != "TR") row = row.parentNode;
                    var details = row.querySelector(".js-order-details");

                    var allRow = e.currentTarget.querySelectorAll(".js-order-details");
                    for (let i = 0; i < allRow.length; i++) {
                        if (allRow[i] != details) {
                            
                            allRow[i].classList.add("hide");
                        }
                        
                    }

                    if (details.classList.contains("hide")) {
                        details.classList.remove("hide");   
                    }else{
                        details.classList.add("hide");
                    }
                }
        </script>
      <!--main content end-->
 <!-- Footer -->
 <?php $this->view("admin/footer", $data) ?>