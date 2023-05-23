<?php $this->view("header", $data) ?>

<style>
	td.cart_product img {
    width: 70px;
}
</style>
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Shopping Cart</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php 
						if ($product_rows) {
							foreach ($product_rows as $product_row) {
							
					?>
						<tr>
							<td class="cart_product">
								<a href="productDetails/<?=$product_row->slag?>"><img src="<?=ROOT . $product_row->image?>" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="productDetails/<?=$product_row->slag?>"><?=$product_row->description?></a></h4>
								<p>Web ID: <?=$product_row->pId?></p>
							</td>
							<td class="cart_price">
								<p>$<?=$product_row->price?></p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up" href="<?=ROOT?>add_to_cart/add_quantity/<?=$product_row->pId?>"> + </a>
									<input oninput="edit_quantity(this.value,'<?=$product_row->pId?>')" class="cart_quantity_input" type="text" name="quantity" value="<?=$product_row->cart_qty?>" autocomplete="off" size="2">
									<a class="cart_quantity_down" href="<?=ROOT?>add_to_cart/subtract_quantity/<?=$product_row->pId?>"> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">$<?=$product_row->price * $product_row->cart_qty ?></p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" delete_id="<?=$product_row->pId?>" onclick="delete_item(getAttribute('delete_id'))" href="<?=ROOT?>add_to_cart/remove/<?=$product_row->pId?>"><i class="fa fa-times"></i></a>
							</td>
						</tr>
					<?php } }else{ ?>
						<div style="font-size:18px; text-align:center;padding:6px">No item found!</div>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="pull-right" style="font-size: 25px;">Sub Total: $<?=number_format($sub_total, 2)?></div><br>
			<div style="display: flex;align-items: center;justify-content: space-between;width: 100%; margin-bottom: 20px;">
				<a href="<?=ROOT?>shop">
					<input type="button" class="btn btn-primary pull-left" value="Continue Shopping" name="">
				</a>
				<a href="<?=ROOT?>checkout">
					<input type="button" class="btn btn-primary pull-right" value="Checkout" name="">
				</a>
			</div>
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			<div class="heading">
				<h3>What would you like to do next?</h3>
				<p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="chose_area">
						<ul class="user_option">
							<li>
								<input type="checkbox">
								<label>Use Coupon Code</label>
							</li>
							<li>
								<input type="checkbox">
								<label>Use Gift Voucher</label>
							</li>
							<li>
								<input type="checkbox">
								<label>Estimate Shipping & Taxes</label>
							</li>
						</ul>
						<ul class="user_info">
							<li class="single_field">
								<label>Country:</label>
								<select>
									<option>United States</option>
									<option>Bangladesh</option>
									<option>UK</option>
									<option>India</option>
									<option>Pakistan</option>
									<option>Ucrane</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
								
							</li>
							<li class="single_field">
								<label>Region / State:</label>
								<select>
									<option>Select</option>
									<option>Dhaka</option>
									<option>London</option>
									<option>Dillih</option>
									<option>Lahore</option>
									<option>Alaska</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
							
							</li>
							<li class="single_field zip-field">
								<label>Zip Code:</label>
								<input type="text">
							</li>
						</ul>
						<a class="btn btn-default update" href="">Get Quotes</a>
						<a class="btn btn-default check_out" href="">Continue</a>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Cart Sub Total <span>$<?=number_format($sub_total, 2)?></span></li>
							<li>Eco Tax <span>$2</span></li>
							<li>Shipping Cost <span>Free</span></li>
							<li>Total <span>$<?=number_format($sub_total, 2)?></span></li>
						</ul>
							<a class="btn btn-default update" href="">Update</a>
							<a class="btn btn-default check_out" href="">Check Out</a>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->

	<script>
		// Edit product quantity
		function edit_quantity(quantity,pId){
			if (isNaN(quantity)) 
				return; 
				
				sendData({
					quantity:quantity.trim(),
					pId:pId.trim()
				},"edit_quantity");
		}

		function delete_item(pId){
				sendData({
					pId:pId.trim()
				},"delete_item");
		}

		// Send only post data
		function sendData(data = {},data_type){

			var ajax = new XMLHttpRequest();
			ajax.addEventListener("readystatechange", function(){
				if (ajax.readyState == 4 && ajax.status == 200) {
					handleResult(ajax.responseText);
				}
			});
			ajax.open("POST", "<?=ROOT?>ajax_cart/"+data_type+"/"+JSON.stringify(data), true);
			ajax.send();
		}

		function handleResult(result){
			console.log(result);
			if (result != "") {
				var obj = JSON.parse(result);

				if (typeof obj.data_type != "undefined") {

					if (obj.data_type == "delete_item") {
						window.location.href = window.location.href;
					}else
					if (obj.data_type == "edit_quantity") {
						window.location.href = window.location.href;
					}
				}
			}
		}
	</script>
	<?php $this->view("footer", $data) ?>