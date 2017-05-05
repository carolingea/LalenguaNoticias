<?php
/*
 * Enqueue necessary scripts
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists( 'FOCUSWP_SLIDER_SCRIPTS' ) ){
	class FOCUSWP_SLIDER_SCRIPTS{

		public function __construct() {
			add_action( 'wp_enqueue_scripts', array($this, 'enqueue'), 999 );
			add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue'), 999 );
		}

		function enqueue(){
			wp_enqueue_style( 'css-focuswp', plugins_url( 'assets/css/focuswp.css' , dirname(__FILE__) ) , array(), null );

			wp_register_script(
				'jquery-focus',
				plugins_url( 'assets/js/jquery.focus.min.js' , dirname(__FILE__) ),
				array( 'jquery' ),
				'',
				true
			);

			wp_enqueue_script( 'jquery-focus' );

			// $params = array(
			// 			'ajaxurl' 		=>  admin_url( 'admin-ajax.php' )
			// 		);

			// wp_localize_script( 'jquery-floatton', 'floatton', $params);
		}

		function admin_enqueue(){
			wp_enqueue_style( 'css-focuswp-admin', plugins_url( 'assets/css/focus-admin.css' , dirname(__FILE__) ) , array(), null );
			wp_enqueue_script(
		        'jquery-admin-focuswp',
		        plugins_url( 'assets/js/jquery.focus.admin.min.js' , dirname(__FILE__) ),
		        array( 'jquery', 'jquery-ui-tabs' ),
		        '',
		        true
		    );
			// wp_enqueue_script(
		    //     'jquery-media-focuswp',
		    //     plugins_url( 'assets/js/jquery.media-frame.js' , dirname(__FILE__) ),
		    //     array( 'jquery', 'media-views' ),
		    //     '',
		    //     true
		    // );
		}
	}
	new FOCUSWP_SLIDER_SCRIPTS();
}
?>
