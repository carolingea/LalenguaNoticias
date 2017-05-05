<?php
/*
 * Create Custom Media Frame Tab
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists( 'FOCUSWP_SLIDER_TINYMCE' ) ){
	class FOCUSWP_SLIDER_TINYMCE{
		/*
		 * For easier overriding we declared the keys
		 * here as well as our tabs array which is populated
		 * when registering settings
		 */
		private $slug	= 'focuswp_edit';

		public function __construct() {
			if ( is_admin() ){
				add_action( 'admin_init', array( $this, 'add_editor_styles' ) );
		        add_action( 'admin_head', array( $this, 'scripts_head' ) );
			}
		}

		function scripts_head() {
		    global $typenow;
		    // check user permissions
		    if ( !current_user_can('edit_posts') & !current_user_can('edit_pages') ) {
		    	return;
		    }

		    // check if WYSIWYG is enabled
		    if ( get_user_option('rich_editing') == 'true') { ?>
				<script type="text/javascript">
				/* <![CDATA[ */
		        var focuswp_localized = { 'ajaxurl' : '<?php echo admin_url( 'admin-ajax.php' );?>', 'url' : '<?php echo admin_url( 'media-upload.php?chromeless=1&tab=focuswp_media' );?>', 'title' : '<?php _e( 'Focus: Featured Posts', 'focuswp' ) ?>', 'update' : '<?php _e( 'Update Featured Posts', 'focuswp' ) ?>' };
				/* ]]> */
		        </script>
				<?php add_filter( 'mce_external_plugins', array( $this ,'mce_external_plugins' ) );
		        add_filter( 'mce_buttons', array($this, 'mce_buttons' ) );
		    }
		}

		function mce_external_plugins( $plugin_array ) {
		    $plugin_array[ $this->slug ] = plugins_url( '../assets/js/tinymce.js', __FILE__ ); // CHANGE THE BUTTON SCRIPT HERE
		    return $plugin_array;
		}

		function mce_buttons( $buttons ) {
		   array_push( $buttons, $this->slug );
		   return $buttons;
		}
		function add_editor_styles() {
			add_theme_support( 'editor-style' );
		    add_editor_style( plugins_url( '../assets/css/custom-editor-style.css', __FILE__ ) );
		}

	}
	new FOCUSWP_SLIDER_TINYMCE();
}
?>
