<?php
/*
 * Essential actions
 * since 1.0
 */

function imperion_do_home_slider(){
	if((is_front_page() || is_home()) ) {
		get_template_part('templates/top', 'slider' );
	}

}
add_action('imperion_home_slider', 'imperion_do_home_slider');

function imperion_do_before_header(){
	get_template_part( 'templates/top', 'notice' ); 
}

add_action('imperion_before_header', 'imperion_do_before_header');


function imperion_do_header(){

		get_template_part( 'templates/contact', 'section' );
		
		do_action('imperion_before_header');
		
		$imperion_header = get_theme_mod('header_layout', 2);
		
		if ($imperion_header == 0) {
			do_action('business_architect_default_header');
			//woocommerce layout
		} else if($imperion_header == 1 && class_exists('WooCommerce')){
			do_action('business_architect_store_header');
			//list layout
		} else if ($imperion_header == 2){
			imperion_burger_header() ;
		} else {
			//default layout			
			do_action('business_architect_default_header');
		}
		
		if(is_front_page()){
			get_template_part( 'templates/top', 'shortcode' );
		}
		


}

add_action('imperion_header', 'imperion_do_header');



/**
 * Theme Breadcrumbs
*/
if( !function_exists('imperion_page_header_breadcrumbs') ):
	function imperion_page_header_breadcrumbs() { 	
		global $post;
		$homeLink = esc_url(home_url());
		$imperion_page_header_layout = get_theme_mod('imperion_page_header_layout', 'imperion_page_header_layout1');
		if($imperion_page_header_layout == 'imperion_page_header_layout1'):
			$breadcrumb_class = 'center-text';	
		else: $breadcrumb_class = 'text-right'; 
		endif;
		
		echo '<ul id="content" class="page-breadcrumb '.esc_attr( $breadcrumb_class ).'">';			
			if (is_home() || is_front_page()) :
					echo '<li><a href="'.esc_url($homeLink).'">'.esc_html__('Home','imperion').'</a></li>';
					    echo '<li class="active">'; echo single_post_title(); echo '</li>';
						else:
						echo '<li><a href="'.esc_url($homeLink).'">'.esc_html__('Home','imperion').'</a></li>';
						if ( is_category() ) {
							echo '<li class="active"><a href="'. esc_url( imperion_page_url() ) .'">' . esc_html__('Archive by category','imperion').' "' . single_cat_title('', false) . '"</a></li>';
						} elseif ( is_day() ) {
							echo '<li class="active"><a href="'. esc_url(get_year_link(esc_attr(get_the_time('Y')))) . '">'. esc_html(get_the_time('Y')) .'</a>';
							echo '<li class="active"><a href="'. esc_url(get_month_link(esc_attr(get_the_time('Y')),esc_attr(get_the_time('m')))) .'">'. esc_html(get_the_time('F')) .'</a>';
							echo '<li class="active"><a href="'. esc_url( imperion_page_url() ) .'">'. esc_html(get_the_time('d')) .'</a></li>';
						} elseif ( is_month() ) {
							echo '<li class="active"><a href="' . esc_url( get_year_link(esc_attr(get_the_time('Y'))) ) . '">' . esc_html(get_the_time('Y')) . '</a>';
							echo '<li class="active"><a href="'. esc_url( imperion_page_url() ) .'">'. esc_html(get_the_time('F')) .'</a></li>';
						} elseif ( is_year() ) {
							echo '<li class="active"><a href="'. esc_url( imperion_page_url() ) .'">'. esc_html(get_the_time('Y')) .'</a></li>';
                        } elseif ( is_single() && !is_attachment() && is_page('single-product') ) {
						if ( get_post_type() != 'post' ) {
							$cat = get_the_category(); 
							$cat = $cat[0];
							echo '<li>';
								echo esc_html( get_category_parents($cat, TRUE, '') );
							echo '</li>';
							echo '<li class="active"><a href="' . esc_url( imperion_page_url() ) . '">'. wp_title( '',false ) .'</a></li>';
						} }  
						elseif ( is_page() && $post->post_parent ) {
							$parent_id  = $post->post_parent;
							$breadcrumbs = array();
							while ($parent_id) {
							$page = get_page($parent_id);
							$breadcrumbs[] = '<li class="active"><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html( get_the_title($page->ID)) . '</a>';
							$parent_id  = $page->post_parent;
                            }
							$breadcrumbs = array_reverse($breadcrumbs);
							foreach ($breadcrumbs as $crumb) echo $crumb;
							echo '<li class="active"><a href="' .  esc_url( imperion_page_url()) . '">'. esc_html( get_the_title() ).'</a></li>';
                        }
						elseif( is_search() )
						{
							echo '<li class="active"><a href="' . esc_url( imperion_page_url() ) . '">'. get_search_query() .'</a></li>';
						}
						elseif( is_404() )
						{
							echo '<li class="active"><a href="' . esc_url( imperion_page_url() ) . '">'.esc_html__('Error 404','imperion').'</a></li>';
						}
						else { 
						    echo '<li class="active"><a href="' . esc_url( imperion_page_url() ) . '">'. esc_html( get_the_title() ) .'</a></li>';
						}
					endif;
			echo '</ul>';
        }
endif;


/**
 * Theme Breadcrumbs Url
*/
function imperion_page_url() {
	global $wp;
	$current_url = esc_url(home_url(add_query_arg(array(), $wp->request)));
	
	return $current_url;
}


/*************
 *  Widgets  *
 ************/

/**
 * Registers the new widget to add it to the available widgets
 * @since 1.0.0
 */
function imperion_Search_register_widget() {
	register_widget( 'imperion_Search_Widget' );
}
add_action( 'widgets_init', 'imperion_Search_register_widget' );


/*
 * Post Widget
 */
class imperion_Post_Widget extends WP_Widget {

	/**
	 * Setup the widget options
	 * @since 1.0
	 */
	public function __construct() {
	
		// set widget options
		$options = array(
			'classname'   => 'imperion_Post_Widget', // CSS class name
			'description' => esc_html__( 'Pro- Post Widget.', 'imperion' ),
		);
		
		// instantiate the widget
		parent::__construct( 'imperion_Post_Widget', esc_html__( 'Pro- Post Widget', 'imperion' ), $options );
	}
	
	

	public function widget( $args, $instance ) {
	
		$category = ( ! empty( $instance['category'] ) ) ? strip_tags( $instance['category'] ) : 0;
		$colums = (!empty($instance['colums'])) ? strip_tags($instance['colums']) : "col-md-3 col-sm-3 col-lg-3 col-xs-12";
		
		// get the widget configuration
		$title = "";
		if(isset($instance['title'])) $title = $instance['title'];
		
				
		if ( $title ) {
			echo  "<h2 class='page-title center-text'>".wp_kses_post($title)."</h2>";
		}

		?>
	  <section id="" class="post-widget-content text-center">
		  <div class="row">
			<?php
			$max_items = 20;
			$args =  array(  'post_type' => 'post', 'ignore_sticky_posts' => 1 , 'cat' =>  $category , 'posts_per_page' =>  absint($max_items), 'numberposts' => absint($max_items) , 'orderby' => 'date', 'order' => 'DESC' );

			$page_query = new WP_Query($args);?>
			  <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
				<div class="<?php echo esc_attr($colums) ;?>">
				  <div class="center-text post">
					<?php the_post_thumbnail(); ?>				  
					<h2 class="widget-title"><a href="<?php the_permalink();?>"><?php the_title();?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2>
					<p class="mt-3"><?php $excerpt = wp_trim_words( get_the_excerpt(), 20 ) ; echo wp_kses_post($excerpt); ?></p>
				  	<span><a class="call-to-action" href="<?php the_permalink();?>"><?php esc_html_e('Read More', 'imperion'); ?></a></span>
				  </div>
				</div>
			  <?php endwhile;
			  wp_reset_postdata();
			  ?>
		  </div>
	  </section>
		<?php
		
	}
	

	public function update( $new_instance, $old_instance ) {
	
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title']) : "" ;
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category']) : 0 ;
		$instance['colums'] = ( ! empty( $new_instance['colums'] ) ) ? strip_tags( $new_instance['colums'] ): "" ;
		
		return $instance;
	}
	

	public function form( $instance ) {
	
		$category = ( ! empty( $instance['category'] ) ) ? strip_tags( $instance['category'] ) : 0;
		$title = ( ! empty( $instance['title'] ) ) ? strip_tags( $instance['title'] ) : '';
		$colums = (!empty($instance['colums'])) ? strip_tags($instance['colums']) : "col-md-3 col-sm-3 col-lg-3 col-xs-12";
		

		$args = array( 'orderby' => 'name', 'exclude' => '', 'include' => '', 'parent' => 0 );
		$categories = get_categories( $args );
		$category_code = '';
			if(0==$category){
				$category_code = $category_code.'<option value="0" Selected=selected>'.__( '-Select Category-','imperion').'</option>';
			} else{
				$category_code = $category_code.'<option value="0">'.__( '-Select Category-','imperion').'</option>';
			}
			foreach ( $categories as $cat ) {
				$selected ='';
				if(($cat->term_id)==$category){
					$selected ='Selected=selected';
				}
			$category_code = $category_code.'<option value="'.$cat->term_id.'" '.$selected.' >'.$cat->name.'</option>';
		}
		
		//
		$bootstrap_colums = array(
			"col-md-12 col-sm-12 col-lg-12 col-xs-12" => 1,
			"col-md-6 col-sm-6 col-lg-6 col-xs-12" => 2,
			"col-md-4 col-sm-4 col-lg-4 col-xs-12" => 3,
			"col-md-3 col-sm-3 col-lg-3 col-xs-12" => 4,
			"col-md-2 col-sm-2 col-lg-2 col-xs-12" => 6,
		);	
		

		?>
				
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'imperion' ) ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( isset( $instance['title'] ) ? $instance['title'] : '' ); ?>" />
		</p>
		
		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'category' )); ?>"><?php esc_html_e( 'Select the News category:','imperion'  ); ?></label> 
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category' )); ?>" type="text">
		<?php echo wp_kses_post($category_code); ?>
		</select>
		</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('colums')); ?>"><?php esc_html_e('Number of colums:', 'imperion'); ?></label> 
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('colums')); ?>" name="<?php echo esc_attr( $this->get_field_name('colums')); ?>" type="text">
		<?php
		foreach ($bootstrap_colums as $key => $value) {
				if ($key == $colums) {
						echo '<option value="' . esc_attr($key) . '" Selected = selected >' . esc_html( $value) . '</option>';
				}
				else {
						echo '<option value="' . esc_attr($key) . '" >' . esc_html($value) . '</option>';
				}
		}
		?>
		</select>
		</p>

		
		<?php
	}
	
} 


/**
 * Registers the new widget to add it to the available widgets
 * @since 1.0.0
 */
function imperion_Post_register_widget() {
	register_widget( 'imperion_Post_Widget' );
}
add_action( 'widgets_init', 'imperion_Post_register_widget' );



/* search widgets */
class imperion_Search_Widget extends WP_Widget {

	/**
	 * Setup the widget options
	 * @since 1.0
	 */
	public function __construct() {
	
		// set widget options
		$options = array(
			'classname'   => 'imperion_Search_Widget', // CSS class name
			'description' => esc_html__( 'WooCommerce Search [With Categories]', 'imperion' ),
		);
		
		// instantiate the widget
		parent::__construct( 'imperion_Search_Widget', esc_html__( 'Pro- WooCommerce Search Widget', 'imperion' ), $options );
	}
	
	

	public function widget( $args, $instance ) {
		
		// get the widget configuration
		$title = "";
		if(isset($instance['title'])) $title = $instance['title'];
				
		if ( $title ) {
			echo wp_kses_post($args['before_title']) . wp_kses_post($title) . wp_kses_post($args['after_title']);
		}

		?>
		<div class="row">
		<div class="col-sm-12">
			<div class="woo-search">
			  <?php if ( class_exists( 'WooCommerce' ) ) { ?>
			  <div class="header-search-form">
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				  <select class="header-search-select" name="product_cat">
					<option value="">
					<?php esc_html_e( 'Categories', 'imperion' ); ?>
					</option>
					<?php
									/*
									 * @package envo-ecommerce
									 * @subpackage consultus
									 */
									$args = array(
										'taxonomy'     => 'product_cat',
										'orderby'      => 'date',
										'order'      	=> 'ASC',
										'show_count'   => 1,
										'pad_counts'   => 0,
										'hierarchical' => 1,
										'title_li'     => '',
										'hide_empty'   => 1,
									);
									$categories = get_categories( $args);
									foreach ( $categories as $category ) {
										$option = '<option value="' . esc_attr( $category->category_nicename ) . '">';
										$option .= esc_html( $category->cat_name );
										$option .= ' (' . absint( $category->category_count ) . ')';
										$option .= '</option>';
										echo wp_kses_post($option); 
									}
									?>
				  </select>
				  <input type="hidden" name="post_type" value="product" />
				  <input class="header-search-input" name="s" type="text" placeholder="<?php esc_attr_e( 'Search products...', 'imperion' ); ?>"/>
				  <button class="header-search-button" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
				</form>
			  </div>
			  <?php } ?>
			</div>
			</div>
		</div>
		<?php
		
	}
	


	public function update( $new_instance, $old_instance ) {
	
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
	}
	

	public function form( $instance ) {
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'imperion' ) ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( isset( $instance['title'] ) ? $instance['title'] : '' ); ?>" />
		</p>
		
		<?php
	}
	
} 




function imperion_burger_header(){
?>


<!-- WooCommerce Menu -->
<div class="container header-main-menu">
<div class="row">

<div id="woocommerce-layout-menu">
  <?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) ) : ?>
  <div id="toggle-container">
    <button id="menu-toggle" class="menu-toggle">
    <?php esc_html_e( 'Menu', 'imperion' ); ?>
    </button>
  </div>
  <div id="site-header-menu" class="site-header-menu">
    <?php if ( has_nav_menu( 'primary' ) ) : ?>
    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'imperion' ); ?>">
      <?php
						if(is_home() ||  is_front_page()) { 
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'menu_class' => 'primary-menu',
							)
						);
						} else {
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'menu_class' => 'primary-menu',
								'items_wrap' 		=> 	business_architect_nav_wrap(),
							)
						);
						
						}
					?>
    </nav>
    <!-- .main-navigation -->
    <?php endif; ?>
  </div>
  <!-- .site-header-menu -->
  <?php endif; ?>
</div>
<!--end outer div -->

</div>
</div>


<?php
}



function imperion_branding(){

if (get_theme_mod('header_layout', 2) == 2) {

	?>
	
	<div id="site-header-main" class="site-header-main">
	  <!--start header-->
	  <div class="container header-full-width">
		<div class="row vertical-center">
		  <div class="col-sm-12 header-layout-2">
			<div class="site-branding">
			  <?php business_architect_the_custom_logo(); ?>
			  <div class="site-info-container">
				<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				  <?php bloginfo( 'name' ); ?>
				  </a></h1>
				<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				  <?php bloginfo( 'name' ); ?>
				  </a></p>
				<?php
				endif;
	
				$business_architect_description = get_bloginfo( 'description', 'display' );
				if ( $business_architect_description || is_customize_preview() ) :
					?>
				<p class="site-description"><?php echo esc_html($business_architect_description); ?></p>
				<?php endif; ?>
			  </div>
			</div>
			<!-- .site-branding -->
		  </div>
		</div>
		<!--end .column-->
	  </div>
	  <!--end .container-->
	</div>
	<!-- end header -->
	</div>
	
	<?php 
	}
}