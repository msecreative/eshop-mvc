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
				if (is_array($order_details)) {

			?>
			<div class="register-req">
				<p>Please confirm the information below</p>
			</div><!--/register-req-->

			<div class="shopper-informations">

				<div class="order-table">
                    <h4><i class="fa fa-angle-right"></i>Product List</h4>  
                    <hr>
                    <table class="table table-striped table-advance table-hover table-class">
                        <thead>
                            <tr>
                                <th>Serial</th>
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
                                $order = (object)$order;
                                $i++;
                            ?>
                            <tr>
                                <td><?=$i ?></td>
                                <td><a href="<?=ROOT?>profile/<?=$order->user_name->url_address?>"><?=$order["user_name"]->name ?></a></td>
                                <td style="font-size: 10px;"><?=$order->delevery_address ?></td>
                                <td>$<?=$order->total ?></td>
                                <td style="font-size: 10px;"><?=date("d-M-Y H:i:a", strtotime($order->date)) ?></td>
                                <td>
                                    <i class="fa fa-arrow-down"></i>
                                    <div class="js-order-details order-details">
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