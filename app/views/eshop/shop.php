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
						<ul class="pagination">
							<li><a href="<?=Page::links()->prev ?>">Prev</a></li>
							<?php 
								$max = Page::links()->current + 3;
								$cur = (Page::links()->current > 3) ? (Page::links()->current - 3) : "1";

								for ($i=$cur; $i < $max; $i++) { 
							?>
							<li class="<?=Page::links()->current == $i ? 'active' : ''; ?>"><a href="<?=Page::generate($i) ?>"><?=$i ?></a></li>
							<?php } ?>
							<li><a href="<?=Page::links()->next?>">Next</a></li>
						</ul>
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
	
	<?php $this->view("footer", $data) ?>