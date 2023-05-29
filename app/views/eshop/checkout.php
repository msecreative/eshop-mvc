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

			<div class="register-req">
				<p>Please use Register And Checkout to easily get access to your order history, or use Checkout as Guest</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-8 clearfix">
						<div class="bill-to">
							<p>Bill To</p>
							<form>
								<div class="form-one">
								
									<input type="text" placeholder="Address 1 *" autofocus>
									<input type="text" placeholder="Address 2">
									<input type="text" placeholder="Phone *">
									<input type="text" placeholder="Mobile Phone">
								</div>
								<div class="form-one" style="margin-left: 5%;">
									<input type="text" placeholder="Zip / Postal Code *">
									<select>
										<option>-- Country --</option>
										<option>United States</option>
										<option>Bangladesh</option>
										<option>UK</option>
										<option>India</option>
										<option>Pakistan</option>
										<option>Ucrane</option>
										<option>Canada</option>
										<option>Dubai</option>
									</select>
									<select>
										<option>-- State / Province / Region --</option>
										<option>United States</option>
										<option>Bangladesh</option>
										<option>UK</option>
										<option>India</option>
										<option>Pakistan</option>
										<option>Ucrane</option>
										<option>Canada</option>
										<option>Dubai</option>
									</select>
								</div>
							</form>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="order-message">
							<p>Shipping Order</p>
							<textarea name="message"  placeholder="Notes about your order, Special Notes for Delivery" rows="10"></textarea>
						</div>	
					</div>					
				</div>
			</div>
			
			<div style="display: flex;align-items: center;justify-content: space-between;width: 100%; margin-bottom: 50px;">
				<a href="<?=ROOT?>cart">
					<input type="button" class="btn btn-primary pull-right" value="Back to cart" name="">
				</a>
				<a href="<?=ROOT?>pay">
					<input type="button" class="btn btn-primary pull-left" value="Payment" name="">
				</a>
			</div>
		</div>
	</section> <!--/#cart_items-->

	

	<?php $this->view("footer", $data) ?>