<html style="" class=" js flexbox canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths"><!--<![endif]--><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>
		NotiBrew - Register
	</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">

	<script src="<?= asset_base_url()?>/login_assets/adminflare-demo-init.js" type="text/javascript"></script>
	<script src="<?= asset_base_url()?>/login_assets/modernizr-jquery.js" type="text/javascript"></script>
	<script src="<?= asset_base_url()?>/login_assets/adminflare-demo.js" type="text/javascript"></script>
	

	<script src="<?= asset_base_url()?>/login_assets/loadingoverlay_002.js" type="text/javascript"></script>
	<script src="<?= asset_base_url()?>/login_assets/loadingoverlay.js" type="text/javascript"></script>	

	<link href="<?= asset_base_url()?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="<?= asset_base_url()?>/login_assets/css.css" rel="stylesheet" type="text/css">

	<link href="<?= asset_base_url()?>/libs/bootstrap.min.css" media="all" rel="stylesheet" type="text/css" id="bootstrap-css">
	<!-- <link href="<?= asset_base_url()?>/login_assets/adminflare.css" media="all" rel="stylesheet" type="text/css" id="adminflare-css"> -->
	<link href="<?= asset_base_url()?>/login_assets/pages.css" media="all" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="<?= asset_base_url()?>/login_assets/style.css" media="screen">

</head>
<body class="register-page">
	<section id="register-container">
		
		<a href="" title="" class="header">
			<img src="<?= asset_base_url()?>/login_assets/logo.png" alt="notibrew">
		</a>

		<form method="post" action="<?= base_url()?>auth/register" accept-charset="utf-8" enctype="multipart/form-data">
				<?php echo (validation_errors() != '') ? "<div class='alert'>Invalid Register.</div>" : "" ; ?>
				<div class="form-group row">
			    	<label for="id_contactname" class="col-sm-4 form-control-label">Contact Name</label>
			    	<div class="col-sm-8">
			      		<input type="text" class="col-sm-3 input-sm" name="contactname" id="id_contactname" placeholder="John Doe" required>
			    	</div>
			  	</div>

			  	<div class="form-group row">
			    	<label for="id_fbpage" class="col-sm-4 form-control-label">Facebook Page</label>
			    	<div class="col-sm-8">
			      		<input type="url" class="col-sm-12 input-sm" name="fbpage" id="id_fbpage" placeholder="https://www.facebook.com/notibrew">
			    	</div>
			  	</div>

			  	<div class="form-group row">
			    	<label for="id_phone" class="col-sm-4 form-control-label">Telephone</label>
			    	<div class="col-sm-8">
			      		<input type="phone" class="col-sm-6 input-sm" name="phone" id="id_phone" placeholder="000 - 000 - 0000" required>
			    	</div>
			  	</div>

			  	<div class="form-group row">
			    	<label for="id_email" class="col-sm-4 form-control-label">Email</label>
			    	<div class="col-sm-8">
			      		<input type="email" class="col-sm-6 input-sm" name="email" id="id_email" placeholder="john.doe@notibrew.com" required>
			    	</div>
			  	</div>

			  	<div class="form-group row">
			    	<label for="id_bname" class="col-sm-4 form-control-label">Business Name</label>
			    	<div class="col-sm-8">
			      		<input type="text" class="col-sm-12 input-sm" name="bname" id="id_bname" placeholder="NotiBrew Liquors LLC" required>
			    	</div>
			  	</div>

			  	<div class="form-group row">
			    	<label for="id_btype" class="col-sm-4 form-control-label ">Business Type</label>
			    	<div class="col-sm-8">
			    		<div class="row">
			    			<div class="col-sm-4">
					      		<select class="form-control" name="btype" id="id_btype">
							 		<option value="retailer">Retailer</option>
									<option value="bar">Bar</option>
									<option value="brewery">Brewery</option>
									<option value="distributor">Distributor</option>
								</select>
							</div>
						</div>
			    	</div>
			  	</div>

			  	<div class="form-group row">
			    	<label for="id_baddress" class="col-sm-4 form-control-label ">Business Address</label>
			    	<div class="col-sm-8">
			      		<input type="address" class="col-sm-9 input-sm" name="baddress" id="id_baddress" placeholder="600 N 5th St. Unit 623 Minneapolis, MM..." required>
			    	</div>
			  	</div>

			  	<div class="form-group row">
			    	<label for="id_bdescription" class="col-sm-4 form-control-label ">Description of Business</label>
			    	<div class="col-sm-8">
			      		<textarea class="col-sm-12 input-sm" id="id_bdescription" name="bdescription" placeholder="Built for consumers 21+, NotiBrew is...."></textarea>
			    	</div>
			  	</div>

			  	<div class="form-group row blogo">
			    	<label for="id_blogo" class="col-sm-4 form-control-label">Business Logo</label>
			    	<div class="col-sm-8" style="position:relative;">
			    		<i class="fa fa-image"></i>
			    		<a class='btn btn-default btn-sm' href='javascript:;'>
				            Choose File...
				            <input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="blogo" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
				        </a>
				        &nbsp;
				        <span class='label' id="upload-file-info"></span>
			    	</div>
			  	</div>

			  	<input type="hidden" name="type" value=2 />
				<div class="form-group row text-center">
					<button type="submit" id="btn-register" class="btn btn-danger" style="margin:40px auto 0">&nbsp;Sign-up&nbsp;</button>
				</div>
		</form>

	</section>

</body>
</html>