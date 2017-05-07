<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
    <link href="//www.google-analytics.com" rel="dns-prefetch">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php bloginfo('description'); ?>">

    <!-- Jquery -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-3.2.1.min.js" type="text/javascript"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/bootstrap-3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/bootstrap-3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <!-- Jquery-UI -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
    <link href="<?php echo get_template_directory_uri(); ?>/js/jquery-ui-1.12.1/jquery-ui.theme.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo get_template_directory_uri(); ?>/js/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>

    <!-- Angular 1 -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/angular.min.js" type="text/javascript"></script>

    <!-- Reset -->
    <link href="<?php echo get_template_directory_uri(); ?>/css/reset.css" rel="stylesheet" type="text/css"/>

    <!-- Hover -->
    <link href="<?php echo get_template_directory_uri(); ?>/css/hover-min.css" rel="stylesheet" type="text/css"/>

    <!-- Fuentes -->
    <link href="<?php echo get_template_directory_uri(); ?>/fonts/RobotoSlab-Regular.ttf" rel="stylesheet">

<!--            <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">-->
    <?php wp_head(); ?>
    <script>
    // conditionizr.com
    // configure environment tests
    conditionizr.config({
        assets: '<?php echo get_template_directory_uri(); ?>',
        tests: {}
    });
    </script>

</head>
<body <?php body_class(); ?>>
    <!-- wrapper -->
    <div class="principal">
        <!-- header -->
        <header class="header clear" role="banner">
            <div class="barra_busqueda">
                <?php get_template_part('searchform'); ?>
            </div>


            <!-- logo -->
            <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/logos/logo.png" height="80px" alt="Logo" class="logo-img">
                </a>
            </div>
            <!-- /logo -->

            <!-- nav -->
            <nav class="nav menugeneral" role="navigation">
                <?php html5blank_nav(); ?>
            </nav>

            <!-- /nav -->

        </header>
        <!-- /header -->
