<?php $this->view("header", $data) ?>

<style>
	.form-one > select {
    padding: 10px 5px;
}
</style>

	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="<?=ROOT?>shop">Shop</a></li>
				  <li class="active">Check out</li>
				</ol>
			</div><!--/breadcrums-->
			<?php 
				if (is_array($orders)) {

			?>
			<div class="register-req">
				<p>Please confirm the information below</p>
			</div><!--/register-req-->

			<div class="shopper-informations">

				<div class="order-table">
                    <h4><i class="fa fa-angle-right"></i>Order Details</h4>  
                    <hr>
                        <?php 
                            $i = 0;
                            foreach ($orders as $order) {
                            $order = (object)$order;
                            $order->orderId = 0;
                            $i++;
                        ?>
                            <div class="js-order-details order-details">
                                <div style="display: flex; justify-content:space-between; align-items:center">
                                    <div>
                                        <h3>Order No: <?=$order->orderId ?></h3>
                                    </div>
                                </div>
                                <hr>
                                <div style="display: flex;">
                                    <table class="table table-striped table-advance table-hover" style="flex:1;margin:5px">
                                        <tr><th>Country</th>:<td><?=$order->country?></td></tr>
                                        <tr><th>State</th><td><?=$order->state?></td></tr>
                                        <tr><th>Delevery Address 1</th><td><?=$order->address1?></td></tr>
                                        <tr><th>Delevery Address 2</th><td><?=$order->address2?></td></tr>
                                    </table>
                                    <table class="table table-striped table-advance table-hover" style="flex:1;margin:5px">
                                        <tr><th>Phone</th><td><?=$order->phone?></td></tr>
                                        <tr><th>Mobile</th><td><?=$order->mobilePhone?></td></tr>
                                        <tr><th>Order Date</th><td><?=date("Y-m-d")?></td></tr>
                                        
                                    </table>
                                </div>
                                <br>
                                <hr>
                                <h4>Order Summary</h4>
                                <?php 
                                    if (isset($order_details) && is_array($order_details)) {
                                        
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
                                        <?php foreach ($order_details as $value) {  ?>
                                        <tr>
                                            <td><?=$i ?></td>
                                            <td><?=$value->description ?></td>
                                            <td><?=$value->cart_qty ?></td>
                                            <td><?=$value->price ?></td>
                                            <td><?=$value->price * $value->cart_qty ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php }else{ ?>
                                    <div>No order details found</div>
                                <?php } ?>
                                <div style="float: right;"><h3>Sub Total: <?=$sub_total ?></h3> </div>
                            </div>
                            
                        <?php } ?>
                </div>
                <div style="padding-bottom:50px;overflow:hidden">
                    <a href="<?=ROOT?>checkout">
                        <input type="button" class="btn btn-primary pull-left" value="Back to checkout" name="">
                    </a>
                </div>
                
			
                    <?php }else{ ?>
                        <div style="padding-bottom:50px;overflow:hidden">
                            <p style="display:block; padding:6px; text-align:center; font-size:18px;">Please add some items in the cart first!</p>
                            <a href="<?=ROOT?>checkout">
                                <input type="button" class="btn btn-primary pull-left" value="Back to checkout" name="">
                            </a>
                        </div>
                    <?php } ?>

			</div>
		</div>
	</section> <!--/#cart_items-->

	<script>
		 
		function get_states(countryId){
				sendData({
					countryId:countryId.trim()
				},"get_states");
		}

		// Send only post data
		function sendData(data = {},data_type){

			var ajax = new XMLHttpRequest();
			ajax.addEventListener("readystatechange", function(){
				if (ajax.readyState == 4 && ajax.status == 200) {
					handleResult(ajax.responseText);
				}
			});
			ajax.open("POST", "<?=ROOT?>ajax_checkout/"+data_type+"/"+JSON.stringify(data), true);
			ajax.send();
		}

		function handleResult(result){
			console.log(result);
			if (result != "") {
				var obj = JSON.parse(result);

				if (typeof obj.data_type != "undefined") {

					if (obj.data_type == "get_states") {
						var select_input = document.querySelector(".js-state");
						select_input.innerHTML = "<option>-- State / Province / Region --</option>";
						for (var i = 0; i < obj.data.length; i++) {

							
							obj.data[i].state
							select_input.innerHTML += "<option value='"+obj.data[i].state+"'>"+obj.data[i].state+"</option>";
							
						}
					}
				}
			}
		}
	</script>

	<?php $this->view("footer", $data) ?>