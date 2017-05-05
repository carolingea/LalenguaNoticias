<?php
/**
 * Create widget
 *
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'FocusWP_SLIDER_Widget' ) ){
	class FocusWP_SLIDER_Widget extends WP_Widget {
		/**
		 * Sets up the widgets name etc
		 */
		public function __construct() {
			parent::__construct(
				'focuswp_widget',
				__( 'Focus: Featured Slider', 'focuswp' ),
				array( 'description' => __( 'Display Modern Featured Posts Slider', 'focuswp' )
				),
				array( 'width' => apply_filters( 'focuswp_widget_width', 500 )  )
			);

			add_action( 'focuswp_widget__before_tab', array($this, 'before_tabs'), 10 );
			add_action( 'focuswp_widget__tab', array($this, 'navtabs'), 10 );
			add_action( 'focuswp_widget__tab', array($this, 'moretabs'), 15 );
			add_action( 'focuswp_widget__tabcontent', array($this, 'tab_display'), 10 );
			add_action( 'focuswp_widget__tabcontent', array($this, 'tab_slide_atts'), 10 );
			add_action( 'focuswp_widget__tabcontent', array($this, 'tab_more'), 15 );
			add_action( 'focuswp_tab__options_content', array($this, 'tab_slide_featured'), 10 );
			if( !function_exists( 'widgetopts_delete_transient_terms' ) ){
				add_action( 'create_term', array($this, 'remove_transient'), 10, 3 );
			}
		}

		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			$old_args = $args;
			extract( $args );

			$instance['uniqid'] = time() .'-'. uniqid(true);
			$instance['origin'] = 'widget';

			ob_start();

			if( isset( $instance['title'] ) ){
				$title = apply_filters( 'widget_title', $instance['title'] );
			}

			echo $before_widget;
			// Check if title is set
			if ( $title ) {
			  echo $before_title . $title . $after_title;
			}

			do_action( 'focuswp_widget_display', $instance, $old_args );

			echo $after_widget;

			echo $html = ob_get_clean();
		}

		/**
		 * Ouputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
			$uniqid 	= time().'-'.uniqid(true);

			$selected = 0;
	        if( isset( $instance['active'] ) ){
	            $selected = $instance['active'];
	        }
			?>
			<div class="focuswp-widget--form">
				<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title:', 'focuswp' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php if ( isset ( $instance['title'] ) ) { echo esc_attr( $instance['title'] ); } ?>" />
				</p>
				<?php do_action( 'focuswp_widget__before_tab', array( 'id' => $uniqid, 'instance' => $instance ) );?>
				<div class="focuswp-widget--tabs">
					<input type="hidden" id="focuswp-widget-opts-selectedtab" name="<?php echo $this->get_field_name( 'active' ); ?>" value="<?php echo $selected;?>" />
					<ul>
						<?php do_action( 'focuswp_widget__tab', array( 'id' => $uniqid, 'instance' => $instance, 'this' => ( isset( $this ) ) ? $this : array() ) );?>
					</ul>
					<?php do_action( 'focuswp_widget__tabcontent', array( 'id' => $uniqid, 'instance' => $instance, 'this' => ( isset( $this ) ) ? $this : array() ) );?>
				</div>
			</div>
			<script type="text/javascript">
			jQuery(document).ready(function($){
				if($('.so-content .focuswp-widget--tabs').length > 0){
					$('.focuswp-widget--tabs').tabs({ active: 0 });
				}
			});
			</script>
			<?php
		}

		function before_tabs( $params ){
			$instance = $params['instance'];
			?>
			<p><label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Slider Title:', 'focuswp' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'label' ); ?>" data-name="title" name="<?php echo $this->get_field_name( 'label' ); ?>" value="<?php if ( isset ( $instance['label'] ) ) { echo esc_attr( $instance['label'] ); } ?>" />
			</p>
		<?php }

		function navtabs( $params ){ ?>
			<input type="hidden" id="focuswp-dummy-fld" value="<?php echo $this->get_field_name('--dummy--'); ?>" />
			<li><a href="#focuswp-widget--tabs-<?php echo $params['id'];?>-filter"><?php _e( 'Filter', 'focuswp' );?></a></li>
			<li><a href="#focuswp-widget--tabs-<?php echo $params['id'];?>-atts"><?php _e( 'Slider Options', 'focuswp' );?></a></li>
		<?php }

		function moretabs( $params ){ ?>
			<li><a href="#focuswp-widget--tabs-<?php echo $params['id'];?>-more"><?php _e( '+', 'focuswp' );?></a></li>
		<?php }

		function tab_display( $params ){
			$instance 	= ( isset( $params['instance'] ) && !empty( $params['instance'] ) ) ? $params['instance'] : array( 'posts_per_page' => 5, 'orderby' => 'date', 'order' => 'DESC' );
			$cat_values = ( isset( $instance['categories'] ) ) ? unserialize( $instance['categories'] ) : array();
			// print_r( $instance );
			/*
	         * get post categories
	         * Check for transient. If none, then execute Query
	         *
	         * use transient from widget options to avoid duplicate whenever installed
	         */
	        if ( false === ( $categories = get_transient( 'widgetopts_categories' ) ) ) {

	            $categories = get_categories( array(
	                        'hide_empty'    => false
	                    ) );

	          // Put the results in a transient. Expire after 4 WEEKS.
	          set_transient( 'widgetopts_categories', $categories, 4 * WEEK_IN_SECONDS );

	        }
			?>
			<div id="focuswp-widget--tabs-<?php echo $params['id'];?>-filter">
				<?php do_action( 'focuswp_tab__display_before', $params );?>
				<p><strong><?php _e( 'Select Categories', 'focuswp' ) ?></strong></p>
				<div class="focuswp-widget--nooverflow">
                    <p>
                        <input type="checkbox" name="<?php echo $this->get_field_name( 'categories' ); ?>[-1]" id="<?php echo $params['id'];?>-focuswp-categories-all" value="1" <?php if( isset( $cat_values['-1'] ) ){ echo 'checked="checked"'; };?> />
                        <label for="<?php echo $params['id'];?>-focuswp-categories-all"><?php _e( 'All Categories', 'widget-options' );?></label>
                    </p>
                    <?php foreach ($categories as $cat) {
                            if( isset( $cat_values[ $cat->cat_ID ] ) && $cat_values[ $cat->cat_ID ] == '1' ){
                                $checked = 'checked="checked"';
                            }else{
                                $checked = '';
                            }
                        ?>
                        <p>
                            <input type="checkbox" id="<?php echo $params['id'];?>-focuswp-categories-<?php echo $cat->cat_ID;?>" data-name="category-<?php echo $cat->cat_ID;?>" name="<?php echo $this->get_field_name( 'categories' ); ?>[<?php echo $cat->cat_ID;?>]" value="1" <?php echo $checked;?> />
                            <label for="<?php echo $params['id'];?>-focuswp-categories-<?php echo $cat->cat_ID;?>"><?php echo $cat->cat_name;?></label>
                        </p>
                    <?php } ?>
                </div>
                <p><label for="<?php echo $this->get_field_id( 'tags' ); ?>"><?php _e( 'or Add Comma Separated Tags:', 'focuswp' ) ?></label>
					<textarea type="text" rows="2" class="widefat" id="<?php echo $this->get_field_id( 'tags' ); ?>" data-name="tag" name="<?php echo $this->get_field_name( 'tags' ); ?>" ><?php if ( isset ( $instance['tags'] ) ) { echo esc_attr( $instance['tags'] ); } ?></textarea>
				</p>
				<p><label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Number of Posts to Show:', 'focuswp' ) ?></label>
				&nbsp;<input type="number" class="tiny-text" min="1" size="3" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" data-name="posts_per_page" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php if ( isset ( $instance['posts_per_page'] ) ) { echo esc_attr( $instance['posts_per_page'] ); } ?>" />
				</p>
				<p class="focuswp-fld-inline"><label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By:', 'focuswp' ) ?></label>
				&nbsp;<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" data-name="orderby" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
					<option value="date" <?php if( $instance['orderby'] == 'date' ){ echo 'selected="selected"'; }?> ><?php _e( 'Date', 'focuswp' ) ?></option>
					<option value="ID" <?php if( $instance['orderby'] == 'ID' ){ echo 'selected="selected"'; }?> ><?php _e( 'ID', 'focuswp' ) ?></option>
					<option value="title" <?php if( $instance['orderby'] == 'title' ){ echo 'selected="selected"'; }?> ><?php _e( 'Title', 'focuswp' ) ?></option>
					<option value="rand" <?php if( $instance['orderby'] == 'rand' ){ echo 'selected="selected"'; }?> ><?php _e( 'Random', 'focuswp' ) ?></option>
				</select>
				<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order:', 'focuswp' ) ?></label>
				&nbsp;<select id="<?php echo $this->get_field_id( 'order' ); ?>" data-name="order" name="<?php echo $this->get_field_name( 'order' ); ?>">
					<option value="ASC" <?php if( $instance['order'] == 'ASC' ){ echo 'selected="selected"'; }?> ><?php _e( 'ASC', 'focuswp' ) ?></option>
					<option value="DESC" <?php if( $instance['order'] == 'DESC' ){ echo 'selected="selected"'; }?> ><?php _e( 'DESC', 'focuswp' ) ?></option>
				</select>
				</p>
				<?php do_action( 'focuswp_tab__display_after', $params );?>
			</div>
		<?php }

		function tab_slide_atts( $params ){
			$instance 	= ( isset( $params['instance'] ) && !empty( $params['instance'] ) ) ? $params['instance'] : array( 'speed' => 400, 'timeout' => 5000 ); ?>
			<div id="focuswp-widget--tabs-<?php echo $params['id'];?>-atts">
				<?php do_action( 'focuswp_tab__options_before', $params );?>
				<p><input type="checkbox" id="<?php echo $this->get_field_id( 'autoplay' ); ?>" data-name="autoplay" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" value="true" <?php if( isset( $instance['autoplay'] ) ){ echo 'checked="checked"'; };?> />
					<label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e( 'Autoplay', 'focuswp' ) ?></label>
				</p>
				<?php do_action( 'focuswp_tab__options_content', $params );?>
				<p><input type="checkbox" id="<?php echo $this->get_field_id( 'pager' ); ?>" data-name="pager" name="<?php echo $this->get_field_name( 'pager' ); ?>" value="true" <?php if( isset( $instance['pager'] ) ){ echo 'checked="checked"'; };?> />
					<label for="<?php echo $this->get_field_id( 'pager' ); ?>"><?php _e( 'Display Pager Navigation', 'focuswp' ) ?></label>
				</p>
				<p><label for="<?php echo $this->get_field_id( 'speed' ); ?>"><?php _e( 'Animation Speed:', 'focuswp' ) ?></label>
				&nbsp;<input type="number" size="4" id="<?php echo $this->get_field_id( 'speed' ); ?>" data-name="speed" name="<?php echo $this->get_field_name( 'speed' ); ?>" value="<?php if ( isset ( $instance['speed'] ) ) { echo esc_attr( $instance['speed'] ); } ?>" /><?php _e( 'ms', 'focuswp' ) ?>
				</p>
				<p><label for="<?php echo $this->get_field_id( 'timeout' ); ?>"><?php _e( 'Timeout Speed:', 'focuswp' ) ?></label>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="number" size="4" id="<?php echo $this->get_field_id( 'timeout' ); ?>" data-name="timeout" name="<?php echo $this->get_field_name( 'timeout' ); ?>" value="<?php if ( isset ( $instance['timeout'] ) ) { echo esc_attr( $instance['timeout'] ); } ?>" /><?php _e( 'ms', 'focuswp' ) ?>
				</p>
				<?php do_action( 'focuswp_tab__options_after', $params );?>
			</div>
		<?php }

		function tab_more( $params ){ ?>
			<div id="focuswp-widget--tabs-<?php echo $params['id'];?>-more" class="focuswp-widget--tabs--more">
				<p>
					<strong><?php _e( 'Focus Styling Add-on coming soon!', 'focuswp' );?></strong> <a href="http://focus-wp.com/#gform_wrapper_1" target="_blank"><?php _e( 'Click here to get notified and be the first to improve your featured slider to the next level!', 'focuswp' );?></a>
				</p>
				<p>
					<em><?php _e( 'or check our latest plugins to improve your WordPress websites:', 'focuswp' );?></em>
				</p>
				<ul>
					<li>
						<a href="https://phpbits.net/plugin/extended-widget-options/" target="_blank"><?php _e( 'Widget Options', 'focuswp' );?></a> - <small><?php _e( 'Free plugin to manage your widget visibility and add more powerful options.', 'focuswp' );?></small>
					</li>
					<li>
						<a href="https://phpbits.net/plugin/forty-four/" target="_blank"><?php _e( 'Forty Four', 'focuswp' );?></a> - <small><?php _e( 'Free 404 lightweight page and SEO 404 to 301 redirection plugin.', 'focuswp' );?></small>
					</li>
					<li>
						<a href="https://wordpress.org/plugins/easy-profile-widget/" target="_blank"><?php _e( 'Easy Profile Widgets', 'focuswp' );?></a> - <small><?php _e( 'Free plugin for user profile information widget with gravatar.', 'focuswp' );?></small>
					</li>
					<li>
						<a href="http://mobi-wp.com/" target="_blank"><?php _e( 'Mobi', 'focuswp' );?></a> - <small><?php _e( 'Mobile-first WordPress Responsive Menu plugin for better browsing experience.', 'focuswp' );?></small>
					</li>
					<li>
						<a href="http://floatton.com/" target="_blank"><?php _e( 'Floatton', 'focuswp' );?></a> - <small><?php _e( 'Floating Action Buttons with pop-up contents for WordPress.', 'focuswp' );?></small>
					</li>
					<li>
						<small><a href="https://phpbits.net/plugins/" target="_blank"><?php _e( 'view all', 'focuswp' );?></a></small>
					</li>
				</ul>
			</div>
		<?php }

		function tab_slide_featured( $params ){
			$instance 	= ( isset( $params['instance'] ) && !empty( $params['instance'] ) ) ? $params['instance'] : array(); ?>
			<p class="focuswp-type-fld"><input type="checkbox" id="<?php echo $this->get_field_id( 'type' ); ?>" data-name="type" name="<?php echo $this->get_field_name( 'type' ); ?>" value="featured--on" <?php if( isset( $instance['type'] ) ){ echo 'checked="checked"'; };?> />
				<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Display Featured Image', 'focuswp' ) ?></label>
			</p>
		<?php }

		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$fields = array( 'title', 'label', 'categories', 'tags', 'autoplay','pager', 'speed', 'timeout', 'type', 'posts_per_page', 'orderby', 'order', 'active' );
			$fields = apply_filters( 'focuswp_widget_instance_fields', $fields );
			foreach ( $fields as $key => $field ) {
				if( in_array( $field,  array( 'categories' ) ) ){
					$instance[ $field ]	= ( isset( $new_instance[ $field ] ) ) ? strip_tags( serialize( $new_instance[ $field ] ) ) : '';
				}else if( in_array( $field,  array( 'autoplay', 'type', 'pager' ) ) ){
					if( !isset( $new_instance[ $field ] ) && isset( $instance[ $field ] ) ){
						unset( $instance[ $field ] );
					}else if( isset( $new_instance[ $field ] ) ){
						$instance[ $field ]	= ( isset( $new_instance[ $field ] ) ) ? strip_tags( $new_instance[ $field ] ) : '';
					}
				}else{
					$instance[ $field ]	= ( isset( $new_instance[ $field ] ) ) ? strip_tags($new_instance[ $field ]) : '';
				}
			}

			//apply filters for custom add_action
			$instance = apply_filters( 'focuswp_widget_instance', $instance, $new_instance );

			return $instance;
		}

		function remove_transient( $term_id, $tt_id, $taxonomy ){
			if( $taxonomy == 'category' ){
				delete_transient( 'widgetopts_categories' );
			}
		}
	}

	// register widget
	function register_focuswp_widget() {
	    register_widget( 'FocusWP_SLIDER_Widget' );
	}
	add_action( 'widgets_init', 'register_focuswp_widget' );
}
?>
