<?php $this->view("header", $data) ?>
	
	<section id="advertisement">
		<div class="container">
			<img src="<?=ASSETS . THEME?>images/shop/advertisement.jpg" alt="" />
		</div>
	</section>
	
	<section>
		<div class="container">
			<div class="row">

				<!-- sidebar start -->
				<?php $this->view("sidebar.inc", $data) ?>
				<!-- sidebar end -->

				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<div class="row">
							<h2 class="title text-center">Features Items</h2>
							<?php 
								if (isset($product_rows) && is_array($product_rows)) {
									foreach ($product_rows as $product) {
							?>
							<!-- include single product -->
							<?php $this->view("product.inc", $product); ?>
							<?php } } ?>
						</div>
						<?php show($page_links->prev) ?>
						<ul class="pagination">
							<li><a href="<?=$page_links->prev ?>">Prev</a></li>
							<li class="active"><a href="">1</a></li>
							<li><a href="">2</a></li>
							<li><a href="">3</a></li>
							<li><a href="<?=$page_links->next?>">Next</a></li>
						</ul>
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
	
	<?php $this->view("footer", $data) ?>