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
				if (is_array($product_rows)) {

			?>
			<div class="register-req">
				<p>Please add some information below</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<?php 
					if (isset($errors) && count($errors) > 0) {
						foreach ($errors as $error) {?>
						<div class='alert alert-danger'><?=$error?></div>
					<?php	}
					}
				?>
				<?php 

					$address1 = "";
					$address2 = "";
					$phone = "";
					$mobilePhone = "";
					$postcode = "";
					$country = "";
					$state = "";
					$message = "";
					if (isset($POST_DATA)) {

						extract($POST_DATA);
					}
				?>
				<form method="POST">
					<div class="row">
						<div class="col-sm-8 clearfix">
							<div class="bill-to">
								<p>Bill To</p>
								<div class="form-one">
								
									<input name="address1" value="<?=$address1?>" type="text" placeholder="Address 1 *" autofocus="autofocus" required>
									<input name="address2" value="<?=$address2?>" type="text" placeholder="Address 2">
									<input name="phone" value="<?=$phone?>" type="text" placeholder="Phone *" required>
									<input name="mobilePhone" value="<?=$mobilePhone?>" type="text" placeholder="Mobile Phone" required>
								</div>
								<div class="form-one" style="margin-left: 5%;">
									<input name="postcode"	value="<?=$postcode?>" type="text" placeholder="Zip / Postal Code *" required>

									<select name="country"	value="<?=$country?>" class="js-country" onchange="get_states(this.value)" required>
										<?php 
											if ($country == "") {
												echo "<option>-- Country --</option>";
											}else{

												echo "<option>$country</option>";	
											}
										?>
										<?php 
											if (isset($countries) && is_array($countries)) {
												foreach ($countries as $country) {
													
										?>
										<option value="<?=$country->country ?>"><?=$country->country ?></option>
										<?php } } ?>
										
									</select>
									<select name="state"	value="<?=$state?>" class="js-state" required>
										<?php 
											if ($state == "") {
												echo "<option>-- State / Province / Region --</option>";
											}else{
												echo "<option>$state</option>";
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="order-message">
								<p>Shipping Order</p>
								<textarea name="message" placeholder="Notes about your order, Special Notes for Delivery" rows="10"><?=$message?></textarea>
							</div>	
						</div>
											
					</div>
					<div style="display: flex;align-items: center;justify-content: space-between;width: 100%; margin-bottom: 50px;">
						<a href="<?=ROOT?>cart">
							<input type="button" class="btn btn-primary pull-right" value="Back to cart" name="">
						</a>
						<input type="submit" class="btn btn-primary pull-left" value="Continue" name="">
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
		 
		function get_states(country){
				sendData({
					country:country.trim()
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

			var info = {};
			info.data_type = data_type;
			info.data = data;

			ajax.open("POST", "<?=ROOT?>ajax_checkout", true);
			ajax.send(JSON.stringify(info));
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