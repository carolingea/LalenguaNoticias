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
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/bootstrap-3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/bootstrap-3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <!-- Jquery-UI -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
    <link href="<?php echo get_template_directory_uri(); ?>/js/jquery-ui-1.12.1/jquery-ui.theme.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo get_template_directory_uri(); ?>/js/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>

    <!-- Scrits -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/scripts.js" type="text/javascript"></script>
    <!-- Angular 1 -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/angular.min.js" type="text/javascript"></script>

    <!-- Reset -->
    <link href="<?php echo get_template_directory_uri(); ?>/css/reset.css" rel="stylesheet" type="text/css"/>

    <!-- Hover -->
    <link href="<?php echo get_template_directory_uri(); ?>/css/hover-min.css" rel="stylesheet" type="text/css"/>
    
    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,700|Open+Sans:400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<!--    <link href="<?php echo get_template_directory_uri(); ?>/fonts/OpenSans-Bold.ttf" rel="stylesheet">-->
    <link href="<?php echo get_template_directory_uri(); ?>/fonts/RobotoSlab-Regular.ttf" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/fonts/merriweather.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo get_template_directory_uri(); ?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    
    <!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5004e44d66e58fb5"></script> 
    
    <!--    Slider de noticias-->
    
    <?php wp_head(); ?>
    <script>
    conditionizr.config({
        assets: '<?php echo get_template_directory_uri(); ?>',
        tests: {}
    });
    </script>
    
</head>
<body <?php body_class(); ?>>
       
    <!-- wrapper -->
    
    <div class="principal">
        
        <nav class="navbar navbar-toggleable-md" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
<!--                  <a class="navbar-brand" href="#">La Lengua Noticias</a>-->
                </div>
                <ul class="nav navbar-nav navbar-right">
<!--                    <li class="active"><a href="#">Inicio</a></li>-->
                    <!-- Login de Usuarios -->
                    <?php 
                        if (is_user_logged_in()) {
                            
                            global $current_user;
                            get_currentuserinfo();

                            echo '<li><a href="'.''.'">Hola '. $current_user->user_login .'!</a></li>';
                            echo '<li><a href="'.wp_logout_url(home_url()).'">Cerrar</a></li>';
                            
                        } else {
                            echo '<li><a href="'. wp_registration_url().'">Registrar</a></li>';
                            echo '<li><a href="'.wp_login_url(get_permalink()).'">Iniciar</a></li>';
                        }
                    ?>
                    <li><?php get_template_part('searchform'); ?></li>
                </ul>
                <ul nav navbar-nav navbar-right>
                    
                    
                </ul>
                
            </div>
          </nav>
        
        <!-- header -->
        <header class="header clear" role="banner">
           <!-- logo -->
            <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/logos/logo.png" height="80px" alt="Logo" class="logo-img">
                </a>
            </div>
            <!-- /logo -->

            <!-- nav -->
            <nav class="nav menugeneral" role="navigation">
                <?php //wp_nav_menu()  ?>
                <?php //wp_nav_menu( 'MenuPrincipal' ); ?>
                <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
                <!--                html5blank_nav();-->
            </nav>
            <!-- /nav -->
        </header>
        <!-- /header -->
