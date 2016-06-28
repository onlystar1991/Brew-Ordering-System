<html style="" class=" js flexbox canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths"><!--<![endif]--><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>
		NotiBrew - Sign Up
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
<body class="signup-page">
	<section id="signup-container">
		
		<a href="" title="" class="header">
			<img src="<?= asset_base_url()?>/login_assets/logo.png" alt="notibrew">
			<br>
		</a>

		<form method="post" action="<?= base_url()?>auth/signup" accept-charset="utf-8">
			<fieldset>
				<?php echo (validation_errors() != '') ? "<div class='alert'>Invalid Register.</div>" : "" ; ?>
				<div class="fields">
					<input name="username" placeholder="Username" id="id_username" tabindex="1" type="text" text="" placeholder="User Name" required>

					<input name="password" placeholder="Password" id="id_password1" tabindex="2" type="password" text="" placeholder="Password" required>
					<input name="passconf" placeholder="Confirm Password" id="id_password2" tabindex="3" type="password" text="" placeholder="Confirm Password" required>
				</div>
				<input type="hidden" name="type" value=1 />

				<button type="submit" id="btn-register" class="btn btn-primary btn-block" tabindex="4">Register</button>
				<p class="to-register">Already Have Account?&nbsp;&nbsp;&nbsp;<a href="<?=base_url()?>">Login to NotiBrew</a></p>
			</fieldset>
		</form>

	</section>

</body>
</html>