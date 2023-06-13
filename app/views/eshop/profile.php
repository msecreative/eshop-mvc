<?php $this->view("header", $data) ?>
<style>
        /*White Panel */
    .white-panel {
        text-align: center;
        background: #f4f4f4;
        color: #11151b;
        margin-bottom: 40px;
        padding-bottom: 30px;
    }

    .white-panel p {
        margin-top: 5px;
        font-weight: 700;
        margin-left: 15px;
    }
    .white-panel .white-header {
        background: #fdb45e;
        padding: 3px;
        margin-bottom: 15px;
        color: #11151b;
    }
    .white-panel .small {
        font-size: 10px;
        color: #11151b;
    }

    .white-panel i {
        color: #68dff0;
        padding-right: 4px;
        font-size: 14px;
    }
    .pn:hover {
        box-shadow: 2px 3px 2px rgba(0, 0, 0, 0.3);
    }

    .order-table>table tbody>tr>td {
        font-size: 10px;
    }
    .order-details {
        background-color: #eee;
        box-shadow: 0px 0px 10px #aaa;
        width: 95%;
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
<section class="user-profile">
    <div class="container">
        <div class="row">
            <?php 
                if (is_object($profile_data)) {
            ?>
            <div class="col-md-4">
                <!-- WHITE PANEL - TOP USER -->
                <div class="white-panel pn">
                    <div class="white-header">
                        <h5><?=strtoupper($profile_data->rank) ?></h5>
                    </div>
                    <p><img src="<?=ASSETS . THEME ?>admin/img/ui-zac.jpg" class="img-circle" width="80"></p>
                    <p><b><?=$profile_data->name ?></b></p>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="small mt">MEMBER SINCE</p>
                            <p><?=date("d-M-Y", strtotime($profile_data->date)) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="small mt">TOTAL SPEND</p>
                            <p>$ 47,60</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="">Edit</a>
                        </div>
                        <div class="col-md-6">
                            <a href="">Delete</a>
                        </div>
                    </div>
                </div>
            </div><!-- /col-md-4 -->
            
            <div class="col-md-8">
                
                <?php 
                    if (is_array($orders)) {
                        
   
                ?>
                <div class="order-table">
                    <table class="table table-striped table-advance table-hover table-class">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Order No</th>
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
                                <td style="font-size: 10px;"><?=$order->delevery_address ?></td>
                                <td>$<?=$order->total ?></td>
                                <td style="font-size: 10px;"><?=date("d-M-Y H:i:a", strtotime($order->date)) ?></td>
                                <td>
                                    <i class="fa fa-arrow-down"></i>
                                    <div class="js-order-details order-details hide">
                                        <div style="float: right; margin-bottom:20px" class="btn btn-danger">Close</div>
                                        <div style="float: left; margin-bottom:20px;"><h3>Order No: <?=$order->orderId ?></h3></div>
                                        <?php 
                                            if (isset($order->details) && is_array($order->details)) { 
                                        ?>
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
                                                <?php $sl =0; foreach ($order->details as $value) { $sl++;  ?>
                                                <tr>
                                                    <td><?=$sl ?></td>
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
            </div>
            <?php }else{ ?>
                <div class="col-md-4"><p>Profile cann't found</p></div>
            <?php } ?>
        </div>
    </div>
</section>

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

<?php $this->view("footer", $data) ?>