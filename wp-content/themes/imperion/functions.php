<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/*
 * BEGIN ENQUEUE PARENT ACTION
 * AUTO GENERATED - Do not modify or remove comment markers above or below:
 */
 
if ( ! function_exists( 'business_architect_default_settings' ) ) :

function business_architect_default_settings($param){
	$values = array (	 'background_color'=> '#fff', 
						 'page_background_color'=> '#fff', 
						 'woocommerce_menubar_color'=> 'rgba(0,0,0,0)', 
						 'woocommerce_menubar_text_color'=> '#333333', 
						 'link_color'=>  '#0568bf',
						 'main_text_color' => '#1a1a1a', 
						 'primary_color'=> '#2271b1',
						 'header_bg_color'=> '#fff',
						 'header_text_color'=> '#333333',
						 'footer_bg_color'=> '#065291',
						 'footer_text_color'=> '#ffffff',
						 'header_contact_social_bg_color'=> '#46474878',
						 'footer_border' =>'1',
						 'hero_border' =>'1',
						 'header_layout' =>'2',
						 'heading_font' => 'Google Sans', 
						 'body_font' => 'Google Sans',
						 'slider_in_home_page' => false,
						 'pre_loader_style' => 1,
						 'pre_loader_enabled' => false					 
					 );
					 
	return $values[$param];
}

endif;

 
if ( !function_exists( 'imperion_locale_css' ) ):
    function imperion_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'imperion_locale_css' );

if ( !function_exists( 'imperion_parent_css' ) ):
    function imperion_parent_css() {
        wp_enqueue_style( 'imperion_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bootstrap','fontawesome' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'imperion_parent_css', 10 );


if ( class_exists( 'WP_Customize_Control' ) ) {

	require get_template_directory() .'/inc/color-picker/alpha-color-picker.php';
}


function imperion_wp_body_open(){
	do_action( 'wp_body_open' );
}

if ( ! function_exists( 'imperion_the_custom_logo' ) ) :
	/**
	 * Displays the optional custom logo.
	 */
	function imperion_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
endif;

/**
 * @since 1.0.0
 * add home link.
 */
function imperion_nav_wrap() {
  $wrap  = '<ul id="%1$s" class="%2$s">';
  $wrap .= '<li class="hidden-xs"><a href="/"><i class="fa fa-home"></i></a></li>';
  $wrap .= '%3$s';
  $wrap .= '</ul>';
  return $wrap;
}


require get_stylesheet_directory() .'/inc/main.php';

/* 
 * add customizer settings 
 */
add_action( 'customize_register', 'imperion_customize_register' );  
function imperion_customize_register( $wp_customize ) {


	// banner image
	$wp_customize->add_setting( 'banner_image' , 
		array(
			'default' 		=> '',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'banner_image' ,
		array(
			'label'          => __( 'Banner Image', 'imperion' ),
			'description'	=> __('Upload banner image', 'imperion'),
			'settings'  => 'banner_image',
			'section'        => 'theme_header',
		))
	);
	
	$wp_customize->add_setting('banner_link' , array(
		'default'    => '#',
		'sanitize_callback' => 'esc_url_raw',
	));
	
	
	$wp_customize->add_control('banner_link' , array(
		'label' => __('Banner Link', 'imperion' ),
		'section' => 'theme_header',
		'type'=> 'url',
	) );
	

	//breadcrumb 

	$wp_customize->add_section( 'breadcrumb_section' , array(
		'title'      => __( 'Header Breadcrumb', 'imperion' ),
		'priority'   => 3,
		'panel' => 'theme_options',
	) );


	$wp_customize->add_setting( 'breadcrumb_enable' , array(
		'default'    => false,
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'business_architect_sanitize_checkbox',
	));

	$wp_customize->add_control('breadcrumb_enable' , array(
		'label' => __('Enable | Disable Breadcrumb','imperion' ),
		'section' => 'breadcrumb_section',
		'type'=> 'checkbox',
	));		
	
	// loader
	$wp_customize->add_section( 'pre_loader' , array(
		'description' => __( 'Add a preloader', 'imperion' ),
		'title'      => __( 'Preloader', 'imperion' ),
		'priority'   => 2,
		'panel' => 'theme_options',
	) );
	
	$wp_customize->add_setting( 'pre_loader_enabled' , array(
		'default'    => false,
		'sanitize_callback' => 'business_architect_sanitize_checkbox',
	));

	$wp_customize->add_control('pre_loader_enabled' , array(
		'label' => __('Enable | Disable Preloader [If prealoader not stopping due to js errors, Disable Preloader.]', 'imperion' ),
		'section' => 'pre_loader',
		'type'=> 'checkbox',
	));		
			
	
}



/**
 * @package twentysixteen
 * @subpackage consultus
 * Converts a HEX value to RGB.
 */
function imperion_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
	} elseif ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
	);
}




function imperion_add_preloader() {

	if (get_theme_mod('pre_loader_enabled' , false)){
		echo '<div class="preloader-wrap"><div class="sk-chase">
					  <div class="sk-chase-dot"></div>
					  <div class="sk-chase-dot"></div>
					  <div class="sk-chase-dot"></div>
					  <div class="sk-chase-dot"></div>
					  <div class="sk-chase-dot"></div>
					  <div class="sk-chase-dot"></div>
					</div></div>';
	}

}


add_action( 'wp_body_open', 'imperion_add_preloader' );


function imperion_custom_header_setup() {
    $args = array(
        'default-image'      => get_stylesheet_directory_uri() . '/images/header.jpg',
        'default-text-color' => '#fff',
        'width'              => 1200,
        'height'             => 800,
        'flex-width'         => true,
        'flex-height'        => true,
    );
    add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'imperion_custom_header_setup' );

function business_health_admin_css_add_style() {  



wp_enqueue_style('admin-css-style', get_bloginfo('stylesheet_directory').'/css/admin.css');



}



add_action('admin_enqueue_scripts', 'business_health_admin_css_add_style');