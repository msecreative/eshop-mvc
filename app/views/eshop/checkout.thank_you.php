<?php $this->view("header", $data) ?>



	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="<?=ROOT?>shop">Shop</a></li>
				  <li class="active"><?=$data["page_title"] ?></li>
				</ol>
			</div><!--/breadcrums-->
		
			<div class="register-req">
				<p>Thank you for shopping with us!</p>
			</div><!--/register-req-->

			<div class="shopper-informations">

                <div style="display: flex;align-items: center;justify-content: space-between;width: 100%; margin-bottom: 50px;">
                    <a href="<?=ROOT?>shop">
                        <input type="button" class="btn btn-primary pull-right" value="Back to shop" name="">
                    </a>

                    <a href="<?=ROOT?>profile">
                        <input type="button" class="btn btn-primary pull-right" value="Back to profile" name="">
                    </a>
                </div>

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