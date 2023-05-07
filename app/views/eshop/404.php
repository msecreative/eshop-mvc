<!-- Header -->
<?php $this->view("header", $data) ?>

<body>
	<div class="container text-center" style="margin-bottom: 60px;">
		<div class="logo-404">
			<a href="index.html"><img src="<?=ASSETS . THEME ?>images/home/logo.png" alt="" /></a>
		</div>
		<div class="content-404">
			<img src="<?=ASSETS . THEME ?>images/404/404.png" class="img-responsive" alt="" />
			<h1><b>OPPS!</b> We Couldn’t Find this Page</h1>
			<p>Uh... So it looks like you brock something. The page you are looking for has up and Vanished.</p>
			<h2><a href="index.php">Bring me back Home</a></h2>
		</div>
	</div>

  
    <!-- Footer -->
<?php $this->view("footer", $data) ?>