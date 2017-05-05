<?php
/*
 * Create Custom Media Frame Tab
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists( 'FOCUSWP_SLIDER_MEDIA_FRAME' ) ){
	add_action( 'plugins_loaded', array( 'FOCUSWP_SLIDER_MEDIA_FRAME', 'init' ) );
	class FOCUSWP_SLIDER_MEDIA_FRAME{
		/*
		 * For easier overriding we declared the keys
		 * here as well as our tabs array which is populated
		 * when registering settings
		 */
		// private $slug	= __( 'Focus: Featured Posts', 'focuswp' );

		public static function init() {
	        $class = __CLASS__;
	        new $class;
	    }

		public function __construct() {
			add_filter( 'media_upload_tabs', array( $this, 'media_upload_tabs' ) );
			// add_filter('media_view_strings', array( $this, 'media_string' ), 10, 2);
			add_action( 'media_upload_focuswp_media', array( $this, 'media_upload_tab__iframe' ) );

			add_action( 'wp_ajax_focuswp_media_upload', array( $this, 'frame_to_shortcode' )  );
			add_action( 'wp_ajax_nopriv_focuswp_media_upload', array( $this, 'frame_to_shortcode' )  );

			add_action( 'wp_ajax_focuswp_extract_shortcodes', array( $this, 'focuswp_extract_shortcodes' )  );
		}

		function media_upload_tabs( $tabs ) {
		    $newtab = array( 'focuswp_media' => __( 'Focus: Featured Posts', 'focuswp' ) );
		    return array_merge( $tabs, $newtab );
		}

		//html content for custom tab frame
		function media_upload_tab__iframe() {
			wp_enqueue_style( 'css-focuswp-admin' );
			wp_enqueue_script( 'jquery-focuswp-media', plugins_url( '../assets/js/jquery.media-frame.js', __FILE__ ), array( 'jquery', 'jquery-ui-tabs', 'jquery-admin-focuswp' ) );

			return wp_iframe( array( $this, 'media_upload_tab__content' ) );
		}
		//html content for custom tab frame contents
		function media_upload_tab__content() { ?>
			<div class="focuswp-media-frame-wrapper">
				<form id="focuswp-media-frame" method="POST" action="<?php echo admin_url( 'admin-ajax.php' );?>">
					<?php wp_nonce_field( 'focuswp_verify_nonce', 'nonce_field' ); ?>
					<input type="hidden" name="action" value="focuswp_media_upload" />
					<input type="hidden" name="media_frame" id="media_frame_fld" value="false" />
					<div class="focuswp-media-frame-inner">
						<?php do_action( 'focuswp_widget__before_tab', array( 'id' => '', 'instance' => array() ) );?>
						<div class="focuswp-widget--tabs">
							<ul>
								<?php do_action( 'focuswp_widget__tab', array( 'id' => '', 'instance' => array() ) );?>
							</ul>
							<?php do_action( 'focuswp_widget__tabcontent', array( 'id' => '', 'instance' => array(), 'this' => array() ) );?>
						</div>
					</div>
					<div class="focuswp-media-frame-submit">
						<?php submit_button( __( 'Insert Featured Posts', 'focuswp' ), 'primary', 'focuswp-query-submit', false ); ?>
					</div>
				</form>
			</div>
		<?php }

		function frame_to_shortcode(){
			parse_str( $_POST['data'], $data );

			if ( ! wp_verify_nonce( $data['nonce_field'], 'focuswp_verify_nonce' ) ) {
				die();
			}
			$values = reset($data['widget-focuswp_widget']);
			$values['origin'] = 'media-frame';
			if( isset( $values['categories'] ) && !empty($values['categories']) ){
				$values['categories'] = serialize( $values['categories'] );
			}
			// print_r( $values );
			if( $data['media_frame'] == 'true' ){
				$focuswpselect = 'data-wp-focuswpselect="1"';
			}else{
				$focuswpselect = '';
			}
			echo '<span class="focuswp" '. $focuswpselect .'>';
			do_action( 'focuswp_widget_display', $values, $values );
			echo '</span>';

			die(); exit();
		}

		function focuswp_extract_shortcodes(){
			$data = isset( $_POST['data'] ) ? $_POST['data'] : '';
			if( !empty( $data ) ){
				$data = str_replace( '[focus-slides ', '', $data );
				$data = str_replace( '[focus-slides', '', $data );
				$data = str_replace( ' ]', '', $data );
				$data = str_replace( ']', '', $data );
				$atts = shortcode_parse_atts( stripslashes( $data ) );
				echo json_encode( $atts );
			}
			die();
		}
	}
}
?>
