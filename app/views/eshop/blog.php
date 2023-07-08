<?php $this->view("header", $data) ?>
	
	<section>
		<div class="container">
			<div class="row">
			<?php $this->view("sidebar.inc", $data) ?>
				<div class="col-sm-9">
					<div class="blog-post-area">
						<h2 class="title text-center">Latest From our Blog</h2>
						<?php 
						
							if (isset($blog_rows) && is_array($blog_rows)) {
								foreach ($blog_rows as $blog) {
						?>
						<div class="single-blog-post">
							<h3><?=$blog->title ?></h3>
							<div class="post-meta">
								<ul>
									<li><i class="fa fa-user"></i> <?=$blog->user_data->name ?></li>
									<li><i class="fa fa-clock-o"></i> <?=date("H:i a", strtotime($blog->date)) ?></li>
									<li><i class="fa fa-calendar"></i> <?=date("M d, Y", strtotime($blog->date)) ?></li>
								</ul>
								<span>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-half-o"></i>
								</span>
							</div>
							<a href="<?=ROOT . 'post/' . $blog->url_address ?>">
								<img src="<?=ROOT . $blog->image ?>" alt="">
							</a>
							<p><?=nl2br(htmlspecialchars(substr($blog->post, 0, 350)))?> ...</p>
							<a class="btn btn-primary" href="<?=ROOT . 'post/' . $blog->url_address ?>">Read More</a>
							<hr>
						</div>
						<?php } ?>
						<div class="pagination-area">
							<ul class="pagination">
								<li><a href="" class="active">1</a></li>
								<li><a href="">2</a></li>
								<li><a href="">3</a></li>
								<li><a href=""><i class="fa fa-angle-double-right"></i></a></li>
							</ul>
						</div>
						<?php }else{ ?>
							<p style="border:1px solid #ddd; padding: 10px">No post found!</p>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php $this->view("footer", $data) ?>