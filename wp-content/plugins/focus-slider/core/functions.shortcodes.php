<?php
/*
 * Create Display Shortcodes for easier calls
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists( 'FOCUSWP_SLIDER_SHORTCODES' ) ){
	class FOCUSWP_SLIDER_SHORTCODES{
		/*
		 * For easier overriding we declared the keys
		 * here as well as our tabs array which is populated
		 * when registering settings
		 */
		private $post_type 	= 'post';
		private $limit 		= 5;

		public function __construct() {
			add_action( 'init', array($this, 'register_shortcode') );
			add_action( 'focuswp_slide_head', array($this, 'slide_head'), 10 );
			add_action( 'focuswp_slide_content', array($this, 'slide_image'), 8 );
			add_action( 'focuswp_slide_content', array($this, 'slide_content'), 10 );
			add_action( 'focuswp_content_meta', array($this, 'slide_meta'), 10 );

			add_action( 'focuswp_widget_display', array($this, 'widget_display'), 1, 10 );

			//add class when featured image available
			add_filter( 'focuswp_item_classes', array($this, 'item_classes'), 1, 10 );
		}

		function register_shortcode(){
			add_shortcode( 'focus-slides', array($this, 'display_shortcode') );
		}

		function display_shortcode( $atts, $content = null ){
			$sc_atts = apply_filters( 'focuswp_shortcode_atts-default', array(
				'title'				=> '',
				'origin'			=> '',
				'type'				=> 'default',
				'autoplay'			=> 'false',
				'pager'				=> 'false',
				'speed'				=> 400,
				'timeout'			=> 5000,
				'posts_per_page'   	=> $this->limit,
				'offset'           	=> 0,
				'category'         	=> '',
				'tag__in'         	=> '',
				'tag'         		=> '',
				'category_name'    	=> '',
				'orderby'          	=> 'date',
				'order'            	=> 'DESC',
				'include'          	=> '',
				'exclude'          	=> '',
				'meta_key'         	=> '',
				'meta_value'       	=> '',
				'post_type'        	=> $this->post_type,
				'post_mime_type'   	=> '',
				'post_parent'      	=> '',
				'author'           	=> '',
				'author_name'	   	=> '',
				'post_status'      	=> 'publish',
				'tax_query' 		=> '',
				'meta_query' 		=> '',
				'suppress_filters' 	=> true
			) );

			$args = shortcode_atts( $sc_atts , $atts );

			//initialize and remove atts that are invalid on get_posts
			$title 		= $args['title'];
			$origin 	= $args['origin'];
			$type 		= $args['type'];
			$autoplay 	= $args['autoplay'];
			$pager 		= $args['pager'];
			$speed 		= $args['speed'];
			$timeout 	= $args['timeout'];
			$args_init 	= $args;
			$args 		= apply_filters( 'focuswp_shortcode_atts', $args );

			unset( $args['title'] );
			unset( $args['origin'] );
			unset( $args['type'] );
			unset( $args['autoplay'] );
			unset( $args['speed'] );
			unset( $args['timeout'] );

			//prevent query issue by removing empty atts
			if( empty( $args['tax_query'] ) ){
				unset( $args['tax_query'] );
			}
			if( empty( $args['meta_query'] ) ){
				unset( $args['meta_query'] );
			}

			$items 	= get_posts( $args );

			$uniqid = time() .'-'. uniqid(true);
			$classes = apply_filters( 'focuswp_classes', array( 'focuswp-slider', 'focuswp-'. $type, 'focuswp-'. $uniqid ) );

			do_action( 'focuswp_init', array( 'Class' => $this, 'type' => $type, 'items' => $items  ) );

			ob_start();
			if( $items ){ ?>
				<div class="<?php echo implode( ' ' , $classes ); ?>" >
					<?php do_action( 'focuswp_before', $uniqid, $args_init ); ?>
					<div class="focuswp-slides" data-autoplay="<?php echo $autoplay;?>" data-pager="<?php echo $pager;?>" data-speed="<?php echo $speed;?>" data-timeout="<?php echo $timeout;?>">
					<?php foreach ( $items as $item ) {
						$params = array( 'type' => $type, 'origin' => $origin, 'title' => $title, 'item' => $item, 'this' => $this );
						$item__classes = apply_filters( 'focuswp_item_classes', array( 'focuswp-slide' ), $params );
						do_action( 'focuswp_before_slide', $params ); ?>
						<div class="<?php echo implode( ' ' , $item__classes ); ?>">
							<?php do_action( 'focuswp_before_inner', $params ); ?>
							<div class="focuswp-inner">
								<?php do_action( 'focuswp_slide_head', $params ); ?>
								<div class="focuswp-content">
									<?php do_action( 'focuswp_slide_content', $params ); ?>
								</div><!-- end focuswp-content -->
								<?php do_action( 'focuswp_slide_footer', $params ); ?>
							</div>
							<?php do_action( 'focuswp_after_inner', $params ); ?>
						</div>
						<?php do_action( 'focuswp_after_slide', $params ); ?>
					<?php }
					wp_reset_postdata(); //just in case it affects postdata; reset em ?>
					<?php do_action( 'focuswp_after', $uniqid, $args_init ); ?>
					</div>
					<div class="focuswp-clear"></div>
				</div>
			<?php
			}
			$output = ob_get_clean();

			return $output;
		}

		function slide_head( $array ){ ?>
			<div class="focuswp-head">
				<div class="focuswp-headleft">
					<span><?php echo ( isset( $array['title'] ) ) ? $array['title'] : '';?></span>
				</div>
				<div class="focuswp-headright">
					<button class="focuswp-arrow focuswp-icon fsprev"><?php _e( 'Prev', 'focuswp' );?></button><button class="focuswp-arrow focuswp-icon fsnext"><?php _e( 'Next', 'focuswp' );?></button>
				</div>
			</div><!-- end head -->
		<?php }

		function slide_content( $array ){
			$item  = $array['item'];
			$title = '<h3 class="focuswp-title"><a href="'. get_permalink( $item ) .'">'. $item->post_title .'</a></h3>';
			?>
			<header>
				<?php echo apply_filters( 'focuswp_content_title',  $title, $item );?>
				<?php do_action( 'focuswp_content_meta', $item ); ?>
			</header>
			<div class="focuswp-entry">
				<?php echo $excerpt = ( empty( $item->post_excerpt ) ) ? $this->wp_trim_excerpt( $item->post_content ) : $item->post_excerpt; ?>

				<?php if( !empty( $excerpt ) ){ ?>
					<span class="focuswp-more"><a href="<?php echo get_permalink( $item );?>"><?php echo apply_filters( 'focuswp_more_text', __( 'Read more', 'focuswp' ), $array ) ?></a></span>
				<?php } ?>
			</div>
		<?php }

		function slide_meta( $item ){
			$name = get_the_author_meta( 'display_name', $item->post_author );
			if( empty( $name ) ) return false;
			?>
			<div class="focuswp-meta">
				<span class="focuswp-author"><a href="<?php echo get_author_posts_url( $item->post_author ); ?>" rel="author" title="<?php _e( 'Posts by', 'focuswp' );?> <?php echo $name;?>" ><?php echo $name; ?></a></span>
			</div>
		<?php }

		function slide_image( $array ){
			if( isset( $array['type'] ) && 'featured--on' == $array['type'] ){
				if( has_post_thumbnail( $array['item'] ) ){
					$item__thumb = apply_filters( 'focuswp_thumb_size', array( 600,600 ), $array );
					echo '<a href="'. get_permalink( $array['item'] ) .'" />';
						echo get_the_post_thumbnail( $array['item'], $item__thumb );
					echo '</a>';
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		function item_classes( $classes, $params ){
			if( has_post_thumbnail( $params['item'] ) ){
				$classes[] = 'focuswp-with--featured';
			}

			return $classes;
		}

		function wp_trim_excerpt($text = '') {
			$raw_text 	= $text;
			$text 		= strip_shortcodes( $text );
			$text 		= apply_filters( 'the_content', $text );
			$text 		= str_replace(']]>', ']]>', $text);
			$length 	= apply_filters( 'focuswp_excerpt_length', 55 );
			$text 		= wp_trim_words( $text, $length, '...' );

			return apply_filters( 'focuswp_trim_excerpt', $text, $raw_text );
		}

		//widget display Shortcodes
		function widget_display( $instance, $args ){
			// print_r( $instance );
			$instance = apply_filters( 'focuswp_widget_instance', $instance, $args );
			$instance['title'] = ( isset( $instance['label'] ) ) ? strip_tags( $instance['label'] ) : '';
			if( isset( $instance['label'] ) ){
				unset( $instance['label'] );
			}
			if( !isset($instance['origin']) ){
				$instance['origin'] = '';
			}
			$shortcode = '[focus-slides ';

			foreach ( $instance as $key => $value) {
				if( in_array( $key, array( 'categories', 'tags', 'uniqid', 'active' ) ) ){
					switch ( $key ) {
						case 'categories':
							if( !empty( $value ) ){
								$categories = unserialize( $value );
								if( isset( $categories['-1'] ) ){
									$category = '';
								}else{
									$category = implode( ',', array_keys( $categories ) );
								}
							}else{
								$category = '';
							}
							$shortcode .= ' category="'. $category .'"';
							break;

						case 'tags':
							if( !empty( $value ) ){
								$tag = str_replace( ', ', ',', $value );
								$tag = str_replace( ' ,', ',', $tag );
								$tag = str_replace( ' ', '-', $tag );
								$shortcode .= ' tag="'. $tag .'"';
							}
							break;

						default:
							# code...
							break;
					}
				}else{
					$shortcode .= ' '. $key .'="'. $value .'"';
				}
			}

			$shortcode .= ' ]';

			switch ( $instance['origin'] ) {
				case 'widget':
					echo do_shortcode( $shortcode );
					break;

				case 'media-frame':
					echo $shortcode;
					break;

				default:
					# code...
					break;
			}
		}
	}
	new FOCUSWP_SLIDER_SHORTCODES();
}
?>
