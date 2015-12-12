<html class="no-js" lang="en">
<head>
    <title>Dashboard - [Please change the title]</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?= asset_base_url()?>/css/font-awesome.min.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= asset_base_url()?>/css/app.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= asset_base_url()?>/css/jquery-ui.css" media="screen"/>
    <link media="screen" href="<?= asset_base_url()?>/css/chosen.min.css" type="text/css" rel="stylesheet">

    <!-- end of stylesheets -->

    <!-- Modernizr -->
    <script type="text/javascript" src="<?= asset_base_url()?>/js/script.js"></script>
</head>
<body>
	<div id="container">
    <div class="row">
        <div class="large-12 column">
            <!-- #header -->
            <header id="header">
                <nav class="top-bar" data-topbar role="navigation">
                    <ul class="title-area">
                        <li class="name">
                            <h1>
                                <a href="#" title="notibrew">
                                    <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="notibrew"/>
                                </a>
                            </h1>
                        </li>
                        <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                        <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
                    </ul>

                    <section class="top-bar-section">
                        <!-- Right Nav Section -->
                        <ul class="account right">
                            <li class="has-dropdown">
                                <a href="#"><?php echo $this->session->userdata('username'); ?></a>
                                <ul class="dropdown">
                                    <li><a href="<?php echo base_url().'auth/logout'; ?>">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </section>
                </nav>
            </header>