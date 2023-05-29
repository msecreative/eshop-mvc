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
				  <li><a href="#">Home</a></li>
				  <li class="active">Check out</li>
				</ol>
			</div><!--/breadcrums-->
			<?php 
				if (is_array($product_rows)) {

			?>
			<div class="register-req">
				<p>Please use Register And Checkout to easily get access to your order history, or use Checkout as Guest</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<form method="POST">
					<div class="row">
						<div class="col-sm-8 clearfix">
							<div class="bill-to">
								<p>Bill To</p>
								<div class="form-one">
								
									<input name="address1" type="text" placeholder="Address 1 *" autofocus="autofocus" required>
									<input name="address2" type="text" placeholder="Address 2">
									<input name="phone" type="text" placeholder="Phone *" required>
									<input name="mobilePhone" type="text" placeholder="Mobile Phone" required>
								</div>
								<div class="form-one" style="margin-left: 5%;">
									<input name="postcode" type="text" placeholder="Zip / Postal Code *" required>
									<select name="country" class="js-country" onchange="get_states(this.value)" required>
										<option>-- Country --</option>
										<?php 
											if (isset($countries) && is_array($countries)) {
												foreach ($countries as $country) {
													
										?>
										<option value="<?=$country->countryId ?>"><?=$country->country ?></option>
										<?php } } ?>
										
									</select>
									<select name="state" class="js-state" required>
										<option>-- State / Province / Region --</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="order-message">
								<p>Shipping Order</p>
								<textarea name="message"  placeholder="Notes about your order, Special Notes for Delivery" rows="10"></textarea>
							</div>	
						</div>
											
					</div>
					<div style="display: flex;align-items: center;justify-content: space-between;width: 100%; margin-bottom: 50px;">
						<a href="<?=ROOT?>cart">
							<input type="button" class="btn btn-primary pull-right" value="Back to cart" name="">
						</a>
						<a href="<?=ROOT?>pay">
							<input type="submit" class="btn btn-primary pull-left" value="Payment" name="">
						</a>
					</div>
				</form>
				<?php }else{ ?>
					<div style="padding-bottom:50px;overflow:hidden">
						<p style="display:block; padding:6px; text-align:center; font-size:18px;">Please add some items in the cart first!</p>
						<a href="<?=ROOT?>cart">
							<input type="button" class="btn btn-primary pull-left" value="Back to cart" name="">
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
							select_input.innerHTML += "<option value='"+obj.data[i].stateId+"'>"+obj.data[i].state+"</option>";
							
						}
					}
				}
			}
		}
	</script>

	

	<?php $this->view("footer", $data) ?>