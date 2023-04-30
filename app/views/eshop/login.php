
<?php $this->view("header", $data); ?>
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<?php chk_error(); ?>
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form action="#" method="post">
							<input type="email" value="<?= isset($_POST["email"]) ? $_POST["email"] : ""; ?>" name="email" placeholder="Email Address" />
							<input type="password" value="<?= isset($_POST["password"]) ? $_POST["password"] : ""; ?>" name="password" placeholder="Password" />
							<span>
								<input type="checkbox" class="checkbox"> 
								Keep me signed in
							</span>
							<button type="submit" class="btn btn-default">Login</button>
						</form>
						<br>
						<a href="<?=ROOT ?>signup">Don't have an account? Signup here</a>
					</div><!--/login form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
	
	
  
	<?php $this->view("footer"); ?>