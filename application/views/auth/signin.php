
<html style="" class=" js flexbox canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths"><!--<![endif]--><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>
		Notibrew - Sign In
	</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">

	<script src="<?= asset_base_url()?>/login_assets/adminflare-demo-init.js" type="text/javascript"></script>
	<script src="<?= asset_base_url()?>/login_assets/modernizr-jquery.js" type="text/javascript"></script>
	<script src="<?= asset_base_url()?>/login_assets/adminflare-demo.js" type="text/javascript"></script>
	

	<script src="<?= asset_base_url()?>/login_assets/loadingoverlay_002.js" type="text/javascript"></script>
	<script src="<?= asset_base_url()?>/login_assets/loadingoverlay.js" type="text/javascript"></script>	

	<link href="<?= asset_base_url()?>/login_assets/css.css" rel="stylesheet" type="text/css">

	<link href="<?= asset_base_url()?>/login_assets/bootstrap.css" media="all" rel="stylesheet" type="text/css" id="bootstrap-css">
	<link href="<?= asset_base_url()?>/login_assets/adminflare.css" media="all" rel="stylesheet" type="text/css" id="adminflare-css">
	<link href="<?= asset_base_url()?>/login_assets/pages.css" media="all" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="<?= asset_base_url()?>/login_assets/style.css" media="screen">

</head>
<body class="signin-page">
	<section id="signin-container">
		
		<a href="" title="" class="header">
			<img src="<?= asset_base_url()?>/login_assets/logo.png" alt="notibrew">
			<br>
		</a>

		<form method="post" action="<?= base_url()?>auth/" accept-charset="utf-8">
			<fieldset>
				<?php echo (validation_errors() != '') ? "<div class='alert'>Invalid Login.</div>" : "" ; ?>
				<div class="fields">
					<input name="username" placeholder="Username" id="id_username" tabindex="1" type="text" text="" placeholder="Username" >

					<input name="password" placeholder="Password" id="id_password" tabindex="2" type="password" text="" placeholder="Password">
				</div>
				<input type="hidden" name="type" value=0 />
				<a href="#" title="" tabindex="3" class="forgot-password">Forgot?</a>

				<button type="submit" class="btn btn-primary btn-block" tabindex="4">Sign In</button>
				<p class="to-register">New to Notibrew?&nbsp;&nbsp;&nbsp;<a href="<?=base_url()?>auth/signup">Create an account.</a></p>
			</fieldset>
		</form>

	</section>

</body></html>
