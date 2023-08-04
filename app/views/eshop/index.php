
<?php $this->view("header", $data) ?>

<?php $this->view("slider", $data) ?>
	
	<section>
		<div class="container">
			<div class="row">
			<?php $this->view("sidebar.inc", $data) ?>
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>
						<div class="row">
							<?php 
								if (is_array($product_rows)) {
									foreach ($product_rows as $product) {
							?>
							<!-- include single product -->
							<?php $this->view("product.inc", $product); ?>
							<?php } } ?>
						</div>
				
					</div><!--features_items-->
					<?php if ( isset($segment_data) && is_array($segment_data)) { $num = 0; ?>
						
					<div class="category-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<?php 
									foreach ($segment_data as $key => $seg_data) { $num++ ?>
										<li class="<?=$num == 1 ? 'active' : '' ?>"><a href="#<?=$key?>" data-toggle="tab"><?=str_replace("-", " ", $key)?></a></li>
								<?php } ?>
							</ul>
						</div>
						<div class="tab-content">
							<?php
								$num1 = 0; 
								foreach ($segment_data as $key => $seg_data) { $num1++ ?>

								<div class="tab-pane fade <?=$num1 == 1 ? 'active in' : '' ?>" id="<?=$key?>" >
								<?php 
									foreach ($seg_data as $value) { ?>
									<div class="col-sm-3">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="<?= ROOT.$value->image ?>" alt="" />
													<h2>$<?=$value->price?></h2>
													<a href="productDetails/<?=$value->slag?>"><p><?=$value->description?></p></a>
													<a href="<?=ROOT?>add_to_cart/<?=$value->pId?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
												</div>
												
											</div>
										</div>
									</div>
								<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div><!--/category-tab-->
					<?php } ?>
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<?php if (isset($slider_rows) && is_array($slider_rows)) { 
									$num = 0;
								?>
									
								<?php foreach ($slider_rows as $slider) { $num++; ?>

									<div class="item <?=$num == 1 ? 'active' : ''?>">
									<?php 
										if ( is_array($slider) ) {
										foreach ($slider as $product) {
									?>
									<!-- include single product -->
										<?php $this->view("product.inc", $product); ?>
									<?php } } ?>
								</div>
							<?php } } ?>
							
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					<?php Page::show_links(); ?>
					
				</div>
			</div>
		</div>
	</section>
	

<?php $this->view("footer",$data); ?>