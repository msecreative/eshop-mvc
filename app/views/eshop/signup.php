
<?php $this->view("header", $data); ?>
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						<form action="#" method="POST">
							<input name="name" type="text" placeholder="Name"/>
							<input name="email" type="email" placeholder="Email Address"/>
							<input name="pasword" type="password" placeholder="Password"/>
							<input name="pasword2" type="password2" placeholder="Confirm Password"/>
							<button type="submit" class="btn btn-default">Signup</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
	
	
  
	<?php $this->view("footer"); ?>