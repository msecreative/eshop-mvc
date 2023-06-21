<?php 
	if (isset($slider_row) && is_array($slider_row)) { 
?>

<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<?php 
								$i = 0;
								foreach($slider_row as $slider) { $i++; ?>	
									<li data-target="#slider-carousel" data-slide-to="<?=$i ?>" class="<?=$i == 1 ? 'active' : ''?>"></li>
							<?php } ?>
						</ol>
						
						<div class="carousel-inner">
						<?php 
							$num = 0;
							foreach($slider_row as $slider) { $num++;  ?>
							<div class="item <?=$num == 1 ? 'active' : ''?>">
								<div class="col-sm-6">
									<h1><span><?=substr($slider->header1_text,0,1) ?></span><?=substr($slider->header1_text,1) ?></h1>
									<h2><?=$slider->header2_text?></h2>
									<p><?=$slider->text?></p>
									<a href="<?=$slider->link_text?>" class="btn btn-default get">Get it now</a>
								</div>
								<div class="col-sm-6">
									<img src="<?= ROOT . $slider->image ?>" class="girl img-responsive" alt="" />
									<img src="<?= ROOT . $slider->image2 ?>"  class="pricing" alt="" />
								</div>
							</div>
						<?php } ?>
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	<?php } ?>