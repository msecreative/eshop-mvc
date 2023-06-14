<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Category</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							<?php 
								if (isset($categories) && is_array($categories)) {
									foreach ($categories as $cat) {
										// This condition for subcategory
										if ($cat->parent > 0) {
											continue;
										}
										$parents = array_column($categories, "parent");
										// subcategory condition end
							?>
							<!-- category with subcategory -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#<?=$cat->category ?>">
										<?php 
											if (in_array($cat->catId, $parents)) {
										?>
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
										<?php } ?>
											<?=$cat->category ?>
										</a>
									</h4>
								</div>
								<?php 
									if (in_array($cat->catId, $parents)) {
								?>
								<div id="<?=$cat->category ?>" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>
											<?php 
												foreach ($categories as $sub_cat) {
													if ($sub_cat->parent == $cat->catId) {
											?>
											<li><a href=""><?=$sub_cat->category ?> </a></li>
											<?php } } ?>
										</ul>
									</div>
								</div>
								<?php } ?>
							</div>
							<?php } } ?>
					
						</div><!--/category-productsr-->
						
						<div class="shipping text-center"><!--shipping-->
							<img src="<?=ASSETS . THEME?>images/home/shipping.jpg" alt="" />
						</div><!--/shipping-->
					</div>
				</div>